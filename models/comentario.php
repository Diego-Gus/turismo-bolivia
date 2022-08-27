<?php 

    class Comentario{
        private $conn;
        private $table = "comentarios";

        public $id;
        public $titulo;
        public $imagen;
        public $texto;
        public $fecha_creacion;

        public function __construct($db){
            $this->conn = $db;
        }

        //leer articulos
        public function leer(){
            $query = "SELECT c.id AS comentario_id, c.comentario AS comentario_articulo, u.email AS usuario_email, a.titulo AS titulo_articulo, c.estado , c.fecha_creacion FROM " . $this->table . " c LEFT JOIN usuarios u ON u.id = c.usuario_id LEFT JOIN articulos a ON c.articulo_id = a.id;";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $comentarios = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $comentarios;
        }

        public function leer_individual($id){
            $query = "SELECT c.id AS comentario_id, c.comentario AS comentario_articulo, u.email AS usuario_email, a.titulo AS titulo_articulo, c.estado , c.fecha_creacion FROM " . $this->table . " c INNER JOIN usuarios u ON u.id = c.usuario_id INNER JOIN articulos a ON c.articulo_id = a.id WHERE c.id = ? LIMIT 0,1;" ;

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1,$id,PDO::PARAM_STR);
            
            $stmt->execute();

            $comentarios = $stmt->fetch(PDO::FETCH_OBJ);

            return $comentarios;
        }

        public function leerPorId($idArticulo){
            $query = "SELECT c.comentario, u.email FROM " . $this->table ." c INNER JOIN usuarios u ON u.id = c.usuario_id WHERE articulo_id = :articulo_id && estado = 1";
            /* $query = "SELECT c.id AS id_comentario, c.comentario AS comentario, c.estado AS estado, c.fecha_creacion AS fecha, c.usuario_id, u.email AS nombre_usuario FROM " . $this->table . " c INNER JOIN usuarios u ON u.id = c.usuario_id WHERE articulo_id = :articulo_id ";
            */ 
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":articulo_id",$idArticulo,PDO::PARAM_INT);
            
            $stmt->execute();

            $comentarios = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $comentarios;
        }

        public function crear($email, $comentario, $idArticulo){
            //obtener el id del usuario
            $query = "SELECT * FROM usuarios WHERE email = :email";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);

            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_OBJ);
            $idUsuario = $usuario->id;

            $query2 = 'INSERT INTO ' . $this->table . '(comentario, usuario_id, articulo_id, estado) VALUES (:comentario, :usuario_id, :articulo_id, 0);';
        
            $stmt = $this->conn->prepare($query2);

            $stmt->bindParam(':comentario',$comentario,PDO::PARAM_STR);
            $stmt->bindParam(':usuario_id',$idUsuario,PDO::PARAM_INT);
            $stmt->bindParam(':articulo_id',$idArticulo,PDO::PARAM_INT);
            
            if($stmt->execute()){
                return true;
            }
            printf("error $s\n", $stmt->error);
        }

        public function actualizar($id, $estado){
            
            $query = 'UPDATE ' . $this->table . ' SET estado = :estado WHERE id = :id;';
                
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':estado',$estado,PDO::PARAM_INT);
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);

            if($stmt->execute()){
                return true;
            }

            printf("error $s\n", $stmt->error);

        }

        public function borrar($id){
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                return true;
            }

            printf("error $s\n", $stmt->error);

        }

    }

?>


