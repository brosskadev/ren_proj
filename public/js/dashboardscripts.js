document.addEventListener("DOMContentLoaded", function () {
    const addUserModalBtn = document.getElementById("add_user_btn");
    const addUserCardModal = document.getElementById("addUserModal");
    const userCardModalBtn = document.getElementById("open_user_card");
    const userCardModal = document.getElementById("Show_user_card");
    const form = document.getElementById("add-user-form");

    function openAddUserCardModal() {
        addUserCardModal.style.display = "flex";
    }

    function openUserCardModal(){
        userCardModal.style.display = "flex";
    }

    function closeUserCardModal(){
        userCardModal.style.display = "none";
        document.getElementById("id").textContent = "";
        document.getElementById("name").textContent = "";
        document.getElementById("email").textContent = "";
        document.getElementById("role").textContent = "";
        document.getElementById("created_at").textContent = "";
    }

    function closeAddUserCardModal() {
        addUserCardModal.style.display = "none";
        form.reset();
    }

    if (addUserModalBtn) addUserModalBtn.addEventListener("click", function (event){
        openAddUserCardModal();
        let title = document.getElementById("modalTitle");
        title.textContent="Добавить Пользователя";
        let confirmButton = document.getElementById("confirm-button");
        confirmButton.setAttribute("data-action", "createUser");
    });
    if (userCardModalBtn) userCardModalBtn.addEventListener("click", function (event){
        openUserCardModal();
    });

    window.addEventListener("click", function (event) {
        if (event.target === addUserCardModal) {
            closeAddUserCardModal();
        }
        if (event.target === userCardModal) {
            closeUserCardModal();
        }
    });

    document.querySelectorAll(".open_user_card").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            let article = this.getAttribute("data-article");
            let modal = document.getElementById("Show_user_card");
            let modalTitle = modal.querySelector("#modalTitle"); 

            if (modal && modal.id === "Show_user_card") { 
                modalTitle.textContent = `${article}`;
            }

            openUserCardModal();

            fetch(`/dashboard/users/${article}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error("Ошибка:", data.error);
                    return;
                }

                document.getElementById("id").textContent = data.id;
                document.getElementById("name").textContent = data.name;
                document.getElementById("email").textContent = data.email;
                document.getElementById("role").textContent = data.role;
                document.getElementById("created_at").textContent = data.created_at;
            })

            let confirmButton = document.getElementById("confirm-button");
            confirmButton.setAttribute("data-action", "editUser");
        });
    });

    document.querySelectorAll(".delete-user-btn").forEach(button => {
        button.addEventListener("click", function (event) {

            let modal = document.getElementById("Show_user_card");
            let modalTitle = modal.querySelector("#modalTitle");

            fetch(`/dashboard/users/${modalTitle.textContent}`, {
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
                alert("Пользователь успешно удален");
                location.reload();
            }
            })
            .catch(error => console.error("Ошибка:", error));

        })
    });


    document.querySelectorAll(".editUserModalBtn").forEach(button => {
        button.addEventListener("click", function (event) {

            let modal = document.getElementById("Show_user_card");
            let modalTitle = modal.querySelector("#modalTitle");
            
            let editmodal = document.getElementById("addUserModal");
            let editTitle = editmodal.querySelector("#modalTitle"); 

            article = modalTitle.textContent;

            closeUserCardModal();

            openAddUserCardModal();

            editTitle.textContent = `Редактировать ${article}`;

            fetch(`/dashboard/users/${article}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error("Ошибка:", data.error);
                    return;
                }

                let nameInput = document.querySelector("input[name='name']");
                let emailInput = document.querySelector("input[name='email']");
                let pwInput = document.querySelector("input[name='password']");
                let roleSelect = document.querySelector("select[name='role']");

                nameInput.value = data.name;
                emailInput.value = data.email;
                pwInput.value = data.password;
                roleSelect.value = data.role;

            })
        });
    });




    document.getElementById("addUserModal").addEventListener("submit", async function(event) {
        event.preventDefault();
        
        let confirmButton = document.getElementById("confirm-button");
        let action = confirmButton.getAttribute("data-action");

        if (action === "createUser") {
            await addNewUser();
        } else if (action === "editUser") {
            await updateUser();
        }
    });
    
    async function addNewUser() {
        let form = document.getElementById("add-user-form");
        let formData = new FormData(form);
    
        try {
            let response = await fetch("/dashboard/users", {
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
                closeAddUserCardModal();
                form.reset();
                location.reload();
            } else {
                alert("Ошибка при создании продукта");
            }
        } catch (error) {
            console.error("Ошибка:", error);
        }
    }

    async function updateUser() {

        let modal = document.getElementById("Show_user_card");
        let modalTitle = modal.querySelector("#modalTitle");

        let oldName = modalTitle.textContent;

        let form = document.getElementById("add-user-form");
        let formData = new FormData(form);
        formData.append("_method", "PUT");

        try {
            let response = await fetch(`/dashboard/users/${oldName}`, {
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
                closeAddUserCardModal();
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
