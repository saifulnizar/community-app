<div>
    <form wire:submit.prevent="save">
        @error('content') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        <flux:input type="text" wire:model="title" placeholder="Judul" class=" w-full mb-2" />
        <flux:textarea wire:model="content" placeholder="Isi Post" class=" w-full mb-2"></flux:textarea>
        
         <div class="mb-4">
            <label class="block font-medium">Tags</label>
            <div class="flex items-center gap-2">
                

                <flux:select wire:model="selectedTagToAdd" @change="Livewire.dispatch('addTagFromSelect')">
                    @foreach ($allTags as $tag)
                        <flux:select.option value="{{ $tag['name'] }}">{{ $tag['name'] }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:button type="button" wire:click="$set('showTagModal', true)" class="px-2 py-1 bg-blue-500 text-white rounded">
                    +
                </flux:button>
            </div>
            @error('selectedTags') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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




        <flux:button type="submit" class="bg-blue-500 text-white px-4 py-2">Buat Post</flux:button>
    </form>

    @if ($showTagModal)
        <flux:modal wire:model="showTagModal" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="md">Tambah Tag Baru</flux:heading>
                </div>

                <flux:input type="text" wire:model="newTagName" class="w-full p-2 rounded" placeholder="Nama tag" />
                @error('newTagName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <div class="flex justify-end gap-2">
                    <flux:spacer />

                    <flux:button wire:click="$set('showTagModal', false)" class="px-4 py-2 border rounded">Batal</flux:button>
                    <flux:button wire:click="createTag" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</flux:button>
                </div>
            </div>
        </flux:modal>


    @endif
</div>

