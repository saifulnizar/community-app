<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentCreate extends Component
{
    public $postId;
    public $content;

    protected $rules = [
        'content' => 'required|string|max:1000',
    ];

    public function save()
    {
        $this->validate();

        Comment::create([
            'post_id' => $this->postId,
            'user_id' => Auth::id(),
            'content' => $this->content,
            'is_approved' => true,
        ]);

        $this->reset('content');
        $this->dispatch('comment-created');
    }

    public function render()
    {
        return view('livewire.comment-create');
    }
}
