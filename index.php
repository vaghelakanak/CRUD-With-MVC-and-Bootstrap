<?php include('common/header.php');?>

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
	if(jQuery('#profilePicture').val().trim() == '')
	{
		error++;
		errorString += "Please upload image\n";
	}
	if(!allowedExtensions.exec(jQuery('#profilePicture').val().trim())){
		error++;
        errorString += "Please upload file having extensions .jpeg/.jpg/.png/.gif only.\n";
    }
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
    <h4 class="text-danger">Registration Form</h4>
    <?php if(isset($_REQUEST['success']) && $_REQUEST['success'] == 1) { ?> <div class="alert alert-success">User has been registered successfully!</div> <?php } ?>
    <?php if(isset($_REQUEST['success']) && $_REQUEST['success'] == 0) { ?> <div class="alert alert-danger">There is some issue in registration part</div><?php } ?>
    <form method="POST" action="save_query.php" enctype="multipart/form-data" onsubmit="return validateForm()">
      <div class="form-group">
        <input type="text" placeholder="Name"  name="fullname" id="fullname" value="<?php echo (isset($SESSION['erros']['fullname']) ? $SESSION['erros']['fullname'] : '');?>" />
      </div>
      
      <div class="form-group">
        <input type="text" placeholder="Email"  name="email" id="email" value="<?php echo (isset($SESSION['erros']['email']) ? $SESSION['erros']['email'] : '');?>" />
      </div>
        <div class="form-group">
            <input type="file" name="profilePicture" id="profilePicture"   accept="image/gif, image/jpeg, image/png" />
          </div>
      <input type="submit" name="signup" value="Sign Up"/>
    </form>
  </div>
</div>

</div>
</body>
</html>