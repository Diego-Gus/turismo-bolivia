<?php  include 'config/config.php' ?>
<?php  include 'config/Basemysql.php' ?>
<?php  include 'helpers/helper_formatos.php' ?>
<?php  include 'models/articulo.php' ?>
<?php  include 'models/comentario.php' ?>
<?php  include 'models/usuario.php' ?>

<?php 
  session_start();
?>

<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <link rel="stylesheet" href="css/bootstrap-icons-1.2.1/font/bootstrap-icons.css">

    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/estilos.css">

    <title>Blog Turismo Bolivia</title>
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="<?php echo RUTA_FRONT; ?>index.php">Blog - Lugares Turisticos de Bolivia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0"> 
                
            <?php if(isset($_SESSION['autentication'])) : ?> 
                    
              <?php if($_SESSION['rol'] == 1) :?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Administración </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li>
                        <a class="dropdown-item" href="<?php echo RUTA_ADMIN; ?>articulos.php">Artículos</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="<?php echo RUTA_ADMIN; ?>comentarios.php">Comentarios</a>
                      </li>                        
                    </ul>
                </li> 
                    
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo RUTA_ADMIN; ?>usuarios.php">Usuarios</a>
                </li> 
              <?php endif; ?>

            <?php endif; ?> 
          </ul>  
          <ul class="navbar-nav mb-2 mb-lg-0">                       
            <li class="nav-item">
              <a class="nav-link" href="<?php echo RUTA_FRONT; ?>">Inicio</a>
            </li> 
            <?php if(!isset($_SESSION['autentication'])) : ?> 

              <li class="nav-item">
                <a class="nav-link" href="<?php echo RUTA_FRONT; ?>registro.php">Registrarse</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo RUTA_FRONT; ?>acceder.php">Acceder</a>
              </li>
                   
            <?php endif; ?>
                        
            <?php if(isset($_SESSION['autentication'])) : ?> 
              <li class="nav-item">
                <p class="text-white mt-2"><i class="bi bi-person-circle"></i><?php echo $_SESSION['email']; ?></p>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="salir.php">Salir</a>
              </li>  
            <?php endif; ?>         
          </ul>    
        </div>
      </div>
  </nav>

  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
      <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
      <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
      <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="http://turismo-bolivia.rf.gd/img/slides/lugares_turisticos_bolivia.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block caja2">
          <h5>Lugares turisticos de Bolivia</h5>
          <p>Lugares turisticos en los nueve departamentos de Bolivia.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="http://turismo-bolivia.rf.gd/img/slides/bolivia-fantastico.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block caja2" >
          <h5>Un Viaje se vive tres veces</h5>
          <p>Cuando lo soñamos, cuando lo vivimos, cuando lo recordamos.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="http://turismo-bolivia.rf.gd/img/slides/bolivia_te_espera.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block caja2">
          <h5>Una ves al año, ve a un lugar donde nunca hayas estado antes</h5>
          <p>BOLIVIA TE ESPERA.</p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </a>
  </div>

  <div class="container mt-5">