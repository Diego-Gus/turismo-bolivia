<?php include("../includes/header.php") ?>

<?php 

    $baseDatos = new Basemysql();

    $db = $baseDatos->connect();

    $usuarios = new usuario($db);

    $roles = $usuarios->leer_roles();

    if(isset($_GET['id'])){
        $id = $_GET['id']; 
        $usuario = $usuarios->leer_individual($id);
    }else{
        $error = "Error: Usuario no seleccionado";
    }

    if(isset($_POST['editarUsuario'])){
        $email = $_POST['email'];
        $nombre = $_POST['nombre'];
        $rolId = $_POST['rol'];
        $id = $_POST['id'];

        if(empty($id)  || $id == "" || empty($nombre) || $nombre == "" || empty($email)  || $email == "" || empty($rolId) || $rolId == ""){
            $error = "Error, algunos campos estan vacios";
        }else{
            if($usuarios->actualizar($id, $nombre, $email, $rolId)){
                $mensaje = "Usuario actualizado correctamente";
                header("Location:usuarios.php?mensaje=" . urlencode($mensaje));
                exit();
            }else{
                $error = "Error, no se pudo actualizar";
            }
        }
    }

    if(isset($_POST['borrarUsuario'])){
        $idUsuario = $_POST["id"];

        if($comentarios->borrar($idUsuario)){
            $mensaje = "Articulo borrado correctamente";
            header("Location:usuarios.php?mensaje=" . urlencode($mensaje));
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
            <h3>Editar Usuario</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="">

            <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" value="<?php echo $usuario->nombre; ?>">              
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email" value="<?php echo $usuario->email; ?>">               
            </div>
            <div class="mb-3">
            <label for="rol" class="form-label">Rol:</label>
            <select class="form-select" aria-label="Default select example" name="rol">
                <option value="">--Selecciona un rol--</option>
                <?php foreach($roles as $fila) : ?>
                    <?php if($fila->id == $usuario->rol_id){?>
                        <option value="<?php echo $fila->id; ?>" selected ><?php echo $fila->nombre;?></option>
                    <?php }else{ ?>
                        <option value="<?php echo $fila->id; ?>"><?php echo $fila->nombre;?></option>
                    <?php } ?>
                <?php endforeach; ?>
            </select>             
            </div>          
        
            <br />
            <button type="submit" name="editarUsuario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Usuario</button>

            <button type="submit" name="borrarUsuario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Usuario</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>
       