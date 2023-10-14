<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mt-8 space-y-6 sm:px-8">
            @if (session()->has('user-groups.store.success'))
                <div class="text-3xl text-green-700">{{ session()->pull('user-groups.store.success') }}</div>
            @endif

            <form action="{{ route('user-groups.store') }}" method="POST">
                @csrf

                <label class="block">
                    <span class="text-gray-700">{{ __('分分组名称') }}</span>
                    <input type="text" name="name" required
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </label>

                <div class="grid grid-cols-2 gap-6">
                    <label class="block">
                        <span class="text-gray-700">{{ __('用户1') }}</span>
                        <select name="user_ids[]"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">{{ __('请选择用户') }}</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('分摊比例(%)') }}</span>
                        <input type="text" name="sharing_ratios[]" required placeholder="1-100"
                            value="50"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </label>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <label class="block">
                        <span class="text-gray-700">{{ __('用户2') }}</span>
                        <select name="user_ids[]"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">{{ __('请选择用户') }}</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('分摊比例(%)') }}</span>
                        <input type="text" name="sharing_ratios[]" required placeholder="1-100"
                            value="50"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button type="reset" class="ml-3">
                        {{ __('重置') }}
                    </x-primary-button>

                    <x-primary-button class="ml-3">
                        {{ __('创建') }}
                    </x-primary-button>
                </div>

                @if ($errors->any())
                    @foreach ($errors->all() as $err)
                        <x-input-error :messages="$err" class="mt-2" />
                    @endforeach
                @endif
            </form>
        </div>
    </div>
</x-app-layout>
