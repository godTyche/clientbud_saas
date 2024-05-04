<?php

namespace App\Models\SuperAdmin;

use App\Models\Company;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\MollieInvoice
 *
 * @property int $id
 * @property int $company_id
 * @property int $package_id
 * @property string|null $transaction_id
 * @property string|null $amount
 * @property string|null $package_type
 * @property \Illuminate\Support\Carbon|null $pay_date
 * @property \Illuminate\Support\Carbon|null $next_pay_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company $company
 * @property-read \App\Models\SuperAdmin\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice whereNextPayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice wherePackageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MollieInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MollieInvoice extends BaseModel
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
