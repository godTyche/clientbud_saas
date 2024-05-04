<?php

namespace App\Models\SuperAdmin;

use App\Models\Company;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\PaystackInvoice
 *
 * @property int $id
 * @property int $company_id
 * @property int $package_id
 * @property string|null $transaction_id
 * @property string|null $amount
 * @property \Illuminate\Support\Carbon $pay_date
 * @property \Illuminate\Support\Carbon|null $next_pay_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company $company
 * @property-read \App\Models\SuperAdmin\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice whereNextPayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaystackInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaystackInvoice extends BaseModel
{
    protected $dates = [
        'pay_date',
        'next_pay_date',
    ];

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
