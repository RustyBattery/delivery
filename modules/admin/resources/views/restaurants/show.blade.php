<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ресторан {{$restaurant->name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form action="{{ route('restaurant.update', [$restaurant->id]) }}" method="POST"
                  class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @csrf
                @method('PUT')
                <h2 class="text-xl font-bold pb-3 mb-5 text-gray-700 border-b border-gray-700">Основная информация</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="name">
                        Название
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                        id="name" name="name" type="text" value="{{$restaurant->name}}">
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
                        id="description" name="description" rows="4">{{$restaurant->description}}</textarea>
                </div>
                <x-primary-button>Обновить</x-primary-button>
            </form>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="pb-3 mb-5 border-b border-gray-700 flex items-center">
                    <h2 class="text-xl font-bold text-gray-700">Меню</h2>
                    <a href="{{ route('menu.create') }}"
                       class="mx-2 inline-flex items-center px-2  bg-gray-800 border border-transparent rounded-md text-lg font-semibold text-white hover:bg-gray-700 transition duration-150 select-none">
                        +
                    </a>
                </div>
                @foreach($restaurant->menus as $menu)
                    <a href="{{ route('menu.show', [$menu->id]) }}"
                       class="block p-2 sm:p-4 bg-gray-50 border border-gray-300 sm:rounded-lg mt-3 hover:bg-gray-100 transition delay-75">
                        <p class="text-lg font-semibold">{{$menu->name}}</p>
                        <p class="mb-2">{{$menu->description}}</p>
                        <p class="text-sm font-semibold">Кол-во блюд: {{$menu->count_dish}}</p>
                    </a>
                @endforeach
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-xl font-bold pb-3 mb-5 text-gray-700 border-b border-gray-700">Персонал</h2>
                <a href="{{route('restaurant.manager.index', [$restaurant->id])}}" class="block p-2 text-lg font-bold text-gray-600 hover:text-gray-500 transition delay-75">Менеджеры
                    ({{$restaurant->manager_count}})</a>
                <a href="{{route('restaurant.cook.index', [$restaurant->id])}}" class="block p-2 text-lg font-bold text-gray-600 hover:text-gray-500 transition delay-75">Повара
                    ({{$restaurant->cook_count}})</a>
            </div>
            <form action="{{ route('restaurant.destroy', [$restaurant->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-danger-button>Удалить ресторан</x-danger-button>
            </form>
        </div>
    </div>
</x-app-layout>
