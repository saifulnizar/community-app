<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class PostCreate extends Component
{
    public string $title = '';
    public string $content = '';
    public array $selectedTags = [];
    public array $tagNames = [];
    public $allTags = []; 
    public string $newTag = '';
    public bool $showTagModal = false;
    public string $newTagName = '';
    public string $selectedTagToAdd= '';

    public function mount()
    {
        $this->loadTags();
    }



    public function loadTags()
    {
        $this->allTags = Tag::all()->map(fn($tag) => ['name' => $tag->name])->toArray();
    }

    public function addTag()
    {
        $tag = trim($this->newTag);

        if ($tag && !in_array($tag, $this->selectedTags)) {
            $this->selectedTags[] = $tag;
        }

        $this->newTag = '';
    }

    #[On('addTagFromSelect')]
    public function addTagFromSelect()
    {
        if ($this->selectedTagToAdd && !in_array($this->selectedTagToAdd, $this->selectedTags)) {
            $this->selectedTags[] = $this->selectedTagToAdd;
        }

        $this->selectedTagToAdd = '';
    }


    public function removeTag($tag)
    {
         $this->selectedTags = array_filter($this->selectedTags, fn($t) => $t !== $tag);
    }

    public function createTag()
    {
        $this->validate([
            'newTagName' => 'required|string|max:50|unique:tags,name',
        ]);

        Tag::create(['name' => $this->newTagName]);

        $this->loadTags();

        $this->selectedTags[] = $this->newTagName;
        $this->reset('newTagName', 'showTagModal');
    }


    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'selectedTags' => 'array',
        ]);

        $post = Post::create([
            'id' => Str::uuid(),
            'user_id' => Auth::id(),
            'title' => $this->title,
            'content' => $this->content,
            'is_approved' => false, // bisa diubah jadi true jika moderasi tidak digunakan
        ]);


        $tagIds = [];
        foreach ($this->selectedTags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }
        $post->tags()->sync($tagIds);

        
        $this->reset(['content', 'selectedTags', 'newTag']);

        $this->dispatch('post-created');
         $this->loadTags();
    }

    public function render()
    {
        return view('livewire.post-create', [
            'tags' => Tag::all(),
        ]);
    }
}
