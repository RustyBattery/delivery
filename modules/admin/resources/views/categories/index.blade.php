<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Категории блюд
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach($categories as $category)
                <div class="p-4 bg-white shadow sm:rounded-lg">
                    <form action="{{ route('category.update', [$category->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="md:flex md:justify-between items-center">
                            <div class="md:w-1/3 mb-2">
                                <label class="block text-gray-700 font-bold mb-2 ml-3" for="name">
                                    Название
                                </label>
                                <input
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                                    id="name" name="name" type="text" value="{{$category->name}}">
                            </div>
                            <div class="md:w-2/3 md:ml-3 mb-2">
                                <label class="block text-gray-700 font-bold mb-2 ml-3" for="description">
                                    Описание
                                </label>
                                <textarea
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                                    id="description" name="description" rows="1">{{$category->description}}</textarea>
                            </div>
                            <div class="md:ml-3 mt-5">
                                <x-primary-button>Сохранить</x-primary-button>
                            </div>
                        </div>
                    </form>
                    <div class="mt-2">
                        <form action="{{ route('category.destroy', [$category->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Удалить</x-danger-button>
                        </form>
                    </div>
                </div>

            @endforeach
            {{ $categories->links() }}
            <form action="{{ route('category.store') }}" method="POST" class="p-4 bg-white shadow sm:rounded-lg">
                @csrf
                <h2 class="text-xl font-bold pb-3 mb-5 text-gray-700 border-b border-gray-700">Добавить новую
                    категорию</h2>
                <div class="md:flex md:justify-between items-center">
                    <div class="md:w-1/3 mb-2">
                        <label class="block text-gray-700 font-bold mb-2 ml-3" for="name">
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
                    <div class="md:w-2/3 md:ml-3 mb-2">
                        <label class="block text-gray-700 font-bold mb-2 ml-3" for="description">
                            Описание
                        </label>
                        <textarea
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                            id="description" name="description" rows="1"></textarea>
                    </div>
                    <div class="md:ml-3 md:pt-4">
                        <x-primary-button>Сохранить</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
