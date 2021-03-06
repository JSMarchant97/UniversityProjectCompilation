<?php


//when a user creates a new idea an email will be sent to the QAC
//We will need to get the user department to send to ->getCoordinatorEmail
include_once('database.php');
session_start();
//this will need to be taken out
$_SESSION["department"] = "test";
$department = $_SESSION["department"];
 
  $emailFunction = new Database();

    $emailQAM = $emailFunction->getCoordinatorEmail($department);  


if($emailQAM->num_rows > 0){
    
    while($row = $emailQAM->fetch_assoc()){
    
        //loops through emails of QAM from a department
        $email = $row["email"];
$to = $email;
//Email title
$subject = "New Idea Submitted";
//this can be improved to give more information if needed
$txt = "A new idea has been submitted to your department"; 

//who sent the message
$headers = "From: DoNotReply@gre.ac.uk\r\n";

mail("$to","$subject","$txt","$headers");
    }
}
?>
    