<x-modal modal_id="addUserModal" modal_title="Добавление продукта">
    <form id="add-user-form">
        @csrf
        <div class="modal-body">

            <div class="body-container">
                <h4>Имя</h4>
                <input type="text" name="name" class="custom-input" required>
            </div>

            <div class="body-container">
                <h4>Email</h4>
                <input type="text" name="email" class="custom-input" required>
            </div>

            <div class="body-container">
                <h4>Пароль</h4>
                <input type="text" name="password" class="custom-input" required>
            </div>

            <div class="body-container">
                <h4>Роль</h4>
                <select name="role" class="custom-select" required>
                    <option value="admin">Админ</option>
                    <option value="user">Пользователь</option>
                </select>
            </div>

            <div class="body-container" id="atr-container"></div>

            <div class="body-container" id="atr-container">
                <button type="submit" id="user-confirm-button" class="confirm-button" data-action="">Добавить</button>
            </div>
        </div>
    </form>
</x-modal>