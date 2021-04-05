<?php

  

    $where = '';
    if (isset($_REQUEST['tipo'])){
        $tipo = $_REQUEST['tipo'];
        if ($tipo != '') {
         $where = "WHERE p.tipo = '$tipo'";
        }
    }
    if (isset($_REQUEST['gender'])){
        $gender = $_REQUEST['gender'];
        if ($gender != ""){
            if ($where == ""){
                $where = " WHERE p.gender = '$gender'";
            }else{
                $where = "$where OR p.gender = '$gender'";
            }
        }
    }


    //Conexión a la base de datos
    $host = "localhost";
    $dbname = "Pet_Shop";
    $username = "root";
    $password = "";

    $cnx = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    //Construir la sentencia sql
    $sql = "SELECT d.Name as doctor_name, d.Consulting_room, p.Name as pet_name, p.Gender, p.Tipo, p.Race, a.Time FROM Doctor as d JOIN appointments as a ON d.Doctor_id = a.Doctor_id JOIN Pet p ON a.Doctor_id = p.Id $where ORDER BY d.Name ASC";

    //Prepara la sentencia SQL
    $q = $cnx->prepare($sql);
    
    // Ejecutar sentencia SQL
    $result = $q->execute();  
    $appointments = $q->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/css/">
    <title>Appointments List</title>
</head>
<body>
    <form action="full-appointment.php">
        Gender
        <select name="gender">
            <option value="">Select</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
        </select>
        <br/><br/>
        Tipo 
        <select name="tipo">
            <option value="">Select</option>
            <option value="Gato">Gato</option>
            <option value="Perro">Perro</option>
        </select>
       
        <br/><br/>
        <input type="submit" value="Search"/>
        <hr/>
    
    </form>
    <h1>Reports List</h1>
        <table> 
            <tr>
                <td>Doctor Name</td>
                <td>Consulting room</td>
                <td>Pet Name</td>
                <td>Genter</td>
                <td>Tipo</td>
                <td>Race</td>
                <td>Time</td>
            </tr>

    <?php
        for($i = 0; $i<count($appointments); $i++){
    ?>       
            <tr>
                <td>
                    <?php echo $appointments[$i]["doctor_name"] ?>
                </td>
                <td><?php echo $appointments[$i]["Consulting_room"] ?></td>
                <td><?php echo $appointments[$i]["pet_name"] ?></td>
                <td><?php echo $appointments[$i]["Gender"] ?></td>
                <td><?php echo $appointments[$i]["Tipo"] ?></td>
                <td><?php echo $appointments[$i]["Race"] ?></td>
                <td><?php echo $appointments[$i]["Time"] ?></td>
            </tr>
    <?php
        }
    ?>

        </table>
</body>
</html>