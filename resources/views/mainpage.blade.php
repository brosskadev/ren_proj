<x-app-layout sidenav_product="Продукты">

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

</body>
</html>

</x-app-layout>