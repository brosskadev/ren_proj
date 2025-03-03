<x-app-layout sidenav_product="Админ-панель">
<div class="content-wrapper">
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>email</th>
                <th>created_at</th>
                <th>role</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
                    <tr>
                        <td><a href="" class="">
                                {{ $user->id }}
                            </a>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->role }}</td>

                    </tr>
                 @endforeach
        </tbody>
    </table>
</div>

</div>

</x-app-layout>