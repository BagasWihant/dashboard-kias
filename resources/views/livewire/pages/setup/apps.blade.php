<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    public $apps = [];
    public $name = '';
    public $url = '';
    public $status = '';
    public $editingId = null;
    public function mount()
    {
        $this->loadApps();
    }

    public function loadApps()
    {
        $this->apps = \App\Models\Application::all();
    }

    public function save()
    {
        $data = [
            'name' => $this->name,
            'url' => $this->url,
            'status' => $this->status,
        ];

        if ($this->editingId) {
            \App\Models\Application::findOrFail($this->editingId)->update($data);
        } else {
            \App\Models\Application::create($data);
        }

        $this->resetFields();
        $this->loadApps();
    }

    public function edit($id)
    {
        $apps = \App\Models\Application::findOrFail($id);
        $this->name = $apps->name;
        $this->url = $apps->url;
        $this->status = $apps->status;
        $this->editingId = $apps->id;
    }

    public function delete($id)
    {
        \App\Models\Application::findOrFail($id)->delete();
        $this->loadApps();
    }

    public function resetFields()
    {
        $this->status = '';
        $this->url = '';
        $this->name = '';
        $this->editingId = null;
    }
}; ?>

<div>

    <form wire:submit.prevent="save" class="space-y-4">
        <input wire:model="name" type="text" placeholder="Nama" class="w-full border px-2 py-1 rounded" />
        <textarea wire:model="url" placeholder="Url" class="w-full border px-2 py-1 rounded"></textarea>
        <textarea wire:model="status" placeholder="Status 1/0" class="w-full border px-2 py-1 rounded"></textarea>
        <div class="flex justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                {{ $editingId ? 'Update' : 'Create' }}
            </button>
            @if ($editingId)
                <button type="button" wire:click="resetFields" class="text-gray-500 underline">Batal</button>
            @endif
        </div>
    </form>

    <hr class="my-4" />

    <div class="space-y-2">
        @foreach ($apps as $app)
            <div class="border p-2 rounded shadow">
                <div class="font-bold">{{ $app['name'] }}</div>
                <div>{{ $app['url'] }}</div>
                <div>{{ $app['status'] }}</div>
                <div class="mt-2 text-sm text-right space-x-2">
                    <button wire:click="edit({{ $app['id'] }})" class="text-blue-500">Edit</button>
                    <button wire:click="delete({{ $app['id'] }})" class="text-red-500">Hapus</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
