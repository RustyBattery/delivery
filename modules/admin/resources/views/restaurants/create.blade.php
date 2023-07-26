<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Создать ресторан
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form action="{{ route('restaurant.store') }}" method="POST"
                  class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="name">
                        Название
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                        id="name" name="name" type="text">
                    @error('name')
                        <span class="text-red-800">
                            * {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="description">
                        Описание
                    </label>
                    <textarea
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                        id="description" name="description" rows="4"></textarea>
                </div>
                <x-primary-button>Сохранить</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
