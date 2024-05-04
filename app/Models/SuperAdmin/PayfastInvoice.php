<?php

namespace App\Models\SuperAdmin;

use App\Models\Company;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\PayfastInvoice
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $package_id
 * @property string|null $m_payment_id
 * @property string|null $pf_payment_id
 * @property string|null $payfast_plan
 * @property string|null $amount
 * @property \Illuminate\Support\Carbon|null $pay_date
 * @property \Illuminate\Support\Carbon|null $next_pay_date
 * @property string|null $signature
 * @property string|null $token
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company|null $company
 * @property-read \App\Models\SuperAdmin\Package|null $package
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice whereMPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice whereNextPayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice wherePayfastPlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice wherePfPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayfastInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PayfastInvoice extends BaseModel
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
