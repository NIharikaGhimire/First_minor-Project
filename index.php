
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Movie Theater | Seat Reservation
           
        </title>

        <link src="admin/assets/font-awesome/css/all.js"/>
        <script src="admin/assets/vendor/jquery/jquery.min.js"></script>
        <script src="admin/assets/font-awesome/js/all.js"></script>
       <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">

        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav" style="background: #00dcff;">
            <div class="container">
                <div style="display: flex; flex-direction: column;">
                    <div>
                        <h3 class="text-primary">Theater Seat Booking</h3>
                    </div>
                     <?php if(isset($_GET['page'])) :?>
                    <div>
                      <a href="index.php" style="color: white;">&#8592; Go Back  </a>
                    </div>
                <?php endif; ?>
                </div>
            <?php session_start();?>

                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                 <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link" > <?php echo $_SESSION['user']?></a></li> 
                      <!--  href="Staticindex.php?page=home -->

                        <li class="nav-item"><a class="nav-link" href="Staticindex.php">Logout</a></li>
                       
 
                    </ul>
                </div>
            </div> 
        </nav>
       <?php

       $page = isset($_GET['page']) ? $_GET['page'] : 'home';
       include($page.'.php');
       ?>
        <!-- Footer-->
        <footer class="bg-light py-5">
            <div class="container"><div class="small text-center text-muted">Movie Theater Seat Reservation System</div></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://js.stripe.com/v2/"></script>
        <script>
  Stripe.setPublishableKey('pk_test_51JQl6tSEid0sNiv5NGGvOscQmDMm2iG21tymT4XxbOaGlL4AHCALFpgkK5hDtgXdaVh39j1djrLPC5FAwtbKokVR00swwUKXsP');
</script>
   
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>