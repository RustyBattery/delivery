<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Блюдо - {{$dish->name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form action="{{route('dish.update', [$dish->id])}}" method="post" enctype="multipart/form-data"
                  class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @csrf
                @if($dish->photo)
                    <div class="flex w-full mb-5 justify-center">
                        <img class="object-cover rounded-lg md:w-1/2"
                             src="{{env('AWS_TAKE_URL').'/'.env('AWS_BUCKET').'/'.$dish->photo}}">
                    </div>
                @endif
                <div class="mb-4">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="name">
                        Название
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                        id="name" name="name" type="text" value="{{$dish->name}}">
                </div>
                <div class="mb-5">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="description">
                        Описание
                    </label>
                    <textarea
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                        id="description" name="description" rows="4">{{$dish->description}}</textarea>
                </div>
                <div class="sm:flex">
                    <div class="mb-5 mt-1 mr-5">
                        <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="photo">
                            Новое фото
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
                                id="price" name="price" type="number" step="any" value="{{$dish->price/100}}">
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
                            <option @if($dish->menu_id == $menu->id) selected
                                    @endif value="{{$menu->id}}">{{$menu->name}}</option>
                        @endforeach
                    </select>
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
                                <option @if($dish->category_id == $category->id) selected
                                        @endif value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        <a href="{{route('category.index')}}"
                           class="block p-2 text-lg font-bold text-gray-600 hover:text-gray-500 transition delay-75">Управление
                            категориями</a>
                    </div>
                </div>
                <div class="flex items-center mb-5">
                    <input @if($dish->is_vegetarian) checked @endif id="is_vegetarian" name="is_vegetarian"
                           type="checkbox" value="true"
                           class="w-6 h-6 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="is_vegetarian" class="ml-2 text-lg text-gray-900">Вегетерианское</label>
                </div>
                <x-primary-button>Сохранить</x-primary-button>
            </form>
            <form action="{{ route('dish.destroy', [$dish->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-danger-button>Удалить блюдо</x-danger-button>
            </form>
        </div>
    </div>
</x-app-layout>
