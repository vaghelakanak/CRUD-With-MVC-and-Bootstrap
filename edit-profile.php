<?php include('common/header.php');?>

<?php require_once "class.php";
	$conn = new db_class(); 
?>

<?php 
if(isset($_GET['id']))
{
 $User_data=$conn->getUserData($_GET['id']);
}
 
?>

<script>
function validateForm()
{
	var error = 0;
	var errorString = '';
	var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
	var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	var emailAddress = jQuery('#email').val().trim();	
	var hasChecked = false;
	errorString += 'Following fileds are required\n\n'	
	
	if(jQuery('#fullname').val().trim() == '')
	{
		error++;
		errorString += "Please insert Name\n";
	}
	if(emailAddress == '')
	{
		error++;
		errorString += "Please insert Email\n";
	}
	else{
		if (!filter.test(emailAddress)) {
			error++;
			errorString += "Please insert Valide Email\n";
		}
	}
	if(error > 0)
	{
		
		alert(errorString);
		return false;
	}
	else
	{
		return true;
	}
}
</script>

<div class="container">
<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4 well">
    <h4 class="text-danger">Edit User Form</h4>
    <?php if(isset($_REQUEST['success']) && $_REQUEST['success'] == 1) { ?> <div class="alert alert-success">User has been edited successfully!</div> <?php } ?>
    <?php if(isset($_REQUEST['success']) && $_REQUEST['success'] == 0) { ?> <div class="alert alert-danger">There is some issue in edit part</div><?php } ?>
    <form method="POST" action="save_query.php" enctype="multipart/form-data" onsubmit="return validateForm()">
     <input type="hidden" name="uid" value="<?php echo $_GET['id']; ?>">
      <div class="form-group">
        <input type="file" name="profilePicture" id="profilePicture"   accept="image/gif, image/jpeg, image/png" style="float:left;"/>
        <input type="hidden" name="imgName" value="<?php echo $User_data['profile_picture']; ?>"> 
		<img src="upload/<?php echo $User_data['profile_picture'];?>" style="height:50px;">
      </div>
      <div class="form-group">
        <input type="text" placeholder="Full Name"  name="fullname" id="fullname" value="<?php echo $User_data['full_name']; ?>" />
      </div>
     
      <div class="form-group">
        <input type="text" placeholder="Email"  name="email" id="email" value="<?php echo $User_data['email']; ?>" />
      </div>
	  <input type="submit" name="edit" value="Edit"/>
    </form>
  </div>
</div>

</div>
</body>
</html>