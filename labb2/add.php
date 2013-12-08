<?php

/**
* Called from AJAX to add stuff to DB
*/
function addToDB($name, $message, $pid) {
    $name = htmlspecialchars($name, ENT_QUOTES);
    $message = htmlspecialchars($message, ENT_QUOTES);
    $pid = htmlspecialchars($pid, ENT_QUOTES);
	$db = null;
	
	try {
		$db = new PDO("sqlite:db.db");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOEception $e) {
		die("Something went wrong -> " .$e->getMessage());
	}
	//$q = ;
	
	try {

        $stm = $db->prepare("INSERT INTO messages (message, name, pid) VALUES(:message, :name, :pid)");
        $stm->bindParam(':message', $message, \PDO::PARAM_STR);
        $stm->bindParam(':name', $name, \PDO::PARAM_STR);
        $stm->bindParam(':pid', $pid, \PDO::PARAM_INT);
        $stm->execute();
		//if(!$db->query($q)) {
			//die("Fel vid insert");
		//}
	}
	catch(PDOException $e) {
		die("Something went wrong -> " .$e->getMessage());
	}
}
