<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $chord_id
 * @property string $title
 * @property string $author
 * @property string $chords
 * @property boolean $is_original
 * @property string $created_at
 * @property string $updated_at
 * @property CfUserChord[] $cfUserChords
 */
class CfChords extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'chord_id';

    /**
     * @var array
     */
    protected $fillable = ['title', 'author', 'chords', 'is_original', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cfUserChords()
    {
        return $this->hasMany(CfUserChord::class, 'chord_id', 'chord_id');
    }
}
