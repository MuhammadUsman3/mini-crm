<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <a class="p-6" href="{{ route('companies.create') }}">{{_('Create Company')}}</a>
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
                                <th>Logo</th>
                                <th>website</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $c)
                                <tr>
                                    <td>{{ $c->name }}</td>
                                    <td>{{ $c->email }}</td>
                                    <td><img src="{{ Storage::url($c->logo) }}"/></td>
                                    <td>{{ $c->website }}</td>
                                    <td>
                                        <form method="post" action="{{route('companies.destroy',$c->id)}}">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>

                                        <a class="btn btn-small btn-info" href="{{ URL::to('companies/' . $c->id . '/edit') }}">Edit</a>
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
