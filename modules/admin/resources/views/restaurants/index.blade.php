<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Рестораны
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="p-2 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('restaurant.create') }}"
               class="inline-flex items-center px-3 py-1 bg-gray-800 border border-transparent rounded-md text-xl font-semibold text-white hover:bg-gray-700 transition duration-150 select-none">
                +
            </a>
            @foreach($restaurants as $restaurant)
                <a href="{{ route('restaurant.show', [$restaurant->id]) }}"
                   class="block p-4 sm:p-8 bg-white shadow sm:rounded-lg cursor-pointer hover:bg-gray-50 transition delay-75">
                    <p class="text-lg font-semibold">{{$restaurant->name}}</p>
                    <p class="mt-2">{{$restaurant->description}}</p>
                </a>
            @endforeach
            {{ $restaurants->links() }}
        </div>
    </div>
</x-app-layout>
