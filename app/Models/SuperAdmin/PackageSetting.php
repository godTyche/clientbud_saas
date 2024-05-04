<?php

namespace App\Models\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

/**
 * App\Models\PackageSetting
 *
 * @property int $id
 * @property string $status
 * @property int|null $no_of_days
 * @property string|null $modules
 * @property string|null $trial_message
 * @property int|null $notification_before
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $all_packages
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSetting whereModules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSetting whereNoOfDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSetting whereNotificationBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSetting whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSetting whereTrialMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PackageSetting extends BaseModel
{
    use HasFactory;

    protected $appends = ['all_packages'];

    public function getAllPackagesAttribute()
    {
        return count(json_decode($this->modules, true)) >= 20;
    }

}
