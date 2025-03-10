<x-app-layout sidenav_product="Админ-панель">
<div class="content-wrapper">
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>email</th>
                <th>role</th>
                <th>created_at</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
                    <tr>
                    <td>{{ $user->id }}</td>
                        <td><a href="#" class="art-link open_user_card" data-article="{{ $user->name }}">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->created_at }}</td>

                    </tr>
                 @endforeach
        </tbody>
    </table>
</div>

<div class="button-container">
    <button type="button" id="add_user_btn" data-action="create">Добавить</button>
</div>

@include('modals.add_user_modal')
@include('modals.show_user_modal')

<script src="{{ asset('js/dashboardscripts.js') }}"></script>
</div>

</x-app-layout>