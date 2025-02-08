<x-app-layout>
    @section('title', 'PLANTILLA - MERLA')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configuracion de Cuenta') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            {{-- @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')


                <x-jet-section-border />
            @endif --}}

            {{-- <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <x-jet-section-title>
                        <x-slot name="title">{{ "Contraseña" }}</x-slot>
                        <x-slot name="description">{{ "Cambia tu contraseña" }}</x-slot>
                    </x-jet-section-title>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                            {{ "Cambio de contraseña" }}
                            <div class="mt-3 max-w-xl text-sm text-gray-600">
                                <p>
                                    {{ "Para poder efectuar el cambio de contraseña es necesario que lo solicites
                                        con el departamento de tecnologias de la información de tu zona, ellos
                                        podrán cambiarte la contraseña" }}
                                </p>
                            </div>
                            <div class="mt-5">
                                <x-jet-button type="button" wire:loading.attr="disabled">
                                    <a href="http://10.19.1.2/novaNacional/">
                                    {{ __('Ir a página para cambio de contraseña') }}
                                    </a>
                                </x-jet-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-jet-section-border /> --}}

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>
                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
