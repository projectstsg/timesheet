fetch("http://localhost:8080/digitalteam_timesheet/api/insert_user.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(userData)
})

    body: JSON.stringify({
        name: userName,
        email: userEmail,
        employeeId: employeeId
    }),
})
