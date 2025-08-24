<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'list_id',
        'title',
        'description',
        'position',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function boardList(): BelongsTo
    {
        return $this->belongsTo(BoardList::class, 'board_list_id');
    }
}
