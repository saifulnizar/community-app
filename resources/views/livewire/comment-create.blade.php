<div>
   <form wire:submit.prevent="save" class="space-y-3">
    <flux:input wire:model.defer="content" class="w-full border rounded p-2" placeholder="Write your comment..."></flux:input>
    <flux:button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Comment</flux:button>
</form>
</div>
