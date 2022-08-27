<?php include("includes/header_front.php") ?>

<?php 

    $baseDatos = new Basemysql();

    $db = $baseDatos->connect();

    if(isset($_GET['id'])){
        $idArticulo = $_GET['id'];

        $articulo = new articulo($db);
        $resultado = $articulo->leer_individual($idArticulo);

        $comentarios = new comentario($db);

        $resultado2 = $comentarios->leerPorId($idArticulo);
    }

    if(isset($_POST['enviarComentario'])){
        $idArticulo2 = $_POST['articulo'];
        $email = $_POST['usuario'];
        $comentario = $_POST['comentario'];

        if(empty($email) || $email == "" || empty($idArticulo2) || $idArticulo2 == "" || empty($comentario) || $comentario == "" ){
            $error = "Error, algunos campos estan vacios";
        }else{
            $comentarioObj = new comentario($db);

            if($comentarioObj->crear($email, $comentario, $idArticulo)){
                $mensaje = "Comentario creado correctamente";
                echo ("<script>location.href = '" . RUTA_FRONT . "'</script>");
            }else{
                $error = "Error, no se pudo crear el comentario";
            }
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

    <div class="container-fluid"> 
                
        <div class="row">
        <div class="col-sm-12">
            
        </div>  
    </div>

            <div class="col-sm-12">
                <div class="card">
                   <div class="card-header">
                        <h1><?php echo $resultado->titulo; ?></h1>
                   </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid img-thumbnail" src="<?php echo RUTA_FRONT . "img/articulos/" . $resultado->imagen; ?>">
                        </div>

                        <p><?php echo $resultado->texto; ?></p>

                    </div>
                </div>
            </div>
        </div>  
  
        <?php if(isset($_SESSION['autentication'])) : ?>
            <div class="row">        

            <div class="col-sm-6 offset-3">
            <form method="POST" action="">
                <input type="hidden" name="articulo" value="<?php echo $idArticulo; ?>">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" name="usuario" id="usuario" value="<?php echo $_SESSION['email']; ?>" readonly>               
                </div>
            
                <div class="mb-3">
                    <label for="comentario">Comentario</label>   
                    <textarea class="form-control" name="comentario" style="height: 200px"></textarea>              
                </div>          
            
                <br />
                <button type="submit" name="enviarComentario" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Crear Nuevo Comentario</button>
                </form>
            </div>
            </div>
        <?php endif; ?>
   
    </div>

    <div class="row comentarios">
    <h3 class="text-center mt-5">Comentarios</h3>
        <?php foreach($resultado2 as $comentario) : ?>
            <div class="container-comentario">
                <h4><i class="bi bi-person-circle"></i><?php echo "  " . $comentario->email; ?></h4>
                <p><?php echo $comentario->comentario; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="<?php echo RUTA_FRONT; ?>registro.php" class="btn btn-primary w-100"> Crear un Comentario</a>
         
    </div>
<?php include("includes/footer.php") ?>
       