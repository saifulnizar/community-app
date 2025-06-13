<div class="space-y-4">
    @forelse ($comments as $comment)
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-3 mb-2">
            <strong>{{ $comment->user->name }}</strong>
            <p>{{ $comment->content }}</p>
            <small>{{ $comment->created_at->diffForHumans() }}</small>

            @if (auth()->id() === $comment->user_id)
                <button wire:click="deleteComment('{{ $comment->id }}')" class="text-red-500 text-xs">Hapus</button>
            @endif
        </div>
    @empty
        <p>No comments yet.</p>
    @endforelse
</div>
