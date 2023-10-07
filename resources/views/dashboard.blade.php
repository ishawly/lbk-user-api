<x-app-layout>
    {{--record filters--}}
    <div class="py-12">
        <div class="mt-8 max-w-md sm:px-6 lg:px-8 space-y-6">
            <form action="{{route('dashboard')}}" method="get">
                <div class="grid grid-cols-2 gap-6">
                    <label class="block">
                        <span class="text-gray-700">{{ __('收支') }}</span>
                        <select name="type"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">{{ __('所有') }}</option>
                            @foreach($types as $t)
                                <option value="{{ $t['id'] }}">{{ $t['name'] }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('类型') }}</span>
                        <select name="category_id"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">{{ __('所有') }}</option>
                            <option value="1">餐饮</option>
                            <option value="5">购物</option>
                            <option value="5002">收款</option>
                        </select>
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('开始日期') }}</span>
                        <input type="date" name="transaction_at_start"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('结束日期') }}</span>
                        <input type="date" name="transaction_at_end"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button type="reset" class="ml-3">
                        {{ __('重置') }}
                    </x-primary-button>

                    <x-primary-button class="ml-3">
                        {{ __('提交') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!--record list-->
        <div class="m-5">
            <form action="{{route('sharings.store')}}" method="post">
                @csrf

                @foreach($records as $record)
                    <div class="grid grid-cols-8 w-4/5 mt-2">
                        <div>
                            <input type="checkbox" name="record_ids[]" value="{{$record->id}}" />
                        </div>

                        <div>{{ $record->transaction_at->format('Y-m-d') }}</div>
                        <div>{{ $record->getTypeName() }}</div>
                        <div class="text-red-500">{{ $record->getAmountYuan() }}元</div>
                        <div>{{ $record->category->name }}</div>
                        <div>{{ $record->reciprocal_name }}</div>

                        <div class="col-span-2 text-gray-500">{{ $record->remarks }}</div>
                    </div>
                @endforeach

                <div class="grid grid-cols-1 gap-6">
                    <x-input-error :messages="$errors->get('record_ids')" class="mt-2" />

                    <label class="block">
                        <span class="text-gray-700">{{ __('分摊名称') }}</span>
                        <input type="text" name="name" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('分组') }}</span>
                        <select name="sharing_user_group_id"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">{{ __('请选择分组') }}</option>
                            @foreach($userGroups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('sharing_user_group_id')" class="mt-2" />

                        <a href="{{route('user-groups.create')}}" class="text-gray-700 text-underline">创建分组</a>
                    </label>
                </div>

                <div class="flex items-center justify-start mt-4">
                    <x-primary-button class="ml-3">
                        {{ __('创建分摊') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
