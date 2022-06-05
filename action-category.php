<?php
	session_start();
	include 'config.php';

	$update=false;
	$id="";
	$category_name="";
	$status="";

	if(isset($_POST['add'])){
		$category_name=$_POST['category_name'];
		$status=$_POST['status'];


        $query="INSERT INTO tbl_categorys(category_name,status)VALUES(?,?)";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("ss",$category_name,$status);
		$stmt->execute();


		header('location:category.php');
		$_SESSION['response']="Successfully Inserted to the database!";
		$_SESSION['res_type']="success";
	}
	

	// This for delete data from database
	if(isset($_GET['delete'])){
		$id=$_GET['delete'];

		$query="DELETE FROM tbl_categorys WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();

		header('location:category.php');
		$_SESSION['response']="Successfully Deleted!";
		$_SESSION['res_type']="danger";
	}

	// End delete

    // This for edit data
	if(isset($_GET['edit'])){
		$id=$_GET['edit'];

		$query="SELECT * FROM tbl_categorys WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$result=$stmt->get_result();
		$row=$result->fetch_assoc();

		$id=$row['id'];
		$category_name=$row['category_name'];
		$status=$row['status'];

		$update=true;
	}
	// End edit


	// This for update data
	if(isset($_POST['update'])){
		$id=$_POST['id'];
		$category_name=$_POST['category_name'];
		$status=$_POST['status'];

		
		$query="UPDATE tbl_categorys SET category_name=?,status=? WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("ssi",$category_name,$status,$id);
		$stmt->execute();

		$_SESSION['response']="Updated Successfully!";
		$_SESSION['res_type']="primary";
		header('location:category.php');
	}
	// End Update

	// This for view data detail
	if(isset($_GET['details'])){
		$id=$_GET['details'];
		$query="SELECT * FROM tbl_categorys WHERE id=?";
		$stmt=$conn->prepare($query);
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$result=$stmt->get_result();
		$row=$result->fetch_assoc();

		$vid=$row['id'];
		$vcategory_name=$row['category_name'];
		$vstatus=$row['status'];
	}
	// End view
?>