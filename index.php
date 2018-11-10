<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Alumnes ST Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>


<body>
<?php
// define variables and set to empty values
$usernameErr = $pswdErr = "";
$username = $pswd = "";
$ok = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $usernameErr = "El nom d'usuari és necessari";
        $ok = false;
    } else {
        $username = test_input($_POST["username"]);
    }

    if (empty($_POST["pswd"])) {
        $pswdErr = "La contrasenya és necessària";
        $ok = false;
    } else {
        $pswd = test_input($_POST["pswd"]);
    }

    if ($ok) {
        // Create connection
        $conn = new mysqli("localhost", "rsesma", "Amsesr.1977", "alumnos");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $hash = password_hash($pswd, PASSWORD_DEFAULT);
        $sql = "SELECT password FROM users WHERE username = '".$username."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $hash = $row["password"];
                if (password_verify($pswd, $hash)) {
                    $_SESSION['loggedin'] = true;
                } else {
                    $ok = false;
                    $pswdErr = "La contrasenya no és correcta";
                }
            }
        } else {
            $ok = false;
            $usernameErr = "El nom d'usuari no existeix";
        }

        $conn->close();

        if ($ok) {
            echo '<script>window.location.href = "load.php";</script>';
        }
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div class="container">
    <div class="jumbotron">
        <h1>Alumnes ST</h1>
        <p>Indiqui nom d'usuari i contrasenya.</p>
    </div>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label for="username">Nom d'usuari:</label>
            <input type="text" class="form-control" name="username">
            <span class="error text-danger"><?php echo $usernameErr;?></span>
        </div>
        <div class="form-group">
            <label for="pswd">Contrasenya:</label>
            <input type="password" class="form-control" name="pswd">
            <span class="error text-danger"><?php echo $pswdErr;?></span>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
