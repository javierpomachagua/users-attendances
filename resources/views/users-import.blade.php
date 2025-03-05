<x-layouts.guest>
    <div class="flex-1 flex flex-col space-y-10 justify-center items-center">
        @foreach($errors as $error)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">¡Ups!</strong>
                <span class="block sm:inline">{{ $error }}</span>
            </div>
        @endforeach

        <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-sm">
            @csrf

            <flux:input
                type="file"
                label="Importar asistentes"
                name="file"
                required/>

            <flux:button
                type="submit"
                variant="primary"
                class="w-full mt-4">
                Importar
            </flux:button>
        </form>

        <form action="{{ route('users-employees.import') }}" method="POST" enctype="multipart/form-data"
              class="w-full max-w-sm">
            @csrf

            <flux:input
                type="file"
                label="Importar asistentes empleados"
                name="file"
                required/>

            <flux:button
                type="submit"
                variant="primary"
                class="w-full mt-4">
                Importar
            </flux:button>
        </form>
    </div>
</x-layouts.guest>
