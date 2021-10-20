<?php

require_once("config.php");

$nameErr = $usernameErr = $passwordErr = $conpasswordErr = $emailErr = $telponErr = "";
$name = $username = $password = $conpassword = $email = $telpon = "";


if(isset($_POST['register'])){

    // filter data yang diinputkan
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $conpassword = password_hash($_POST["conpassword"], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $telpon = filter_input(INPUT_POST, 'telpon', FILTER_SANITIZE_STRING);

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["name"]))
        {
            $nameErr = "Name is required";
        }
        else
        {
            $name = test_input($_POST["name"]);
            if (!preg_match("/^[a-zA-Z ]*$/",$name))
            {
                $nameErr = "Only letters and white space are allowed";
            }
        }

        if (empty($_POST["username"]))
        {
            $usernameErr = "Username is required";
        }

        if (empty($_POST["telpon"]))
        {
            $telponErr = "Telephone is required";
        }
        else
        {
            $telpon = test_input($_POST["telpon"]);
            if (!preg_match("/^[0-9]*$/",$telpon))
            {
                $telponErr = "Only Numbers are allowed";
            }
        }

        if (empty($_POST["email"]))
        {
            $emailErr = "Email is required";
        }

        if (empty($_POST["password"]))
        {
            $passwordErr = "Password is required";
        }

        if (empty($_POST["conpassword"]))
        {
            $conpasswordErr = "Please confirm your password";
        }
        else
        {
            if(strcmp($_POST["conpassword"],$_POST["password"])!=0)
            {
                $conpasswordErr = "Please confirm your password CORRECTLY";
            }
        }
    }
}


    // menyiapkan query
    $sql = "INSERT INTO users (name, username, email, telpon, password) 
            VALUES (:name, :username, :email, :telpon, :password)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":name" => $name,
        ":username" => $username,
        ":password" => $password,
        ":email" => $email,
        ":telpon" => $telpon
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if($saved) header("Location: login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - Ray'Z</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">

        <h4>Register</h4>
        <hr />

        <form action="" method="POST">

            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control" type="text" name="username" placeholder="Your Username" />
                <span class="error">* <?php echo $usernameErr;?></span>
            </div>
            
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name" placeholder="Your Name" />
                <span class="error">* <?php echo $nameErr;?></span>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" placeholder="Your Email" />
                <span class="error">* <?php echo $emailErr;?></span>
            </div>

            <div class="form-group">
                <label for="telpon">Telephone</label>
                <input class="form-control" type="telpon" name="telpon" placeholder="Your Telephone" />
                <span class="error">* <?php echo $telponErr;?></span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Your Password" />
                <span class="error">* <?php echo $passwordErr;?></span>
            </div>

            <div class="form-group">
                <label for="conpassword">Confirm Password</label>
                <input class="form-control" type="conpassword" name="conpassword" placeholder="Confirm Password" />
                <span class="error">* <?php echo $conpasswordErr;?></span>
            </div>

            <p>Already have an account? <a href="login.php">LOGIN</a></p>

            <input type="submit" class="btn btn-success btn-block" name="register" value="R E G I S T E R" />

        </form>
            
        </div>

        <div class="col-md-4">
            
        </div>

        <div class="col-md-2">
            <p>&rarr; <a href="index.php">Home</a>
        </div>

    </div>
</div>

</body>
</html>