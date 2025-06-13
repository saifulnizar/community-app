<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Post;
use App\Models\PostLike as Post_Like;
use Illuminate\Support\Facades\Auth;

class PostLike extends Component
{

    public Post $post;
    public bool $liked = false;
    public int $likeCount = 0;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->liked = Auth::check() && $post->isLikedBy(Auth::user());
        $this->likeCount = $post->likes()->count();
    }

    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($this->liked) {
            Post_Like::where('post_id', $this->post->id)
                ->where('user_id', $user->id)
                ->delete();

            $this->liked = false;
        } else {
            Post_Like::create([
                'post_id' => $this->post->id,
                'user_id' => $user->id,
            ]);

            $this->liked = true;
        }

        $this->likeCount = $this->post->likes()->count();
    }

    public function render()
    {
        return view('livewire.post-like');
    }
    
}
