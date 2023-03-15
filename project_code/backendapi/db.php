<?php
	// Include config.php file
	include_once 'config.php';
	error_reporting( E_ALL );
	// Create a class Users
	class Database extends Config {
	  // Fetch all or a single user from database
	  public function fetch($id = 0) {
	    $sql = 'SELECT * FROM employees';
	    if ($id != 0) {
	      $sql .= ' WHERE id = :id';
	    }
		
	    $stmt = $this->conn->prepare($sql);
		if ($id != 0) {
			$stmt->execute(['id' => $id]);
		  }
		  else{
			$stmt->execute();
		  }
	   
	    $rows = $stmt->fetchAll();
		//print_r($stmt);
	    return $rows;
	  }

	 // Insert an user in the database
	  public function insert($name, $email, $phone,  $domain, $location, $dob, $gender) {
	    $sql = 'INSERT INTO employees (name, email, phone, domain, location, dob, gender) VALUES (:name, :email, :phone, :domain, :location,  :gender, :dob)';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'domain' => $domain, 'location' => $location, 'gender' => $gender, 'dob' => $dob]);
	    return true;
	  }

	  // Update an user in the database
	  public function update($name, $email, $phone, $domain, $location, $dob, $gender,  $id) {
	    $sql = 'UPDATE employees SET name = :name, email = :email, phone = :phone, domain = :domain, location = :location, dob = :dob, gender = :gender WHERE id = :id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'domain' => $domain, 'location' => $location, 'dob' => $dob, 'gender' => $gender, 'id' => $id]);
		return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM employees WHERE id = :id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['id' => $id]);
	    return true;
	  }
	}
    

?>