<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="dark:text-gray-300" />
            <x-text-input id="name" class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 dark:text-red-400" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="dark:text-gray-300" />
            <x-text-input id="email" class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 dark:text-red-400" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300" />
            <x-text-input id="password" class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 dark:text-red-400" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="dark:text-gray-300" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 dark:text-red-400" />
        </div>

        {{-- <!-- Especialidade -->
        <div class="mt-4">
            <x-input-label for="especialidade" :value="__('Especialidade')" class="dark:text-gray-300" />
            <select id="especialidade" name="especialidade" class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" required>
                <option value="" class="dark:bg-gray-800">-- Selecione uma especialidade --</option>
                <option value="desenvolvedor" class="dark:bg-gray-800">Desenvolvedor</option>
                <option value="designer" class="dark:bg-gray-800">Designer</option>
                <option value="gerente" class="dark:bg-gray-800">Gerente</option>
            </select>
            <x-input-error :messages="$errors->get('especialidade')" class="mt-2 dark:text-red-400" />
        </div> --}}

        {{-- <!-- Status -->
        <div class="mt-4">
            <x-input-label for="status" :value="__('Status')" class="dark:text-gray-300" />
            <select id="status" name="status" class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" required>
                <option value="" class="dark:bg-gray-800">-- Selecione o status --</option>
                <option value="Y" class="dark:bg-gray-800">Ativo</option>
                <option value="N" class="dark:bg-gray-800">Inativo</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2 dark:text-red-400" />
        </div> --}}

        {{-- <!-- Access -->
        <div class="mt-4">
            <x-input-label for="access" :value="__('Acesso')" class="dark:text-gray-300" />
            <select id="access" name="access" class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" required>
                <option value="" class="dark:bg-gray-800">-- Selecione o tipo de acesso --</option>
                <option value="1" class="dark:bg-gray-800">Admin</option>
                <option value="0" class="dark:bg-gray-800">User</option>
            </select>
            <x-input-error :messages="$errors->get('access')" class="mt-2 dark:text-red-400" />
        </div> --}}

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 dark:bg-indigo-600 dark:hover:bg-indigo-700">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
