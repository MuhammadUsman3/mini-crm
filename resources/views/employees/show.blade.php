<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="container">
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <td>{{ $employee->first_name . ' ' . $employee->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td>{{ $employee->phone }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $employee->email }}</td>
                            </tr>
                            <tr>
                                <th>Company</th>
                                <td>{{ $employee->company->name }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
