<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\BoardList;
use Illuminate\Http\Request;
use App\Http\Resources\CardResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\Cards\MoveCardRequest;
use App\Http\Requests\Cards\StoreCardRequest;
use App\Http\Requests\Cards\UpdateCardRequest;

class CardController extends Controller
{

    public function index(Request $request)
    {
        $cards = QueryBuilder::for(Card::class)
            ->allowedFilters([
                'title',
                AllowedFilter::exact('board_list_id')
            ])
            ->allowedSorts(['id', 'position', 'due_date'])
            ->allowedIncludes(['boardList', 'boardList.board'])
            ->get();

        return CardResource::collection($cards);
    }

    public function store(StoreCardRequest $request)
    {
        $validated = $request->validated();

        $list = BoardList::findOrFail($validated['list_id']);

        $position = $list->cards()->max('position') + 1;

        $card = $list->cards()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'position' => $position,
        ]);

        return new CardResource($card);
    }

    public function update(UpdateCardRequest $request, Card $card)
    {

        $validated = $request->validated();

        $card->update($validated);

        return new CardResource($card);
    }

    public function destroy(Card $card)
    {
        $card->delete();

        return response()->json(['message' => 'Card deleted']);
    }

    public function move(MoveCardRequest $request, Card $card)
    {

        $validated = $request->validated();

        $card->update([
            'list_id' => $validated['list_id'],
            'position' => $validated['position'],
        ]);

        return new CardResource($card);
    }
}
