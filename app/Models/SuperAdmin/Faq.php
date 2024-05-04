<?php

namespace App\Models\SuperAdmin;

use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\Faq
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $faq_category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SuperAdmin\FaqCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SuperAdmin\FaqFile[] $files
 * @property-read int|null $files_count
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|Faq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq query()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereFaqCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereImage($value)
 */
class Faq extends BaseModel
{

    public $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return ($this->image) ? asset_url('faq-files/' .$this->id.'/'. $this->image) : asset('saas/img/svg/mock-2.svg');
    }

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }

    public function files()
    {
        return $this->hasMany(FaqFile::class, 'faq_id');
    }

}
