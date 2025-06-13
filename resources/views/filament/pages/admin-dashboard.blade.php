<x-filament-panels::page>
	 <div class="grid grid-cols-2 gap-4">
        <x-filament::card>
            <h2 class="text-lg font-bold">Total Posts</h2>
            <p>{{ \App\Models\Post::count() }}</p>
        </x-filament::card>
        <x-filament::card>
            <h2 class="text-lg font-bold">Total Comments</h2>
            <p>{{ \App\Models\Comment::count() }}</p>
        </x-filament::card>
        <x-filament::card>
            <h2 class="text-lg font-bold">Total Users</h2>
            <p>{{ \App\Models\User::count() }}</p>
        </x-filament::card>
    </div>

</x-filament-panels::page>
