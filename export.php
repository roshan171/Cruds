<?php

include 'config.php';

 if(isset($_POST["Export"])){
     
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=mydata.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('ID', 'Username', 'Email', 'Password', 'Mobile'));  
      $query = "SELECT * from details";  
      $result = mysqli_query($conn, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 } 
?>