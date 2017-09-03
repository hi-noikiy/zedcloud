<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modules\Product\Entities\ProductPhoto
 *
 * @property int $id
 * @property int $product_id
 * @property string $url
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Modules\Product\Entities\Product $product
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Product\Entities\ProductPhoto onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductPhoto whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductPhoto whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductPhoto whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductPhoto whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Product\Entities\ProductPhoto withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Product\Entities\ProductPhoto withoutTrashed()
 * @mixin \Eloquent
 */
class ProductPhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    /**
     * Get the photo's url.
     *
     * @param string $value
     * @return string
     */
    public function getUrlAttribute($value){
        return $value ? cdn($value) : null;
    }

    /**
     * Get photo's product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
