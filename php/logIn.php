<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LogIn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <?php        
        if(isset($_POST['submit'])){
            require("connection.php");
            require("classes.php");

            $email = $_POST['username'];
            $pass = $_POST['password'];
    
            //Security:
            $email = strip_tags(mysqli_real_escape_string($connection, trim($email)));
            $pass = strip_tags(mysqli_real_escape_string($connection, trim($pass)));
    
            $tempUser = new User();

            if($tempUser->logIn($email, $pass)){
                $tempUser->userQuery($_SESSION['id']);
                // $tempUser->print($_SESSION['id']);

                mysqli_close($connection);
                header("Location: ../php/welcome.php");    
            }
            else{
                echo "Username or Password invalid";
                echo "<br>";
            }    
            mysqli_close($connection);
        }
    ?>

    <form name="logIn" action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password"><br><br>
        <a href='registration.php'>Register</a><br><br>
            
        <input type="submit" name="submit">
    </form>    
</body>
</html>