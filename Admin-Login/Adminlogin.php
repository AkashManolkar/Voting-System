<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .admin-login-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        .admin-login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="admin-login-container">
        <h2>Admin Login</h2>
        <form action="Adminlogin.php" method="post">
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>
    </div>
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();
        $conn = mysqli_connect('localhost', 'root', '', 'studentdatabase');

        $name = $_POST['name'];
        $password = $_POST['password'];

        $check = mysqli_query($conn, "SELECT * FROM adminlogin WHERE name='$name' AND password='$password' ");

        if (mysqli_num_rows($check)>0) {
            $_SESSION['adminlogin'] = true;
            $_SESSION['admin_name'] = $name;
            echo '
                <script>
                    location = "AdminDashboard.php";
                </script>
            ';
        }
        else{
            echo '
                <script>
                    alert("Incorrect information !! You are not Admin");
                    location = "Adminlogin.php";
                </script>
            ';
        }
    }
?>