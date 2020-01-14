<?php
require 'conectare.php';
session_start();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <!-- Required meta tags-->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->

    <title>Romania FTW</title>

    <!-- Fontfaces CSS-->

    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->

    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->

    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->

    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
<div class="page-wrapper">
    <?php
    $username=$_SESSION['Username'];
    $ledname="";

    if(isset($_POST['button1'])) {
        system("gpio -g mode 15 out");
        system("gpio -g write 15 1"); //red led on
        mysqli_query($conectare,"INSERT INTO `leds`(`Username`, `LedName`,`Date`) VALUES ('$username','RedLedON',NOW())");
    }
    if(isset($_POST['button2'])) {
        system("gpio -g write 15 0"); //red led off
        mysqli_query($conectare,"INSERT INTO `leds`(`Username`, `LedName`,`Date`) VALUES ('$username','RedLedOFF',NOW())");
    }

    if(isset($_POST['button3'])) {
        system("gpio -g mode 16 out");
        system("gpio -g write 16 1"); //yellow led on
        mysqli_query($conectare,"INSERT INTO `leds`(`Username`, `LedName`,`Date`) VALUES ('$username','YellowLedON',NOW())");
    }
    if(isset($_POST['button4'])) {
        system("gpio -g write 16 0"); //yellow led off
        mysqli_query($conectare,"INSERT INTO `leds`(`Username`, `LedName`,`Date`) VALUES ('$username','YellowLedOFF',NOW())");
    }


    if(isset($_POST['button5'])) {
        system("gpio -g mode 18 out");
        system("gpio -g write 18 1"); //green led on
        mysqli_query($conectare,"INSERT INTO `leds`(`Username`, `LedName`,`Date`) VALUES ('$username','GreenLedON',NOW())");
    }
    if(isset($_POST['button6'])) {
        system("gpio -g write 18 0");//green led off
        mysqli_query($conectare,"INSERT INTO `leds`(`Username`, `LedName`,`Date`) VALUES ('$username','GreenLedOFF',NOW())");
    }

    if(isset($_POST['button7'])) {
        system("gpio -g mode 22 out");
        system("gpio -g write 22 1"); //white led on
        mysqli_query($conectare,"INSERT INTO `leds`(`Username`, `LedName`,`Date`) VALUES ('$username','WhiteLedON',NOW())");
    }
    if(isset($_POST['button8'])) {
        system("gpio -g write 22 0");//white led off
        mysqli_query($conectare,"INSERT INTO `leds`(`Username`, `LedName`,`Date`) VALUES ('$username','WhiteLedOFF',NOW())");
    }

    //insert into datasets
    $output=file_get_contents("date.txt");
    $outputint = explode(",",$output);
    $lightlevel=(float)$outputint[0];     //Primul element e nivelul de lumina luat de tip string. Cu '(float)' se converteste la tipul real
    $humidity=(float)$outputint[2];      //Al doilea element e umiditatea luat de tip string.
    $pressure=(float)$outputint[3];      //Al treilea element e presiunea
    $temperature=(float)$outputint[1];   //Al patrulea element e temperatura


    /*$conne=mysqli_connect("localhost","marian","marian","bazabazei");*/
    $sql_insert="INSERT INTO `datasets`(`data`, `temperature`, `humidity`, `pressure`, `light`) values (NOW(),$temperature,$humidity,$pressure,$lightlevel)";
    //mysqli_query($conectare,$sql_insert);
    if(mysqli_query($conectare,$sql_insert)){echo "Records inserted!";}
    else "ERROR: Could not able to execute $sql_insert. " . mysqli_error($conectare);

    system("gpio -g mode 15 out");

    system("gpio -g mode 22 out");

    system("gpio -g mode 16 out");

    system("gpio -g mode 18 out");


    $sql_temp = "select * from ledstates";
    $result = mysqli_query($conectare,$sql_temp);
    $row = $result -> fetch_assoc();

    if($temperature >= $row['redLed'])

    {

        system("gpio -g mode 15 out");

        system("gpio -g write 15 1"); //red led on
        echo "<h2>Red led on</h2>";

    }


    else


    {

        system("gpio -g write 15 0"); //red led off

    }



    if($lightlevel >= $row['whiteLed'])

    {

        system("gpio -g mode 22 out");

        system("gpio -g write 22 1"); //white led on

    }

    else

    {

        system("gpio -g write 22 0"); //white led off

    }



    if($humidity > $row['yellowLed'])

    {


        system("gpio -g mode 16 out");
        system("gpio -g write 16 1"); //yellow led on

    }

    else

    {
        system("gpio -g write 16 0"); //yellow led off
    }

    $sql_pressure="select greenLed from ledstates";
    $pressureState = mysqli_query($conectare, $sql_pressure);



    if($pressure >= $row['greenLed'])

    {

        system("gpio -g mode 18 out");
        system("gpio -g write 18 1"); //green led on

    }

    else

    {

        system("gpio -g write 18 0"); //green led off

    }



    ?>
    <!-- HEADER MOBILE-->

    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="index.html">
                        <img src="images/icon/Untitled-2.png" alt="CoolAdmin" />
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">


                </ul>
            </div>
        </nav>
    </header>

    <!-- END HEADER MOBILE-->

    <!-- MENU SIDEBAR-->

    <aside class="menu-sidebar d-none d-lg-block">
        <div class="logo">
            <a href="#">
                <img src="images/icon/Untitled-2.png" alt="Cool Admin" />
            </a>
        </div>
        <div class="menu-sidebar__content js-scrollbar1">
            <nav class="navbar-sidebar">
                <ul class="list-unstyled navbar__list">

                    <li>

                        <?php
                        if(isset($_POST['btnSub']))
                            echo "<script>window.close();</script>";
                        ?>


                        <i class="fas fa-desktop"></i>
                        <input type="submit" name="btnSub" class="ml-2 btn btn-outline-secondary" value="Exit!">


                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->

    <div class="page-container">

        <!-- HEADER DESKTOP-->

        <header class="header-desktop">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap">
                        <form class="form-header">
                        </form>
                        <div class="header-button">
                            <div class="account-wrap">
                                <div class="clearfix">
                                    <div class=" content d-flex">
                                        <?php
                                        echo '<p class="text-danger display-6 flex-wrap links" >Welcome,&nbsp;</p>'.$_SESSION['Name'];echo'<p>&nbsp;!</p>'
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->

        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row m-t-25">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                                <div class="card-header">Temperature</div>
                                <div class="card-body">
                                    <h5 class="card-title">Most recent reading:</h5>
                                    <?php echo '<p class="card-text"></p>'.$temperature ?>&#8451
                                </div>
                            </div>




                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                                <div class="card-header">Humidity</div>
                                <div class="card-body">
                                    <h5 class="card-title">Most recent reading:</h5>
                                    <?php echo '<p class="card-text"></p>'.$humidity ?>%
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                                <div class="card-header"> Pressure</div>
                                <div class="card-body">
                                    <h5 class="card-title">Most recent reading:</h5>
                                    <?php echo '<p class="card-text"></p>'.$pressure ?> &nbsp; hPa
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                                <div class="card-header">Light level</div>
                                <div class="card-body">
                                    <h5 class="card-title">Most recent reading:</h5>
                                    <?php echo '<p class="card-text"></p>'.$lightlevel ?>&nbsp; lx
                                </div>
                            </div>
                        </div>



                        <div class="container-fluid">

                            <div class="row m-t-25">

                                <div class="col-sm-6 col-lg-3">

                                    <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">

                                        <?php $sql="select * from ledstates";
                                        $result=mysqli_query($conectare,$sql);
                                        $row = $result->fetch_assoc();

                                        echo '<div class="card-header">Temperature &nbsp; > '.$row['redLed'].'&#8451;</div>'?>



                                        <div class="card-body";>

                                            <h5 class="card-title">Insert:</h5>

                                            <div class="form-group">
                                                <form action="update.php" method="post">


                                                    <input class="form-control form-control-lg" type="text" name="inputtemperature" placeholder="Temperature">
                                                    <button type="submit" class="mt-2 text-center btn btn-outline-light ">Change!</button>
                                                </form>



                                            </div>

                                        </div>

                                    </div>



                                </div>

                                <div class="col-sm-6 col-lg-3">

                                    <div class="card text-white bg-info mb-3" style="max-width: 18rem;">

                                        <?php $sql="select * from ledstates";
                                        $result=mysqli_query($conectare,$sql);
                                        $row = $result->fetch_assoc();
                                        echo '<div class="card-header">Humidity &nbsp; > '.$row['yellowLed'].'%</div>'?>

                                        <div class="card-body">

                                            <h5 class="card-title">Insert:</h5>

                                            <div class="form-group">
                                                <form action="update.php" method="post">

                                                    <input class="form-control form-control-lg" type="text" name="inputhumidity" placeholder="humidity">

                                                    <button type="submit" class="mt-2 text-center btn btn-outline-light ">Change!</button>
                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-sm-6 col-lg-3">

                                    <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">

                                        <?php $sql="select * from ledstates";
                                        $result=mysqli_query($conectare,$sql);
                                        $row = $result->fetch_assoc();
                                        echo '<div class="card-header">Pressure &nbsp; > '.$row['greenLed'].'hPa</div>'?>

                                        <div class="card-body">

                                            <h5 class="card-title">Insert:</h5>

                                            <div class="form-group">
                                                <form action="update.php" method="post">

                                                    <input class="form-control form-control-lg" type="text" name="inputpressure" placeholder="pressure">

                                                    <button type="submit" class="mt-2 text-center btn btn-outline-light ">Change!</button>
                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-sm-6 col-lg-3">

                                    <div class="card text-white bg-success mb-3" style="max-width: 18rem;">

                                        <?php $sql="select * from ledstates";
                                        $result=mysqli_query($conectare,$sql);
                                        $row = $result->fetch_assoc();
                                        echo '<div class="card-header">Light &nbsp; > '.$row['whiteLed'].'lx</div>'?>

                                        <div class="card-body">

                                            <h5 class="card-title">Insert:</h5>

                                            <div class="form-group">
                                                <form action="update.php" method="post">

                                                    <input class="form-control form-control-lg" type="text" name="inputlight" placeholder="light-level">

                                                    <button type="submit" class="mt-2 text-center btn btn-outline-light ">Change!</button>
                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="row m-t-25">
                        <div class="col-sm-6 col-lg-3">
                            <form method="post">
                                <button type="submit" name="button1" value="Button1" class="ml-3 btn btn-outline-secondary ">Turn on!</button>


                                <button type="submit" name="button2" value="Button2" class="btn btn-outline-secondary ">Turn off!</button>


                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview__inner">
                                <button type = "submit" name="button3" value="Button3" class="ml-3 btn btn-outline-info ">Turn on!</button>
                                <button type = "submit" name="button4" value="Button4" class="btn btn-outline-info">Turn off!</button>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="overview__inner">
                                <button type = "submit" name="button5" value="Button5" class="ml-3 btn btn-outline-danger ">Turn on!</button>
                                <button type = "submit" name="button6" value="Button6" class="btn btn-outline-danger">Turn off!</button>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <button type = "submit" name="button7" value="Button7" class="ml-3 btn btn-outline-success ">Turn on!</button>
                            <button type = "submit" name="button8" value="Button8" class="btn btn-outline-success ">Turn off!</button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mt-5 table-responsive table--no-card m-b-40">
                                <table class="table table-borderless table-striped table-earning">
                                    <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Led Name</th>
                                        <th>Timestamp</th>
                                    </tr>
                                    <?php
                                    $sql="SELECT Username, LedName, Date FROM `leds` ORDER BY Date DESC LIMIT 10";
                                    $result=$conectare-> query($sql);

                                    if($result->num_rows>0) {while($row=$result->fetch_assoc())
                                    {echo "<tr><td>". $row[Username]."</td><td>".
                                        $row[LedName]."</td><td>".
                                        $row[Date]."</td></tr>";}
                                        echo "</table>";
                                    }
                                    else {"0 result";}
                                    ?>
                                    </thead>
                                    <tbody>
                                    <!-- Here some code to read from database -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- END MAIN CONTENT-->

        <!-- END PAGE CONTAINER-->

    </div>

</div>

<!-- Jquery JS-->

<script src="vendor/jquery-3.2.1.min.js"></script>

<!-- Bootstrap JS-->

<script src="vendor/bootstrap-4.1/popper.min.js"></script>
<script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>

<!-- Vendor JS       -->

<script src="vendor/slick/slick.min.js">
</script>
<script src="vendor/wow/wow.min.js"></script>
<script src="vendor/animsition/animsition.min.js"></script>
<script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="vendor/circle-progress/circle-progress.min.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="vendor/chartjs/Chart.bundle.min.js"></script>
<script src="vendor/select2/select2.min.js">
</script>

<!-- Main JS-->



</body>

</html>
<!-- end document-->
