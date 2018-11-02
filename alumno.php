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
$periodo = $_GET["periodo"];
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
} else {
    $ok = false;
    header("Location: index.php");
}?>

<div class="container">
  <h2>Dades de l'alumne</h2>

  <div class="form-inline">
    <label for="periodo" class="mr-sm-2">Període:</label>
    <input type="text" class="form-control mb-2 mr-sm-2" id="periodo" value="<?php echo $periodo; ?>"/>
    <label for="grupo" class="mr-sm-2">Grup:</label>
    <input type="text" class="form-control mb-2 mr-sm-2" id="grupo" value="<?php echo $grupo; ?>"/>
    <label for="dni" class="mr-sm-2">DNI:</label>
    <input type="text" class="form-control mb-2 mr-sm-2" id="dni" value="<?php echo $dni; ?>"/>
  </div>
  <div class="form-group">
    <label for="nom" class="mr-sm-2">Nom:</label>
    <input type="text" class="form-control mb-2 mr-sm-2" id="nom" value="<?php echo $row["nom"]; ?>"/>
  </div>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="form-inline">
      <label for="pc" class="mr-sm-2">PC:</label>
      <input type="text" class="form-control mb-2 mr-sm-2" id="pc" value="<?php echo $row["PC"]; ?>"/>
      <div class="form-check">
        <label class="form-check-label">
          <input class="form-check-input" type="checkbox" <?php if ($row["Fijo"]==1) { ?> checked <?php } ?> > Fix
        </label>
      </div>
    </div>
    <div class="form-inline">
      <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="clase" <?php if ($row["CLASE"]==1) { ?> checked <?php } ?> >APROBADO
        </label>
      </div>
      <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="clase" <?php if ($row["CLASE"]==2) { ?> checked <?php } ?>>BIEN
        </label>
      </div>
      <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="clase" <?php if ($row["CLASE"]==3) { ?> checked <?php } ?>>NOTABLE
        </label>
      </div>
      <div class="form-check-inline">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="clase" <?php if ($row["CLASE"]==4) { ?> checked <?php } ?>>EXCELENTE
        </label>
      </div>
    </div>
    <div class="form-group">
      <label for="coment" class="mr-sm-2">Comentari:</label>
      <input type="text" class="form-control mb-2 mr-sm-2" id="coment" value="<?php echo $row["Comentario"]; ?>"/>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

</body>
</html>
