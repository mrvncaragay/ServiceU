<!DOCTYPE html>
<?php
include("DatabaseFunctions.php");
include("functions.php");
$db = mysql_connect("us-cdbr-azure-central-a.cloudapp.net", "b1d6ea18aa71c7", "d41e125d");
mysql_select_db("serviceuDB", $db);
//$con=mysqli_connect("us-cdbr-azure-central-a.cloudapp.net","b1d6ea18aa71c7","d41e125d","serviceuDB");

// $result = mysql_query("SELECT * FROM jobtable", $link);

//$_POST['search']=mysql_real_escape_string($_POST['search']);
//if(!isset($_POST['search'])){
  //header("Location:services.php");

$result = mysql_query("SELECT * FROM jobtable WHERE jobTitle LIKE '%doctor%' OR jobDescription LIKE '%doctor%' OR category LIKE '%doctor%'" , $db);

// echo 'Results'.$result;
if(mysql_num_rows($result) != 0){
  $search_rs=mysql_fetch_assoc($result);
}
?>


<!-- <?php
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

?> -->


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
    <div class="panel panel-default  text-left">
      <div class="panel-heading">
        <span class=" h1 text-center">Search Results <span class="pull-right"><?php echo mysql_num_rows($result) ?> results</span></span>
      </div>
      <div class="panel-body">
        <?php
      if (mysql_num_rows($result)!=0){
        do{ ?>

          <!-- <p> <?php echo $search_rs['jobTitle']; ?> </p> -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <a style="color: blue" class="h2" href="postComplete.php?jobID=<?php echo $search_rs['jobID']; ?>">
                <strong>
            <?php echo $search_rs['jobTitle']; ?>
                </strong>

                <label class="label label-success pull-right">$<?php echo $search_rs['payment'] ?></label>
              </a>
            </div>
            <div class="panel-body">
            <?php echo $search_rs['jobDescription']; ?>
          </div>
        </div>
          <hr style="border-color: #D8D8D8" />
          <?php
        } while($search_rs=mysql_fetch_assoc($result));
      } else {
        echo "Results not found";
      }
      ?>
      </div>
  </div>

    <div class="row">

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
<script src="js/bootbox.js"></script>
<script src="js/bootbox.min.js"></script>

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
