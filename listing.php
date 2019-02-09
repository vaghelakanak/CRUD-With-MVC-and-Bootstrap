<?php include('common/header.php');
require "class.php";
$newClass = new db_class();
$arrayData = $newClass->ShowData();

?>

  <div class="container">
<?php if(isset($_REQUEST['success']))
  {
	  echo '<p>';
	  if($_REQUEST['success'] == 1) { echo "<div class='alert alert-success'>User Deleted Successfully</div>"; } 
	  else { echo "<div class='alert alert-danger'>There is some issue in deleting user</div>"; }
	  echo '</p>';
  }	
  ?>





<table class="table">
  <thead class="black white-text">
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Image</th>
      <th scope="col">Edit</th>
	  <th scope="col">Delete</th>
    </tr>
  </thead>
  
  
   <tbody>
   <?php if($arrayData)
	  {
		  foreach($arrayData as $userData)
		  {
			  $userID = $userData['user_id'];
		?>
		 <tr>
			<td scope="row"><?php echo $userData['full_name'];?></td>
			<td><?php echo $userData['email'];?></td>
			<td><img src="upload/<?php echo $userData['profile_picture'];?>" style="height:50px;"></td>
			<td><a href="edit-profile.php?id=<?php echo $userID;?>">Edit</a></td>
			<td><a href="delete-user.php?id=<?php echo $userID;?>" onclick="return confirm('Are you sure you want to delete?');">Delete</a></td>
		</tr>
	  <?php
		 }
	  }
	  else{
  ?>
	 <tr>
		<td colspan="5" align="center">No data found</td>
	 </tr>
	
	  <?php } ?>
  
  </tbody>
</table>












</div>

</body>
</html>