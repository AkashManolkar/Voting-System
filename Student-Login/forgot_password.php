<?php
$conn = mysqli_connect('localhost', 'root', '', 'studentdatabase');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_number = $_POST['roll_number'] ?? null;
    $email = $_POST['email'] ?? null;
    $mobile = $_POST['mobile'] ?? null;

    if (!$roll_number) {
        echo '<script>
            alert("Enter your Roll Number"); 
            location="forgot_password.php";
        </script>';
        exit();
    }

    // Check if roll number exists
    $check_query = "SELECT * FROM studentsregistration WHERE roll_number = ? AND email = ? And mobile = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("sss", $roll_number, $email, $mobile);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        echo '<script>
                    alert("Roll Number Verified. Proceed to Reset Password.");
                    location="reset_password.php?roll_number=' . $roll_number . '";
              </script>';
    } else {
        echo '<script>
                alert("Incorrect Roll-Number or Email or Mobile No. "); 
                location="forgot_password.php";
            </script>';
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password</title>
</head>
<style>
    .container {
        height: 400px;
        width: 450px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        margin: 100px auto;
        padding: 15px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.9);
    }

    .submit {
        background-color: #3498db;
        color: white;
        padding: 12px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-top: 10px;
        border-radius: 5px;
    }

    p {
        font-size: 1.5rem;
    }

    input {
        font-size: 1.2rem;
        padding: 8px;
    }

    h2 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 20px;
    }
</style>

<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="forgot_password.php" method="post">
            <p>
                <label>Roll Number : </label>
                <input type="text" name="roll_number" placeholder="Enter Roll Number" required />
            </p>
            <p>
                <label style="padding-right: 67px;">Email :</label>
                <input type="email" name="email" placeholder="Enter Email" required />
            </p>
            <p>
                <label>Mobile No. : &nbsp;</label>
                <input type="number" name="mobile" placeholder="Enter Mobile No." required />
            </p>
            <p>
                <input type="submit" value="Submit" class="submit" />
            </p>
        </form>
    </div>
</body>

</html>