<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Менеджеры ресторана
            <a href="{{route('restaurant.show', [$restaurant->id])}}" class="text-gray-600 hover:text-gray-500 transition delay-75">{{$restaurant->name}}</a>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a href="{{route('user.create')}}" class="inline-flex items-center px-3 py-1 bg-gray-800 border border-transparent rounded-md text-xl font-semibold text-white hover:bg-gray-700 transition duration-150 select-none">
                +
            </a>
            @foreach($managers as $manager)
                <a href="{{route('user.show', [$manager->id])}}" class="block p-4 sm:p-8 bg-white shadow sm:rounded-lg hover:bg-gray-50 transition delay-75">
                    <p class="text-lg font-semibold">{{$manager->name}}</p>
                    <p class="mt-2">{{$manager->email}}</p>
                    <p class="mt-2">{{$manager->phone}}</p>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
