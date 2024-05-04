<?php

namespace App\Models\SuperAdmin;

use App\Models\Company;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\PaypalInvoice
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $currency_id
 * @property int|null $package_id
 * @property float|null $sub_total
 * @property float|null $total
 * @property string|null $transaction_id
 * @property string|null $remarks
 * @property string|null $billing_frequency
 * @property int|null $billing_interval
 * @property \Illuminate\Support\Carbon|null $pay_date
 * @property \Illuminate\Support\Carbon|null $next_pay_date
 * @property string|null $recurring
 * @property string|null $status
 * @property string|null $plan_id
 * @property string|null $event_id
 * @property string|null $end_on
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company|null $company
 * @property-read \App\Models\SuperAdmin\Package|null $package
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereBillingFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereBillingInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereEndOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereNextPayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice wherePaidOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereRecurring($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $paid_on
 */
class PaypalInvoice extends BaseModel
{
    protected $dates = ['paid_on', 'next_pay_date'];

    protected $casts = [
        'paid_on' => 'datetime',
        'next_pay_date' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function currency()
    {
        return $this->belongsTo(GlobalCurrency::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

}
