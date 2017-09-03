<?php

namespace Modules\Album\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modules\Album\Entities\Album
 *
 * @property int $id
 * @property int $category_id
 * @property string $cover
 * @property string|null $name
 * @property int $like
 * @property int $photo_number
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Modules\Album\Entities\AlbumCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Album\Entities\AlbumPhoto[] $photos
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Album\Entities\Album onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\Album whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\Album whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\Album whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\Album whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\Album whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\Album whereLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\Album whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\Album wherePhotoNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\Album whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Album\Entities\Album withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Album\Entities\Album withoutTrashed()
 * @mixin \Eloquent
 */
class Album extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    /**
     * Get the album's cover.
     *
     * @param string $value
     * @return string
     */
    public function getCoverAttribute($value){
        return $value ? cdn($value) : null;
    }

    /**
     * Get album's category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo(AlbumCategory::class, 'category_id', 'id');
    }

    /**
     * get album's photos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos(){
        return $this->hasMany(AlbumPhoto::class, 'album_id', 'id');
    }
}
