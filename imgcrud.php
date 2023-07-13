<?php  
require_once 'constant.php';
error_reporting(0);

// Insert Query 

if (isset($_POST['submit'])) {
	$name=str_replace(" ","",$_POST['name']);
	$email=str_replace(" ","",$_POST['email']);
	$mobile=str_replace(" ","",$_POST['mobile']);

	$image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_tmp, "images/" . $image_name);

	$sql=mysqli_query($conn,"INSERT INTO `imgcrud`( `name`, `email`, `mobile`, `image`) VALUES ('$name','$email','$mobile','$image_name')");
	
	if ($sql) {
		// die("Data Not Inserted".mysql_error($conn));
		 echo "<script>alert(' data inserted successfully')</script>";

	}
header('location:imgcrud.php');
    exit;

}



// Update Query 

if (isset($_POST['Update'])) {
	$id=$_POST['id'];
	$name=str_replace(" ","",$_POST['name']);
	$email=str_replace(" ","",$_POST['email']);
	$mobile=str_replace(" ","",$_POST['mobile']);

	$image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_tmp, "images/" . $image_name);

	$sql=mysqli_query($conn,"UPDATE `imgcrud` SET `id`='$id',`name`='$name',`email`='$email',`mobile`='$mobile',`image`='$image_name' WHERE id='$id'");
	
	if ($sql) {
		// die("Data Not Inserted".mysql_error($conn));
		 echo "<script>alert(' data updated successfully')</script>";

	}
	  header('location:imgcrud.php');
    exit;


}

// Delete Query


if (isset($_GET['id'])) {
	$id=$_GET['id'];
	$sql="DELETE FROM `imgcrud` WHERE id='$id'";
	$result=$conn->query($sql);
	if ($result) {
		echo "<script type=\"text/javascript\">
              alert(\"Data deleted Successfully\");
              window.location = \"imgcrud.php\"
              </script>";
	}
	else{
    die(mysqli_error($conn));
  }

}





?>




<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Crud</title>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js">
<style type="text/css">
	



</style>
</head>
<body>
	<h2 class="text-center">Image Crud</h2>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary m-5" data-toggle="modal" data-target="#addmodal" >
  Add Form
</button>

<!-- Modal -->
<div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<form action="" method="POST" enctype="multipart/form-data">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Name</label>
      <input type="text" class="form-control" name="name" id="inputEmail4">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Email</label>
      <input type="text" class="form-control" name="email" id="inputPassword4">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Mobile</label>
    <input type="text" class="form-control" name="mobile" id="inputAddress" placeholder="">
  </div>
   <div class="form-group">
    <label for="exampleFormControlFile1">Image Upload</label>
    <input type="file" class="form-control-file" name="image" id="exampleFormControlFile1">
  </div>

  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Save</button>
</form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>



<!-- Edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<form action="" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id" id="id">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Name</label>
      <input type="text" class="form-control" name="name" id="name">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Email</label>
      <input type="text" class="form-control" name="email" id="email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Mobile</label>
    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="">
  </div>
   <div class="form-group">
    <label for="exampleFormControlFile1">Image Upload</label>
    <input type="file" class="form-control-file" name="image" id="image">
  </div>

  
  <button type="submit" class="btn btn-success" name="Update">Update</button>
</form>
      </div>
      
    </div>
  </div>
</div>



<!-- View Modal -->
<div class="modal fade" id="viewmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<form action="" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" id="id1">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Name</label>
      <input type="text" class="form-control" name="name" id="name1" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Email</label>
      <input type="text" class="form-control" name="email" id="email1" readonly>
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Mobile</label>
    <input type="text" class="form-control" name="mobile" id="mobile1" readonly>
  </div>
   <div class="form-group">
    <label for="exampleFormControlFile1">Image Upload</label>
    <input type="file" class="form-control-file" name="image" id="image1" disabled>
  </div>

  
  <button type="submit" class="btn btn-success" name="Update">Update</button>
</form>
      </div>
      
    </div>
  </div>
</div>


<table class="table">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Mobile</th>
      <th scope="col">Image</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
<?php 
// require_once 'constant.php'; 
  	 $sql = "SELECT * FROM `imgcrud` ";
  $result = mysqli_query($conn, $sql);
  $i=1;
  ?>
  <?php
        while($data = mysqli_fetch_assoc($result)){
         ?>
   <tr id=<?php echo $data['id'];?>>
   	<td> <?php echo $i++; ?></td>
   <td> <?php echo $data["name"]; ?></td>
    <td> <?php echo $data["email"]; ?></td>
    <td> <?php echo $data["mobile"]; ?></td>
    <td width="80"><img src="images/<?php echo $data['image']; ?>" width="50" height="50"></td>
    	



     <td class="actions ">
     <a href=""  data-toggle="modal" data-target="#editmodal"  class=" btn btn-success editbtn"><i class="fas fa-edit"></i></a>

      <a href="imgcrud.php?id=<?php echo $data['id'];?>" class="btn btn-danger trash m-1"><i class="fas fa-trash" ></i></a>

       <a href="" data-toggle="modal" data-target="#viewmodal" class=" btn btn-secondary viewbtn" name="viewbtn"><i class="fas fa-eye"></i> </a>
                </td>

            <?php  }
            ?>
    </tr>
  </tbody>
</table>





<script type="text/javascript">
	

$(document).ready(function () {
$('.editbtn').on('click',function(){
$tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {

            return $(this).text();

        }).get();

        console.log(data);
        $('#id').val(data[0]);
         $('#name').val(data[1]);
           $('#email').val(data[2]);
             $('#mobile').val(data[3]);
               $('#image').val(data[4]);
               
                  
                       
});

$('.viewbtn').on('click',function(){
$tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {

            return $(this).text();

        }).get();

        console.log(data);
        $('#id1').val(data[0]);
         $('#name1').val(data[1]);
           $('#email1').val(data[2]);
             $('#mobile1').val(data[3]);
               $('#image1').val(data[4]);
               
                  
                       
});
});



</script>




</body>
</html>