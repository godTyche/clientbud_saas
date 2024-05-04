<?php

namespace App\Models\SuperAdmin;

use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\FaqCategory
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SuperAdmin\Faq[] $faqs
 * @property-read int|null $faqs_count
 * @method static \Illuminate\Database\Eloquent\Builder|FaqCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FaqCategory extends BaseModel
{

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_category_id', 'id');
    }

}
