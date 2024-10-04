<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Evaluation System for Lyceum of Alabang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
    <div class="inner-box">
                <div class="logo">
                    <img src="images/LoaLogo.png" alt="Lyceum of Alabang Logo">
                    <h4>LYCEUM OF ALABANG</h4>
                </div>
        </div>
        <div class="box">
            <div class="forms-wrap">
        <form action="DBlogin.php" method="POST" autocomplete="off" class="sign-in-form">
            <div class="actual-form">
                <div class="heading">
                    <h2>STUDENT-FACULTY EVALUATION SYTEM</h2>
                </div>
                <br>
                <div class="input-wrap">
                    <input type="text" name="username" minlength="4" class="input-field" autocomplete="off" required/> 
                    <label>Username</label>
                </div>
                <div class="input-wrap">
                    <input type="password" name="password" minlength="4" class="input-field" autocomplete="off" required/> 
                    <label>Password</label>
                </div>
                <div class="paste-button">
                    <button type="button" class="button" id="pasteButton">Login As &nbsp; ▼</button>
                    <div class="dropdown-content">
                        <a id="top" href="#">Student</a>
                        <a id="middle" href="#">Faculty</a>
                        <a id="bottom" href="#">Admin</a>
                    </div>
                </div>
                <input type="submit" value="Sign In" class="sign-btn">
                <p class="text">
                    Forgot your password?
                    <a href="AdminDashboard.php">Get help</a> signing in
                </p>
            </div>
        </form>
    </div>
            
        </div>
    </main>

    <script src="script.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    const pasteButton = document.getElementById("pasteButton");
    const dropdownLinks = document.querySelectorAll(".dropdown-content a");
    let selectedRole = '';

    dropdownLinks.forEach(link => {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            selectedRole = this.textContent;
            pasteButton.innerHTML = `Login as &nbsp; ${selectedRole}`;

            // Ensure the hidden input is updated
            let roleInput = document.getElementById("roleInput");
            if (!roleInput) {
                roleInput = document.createElement("input");
                roleInput.type = "hidden";
                roleInput.name = "role";
                roleInput.id = "roleInput";
                document.querySelector(".sign-in-form").appendChild(roleInput);
            }
            roleInput.value = selectedRole;
        });
    });

    document.querySelector(".sign-in-form").addEventListener("submit", function(event) {
        if (!selectedRole) {
            event.preventDefault();
            alert('You need to choose a role before logging in.');
        }
    });
});
</script>
    
</body>
</html>