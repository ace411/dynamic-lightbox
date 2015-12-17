<!DOCTYPE html>
<html>
<head>
	<title>Upload an image</title>
	<link rel="stylesheet" type="text/css" href="css/lightbox.css">
</head>
<body>
<h2 align="center">File upload script</h2>
<form action="file-upload.php" method="post" id="upload_form" enctype="multipart/form-data">
    <fieldset>
		<input type="file" name="files[]" class="upload_img" multiple>
		<input type="submit" value="Upload image">
    </fieldset>
</form>
</body>
</html>
