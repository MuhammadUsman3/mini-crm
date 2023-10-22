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

        <form method="POST" action="{{ route('employees.update',$employee->id) }}">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="first_name">{{__('First Name')}}</label>

                <input id="first_name" class="block mt-1 w-full" type="text" name="first_name" value="{{$employee->first_name}}" required autofocus />
            </div>

            <div>
                <label for="last_name">{{__('Last Name')}}</label>

                <input id="last_name" class="block mt-1 w-full" type="text" name="last_name" value="{{$employee->last_name}}" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email">{{__('Email')}}</label>

                <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{$employee->email}}" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="company_id">{{__('Company')}}</label>

                <select  id="company_id" name="company_id" class="form-control">
                            <option value="">-- Select Company --</option>
                            @foreach ($companies as $data)
                            <option {{$employee->company_id == $data->id ? " selected" : ""}} value="{{$data->id}}">
                                {{$data->name}}
                            </option>
                            @endforeach
                        </select>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="phone">{{__('Phone')}}</label>

                <input id="phone" class="block mt-1 w-full"
                                type="text"
                                name="phone" value="{{$employee->phone}}" required />
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
