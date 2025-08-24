<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\BoardList;
use Illuminate\Http\Request;
use App\Http\Resources\ListResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\Lists\StoreBoardListRequest;
use App\Http\Requests\Lists\UpdateBoardListRequest;

class BoardListController extends Controller
{
     public function index(Request $request)
    {
        $boardLists = QueryBuilder::for(BoardList::class)
            ->allowedFilters([
                AllowedFilter::exact('board_id'),
                'name',
            ])
            ->allowedSorts(['id', 'position', 'name'])
            ->allowedIncludes(['board', 'cards'])
            ->get();

        return ListResource::collection($boardLists);
    }

    public function store(StoreBoardListRequest $request)
    {
        $validated = $request->validated();

        $board = Board::findOrFail($validated['board_id']);
       
        $position = $board->boardLists()->max('position') + 1;

        $boardList = $board->boardLists()->create([
            'name' => $validated['name'],
            'position' => $position,
        ]);

        return new ListResource($boardList);
    }

    public function update(UpdateBoardListRequest $request, BoardList $boardList)
    {
       

        $validated = $request->validated();

        $boardList->update(['name' => $validated['name']]);

        return new ListResource($boardList);
    }

    public function destroy(BoardList $list)
    {

        $list->delete();

        return response()->json(['message' => 'List deleted']);
    }
}
