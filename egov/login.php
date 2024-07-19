<?php
$error_message = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $servername = "localhost";
    $username = "test";
    $password = "test";
    $dbname = "website";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and get the input data
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Retrieve the user data from the database
    $sql = "SELECT id, password FROM register WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the hashed password from the database
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, redirect to products.php or set session variables
            session_start();
            $_SESSION['user_id'] = $row['id'];
            header("Location: products.php");
            exit();
        } else {
            // Password is incorrect
            $error_message = "Incorrect email/password.";
        }
    } else {
        // Email not found
        $error_message = "Incorrect email/password.";
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!--- My CSS Link-->
    <link rel="stylesheet" href="./styles.css">
    <!-- JavaScript for message timeout and redirect -->
    <script>
        // Function to display message for 7 seconds and then refresh
        function displayMessageAndRefresh(message) {
            var msgElement = document.getElementById('msg');
            msgElement.textContent = message;
            msgElement.style.display = 'block';
            setTimeout(function() {
                window.location.href = "login.php";
            }, 7000); // 7 seconds timeout
        }
    </script>
</head>
<body>
    <main>
    <img src="flag.gif" style="width: 50px; left:0; top:0; position:absolute">
        <img src="banner2.jpg" style="width: 20%; height:60px; left:70%; top:0%; position:absolute">
        <img src="banner.jpg" style="width:20%; height:100px; left:7%; top:0%; position:absolute">
        <section>
            <div class="cta">
                <p><span>LOGIN</span></p>
            </div>
            <div class="sign-up">
                <form action="login.php" method="POST" class="signup-form">
                    <div class="form-btn">
                        <input type="email" name="email" placeholder="Email Address" required>
                        <img class="icon" src="./Images/icon-error.svg" alt="Error">
                        <p class="msg">Looks like this is not an email</p>
                    </div>
                    <div class="form-btn">
                        <input type="password" name="password" placeholder="Password" required>
                        <img class="icon" src="./Images/icon-error.svg" alt="Error">
                        <p class="msg">Password cannot be empty</p>
                    </div>
                    <input id="submit-btn" type="submit" value="LOGIN" id="btn" onclick="displayMessageAndRefresh('<?php echo $error_message; ?>')">
                    <!-- Error message display -->
                    <p id="msg" class="msg" style="display: <?php echo empty($error_message) ? 'none' : 'block'; ?>;"><?php echo $error_message; ?></p>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
