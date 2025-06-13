<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <livewire:post-create wire:key="create-post" />
        </div>

        <livewire:post-index wire:key="index-posts" />
    </div>
</x-layouts.app>
