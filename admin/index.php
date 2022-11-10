<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    //si el usuario presionó el botón ingresar.
    if (isset($_POST['ingresar'])) {
        //verifica si usuario o clave estan vacios
        if (empty($_POST['nombreUsuario']) || empty($_POST['claveUsuario'])) {
            echo "<script languaje='JavaScript'>
            alert('El usuario o contraseña no han sido ingresados');
            </script>";
        } else {
        //incluye la coneccion y verifica que usuario y clave esten en la base de datos
            include("config/db.php");
            $nombreUsuario = $_POST['nombreUsuario'];
            $claveUsuario = $_POST['claveUsuario'];
            $sql = "SELECT * FROM usuarios WHERE nombreUsuario='" . $nombreUsuario . "' and claveUsuario='" . $claveUsuario . "'";
            $resultado = mysqli_query($conexion, $sql);
            if ($fila = mysqli_fetch_assoc($resultado)) {
                header('Location:inicio.php');
            } else {
                echo "<script languaje='JavaScript'>
            alert('USUARIO Y CLAVE INCORRECTOS');
            </script>";
            }
        }
}
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                </br></br></br>
                <div class="card">
                    <div class="card-header">
                        LOGIN
                    </div>
                    <div class="card-body">
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-group">
                                <label>Usuario:</label>
                                <input type="text" class="form-control" name="nombreUsuario" aria-describedby="emailHelp" placeholder="Ingresar usuario">
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Contraseña:</label>
                                <input type="password" class="form-control" name="claveUsuario" placeholder="Ingresar contraseña">
                            </div>
                            <br />
                            <button type="submit" name="ingresar" class="btn btn-primary">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>