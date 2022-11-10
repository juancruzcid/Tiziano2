<link rel="stylesheet" href="../css/estilo.css">;
<?php include("template/header.php");?>
<?php include("config/db.php");?>



<form method="POST" id="frmNoticia" name="nuevaNoticia">
    <div class="mb-3">
        <h1>Nueva publicación</h1><br />
        <label for="tituloNoticia" class="form-label">Titulo:</label>
        <input type="text" class="form-control" name="tituloNoticia" id="tituloNoticia">
    </div>
    <div class="mb-3">
        <label class="form-label">Cuerpo:</label>
        <textarea class="form-control" name="contenidoNoticia"></textarea>
    </div>
    <select class="form-select" aria-label="Default select example" name="referenciaNoticia">
        <option value="border-success">Novedad</option>
        <option value="border-danger">Urgente</option>
        <option value='"border-warning"'>Varios</option>
    </select><br /><br />
    <div class="form-group">
        <label>Seleccionar Imagen:</label>
        <input type="file" class="form-control" name="imagenNoticia" placeholder="Imagen">
    </div><br />
    <button type="submit" class="btn btn-primary" name="publicarNoticia" value="publicar">Publicar</button>
</form>

<?php
if (isset($_POST['publicarNoticia'])) {
    if (empty($_POST['tituloNoticia']) || empty($_POST['contenidoNoticia']) || empty($_POST['referenciaNoticia'])) {
        echo "<script languaje='JavaScript'>
        alert('Los campos Titulo, Contenido y Referencia tienen que estar completos');
        </script>";} 

    else {
            $tituloNoticia=(isset($_POST['tituloNoticia']))?$_POST['tituloNoticia']:"";
            $contenidoNoticia=(isset($_POST['contenidoNoticia']))?$_POST['contenidoNoticia']:"";
            $referenciaNoticia=(isset($_POST['referenciaNoticia']))?$_POST['referenciaNoticia']:"";
            $imagenNoticia=(isset($_FILES['imagenNoticia']['name']))?$_FILES['imagenNoticia']['name']:"";
            $publicarNoticia=(isset($_POST['publicarNoticia']))?$_POST['publicarNoticia']:"";

            $DateAndTime=date('d-m-Y');
            $sentenciaSQL3 = $conexion2->prepare("INSERT INTO noticias (tituloNoticia, contenidoNoticia, referenciaNoticia, fechaNoticia, imagenNoticia) VALUES (:tituloNoticia, :contenidoNoticia, :referenciaNoticia, :fechaNoticia,  :imagenNoticia);");
            $sentenciaSQL3->bindParam(':tituloNoticia', $tituloNoticia);
            $sentenciaSQL3->bindParam(':fechaNoticia', $DateAndTime);
            $sentenciaSQL3->bindParam(':contenidoNoticia', $contenidoNoticia);
            $sentenciaSQL3->bindParam(':referenciaNoticia', $referenciaNoticia);
            
            //Fecha para no duplicar el nombre de las imagenes
            $fecha = new DateTime();
            $nombreArchivo=($imagenNoticia!="")?$fecha->getTimestamp()."_".$_FILES["imagenNoticia"]["name"]:"imagen.jpg";
            
            $tempImg=$_FILES["imagenNoticia"]["temp_name"];

            if ($tempImg!=""){
                move_uploaded_file($tempImg,"../img/imgNoticias".$nombreArchivo);
            }


            $sentenciaSQL3->bindParam(':imagenNoticia', $imagenNoticia);

            $sentenciaSQL3->execute();
    }
}


?>



<?php include('template/footer.php'); ?>