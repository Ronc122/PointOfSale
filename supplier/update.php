<?php
	$msg 		= '';
  	if(isset($_POST['update'])){
		$target   	= "../images/".basename($_FILES['image']['name']);
	  	$image    	= $_FILES['image']['name'];
	  	$id       	= $_POST['id'];
	  	$company 	= mysqli_real_escape_string($db, $_POST['com_name']);	
	  	$firstname  = mysqli_real_escape_string($db, $_POST['firstname']);
	  	$lastname   = mysqli_real_escape_string($db, $_POST['lastname']);
	  	$number   	= mysqli_real_escape_string($db, $_POST['number']);
	  	$address  	= mysqli_real_escape_string($db, $_POST['address']);

	  	$query  = "SELECT username FROM users WHERE position = 'admin'";
	  	$result = mysqli_query($db, $query);
	  	if (mysqli_num_rows($result)>0){
			while ($row = mysqli_fetch_assoc($result)){
				$user = $row['username'];
		  			if (!empty($image)){
		  				$sql  = "UPDATE supplier SET company_name='$company',firstname='$firstname',lastname='$lastname',address='$address',contact_number='$number',image='$image' WHERE supplier_id = '$id'";
		  				mysqli_query($db, $sql);
		  				if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
		  					$msg = "Image successfully uploaded!";
		  					$logs 	= "INSERT INTO logs (username,purpose,logs_time) VALUES('$user','Supplier $company updated',CURRENT_TIMESTAMP)";
 							mysqli_query($db,$logs);
 							header('location: ../supplier/supplier.php?username='.$user.'&updated');
		  				}
					}else{
		  				$sql  = "UPDATE supplier SET company_name='$company',firstname='$firstname',lastname='$lastname',address='$address',contact_number='$number' WHERE supplier_id = '$id'";
		  				mysqli_query($db, $sql);
		  				$logs 	= "INSERT INTO logs (username,purpose,logs_time) VALUES('$user','Supplier $company updated',CURRENT_TIMESTAMP)";
 						mysqli_query($db,$logs);
 						header('location: ../supplier/supplier.php?username='.$user.'&updated');
					}
			}
		}else{
		  		$msg = "There was a problem uploading the image!";
		}
	}
	  		