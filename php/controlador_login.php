<?php

session_start();
if (!empty($_POST["btnIngresar"])) {
    if (!empty($_POST["usuario"]) && !empty($_POST["contrasena"])) {
        $correo = $_POST["email"];
        $contrasena = $_POST["password"];
        $rol = $_POST["rol"];

        if ($rol == "Padre/Tutor") {
            $sql = $conexion->query("SELECT * FROM Tutor WHERE correo='$correo' AND contrasena='$contrasena' ");


            if ($datos = $sql->fetch_object()) {

                $idTutor = (int) $datos->id_tutor;
                $sql = $conexion->query("SELECT id_alumno, nombre, apellidos FROM Alumno WHERE id_tutor={$idTutor} ORDER BY apellidos, nombre");
                $_SESSION["alumnos"] = $sql->fetch_all(MYSQLI_ASSOC);

                if (!empty($_SESSION["alumnos"])) {
                    $_SESSION["id_tutor"] = $idTutor;
                    $_SESSION["id"] = (int) $_SESSION["alumnos"][0]["id_alumno"];
                    $_SESSION["nombre"] = $_SESSION["alumnos"][0]["nombre"];
                    $_SESSION["apellido"] = $_SESSION["alumnos"][0]["apellidos"];

                    header("location: ../index.html");
                } else {
                    echo "<script>alert('Esta cuenta no tiene alumnos asociados.');</script>";
                }
            } else {
                echo "<script>alert('Correo o contraseña incorrectos.');</script>";
            }

        } elseif ($rol == "Profesor/Docente") {
            $sql = $conexion->query("SELECT * FROM Profesor WHERE correo='$correo' AND contrasena='$contrasena' ");
            
            if ($datos = $sql->fetch_object()) {
                unset($_SESSION["alumnos"], $_SESSION["id_tutor"]);
                $_SESSION["id"] = $datos->id_profesor;
                $_SESSION["nombre"] = $datos->nombre;
                $_SESSION["apellido"] = $datos->apellido;
                
                header("location: ../index.html");
            } else {
                echo "<script>alert('Correo o contraseña incorrectos.');</script>";
            }

        } 
        
        
    } else {
        echo "<script>alert('Por favor, complete todos los campos.');</script>";
    }
}


?>