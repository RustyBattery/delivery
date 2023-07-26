<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Создать блюдо
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form action="{{route('dish.store')}}" method="post" enctype="multipart/form-data"
                  class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="name">
                        Название
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                        id="name" name="name" type="text" value="">
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
                <div class="sm:flex">
                    <div class="mb-5 mt-1 mr-5">
                        <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="photo">
                            Фото
                        </label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                            id="photo" name="photo" type="file">
                        @error('photo')
                        <span class="text-red-800">
                                * {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="price">
                            Цена
                        </label>
                        <div class="flex items-center">
                            <input
                                class="mr-2 bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                                id="price" name="price" type="number" step="any" value="">
                            <span>руб.</span>
                        </div>
                        @error('price')
                        <span class="text-red-800">
                                * {{ $message }}
                                </span>
                        @enderror
                    </div>

                </div>
                <div class="mb-5">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="menu_id">
                        Меню
                    </label>
                    <select id="menu_id" name="menu_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500">
                        <option value="0"> Не выбрано</option>
                        @foreach($menus as $menu)
                            <option @if($menu_cur->id == $menu->id) selected
                                    @endif value="{{$menu->id}}">{{$menu->name}}</option>
                        @endforeach
                    </select>
                    @error('menu_id')
                    <span class="text-red-800">
                            * {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="category_id">
                        Категория
                    </label>
                    <div class="flex">
                        <select id="category_id" name="category_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-1/2 p-2.5 focus:ring-gray-500 focus:border-gray-500 mr-2">
                            <option value="0"> Не выбрано</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        <a href="{{route('category.index')}}"
                           class="block p-2 text-lg font-bold text-gray-600 hover:text-gray-500 transition delay-75">Управление
                            категориями</a>
                    </div>
                    @error('category_id')
                    <span class="text-red-800">
                            * {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="flex items-center mb-5">
                    <input id="is_vegetarian" name="is_vegetarian" type="checkbox" value="true"
                           class="w-6 h-6 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="is_vegetarian" class="ml-2 text-lg text-gray-900">Вегетерианское</label>
                </div>
                <x-primary-button>Сохранить</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
