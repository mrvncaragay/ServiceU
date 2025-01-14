
<!DOCTYPE html>
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

    if (isset($_POST['createJob'])) {

        $jobTitle = $_POST['jobTitle'];
        $jobDescription = $_POST['jobDescription'];
    $jobPayment = $_POST['jobPayment'];
    $jobCategory = $_POST['jobCategory'];

        createPost($userEmail, $jobTitle, $jobDescription, $jobPayment, $jobCategory);
        echo '<script type="text/javascript">';
        echo 'alert("Your post has been created")';
        echo '</script>';

    }

?>


<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ServiceU</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dashboardcss.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">
     <link href="css/stylish-portfolio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

</head>


<body>

<!-- Navigation Sidebar -->
    <?php include 'navigationbar.php' ?>

<div class="container">



		<div class="well text-left">
<!--
			<form action=
"https://www.paypal.com/webapps/adaptivepayment/flow/pay"
target="PPDGFrame">
<input id="type" type="hidden" name="expType" value="light">
<input id="paykey" type="hidden" name="paykey" value="AP-..."> 		<input id="preapprovalkey" 				type="hidden" name="preapprovalkey" value="PA-..."> 		<input type="submit" id="submitBtn" value="Pay with PayPal"> 	</form>
-->

<!--
	<script src="https://www.paypalobjects.com/js/external/apdg.js">
</script>


		</div>
<script 
    data-env="sandbox" 
    data-currency="USD" 
    data-amount="0" 
    data-quantity="1" 
    data-name="Service" 
    data-button="buynow" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant=serviceu@gmail.com" async="async"
></script>
-->

<!--use the paypal code below.  this is the most recent update 7/24/15 5:00pm -->
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="AKKK98HQR4UVU">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>





            <div class="row">

              <!--<div class="col-md-2">
                    <p>
                        <a class="btn btn-sm btn-warning btn-block" href="myjobpost.php" ><b>My Job Post</b></a>
                    </p>

                    <p>
                        <a class="btn btn-sm btn-warning btn-block" href="myapplications.php" ><b>My Applications</b></a>
                    </p>


              </div> -->
              <!--<div class="col-md-10">

                     <div class="well well-lg">

                                <header>

                                        <h2 class="wellHeader text-center"><b>My Job Post</b></h2>

                                </header>

                                <div class="rowAddjobpost">
                                        <span class="glyphicon glyphicon-wrench"> </span>
                                        <h3>Creating Job on ServiceU is effortless.</h3>
                                        <p>Start now to provide service to your local community!</p>
                                        <?php include('newPost.php'); ?>
                                        <a class="btn btn-success" href="#newPost" data-toggle="modal" data-target="#newPost" role="button">Create Job Now!</a>

                                </div>






                     </div>
              </div>-->



            </div>


</div> <!--End of container-->



<footer style="text-align: center;">

                <ul class="list-inline">
                  <li><a href="about.php">About</a></li>
                  <!--<li><a href="help.php">Help</a></li>-->
				  <li><a href="contactus.php">Contact Us</a></li>
                  <li><a href="#">Directory</a></li>
                  <li><h5 style="color: #aab8c2">&#169 2015 ServiceU, Inc, All rights reserved.</h5></li>
                </ul>

</footer>

</div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/bootbox.min.js"></script>
<script src="https://www.paypalobjects.com/js/external/dg.js">

</script>
<script>
var dgFlow = new PAYPAL.apps.DGFlow({ trigger: 'submitBtn' });

</script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script>

   $('[data-dismiss=modal]').on('click', function (e) {
        var $t = $(this),
            target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];

      $(target)
        .find("input,textarea")
           .val('')
           .end();

      $('select option:first-child').attr("selected", "selected");

    });
    </script>

    <!-- Custom for project -->
    <script src="js/editProfileactions.js"></script>
    <!--Start online JSS first-->
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

</body>
</html>
