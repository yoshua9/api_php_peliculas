<?php
    class Pelicula{

        // Connection
        private $conn;

        // Table
        private $db_table = "peliculas";

        // Data Price
        public $precio_unitario = 3;

        // Columns
        public $id;
        public $name;
        public $type;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getPeliculas(){
            $sqlQuery = "SELECT id, name, type FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createPelicula(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        type = :type";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->type=htmlspecialchars(strip_tags($this->type));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":type", $this->type);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getTypePelicula(){
            $sqlQuery = "SELECT
                    id, 
                    name, 
                    type
                  FROM
                    ". $this->db_table ."
                WHERE 
                   type LIKE ". $this->type;

            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $data= [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $e = array(
                    "id" => $id,
                    "name" => $name,
                    "type" => $type
                );
                array_push($data, $e);
            }

            return $data;
        }   

        // UPDATE
        public function getPeliculasByIds($days){
            $sqlQuery = "SELECT
                    id, 
                    name, 
                    type
                  FROM
                    ". $this->db_table ."
                WHERE 
                   id IN (". $this->ids.")";

            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $data= [];
            $price = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                if($type == "Películas viejas"){
                    if($days <= 5){
                        $price = $this->precio_unitario;
                    }else{
                        $price = ($days-3) * $this->precio_unitario + $this->precio_unitario;
                    }
                }else if($type == "Películas normales"){
                    if($days <= 3){
                        $price = $this->precio_unitario;
                    }else{
                        $price = ($days-3) * $this->precio_unitario + $this->precio_unitario;
                    }
                }else{
                    $price=$days*$this->precio_unitario;
                }

                $e = array(
                    "id" => $id,
                    "name" => $name,
                    "type" => $type,
                    "price" => $price,
                    "days" => $days
                );
                array_push($data, $e);
            }

            return $data;
        } 

        // UPDATE
        public function updatePelicula(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        type = :type, 
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->type=htmlspecialchars(strip_tags($this->type));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":type", $this->type);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deletePelicula(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>

