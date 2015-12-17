<?php
     require "connect.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dynamic lightbox</title>
	<link rel="stylesheet" type="text/css" href="lightbox.css">
</head>
<body>
    <div id="place"></div>
    <?php
    //this is to get the thumbnail and enlarged image url's from the database 
    $query = "SELECT id, image_url, enlarged_url FROM images";
    try{
    	
      $stmt = $db->prepare($query);
    	
      $stmt->execute();
    	
      $total = $stmt->rowCount();

    }catch(PDOException $ex){
    	
      exit("Cannot connect!");
    }
    $rows = $stmt->fetchAll();
    ?>
    <?php if($total < 0):?>
    	<h2 align="center">No images present</h2>
    <?php else:?>	
    <ul class="image-list">
    <?php foreach($rows as $row):?>
      <li id="inner-list">
          <a href="#overlay_<?php echo htmlentities($row['id'], ENT_QUOTES, 'UTF-8');?>">
           <img src="<?php echo htmlentities($row['image_url'], ENT_QUOTES, 'UTF-8');?>" 
           onclick="enlarge_image('<?php echo htmlentities($row['enlarged_url'], ENT_QUOTES, 'UTF-8');?>')">
          </a> 
      </li>
      <div class="overlay_box" id ="overlay_<?php echo htmlentities($row['id'], ENT_QUOTES, 'UTF-8');?>">
            <img id="l_img" src="<?php echo htmlentities($row['enlarged_url'], ENT_QUOTES, 'UTF-8');?>">    
          <a id="cancel" href="#" >X</a>  
      </div>    
	<?php endforeach;?>
	</ul>
	<?php endif;?>  
	<script type="text/javascript">
       var box, place;
       function enlarge_image(url){
       	      box = document.getElementById('overlay_box');
       	      var place = document.getElementById('l_img');
       	      place.innerHTML = "<img src='" + url + "'>";      	      
       }
	</script>	
</body>
</html>
