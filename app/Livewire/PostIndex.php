<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class PostIndex extends Component
{

    public $posts;
    public array $selectedTags = [];
    public string $selectedTagToAdd= '';

    public function mount()
    {
        $this->loadPosts();
    }

    #[On('post-created')]
    public function reloadAfterCreate()
    {
        $this->loadPosts();
    }

    #[On('addTagFromSelect')]
    public function addTagFromSelect()
    {
        if ($this->selectedTagToAdd && !in_array($this->selectedTagToAdd, $this->selectedTags)) {
            $this->selectedTags[] = $this->selectedTagToAdd;
        }

        $this->selectedTagToAdd = '';
        $this->loadPosts();
    }

    public function removeTag($tag)
    {
        $this->selectedTags = array_filter($this->selectedTags, fn($t) => $t !== $tag);
        $this->loadPosts();

    }

    public function deletePost($postId)
    {
        $post = Post::findOrFail($postId);

        if ($post->user_id === Auth::id()) {
            $post->delete();
            $this->loadPosts();
        }
    }


    public function loadPosts()
    {
        $query = Post::with(['user', 'tags'])
            ->where('is_approved', true)
            ->latest();

        
        if (count($this->selectedTags) > 0) {
            $query->whereHas('tags', function ($q) {
                $q->whereIn('name', $this->selectedTags);
            });
        }


        $this->posts = $query->get();
    }

    public function filterByTag($tagId)
    {
        $this->selectedTag = $tagId;
        $this->loadPosts();
    }

    public function clearTagFilter()
    {
        $this->selectedTag = null;
        $this->loadPosts();
    }

    public function render()
    {
        return view('livewire.post-index', [
            'tags' => Tag::all()
        ]);
    }

}
