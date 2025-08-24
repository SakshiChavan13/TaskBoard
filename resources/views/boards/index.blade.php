@extends('layouts.app')

@section('title', 'My Boards')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">My Boards</h1>

    <div class="grid grid-cols-3 gap-4">
        @foreach($boards as $board)
            <a href="{{ route('boards.show', $board->id) }}" class="p-4 bg-white rounded shadow hover:bg-gray-50">
                <h2 class="font-semibold text-lg">{{ $board->name }}</h2>
                <p class="text-sm text-gray-500">{{ $board->description }}</p>
            </a>
        @endforeach
    </div>

    <button id="create-board" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Create New Board</button>
</div>

@include('boards.partials.modal-create-board')
@endsection

@push('scripts')
<script>
document.getElementById('create-board').addEventListener('click', () => {
    document.getElementById('board-modal').classList.remove('hidden');
});
</script>
@endpush
