<?php 
header("Access-Control-Allow-Origin: *");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');

// Include action.php file
include_once 'db.php';
// Create object of Users class
$user = new Database();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = intval($_GET['id'] ?? '');

// Get all or a single user from database
if ($api == 'GET') {
	if ($id != 0) {
		$data = $user->fetch($id);
	} else {
		$data = $user->fetch();
	}
	if(!empty($data)){
		echo json_encode($data);
	}else{
		echo json_encode(["response"=>204,"message"=>"data not found!"]);
	}
	
}
// Add a new user into database
if ($api == 'POST') {
	$postdata = file_get_contents("php://input");
	// Extract the data.
	$request = json_decode($postdata);
	

    $name = $user->test_input($request->name);
	$email = $user->test_input($request->email);
	$phone = $user->test_input($request->phone);
	$domain = $user->test_input($request->domain);
	$location = $user->test_input($request->location);
    $gender = $user->test_input($request->gender);exit;
	$dob = date("Y-m-d",strtotime($user->test_input($request->dob)));

	if ($user->insert($name, $email, $phone, $domain, $location, $dob, $gender)) {
		echo $user->message('User added successfully!',false);
	} else {
		echo $user->message('Failed to add an user!',true);
	}
}
// Update an user in database
if ($api == 'PUT') {
	$postdata = file_get_contents("php://input");
	// Extract the data.
	$request = json_decode($postdata);
	

    $name = $user->test_input($request->name);
	$email = $user->test_input($request->email);
	$phone = $user->test_input($request->phone);
	$domain = $user->test_input($request->domain);
	$location = $user->test_input($request->location);
	$gender = $user->test_input($request->gender);
	$dob = date("Y-m-d",strtotime($user->test_input($request->dob)));


	if ($id != null) {
		if ($user->update($name, $email, $phone, $domain, $location, $dob, $gender, $id)) {
			echo $user->message('User updated successfully!',false);
		} else {
			echo $user->message('Failed to update an user!',true);
		}
	} else {
		echo $user->message('User not found!',true);
	}
}
// Delete an user from database
if ($api == 'DELETE') {
	if ($id != null) {
		if ($user->delete($id)) {
			echo $user->message('User deleted successfully!', false);
		} else {
			echo $user->message('Failed to delete an user!', true);
		}
	} else {
		echo $user->message('User not found!', true);
	}
}
?>