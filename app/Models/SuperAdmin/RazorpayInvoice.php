<?php

namespace App\Models\SuperAdmin;

use App\Models\Company;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\RazorpayInvoice
 *
 * @property int $id
 * @property int $company_id
 * @property int|null $currency_id
 * @property string $invoice_id
 * @property string $subscription_id
 * @property string|null $order_id
 * @property int $package_id
 * @property string $transaction_id
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $pay_date
 * @property \Illuminate\Support\Carbon|null $next_pay_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company $company
 * @property-read \App\Models\SuperAdmin\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice whereNextPayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RazorpayInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RazorpayInvoice extends BaseModel
{
    protected $dates = ['pay_date', 'next_pay_date'];

    protected $casts = [
        'pay_date' => 'datetime',
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
