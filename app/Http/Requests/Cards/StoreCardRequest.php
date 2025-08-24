<?php

namespace App\Http\Requests\Cards;

use App\Models\BoardList;
use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $listId = $this->input('list_id');
        $list = BoardList::query()->find($listId);
        return $list && $list->board->user_id === auth()->id();
    }


    public function rules(): array
    {
        return [
            'list_id' => ['required', 'exists:lists,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
        ];
    }
}
