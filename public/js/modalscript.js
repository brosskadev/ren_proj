document.addEventListener("DOMContentLoaded", function () {
    let modal = document.getElementById("modal");
    let btn = document.getElementById("openModalBtn");
    let closeBtn = document.getElementById("closeModalBtn");
    let addAttributeBtn = document.getElementById("add-attribute");
    let form = document.getElementById("product-form");
    let atrContainer = document.getElementById("atr-container");

    btn.addEventListener("click", function () {
        modal.style.display = "flex";
    });

    closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
        form.reset();
        atrContainer.innerHTML = "";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
            form.reset();
            atrContainer.innerHTML = "";
        }
    });

    addAttributeBtn.addEventListener("click", function (event) {
        event.preventDefault();

        let index = document.querySelectorAll(".attribute-row").length;

        let newAttribute = document.createElement("div");
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
    });

    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("remove-attribute")) {
            event.target.parentElement.remove();
        }
    });
});