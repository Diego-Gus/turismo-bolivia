<?php include("../includes/header.php") ?>

<?php 

    $baseDatos = new Basemysql();

    $db = $baseDatos->connect();

    if(isset($_GET['id'])){
        $id = $_GET['id'];    
        
        $articulos = new articulo($db);
        
        $resultado = $articulos->leer_individual($id);
    }

    if(isset($_POST['editarArticulo'])){
        $titulo = $_POST['titulo'];
        $texto = $_POST['texto'];
        $id = $_POST['id'];

        if($_FILES['imagen']['error'] > 0){
            if(empty($titulo)  || $titulo == "" || empty($texto) || $texto == ""){
                $error = "Error, algunos campos estan vacios";
            }else{
    
                $articulos = new articulo($db);

                $imagen = "";

                if($articulos->actualizar($id, $titulo, $imagen, $texto)){
                    $mensaje = "Articulo actualizado correctamente";
                    header("Location:articulos.php?mensaje=" . urlencode($mensaje));
                    exit();
                }else{
                    $error = "Error, no se pudo actualizar";
                }
            }
        }else{
            if(empty($titulo)  || $titulo == "" || empty($texto) || $texto == ""){
                $error = "Error, algunos campos estan vacios";
            }else{
                $image = $_FILES['imagen']['name'];
                $imageArr = explode('.', $image);

                $rand = rand(1000, 99999);

                $newImageName = $imageArr[0] . $rand . '.' . $imageArr[1];

                $rutaFinal = "../img/articulos/" . $newImageName;
                
                move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFinal);

                $articulos = new articulo($db);

                if($articulos->actualizar($id, $titulo, $newImageName, $texto)){
                    $mensaje = "Articulo actualizado correctamente";
                    header("Location:articulos.php?mensaje=" . urlencode($mensaje));
                }else{
                    $error = "Error, no se pudo actualizar";
                }
            }
        }
    }

    if(isset($_POST['borrarArticulo'])){
        $idArticulo = $_POST['id'];
        
        $articulos = new articulo($db);

        if($articulos->borrar($id)){
            $mensaje = "Articulo borrado correctamente";
            header("Location:articulos.php?mensaje=" . urlencode($mensaje));
        }else{
            $error = "Error, no se pudo borrar el articulo";
        }
    }

?>


<div class="row">
        <div class="col-sm-12">
            <?php if(isset($error)) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?php echo $error; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>    
    </div>

<div class="row">
        <div class="col-sm-6">
            <h3>Editar Artículo</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $resultado->id; ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $resultado->titulo; ?>">               
            </div>

            <div class="mb-3">
                <img class="img-fluid img-thumbnail" src="<?php echo RUTA_FRONT . "img/articulos/" . $resultado->imagen; ?>">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Selecciona una imagen">               
            </div>
            <div class="mb-3">
                <label for="texto">Texto</label>   
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px">
                    <?php echo $resultado->texto; ?>
                </textarea>              
            </div>          
        
            <br />
            <button type="submit" name="editarArticulo" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Artículo</button>

            <button type="submit" name="borrarArticulo" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Artículo</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>