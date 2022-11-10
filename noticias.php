<?php include("template/header.php");?>
<?php include("admin/config/db.php");?>
<?php

//instruccion para seleccionar todas las noticias de la tabla
$sentenciaSQL2= $conexion2->prepare("SELECT * FROM noticias ");
//ejecutar instruccion anterior
$sentenciaSQL2->execute();
//recupera todos los registros para mostrar asociando datos de la tabla con nuevos registros
$listaNoticias=$sentenciaSQL2->fetchAll(PDO::FETCH_ASSOC);

foreach($listaNoticias as $noticia){?>


<div class="card mb-3 border border-3 <?php echo $noticia["referenciaNoticia"] ?>" style="max-width:80%;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="..." class="img-fluid rounded-start" alt="">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title"><?php echo $noticia["tituloNoticia"] ?></h5>
        <p class="card-text"><?php echo $noticia["contenidoNoticia"] ?></p>
        <p class="card-text"><small class="text-muted">Fecha de publicación: <?php echo $noticia["fechaNoticia"] ?></small></p>
</div>
    </div>
  </div>
</div>





<?php } ?>








<?php include("template/footer.php"); ?>