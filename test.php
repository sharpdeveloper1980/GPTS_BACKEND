<?php
	ini_set('max_execution_time', 0);
	
	if(isset($_POST['sbtupload'])){

		print_r($_FILES);
		echo "<br>";
        print_r($_FILES['file_name']['size']);
        echo "<br>";
        print_r($_FILES['file_name']['name']);   
        echo "<br>";
        print_r($_FILES['file_name']['error']);   
        die();
        echo "<script>location.href='test.php'</script>";
    }
?>
<form action="#" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="100000000000000" /> 
	
    <input type="file" name="file_name" value=""><br><br>
    <input type="submit" name="sbtupload" value="Upload">
</form>