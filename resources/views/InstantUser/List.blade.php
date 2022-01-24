<x-yrm2>
    <h1>User List</h1>

    <div id="app">
        <table class="table table-dark table-striped text-left">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    @foreach($column as $c)
                        <th scope="col">{{ $c }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $user->instant_id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-yrm2>