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

$sqlrez    = "
SELECT rezervare.id, rezervare.Description, rezervare.Id_Organizator, rezervare.date_start, rezervare.date_end, rezervare.Este_Confirmata, p.id as id2, p.description as description2, p.id_organizator as id_organizator2, p.date_start as date_start2, datasf as date_end2, p.este_confirmata as este_confirmata2, sysdate() as sysdate from rezervare cross join ( SELECT id, Description, Id_Organizator, date_start, date_end as datasf, Este_Confirmata FROM rezervare where sysdate() > date_start and sysdate() < date_end ) as p where datasf < rezervare.date_start limit 1
";
$resultrez = $conectare->query($sqlrez);
$date      = date("Y-m-d H:i:s");

$sqlsed = "SELECT id, Nume, Adresa, Capacitate_Maxima from camera_sedinte limit 1";
$resultsed = $conectare->query($sqlsed);

$sqlorg = "SELECT Nume from utilizator inner join rezervare on utilizator.id = Id_Organizator order by date_end desc limit 1";
$resultorg = $conectare->query($sqlorg);

$sqlpart = "SELECT Nume from utilizator #inner join participanti on utilizator.id = Id_Participant and A_Confirmat like 1";
$resultpart = $conectare->query($sqlpart);

if($resultrez ->num_rows > 0){
    while($rowrez = $resultrez->fetch_assoc() AND $rowsed = $resultsed->fetch_assoc() AND $roworg = $resultorg->fetch_assoc() AND $rowpart = $resultpart->fetch_assoc())
    {
            echo "<h2 class='mt-1 names'>Camera: ".$rowsed['id']." | maxim ".$rowsed['Capacitate_Maxima']." participanti</h2>";
        if ($rowrez['date_start2'] < $rowrez['sysdate'] AND $rowrez['date_end2'] > $rowrez['sysdate'])
            {if($rowrez['este_confirmata2'] == True)
            {
            echo "<div class ='current-reservation mt-2' style = 'background-color: red'>";
            echo "<h2>Rezervat pentru : ". $rowrez['description2']. "</h2><h2>Pana la : ". $rowrez['date_end2']."</h2><h2>Organizator : ".
                 $roworg['Nume']."</h2><h2>Participanti: ".$rowpart['Nume']."</h2></div>";
            }
            else echo "<h2>Rezervarea exista dar nu este confirmata!</h2>";}

        
        else
              echo "
              <div class='current-reservation mt-2' style='background-color: green'>
              <!-- in caz ca nu e rezervata camera in momentul asta, se golesc urmatoarele h2-uri si se face bg color verde-->
              <h2>Camera disponibila pana la " . $rowrez['date_start'] . "</h2>
              <h2><br></h2>
              <h2><br></h2>
              <h2><br></h2>
              </div>";




            echo "<h2 class='mt-1 names'>Camera: ".$rowsed['id']." | maxim ".$rowsed['Capacitate_Maxima']." participanti</h2>";
        if ($rowrez['date_start'] > $date)
            {if($rowrez['Este_Confirmata'] == True){
            echo "<div class ='future-reservation mt-2' style = 'background-color: white'>";
            echo "<h2>Rezervat pentru : ". $rowrez['Description']. "</h2><h2>Pana la : ". $rowrez['date_end']."</h2><h2>Organizator : ".
                 $roworg['Nume']."</h2><h2>Participanti: ".$rowpart['Nume']."</h2>";}
             else echo "<h2>Rezervarea exista dar nu este confirmata!</h2>";}
                
    }
}
?>
            </div>
            </div>
        </section>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>