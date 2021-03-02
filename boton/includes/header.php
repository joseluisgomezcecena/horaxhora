<?php
date_default_timezone_set("America/Tijuana");
require_once('config/db.php'); 

$hora_actual       = date("H:i:s");
$fecha_actual      = date("Y-m-d");
$fecha_hora        = date("Y-m-d H:i:s");


if(isset($_GET['display']))
{
$display           = $_GET['display'];
}
else
{
$display = '12';
}


if(isset($_GET['planta_id']))
{
$planta_id           = $_GET['planta_id'];
}
else
{
$planta_id = '1';
}




?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MMW - Hour By Hour Buttons</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/bootstrap.css" />
   
    <style>
    ::-webkit-scrollbar 
    { 
    display: none; 
    }

    html, body 
      {

       /*
        min-height: 100%;
        margin: 0;
       
        
        background-image: linear-gradient(rgb(33, 118, 255), rgb(32, 229, 247));
        background-color: blue;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        background-repeat: no-repeat;
        */
      }

    .late{
    animation:blinkingText 1.0s infinite;
}
    @keyframes blinkingText{
        0%{     color: darkred;    }
        49%{    color: white; }
        60%{    color: transparent; }
        99%{    color:transparent;  }
        100%{   color: red;    }
    }




/*
*
* ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*
*/

.btn-circle {
  width: 45px;
  height: 45px;
  line-height: 45px;
  text-align: center;
  padding: 0;
  border-radius: 50%;
}

.btn-circle i {
  position: relative;
  top: -1px;
}

.btn-circle-sm {
  width: 35px;
  height: 35px;
  line-height: 35px;
  font-size: 0.9rem;
}

.btn-circle-lg {
  width: 55px;
  height: 55px;
  line-height: 55px;
  font-size: 1.1rem;
}

.btn-circle-xl {
  width: 70px;
  height: 70px;
  line-height: 70px;
  font-size: 1.3rem;
}


</style>

</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal"><img src="assets/img/logo.png"></h5>
  <nav class="my-2 my-md-0 mr-md-3">
    <!--
    <a class="p-2 text-dark" href="#">Features</a>
    <a class="p-2 text-dark" href="#">Enterprise</a>
    <a class="p-2 text-dark" href="#">Support</a>
    <a class="p-2 text-dark" href="#">Pricing</a>
    -->
  </nav>
  <a class="btn btn-primary" href="index.php">Elegir Planta</a>
  &nbsp;&nbsp;
  <a class="btn btn-outline-danger" href="http://mxmtsvrandon1/andon/floor/public/index.php">Andon</a>
</div>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center text-white">
  <h1 class="display-4">Hora x Hora</h1>
  <p class="lead">Elige la planta en la que se capturara la producción.</p>
</div>