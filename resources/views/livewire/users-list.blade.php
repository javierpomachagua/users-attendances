<?php

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

new class extends Component {
    use WithPagination;

    #[Url]
    public string $search = '';

    public function with(): array
    {
        return [
            'users' => User::query()
                ->when(!empty($this->search), fn($query) => $query->whereAny([
                    'name', 'dni'
                ], 'like', '%'.$this->search.'%'))
                ->where('is_employee', false)
                ->paginate(20),
            'countAttendedAssistantUsers' => User::query()
                ->selectSub('SUM(1 + COALESCE(invitations, 0))', 'total_users')
                ->whereNotNull('attended_at')
                ->where('is_employee', false)
                ->first()->total_users,
            'countAttendedEmployeeUsers' => User::query()
                ->selectSub('SUM(1 + COALESCE(invitations, 0))', 'total_users')
                ->whereNotNull('attended_at')
                ->where('is_employee', true)
                ->first()->total_users,
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function markUserAttendance(int $userId): void
    {
        $user = User::findOrFail($userId);

        if ($user->attended_at) {
            return;
        }

        $user->update([
            'attended_at' => now(),
        ]);

        $this->modal('confirm-user-attendance-'.$userId)->close();
    }

    public function resetUserAttendance(int $userId): void
    {
        $user = User::findOrFail($userId);

        if (!$user->attended_at) {
            return;
        }

        $user->update([
            'attended_at' => null,
        ]);
    }
}; ?>
<div class="my-10">
    <flux:input wire:model.live.debounce="search" placeholder="Buscar por nombre o DNI" clearable/>

    <div class="px-4 sm:px-6 lg:px-8 mt-6">
        <div class="flow-root">
            <div class="-mx-4 overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg">
                        <table class="min-w-full border-separate border-spacing-0">
                            <thead>
                            <tr>
                                <th scope="col"
                                    class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5 pl-4 pr-3 text-left text-base font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">
                                    Nombre
                                </th>
                                <th scope="col"
                                    class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-base font-semibold text-gray-900 backdrop-blur backdrop-filter lg:table-cell">
                                    DNI
                                </th>
                                <th scope="col"
                                    class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-base font-semibold text-gray-900 backdrop-blur backdrop-filter lg:table-cell">
                                    # de Invitados
                                </th>
                                <th scope="col"
                                    class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 px-3 py-3.5 text-left text-base font-semibold text-gray-900 backdrop-blur backdrop-filter lg:table-cell">
                                    ¿Asistió?
                                </th>
                                <th scope="col"
                                    class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5 pl-3 pr-4 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">
                                    <span class="sr-only">Attendance</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-base font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                        {{ $user->name }}
                                    </td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-base text-gray-500 sm:table-cell">
                                        {{ $user->dni }}
                                    </td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-base text-gray-500 sm:table-cell">
                                        {{ $user->invitations }}
                                    </td>
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-base text-gray-500 sm:table-cell">
                                        {{ $user->attended_at ? 'Sí' : 'No' }}
                                    </td>
                                    <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pl-3 pr-4 text-base font-medium sm:pr-8 lg:pr-8">
                                        @if(!$user->attended_at)
                                            <flux:modal.trigger
                                                wire:key="confirm-user-attendance-modal-trigger-{{ $user->id }}"
                                                name="confirm-user-attendance-{{ $user->id }}">
                                                <flux:button variant="primary">
                                                    Marcar asistencia
                                                </flux:button>
                                            </flux:modal.trigger>

                                            <flux:modal wire:key="confirm-user-attendance-modal-{{ $user->id }}"
                                                        wire:submit="markUserAttendance({{ $user->id }})"
                                                        name="confirm-user-attendance-{{ $user->id }}" focusable
                                                        class="w-72 sm:w-full sm:max-w-lg">
                                                <form class="space-y-6">
                                                    <div>
                                                        <flux:heading size="xl">
                                                            Confirmar asistencia
                                                        </flux:heading>

                                                        <flux:subheading class="text-wrap" size="lg">
                                                            ¿Desea marcar asistencia del usuario {{ $user->name }}?
                                                        </flux:subheading>
                                                    </div>

                                                    <div class="flex justify-end space-x-2">
                                                        <flux:modal.close>
                                                            <flux:button variant="filled">Cancelar</flux:button>
                                                        </flux:modal.close>

                                                        <flux:button variant="primary" type="submit">Sí
                                                        </flux:button>
                                                    </div>
                                                </form>
                                            </flux:modal>
                                        @else
                                            <flux:modal.trigger
                                                wire:key="confirm-user-reset-modal-trigger-{{ $user->id }}"
                                                name="confirm-user-reset-{{ $user->id }}">
                                                <flux:button>
                                                    Restablecer
                                                </flux:button>
                                            </flux:modal.trigger>

                                            <flux:modal wire:key="confirm-user-reset-modal-{{ $user->id }}"
                                                        wire:submit="resetUserAttendance({{ $user->id }})"
                                                        name="confirm-user-reset-{{ $user->id }}" focusable
                                                        class="w-72 sm:w-full sm:max-w-lg">
                                                <form class="space-y-6">
                                                    <div>
                                                        <flux:heading size="xl">
                                                            Confirmar restablecer
                                                        </flux:heading>

                                                        <flux:subheading class="text-wrap" size="lg">
                                                            ¿Desea restablecer al usuario {{ $user->name }}?
                                                        </flux:subheading>
                                                    </div>

                                                    <div class="flex justify-end space-x-2">
                                                        <flux:modal.close>
                                                            <flux:button variant="filled">Cancelar</flux:button>
                                                        </flux:modal.close>

                                                        <flux:button variant="primary" type="submit">Sí
                                                        </flux:button>
                                                    </div>
                                                </form>
                                            </flux:modal>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>

    <div class="flex space-x-4">
        <a wire:navigate href="{{ route('users.create') }}">
            <flux:button variant="primary" class="w-full mt-4">
                Buscar empleado
            </flux:button>
        </a>

        <a wire:navigate href="{{ route('survey') }}">
            <flux:button class="w-full mt-4">
                Encuesta
            </flux:button>
        </a>
    </div>

    <div class="mt-4">
        <p>Usuarios invitados atendidos: {{ $countAttendedAssistantUsers }}</p>
        <p class="mt-2">Usuarios empleados atendidos: {{ $countAttendedEmployeeUsers }}</p>
    </div>
</div>
