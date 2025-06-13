<div class="mt-4">
    <div class="mb-4">
        <h2 class="text-lg font-semibold mb-2">Filter by Tag:</h2>
        <div class="flex flex-wrap gap-2">
            <flux:select wire:model="selectedTagToAdd" @change="Livewire.dispatch('addTagFromSelect')">
                @foreach ($tags as $tag)
                    <flux:select.option value="{{ $tag->name  }}">{{ $tag->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

         @if ($selectedTags)
        <div class="flex flex-wrap gap-2 mt-2">
            @foreach ($selectedTags as $tag)
                <span class="bg-blue px-2 py-1 rounded flex items-center gap-1">
                    {{ $tag }}
                    <button type="button" wire:click="removeTag('{{ $tag }}')" class="text-red-600">&times;</button>
                </span>
            @endforeach
        </div>
        @endif
    </div>

    <hr class="my-4">

    @forelse ($posts as $post)
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4 mb-4">
            <h2 class="text-lg font-bold">{{ $post->title }}</h2>
            <p>{{ $post->content }}</p>
            <p class="text-sm text-gray-500">By: {{ $post->user->name }}</p>

            @if (auth()->id() === $post->user_id)
                <button wire:click="deletePost('{{ $post->id }}')" class="text-red-500 text-sm">Hapus</button>
            @endif

            <div class="mt-2 text-sm text-gray-500">
                Tags:

                @forelse ($post->tags as $tag)
                    <flux:button>{{ $tag->name }}</flux:button>
                @empty
                @endforelse
            </div>

             <div class="mt-4 mb-4">
                <livewire:post-like :post="$post" :wire:key="'like-'.$post->id" />
            </div>

            <livewire:comment-list :postId="$post->id" />
            <livewire:comment-create :postId="$post->id" />
        </div>

        

    @empty
    <p>Tidak ada post.</p>
    @endforelse
</div>