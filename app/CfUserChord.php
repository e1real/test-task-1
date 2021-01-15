<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $chord_id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property CfChord $cfChord
 * @property User $user
 */
class CfUserChord extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cf_user_chord';

    /**
     * @var array
     */
    protected $fillable = ['chord_id', 'user_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cfChord()
    {
        return $this->belongsTo(CfChords::class, 'chord_id', 'chord_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
