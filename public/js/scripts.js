document.addEventListener("DOMContentLoaded", function () {

    const addProdModal = document.getElementById("addProductModal");
    const prodCardModal = document.getElementById("Show_prod_card");
    const addProdBtn = document.getElementById("add_prod_btn");
    const prodCardButton = document.getElementById("prod_card_button");
    const editModalBtn = document.getElementById("editModalBtn")

    const form = document.getElementById("product-form");
    const atrContainer = document.getElementById("atr-container");
    const addAttributeBtn = document.getElementById("add-attribute");

    
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
        document.getElementById("productArticle").textContent = "";
        document.getElementById("productName").textContent = "";
        document.getElementById("productStatus").textContent = "";
        document.getElementById("productAttributes").textContent = "";
        atrContainer.innerHTML = "";

        prodCardModal.style.display = "none";
        atrContainer.innerHTML = "";
    }

    if (addProdBtn) addProdBtn.addEventListener("click", function (event){
        openAddProdModal();
        let title = document.getElementById("modalTitle");
        title.textContent="Добавить продукт";
        let confirmButton = document.getElementById("confirm-button");
        confirmButton.setAttribute("data-action", "create");
    });
    if (prodCardButton) prodCardButton.addEventListener("click", function (event) {
        event.preventDefault();
        openProdCardModal();
    });
    if (editModalBtn) editModalBtn.addEventListener("click", function (event){});

    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("close-btn")) {
            const modal = event.target.closest(".modal");
            if (modal) modal.style.display = "none";
        }
        if (event.target.classList.contains("modal")) {
            event.target.style.display = "none";
        }
    });

    window.addEventListener("click", function (event) {
        if (event.target === addProdModal) {
            closeAddProdModal();
        }
        if (event.target === prodCardModal) {
            closeProdCardModal();
        }
    });
    
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

                document.getElementById("productArticle").textContent = data.article;
                document.getElementById("productName").textContent = data.name;
                document.getElementById("productStatus").textContent = data.status;
                const attributesContainer = document.getElementById("productAttributes");
                attributesContainer.innerHTML = Array.isArray(data.attributes) && data.attributes.length > 0 
                ? data.attributes.map(attr => `<p>${attr.key}: ${attr.value}</p>`).join("")
                : "<p>Нет атрибутов</p>";
            })

            let confirmButton = document.getElementById("confirm-button");
            confirmButton.setAttribute("data-action", "edit");
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

                articleInput.value = data.article;
                nameInput.value = data.name;
                statusSelect.value = statusMap[data.status] || "Доступен";
                
                atrContainer.innerHTML = "";

                if (data.attributes && Array.isArray(data.attributes)) {
                    data.attributes.forEach((attr, index) => {
                        const newAttribute = document.createElement("div");
                        newAttribute.classList.add("attribute-row");
                        newAttribute.innerHTML = `
                            <div class="attribute-container">
                                <div class="attribute-group">
                                    <h4>Название</h4>
                                    <input type="text" name="attributes[${index}][key]" class="attribute-input" required value="${attr.key}" />
                                </div>
                                <div class="attribute-group">
                                    <h4>Значение</h4>
                                    <input type="text" name="attributes[${index}][value]" class="attribute-input" required value="${attr.value}" />
                                </div>
                                <button type="button" class="remove-attribute">🗑️</button>
                            </div>
                        `;
                        atrContainer.appendChild(newAttribute);
                    });
                }
            })
            .catch(error => console.error("Ошибка запроса:", error));
        });
    });

    document.getElementById("product-form").addEventListener("submit", async function(event) {
        event.preventDefault();
        
        let confirmButton = document.getElementById("confirm-button");
        let action = confirmButton.getAttribute("data-action");
    
        if (action === "create") {
            await addNewProd();
        } else if (action === "edit") {
            await updateProduct();
        }
    });
    
    async function addNewProd() {
        let form = document.getElementById("product-form");
        let formData = new FormData(form);

        try {
            let response = await fetch("/product", {
                method: "POST",
                body: formData,
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                }
            });

            console.log("Статус ответа:", response.status);
    
            let result = await response.json();
    
            if (result.success) {
                closeAddProdModal();
                form.reset();
                location.reload();
            } else {
                alert("Ошибка при создании продукта");
            }
        } catch (error) {
            console.error("Ошибка:", error);
        }
    }
    
    async function updateProduct() {

        let modal = document.getElementById("Show_prod_card");
        let modalTitle = modal.querySelector("#modalTitle");

        let oldArticle = modalTitle.textContent;

        console.log(oldArticle);

        let form = document.getElementById("product-form");
        let formData = new FormData(form);
        formData.append("_method", "PUT");

        try {
            let response = await fetch(`/product/${oldArticle}`, {
                method: "POST",
                body: formData,
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                }
            });
    
            let result;
    
            try {
                result = await response.json();
            } catch (jsonError) {
                console.error("Ошибка парсинга JSON:", jsonError);
                let errorText = await response.text();
                console.error("Ответ сервера:", errorText);
                return;
            }
    
            if (response.ok && result.success) {
                closeAddProdModal();
                form.reset();
                location.reload();
            } else {
                alert("Ошибка при обновлении продукта: " + (result.message || "Неизвестная ошибка"));
            }
        } catch (error) {
            console.error("Ошибка запроса:", error);
        }
    }
});    

document.addEventListener("DOMContentLoaded", function () {
    let dropdownToggle = document.querySelector(".topbar-username");
    let dropdownMenu = document.querySelector(".admin-dropdown");

    dropdownToggle.addEventListener("click", function (event) {
        event.stopPropagation();
        dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
    });

    document.addEventListener("click", function (event) {
        if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = "none";
        }
    });
});