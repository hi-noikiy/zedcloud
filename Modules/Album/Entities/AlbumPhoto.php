<?php

namespace Modules\Album\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modules\Album\Entities\AlbumPhoto
 *
 * @property int $id
 * @property int $album_id
 * @property string|null $url
 * @property int $like
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumPhoto whereAlbumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumPhoto whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumPhoto whereLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumPhoto whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Album\Entities\AlbumPhoto whereUrl($value)
 * @mixin \Eloquent
 */
class AlbumPhoto extends Model
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
     * Get photo's album
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function album() {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }
}
