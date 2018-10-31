<html>
<head>
    <title>Alumnes ST</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datatables/datatables.css">
</head>

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">

<body>
<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // Create connection
    $conn = new mysqli("localhost", "roberto", "amsesr", "alumnos");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->query("SET NAMES 'utf8'");
    $conn->query("SET CHARACTER SET utf8");
    $conn->query("SET SESSION collation_connection = 'utf8_unicode_ci'");

    $sql = "SELECT * FROM alumnos_clase";
    $result = $conn->query($sql);
    $ok = ($result->num_rows > 0);
} else {
    $ok = false;
    header("Location: index.php");
}?>

<?php if ($ok){ ?>
<div id="wrap">
<div class="container">
    <h2>Alumnes cursos Stata</h2>
    <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered" id="alumnes">
        <thead>
            <tr>
                <th>Periodo</th>
                <th>Grupo</th>
                <th>DNI</th>
                <th>PC</th>
                <th>Nombre</th>
                <th>Fijo</th>
                <th>Clase</th>
                <th>Comentario</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_array($result)) { ?>
            <?php $url = 'alumno.php?grupo='.$row["Grupo"].'&dni='.$row["DNI"]; ?>
            <tr>
                <td><?php echo $row["Periodo"]; ?></td>
                <td><?php echo $row["Grupo"]; ?></td>
                <td><?php echo "<a href='".$url."'>".$row["DNI"]."</a>"; ?></td>
                <td><?php echo $row["PC"]; ?></td>
                <td><?php echo $row["nom"]; ?></td>
                <td><?php echo ($row["Fijo"]==1 ? "Sí" : "No"); ?></td>
                <td><?php switch ($row["CLASE"]) {
                            case 1:
                              echo "APROBADO";
                              break;
                            case 2:
                              echo "BIEN";
                              break;
                            case 3:
                              echo "NOTABLE";
                              break;
                            case 4:
                              echo "EXCELENTE";
                              break;
                            } ?></td>
                <td><?php echo $row["Comentario"]; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#alumnes').dataTable();
    });
</script>

<?php $conn->close(); ?>

<?php } else {
    header("Location: index.php");
}?>

</body>
</html>
