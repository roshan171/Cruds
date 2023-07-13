 <?php
include_once 'config.php';

 if(isset($_POST["Import"])){
    
    $filename=$_FILES["file"]["tmp_name"];    
     if($_FILES["file"]["size"] > 0)
     {
        $file = fopen($filename, "r");
          while (($getData = fgetcsv($file, 100000, ",")) !== FALSE)
           {
             $sql = "INSERT into details(username,email,password,mobile) 
                   values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."')";
                   $result = mysqli_query($conn, $sql);
        if(!isset($result))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"csv.php\"
              </script>";    
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"view.php\"
          </script>";
        }
           }
      
           fclose($file);  
     }
  }   
?>