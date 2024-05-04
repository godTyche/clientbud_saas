<?php

namespace App\Models\SuperAdmin;

use App\Models\Company;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\AuthorizeInvoice
 *
 * @property int $id
 * @property int $company_id
 * @property int $package_id
 * @property string|null $transaction_id
 * @property string|null $amount
 * @property \Illuminate\Support\Carbon|null $pay_date
 * @property \Illuminate\Support\Carbon|null $next_pay_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company $company
 * @property-read \App\Models\SuperAdmin\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice whereNextPayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizeInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuthorizeInvoice extends BaseModel
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
