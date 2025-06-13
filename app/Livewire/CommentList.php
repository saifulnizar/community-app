<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;

class CommentList extends Component
{
    public $postId;
    public $comments = [];

    protected $listeners = ['comment-created' => '$refresh'];

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->loadComments();
    }


    public function loadComments()
    {
        $this->comments = Comment::with('user')
            ->where('post_id', $this->postId)
            ->orderBy('created_at', 'asc')
            ->get();
    }
    
    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if ($comment->user_id === auth()->id()) {
            $comment->delete();
            $this->loadComments(); // method yang sudah ada
        }
    }

    #[\Livewire\Attributes\On('comment-created')]
    public function reloadAfterCreate()
    {
        $this->loadComments();
    }

    public function render()
    {
        return view('livewire.comment-list');
    }

}
