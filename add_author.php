<?php 

//connection 
// prepare sql INSERT lause

require_once('connection.php');

// var.dump($_POST )


if ( isset($_POST['add-author']) ) {
      $stmt = $pdo->prepare('INSERT INTO authors (first_name, last_name) VALUES (:first_name, :last_name)');
      $stmt->execute(['first_name' => $_POST['first-name'],  'last_name' => $_POST['last-name']]);
      
      header('Location: index.php');
} //lingi ja vormi kaudu lehele if post on edit, siis update päring. autori lisamine insert päring peale host nupule vajutamist

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lisa autor</title>
</head>

<body>
    <h1>Uue autori lisamine</h1>
    <form action="add_author.php" method="post"> <!-- Posti puhul on parameetrid päringu sees, mitte URL'is -->
        <input type="text" name="first-name" palceholder="Eesnimi">
        <br>
        <input type="text" name="last-name" palceholder="Perekonnanimi">
        <br>
        <input type="submit" name="add-author" value="Lisa">
    </form>
</body>

</html>
