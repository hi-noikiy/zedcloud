<?php

namespace Modules\Album\Entities;

use App\Scopes\CompanyScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

/**
 * Modules\Album\Entities\AlbumCategory
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $name
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Album\Entities\Album[] $albums
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Album\Entities\AlbumCategory onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumCategory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Album\Entities\AlbumCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Album\Entities\AlbumCategory withoutTrashed()
 * @mixin \Eloquent
 */
class AlbumCategory extends Model
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
     * Get category albums
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albums() {
        return $this->hasMany(Album::class, 'category_id', 'id');
    }


}
