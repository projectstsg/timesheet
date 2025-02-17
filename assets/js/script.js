document.getElementById("timesheetForm").addEventListener("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch("../api/insert_timesheet.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    })
    .catch(error => console.error("Error:", error));
});
