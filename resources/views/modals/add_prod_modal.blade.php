<x-modal modal_id="addProductModal" modal_title="Добавление продукта">
<form id="product-form" action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="body-container">
                <h4>Артикул</h4>
                <input type="text" name="article" class="custom-input" required>
            </div>

            <div class="body-container">
                <h4>Название</h4>
                <input type="text" name="name" class="custom-input" required>
            </div>

            <div class="body-container">
                <h4>Статус</h4>
                <select name="status" class="custom-select" required>
                    <option value="Доступен">Доступен</option>
                    <option value="Не доступен">Не доступен</option>
                </select>
            </div>

            <div class="body-container">
                <h3>Атрибуты</h3>
            </div>

            <div class="body-container" id="atr-container">

            </div>

            <div class="body-container">
                <a href="#" id="add-attribute" class="button-link">+ Добавить атрибут</a>
            </div>

            <div class="body-container" id="atr-container">
                <button type="submit" id="confirm-button" class="confirm-button">Добавить</button>
            </div>
        </div>
    </form>
</x-modal>
