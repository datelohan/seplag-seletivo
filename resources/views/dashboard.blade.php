<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">Bem-vindo ao SEPLAG!</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Este é o painel de controle da API SEPLAG. Aqui você pode gerenciar os servidores efetivos e suas informações.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 