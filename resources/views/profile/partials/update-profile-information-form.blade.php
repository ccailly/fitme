<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="flex flex-col gap-4" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex justify-between">
            <header>
                <h2 class="text-lg font-medium">
                    {{ __('Informations') }}
                </h2>
                <p class="mt-1 text-sm">
                    {{ __('Mettre à jour votre profil.') }}
                </p>
            </header>
            <div class="flex flex-col items-center gap-1">
                <x-avatar-input :src="$user->avatar" id="avatar" name="avatar" />
                <x-input-error class="mt-2 text-xs text-center" :messages="$errors->get('avatar')" />
            </div>
        </div>
        <div>
            <x-input-label for="name" :value="__('Nom')" class="text-base-content" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm">
                    {{ __('Enregistré') }}</p>
            @endif
        </div>
    </form>
</section>
