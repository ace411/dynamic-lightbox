<?php 

require "connect.php";

try {

     $sql_create = "CREATE TABLE images( 
                    id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                    image_url VARCHAR(60) NOT NULL,
                    enlarged_url VARCHAR(60) NOT NULL
                    )";

     $conn = $db->prepare($sql_create);

     $conn = $db->execute();

     echo "Table created successfully.";              

}catch(PDOException $ex){

    exit("Failed to create a table!");

}
?>
