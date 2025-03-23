<?php
session_start();
ob_start(); 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);  
include_once("/home/cocobills/staging.cocobills.com/functions.php");
 


if(isset($_GET['sessid'])){
    $sessionId = $_GET['sessid']; 
    $ref = $_GET['ref'];
 
        $conn = con();     // Retrieve user data
        $sql = "SELECT * FROM users WHERE auth_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $sessionId); 
        if(!$stmt->execute()) { echo json_encode(['success' => false, 'message' => 'Error executing user: ' . $stmt->error ]); } 
        $result = $stmt->get_result();
        //    if (!$result) { echo json_encode(['success' => false, 'message' => 'Error getting user: ' . $stmt->error ]); } 
        $user = $result->fetch_assoc();
        //if (!$user) { echo json_encode(['success' => false, 'message' => 'Error fetching assoc : ' . $stmt->error .$user['customerid'].var_dump($user) ]); }
         
        	if($sessionId === $user['auth_token']){
        	     $_SESSION['customer_phoneno'] = $user['customer_phoneno'];
        	     $_SESSION['user_id'] = $user['id'];
                    //print_r($_SESSION);
                    if(!empty($ref)){
                        header("Location: $ref ");
                    } else{ header("Location: https://cocobills.com/ "); }
        	}else{  
        	    header("Location: /login");
        	}
    } else{
	    echo "Session expired!";
//	    print_r($_SESSION);
	    header("Location: /login");
}



header("Location: / ");

?>