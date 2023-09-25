<x-app-layout>
    <div class="py-12">
        <div class="mt-8 max-w-md sm:px-6 lg:px-8 space-y-6">
            @if(session()->has('record.store.success'))
                <div class="text-3xl text-green-700">{{ session()->pull('record.store.success') }}</div>
            @endif

            <h2 class="text-2xl font-bold">{{ __('添加') }}</h2>
            <form id="form" action="{{ route('records.store') }}" method="post">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <label class="block">
                        <span class="text-gray-700">{{ __('收支') }}</span>
                        <select name="type"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach($types as $t)
                                <option value="{{ $t['id'] }}">{{ $t['name'] }}</option>
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('类型') }}</span>
                        <select name="category_id"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="1">餐饮</option>
                            <option value="5">购物</option>
                            <option value="5002">收款</option>
                        </select>

                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('对方名称') }}</span>
                        <input type="text" name="reciprocal_name"
                               placeholder="({{ __('可选') }})"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />

                        <x-input-error :messages="$errors->get('reciprocal_name')" class="mt-2" />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('金额') }}</span>
                        <input type="text" name="amount"
                               placeholder="{{ __('单位(元)') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />

                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('日期') }}</span>
                        <input type="date" name="transaction_at"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                        <x-input-error :messages="$errors->get('transaction_at')" class="mt-2" />
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('备注') }}</span>
                        <textarea name="remarks"
                                  placeholder="({{ __('可选') }})"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                  rows="3" style="height: 76px;" maxlength="100"></textarea>

                        <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
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
    </div>
</x-app-layout>
