<?php

namespace App\Models\SuperAdmin;

use App\Models\Company;
use App\Scopes\CompanyScope;
use App\Models\SuperAdmin\Package;
use App\Models\OfflinePaymentMethod;
use App\Models\BaseModel;
use App\Observers\SuperAdmin\OfflineInvoiceObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\SuperAdmin\OfflineInvoice
 *
 * @property int $id
 * @property int $company_id
 * @property int $package_id
 * @property string|null $package_type
 * @property int|null $offline_method_id
 * @property string|null $transaction_id
 * @property string $amount
 * @property \Illuminate\Support\Carbon $pay_date
 * @property \Illuminate\Support\Carbon|null $next_pay_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company $company
 * @property-read OfflinePaymentMethod|null $offlinePaymentMethod
 * @property-read \App\Models\SuperAdmin\OfflinePlanChange|null $offlinePlanChangeRequest
 * @property-read Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice whereNextPayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice whereOfflineMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice wherePackageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfflineInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OfflineInvoice extends BaseModel
{
    const FILE_PATH = 'offline-invoice';

    protected $dates = [
        'pay_date',
        'next_pay_date'
    ];

    protected $casts = [
        'pay_date' => 'datetime',
        'next_pay_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::observe(OfflineInvoiceObserver::class);

        static::addGlobalScope(new CompanyScope);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withoutGlobalScopes(['active']);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function offlinePaymentMethod()
    {
        return $this->belongsTo(OfflinePaymentMethod::class, 'offline_method_id')->whereNull('company_id');
    }

    public function offlinePlanChangeRequest()
    {
        return $this->hasOne(OfflinePlanChange::class, 'invoice_id');
    }

}
