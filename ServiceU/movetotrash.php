<?php 
    include("DatabaseFunctions.php"); 
    include("functions.php");
?>


<?php
    if(!empty(isset($_GET['dID'])) && !empty(isset($_GET['jID'])))
        {
       
            //PROMPT THE USER IF WANTS TO DELETE OR CANCEL
            /*$message = "This will delete your experience, are you sure?";
            echo "<script type='text/javascript'>
            
                    if(confirm('$message') == true){               
                            
                    }
            
            </script>";*/
        
            //echo $inboxID = $_GET["dID"];
          // echo  $jobID = $_GET['jID'];
        
           moveMessageToTrashByDataID($inboxID, $jobID);
           echo "<meta http-equiv='refresh' content='0;url=inbox.php'>";
        
         
        }


?>