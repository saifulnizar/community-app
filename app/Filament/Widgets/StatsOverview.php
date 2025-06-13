<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('Total Posts', Post::count())
                ->description('Semua post yang dibuat')
                ->color('primary'),

            Card::make('Total Comments', Comment::count())
                ->description('Termasuk komentar belum dimoderasi')
                ->color('success'),

            Card::make('Total Users', User::count())
                ->description('Jumlah total user terdaftar')
                ->color('warning'),
        ];
    }
}
