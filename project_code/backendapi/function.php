<?php
error_reporting( E_ALL );
getdb();
function getdb(){
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $db = "test";
    try {
       
        $con = mysqli_connect($servername, $username, $password, $db);
         //echo "Connected successfully"; 
        }
    catch(exception $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
        return $con;
    }
//echo "hii";exit;
 if(isset($_POST["Import"])){
		
		$filename=$_FILES["file"]["tmp_name"];		


		 if($_FILES["file"]["size"] > 0)
		 {
		  	$file = fopen($filename, "r");
	        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {


	           $sql = "INSERT into employees (name,email,phone,domian,location,dob,gender) 
                   values ('".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."','".$getData[7]."')";
                   $result = mysqli_query($con, $sql);
                   
				if(!isset($result))
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"index.php\"
						  </script>";		
				}
				else {
					  echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"index.php\"
					</script>";
				}
	         }
			
	         fclose($file);	
		 }
	}	 
    if(isset($_POST["Export"])){
     
        header('Content-Type: text/csv; charset=utf-8');  
        header('Content-Disposition: attachment; filename=data.csv');  
        $output = fopen("php://output", "w");  
        fputcsv($output, array('ID', 'First Name', 'Email', 'Phone', 'DOB Date','Domain','Location','Gender'));  
        $query = "SELECT * from employees ORDER BY id DESC";  
        $result = mysqli_query($con, $query);  
        while($row = mysqli_fetch_assoc($result))  
        {  
             fputcsv($output, $row);  
        }  
        fclose($output);  
   }  
    function get_all_records(){
        $con = getdb();
        $Sql = "SELECT * FROM employees";
        $result = mysqli_query($con, $Sql);  
        if (mysqli_num_rows($result) > 0) {
         echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
                 <thead><tr><th>EMP ID</th>
                              <th> Name</th>
                              <th>Email</th>
                              <th>Mobile</th>
                              <th>DOB Date</th>
                              <th>Gender</th>
                              <th>Domain</th>
                              <th>Location</th>
                            </tr></thead><tbody>";
         while($row = mysqli_fetch_assoc($result)) {
             echo "<tr><td>" . $row['id']."</td>
                       <td>" . $row['tname']."</td>
                       <td>" . $row['email']."</td>
                       <td>" . $row['phone']."</td>
                       <td>" . $row['dob']."</td>
                       <td>" . $row['gender']."</td>
                       <td>" . $row['domain']."</td>
                       <td>" . $row['location']."</td>
                       </tr>";        
         }
        
         echo "</tbody></table></div>";
         
    } else {
         echo "you have no records";
    }
    }
 ?>