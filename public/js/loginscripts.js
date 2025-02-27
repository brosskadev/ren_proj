document.addEventListener("DOMContentLoaded", function(){
    document.getElementById("login-form").addEventListener("submit", async function (event) {
        event.preventDefault(); // Останавливаем стандартную отправку формы

        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;

        let response = await fetch("/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email, password })
        });

        let result = await response.json();

        if (response.ok) {
            window.location.href = "/main"; // Перенаправляем на страницу
        } else {
            document.getElementById("error-message").textContent = result.error;
        }
    });
});