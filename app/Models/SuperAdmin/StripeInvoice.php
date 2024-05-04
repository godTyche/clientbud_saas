<?php

namespace App\Models\SuperAdmin;

use App\Models\Company;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\StripeInvoice
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $invoice_id
 * @property int $package_id
 * @property string|null $transaction_id
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $pay_date
 * @property \Illuminate\Support\Carbon|null $next_pay_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company $company
 * @property-read \App\Models\SuperAdmin\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice whereNextPayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StripeInvoice extends BaseModel
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

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

}
