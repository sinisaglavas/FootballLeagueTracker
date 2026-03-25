<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoriteTeam extends Model
{
    use SoftDeletes;

    const string TABLE = 'favorite_teams';

    protected $table = self::TABLE;

    protected $fillable = [
        'user_id',
        'favorite_team_id',
        'favorite_team_name',
        'favorite_team_crest',
        'favorite_team_country',
        'deleted_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
