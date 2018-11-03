<?php session_start(); ?>

<!DOCTYPE html>
<head>
  <title>Alumne</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>

<body>
<?php
$grupo = $_GET["grupo"];
$dni = $_GET["dni"];

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // Create connection
    $conn = new mysqli("localhost", "roberto", "Amsesr.2108", "alumnos");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->query("SET NAMES 'utf8'");
    $conn->query("SET CHARACTER SET utf8");
    $conn->query("SET SESSION collation_connection = 'utf8_unicode_ci'");

    $sql = "SELECT * FROM clase WHERE Grupo='".$grupo."' AND DNI='".$dni."'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    $txt = $row["nom"]." (".$dni.") Grup: ".$grupo;
} else {
    $ok = false;
    header("Location: index.php");
}
?>

<div class="container">
  <div class="jumbotron">
      <h4><?php echo $txt; ?></h4>
  </div>

  <form method="post" action="<?php echo htmlspecialchars("load.php");?>">
    <input type="hidden" name="grupo" value="<?php echo $grupo;?>">
    <input type="hidden" name="dni" value="<?php echo $dni;?>">

    <div class="form-inline">
      <label for="pc" class="mr-sm-2">PC:</label>
      <input type="text" class="form-control mb-2 mr-sm-2" name="pc" value="<?php echo $row["PC"]; ?>"/>
      <div class="form-check">
        <label class="form-check-label mr-sm-2">
          <input class="form-check-input" name="fijo" type="checkbox" <?php if ($row["Fijo"]==1) { ?> checked <?php } ?> > Fix
        </label>
      </div>
    </div>
    <div class="form-inline mt-2">
      <label class="mr-sm-2">CLASE:</label>
      <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="clase" value="1" <?php if ($row["CLASE"]==1) { ?> checked <?php } ?> >APROBADO
        </label>
      </div>
      <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="clase" value="2" <?php if ($row["CLASE"]==2) { ?> checked <?php } ?>>BIEN
        </label>
      </div>
      <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="clase" value="3" <?php if ($row["CLASE"]==3) { ?> checked <?php } ?>>NOTABLE
        </label>
      </div>
      <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="clase" value="4" <?php if ($row["CLASE"]==4) { ?> checked <?php } ?>>EXCELENTE
        </label>
      </div>
    </div>
    <div class="form-group mt-3">
      <label for="coment" class="mr-sm-2">Comentari:</label>
      <input type="text" class="form-control mb-2 mr-sm-2" name="coment" value="<?php echo $row["Comentario"]; ?>"/>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
  </form>
</div>

</body>
</html>
