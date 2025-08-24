@extends('layouts.app')

@section('title', $board->name)

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">{{ $board->name }}</h1>

    <div class="flex space-x-4 overflow-x-auto" id="lists-container">
        @foreach($board->boardLists as $list)
            <div class="w-80 bg-gray-100 rounded p-2 flex-shrink-0 list" data-list-id="{{ $list->id }}">
                <h2 class="font-semibold mb-2">{{ $list->name }}</h2>

                <div class="space-y-2" id="cards-{{ $list->id }}">
                    @foreach($list->cards as $card)
                        <div class="bg-white p-2 rounded shadow card" data-card-id="{{ $card->id }}">
                            <h3 class="font-medium">{{ $card->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $card->description }}</p>
                        </div>
                    @endforeach
                </div>

                <button class="mt-2 w-full bg-blue-600 text-white rounded px-2 py-1 add-card" data-list-id="{{ $list->id }}">+ Add Card</button>
            </div>
        @endforeach

        <div class="w-80 flex-shrink-0">
            <button id="add-list" class="w-full bg-green-600 text-white rounded px-2 py-1">+ Add List</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Initialize sortable for lists
    const listContainers = document.querySelectorAll('.list');
    listContainers.forEach(list => {
        new Sortable(list.querySelector('#cards-' + list.dataset.listId), {
            group: 'shared-cards',
            animation: 150,
            onEnd: function (evt) {
                const cardId = evt.item.dataset.cardId;
                const listId = evt.to.closest('.list').dataset.listId;
                const position = Array.from(evt.to.children).indexOf(evt.item);

                fetch(`/cards/${cardId}/move`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({board_list_id: listId, position: position})
                });
            }
        });
    });

    // Add Card
    document.querySelectorAll('.add-card').forEach(button => {
        button.addEventListener('click', () => {
            const listId = button.dataset.listId;
            const title = prompt('Card title');
            if (!title) return;

            fetch('/cards', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({board_list_id: listId, title: title})
            })
            .then(res => res.json())
            .then(card => {
                const container = document.getElementById('cards-' + listId);
                const div = document.createElement('div');
                div.className = 'bg-white p-2 rounded shadow card';
                div.dataset.cardId = card.id;
                div.innerHTML = `<h3 class="font-medium">${card.title}</h3>`;
                container.appendChild(div);
            });
        });
    });

    // Add List
    document.getElementById('add-list').addEventListener('click', () => {
        const name = prompt('List name');
        if (!name) return;

        fetch('/lists', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({board_id: '{{ $board->id }}', name: name})
        })
        .then(res => res.json())
        .then(list => {
            location.reload(); // simple: reload to see new list
        });
    });

});
</script>
@endpush