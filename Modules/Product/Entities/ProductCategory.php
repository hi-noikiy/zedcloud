<?php

namespace Modules\Product\Entities;

use App\Scopes\CompanyScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

/**
 * Modules\Product\Entities\ProductCategory
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $name
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Product\Entities\Product[] $studios
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Product\Entities\ProductCategory onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductCategory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Product\Entities\ProductCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Product\Entities\ProductCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Product\Entities\ProductCategory withoutTrashed()
 * @mixin \Eloquent
 */
class ProductCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::addGlobalScope(new CompanyScopes());
    }

    /**
     * AlbumCategory constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $user             = Auth::user();
        $this->company_id = isset($user) ? $user->company_id : 0;
    }

    /**
     * Get category product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studios() {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
