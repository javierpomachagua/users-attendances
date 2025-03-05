<?php

use App\Models\Survey;
use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new class extends Component {
    public string $dni = '';
    public string $score_1 = '';
    public string $score_2 = '';
    public string $score_3 = '';

    #[Locked]
    public ?User $user = null;

    #[Locked]
    public bool $surveyCompleted = false;

    public function submitDni(): void
    {
        $this->validate([
            'dni' => 'required|exists:users,dni'
        ]);

        $this->user = User::where('dni', $this->dni)->first();
    }

    public function submitScore1(): void
    {
        $this->validate([
            'score_1' => 'required|between:1,10'
        ]);
    }

    public function submitScore2(): void
    {
        $this->validate([
            'score_2' => 'required|in:si,no'
        ]);
    }

    public function submitScore3(): void
    {
        $this->validate([
            'score_3' => 'required|between:1,10'
        ]);

        $this->user->surveys()->delete();

        $this->user->surveys()->create([
            'score_1' => $this->score_1,
            'score_2' => $this->score_2,
            'score_3' => $this->score_3,
        ]);

        $this->surveyCompleted = true;
    }

    public function clear(): void
    {
        $this->reset();
    }
}; ?>

<div>
    @if($surveyCompleted)
        <h1 class="text-3xl">¡Gracias <span class="font-bold">{{ $user->name }}</span> por participar!</h1>
        <h2 class="text-3xl mt-4">Tu opinión es muy importante para nosotros.</h2>

        <flux:button type="button" variant="primary" class="w-full mt-4" wire:click="clear">
            Reiniciar encuesta
        </flux:button>
    @else
        @if(!$user)
            <form wire:submit="submitDni">
                <flux:input wire:model="dni"
                            label="DNI"
                            type="number"
                            name="dni"
                            size="base"
                            id="dni"/>

                <flux:button type="submit" variant="primary" class="w-full mt-4">
                    Ingresar
                </flux:button>

                <a wire:navigate href="{{ route('home') }}">
                    <flux:button class="w-full mt-4">
                        Ir a la lista
                    </flux:button>
                </a>
            </form>
        @else
            <h1 class="text-3xl">Hola, <span class="font-bold">{{ $user->name }}</span></h1>

            @if(empty($score_1))
                <form wire:submit="submitScore1" class="mt-20">
                    <fieldset aria-label="Choose a memory option">
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-medium text-gray-900">
                                ¿Cómo calificas la experiencia en el evento hoy?
                            </div>
                        </div>

                        <div class="my-10 grid grid-cols-3 gap-3 sm:grid-cols-6">
                            @foreach(range(1, 10) as $number)
                                <div class="inline-block">
                                    <input
                                        type="radio"
                                        wire:model="score_1"
                                        id="score1-{{ $number }}"
                                        name="score_1"
                                        value="{{ $number }}"
                                        class="sr-only peer"
                                    />
                                    <label
                                        for="score1-{{ $number }}"
                                        class="flex items-center justify-center rounded-md px-3 py-3 text-sm font-semibold uppercase cursor-pointer
             ring-inset ring-1 ring-gray-300 bg-white text-gray-900 hover:bg-gray-50
             focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2
             peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:ring-0 peer-checked:hover:bg-indigo-500">
                                        {{ $number }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>

                    <flux:button type="submit" variant="primary" class="w-full mt-4">
                        Continuar
                    </flux:button>
                </form>
            @elseif(empty($score_2))
                <form wire:submit="submitScore2" class="mt-20">
                    <fieldset aria-label="Choose a memory option">
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-medium text-gray-900">
                                ¿Consideras que el evento cumplió con tus expectativas?
                            </div>
                        </div>

                        <div class="my-10 grid grid-cols-3 gap-3 sm:grid-cols-6">
                            @foreach(["si", "no"] as $number)
                                <div class="inline-block">
                                    <input
                                        type="radio"
                                        wire:model="score_2"
                                        id="score2-{{ $number }}"
                                        name="score_2"
                                        value="{{ $number }}"
                                        class="sr-only peer"
                                    />
                                    <label
                                        for="score2-{{ $number }}"
                                        class="flex items-center justify-center rounded-md px-3 py-3 text-sm font-semibold uppercase cursor-pointer
             ring-inset ring-1 ring-gray-300 bg-white text-gray-900 hover:bg-gray-50
             focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2
             peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:ring-0 peer-checked:hover:bg-indigo-500">
                                        {{ $number }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>

                    <flux:button type="submit" variant="primary" class="w-full mt-4">
                        Continuar
                    </flux:button>
                </form>
            @elseif(empty($score_3))
                <form wire:submit="submitScore3" class="mt-20">
                    <fieldset aria-label="Choose a memory option">
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-medium text-gray-900">
                                ¿Participarías y recomendarías a otros eventos de anglo american?
                            </div>
                        </div>

                        <div class="my-10 grid grid-cols-3 gap-3 sm:grid-cols-6">
                            @foreach(range(1, 10) as $number)
                                <div class="inline-block">
                                    <input
                                        type="radio"
                                        wire:model="score_3"
                                        id="score3-{{ $number }}"
                                        name="score_3"
                                        value="{{ $number }}"
                                        class="sr-only peer"
                                    />
                                    <label
                                        for="score3-{{ $number }}"
                                        class="flex items-center justify-center rounded-md px-3 py-3 text-sm font-semibold uppercase cursor-pointer
             ring-inset ring-1 ring-gray-300 bg-white text-gray-900 hover:bg-gray-50
             focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2
             peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:ring-0 peer-checked:hover:bg-indigo-500">
                                        {{ $number }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>

                    <flux:button type="submit" variant="primary" class="w-full mt-4">
                        Continuar
                    </flux:button>
                </form>
            @endif
        @endif
    @endif
</div>

