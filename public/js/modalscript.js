document.addEventListener("DOMContentLoaded", function () {
    // 1. Переменные для модальных окон
    const addProdModal = document.getElementById("addProductModal");
    const prodCardModal = document.getElementById("Show_prod_card");
    const addProdBtn = document.getElementById("add_prod_btn");
    const prodCardButton = document.getElementById("prod_card_button");
    const editModalBtn = document.getElementById("editModalBtn")

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
        form.reset();
        atrContainer.innerHTML = "";
    }

    function closeProdCardModal() {

        document.getElementById("modalTitle").textContent = "";
        document.getElementById("productArticle").textContent = "";
        document.getElementById("productName").textContent = "";
        document.getElementById("productStatus").textContent = "";
        document.getElementById("productAttributes").textContent = "";
        atrContainer.innerHTML = "";

        prodCardModal.style.display = "none";
        atrContainer.innerHTML = "";
    }

    //обработчики событий на кнопки
    if (addProdBtn) addProdBtn.addEventListener("click", openAddProdModal);
    if (prodCardButton) prodCardButton.addEventListener("click", function (event) {
        event.preventDefault();
        openProdCardModal();
    });
    if (editModalBtn) editModalBtn.addEventListener("click", openAddProdModal);

    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("close-btn")) {
            const modal = event.target.closest(".modal");
            if (modal) modal.style.display = "none";
        }
        if (event.target.classList.contains("modal")) {
            event.target.style.display = "none";
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
            let modal = document.getElementById("Show_prod_card");
            let modalTitle = modal.querySelector("#modalTitle"); 

            if (modal && modal.id === "Show_prod_card") { 
                modalTitle.textContent = `${article}`;
            }

            openProdCardModal();

            fetch(`/product/${article}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error("Ошибка:", data.error);
                    return;
                }

                // Заполняем модалку данными
                document.getElementById("productArticle").textContent = data.article;
                document.getElementById("productName").textContent = data.name;
                document.getElementById("productStatus").textContent = data.status;
                const attributesContainer = document.getElementById("productAttributes");
                attributesContainer.innerHTML = Array.isArray(data.attributes) && data.attributes.length > 0 
                ? data.attributes.map(attr => `<p>${attr.key}: ${attr.value}</p>`).join("")
                : "<p>Нет атрибутов</p>";
            })
        });
    });

    document.querySelectorAll(".delete-product-btn").forEach(button => {
        button.addEventListener("click", function (event) {

            let modal = document.getElementById("Show_prod_card");
            let modalTitle = modal.querySelector("#modalTitle");

            fetch(`/product/${modalTitle.textContent}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
            if (data.error) {;
                alert("Ошибка: " + data.error);
            } else {
                alert("Продукт успешно удален");
                location.reload();
            }
            })
            .catch(error => console.error("Ошибка:", error));

        })
    });

    document.querySelectorAll(".editModalBtn").forEach(button => {
        button.addEventListener("click", function (event) {

            const statusMap = {
                "available": "Доступен",
                "not_available": "Не доступен"
            };

            let modal = document.getElementById("Show_prod_card");
            let modalTitle = modal.querySelector("#modalTitle");
            
            let editmodal = document.getElementById("addProductModal");
            let editTitle = editmodal.querySelector("#modalTitle"); 

            article = modalTitle.textContent;

            closeProdCardModal();

            openAddProdModal();

                editTitle.textContent = `Редактировать ${article}`;

            fetch(`/product/${article}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error("Ошибка:", data.error);
                    return;
                }

                let articleInput = document.querySelector("input[name='article']");
                let nameInput = document.querySelector("input[name='name']");
                let statusSelect = document.querySelector("select[name='status']");
                //let attributesContainer = document.getElementById("atr-container");

                // Заполняем модалку данными
                articleInput.value = data.article; // Вставляем артикул
                nameInput.value = data.name;       // Вставляем название
                statusSelect.value = statusMap[data.status] || "Доступен";
                
            })

            .catch(error => console.error("Ошибка запроса:", error));
        });
    });
});
