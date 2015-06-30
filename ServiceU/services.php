<!DOCTYPE html>
<html lang="en">
<?php 
    include("DatabaseFunctions.php"); 
    include("functions.php");
?>
<?php 
session_start();
  if (!isset($_SESSION["loginEmail"]))
   {
      header("location: index.php");
      exit();
   }
   else{
       $userEmail = $_SESSION["loginEmail"];
    }
   
?>
    
    
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ServiceU</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    
    <!--Customized CSS-->
    <link rel="stylesheet" href="css/mycss.css">
    
</head>

    
<body>

<!-- Navigation Sidebar -->
    <?php include 'navigationbar.php' ?>
    <?php //include 'postInfo.php' ?>
<!-- About -->


<div class="container">


    <div class="well text-center">


            <div class="row">
              <div class="col-md-4">

                <input type="text" class="form-control" id="serviceTop" placeholder="Job title">


              </div>
              <div class="col-md-4">

                <input type="text" class="form-control" id="serviceTop" placeholder="Skills">

              </div>
              <div class="col-md-4">

                <input type="text" class="form-control" id="serviceTop" placeholder="City, State">

              </div>

            </div>

    </div>


<div class="well well-lg">
<div class="row text-center">
    <div class="col-lg-10 col-lg-offset-1">
        <h2>Services</h2>
            <hr class="small">
 
            <div class="row">
             <div class="left-square">
                    <div class="left-side">
                        <div id="result">
                            
                            <iframe src="servicesPosts.php"></iframe>
                        </div>
                                          
                    </div>
                        
                        </div>
                            
                        </div>
                </div>
                <!-- /.col-lg-10 -->
            </div>
            <!-- /.row -->
        </div>
</div>





    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/bootbox.js"></script>
    <script src="js/bootbox.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    
    <!-- Custom for project -->
    <script src="js/editProfileactions.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <!--Bootstrap JSS-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>


    <!--Customized JSS-->
    <script src="js/myjs.js"></script>


    <!--change acive mode in the navbar-->
    <script> 

        $(".nav a").on("click", function(){
           $(".nav").find(".active").removeClass("active");
           $(this).parent().addClass("active");
        });

    </script>
    
    </script>
     

</body>
</html>
