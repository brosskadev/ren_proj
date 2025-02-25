<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/mainpagestyle.css">
    <link rel="stylesheet" href="/css/modalstyle.css">
    <title>Enterprise Resource Planning</title>
</head>
<body>

<div class="sidenav">
    <div class="sidenav-header">
        <div class="logobox">
            <img src="logo.png" alt="Logo">
        </div>
        <div class="sidenav-companyname">Enterprise<br> Resource<br> Planning<br></div>
    </div>
    <div class="sidenav-product">Продукты</div>
</div>

<div class="topbar">
    <div class="topbar-product">
        ПРОДУКТЫ
    </div>
    <div class="topbar-username">
        Иванов Иван Иванович
    </div>
</div>

<div class="content-wrapper">

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Артикул</th>
                    <th>Название</th>
                    <th>Статус</th>
                    <th>Атрибуты</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td><a href="#" class="art-link prod-card-button" data-article="{{ $product->article }}">
                                {{ $product->article }}
                            </a>
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->status }}</td>

                        <td>
                            @if(!empty($product->attributes))
                                @foreach($product->attributes as $attribute)
                                    {{ $attribute['key'] ?? '—' }}: {{ $attribute['value'] ?? '—' }}<br>
                                @endforeach
                            @else
                                Нет атрибутов
                            @endif
                        </td>

                    </tr>
                 @endforeach
            </tbody>
        </table>
    </div>

    <div class="button-container">
        <button type="button" id="add_prod_btn" data-action="create">Добавить</button>
    </div>

</div>

@include('modals.add_prod_modal')
@include('modals.show_prod_card')

<script src="{{ asset('js/modalscript.js') }}"></script>

</body>
</html>