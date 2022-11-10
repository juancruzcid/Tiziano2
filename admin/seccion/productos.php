<?php include("../template/header.php"); ?>
<?php

/*variables para validar los campos. 
    La funcion isset valida que no este vacio.
    Condicional ?(condicion=true):(condicion=false)
    */

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtProducto = (isset($_POST['txtProducto'])) ? $_POST['txtProducto'] : "";
$txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$txtImg = (isset($_FILES['txtImg']['name'])) ? $_FILES['txtImg']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";


//se incluye el archivo de coneccion
include("../config/db.php");

switch ($accion) {

    case "Agregar":
        //Agrega los datos a la base a traves de los parametros que ingresa el usuario
        $sentenciaSQL = $conexionProd->prepare("INSERT INTO productos (Producto, Precio, Imagen) VALUES (:Producto, :Precio, :Imagen);");
        $sentenciaSQL->bindParam(':Producto', $txtProducto);
        $sentenciaSQL->bindParam(':Precio', $txtPrecio);

        //variable nombreArchivo genera un nombre con fecha para que no se sobrescriban archivos con el mismo nombre
        $fecha = new DateTime();
        $nombreArchivo = ($txtImg != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImg"]["name"] : "imagen.jpg";

        $tmpImg = $_FILES["txtImg"]["tmp_name"];

        if ($tmpImg != "") {
            move_uploaded_file($tmpImg, "../../img/" . $nombreArchivo);
        }

        $sentenciaSQL->bindParam(':Imagen', $nombreArchivo);
        $sentenciaSQL->execute();
        break;
    case "Modificar":

        $sentenciaSQL = $conexionProd->prepare("UPDATE productos SET Producto=:Producto WHERE ID=:ID");
        $sentenciaSQL->bindParam(':Producto', $txtProducto);
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();

        if ($txtImg != "") {
            $sentenciaSQL = $conexionProd->prepare("UPDATE productos SET Imagen=:Imagen WHERE ID=:ID");
            $sentenciaSQL->bindParam(':Imagen', $txtImg);
            $sentenciaSQL->bindParam(':ID', $txtID);
            $sentenciaSQL->execute();
        }

        break;

    case "Cancelar":
        echo "presionó Cancelar";
        break;

    case "Seleccionar":

        $sentenciaSQL = $conexionProd->prepare("SELECT * FROM productos WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();
        $Producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtProducto = $Producto['Producto'];
        $txtPrecio = $Producto['Precio'];
        $txtImg = $Producto['Imagen'];

        break;

    case "Borrar":

        $sentenciaSQL = $conexionProd->prepare("DELETE FROM productos WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();
        break;
}

//mostrar datos
$sentenciaSQL = $conexionProd->prepare("SELECT * FROM productos");
$sentenciaSQL->execute();
$listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="col-md-6">

    <div class="card">
        <div class="card-header">
            Datos de Productos
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="txtID">ID</label>
                    <input type="text" class="form-control" value="<?php echo $txtID; ?>" id="txtID" name="txtID" placeholder="ID">
                </div>


                <div class="form-group">
                    <label for="txtProducto">Producto:</label>
                    <input type="text" class="form-control" value="<?php echo $txtProducto; ?>" id="txtProducto" name="txtProducto" placeholder="Nombre del producto">
                </div>


                <div class="form-group">
                    <label for="txtPrecio">Precio:</label>
                    <input type="text" class="form-control" value="<?php echo $txtPrecio; ?>" id="txtPrecio" name="txtPrecio" placeholder="Precio">
                </div>

                <div class="form-group">
                    <label for="txtImg">Imagen</label>
                    <?php echo $txtID; ?>
                    <input type="file" class="form-control" id="txtImg" name="txtImg" placeholder="Imagen">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-6">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaProductos as $producto) { ?>
                <tr>
                    <td><?php echo $producto['ID']; ?></td>
                    <td><?php echo $producto['Producto']; ?></td>
                    <td><?php echo $producto['Precio']; ?></td>
                    <td><?php echo $producto['Imagen']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $producto['ID']; ?>" />
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include("../template/footer.php"); ?>