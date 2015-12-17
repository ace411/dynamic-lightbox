<?php 

require "connect.php";

if(!empty($_FILES["files"]["name"][0])){
	//this is to check if at least one file has been uploaded
	$files = isset($_FILES["files"]) ? $_FILES["files"]:"";
//this is to hold the files that have been successfully uploaded
	$uploaded = array();
//this is to hold the files that have not been uploaded
	$failed = array();
//acceptable formats
	$allowed_formats = array('jpg', 'png', 'gif');

foreach($files["name"] as $filepos => $filename){ //filepos is the position of the file in the array
     
 $file_tmp_name = $files["tmp_name"][$filepos];

 $file_size = $files["size"][$filepos];
 
 $file_error = $files["error"][$filepos]; //boolean value

 $file_ext = explode(".", $filename);
 //this is to extract the file extension
 $file_ext = strtolower(end($file_ext)); 
 //this is to extract the file extension as a lowercase string
 if(in_array($file_ext, $allowed_formats)){ 
 //this is to validate the file types of the uploaded files           
   if($file_error === 0){
 //this is to validate the file error type. 1 for not uploaded and 0 for uploaded    
     if($file_size  <= 2500000){
 //Max size is 2.4MB. Check your php.ini file to change the size of the image
     	$new_name = $files["name"][$filepos].'.'. $file_ext;
 //the new names of the files is the original names so that the files can be overwritten
     	$path = "files/".$new_name."";
 //this is the path to the files in the directory
     	if(move_uploaded_file($file_tmp_name, $path)){
 //add the uploaded files to the listed path 
     		$uploaded[$filepos] = $path;
 //the resize.php script has the resize function
     		require_once "resize.php";
 //the resized path is the equivalent of the file path
     		$resized_path = "files/resized_".$new_name;
 
     		$resized_width = 250;

     		$resized_height = 250;
 //call the resize_image function to resize the images on the fly
     		resize_image($path, $resized_path, $resized_width, $resized_height, $file_ext);
 //this is to enter the path data in the database
     		$query = "INSERT INTO images(enlarged_url, image_url) 
	             	  VALUES(:enlarged, :image)
     		         ";
     		$params = array(":enlarged" => $path, ":image" => $resized_path);
     		         
         		try{

         			$stmt  = $db->prepare($query);

         			$stmt->execute($params);

         		}catch(PDOException $ex){
                    
                    exit("Cannot save the selected files.");
         		}

         	}else {
         		//tell the user they've failed
         		$failed[$filepos] = "[{$filename}] could not be uploaded";
         	}

         }else {
            //image size constraints
            $failed[$filepos] = "[{$filename}] cannot be uploaded. Image is too large";

         }
         
       }else {
        //image error check from the boolean value
         $failed[$filepos] = "[{$filename}] cannot be uploaded. Error {'$file_error'}";

       }

     }else {
       //file is of the wrong format
     	$failed[$filepos] = "[{$filename}] of type '{$file_ext}' cannot be uploaded";
     }

     }
     
     if(!empty($uploaded)){
     	
    echo "You have successfully uploaded the following files:";

     	foreach($uploaded as $upload){
               
               echo '<pre>'.$upload.'</pre>';
     	}
     	
     }

     if(!empty($failed)){
     	
    echo "You have failed to upload the following files:";
     	
     	foreach($failed as $fail){
                                  
     		   echo '<pre>'.$fail.'</pre>';
     	}

     }

}else {
   //tell the user that they cannot upload a file
	exit("Please upload a file");

   }
?>
