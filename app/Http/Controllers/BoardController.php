<?php

namespace App\Http\Controllers;

use App\Http\Requests\Boards\StoreBoardRequest;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BoardResource;
use Spatie\QueryBuilder\QueryBuilder;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = QueryBuilder::for(Board::class)
            ->where('user_id', Auth::id())
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['id', 'name', 'created_at'])
            ->defaultSort('-created_at')
            ->allowedIncludes(['lists', 'lists.cards'])
            ->get();

        return view('boards.index', compact('boards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoardRequest $request)
    {
        $validated = $request->validated();

        $board = Board::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return new BoardResource($board);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {


        $board = QueryBuilder::for(Board::where('id', $board->id))
            ->allowedIncludes(['lists', 'lists.cards'])
            ->firstOrFail();

        return view('boards.show', compact('board'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board)
    {
        $this->authorize('update', $board);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $board->update($validated);

        return new BoardResource($board);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        $this->authorize('delete', $board);

        $board->delete();

        return response()->json(['message' => 'Board deleted']);
    }
}
