<?php 

    class Usuario{
        private $conn;
        private $table = "usuarios";

        public $id;
        public $nombre;
        public $email;
        public $password;
        /* public $rol_id; */
        public $fecha_creacion;

        public function __construct($db){
            $this->conn = $db;
        }

        //leer articulos
        public function leer(){
            $query = "SELECT u.id AS usuario_id, u.nombre AS usuario_nombre, u.email AS usuario_email, r.nombre AS usuario_rol, u.fecha_creacion AS usuario_fecha_creacion FROM " . $this->table . " u INNER JOIN roles r ON r.id = u.rol_id;";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $usuarios;
        }

        public function leer_roles(){
            $query = "SELECT * FROM roles;";

            $stmt = $this->conn->query($query);

            $roles = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $roles;

        }  

        public function leer_individual($id){
            $query = "SELECT id, nombre, email, rol_id FROM " . $this->table . " WHERE id= ? LIMIT 0,1" ;

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1,$id,PDO::PARAM_STR);
            
            $stmt->execute();

            $articulos = $stmt->fetch(PDO::FETCH_OBJ);

            return $articulos;
        }

        public function validar_email($email){
            $query = "SELECT * FROM " . $this->table . " WHERE email = :email;";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            $resultado = $stmt->execute();

            $registroEmail = $stmt->fetch(PDO::FETCH_ASSOC);

            if($registroEmail){
                //El email ya existe
                return false;
            }else{
                //El email no existe
                return true;
            }
        }

        public function acceder_rol($email){
            $query = "SELECT rol_id FROM " . $this->table . " WHERE email = :email;";
            
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            $resultado = $stmt->execute();

            $registroRol = $stmt->fetch(PDO::FETCH_OBJ);

            return $registroRol;
        }

        public function acceder($email, $password){
            $query = "SELECT * FROM " . $this->table . " WHERE email = :email AND password = :password;";

            $passwordEncript = md5($password);

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $passwordEncript, PDO::PARAM_STR);

            $resultado = $stmt->execute();

            $existeUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if($existeUsuario){
                //El email ya existe
                return true;
            }else{
                //El email no existe
                return false;
            }
        }

        public function registrar($nombre, $email, $password){
            $query = 'INSERT INTO ' . $this->table . ' (nombre, email, password, rol_id) VALUES (:nombre, :email, :password, 2);';
        
            //Encriptar el password MD%

            $passwordEncript = md5($password);
            
            $stmt = $this->conn->prepare($query);


            $stmt->bindParam(':nombre', $nombre,PDO::PARAM_STR);
            $stmt->bindParam(':email', $email,PDO::PARAM_STR);
            $stmt->bindParam(':password', $passwordEncript,PDO::PARAM_STR);
            
            if($stmt->execute()){
                return true;
            }

            printf("error $s\n", $stmt->error);

        }

        public function actualizar($id, $nombre, $email, $rol_id){
            $query = 'UPDATE ' . $this->table . ' SET nombre = :nombre, email = :email, rol_id = :rol_id WHERE id = :id;';
                
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':nombre',$nombre,PDO::PARAM_STR);
            $stmt->bindParam(':email',$email,PDO::PARAM_STR);
            $stmt->bindParam(':rol_id',$rol_id,PDO::PARAM_STR);
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


