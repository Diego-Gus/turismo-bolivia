<?php include("includes/header_front.php") ?>

<?php 

    $baseDatos = new Basemysql();

    $db = $baseDatos->connect();

    $articulos = new articulo($db);

    $resultado = $articulos->leer();

?>

    <div class="container-fluid">
        <h1 class="text-center">Lugares Turisticos</h1>
        <div class="row">

            <?php foreach ($resultado as $articulo) :?>
                <div class="col-sm-4 margin-bottom">
                    <div class="card">
                        <img class="img-nuevas" src="<?php echo RUTA_FRONT . "img/articulos/" . $articulo->imagen; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $articulo->titulo; ?></h5>
                            <p><?php echo formatearFecha($articulo->fecha_creacion); ?></p>
                            <p class="card-text"><?php echo textoCorto($articulo->texto); ?></p>
                            <a href="detalle.php?id=<?php echo $articulo->id; ?>" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?> 
        </div>            
    </div>
<?php include("includes/footer.php") ?>
       