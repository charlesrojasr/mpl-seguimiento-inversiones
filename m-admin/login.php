<?php
session_start();
include '../00_includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "
        SELECT 
            u.id AS user_id,
            u.username,
            u.password,
            u.role_id,
            ua.area_id,
            a.nombre AS area_nombre
        FROM inversiones_seg_users u
        LEFT JOIN inversiones_seg_user_areas ua 
               ON ua.user_id = u.id 
              AND ua.estado = 1
              AND ua.es_principal = 1
        LEFT JOIN inversiones_seg_area a 
               ON a.id = ua.area_id
        WHERE u.username = ?
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error SQL: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id']   = $user['user_id'];
            $_SESSION['role_id']   = $user['role_id'];
            $_SESSION['area_id']   = $user['area_id'];
            $_SESSION['area_name'] = $user['area_nombre'];

            header('Location: ../m-modulos/index.php');
            exit;

        } else {
            echo "Contraseña incorrecta.";
        }

    } else {
        echo "Usuario no encontrado.";
    }
}
?>





<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {font-family: Arial, Helvetica, sans-serif; }

/* Full-width input fields */
input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button {
    background-color: #053A52;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

/* Extra styles for the cancel button */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}

img.avatar {
    width: 150px;
    border-radius: 50%;
}

.container {
    padding: 16px;

}

span.psw {
    float: right;
    padding-top: 16px;
}

/* The Modal (background) */
.modal {
    display: block; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;


}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 55%; /* Could be more or less, depending on screen size */

}

/* The Close Button (x) */


/* Agregando efecto Zoom */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }

}


</style>
</head>
<body>



<div id="id01" class="modal">
  
  <form class="modal-content animate" action="login.php" method="post">
    <div class="imgcontainer">
      <h3>SEGUIMIENTO DE INVERSIONES</h3>
      <img src="img/logo-mdpl.png" alt="Municipalidad de Pueblo Libre" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Usuario</b></label>
      <input type="text" class="form-control" name="username" required>



      <label for="psw"><b>Contraseña</b></label>

      <input type="password" class="form-control" name="password" required>

        

      <button type="submit">Ingresar</button>

    </div>

  </form>
</div>

  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

</body>
</html>
