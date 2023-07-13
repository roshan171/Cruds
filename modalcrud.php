<?php 
include_once 'config.php';


//Update Query

if(isset($_POST['updatedata'])){
   //  print_r($_POST);
   // echo "point!"; exit;

 $id=$_POST['id'];
 $reference_id = $_POST['reference_id'];
   $order_id = $_POST['order_id'];
   $first_name = $_POST['first_name'];
   $last_name = $_POST['last_name'];
 $status=$_POST['status'];



 $sql = mysqli_query($conn,"UPDATE `modalcrud` SET id='$id', reference_id='$reference_id',order_id='$order_id',first_name='$first_name',last_name='$last_name',status='$status' WHERE id='$id'")or die(mysqli_error($conn));
    

     if($sql){
        echo "<script type=\"text/javascript\">
              alert(\"Data Updated Successfully\");
              window.location = \"modalcrud.php\"
              </script>"; 
      }
      else{
       echo "Data not Updated".mysql_error($conn);
    }
       // header('location:crm.php');
   //exit;
      }




// Insert Query

if(isset($_POST['submit'])){
  $reference_id=$_POST['reference_id'];
  $order_id=$_POST['order_id'];
  $first_name=$_POST['first_name'];
  $last_name=$_POST['last_name'];
  $status=$_POST['status'];

      $sql= mysqli_query($conn,"INSERT INTO modalcrud (`reference_id`,`order_id`,`first_name`,`last_name`,`status`)VALUES('$reference_id','$order_id','$first_name','$last_name','$status')") or die(mysqli_error($conn));

     if($sql){
        echo "<script type=\"text/javascript\">
              alert(\"Data Inserted Successfully\");
              window.location = \"modalcrud.php\"
              </script>"; 
      }
      else{
       echo "Data not Inserted".mysql_error($conn);
    }
  //  header('location:crm.php');
    //exit;
      }


// Delete Data 

if (isset($_GET['id'])) {
  $id=$_GET['id'];

  $sql = "DELETE FROM modalcrud WHERE id='$id'";
  $result=$conn->query($sql);

  if ($result) {
    echo "<script type=\"text/javascript\">
              alert(\"Data deleted Successfully\");
              window.location = \"modalcrud.php\"
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
  <title>Crud Using Modal</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
</head>
<body>

<div class="conatiner m-3">
<div class="" style="height:50px;border-radius: 5px; background-color: #008b76;">
  <h5 class="p-2 text-white ml-2">Crud With Modal</h5>
</div>


<div class="m-3 " style="float: right; padding-right: 250px">
  <div class="table-group mt-2 mb-2">
             

              <input type="text" class="searchbox mr-2" name="search" value="" id="search">

<a href="#"><button type="button" class="btn btn-primary m-0">Search</button></a>
<a href="#"><button type="button" class="btn btn-danger m-0" onclick="document.getElementById('myInput').value=''">Clear</button></a>
<a href="#"><button type="button" class="btn btn-info m-0" data-toggle="modal" data-target="#addModal"> Add Form</button></a>
<a href="#"><button type="button" class="btn btn-success m-0"> Done</button></a>
<a href="#"><button type="button" class="btn btn-danger m-0"> Pending</button></a>
</div>
</div>

<table class="table" id="myTable">
  <thead class=" text-dark" style="border-radius: 5px;background-color:#a0c8c3" >
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Reference Id</th>
      <th scope="col">Order Id</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>


        <?php
        //require 'constant.php';
        

         $showRecordPerPage = 5;
  if(isset($_GET['page']) && !empty($_GET['page'])){
  $currentPage = $_GET['page'];
  }
  else
  {
  $currentPage = 1;
  }
  $startFrom = ($currentPage * $showRecordPerPage) - $showRecordPerPage;
  $totalEmpSQL = "SELECT * FROM modalcrud";
  $allEmpResult = mysqli_query($conn, $totalEmpSQL);
  $totalEmployee = mysqli_num_rows($allEmpResult);
  $lastPage = ceil($totalEmployee/$showRecordPerPage);
  $firstPage = 1;
  $nextPage = $currentPage + 1;
  $previousPage = $currentPage - 1;
  $empSQL = "SELECT id,reference_id, order_id, first_name,last_name, status
  FROM `modalcrud` LIMIT $startFrom, $showRecordPerPage";
  $result = mysqli_query($conn, $empSQL);
?>
<?php
        while($emp = mysqli_fetch_assoc($result)){
         ?>
<tr>
  <td><?php echo $emp["id"]; ?></td>
<td><?php echo $emp["reference_id"]; ?></td>
<td><?php echo $emp["order_id"]; ?></td>
<td><?php echo $emp["first_name"]; ?></td>
<td><?php echo $emp["last_name"]; ?></td>
<td><?php echo $emp["status"]; ?></td>

    
     
   <td class="actions ">
     <a href=""  data-toggle="modal" data-target="#editModal"  class=" btn btn-warning editbtn"><i class="fas fa-edit"></i></a>

      <a href="modalcrud.php?id=<?php echo $emp['id'];?>" class="btn btn-danger trash m-1"><i class="fas fa-trash" ></i></a>

       <a href="" data-toggle="modal" data-target="#viewModal" class=" btn btn-success viewbtn" name="viewbtn"><i class="fas fa-eye"></i> </a>
                </td>
</tr>
<?php }?>
  </tbody>
</table>
</div>
<nav aria-label="Page navigation">
  <ul class="pagination mt-2 mr-2" style="float:right">
  <?php if($currentPage != $firstPage) { ?>
  <li class="page-item">
    <a class="page-link" href="?page=<?php echo $firstPage ?>" tabindex="-1" aria-label="Previous">
    <span aria-hidden="true">First</span>     
    </a>
  </li>
  <?php } ?>
  <?php if($currentPage >= 2) { ?>
    <li class="page-item"><a class="page-link" href="?page=<?php echo $previousPage ?>"><?php echo $previousPage ?></a></li>
  <?php } ?>
  <li class="page-item active"><a class="page-link" href="?page=<?php echo $currentPage ?>"><?php echo $currentPage ?></a></li>
  <?php if($currentPage != $lastPage) { ?>
    <li class="page-item"><a class="page-link" href="?page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a></li>
    <li class="page-item">
      <a class="page-link" href="?page=<?php echo $lastPage ?>" aria-label="Next">
      <span aria-hidden="true">Last</span>
      </a>
    </li>
  <?php } ?>
  </ul>
</nav>



</div>





<!-- Modal Add Form-->
<div class="modal" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crud With Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="modalcrud.php" method="POST">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputrefeid4">Reference Id</label>
      <input type="text" class="form-control" id="inputrefeid" name="reference_id" placeholder="Reference Id" required>
    </div>
     <div class="form-group col-md-6">
      <label for="inputorderid4">Order Id</label>
      <input type="text" class="form-control" id="inputorderid" name="order_id" placeholder="Order Id" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputfname4">First Name</label>
      <input type="text" class="form-control" id="inputfname" name="first_name" placeholder="First Name" required>
    </div>
     <div class="form-group col-md-6">
      <label for="inputlname4">Last Name</label>
      <input type="text" class="form-control" id="inputlname" name="last_name" placeholder="Last Name" required>
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6">
    <label for="exampleFormStore">Status</label>
    <select class="form-control" id="exampleFormStatus" name="status">
      <option></option>
      <option>Done</option>
      <option>Pending</option>
    </select>
  </div>
  </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary" name="submit">Save Data</button>
      </div>
    </div>
  </div>
</div>
</form>




<!-- Modal Edit Form-->
<div id="editModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body edit_crm">
                     <form action="" method="POST">
                      <input type="hidden" id="id" name="id" class="form-control" required>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Reference Id</label>
      <input type="text" class="form-control" id="reference_id" name="reference_id" placeholder="Reference Id" value="">
    </div>
     <div class="form-group col-md-6">
      <label for="inputEmail4">Order Id</label>
      <input type="text" class="form-control" id="order_id" name="order_id" 
      value="" placeholder="Order Id">
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">First Name</label>
      <input type="text" class="form-control" id="first_name" name="first_name" 
      value=""  placeholder="First Name">
    </div>
     <div class="form-group col-md-6">
      <label for="inputEmail4">Last Name</label>
      <input type="text" class="form-control" id="last_name" name="last_name" 
      value="" placeholder="Last Name" >
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6">
    <label for="Store">Status</label>
    <select class="form-control"  name="status" id="status" value="" >
      <option > </option>
      <option >Done</option>
      <option >Pending</option>
    </select>
  </div>
  
  </div>
<div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-info"  name="updatedata" value="Update">
                </div>
                </form>
    </div>
  </div>      
  </div>
</div>
 




<!--view Modal-->

<div id="viewModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Read Only</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body view_employee">
  <form action="" method="POST">
      <input type="hidden" name="id" id="id1" value="">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Reference Id</label>
      <input type="text" class="form-control" id="reference_id1" name="reference_id" placeholder="Reference Id" value="" readonly>
    </div>
     <div class="form-group col-md-6">
      <label for="inputEmail4">Order Id</label>
      <input type="text" class="form-control" id="order_id1" name="order_id" placeholder="Order Id" 
      value="" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail4">First Name</label>
      <input type="text" class="form-control" id="first_name1" name="first_name" 
      value=""  placeholder="First Name" readonly>
    </div>
     <div class="form-group col-md-6">
      <label for="inputEmail4">Last Name</label>
      <input type="text" class="form-control" id="last_name1" name="last_name" 
      value="" placeholder="Last Name" readonly>
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6">
    <label for="Store">Status</label>
    <select class="form-control"  name="status" id="status1" value="" disabled >
      <option ></option>
      <option >Done</option>
      <option >Pending</option>
    </select>
  </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
           <!-- <button type="submit" class="btn btn-primary" name="updatedata">Update Data</button>   -->
      </div>
    </div>
  </div>
</div>
</form>




<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

<script type="text/javascript">
  
$(document).ready(function () {
$('.editbtn').on('click',function(){
$tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {

            return $(this).text();

        }).get();

        console.log(data);
        $('#id').val(data[0]);
         $('#reference_id').val(data[1]);
           $('#order_id').val(data[2]);
             $('#first_name').val(data[3]);
               $('#last_name').val(data[4]);
                 $('#status').val(data[5]);
                  
                       
});

$('.viewbtn').on('click',function(){
$tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {

            return $(this).text();

        }).get();

        console.log(data);
        $('#id1').val(data[0]);
         $('#reference_id1').val(data[1]);
           $('#order_id1').val(data[2]);
             $('#first_name1').val(data[3]);
               $('#last_name1').val(data[4]);
                 $('#status1').val(data[5]);
                       
});
});



$(document).ready(function(){

$('#search').keyup(function(){
  search_table($(this).val());
});

function search_table(value){
  $('#myTable tr').each(function(){
    var found ='false';
    $(this).each(function(){
      if($(this).text().toLocaleLowerCase().indexOf(value.toLowerCase())>=0)
      {
        found='true';
      }
    });
    if(found=='true'){
      $(this).show();
    }
    else{
      $(this).hide();
    }
  });
}
});




</script>

</body>
</html>

