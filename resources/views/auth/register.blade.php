<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <h1 class="hero-title1">Entrar</h1>
        <!-- Name -->
        <div>
            <x-input-label class="hero-subtitle" for="name" :value="__('Nome')" />
            <x-text-input id="name" class="block mt-1 w-full hero-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label class="hero-subtitle" for="email" :value="__('Email')" />
            <x-text-input 
                id="email"
                class="block mt-1 w-full hero-input"
                type="email"
                name="email"
                :value="old('email', request('email'))"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 hero-email-text">
            <x-input-label class="hero-subtitle" for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full hero-input"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4 hero-email-text">
            <x-input-label class="hero-subtitle" for="password_confirmation" :value="__('Confirmar Senha')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full hero-input"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 hero-email-text">
            <a class="tilt rounded-md" href="{{ route('login') }}">
                {{ __('Já possui conta?') }}
            </a>

            <x-primary-button class="ms-4 btn-primary hero-btn">
                {{ __('Cadastrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
