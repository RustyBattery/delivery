<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Создать пользователя
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form action="{{route('user.store')}}" method="post"
                class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @csrf
                <div class="mb-5">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="name">
                        Имя
                    </label>
                    <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500" id="name" name="name" type="text">
                    @error('name')
                    <span class="text-red-800">
                            * {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="sm:flex">
                    <div class="mb-5 sm:w-1/2 sm:pr-2">
                        <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="email">
                            Почта
                        </label>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500" id="email" name="email" type="text" placeholder="example@gmail.com">
                        @error('email')
                        <span class="text-red-800">
                            * {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="mb-5 sm:w-1/2 sm:pl-2">
                        <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="phone">
                            Телефон
                        </label>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500" id="phone" name="phone" type="text" placeholder="+7(xxx)xxx-xx-xx">
                        @error('phone')
                        <span class="text-red-800">
                            * {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="flex mb-5">
                    <div class="mr-5">
                        <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="birthdate">
                            Дата рождения
                        </label>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500" id="birthdate" name="birthdate" type="date">
                        @error('birthdate')
                        <span class="text-red-800">
                            * {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="mr-5">
                        <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="gender">
                            Пол
                        </label>
                        <select id="gender" name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500">
                            <option value="">Не выбран</option>
                            <option value="Male">Мужской</option>
                            <option value="Female">Женский</option>
                        </select>
                        @error('gender')
                        <span class="text-red-800">
                            * {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-5">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="password">
                        Пароль
                    </label>
                    <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500" id="password" name="password" type="text">
                    @error('password')
                    <span class="text-red-800">
                            * {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3">
                        Роли
                    </label>
                    <div class="flex flex-wrap">
                        <div class="flex items-center mr-4">
                            <input id="cook" value="cook" name="roles[]" type="checkbox" class="w-5 h-5 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 focus:ring-2">
                            <label for="cook" class="ml-2 font-medium text-gray-900">Повар</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="courier" value="courier" type="checkbox" class="w-5 h-5 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 focus:ring-2">
                            <label for="courier" class="ml-2 font-medium text-gray-900">Курьер</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="manager" value="manager" name="roles[]" type="checkbox" class="w-5 h-5 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 focus:ring-2">
                            <label for="manager" class="ml-2 font-medium text-gray-900">Менеджер</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="admin" value="admin" name="roles[]" type="checkbox" class="w-5 h-5 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 focus:ring-2">
                            <label for="admin" class="ml-2 font-medium text-gray-900">Администратор</label>
                        </div>
                    </div>
                </div>
                <x-primary-button>Сохранить</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
