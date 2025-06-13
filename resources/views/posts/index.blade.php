<x-layouts.app :title="__('Dashboard')">
    <h1 class="text-xl font-bold mb-4">Daftar Post</h1>

    @livewire('post-create')
    @livewire('post-index')
</x-layouts.app>
    