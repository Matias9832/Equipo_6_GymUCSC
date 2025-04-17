<x-app-layout>
    
    <x-slot name="sidebar">
        <h3 class="font-semibold text-lg mb-4">Panel de control</h3>
        <ul>
            <li class="mb-2">
                <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">
                    Ver Tabla de Usuarios
                </a>
            </li>
            <!-- Aquí puedes agregar más opciones en el futuro -->
        </ul>
    </x-slot>

    <div class="p-6 text-gray-900">
        {{ __("Bienvenido al panel de control de mantenedores.") }}
    </div>
</x-app-layout>