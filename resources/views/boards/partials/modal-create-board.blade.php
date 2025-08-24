<div id="board-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded p-6 w-96">
        <h2 class="text-lg font-semibold mb-4">Create New Board</h2>
        <form id="create-board-form">
            @csrf
            <input type="text" name="name" placeholder="Board Name" class="w-full border p-2 rounded mb-4" required>
            <textarea name="description" placeholder="Description" class="w-full border p-2 rounded mb-4"></textarea>
            <div class="flex justify-end space-x-2">
                <button type="button" id="close-modal" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('close-modal').addEventListener('click', () => {
    document.getElementById('board-modal').classList.add('hidden');
});

document.getElementById('create-board-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const data = {
        name: form.name.value,
        description: form.description.value,
    };

    fetch('/boards', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(board => {
        location.reload(); // simple: reload to show new board
    });
});
</script>
@endpush
