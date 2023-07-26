<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            История банов пользователя
            <a href="{{route('user.show', [$user->id])}}" class="text-gray-600 hover:text-gray-500 transition delay-75">{{$user->name}}</a>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach($bans as $ban)
                <div class="p-4 bg-white shadow sm:rounded-lg">
                    <form action="{{route('ban.update', [$ban->id])}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="flex justify-end">
                            @if(\Carbon\Carbon::create($ban->end_time) > \Carbon\Carbon::now())
                                <div class="ml-3 lowercase px-2 rounded-lg bg-red-800 text-white">active</div>
                            @endif
                        </div>
                        <div class="md:flex md:justify-between items-center">
                            <div class="md:w-1/3 mb-2">
                                <label class="block text-gray-700 font-bold mb-2 ml-3" for="end_time">
                                    Окончание
                                </label>
                                <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500" id="end_time" name="end_time" type="date" value="{{\Carbon\Carbon::create($ban->end_time)->toDateString()}}">
                                @error('end_time')
                                    <span class="text-red-800">
                                        * {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="md:w-2/3 md:ml-3 mb-2">
                                <label class="block text-gray-700 font-bold mb-2 ml-3" for="reason">
                                    Причина
                                </label>
                                <input class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 focus:ring-gray-500 focus:border-gray-500" id="reason" name="reason" type="text" value="{{$ban->reason}}">
                            </div>
                            <div class="mb-2 flex items-center mt-5">
                                <div class="md:ml-3"><x-primary-button>Сохранить</x-primary-button></div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('ban.destroy', [$ban->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-danger-button>Удалить</x-danger-button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
