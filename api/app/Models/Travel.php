<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Travel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'travels';

    protected $fillable = [
        'id_user',
        'method',
        'destination',
        'start_date',
        'end_date',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
