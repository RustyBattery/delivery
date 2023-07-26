<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Профиль пользователя {{$user->name}} @if($user->is_banned)
                <span class="text-red-800">(ban)</span>
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form action="{{ route('user.destroy', [$user->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-danger-button>Удалить</x-danger-button>
            </form>
            {{--основная-информация--}}
            <form action="{{ route('user.update', [$user->id]) }}" method="POST"
                  class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @csrf
                @method('PUT')
                <h2 class="text-xl font-bold pb-3 mb-5 text-gray-700 border-b border-gray-700">Основная информация</h2>
                <div class="mb-5">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="name">
                        Имя
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                        id="name" name="name" type="text" value="{{$user->name}}">
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
                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                            id="email" name="email" type="text" placeholder="example@gmail.com"
                            value="{{$user->email}}">
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
                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                            id="phone" name="phone" type="text" placeholder="+7(xxx)xxx-xx-xx" value="{{$user->phone}}">
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
                        <input
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                            id="birthdate" name="birthdate" type="date"
                            value="{{\Carbon\Carbon::create($user->birthdate)->toDateString()}}">
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
                        <select id="gender"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500">
                            <option>Не выбран</option>
                            <option @if($user->gender == "male") selected @endif value="Male">Мужской</option>
                            <option @if($user->gender == "female") selected @endif value="Female">Женский</option>
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
                        Новый пароль
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                        id="password" name="password" type="text">
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
                            <input @if(in_array("cook", $user->roles)) checked @endif id="cook" name="roles[]"
                                   type="checkbox" value="cook"
                                   class="w-5 h-5 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 focus:ring-2">
                            <label for="cook" class="ml-2 font-medium text-gray-900">Повар</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input @if(in_array("courier", $user->roles)) checked @endif id="courier" name="roles[]"
                                   type="checkbox" value="courier"
                                   class="w-5 h-5 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 focus:ring-2">
                            <label for="courier" class="ml-2 font-medium text-gray-900">Курьер</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input @if(in_array("manager", $user->roles)) checked @endif id="manager" name="roles[]"
                                   type="checkbox" value="manager"
                                   class="w-5 h-5 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 focus:ring-2">
                            <label for="manager" class="ml-2 font-medium text-gray-900">Менеджер</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input @if(in_array("admin", $user->roles)) checked @endif id="admin" name="roles[]"
                                   type="checkbox" value="admin"
                                   class="w-5 h-5 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-gray-500 focus:ring-2">
                            <label for="admin" class="ml-2 font-medium text-gray-900">Администратор</label>
                        </div>
                    </div>
                </div>
                <x-primary-button>Обновить</x-primary-button>
            </form>
            {{--повар--}}
            @if(in_array("cook", $user->roles))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex items-center justify-between border-b border-gray-700 pb-3 mb-5">
                        <h2 class="text-xl font-bold text-gray-700">Информация
                            повара</h2>
                        <form action="{{route('user.cook.delete', [$user->id])}}" method="POST" class="">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Разжаловать</x-danger-button>
                        </form>
                    </div>
                    <form action="{{ route('user.cook.upsert', [$user->id]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="restaurant_id">
                                Ресторан
                            </label>
                            <select id="restaurant_id" name="restaurant_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500">
                                <option value="0">Не выбран</option>
                                @foreach($restaurants as $restaurant)
                                    <option
                                        @if(isset($user->cook->restaurant_id) && $user->cook->restaurant_id == $restaurant->id) selected
                                        @endif value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-primary-button>Обновить</x-primary-button>
                    </form>
                </div>
            @endif

            {{--менеджер--}}
            @if(in_array("manager", $user->roles))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex items-center justify-between border-b border-gray-700 pb-3 mb-5">
                        <h2 class="text-xl font-bold text-gray-700">Информация
                            менеджера</h2>
                        <form action="{{route('user.manager.delete', [$user->id])}}" method="POST" class="">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Разжаловать</x-danger-button>
                        </form>
                    </div>
                    <form action="{{ route('user.manager.upsert', [$user->id]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="restaurant_id">
                                Ресторан
                            </label>
                            <select id="restaurant_id" name="restaurant_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500">
                                <option value="0"> Не выбран</option>
                                @foreach($restaurants as $restaurant)
                                    <option
                                        @if(isset($user->manager->restaurant_id) && $user->manager->restaurant_id == $restaurant->id) selected
                                        @endif value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-primary-button>Обновить</x-primary-button>
                    </form>
                </div>
            @endif
            {{--бан--}}
            <form action="{{route('user.ban.create', [$user->id])}}" method="post"
                class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @csrf
                <h2 class="text-xl font-bold pb-3 mb-5 text-gray-700 border-b border-gray-700">Забанить
                    пользователя</h2>
                <div class="mb-5">
                    <label class="block text-gray-700 text-lg font-bold mb-2 ml-3" for="reason">
                        По причине
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500"
                        id="reason" name="reason" type="text">
                </div>
                <div class="mb-5 flex items-center">
                    <label class="block text-gray-700 text-lg font-bold mb-2 mr-5 pt-2" for="end_time">
                        До
                    </label>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block p-2.5 focus:ring-gray-500 focus:border-gray-500"
                        id="end_time" name="end_time" type="date">
                    @error('end_time')
                    <span class="text-red-800">
                            * {{ $message }}
                        </span>
                    @enderror
                </div>
                <x-primary-button>Сохранить</x-primary-button>
            </form>
            <div class="mb-5">
                <a href="{{route('user.ban.index', [$user->id])}}" class="block p-2 text-lg font-bold text-gray-600 hover:text-gray-500 transition delay-75">
                    История банов
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
