<?php

// Change it if necessary for your localhost
$con=mysqli_connect("us-cdbr-azure-central-a.cloudapp.net","b1d6ea18aa71c7","d41e125d","serviceuDB");
//$con=mysqli_connect("localhost","root","","serviceu");

function register($email, $firstName, $lastName, $password)
{
    global $con;
    $code = generateRandomString();
    
    mysqli_query($con,
                "INSERT INTO userTable (email, firstName, lastName, password, verificationCode) "
                . "values('$email', '$firstName', '$lastName', '$password', '$code');"
                );
    
    sendVerificationCode($email, $code);
    return TRUE;    
}


function emailAvailable($email) {
    global $con;

    $result = mysqli_query($con,
		"SELECT email 
		 FROM userTable
		 WHERE email = '$email'"
    );

    if (mysqli_num_rows($result) > 0)
	return FALSE;
    else
    	return TRUE;
}

function sendVerificationCode($email1, $code){
    require('phpMailer/PHPMailerAutoload.php');

    $mail = new PHPMailer(); 
    $mail->SMTPDebug = 2;
    $mail->IsSMTP(); // send via SMTP
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 2525;
    $mail->SMTPAuth = true; // turn on SMTP authentication

    $mail->Username = "serviceuconfirmation@gmail.com"; // SMTP username
    $mail->Password = "alvarez12"; // SMTP password

    $webmaster_email = "serviceuconfirmation@gmail.com"; //Reply to this email ID
    $email= $email1; // Recipients email ID
    $name=""; // Recipient's name
    $mail->From = $webmaster_email;
    $mail->AddAddress($email,$name);
    $mail->SetFrom('serviceuconfirmation@gmail.com', 'ServiceU Team');
    $mail->WordWrap = 50; // set word wrap

    $mail->IsHTML(true); // send as HTML
    $mail->Subject = "Verification Code";
    $mail->Body = "Welcome to ServiceU,
        <br>
        Here's your verification code: " . $code .  
        "<br>
        <br>Sincerely,
        <br>The ServiceU Team
        <br>"; //HTML Body
    if(!$mail->Send())
    {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
        echo "Message has been sent";
    }
}

function validateLogin($email, $password) {
    global $con;

    $query = "SELECT * FROM userTable
		WHERE email = '$email'
		AND password = '$password'";

    $result = mysqli_query($con, $query);
        
    if (mysqli_num_rows($result) > 0)
	return TRUE;
    else
	return FALSE;
}

function getEmail($userEmail){
    global $con;

    $query = "SELECT email FROM usertable WHERE email = '$userEmail'";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
        
    return $row['email'];
}

function getEmailByID($userID){
    global $con;

    $query = "SELECT email FROM usertable WHERE userId = '$userID'";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
        
    return $row['email'];
}

function getID($userEmail){
    global $con;

    $query = "SELECT userID FROM usertable WHERE email = '$userEmail'";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
        
    return $row['userID'];
}

function getFirstName($userEmail){
    global $con;

    $query = "SELECT firstName FROM usertable
              WHERE email = '$userEmail'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
        
    return $row['firstName'];        
}

function getFirstNameByID($userID){
    global $con;

    $query = "SELECT firstName FROM usertable
              WHERE userID = '$userID'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
        
    return $row['firstName'];        
}

function getLastName($userEmail){
    global $con;

    $query = "SELECT lastName FROM userTable
              WHERE email = '$userEmail'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
        
    return $row['lastName'];
}

function getFullName($userEmail){
    global $con;

    $query = "SELECT firstName, lastName FROM userTable
              WHERE email = '$userEmail'";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
        
    return $row['firstName'] . " " . $row['lastName'];    
}

function getRate($userEmail){
    global $con;

    $query = "SELECT rate FROM userTable
              WHERE email = '$userEmail'";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
        
    return $row['rate'];    
}

function checkVerification($userEmail){
    global $con;
        
    $query = "SELECT verify FROM userTable 
              WHERE email = '$userEmail'";
        
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
        
    if($row['verify'] == 1)
        return TRUE;
    else
        return FALSE;
}

function verifyCode($userEmail, $code)
{
    global $con;
        
    $query = "SELECT verificationCode FROM userTable 
              WHERE email = '$userEmail'";
        
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
        
    if($row['verificationCode'] == $code)
        return TRUE;
    else
        return FALSE;
}

function verifyAccount($email)
{
    global $con;
    mysqli_query($con,
                "UPDATE userTable SET verify=1 WHERE email ='$email';");
    
    return TRUE;
}

function verifyPassword($userEmail, $potentialPassword)
{
    global $con;
	
    $query = "SELECT password from userTable WHERE email='$userEmail'";
        
    $result = mysqli_query($con, $query);
    
    $row = mysqli_fetch_assoc($result);
    
    if ($row['password'] == $potentialPassword)
	   return TRUE;
    else 
	    return FALSE;
    
}

function changePassword($userEmail, $newPassword)
{
    global $con;

    
    $query = "UPDATE usertable SET password='$newPassword' WHERE email='$userEmail'";
    
    $result = mysqli_query($con, $query);
    
    
     if($result == 1)
        return TRUE;
     else
        return FALSE;
       
}


/*function getDegree($userEmail){
    global $con;

    $query = "SELECT degree FROM usertable
              WHERE email = '$userEmail'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    $nrDegree = $row['degree'];
    
    if( $nrDegree == 0)
    {
        return "Not defined";
    }
    else{
        
        $query2 = "SELECT degree1, degree2, degree3, degree4 FROM degreetable
              WHERE emailID = '$userEmail'";

        $result2 = mysqli_query($con, $query2);        
        $row2 = mysqli_fetch_assoc($result2);
        
        $res = $row2['degree1'];
        return $res;
    }
    
}*/

function getSkills($userEmail){
    global $con;

    $query = "SELECT skill FROM userTable
              WHERE email = '$userEmail'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
        
    $skill = $row['skill'];
        
    return $skill;
}

function getInterests($userEmail){
    global $con;

    $query = "SELECT interest FROM userTable
              WHERE email = '$userEmail'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
        
    $interest = $row['interest'];
        
    return $interest;
}

 /*function editDegree1($userEmail, $newDegree){
    global $con;
    
    $query = "SELECT degree FROM usertable
              WHERE email = '$userEmail'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    
    $nrDegree = $row['degree'];
    
 
    if( $nrDegree == 0)
    {

        mysqli_query($con,
                "INSERT INTO degreetable(emailID, degree1) values('$userEmail','$newDegree');");
        $query1 = "UPDATE usertable SET degree=1 WHERE email ='$userEmail';";
        mysqli_query($con, $query1);
        
    }    
    else
    {
        mysqli_query($con, 
            "UPDATE degreetable SET degree1='$newDegree' WHERE emailID='$userEmail';");
    }
        


    RETURN TRUE;

}*/

 /*function editDegree2($userEmail, $newDegree){
    global $con;
    
    $query = "UPDATE degreeTable SET degree2 = '$newDegree' WHERE emailID = '$userEmail'";
    
    $result = mysqli_query($con, $query);
    
    if($result == 1)
        return TRUE;
    else
        return FALSE;

}*/

 /*function editDegree3($userEmail, $newDegree){
    global $con;
    
    $query = "UPDATE degreeTable SET degree3 = '$newDegree' WHERE emailID = '$userEmail'";
    
    $result = mysqli_query($con, $query);
    
    if($result == 1)
        return TRUE;
    else
        return FALSE;

}

 function editDegree4($userEmail, $newDegree){
    global $con;
    
    $query = "UPDATE degreeTable SET degree4 = '$newDegree' WHERE emailID = '$userEmail'";
    
    $result = mysqli_query($con, $query);
    
    if($result == 1)
        return TRUE;
    else
        return FALSE;

}*/

function insertSkill($userEmail, $newSkill)
{
    global $con;
    
    if($newSkill == "na"){
        $query = "UPDATE userTable SET skill = '$newSkill' WHERE email = '$userEmail'";
    }
    else{//$oldSkill is not NA
        
        $query = "UPDATE userTable SET skill = '$newSkill' WHERE email = '$userEmail'";
        
    }
        
    $result = mysqli_query($con, $query);
    
    if($result == 1)
        return TRUE;
    else
        return FALSE;
}

function insertInterest($userEmail, $newInterest)
{
    global $con;

    
    if($newInterest == "na"){
        $query = "UPDATE userTable SET interest = '$newInterest' WHERE email = '$userEmail'";
    }
    else{
        $query = "UPDATE userTable SET interest = '$newInterest' WHERE email = '$userEmail'";
    }
        
    $result = mysqli_query($con, $query);
    
    if($result == 1)
        return TRUE;
    else
        return FALSE;
}

function numberofJobs()
{
    global $con;
    
    mysqli_query($con, "SELECT COUNT(*) FROM jobTable");
    
    return TRUE;       
}

function getJob()
{
    global $con;

    $query = "SELECT * FROM jobTable ORDER BY `jobID` DESC";
    $result = mysqli_query($con, $query);        
    
    return $result;
}

function numApplications($jobID){
    global $con;
    
    $query = "SELECT totalApp FROM jobTable
              WHERE jobID = '$jobID'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
        
    $total = $row['totalApp'];
        
    return $total;
}

function getJobPost($postID)
{
    global $con;

    $query = "SELECT * FROM jobTable WHERE='$postID'";
    $result = mysqli_query($con, $query);        
    
    return $result;
} 

function getJobDescription($jobID){
    global $con;

    $query = "SELECT jobDescription FROM jobTable
              WHERE jobID = '$jobID'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
        
    $jobDescription = $row['jobDescription'];
        
    return $jobDescription;
}

function getJobTitle($jobID){
    global $con;

    $query = "SELECT jobTitle FROM jobTable
              WHERE jobID = '$jobID'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
        
    $jobTitle = $row['jobTitle'];
        
    return $jobTitle;
}

function getJobOwner($jobID){
    global $con;

    $query = "SELECT employeerID FROM jobTable
              WHERE jobID = '$jobID'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
        
    $employeerID= $row['employeerID'];
        
    return $employeerID;
}

function getJobPayment($jobID){
    global $con;

    $query = "SELECT payment FROM jobTable
              WHERE jobID = '$jobID'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
        
    $payment = $row['payment'];
        
    return $payment;
}

function getJobCategory($jobID){
    global $con;

    $query = "SELECT category FROM jobTable
              WHERE jobID = '$jobID'";

    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
        
    $jobCategory = $row['category'];
        
    return $jobCategory;
}

function existApp($emailApp, $jobID){
    global $con;
    
    $query = "SELECT COUNT(*) as total FROM appTable"
            . " WHERE `jobID`='" . $jobID . "' AND  `employeeID`='" .$emailApp. "'";
    
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['total'];

    
}

function submitApp($email, $jobID){
    global $con;
    
    $num = numApplications($jobID) + 1;
    
    newTotalApp($jobID, $num);
    
    mysqli_query($con,
                "INSERT INTO appTable (jobID, employeeID, orderApp)"
                . "values('$jobID', '$email', '$num');"
                );
    
    return TRUE;
}

function newTotalApp($jobID, $num){
    global $con;
    
    $query = "UPDATE jobTable SET totalApp = '$num' WHERE jobID = '$jobID'";
    mysqli_query($con, $query);
    
    return TRUE;
}

function getJobApplicants($jobID){
    global $con;

    $query = "SELECT * FROM appTable WHERE jobID='$jobID' "
            . "ORDER BY `orderApp` ASC";
    $result = mysqli_query($con, $query);        
    
    return $result;
}

function isOwner($email, $jobID){
    global $con;
    
    $query = "SELECT COUNT(*) as total FROM jobTable"
            . " WHERE employeerID = '$email' AND jobID = '$jobID'";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['total'];
}

function hasApplied($email, $jobID){
    global $con;
    
    $query = "SELECT COUNT(*) as total FROM appTable"
            . " WHERE employeeID = '$email' AND jobID = '$jobID'";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['total'];
}

function jobHasEmployee($jobID){
    global $con;
    
    $query = "SELECT COUNT(*) as selected FROM appTable"
        . " WHERE selectedEmployee= '1' AND jobID='$jobID'";
    
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    
    return $row['selected']; 
}


function jobIsClose($jobID){
    global $con;
    
    $query = "SELECT closeJob FROM jobTable"
            . " WHERE jobID='$jobID'";
    
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    
    return $row['closeJob']; 
}

function closePost($jobID){
    global $con;
    
    $result = mysqli_query($con, "UPDATE jobTable SET closeJob=1 WHERE jobID='$jobID';");
    
    return $result;
}

function openPost($jobID){
    global $con;
    
    $result = mysqli_query($con, "UPDATE jobTable SET closeJob=0 WHERE jobID='$jobID';");
    
    return $result;
}

function createPost($email, $jobTitle, $jobDescription, $jobPayment, $jobCategory){
    global $con;

    mysqli_query($con,
                "INSERT INTO jobTable (employeerID,jobTitle, jobDescription, payment, category)"
                . "values('$email', '$jobTitle', '$jobDescription', '$jobPayment', '$jobCategory');"
                );
    
    return TRUE;
    
}

function updatePost($jobID, $jobTitle, $jobDescription, $jobPayment, $jobCategory){
    global $con;
    
    $query = "UPDATE jobTable SET jobTitle ='$jobTitle', jobDescription='$jobDescription', "
            . " payment='$jobPayment', category='$jobCategory' WHERE jobID = '$jobID'";
    mysqli_query($con, $query);
    
    return TRUE;
    
    
}

function getUserJobs($email)
{
    global $con;

    $query = "SELECT * FROM jobTable WHERE employeerID='$email' "
            . "ORDER BY `jobID` DESC";
    $result = mysqli_query($con, $query);        
    
    return $result;
}

function getUserApps($email)
{
    global $con;

    $query = "SELECT * FROM jobTable WHERE jobID IN ( SELECT jobID from appTable WHERE employeeID='$email')"
            . " ORDER BY `jobID` DESC";
    $result = mysqli_query($con, $query);        
    
    return $result;
}


///////////////////////// REVIEW PAGE
function nroCommentStars($userEmail, $num){
    global $con;

    $query = "SELECT COUNT(*) as total FROM commentTable
              WHERE email = '$userEmail' AND stars='$num'";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
        
    return $row['total'];    
}

function getNroComments($userEmail){
    global $con;

    $query = "SELECT COUNT(*) as total FROM commentTable WHERE receiverID='$userEmail'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    
    return $row['total'];   
}

function getComments($userEmail){
    global $con;

    $query = "SELECT * FROM commentTable WHERE receiverID='$userEmail'";
    $result = mysqli_query($con, $query);
    
    return $result;
}

function getStarComments($userEmail, $numStars){
    global $con;

    $query = "SELECT * FROM commentTable WHERE receiverID='$userEmail' AND stars='$numStars'";
    $result = mysqli_query($con, $query);
    
    return $result;
}

///////////Update Profile Information
///////////////////////////////////
function updateUserInformation($userEmail, $newFirstName, $newLastName, $userPhoneNumber){
    global $con;
    
    $result = mysqli_query($con, "UPDATE userTable SET firstName='$newFirstName', lastName='$newLastName', userPhone='$userPhoneNumber' WHERE email='$userEmail';");
         
         return TRUE;

    
    
}

function getUserPhoneNumber($userEmail)
{
    global $con;

    $query = "SELECT userPhone FROM usertable WHERE email='$userEmail' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['userPhone'];
}



////////Photo Functions
////////////////////////

 function checkImageUserIfExist($userEmail){
    
      global $con;
     
      $query = "SELECT COUNT(*) as total FROM userimage WHERE imgUserEmail='$userEmail'";
     
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_assoc($result);
     
       return $row['total'];
    
 }

 function uploadImage($userEmail, $imageName, $imageData){
                
    global $con;

    if(checkImageUserIfExist($userEmail) == 0)
            mysqli_query($con, "INSERT INTO userimage (imgUserEmail, imgName, image) values('$userEmail', '$imageName', '$imageData');") or die("Failed to upload image".mysql_error());
     else{
         
         $query = "UPDATE userimage SET imgName='$imageName', image='$imageData' WHERE imgUserEmail = '$userEmail'";
         mysqli_query($con, $query) or die("Failed to save new image".mysql_error());
         
     }
     
    return TRUE;
     

}

function displayMyImage($userEmail){
    
    global $con;

    $query = "SELECT image FROM userimage WHERE imgUserEmail = '$userEmail'";
    
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);

    return $row['image'];
                
}


///////////Update User Experience
///////////
function insertUserExperience($userEmail, $userEmployer, $userJobTitle, $userLocation, $userDescription, $userCountry, $userStillWorkWhere, $userStartMonth, $userStartYear, $userEndMonth, $userEndYear){
    global $con;
    
    $result = mysqli_query($con, "INSERT INTO userexperiencetable (emailID, userEmployer, jobTitle, location, description, country, stillWorkHere, startDateMonth, startDateYear, endDateMonth, endDateYear) values('$userEmail', '$userEmployer', '$userJobTitle', '$userLocation', '$userDescription', '$userCountry', '$userStillWorkWhere',
                                  '$userStartMonth', '$userStartYear', '$userEndMonth', '$userEndYear');") or die("Failed to execute Add user experience".mysql_error());
         
         return TRUE;

    
    
}


function updateUserExperience($tempID, $userEmployer, $userJobTitle, $userLocation, $userDescription, $userCountry, $userStillWorkWhere, $userStartMonth, $userStartYear, $userEndMonth, $userEndYear){
    
    global $con;
    
    
    $query = "UPDATE userexperiencetable SET userEmployer ='$userEmployer', jobTitle='$userJobTitle', location='$userLocation', description='$userDescription', country='$userCountry', stillWorkHere='$userStillWorkWhere', startDateMonth='$userStartMonth', startDateYear='$userStartYear', endDateMonth='$userEndMonth', endDateyear='$userEndYear' WHERE expID = '$tempID'";
    mysqli_query($con, $query);
    
    return TRUE;
    
    
}


function getAllUserOldExperience($userEmail){
    
    global $con;

    $query = "SELECT * FROM userexperiencetable WHERE stillWorkHere='' && emailID='$userEmail' "
            . "ORDER BY `expID` ASC";
    $result = mysqli_query($con, $query);        
    
    return $result;
    
}

function getAllUserCurrentJob($userEmail)
{
    global $con;

    $query = "SELECT * FROM userexperiencetable WHERE stillWorkHere='Current' && emailID ='$userEmail' " . "ORDER BY `expID` ASC";;
    $result = mysqli_query($con, $query);        
    
    
    return  $result;
}


function deleteUserExperience($userexpID){
    
    global $con;

    $query = "DELETE FROM `userexperiencetable` WHERE expID='$userexpID' ";
            
    $result = mysqli_query($con, $query) or die("Failed to execute delete user experience".mysql_error());        
    
    return true;
    
}

function getUserEmployer($ID)
{
    global $con;

    $query = "SELECT userEmployer FROM userexperiencetable WHERE expID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['userEmployer'];
}



function getUserJobTitle($ID)
{
    global $con;

    $query = "SELECT jobTitle FROM userexperiencetable WHERE expID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['jobTitle'];
}


function getUserJobLocation($ID)
{
    global $con;

    $query = "SELECT location FROM userexperiencetable WHERE expID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['location'];
}

function getUserJobDescription($ID)
{
    global $con;

    $query = "SELECT description FROM userexperiencetable WHERE expID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['description'];
}


function getUserJobCountry($ID)
{
    global $con;

    $query = "SELECT country FROM userexperiencetable WHERE expID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['country'];
}


function getUserWorkStatus($ID)
{
    global $con;

    $query = "SELECT stillWorkHere FROM userexperiencetable WHERE expID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['stillWorkHere'];
}


function getUserStartMonth($ID)
{
    global $con;

    $query = "SELECT startDateMonth FROM userexperiencetable WHERE expID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['startDateMonth'];
}

function getUserStartYear($ID)
{
    global $con;

    $query = "SELECT startDateYear FROM userexperiencetable WHERE expID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['startDateYear'];
}

function getUserEndMonth($ID)
{
    global $con;

    $query = "SELECT endDateMonth FROM userexperiencetable WHERE expID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['endDateMonth'];
}

function getUserEndYear($ID)
{
    global $con;

    $query = "SELECT endDateYear FROM userexperiencetable WHERE expID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['endDateYear'];
}






///////////Update User Education
function insertUserEducation($userEmail, $user_eduschoolName,  $user_edudegreeLevel,  $user_edudegreeName, $user_educountry, $user_edulocation, $user_edustartDateMonth, $user_edustartDateYear, $user_eduendDateMonth, $user_eduendDateYear){
    
    global $con;
    
    $result = mysqli_query($con, "INSERT INTO usereduTable (eduEmail, eduSchoolName, eduDegreeLevel, eduDegreeName, eduCountry, eduLocation, eduStartMonth, eduStartYear, eduEndMonth, eduEndYear) values('$userEmail', '$user_eduschoolName', '$user_edudegreeLevel', '$user_edudegreeName', '$user_educountry', '$user_edulocation', '$user_edustartDateMonth', '$user_edustartDateYear', '$user_eduendDateMonth', '$user_eduendDateYear');") or die("Failed to execute Add user Education".mysql_error());
         
         return TRUE;
    
}


function updateUserEducation($tempID, $user_eduschoolName,  $user_edudegreeLevel,  $user_edudegreeName, $user_educountry, $user_edulocation,                                                     $user_edustartDateMonth, $user_edustartDateYear, $user_eduendDateMonth, $user_eduendDateYear){
    
    global $con;
    
    
    $query = "UPDATE usereduTable SET eduSchoolName ='$user_eduschoolName', eduDegreeLevel='$user_edudegreeLevel', " . " eduDegreeName='$user_edudegreeName', eduCountry='$user_educountry', eduLocation='$user_edulocation', eduStartMonth='$user_edustartDateMonth', eduStartYear='$user_edustartDateYear', eduEndMonth='$user_eduendDateMonth', eduEndYear='$user_eduendDateYear' WHERE eduID = '$tempID'";
    mysqli_query($con, $query);
    
    return TRUE;
    
    
}



function getAllUserEducation($userEmail){
    
    global $con;

    $query = "SELECT * FROM usereduTable WHERE eduEmail='$userEmail' "
            . "ORDER BY `eduID` ASC";
    $result = mysqli_query($con, $query);        
    
    return $result;
    
}


function deleteUserEducation($userexpID){
    
    global $con;

    $query = "DELETE FROM `usereduTable` WHERE eduID='$userexpID' ";
            
    $result = mysqli_query($con, $query) or die("Failed to execute delete user education".mysql_error());        
    
    return true;
    
}

function getUserSchoolName($ID)
{
    global $con;

    $query = "SELECT eduSchoolName FROM usereduTable WHERE eduID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['eduSchoolName'];
}


function getUserDegreeLevel($ID)
{
    global $con;

    $query = "SELECT eduDegreeLevel FROM usereduTable WHERE eduID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['eduDegreeLevel'];
}


function getUserDegreeName($ID)
{
    global $con;

    $query = "SELECT eduDegreeName FROM usereduTable WHERE eduID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['eduDegreeName'];
}


function getUserEduCountry($ID)
{
    global $con;

    $query = "SELECT eduCountry FROM usereduTable WHERE eduID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['eduCountry'];
}


function getUserEduLocation($ID)
{
    global $con;

    $query = "SELECT eduLocation FROM usereduTable WHERE eduID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['eduLocation'];
}


function getUserEduStartMonth($ID)
{
    global $con;

    $query = "SELECT eduStartMonth FROM usereduTable WHERE eduID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['eduStartMonth'];
}


function getUserEduStartYear($ID)
{
    global $con;

    $query = "SELECT eduStartYear FROM usereduTable WHERE eduID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['eduStartYear'];
}


function getUserEduEndMonth($ID)
{
    global $con;

    $query = "SELECT eduEndMonth FROM usereduTable WHERE eduID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['eduEndMonth'];
}


function getUserEduEndYear($ID)
{
    global $con;

    $query = "SELECT eduEndYear FROM usereduTable WHERE eduID='$ID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['eduEndYear'];
}





///////////////////////// REVIEW PAGE

function getNroStarsComments($userEmail, $numStars){
    global $con;

    $query = "SELECT COUNT(*) as total FROM commentTable WHERE receiverID='$userEmail' AND stars='$numStars'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    
    return $row['total'];   
}




////// NOTIFICATIONS PAGE
function newNotification($email, $message){
    global $con;

    mysqli_query($con,
                "INSERT INTO alertsTable (email,message) "
                . "values('$email', '$message');"
                );
    
    return TRUE;
    
}

function getNroNewNotifications($userEmail){
    global $con;

    $query = "SELECT COUNT(*) as total FROM alertsTable WHERE email='$userEmail'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    
    return $row['total'];   
}

            
function getTotalNotifications($userEmail){
    global $con;

    $query = "SELECT COUNT(*) as total FROM alertsTable WHERE email='$userEmail'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    
    return $row['total'];   
}
            
function getNotifications($userEmail, $start_from){
    global $con;

    $query = "SELECT * FROM alertsTable WHERE email='$userEmail' ORDER BY orderNum DESC LIMIT $start_from, 10";
    $result = mysqli_query($con, $query);
    
    return $result;
}

function getLastNotifications($userEmail){
    global $con;

    $query = "SELECT orderNum FROM alertsTable WHERE email='$userEmail' ORDER BY orderNum DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    
    return $result;
}

function getUserLastNotification($userEmail){
    global $con;

    $query = "SELECT lastNotification FROM userTable WHERE email='$userEmail'";
    $result = mysqli_query($con, $query);
    
    return $result;
}

function checkNotifications($userEmail, $lastNotification){
    global $con;
    
    $query = "UPDATE userTable SET lastNotification ='$lastNotification' "
            . " WHERE email = '$userEmail'";
    mysqli_query($con, $query);
    
    return TRUE;
}
            
     
///// SELECT APPLICANT
function selectApplicant($userEmail, $jobID){
    global $con;
    
    $query = "UPDATE appTable SET selectedEmployee=1 "
            . " WHERE employeeID='$userEmail' AND jobID='$jobID'";
    mysqli_query($con, $query);
    closePost($jobID);
    
    return TRUE;
}

function isApplicantSelected($userEmail, $jobID){
    global $con;
    
    $query = "SELECT selectedEmployee FROM appTable "
            . " WHERE jobID='$jobID' AND selectedEmployee=1 AND employeeID='$userEmail'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    
    return $row['selectedEmployee'];  
}

function clearApplicant($userEmail, $jobID){
    global $con;
    
    $query = "UPDATE appTable SET selectedEmployee=0 "
            . " WHERE employeeID='$userEmail' AND jobID='$jobID'";
    mysqli_query($con, $query);
    closePost($jobID);
    
    return TRUE;    
}

function isSelected($jobID){
    global $con;
    
    $query = "SELECT selectedEmployee FROM appTable "
            . " WHERE jobID='$jobID' AND selectedEmployee=1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    
    return $row['selectedEmployee'];  
}


/////////////new messsaging system
function insertMessage($jobID, $userEmail, $userReceiver){


  global $con;
     
  $query = "INSERT INTO userinboxtable(jobID, senderEmail, receiverEmail) values('$jobID','$userEmail','$userReceiver')";
  mysqli_query($con, $query);
    
  return TRUE;  


}


function getInboxID(){
    
    global $con;
    
    $query = "SELECT MAX(inboxID) as inboxID FROM userinboxtable"; 
    
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    return $row['inboxID'];   
    
}





function insertDataInboxSender($iD, $jobID, $recipient_message, $userEmail, $idToSenderAndReciever, $sentMessage){

 global $con;
     
  $query = "INSERT INTO datainboxtable(inboxID, jobID, message, senderEmail, receiverEmail ,msgStatus) values('$iD','$jobID', '$recipient_message', '$userEmail', '$idToSenderAndReciever', '$sentMessage')";
  mysqli_query($con, $query);
    
  return TRUE; 
    
}



function insertDataInboxReceiver($iD, $jobID, $recipient_message, $idToSenderAndReciever ,$userEmail, $sentMessage){

 global $con;
     
  $query = "INSERT INTO datainboxtable(inboxID, jobID, message, receiverEmail, senderEmail ,msgStatus) values('$iD','$jobID', '$recipient_message', '$idToSenderAndReciever' ,'$userEmail', '$sentMessage')";
  mysqli_query($con, $query);
    
  return TRUE;
    
}




function getMyInbox($userEmail){
    
    
     global $con;
    
     $query = "SELECT  MAX(dataID) as dataID, inboxID, jobID, message, senderEmail, receiverEmail,  msgStatus, datesend FROM datainboxtable WHERE receiverEmail='$userEmail' AND (msgStatus='Unread' OR msgStatus='Read') GROUP BY jobID"; 
    
     $result = mysqli_query($con, $query);
    

     return $result;
    
    
}


function getMyMessageByID($ID){
    
    global $con;
    
    $query = "SELECT message FROM datainboxtable WHERE dataID='$ID'"; 
    
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    return $row['message'];

}



function getDateSendByID($ID){
    
    global $con;
    
    $query = "SELECT datesend FROM datainboxtable WHERE dataID='$ID'"; 
    
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    return $row['datesend'];

}


function updateMyNumberofMessages($jobID, $userEmail){
     global $con;
    
     $query = "UPDATE datainboxtable SET msgStatus='Read' WHERE receiverEmail='$userEmail' AND jobID='$jobID' AND msgStatus='Unread'";
     $result = mysqli_query($con,$query );
    
      return TRUE;
    
}



function checkIfThereisHistory($jobID, $userEmail, $recipient){
    
    global $con;

    $query = "SELECT COUNT(*) as total FROM userinboxtable WHERE jobID='$jobID' AND (senderEmail='$userEmail' AND receiverEmail='$recipient') OR (senderEmail='$recipient' AND receiverEmail='$userEmail')";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    return $row['total'];

}


function loadHistory($jobID){
    
   global $con;

    $query = "SELECT * FROM datainboxtable WHERE jobID='$jobID' GROUP BY inboxID";
    $result = mysqli_query($con, $query);
    
    return $result;
    
}

function getMessageStatusByID($ID){
    
    global $con;
    
    $query = "SELECT msgStatus FROM datainboxtable WHERE dataID='$ID'"; 
    
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    return $row['msgStatus'];

}

function countMyNewMesssages($userEmail)
{
    
    global $con;

    $query = "SELECT COUNT(*) as total FROM datainboxtable WHERE receiverEmail='$userEmail' AND msgStatus='Unread'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    return $row['total'];
    
}

function countMyNewMesssagesByID($userEmail, $jobID)
{
    
    global $con;

    $query = "SELECT COUNT(*) as total FROM datainboxtable WHERE receiverEmail='$userEmail' AND msgStatus='Unread' AND jobID='$jobID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    return $row['total'];
    
}

function getAllSentMessage($userEmail){
    
     global $con;
    
       $query = "SELECT  MAX(dataID) as dataID, inboxID, jobID, message, senderEmail, receiverEmail,  msgStatus, datesend FROM datainboxtable WHERE senderEmail='$userEmail' AND msgStatus='Sent' GROUP BY jobID"; 
    
    $result = mysqli_query($con,$query );
    

     return $result;

}

function moveMessageToTrash($userEmail, $status){
     global $con;
    
     $query = "UPDATE datainboxtable SET msgStatus='$status' WHERE receiverEmail='$userEmail' AND (msgStatus='Unread' || msgStatus='Read')";
     $result = mysqli_query($con,$query );
    
      return TRUE;
    

}

function moveMessageToTrashByDataID($dataID, $jobID){
     global $con;
    
     $query = "UPDATE datainboxtable SET msgStatus='Trash' WHERE dataID='$dataID' AND jobID='$jobID' AND (msgStatus='Unread' || msgStatus='Read')";
     $result = mysqli_query($con,$query);
    
      return TRUE;   

}

function moveMessageToDeleteByID($dataID, $jobID){
     global $con;
    
     $query = "UPDATE datainboxtable SET msgStatus='Deleted' WHERE dataID='$dataID' AND jobID='$jobID' AND (msgStatus='Trash' || msgStatus='Sent')";
     $result = mysqli_query($con,$query);
    
      return TRUE;   

}


function moveMessageToDelete($userEmail, $status){
     global $con;
    
     $query = "UPDATE datainboxtable SET msgStatus='$status' WHERE senderEmail='$userEmail' AND msgStatus='Sent'";
     $result = mysqli_query($con,$query );
    
      return TRUE;

}


function getAllDeleteMessages($userEmail){
    
     global $con;
    
       $query = "SELECT  MAX(dataID) as dataID, inboxID, jobID, message, senderEmail, receiverEmail,  msgStatus, datesend FROM datainboxtable WHERE receiverEmail='$userEmail' AND msgStatus='Trash' GROUP BY jobID"; 
    
    $result = mysqli_query($con,$query );
    

     return $result;

}


function deleteAllTrashMessage($userEmail, $status){
     global $con;
    
     $query = "UPDATE datainboxtable SET msgStatus='$status' WHERE receiverEmail='$userEmail' AND msgStatus='Trash'";
     $result = mysqli_query($con,$query );
    
      return TRUE;

}



function deleteMessagePermanent($userEmail){
     global $con;
  
     $query = "SELECT jobID FROM userinboxtable WHERE senderEmail='$userEmail' GROUP BY jobID";
     $result = mysqli_query($con,$query );
    
      return $result;

}





function countMessageStatusDeleted($jobID){
    
    global $con;

    $query = "SELECT COUNT(*) as total FROM datainboxtable WHERE jobID = '$jobID' AND msgStatus='Deleted'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    return $row['total'];
    
}

function countJobIDinTheDataInbox($jobID){
    
    global $con;

    $query = "SELECT COUNT(*) as total FROM datainboxtable WHERE jobID = '$jobID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    
    return $row['total'];
    
}

function deleteDataInboxByJobID($jobID){
  
  global $con;

  $query = "DELETE FROM datainboxtable WHERE jobID='$jobID'";
  $result = mysqli_query($con, $query) or die("Failed to delete msg in the datainbox".mysql_error());        
    
   return true;
    
}

function deleteTheInboxIdInUserTable($jobID){
     
  global $con;

  $query = "DELETE FROM userinboxtable WHERE jobID='$jobID'";
  $result = mysqli_query($con, $query) or die("Failed to  delete user jobID in the userinboxTable".mysql_error());        
    
   return true;
}





function deleteMSG($userEmail){

                    //Slow DELETE NEED TO CHANGE THIS!!!!!!!!!!!!!!!!!!!!!!!!!!
                    $result = deleteMessagePermanent($userEmail);
                    
                    if(!empty($result)){
                       
                        $countDeletedMSG=0;
                        $countJobID=0;
                        
                        //get all userEmail inboxID
                        while($row = mysqli_fetch_assoc($result)){
                            
                            
                            $countJobID = countJobIDinTheDataInbox($row['jobID']);
                            $countDeletedMSG = countMessageStatusDeleted($row['jobID']);
                            
                             //if True then all the all messages
                             if($countJobID == $countDeletedMSG){
                                   
                                   //Delete all message by ID in the datainboxtable
                                   deleteDataInboxByJobID($row['jobID']);
                                 
                                    //Then delete the InboxId in the userinboxTable
                                    deleteTheInboxIdInUserTable($row['jobID']);
                                                                       
                                            }               
                            
                                        }
                                                
                                }
   
}


/////////////////////////////////


function isAdmin($userEmail)
{
    global $con;

    $query = "SELECT admin FROM usertable WHERE email='$userEmail' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['admin'];
}

function selectedApplicant($jobID){
    global $con;

    $query = "SELECT applicantSelected FROM jobtable WHERE jobID='$jobID' ";
    $result = mysqli_query($con, $query);        
    $row = mysqli_fetch_assoc($result);
    
    return $row['applicantSelected'];
}

function applicantSelected($applicantEmail, $jobID){
    global $con;
    
    $query = "UPDATE appTable SET selectedEmployee='1' WHERE employeeID='$applicantEmail' AND jobID='$jobID'";
    $result = mysqli_query($con,$query );
    
      return TRUE;
}

function applicantConfirmed($applicantEmail, $jobID){
    global $con;
    
    $query = "UPDATE jobtable SET applicantSelected='$applicantEmail' WHERE jobID='$jobID'";
    $result = mysqli_query($con,$query );
    
      return TRUE;
}


function createPayment($jobID, $employeerEmail, $employeeEmail, $amount)
{
    global $con;
    $code = generateRandomString();
    
    mysqli_query($con,
                "INSERT INTO paymenttable (jobID, employeerEmail, employeeEmail, amount) "
                . "values('$jobID', '$employeerEmail', '$employeeEmail', '$amount');"
                );
    
    $payment = retrievePayment($jobID);

    mysqli_query($con,
                "UPDATE jobtable SET paymentID='$payment' WHERE jobID='$jobID'"
                );
    
    mysqli_query($con,
                "INSERT INTO historytable (userEmail, jobID) "
                . "values('$employeeEmail', '$jobID');"
                );
    
    
    
    return TRUE;    
}

function retrievePayment($jobID){
    global $con;

    $query = "SELECT paymentID FROM paymenttable WHERE jobID='$jobID' ORDER BY paymentID DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    
    return $row['paymentID'];   
}

function isPayment($jobID){
    global $con;

    $query = "SELECT COUNT(*) as total FROM paymenttable WHERE jobID='$jobID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    
    return $row['total'];   
}

function isPaymentDone($jobID){
    global $con;

    $query = "SELECT initialstatus FROM paymenttable WHERE jobID='$jobID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    return $row['initialstatus'];   
}

function isPaymentRejected($jobID){
    global $con;
    $query = "SELECT clearstatus FROM paymenttable WHERE jobID='$jobID' ORDER BY paymentID DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    return $row['clearstatus'];  
}



function submitPayment($jobID){
    global $con;
    
    $query = "UPDATE paymentTable SET initialStatus='1' WHERE jobID='$jobID' ORDER BY paymentID DESC LIMIT 1";
    $result = mysqli_query($con,$query );
    
      return TRUE;
}

function getPayments(){
    global $con;
    
    $query = "SELECT * FROM paymentTable WHERE initialstatus='1' ORDER BY submitTime DESC";
    $result = mysqli_query($con,$query);
    
    return $result;
}

function clearPayment($jobID, $paymentID){
    global $con;
    
    $query = "UPDATE paymentTable SET clearstatus='1' WHERE jobID='$jobID' AND paymentID='$paymentID'";
    $result = mysqli_query($con,$query );
    
    $applicant = selectedApplicant($jobID);
    
    mysqli_query($con,
                "UPDATE historyTable SET completestat='1' WHERE jobID='$jobID' AND userEmail='$applicant' AND completestat='0'"
                );    
    
    return TRUE;
}

function denyPayment($jobID, $paymentID){
    global $con;
    
    $query = "UPDATE paymentTable SET clearstatus='2' WHERE jobID='$jobID' AND paymentID='$paymentID'";
    $result = mysqli_query($con,$query );
    
    //$applicant = selectedApplicant($jobID);
    
    //mysqli_query($con,
      //          "UPDATE historyTable SET completestat='2' WHERE jobID='$jobID' AND userEmail='$applicant' AND completestat='0'"
        //        );
    
    //mysqli_query($con,
      //          "UPDATE jobTable SET applicantSelected='na' AND paymentID = '0' "
        //    . "WHERE jobID='$jobID'"
          //      );
    
    
    
    
    return TRUE;
}

function isPaymentClear($jobID, $paymentID){
    global $con;

    $query = "SELECT clearstatus FROM paymenttable WHERE jobID='$jobID' AND paymentID='$paymentID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    return $row['clearstatus'];   
}

function getReceiverPayment($jobID, $paymentID){
    global $con;

    $query = "SELECT employeeEmail FROM paymenttable WHERE jobID='$jobID' AND paymentID='$paymentID' ";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    return $row['employeeEmail'];   
}

/////////////////////////////
function cancelPayment($jobID, $paymentID){
    global $con;
    
    $query = "UPDATE paymentTable SET clearstatus='3' WHERE jobID='$jobID' AND paymentID='$paymentID'";
    $result = mysqli_query($con,$query );
    
    $applicant = selectedApplicant($jobID);
    
    mysqli_query($con,
                "UPDATE historyTable SET completestat='2' WHERE jobID='$jobID' AND userEmail='$applicant' AND completestat='0'"
                );
    
    $jobTitle = getJobTitle($jobID);
    
    newNotification( $applicant , "<strong> ". $jobTitle ." </strong> :: The employer has cancel the payment. Therefore the service was cancelled"
            . ". <a href=\"postComplete.php?jobID=" . $jobID . "\" target=\"_parent\">Click here </a> to review the job" ); 
    
    
    mysqli_query($con,
                "UPDATE jobTable SET applicantSelected='na', paymentID = '0' WHERE jobID='$jobID'"
                );

    
    clearApplicant($applicant, $jobID);
    
    return TRUE;
}

function resubmitPayment($jobID, $paymentID){
    global $con;
    
    $query = "UPDATE paymentTable SET clearstatus='0' WHERE jobID='$jobID' AND paymentID='$paymentID'";
    $result = mysqli_query($con,$query );
    
    return TRUE;
}

function employeeCompletedJob($jobID){
    global $con;
    $paymentID = retrievePayment($jobID);
    
    $query = "SELECT completeEmployee FROM paymenttable WHERE jobID='$jobID' AND paymentID='$paymentID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    return $row['completeEmployee'];   
}

function verifyJobCompleted($jobID){
    global $con;
    $paymentID = retrievePayment($jobID);
    
    $query = "SELECT completeEmployer FROM paymenttable WHERE jobID='$jobID' AND paymentID='$paymentID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    return $row['completeEmployer'];    
}

function completePaymentEmployee($jobID){
    global $con;
    
    $paymentID = retrievePayment($jobID);
    $query = "UPDATE paymentTable SET completeEmployee='1' WHERE jobID='$jobID' AND paymentID='$paymentID'";
    $result = mysqli_query($con,$query );
    
    return TRUE;
}

function completePaymentEmployer($jobID){
    global $con;
    $paymentID = retrievePayment($jobID);
    $query = "UPDATE paymentTable SET completeEmployer='1' WHERE jobID='$jobID' AND paymentID='$paymentID'";
    $result = mysqli_query($con,$query );
    
    return TRUE;
}

function isJobCompleted($jobID){
    global $con;
    $paymentID = retrievePayment($jobID);
    
    $query = "SELECT finished FROM paymenttable WHERE jobID='$jobID' AND paymentID='$paymentID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    return $row['finished'];   
}




function getCompletedPayments(){
    global $con;
    
    $query = "SELECT * FROM paymentTable WHERE completeEmployee='1' AND completeEmployer='1' ORDER BY submitTime DESC";
    $result = mysqli_query($con,$query);
    
    return $result;
}

function forwardPayment($jobID){
    global $con;
    
    $paymentID = retrievePayment($jobID);
    
    
    $query = "UPDATE paymentTable SET finished='1' WHERE jobID='$jobID' AND paymentID='$paymentID'";
    $result = mysqli_query($con,$query );
    
    $applicant = selectedApplicant($jobID);
    
    $jobOwner = getJobOwner($jobID);
 
    $jobTitle = getJobTitle($jobID);
    
    newNotification( $applicant , "<strong> ". $jobTitle ." </strong> :: ServiceU has forward you the payment to your PayPal account from this service"
            . ". <a href=\"postComplete.php?jobID=" . $jobID . "\" target=\"_parent\">Click here </a> to review the job" ); 
        
    newNotification( $jobOwner , "<strong> ". $jobTitle ." </strong> :: ServiceU has forward the payment to your employer. Thank you for using ServiceU"
            . ". <a href=\"postComplete.php?jobID=" . $jobID . "\" target=\"_parent\">Click here </a> to review the job" ); 
       
    
   // mysqli_query($con,
     //           "UPDATE historyTable SET completestat='1' WHERE jobID='$jobID' AND userEmail='$applicant' AND completestat='0'"
     //           );    
    
    return TRUE;
}

function isReviewSubmitted($jobID){
    global $con;

    $query = "SELECT COUNT(*) as total FROM commenttable WHERE jobID='$jobID'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_Assoc($result);
    
    return $row['total'];   
}

function submitNewReview($receiverID, $senderID, $comment, $stars, $recommend, $jobID){
    global $con;
    
    mysqli_query($con,
                "INSERT INTO commentTable (receiverID, senderID, comment, stars, recommend, jobID) "
                . "values('$receiverID', '$senderID', '$comment', '$stars', '$recommend', '$jobID');"
                );
    
     $jobTitle = getJobTitle($jobID);
    newNotification( $receiverID , "<strong> ". $jobTitle ." </strong> :: You have received a review from this job. "
            . ". <a href=\"postComplete.php?jobID=" . $jobID . "\" target=\"_parent\">Click here </a> to review the job" ); 
       
    
    
    return TRUE;        
}






?>