<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PostComments extends Component
{
    public function render()
    {
        return view('livewire.post-comments');
    }
}
