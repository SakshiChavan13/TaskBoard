<?php

namespace App\Http\Requests\Lists;

use App\Models\Board;
use Illuminate\Foundation\Http\FormRequest;

class StoreBoardListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize(): bool
    {
        $boardId = $this->input('board_id');
        $board = Board::query()->find($boardId);
        return $board && $board->user_id === auth()->id();
    }


    public function rules(): array
    {
        return [
            'board_id' => ['required', 'exists:boards,id'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
