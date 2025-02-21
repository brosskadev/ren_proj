<x-modal modal_id="Show_prod_card" modal_title="артикул">
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
                    <option value="available">Доступен</option>
                    <option value="not_available">Не доступен</option>
                </select>
            </div>

            <div class="body-container">
                <h3>Атрибуты</h3>
            </div>
</x-modal>