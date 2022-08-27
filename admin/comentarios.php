<?php include("../includes/header.php") ?>

<?php 

    $baseDatos = new Basemysql();

    $db = $baseDatos->connect();

    $comentarios = new comentario($db);

    $resultado = $comentarios->leer();

?>

<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Comentarios</h3>
    </div>       
</div>
<div class="row mt-2 caja">
    <div class="col-sm-12">
            <table id="tblContactos" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Comentario</th>
                        <th>Usuario</th>
                        <th>Artículo</th>
                        <th>Estado</th>
                        <th>Fecha de creación</th>                                          
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultado as $comentario) :?>
                        <tr>
                            <td><?php echo $comentario->comentario_id; ?></td>
                            <td><?php echo $comentario->comentario_articulo; ?></td>
                            <td><?php echo $comentario->usuario_email; ?></td>
                            <td><?php echo $comentario->titulo_articulo; ?></td>    
                            <td><?php echo $comentario->estado; ?></td>                      
                            <td><?php echo $comentario->fecha_creacion; ?></td>                      
                            <td>
                                <a href="editar_comentario.php?id=<?php echo $comentario->comentario_id; ?>" class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>                       
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>       
            </table>
    </div>
</div>
<?php include("../includes/footer.php") ?>

<script>
    $(document).ready( function () {
        $('#tblContactos').DataTable();
    });
</script>