<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Filament\Support\Colors\Color;

class AdminDashboard extends Page
{
    // protected static ?string $navigationIcon = 'heroicon-o-home';
    // protected static string $view = 'filament.pages.admin-dashboard';
    // protected static ?string $title = 'Admin Analytics';
    // protected static ?string $navigationLabel = 'Analytics';
    // protected static ?string $navigationGroup = 'Analytics';
    // protected static ?int $navigationSort = 0;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.admin-dashboard';
    protected static ?string $slug = 'dashboard';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';

    public $postCount;
    public $commentCount;
    public $userCount;

    public function mount(): void
    {
        $this->postCount = Post::count();
        $this->commentCount = Comment::count();
        $this->userCount = User::count();
    }

    public function getViewData(): array
    {
        return [
            'postCount' => Post::count(),
            'commentCount' => Comment::count(),
            'userCount' => User::count(),
        ];
    }
}
