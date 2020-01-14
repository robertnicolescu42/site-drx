<?php
$conectare = mysqli_connect('localhost','root','','bazabazei');

if(!$conectare){
    die(mysqli_connect_error());
}