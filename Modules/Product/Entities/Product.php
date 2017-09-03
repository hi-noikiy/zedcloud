<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modules\Product\Entities\Product
 *
 * @property int $id
 * @property int $category_id
 * @property int $sale_type
 * @property string $cover
 * @property string|null $name
 * @property int $sales_volume
 * @property int $price
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Modules\Product\Entities\ProductCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Product\Entities\ProductPhoto[] $photos
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Product\Entities\Product onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\Product whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\Product whereSaleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\Product whereSalesVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Product\Entities\Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Product\Entities\Product withoutTrashed()
 * @mixin \Eloquent
 */
class Product extends Model
{
    use SoftDeletes;

    const SALE_TYPE_ACTIVITY = 1;

    protected $fillable = [];

    /**
     * Product sale type config
     *
     * @return array
     */
    public function saleTypes(){
        return [
            self::SALE_TYPE_ACTIVITY => 'activity',
        ];
    }

    /**
     * Product sale type text
     *
     * @return mixed|string
     */
    public function saleTypeText(){
        $params = $this->saleTypes();
        return isset($params[$this->sale_type]) ? $params[$this->sale_type] : '';
    }

    /**
     * Get the product's cover.
     *
     * @param string $value
     * @return string
     */
    public function getCoverAttribute($value){
        return $value ? cdn($value) : null;
    }

    /**
     * Get product's category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    /**
     * get product's photos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos(){
        return $this->hasMany(ProductPhoto::class, 'product_id', 'id');
    }
}
