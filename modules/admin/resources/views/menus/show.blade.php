<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Меню - {{$menu->name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form action="{{ route('menu.update', [$menu->id]) }}" method="POST"
                  class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @csrf
                @method('PUT')
                <h2 class="text-xl font-bold pb-3 mb-5 text-gray-700 border-b border-gray-700">Основная информация</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="restaurant_id">
                        Ресторан
                    </label>
                    <select id="restaurant_id" name="restaurant_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500">
                        <option value="0">Не выбран</option>
                        @foreach($restaurants as $restaurant)
                            <option @if($menu->restaurant_id == $restaurant->id) selected
                                    @endif value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                        @endforeach
                    </select>
                    @error('restaurant_id')
                    <span class="text-red-800">
                            * {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="name">
                        Название
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                        id="name" name="name" type="text" value="{{$menu->name}}">
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
                        id="description" name="description" rows="4"> {{$menu->description}}</textarea>
                </div>
                <x-primary-button>Сохранить</x-primary-button>
            </form>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="pb-3 mb-5 border-b border-gray-700 flex items-center">
                    <h2 class="text-xl font-bold text-gray-700">Блюда</h2>
                    <a href="{{ route('dish.create', [$menu->id]) }}"
                       class="mx-2 inline-flex items-center px-2  bg-gray-800 border border-transparent rounded-md text-lg font-semibold text-white hover:bg-gray-700 transition duration-150 select-none">
                        +
                    </a>
                </div>
                @foreach($menu->dishes as $dish)
                    <a href="{{ route('dish.show', [$dish->id]) }}"
                       class="block p-2 sm:p-4 bg-gray-50 border border-gray-300 sm:rounded-lg mt-3 hover:bg-gray-100 transition delay-75">
                        <div class="flex items-center">
                            <p class="text-lg font-semibold mr-2">{{$dish->name}}</p>
                            <div class="bg-gray-600 text-white px-2 text-sm rounded-lg mr-2">{{$dish->category->name}}</div>
                            @if($dish->is_vegetarian)
                                <div class="bg-green-800 text-white px-2 text-sm rounded-lg">Вегетерианское</div>
                            @endif
                        </div>
                        <p class="mb-2">{{$dish->description}}</p>
                    </a>
                @endforeach
            </div>
            <form action="{{ route('menu.destroy', [$menu->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-danger-button>Удалить меню</x-danger-button>
            </form>
        </div>
    </div>
</x-app-layout>
