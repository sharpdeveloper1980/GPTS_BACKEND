<?php
if(isset($_POST["submit"]))
{

                $url='localhost';
                $username='root';
                $password='';
                //$conn=mysqli_connect($url,$username,$password,"location");
        //   if(!$conn){
        //   die('Could not Connect My Sql:' .mysqli_error());
		//   }
          $file = $_FILES['file']['tmp_name'];
          $handle = fopen($file, "r");
          $c = 0;
          while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
            {
             
            $fname = $filesop[0];
            echo $fname;
            //$lname = $filesop[1];
            $c = $c + 1;

           }

        //     if($sql){
        //        echo "sucess";
        //      } 
		//  else
		//  {
        //     echo "Sorry! Unable to impo.";
        //   }

}
?>
<!DOCTYPE html>
<html>
<body>
<form enctype="multipart/form-data" method="post" role="form">
    <div class="form-group">
        <label for="exampleInputFile">File Upload</label>
        <input type="file" name="file" id="file" size="150">
        <p class="help-block">Only Excel/CSV File Import.</p>
    </div>
    <button type="submit" class="btn btn-default" name="submit" value="submit">Upload</button>
</form>
</body>
</html>