<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

        <form method="POST" action="{{ route('companies.update',$company->id) }}">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name">{{__('Name')}}</label>

                <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$company->name}}" required autofocus />
            </div>

            <div>
                <label for="email">{{__('Email')}}</label>

                <input id="email" class="block mt-1 w-full" type="text" name="email" value="{{$company->email}}" required autofocus />
            </div>


            <div class="mt-4">
                <img src="{{ Storage::url($company->logo) }}"/>
            </div>

            <div class="mt-4">
                <label for="logo">{{__('Logo')}}</label>

                <input id="logo" class="block mt-1 w-full"
                                type="file"
                                name="logo" value="{{$company->logo}}" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="website">{{__('Website')}}</label>

                <input id="website" class="block mt-1 w-full"
                                type="text"
                                name="website" value="{{$company->website}}" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                

                <x-button class="ml-4">
                    {{ __('Update') }}
                </x-button>
            </div>
        </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
