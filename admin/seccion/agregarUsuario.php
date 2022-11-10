<?php 
include("../template/header.php");
require("../config/db.php");

$message="";
//$sentenciaSQL= $conexionProd->prepare("INSERT INTO productos (Producto, Precio, Imagen) VALUES (:Producto, :Precio, :Imagen);");
//$sentenciaSQL->bindParam(':Producto',$txtProducto);
//$sentenciaSQL->bindParam(':Precio',$txtPrecio);


if (!empty($_POST['usuario']) && !empty($_POST['contrasena']) && !empty($_POST['confirmarContrasena'])){
 $stmt= $conexionProd->prepare("INSERT INTO usuarios (nombreUsuario, claveUsuario, tipoUsuario, activoUsuario) VALUES (:usuario, :contrasena, :tipoUsuario, :activoUsuario);");
 $stmt->bindParam(':usuario',$_POST['usuario']);
 $pass= password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
 $stmt->bindParam(':contrasena', $pass);
 $stmt->bindParam(':tipoUsuario',$_POST['tipoUsuario']);
 $stmt->bindParam(':activoUsuario',$_POST['activoUsuario']);

    if($stmt->execute()){
        $message="OK";
    }else{
        $message="NO OK";
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuarios</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
</br></br></br>
                <div class="card">
                    <div class="card-header">
                    Agregar Usuarios
                    </div>
                    <div class="card-body">

                        <form method="POST">
                        <div class = "form-group">
                        <label>Usuario:</label>
                        <input type="text" class="form-control" name="usuario" placeholder="Ingresar usuario">
                        <small id="emailHelp" class="form-text text-muted"></small>
                        </div>

                        <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña:</label>
                        <input type="password" class="form-control" name="contrasena" placeholder="Ingresar contraseña">
                        </div>
                        <div class="form-group">
                        <label for="exampleInputPassword1">Confirmar contraseña:</label>
                        <input type="password" class="form-control" name="confirmarContrasena" placeholder="Confirmar contraseña">
                        </div>
                        <input type="checkbox" name="tipoUsuario" value="Administrador"> Administrador</input>
                        <br>
                        <input type="checkbox" name="activoUsuario" value="Activo"> Activo</input>
                        <br/><br/>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                        </form>
                        
                        

                    </div>
                    
                </div>
                
            </div>
            
        </div>
    </div>
</body>
</html>





<?php include("../template/footer.php");?>