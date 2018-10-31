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
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $row["Periodo"]; ?></td>
                <td><?php echo $row["Grupo"]; ?></td>
                <td><?php echo $row["DNI"]; ?></td>
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