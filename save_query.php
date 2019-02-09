<?php
	require_once "class.php";
	$conn = new db_class();
	/*Create database and table*/
	//$conn->CreateDatabaseAndTable();
	
	if(ISSET($_POST['signup'])){
		$erros = "";
		$validate = $conn->isRequired($_POST);
		if ($validate) {
			  $erros = "All fields are required.";
		}else {
			if ($_POST["email"] != "") {
				$email = $_POST["email"];
    			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			      $erros = "Invalid email format"; 
			    }
  			}
  			if($erros == ""){
  				$image = $conn->userImage($_FILES);
  				if($image != 1){
  					 $erros = $image;
  				}
  			}
		}
		if($erros == ""){
			$_SESSION['erros'] = "";
			$conn->save($_REQUEST);
			echo '<script>window.location= "index.php?success=1"</script>';
		}else{
			$_POST['errosMsg'] = $erros; 
			$_SESSION['erros'] = $_POST;
			echo '<script>window.location= "index.php?success=0"</script>';
		}
	}
	if(ISSET($_POST['edit'])){

		$erros = "";
		$validate = $conn->isRequired($_POST);
		if ($validate) {
			  $erros = "All fields are required.";
		}else {
			if ($_POST["email"] != "") {
				$email = $_POST["email"];
    			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			      $erros = "Invalid email format"; 
			    }
  			}
  			if($erros == ""){
  				if($_FILES['profilePicture']['name'] != ""){
  					$image = $conn->userImage($_FILES);
  					if($image != 1){
  						 $erros = $image;
  					}	
  				}
  			}
		}
		if($erros == ""){
			$_SESSION['erros'] = "";
			$userId=$conn->edit($_REQUEST);
			//echo '<script>alert("Successfully saved!")</script>';
			echo '<script>window.location= "edit-profile.php?id='.$userId.'&success=1"</script>';
		}else{
			$_POST['errosMsg'] = $erros; 
			$_SESSION['erros'] = $_POST;
			echo '<script>window.location= "edit-profile.php?id='.$userId.'&success=0"</script>';
		}
		//echo '<script>window.location= "index.php"</script>';
	}
	if(ISSET($_POST['login'])){
		$isLogin = $conn->login($_POST);
		if($isLogin){
			echo '<script>window.location= "admin/view-profile.php?success=1"</script>';
		}else{
			echo '<script>window.location= "admin/index.php?success=0"</script>';
		}	
	}	
?>