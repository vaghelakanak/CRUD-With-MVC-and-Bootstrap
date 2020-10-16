<?php
	require 'config.php';
	
	class db_class{
		public $host = db_host;
		public $user = db_user;
		public $pass = db_pass;
		public $dbname = db_name;
		public $conn;
		public $error;
		
		
		public function __construct(){
			$this->createDatabaseIfNotExists();
			$this->connect();
		}
		
		private function connect(){	
			$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
			if(!$this->conn){
				$this->error = "Fatal Error: Can't connect to database".$this->conn->connect_error;
				return false;
			}
				
			/*Create table if not exist*/
			$sql="CREATE TABLE IF NOT EXISTS `users` (
				  `user_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'User Id',				  
				  `profile_picture` varchar(128) CHARACTER SET utf8 NOT NULL COMMENT 'User Profile Picture',
				  `full_name` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT 'User full Name',
				  `email` varchar(128) CHARACTER SET utf8 NOT NULL COMMENT 'User Email Address',				  
				  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'User Created Date and Time',
				  PRIMARY KEY (`user_id`)
				) ";
				
			$results=$this->conn->query($sql);
		}
		
		public function createDatabaseIfNotExists() {
			$MainConn = new mysqli($this->host, $this->user, $this->pass);
                  	$CreateDbsql = "CREATE DATABASE IF NOT EXISTS ". $this->dbname;
			$MainConn->query($CreateDbsql);
			$MainConn->close();
		}
		
		public function isRequired($data){

			// Required field names
			$required = array('fullname', 'email');

			// Loop over field names, make sure each one exists and is not empty
			$error = false;
			foreach($required as $field) {
			  if (empty($data[$field])) {
			    $error = true;
			  }
			}
		}
		public function userImage($userimage){
			$target_dir = "upload/";
		    $temp = explode(".", $userimage["profilePicture"]["name"]);
		    $newfilename = round(microtime(true)) . '.' . end($temp);
			$target_file = $target_dir .''. $newfilename;
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			    $check = getimagesize($userimage["profilePicture"]["tmp_name"]);
			    if($check !== false) {
			        $msg = "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } else {
			        $msg = "File is not an image.";
			        $uploadOk = 0;
			    }
			}
			// Check if file already exists
			if (file_exists($target_file)) {
			    $msg = "Sorry, file already exists.";
			    $uploadOk = 0;
			}
			
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" ) {
			    $msg = "Sorry, only JPG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    $msg = "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($userimage["profilePicture"]["tmp_name"], $target_file)) {
			        $msg = "The file ". basename( $userimage["profilePicture"]["name"]). " has been uploaded.";
			        $_POST['profilePicture'] = $newfilename;
					return 1;
			    } else {
			        $msg = "Sorry, there was an error uploading your file.";
			        return $msg;
			    }
			}
		}
		public function save($data){
			
			
			$stmt = $this->conn->prepare("INSERT INTO `users` (user_id, profile_picture, full_name , email) VALUES('','".$_POST["profilePicture"]."','".$data["fullname"]."','".$data["email"]."')")
			 or die($this->conn->error);
			
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}
		public function edit($data){			
			$userid = $data['uid'];
		

			if(!isset($_POST["profilePicture"])){
				$_POST["profilePicture"] = $_POST['imgName'];
			}
			$stmt = $this->conn->prepare("UPDATE `users` set profile_picture = '".$_POST["profilePicture"]."',full_name = '".$data["fullname"]."',email = '".$data["email"]."' WHERE user_id = $userid")
			 or die($this->conn->error);
			 
			
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return $userid;
			}
		}
	
		public function getUserData($userId){
			 $sql = "SELECT * FROM users WHERE user_id = $userId";
			
			$result = $this->conn->query($sql);
			if ($result->num_rows > 0)
			{
				$row = $result->fetch_assoc();
				return $row;
			}
		}

		public function ShowData(){
			$sql = "SELECT * FROM users";
			$result = $this->conn->query($sql);
			if ($result->num_rows > 0)
			{
				$resultArray = array();
				while($row = $result->fetch_assoc())
				{
					$resultArray[] = $row;
				}
				return $resultArray;
			}
		}
		
		public function deleteUser($userID){			
		
			$userData = $this->getUserData($userID);			
			$stmt = $this->conn->prepare("delete from `users` where user_id = '".$userID."' ")
			 or die($this->conn->error);
			 
			
			if($stmt->execute()){
				$dir = 'upload';
				$file = $userData['profile_picture'];
				unlink($dir.'/'.$file); 
				$stmt->close();
				$this->conn->close();
				return 1;
			}
			else
			{
				return 0;
			}
		}

	}
?>
