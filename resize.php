<?php 
 function resize_image($target, $newcopy, $w, $h, $ext){
 	list($w_orig, $h_orig) =  getimagesize($target);
	//a variable to capture the aspect ratio of the image
	$scale_ratio = $w_orig / $h_orig;
	//the w and h are sent from the process script(wmax and hmax values) and are analyzed based on the aspect ratio set in the previous variable
	if($w/$h > $scale_ratio){
		$w = $h * $scale_ratio;
		}else{
			$h = $w / $scale_ratio ;
			}
	$img = "";
	if($ext == "gif" || $ext == "GIF"){
		$img =imagecreatefromgif($target);
		}else if($ext == "png" || $ext =="PNG"){
			$img = imagecreatefrompng($target);
			}else {
				$img = imagecreatefromjpeg($target);
				}
	$tci = imagecreatetruecolor($w, $h);
	imagecopyresampled($tci,$img,0,0,0,0,$w,$h,$w_orig,$h_orig);
	//imagejpeg puts a file on a server
	//imagepng and imagegif are similar functions but more specific to those respective types
	imagejpeg($tci, $newcopy, 80);
 }
