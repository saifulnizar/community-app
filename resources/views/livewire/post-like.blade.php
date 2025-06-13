<div>
    <flux:button wire:click="toggleLike"
        class="px-3 py-1 rounded {{ $liked ? 'bg-red-500 text-white' : 'bg-gray-200' }}">
        👍 {{ $likeCount }}
    </flux:button>
</div>
