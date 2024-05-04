<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\AccountBaseController;
use App\Models\Company;
use App\Models\SuperAdmin\GlobalInvoice;
use App\Models\SuperAdmin\GlobalPaymentGatewayCredentials;
use App\Models\SuperAdmin\GlobalSubscription;
use App\Models\SuperAdmin\Package;
use App\Models\SuperAdmin\PaypalInvoice;
use App\Models\SuperAdmin\StripeSetting;
use App\Models\SuperAdmin\Subscription;
use App\Traits\SuperAdmin\StripeSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Common\PayPalModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Notification;

/** All Paypal Details class **/

use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\SuperAdmin\CompanyUpdatedPlan;

class SuperAdminPaypalController extends AccountBaseController
{
    //phpcs:ignore
    private $_api_context;
    use StripeSettings;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $credential = GlobalPaymentGatewayCredentials::first();

        if ($credential->paypal_mode == 'sandbox') {

            $paypalClientId = $credential->sandbox_paypal_client_id;
            $PaypalSecret = $credential->sandbox_paypal_secret;

        } else {
            $paypalClientId = $credential->paypal_client_id;
            $PaypalSecret = $credential->paypal_secret;

        }

        /** setup PayPal api context **/
        config(['paypal.settings.mode' => $credential->paypal_mode]);
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypalClientId, $PaypalSecret));
        $this->_api_context->setConfig($paypal_conf['settings']);
        $this->pageTitle = 'modules.paymentSetting.paypal';
    }

    /**
     * Show the application paywith paypalpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function payWithPaypal()
    {
        return view('paywithpaypal', $this->data);
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentWithpaypal(Request $request, $invoiceId, $type)
    {
        $package = Package::where('id', $invoiceId)->first();

        if($type == 'annual'){
            $totalAmount = $package->annual_price;
            $frequency = 'year';
            $cycle = 0;
        }
        else{
            $totalAmount = $package->monthly_price;
            $frequency = 'month';
            $cycle = 0;
        }

        $this->companyName = company()->company_name;

        $plan = new Plan();
        $plan->setName('#'.$package->name)
            ->setDescription('Payment for package '.$package->name)
            ->setType('INFINITE');

        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Payment for package '.$package->name)
            ->setType('REGULAR')
            ->setFrequency(strtoupper($frequency))
            ->setFrequencyInterval(1)
            ->setCycles($cycle)
            ->setAmount(new Currency(array('value' => $totalAmount, 'currency' => $package->currency->currency_code)));

        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(route('billing.paypal-recurring').'?success=true&invoice_id='.$invoiceId)
            ->setCancelUrl(route('billing.paypal-recurring').'?success=false&invoice_id='.$invoiceId)
            ->setAutoBillAmount('yes')
            ->setInitialFailAmountAction('CONTINUE')
            ->setMaxFailAttempts('0');

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        try {
            $output = $plan->create($this->_api_context);

        } catch (\Exception $ex) {

            if (\Config::get('app.debug')) {
                \Session::put('error', $ex->getMessage());
                return Redirect::route('billing.upgrade_plan');

            }
            else {

                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('billing.upgrade_plan');

            }

        }

        try {
            $patch = new Patch();
            $value = new PayPalModel('{
               "state":"ACTIVE"
             }');
            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);

            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);
            $output->update($patchRequest, $this->_api_context);
            $newPlan = Plan::get($output->getId(), $this->_api_context);

        } catch (\Exception $ex) {

            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::route('billing.upgrade_plan');

            }
            else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('billing.upgrade_plan');

            }

        }

        $company = Company::findOrFail(company()->id);

        // Calculating next billing date
        $today = now()->addDay(); // Payment will deduct after 1 day

        $startingDate = $today->toIso8601String();


        $agreement = new Agreement();
        $agreement->setName($package->name)
            ->setDescription('Payment for package # '.$package->name)
            ->setStartDate($startingDate);

        $plan1 = new Plan();
        $plan1->setId($newPlan->getId());
        $agreement->setPlan($plan1);

        // Add Payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        // Create Agreement
        try {
            // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
            $agreement = $agreement->create($this->_api_context);
            $approvalUrl = $agreement->getApprovalLink();

        } catch (\Exception $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::route('billing.upgrade_plan');

            }
            else {

                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('billing.upgrade_plan');
            }

        }
        /** Add payment ID to session **/
        Session::put('paypal_payment_id', $newPlan->getId());

        $paypalSubscription = new GlobalSubscription();

        $paypalSubscription->company_id = company()->id;
        $paypalSubscription->package_id = $package->id;
        $paypalSubscription->package_type = $type;
        $paypalSubscription->gateway_name = 'paypal';
        $paypalSubscription->subscription_status = 'active';
        $paypalSubscription->subscribed_on_date = now()->format('Y-m-d H:i:s');
        $paypalSubscription->currency_id = $package->currency_id;
        $paypalSubscription->save();

        $paypalInvoice = new GlobalInvoice();
        $paypalInvoice->company_id = company()->id;
        $paypalInvoice->package_id = $package->id;
        $paypalInvoice->currency_id = $package->currency_id;
        $paypalInvoice->package_type = $paypalSubscription->package_type;
        $paypalInvoice->total = $totalAmount;
        $paypalInvoice->status = 'pending';
        $paypalInvoice->plan_id = $newPlan->getId();
        $paypalInvoice->billing_frequency = $frequency;
        $paypalInvoice->billing_interval = 1;
        $paypalInvoice->global_subscription_id = $paypalSubscription->id;
        $paypalInvoice->save();

        if(isset($approvalUrl)) {
            /** redirect to paypal **/
            return Redirect::away($approvalUrl);
        }

        \Session::put('error', 'Unknown error occurred');
        return Redirect::route('billing.upgrade_plan');

    }

    public function getPaymentStatus(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        $invoice_id = Session::get('invoice_id');
        $clientPayment = PaypalInvoice::where('plan_id', $payment_id)->first();
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');

        if (empty($request->PayerID) || empty($request->token)) {
            \Session::put('error', 'Payment failed');
            return redirect(route('billing.upgrade_plan'));
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary **/
        /** to execute a PayPal account payment. **/
        /** The payer_id is added to the request query parameters **/
        /** when the user is redirected from paypal back to your site **/
        $execution = new PaymentExecution();
        $execution->setPayerId(request()->get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {

            /** it's all right **/
            /** Here Write your database logic like that insert record or value in database if you want **/
            $clientPayment->paid_on = now();
            $clientPayment->status = 'paid';
            $clientPayment->save();

            Session::put('success', 'Payment success');
            return Redirect::route('billing.index');
        }

        Session::put('error', 'Payment failed');

        return Redirect::route('billing.upgrade_plan');
    }

    public function payWithPaypalRecurrring(Request $requestObject)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        $clientPayment = GlobalInvoice::where('plan_id', $payment_id)->first();
        $company = company();
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');

        if($requestObject->get('success') == true && $requestObject->has('token') && $requestObject->get('success') != 'false' )
        {
            $token = $requestObject->get('token');
            $agreement = new Agreement();

            try {
                // Execute Agreement
                // Execute the agreement by passing in the token
                $agreement->execute($token, $this->_api_context);


                if($agreement->getState() == 'Active' || $agreement->getState() == 'Pending') {

                    $this->cancelSubscription();
                    // Calculating next billing date
                    $today = now();


                    $clientPayment->transaction_id = $agreement->getId();

                    if($agreement->getState() == 'Active') {
                        $clientPayment->status = 'paid';
                    }

                    $clientPayment->pay_date = now();
                    $clientPayment->gateway_name = 'paypal';
                    $clientPayment->save();

                    $company->package_id = $clientPayment->package_id;
                    $company->package_type = ($clientPayment->billing_frequency == 'year') ? 'annual' : 'monthly';
                    $company->status = 'active';// Set company status active
                    $company->licence_expire_on = null;
                    $company->save();

                    if( $company->package_type == 'monthly') {
                        $today = $today->addMonth();

                    } else {
                        $today = $today->addYear();
                    }

                    $clientPayment->next_pay_date = $today->format('Y-m-d');
                    $clientPayment->save();

                    // Send superadmin notification
                    $generatedBy = User::whereNull('company_id')->get();
                    Notification::send($generatedBy, new CompanyUpdatedPlan($company, $clientPayment->package_id));

                    \Session::put('success', __('superadmin.paymentSuccessfullyDone', ['package' => company()->package->name, 'planType' => company()->package_type]));
                    return Redirect::route('billing.index');

                }

                \Session::put('error', 'Payment failed');

                return Redirect::route('billing.upgrade_plan');

            } catch (PayPalConnectionException $ex) {
                $errCode = $ex->getCode();
                $errData = json_decode($ex->getData());

                if ($errCode == 400 && $errData->name == 'INVALID_CURRENCY'){
                    \Session::put('error', $errData->message);
                    return Redirect::route('billing.upgrade_plan');

                }
                elseif (\Config::get('app.debug')) {
                    \Session::put('error', 'Connection timeout');
                    return Redirect::route('billing.upgrade_plan');

                }
                else {
                    \Session::put('error', 'Some error occur, sorry for inconvenient '.$errData->message);
                    return Redirect::route('billing.upgrade_plan');

                }
            }


        }
        else if($requestObject->get('fail') == true || $requestObject->get('success') == 'false')
        {
            \Session::put('error', 'Payment failed');
            return Redirect::route('billing.upgrade_plan');

        }else {
            abort(403);

        }

    }

    public function cancelAgreement()
    {
        $paypalInvoice = PaypalInvoice::whereNotNull('transaction_id')->whereNull('end_on')
            ->where('id', company()->id)->first();

        $agreementId = $paypalInvoice->transaction_id;
        $agreement = new Agreement();

        $agreement->setId($agreementId);
        $agreementStateDescriptor = new AgreementStateDescriptor();
        $agreementStateDescriptor->setNote('Cancel the agreement');

        try {
            $agreement->cancel($agreementStateDescriptor, $this->_apiContext);
            $cancelAgreementDetails = Agreement::get($agreement->getId(), $this->_apiContext);

            // Set subscription end date
            $paypalInvoice->end_on = Carbon::parse($cancelAgreementDetails->agreement_details->final_payment_date)->format('Y-m-d H:i:s');
            $paypalInvoice->save();

        } catch (\Exception $ex) {
            info($ex->getMessage());
        }

    }

    public function cancelSubscription()
    {
        $company = company();
        $stripe = DB::table('stripe_invoices')
            ->join('packages', 'packages.id', 'stripe_invoices.package_id')
            ->selectRaw('stripe_invoices.id , "Stripe" as method, stripe_invoices.pay_date as paid_on ,stripe_invoices.next_pay_date')
            ->whereNotNull('stripe_invoices.pay_date')
            ->where('stripe_invoices.company_id', company()->id);

        $allInvoices = DB::table('paypal_invoices')
            ->join('packages', 'packages.id', 'paypal_invoices.package_id')
            ->selectRaw('paypal_invoices.id, "Paypal" as method, paypal_invoices.paid_on,paypal_invoices.next_pay_date')
            ->where('paypal_invoices.status', 'paid')
            ->whereNull('paypal_invoices.end_on')
            ->where('paypal_invoices.company_id', company()->id)
            ->union($stripe)
            ->get();

        $firstInvoice = $allInvoices->sortByDesc(function ($temp, $key) {
            return Carbon::parse($temp->paid_on)->getTimestamp();
        })->first();

        if(!is_null($firstInvoice) && $firstInvoice->method == 'Paypal'){
            $credential = StripeSetting::first();
            config(['paypal.settings.mode' => $credential->paypal_mode]);
            $paypal_conf = Config::get('paypal');
            $api_context = new ApiContext(new OAuthTokenCredential($credential->paypal_client_id, $credential->paypal_secret));
            $api_context->setConfig($paypal_conf['settings']);

            $paypalInvoice = PaypalInvoice::whereNotNull('transaction_id')->whereNull('end_on')
                ->where('company_id', company()->id)->where('status', 'paid')->first();

            if($paypalInvoice){
                $agreementId = $paypalInvoice->transaction_id;
                $agreement = new Agreement();

                $agreement->setId($agreementId);
                $agreementStateDescriptor = new AgreementStateDescriptor();
                $agreementStateDescriptor->setNote('Cancel the agreement');

                try {
                    $agreement->cancel($agreementStateDescriptor, $api_context);
                    $cancelAgreementDetails = Agreement::get($agreement->getId(), $api_context);

                    // Set subscription end date
                    $paypalInvoice->end_on = Carbon::parse($cancelAgreementDetails->agreement_details->final_payment_date)->format('Y-m-d H:i:s');
                    $paypalInvoice->save();

                    $company->licence_expire_on = $paypalInvoice->end_on;
                    $company->save();

                } catch (\Exception $ex) {
                     \Session::put('error', 'Some error occur, sorry for inconvenient '.$ex->getMessage());
                }

            }

        }elseif(!is_null($firstInvoice) && $firstInvoice->method == 'Stripe'){
            $this->setStripConfigs();
            $subscription = Subscription::where('company_id', company()->id)->whereNull('ends_at')->first();

            if($subscription){

                try {
                    $company->subscription('primary')->cancel();

                    $company->licence_expire_on = $subscription->ends_at;
                    $company->save();

                } catch (\Exception $ex) {
                    \Session::put('error', 'Some error occur, sorry for inconvenient '.$ex->getMessage());
                }

            }

        }

    }

}
