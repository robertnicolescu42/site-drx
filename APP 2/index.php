<?php
$conectare = mysqli_connect('localhost','root','','test');

if(!$conectare){
    die(mysqli_connect_error());
}

$sql = "SELECT id, Nume, Adresa, Capacitate_Maxima from camera_sedinte";
$result= $conectare -> query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $aaa= "id: " . $row['id']. " - Name: " . $row["Nume"]. " " . $row["Adresa"]. "<br>";
    }
} else {
    echo "0 results";
}

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Rezervari</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">

    </head>

    <body>

        <!-- Page Content -->
        <section>
            <div class="container-fluid">
                <div class="containter-fluid both">
                    <!-- in caz ca nu e rezervata camera in momentul asta,se golesc urmatoarele h2-uri si se face bg color verde-->
<?php

$sqlrez    = "SELECT id, Description, Id_Organizator, date_start, date_end, Este_Confirmata FROM rezervare order by date_end desc limit 1";
$resultrez = $conectare->query($sqlrez);
$date      = date("Y-m-d H:i:s");

if ($resultrez->num_rows > 0) {
    while ($row = $resultrez->fetch_assoc()) {
        if ($row['date_start'] < $date AND $row['date_end'] > $date) {
            $sql    = "SELECT id, Nume, Adresa, Capacitate_Maxima from camera_sedinte";
            $result = $conectare->query($sql);

            echo "<h2 class='mt-1 names'>Camera: " . $row['id'] . " | maxim " . $row["Capacitate_Maxima"] . " participanti</h2>";
            echo "<div class='current-reservation mt-2' style='background-color: red'>";
            

            $sql2    = "SELECT 'id', 'Description', 'Id_Organizator', 'Este_Confirmata' FROM 'rezervare'";
            $result2 = $conectare->query($sql2);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<h2>Camera: " . $row['id'] . "| maxim " . $row["Capacitate_Maxima"] . " participanti</h2><br><h2>Pana la: " . $row["Adresa"] . "</h2><br><h2>Organizator: " . $row["Nume"], "</h2>";
                }
            } else
                echo "0 results";
        } else
            echo "
              <div class='current-reservation mt-2' style='background-color: green'>
              <!-- in caz ca nu e rezervata camera in momentul asta, se golesc urmatoarele h2-uri si se face bg color verde-->
              <h2>Camera disponibila pana la " . $row['date_start'] . "</h2>
              <h2><br></h2>
              <h2><br></h2>
              <h2><br></h2>
              </div>";
    }
} else
    echo "0 results";

?>

                </div>

                <h2 class="mt-1 names">Camera: VR PIT 2 13 | maxim 3 participanti</h2>
                <div class="future-reservation mt-2" style="background-color: white">
                    <h2>Urmatoarea sedinta : Lista de mancare pentru revelion</h2>
                    <h2>De la: 13.11.2019 18:00</h2>
                    <h2>Organizator: Kaufland</h2>
                    <h2>Participanti: Miami Vice; Andre Andrei; Luna Cateaua;</h2>
                </div>

            </div>
            </div>
        </section>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>