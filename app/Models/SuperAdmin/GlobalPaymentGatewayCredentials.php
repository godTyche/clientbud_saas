<?php

namespace App\Models\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

/**
 * App\Models\StripeSetting
 *
 * @property int $id
 * @property string|null $api_key
 * @property string|null $api_secret
 * @property string|null $webhook_key
 * @property string|null $paypal_client_id
 * @property string|null $paypal_secret
 * @property string $paypal_status
 * @property string $stripe_status
 * @property string|null $razorpay_key
 * @property string|null $razorpay_secret
 * @property string|null $razorpay_webhook_secret
 * @property string $razorpay_status
 * @property string $paypal_mode
 * @property string|null $paystack_client_id
 * @property string|null $paystack_secret
 * @property string|null $paystack_status
 * @property string|null $paystack_merchant_email
 * @property string|null $paystack_payment_url
 * @property string $mollie_api_key
 * @property string $mollie_status
 * @property string|null $authorize_api_login_id
 * @property string|null $authorize_transaction_key
 * @property string|null $authorize_signature_key
 * @property string|null $authorize_environment
 * @property string $authorize_status
 * @property string|null $payfast_key
 * @property string|null $payfast_secret
 * @property string $payfast_status
 * @property string|null $payfast_salt_passphrase
 * @property string $payfast_mode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $show_pay
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereApiSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereAuthorizeApiLoginId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereAuthorizeEnvironment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereAuthorizeSignatureKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereAuthorizeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereAuthorizeTransactionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereMollieApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereMollieStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePayfastKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePayfastMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePayfastSaltPassphrase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePayfastSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePayfastStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePaypalClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePaypalMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePaypalSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePaypalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePaystackClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePaystackMerchantEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePaystackPaymentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePaystackSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting wherePaystackStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereRazorpayKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereRazorpaySecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereRazorpayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereRazorpayWebhookSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereStripeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeSetting whereWebhookKey($value)
 * @mixin \Eloquent
 */
class GlobalPaymentGatewayCredentials extends BaseModel
{

    use HasFactory;

    protected $table = 'global_payment_gateway_credentials';

}
