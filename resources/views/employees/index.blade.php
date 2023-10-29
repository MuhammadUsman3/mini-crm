<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <a class="p-6" href="{{ route('employees.create') }}">{{_('Create Employee')}}</a>
                <div class="p-6 bg-white border-b border-gray-200">
                @if(Session::get('success', false))
                <?php $data = Session::get('success'); ?>
                    @if (is_array($data))
                        @foreach ($data as $msg)
                            <div class="alert alert-success" role="alert">
                                <i class="fa fa-check"></i>
                                {{ $msg }}
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check"></i>
                            {{ $data }}
                        </div>
                    @endif
                    @endif
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $e)
                                <tr>
                                    <td>{{ $e->first_name . ' ' . $e->last_name }}</td>
                                    <td>{{ $e->email }}</td>
                                    <td>{{$e->company->name}}</td>
                                    <td>{{ $e->phone }}</td>
                                    <td>
                                        <a class="btn btn-small btn-info" href="{{ URL::to('employees/' . $e->id . '') }}">Show</a>
                                        | <a class="btn btn-small btn-info" href="{{ URL::to('employees/' . $e->id . '/edit') }}">Edit</a>
                                        | <form method="post" action="{{route('employees.destroy',$e->id)}}">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
