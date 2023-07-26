<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Пользователи
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center justify-between">
                <a href="{{route('user.create')}}" class="inline-flex items-center px-3 py-1 bg-gray-800 border border-transparent rounded-md text-xl font-semibold text-white hover:bg-gray-700 transition duration-150 select-none">
                    +
                </a>
                <form action="{{route('user.index')}}" method="get" class="flex">
                    <select id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500 mr-2">
                        <option >Все пользователи</option>
                        <option @if(app('request')->input('role') == "manager" ) selected @endif value="manager">Менеджеджеры</option>
                        <option @if(app('request')->input('role') == "cook" ) selected @endif value="cook">Повара</option>
                        <option @if(app('request')->input('role') == "courier" ) selected @endif value="courier">Курьеры</option>
                        <option @if(app('request')->input('role') == "admin" ) selected @endif value="admin">Администраторы</option>
                        <option @if(app('request')->input('role') == "customer" ) selected @endif value="customer">Без роли</option>
                    </select>
                    <x-primary-button>Показать</x-primary-button>
                </form>
            </div>
            @foreach($users as $user)
                <a href="{{route('user.show', [$user->id])}}" class="block p-4 sm:p-8 bg-white shadow sm:rounded-lg hover:bg-gray-50 transition delay-75">
                    <div class="md:flex justify-between flex-row-reverse">
                        <div class="flex justify-end items-start">
                            @foreach($user->roles as $role)
                                @if($role->slug == "manager")
                                    <div class="ml-3 lowercase px-2 rounded-lg bg-blue-800 text-white">{{$role->name}}</div>
                                @endif
                                @if($role->slug == "cook")
                                    <div class="ml-3 lowercase px-2 rounded-lg bg-green-800 text-white">{{$role->name}}</div>
                                @endif
                                @if($role->slug == "courier")
                                    <div class="ml-3 lowercase px-2 rounded-lg bg-yellow-700 text-white">{{$role->name}}</div>
                                @endif
                                @if($role->slug == "admin")
                                    <div class="ml-3 lowercase px-2 rounded-lg bg-gray-800 text-white">{{$role->name}}</div>
                                @endif
                            @endforeach
                        </div>
                        <div>
                            <p class="text-lg font-semibold">{{$user->name}} @if($user->is_banned)<span class="text-red-800">(ban)</span>@endif</p>
                            <p class="mt-2">{{$user->email}}</p>
                            <p class="mt-2">{{$user->phone}}</p>
                        </div>
                    </div>
                </a>
            @endforeach
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
