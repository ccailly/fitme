<x-app-layout title="Paramètres" activeTab="1">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="flex flex-col items-center justify-center">
        <a href="{{ route('user.show', ['user_id' => $user->id]) }}" class="btn btn-accent btn-outline btn-sm mt-3">
            Voir mon profil
        </a>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mx-3 rounded-xl p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="mx-3 rounded-xl p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="mx-3 rounded-xl p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
