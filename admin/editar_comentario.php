<?php include("../includes/header.php") ?>

<?php 

    $baseDatos = new Basemysql();

    $db = $baseDatos->connect();

    $comentarios = new comentario($db);

    if(isset($_GET['id'])){
        $id = $_GET['id']; 
        $comentario = $comentarios->leer_individual($id);

    }else{
        $error = "Error: Usuario no seleccionado";
    }

    if(isset($_POST['editarComentario'])){
        $id = $_POST['id'];
        $estado = $_POST['cambiarEstado'];

        if($estado == "" || empty($id) || $id == ""){
            $error = "Error, algunos campos estan vacios" . $estado;
        }else{
            if($comentarios->actualizar($id, $estado)){
                $mensaje = "Comentario actualizado correctamente";
                header("Location:comentarios.php?mensaje=" . urlencode($mensaje));
                exit();
            }else{
                $error = "Error, no se pudo actualizar";
            }
        }
    }

    if(isset($_POST['borrarComentario'])){
        $idComentario = $_POST["id"];

        if($comentarios->borrar($idComentario)){
            $mensaje = "Articulo borrado correctamente";
            header("Location:comentarios.php?mensaje=" . urlencode($mensaje));
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
            <h3>Editar Comentario</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action=""> 

            <input type="hidden" name="id" value="<?php echo $comentario->comentario_id; ?>">

            <div class="mb-3">
                <label for="texto">Texto</label>   
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px" readonly>
                <?php echo $comentario->comentario_articulo; ?>
                </textarea>              
            </div>               

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" value="<?php echo $comentario->usuario_email?>" readonly>               
            </div>

            <div class="mb-3">
                <label for="cambiarEstado" class="form-label">Cambiar estado:</label>
                <select class="form-select" name="cambiarEstado" aria-label="Default select example">
                <option value="">--Seleccionar una opción--</option>
                <option value="1">Aprobado</option>
                <option value="0">No Aprobado</option>              
                </select>                 
            </div>  

            <br />
            <button type="submit" name="editarComentario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Comentario</button>

            <button type="submit" name="borrarComentario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Comentario</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>
       