<?php

use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

new class extends Component {
    public string $dni = '';
    public string $invitations = '';

    #[Locked]
    public ?User $user = null;

    public function updatedDni(): void
    {
        $this->user = User::query()
            ->where('dni', $this->dni)
            ->where('is_employee', true)
            ->first();

        if (!$this->user) {
            $this->reset(['user']);
        }
    }

    public function createAssistant(): void
    {
        $this->validate([
            'dni' => 'required|exists:users,dni',
            'invitations' => 'required|numeric',
        ]);

        $this->user->update([
            'invitations' => $this->invitations,
        ]);

        $this->dispatch('assistant-created', message: '¡Asistente creado correctamente!');
        $this->reset();
    }
}; ?>


<div>
    <h1 class="text-2xl">Nuevo Asistente</h1>

    <x-action-message class="me-3 text-indigo-700 text-lg" on="assistant-created">
        Guardado correctamente.
    </x-action-message>

    <form wire:submit="createAssistant" class="my-10">
        <div>
            <flux:input wire:model.live.debounce="dni"
                        label="DNI"
                        type="number"
                        name="dni"
                        size="base"
                        id="dni"
                        mask="99999999"/>
        </div>

        <div class="mt-4">
            <flux:input value="{{ $user->name ?? '' }}"
                        label="Nombre"
                        type="text"
                        name="name"
                        size="base"
                        id="name"
                        disabled/>
        </div>

        <div class="mt-4">
            <flux:input wire:model="invitations"
                        label="Invitaciones"
                        type="number"
                        name="invitations"
                        size="base"
                        id="invitations"/>
        </div>

        <flux:button type="submit" variant="primary" class="w-full mt-4">
            Ingresar
        </flux:button>

        <a wire:navigate href="{{ route('home') }}">
            <flux:button variant="ghost" class="w-full mt-4">
                Regresar
            </flux:button>
        </a>
    </form>
</div>
