<?php
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

    // Sanitize and prepare input data
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_BCRYPT);

    // Insert data into database
    $sql = "INSERT INTO register (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Registration successful!');
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 5000);
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>

    <!--- My CSS Link-->
    <link rel="stylesheet" href="./styles.css">
</head>
<body>

    <main>
        <img src="flag.gif" style="width: 50px; left:0; top:0; position:absolute">
        <img src="banner2.jpg" style="width: 20%; height:60px; left:30%; top:0%; position:absolute">
        <img src="banner.jpg" style="width:20%; height:100px; left:7%; top:0%; position:absolute">
        <section class="learn">
           <h1>Transform Your Farming with Our Premium Products </h1>
           <p>Backed by the 
           <span style="font-weight: bold; color: #0000ff; font-size: 1.2em;">Ministry of Agriculture and Livestock Development Nepal</span>, and elevate your harvests to new heights!
           <br>  Upgrade your farm today and watch your yields soar! </p>  
        </section>

        <section>
            <div class="cta">
                <p><span>REGISTER to</span> browse our products</p>
            </div>

            
    <div class="sign-up">
        <form action="register.php" method="POST" class="signup-form">
            <div class="form-btn">
                <input type="text" name="first_name" placeholder="First Name" required>
                <img class="icon" src="./Images/icon-error.svg" alt="Error">
                <p class="msg">First Name cannot be empty</p>
            </div>

            <div class="form-btn">
                <input type="text" name="last_name" placeholder="Last Name" required>
                <img class="icon" src="./Images/icon-error.svg" alt="Error">
                <p class="msg">Last Name cannot be empty</p>
            </div>

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

            <input id="submit-btn" type="submit" value="REGISTER" id="btn">

            <p class="terms">By clicking the button, you are agreeing to our <span><a href="#">Terms and Services</a></span></p>
        </form>
        </section>
    </main>
    
</body>
</html>
