<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('storage/logo.png') }}" class="block h-16 w-auto fill-current text-gray-600">
            </a>
        </x-slot>

        <div class="mb-4 text-2xl font-semibold text-gray-600">
            Reset Password
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('custom.password.store') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" value="New Password" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
