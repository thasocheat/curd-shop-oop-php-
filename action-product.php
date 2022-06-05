<?php
	session_start();
	include 'config.php';

	$update=false;
	$id="";
	$name="";
	$category_id="";
	$price="";
	$image="";
	$status="";

    // This for insert data into database
	if(isset($_POST['add'])){
		$name=$_POST['name'];
		$category_id=$_POST['category_id'];
		$price=$_POST['price'];
		$status=$_POST['status'];

		$image=$_FILES['photo']['name'];
		$upload="images/".$image;

		$query="INSERT INTO tbl_products(name,category_id,price,image,status)VALUES(?,?,?,?,?)";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("sssss",$name,$category_id,$price,$upload,$status);
		$stmt->execute();
		move_uploaded_file($_FILES['photo']['tmp_name'], $upload);

		// When add data success go to product.php file
		header('location:product.php');
		$_SESSION['response']="Successfully Inserted to the database!";
		$_SESSION['res_type']="success";
	}
    // End

    // This for delete data from database
	if(isset($_GET['delete'])){
		$id=$_GET['delete'];

		$sql="SELECT image FROM tbl_products WHERE id=?";
		$stmt2=$conn->prepare($sql);
		$stmt2->bind_param("i",$id);
		$stmt2->execute();
		$result2=$stmt2->get_result();
		$row=$result2->fetch_assoc();

		$imagepath=$row['image'];
		unlink($imagepath);

		$query="DELETE FROM tbl_products WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();

		header('location:product.php');
		$_SESSION['response']="Successfully Deleted!";
		$_SESSION['res_type']="danger";
	}

	// End delete

    // This for edit data
	if(isset($_GET['edit'])){
		$id=$_GET['edit'];

		$query="SELECT * FROM tbl_products WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$result=$stmt->get_result();
		$row=$result->fetch_assoc();

		$id=$row['id'];
		$name=$row['name'];
		$category_id=$row['category_id'];
		$price=$row['price'];
		$image=$row['image'];
		$status=$row['status'];

		$update=true;
	}
	// End edit


	// This for update data
	if(isset($_POST['update'])){
		$id=$_POST['id'];
		$name=$_POST['name'];
		$category_id=$_POST['category_id'];
		$price=$_POST['price'];
		$oldimage=$_POST['oldimage'];
		$status=$_POST['status'];

		if(isset($_FILES['photo']['name'])&&($_FILES['photo']['name']!="")){
			$newimage="images/".$_FILES['photo']['name'];
			unlink($oldimage);
			move_uploaded_file($_FILES['photo']['tmp_name'], $newimage);
		}
		else{
			$newimage=$oldimage;
		}
		$query="UPDATE tbl_products SET name=?,category_id=?,price=?,image=?,status=? WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("sssssi",$name,$category_id,$price,$newimage,$status,$id);
		$stmt->execute();

		$_SESSION['response']="Updated Successfully!";
		$_SESSION['res_type']="primary";
		header('location:product.php');
	}
	// End Update

	// This for view data detail
	if(isset($_GET['details'])){
		$id=$_GET['details'];
		$query="SELECT * FROM tbl_products WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$result=$stmt->get_result();
		$row=$result->fetch_assoc();

		$vid=$row['id'];
		$vname=$row['name'];
		$vcategory_id=$row['category_id'];
		$vprice=$row['price'];
		$vimage=$row['image'];
		$vstatus=$row['status'];
	}
	// End view


?>