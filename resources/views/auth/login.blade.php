<x-guest-layout>
    <form id="form" action="{{ route('login') }}" method="post">
        @csrf

        <div>
            <x-input-label for="username" :value="__('用户名')"/>
            <x-input-text id="username" class="block mt-1 w-full" type="email" name="username" :value="old('username')"
                          required autofocus/>
            <x-input-error :messages="$errors->get('username')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('密码')"/>
            <x-input-text id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-3">
                {{ __('登录') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>