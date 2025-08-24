<?php

namespace App\Http\Requests\Cards;

use App\Models\BoardList;
use Illuminate\Foundation\Http\FormRequest;

class MoveCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        
        $card = $this->route('card');
        $toListId = $this->input('to_list_id');
        $toList = BoardList::find($toListId);
        return $card
            && $card->list->board->user_id === auth()->id()
            && $toList
            && $toList->board->user_id === auth()->id();
    }


    public function rules(): array
    {
        return [
            'to_list_id' => ['required', 'exists:lists,id'],
            'to_position' => ['required', 'integer', 'min:0'],
        ];
    }
}
