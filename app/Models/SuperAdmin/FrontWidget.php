<?php

namespace App\Models\SuperAdmin;

use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\FrontWidget
 *
 * @property int $id
 * @property string $name
 * @property string $widget_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FrontWidget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontWidget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontWidget query()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontWidget whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontWidget whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontWidget whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontWidget whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontWidget whereWidgetCode($value)
 * @mixin \Eloquent
 */
class FrontWidget extends BaseModel
{
    protected $guarded = ['id'];
}
