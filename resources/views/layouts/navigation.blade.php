<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('records.create')" :active="request()->routeIs('records.create')">
                        {{ __('添加记录') }}
                    </x-nav-link>
                    <x-nav-link href="#">
                        {{ __('分摊') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
