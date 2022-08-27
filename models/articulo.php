<?php 

    class Articulo{
        private $conn;
        private $table = "articulos";

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
            $query = "SELECT id, titulo, imagen, texto, fecha_creacion FROM " . $this->table;

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $articulos = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $articulos;
        }

        public function leer_individual($id){
            $query = "SELECT id, titulo, imagen, texto, fecha_creacion FROM " . $this->table . " WHERE id= ? LIMIT 0,1" ;

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1,$id,PDO::PARAM_STR);
            
            $stmt->execute();

            $articulos = $stmt->fetch(PDO::FETCH_OBJ);

            return $articulos;
        }

        public function crear($titulo, $imagen, $texto){
            $query = 'INSERT INTO ' . $this->table . '(titulo, imagen, texto) VALUES (:titulo, :imagen, :texto);';
        
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':titulo',$titulo,PDO::PARAM_STR);
            $stmt->bindParam(':imagen',$imagen,PDO::PARAM_STR);
            $stmt->bindParam(':texto',$texto,PDO::PARAM_STR);
            
            if($stmt->execute()){
                return true;
            }

            printf("error $s\n", $stmt->error);

        }

        public function actualizar($id, $titulo, $imagen, $texto){
            
            if($imagen == ""){
                $query = 'UPDATE ' . $this->table . ' SET titulo = :titulo, texto = :texto WHERE id = :id;';
                
                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':titulo',$titulo,PDO::PARAM_STR);
                $stmt->bindParam(':texto',$texto,PDO::PARAM_STR);
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);

                if($stmt->execute()){
                    return true;
                }
            }else{
                $query = 'UPDATE ' . $this->table . ' SET titulo = :titulo, texto = :texto, imagen = :imagen WHERE id = :id;';
                
                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':titulo',$titulo,PDO::PARAM_STR);
                $stmt->bindParam(':texto',$texto,PDO::PARAM_STR);
                $stmt->bindParam(':imagen',$imagen,PDO::PARAM_STR);
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);

                if($stmt->execute()){
                    return true;
                }
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


