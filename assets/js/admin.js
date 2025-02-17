document.getElementById("adminLoginForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    fetch("../api/admin_login.php", {
        method: "POST",
        body: new URLSearchParams({ username, password }),
        headers: { "Content-Type": "application/x-www-form-urlencoded" }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            window.location.href = "timesheetadmin.html";
        } else {
            alert(data.error);
        }
    });
});
