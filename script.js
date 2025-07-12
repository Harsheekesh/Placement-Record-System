<script>
    document.getElementById("login-btn").addEventListener("click", function (event) {
        event.preventDefault(); // Prevent form from submitting

        // Get input values
        const role = document.getElementById("role").value;
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        // Admin credentials (for demonstration purposes, use more secure authentication in production)
        const adminUsername = "admin123"; // Replace with actual admin username
        const adminPassword = "password123"; // Replace with actual admin password

        // Authentication logic for admin
        if (role === "admin") {
            if (username === adminUsername && password === adminPassword) {
                alert("Login successful! Redirecting to admin panel...");
                window.location.href = "update.html"; // Redirect to admin page
            } else {
                alert("Invalid admin credentials! Please try again.");
            }
        } else {
            alert("You are not authorized to access the admin panel.");
        }
    });

    // Optional: Disable "Close" button form submission (if it's not necessary to submit the form)
    document.getElementById("close-btn").addEventListener("click", function (event) {
        event.preventDefault();
        window.location.href = "index.html"; // Redirect to home page
    });
</script>
