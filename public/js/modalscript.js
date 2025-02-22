document.addEventListener("DOMContentLoaded", function () {
    // 1. Переменные для модальных окон
    const addProdModal = document.getElementById("addProductModal");
    const prodCardModal = document.getElementById("Show_prod_card");
    const addProdBtn = document.getElementById("add_prod_btn");
    const prodCardButton = document.getElementById("prod_card_button");

    // 2. Переменные для формы и атрибутов
    const form = document.getElementById("product-form");
    const atrContainer = document.getElementById("atr-container");
    const addAttributeBtn = document.getElementById("add-attribute");

    // === ФУНКЦИИ ОТКРЫТИЯ И ЗАКРЫТИЯ МОДАЛОК ===
    
    function openAddProdModal() {
        addProdModal.style.display = "flex";
    }

    function openProdCardModal() {
        prodCardModal.style.display = "flex";
    }

    function closeAddProdModal() {
        addProdModal.style.display = "none";
        form.reset(); // Очистка формы
        atrContainer.innerHTML = ""; // Очистка атрибутов
    }

    function closeProdCardModal() {
        prodCardModal.style.display = "none";
    }

    // Назначаем обработчики событий на кнопки
    if (addProdBtn) addProdBtn.addEventListener("click", openAddProdModal);
    if (prodCardButton) prodCardButton.addEventListener("click", function (event) {
        event.preventDefault(); // Предотвращает переход по ссылке
        openProdCardModal();
    });

    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("close-btn")) {
            const modal = event.target.closest(".modal");
            if (modal) modal.style.display = "none";
        }
        if (event.target.classList.contains("modal")) {
            event.target.style.display = "none"; // Закрытие при клике вне контента
        }
    });

    // Закрытие при клике вне модального окна
    window.addEventListener("click", function (event) {
        if (event.target === addProdModal) {
            closeAddProdModal();
        }
        if (event.target === prodCardModal) {
            closeProdCardModal();
        }
    });

    // === УПРАВЛЕНИЕ АТРИБУТАМИ ===
    
    function addAttribute(event) {
        event.preventDefault();

        const index = document.querySelectorAll(".attribute-row").length;

        const newAttribute = document.createElement("div");
        newAttribute.classList.add("attribute-row");
        newAttribute.innerHTML = `
            <div class="attribute-container">
                <div class="attribute-group">
                    <h4>Название</h4>
                    <input type="text" name="attributes[${index}][key]" class="attribute-input" required />
                </div>
                <div class="attribute-group">
                    <h4>Значение</h4>
                    <input type="text" name="attributes[${index}][value]" class="attribute-input" required />
                </div>
                <button type="button" class="remove-attribute">🗑️</button>
            </div>
        `;

        atrContainer.appendChild(newAttribute);
    }

    if (addAttributeBtn) addAttributeBtn.addEventListener("click", addAttribute);

    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-attribute")) {
            event.target.closest(".attribute-row").remove();
        }
        if (event.target.classList.contains("edit-attribute")) {
            const attributeRow = event.target.closest(".attribute-row");
            const inputs = attributeRow.querySelectorAll(".attribute-input");
            inputs.forEach(input => input.removeAttribute("readonly"));
        }
    });

    document.querySelectorAll(".prod-card-button").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            
            let article = this.getAttribute("data-article");
            let modal = document.getElementById("Show_prod_card"); // Получаем нужную модалку
            let modalTitle = modal.querySelector("#modalTitle");

            console.log("Перед изменением:", modalTitle.textContent); 

            if (modal && modal.id === "Show_prod_card") { 
                modalTitle.textContent = `${article}`; // Меняем заголовок
                console.log("После изменения:", modalTitle.textContent);
            }

            openProdCardModal();
        });
    });

    document.getElementById("closeModalBtn").addEventListener("click", function () {
        document.getElementById("productModal").style.display = "none";
    });

});
