<?php
require_once("db.php");

error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;




global $connection;

//MENSAJE AUTOMATICO
echo $query_message = "SELECT * FROM automated_messages ORDER BY id DESC LIMIT 1";
$run_query_message = mysqli_query($connection, $query_message);
$row_message = mysqli_fetch_array($run_query_message);

//PRIMERA ESCALACION: TODOS LOS MENSAJES QUE SE ENVIAN EN CUANTO SE VENCE LA FECHA DE CUARENTENA.
$today = date("Y-m-d");
$query = "SELECT * FROM incoming_log WHERE out_quarantine = 0 AND date_end < '$today' AND scale1 = 0 ;";
$result = mysqli_query($connection, $query);


  while($row = mysqli_fetch_array($result))
  {

    $responsible            = $row['responsible'];
    $responsible_dept_id    = $row['responsible_dept_id'];
    $part                   = $row['part'];
    $lot                    = $row['lot'];
    $quantity               = $row['quantity'];
    $days_overdue           = $row['days_overdue'];
    $date_end               = $row['date_end'];


    //dates para ESCALACION

    $date_2       =  date('Y-m-d', strtotime($date_end. " + 5 days"));
    $date_3       =  date('Y-m-d', strtotime($date_end. " + 10 days"));
    $date_4       =  date('Y-m-d', strtotime($date_end. " + 15 days"));
    $date_5       =  date('Y-m-d', strtotime($date_end. " + 30 days"));

    //dates para ESCALACION end



    $query_responsables = "SELECT * FROM users WHERE department_id = '$responsible_dept_id' AND scale1 = 1;";
    $run_query_responsables = mysqli_query($connection, $query_responsables);


   while($row_responsable = mysqli_fetch_array($run_query_responsables))
   {

       $destino = $row_responsable['user_email'];

       require 'mail/vendor/autoload.php';

       $mail = new PHPMailer(true);                                         // Passing `true` enables exceptions
       try {
           //Server settings

           $mail->SMTPDebug = 2;                                            // Enable verbose debug output
           $mail->isSMTP();                                                 // Set mailer to use SMTP
           $mail->Host = 'mail.martechsender.com;mail.martechsender.com';   // Specify main and backup SMTP servers
           $mail->SMTPAuth = true;                                          // Enable SMTP authentication
           $mail->Username = 'noreply@martechsender.com';                   // SMTP username
           $mail->Password = 'smartsender1!';                              // SMTP password
           $mail->SMTPSecure = 'tls';                                      // Enable TLS encryption, `ssl` also accepted
           $mail->Port = 587;                                              // TCP port to connect to 587
           //antes en 465

           //Recipients
           $mail->setFrom('noreply@martechsender.com', 'Cuarentena');

           $mail->addAddress($destino, 'Responsable');     // Add a recipient

           $mail->addReplyTo('noreply@martechmedical.com', 'Information');


           //Content
           $mail->isHTML(true);                                  // Set email format to HTML
           $mail->Subject = 'Aviso de Caurentena';
           $mail->Body    = $row_message['message']."<br>Material:".$part."<br>Lote:$lote"."<br>Cantidad:$quantity"."<br>Dias de Retraso:$days_overdue"."<br>Fecha promesa:$date_end";
           $mail->AltBody = $row_message['message']."<br>Material:".$part."<br>Lote:$lote"."<br>Cantidad:$quantity"."<br>Dias de Retraso:$days_overdue"."<br>Fecha promesa:$date_end";

           $mail->send();
           //echo 'Message has been sent';
       }
       catch (Exception $e)
       {
           echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
           //INTENTAR SEGUNDO SERVIDOR DE CORREOS
       }//TERMINA TRY CATCH
   }//termina while incluyendo direcciones y enviando correos
 }//PRIMER CICLO











 //SEGUNDA ESCALACION: TODOS LOS MENSAJES QUE SE ENVIAN EN CUANTO SE VENCE LA FECHA.
 $today = date("Y-m-d");
 $query = "SELECT * FROM incoming_log WHERE out_quarantine = 0 AND date_end < '$today' AND scale1 = 1 AND scale2 = 0 ;";
 $result = mysqli_query($connection, $query);


   while($row = mysqli_fetch_array($result))
   {

     $responsible            = $row['responsible'];
     $responsible_dept_id    = $row['responsible_dept_id'];
     $part                   = $row['part'];
     $lot                    = $row['lot'];
     $quantity               = $row['quantity'];
     $days_overdue           = $row['days_overdue'];
     $date_end               = $row['date_end'];


     //dates para ESCALACION

     $date_2       =  date('Y-m-d', strtotime($date_end. " + 5 days"));
     $date_3       =  date('Y-m-d', strtotime($date_end. " + 10 days"));
     $date_4       =  date('Y-m-d', strtotime($date_end. " + 15 days"));
     $date_5       =  date('Y-m-d', strtotime($date_end. " + 30 days"));

     //dates para ESCALACION end


     if($today > $date_2)
     {
            $query_responsables = "SELECT * FROM users WHERE department_id = '$responsible_dept_id' AND scale2 = 1;";
            $run_query_responsables = mysqli_query($connection, $query_responsables);


           while($row_responsable = mysqli_fetch_array($run_query_responsables))
           {

               $destino = $row_responsable['user_email'];

               require 'mail/vendor/autoload.php';

               $mail = new PHPMailer(true);                                         // Passing `true` enables exceptions
               try {
                   //Server settings

                   $mail->SMTPDebug = 2;                                            // Enable verbose debug output
                   $mail->isSMTP();                                                 // Set mailer to use SMTP
                   $mail->Host = 'mail.martechsender.com;mail.martechsender.com';   // Specify main and backup SMTP servers
                   $mail->SMTPAuth = true;                                          // Enable SMTP authentication
                   $mail->Username = 'noreply@martechsender.com';                   // SMTP username
                   $mail->Password = 'smartsender1!';                              // SMTP password
                   $mail->SMTPSecure = 'tls';                                      // Enable TLS encryption, `ssl` also accepted
                   $mail->Port = 587;                                              // TCP port to connect to 587
                   //antes en 465

                   //Recipients
                   $mail->setFrom('noreply@martechsender.com', 'Cuarentena');

                   $mail->addAddress($destino, 'Responsable');     // Add a recipient

                   $mail->addReplyTo('noreply@martechmedical.com', 'Information');


                   //Content
                   $mail->isHTML(true);                                  // Set email format to HTML
                   $mail->Subject = 'Aviso de Caurentena';
                   $mail->Body    = $row_message['message']."<br>Material:".$part."<br>Lote:$lote"."<br>Cantidad:$quantity"."<br>Dias de Retraso:$days_overdue"."<br>Fecha promesa:$date_end";
                   $mail->AltBody = $row_message['message']."<br>Material:".$part."<br>Lote:$lote"."<br>Cantidad:$quantity"."<br>Dias de Retraso:$days_overdue"."<br>Fecha promesa:$date_end";

                   $mail->send();
                   //echo 'Message has been sent';
               }
               catch (Exception $e)
               {
                   echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                   //INTENTAR SEGUNDO SERVIDOR DE CORREOS
               }//TERMINA TRY CATCH
           }//termina while incluyendo direcciones y enviando correos
     }//termina if de fechas

  }//PRIMER CICLO













   //TERCERA ESCALACION: TODOS LOS MENSAJES QUE SE ENVIAN EN CUANTO SE VENCE LA FECHA.
   $today = date("Y-m-d");
   $query = "SELECT * FROM incoming_log WHERE out_quarantine = 0 AND date_end < '$today' AND scale2 = 1 AND scale3 = 0 ;";
   $result = mysqli_query($connection, $query);


     while($row = mysqli_fetch_array($result))
     {

       $responsible            = $row['responsible'];
       $responsible_dept_id    = $row['responsible_dept_id'];
       $part                   = $row['part'];
       $lot                    = $row['lot'];
       $quantity               = $row['quantity'];
       $days_overdue           = $row['days_overdue'];
       $date_end               = $row['date_end'];


       //dates para ESCALACION

       $date_2       =  date('Y-m-d', strtotime($date_end. " + 5 days"));
       $date_3       =  date('Y-m-d', strtotime($date_end. " + 10 days"));
       $date_4       =  date('Y-m-d', strtotime($date_end. " + 15 days"));
       $date_5       =  date('Y-m-d', strtotime($date_end. " + 30 days"));

       //dates para ESCALACION end


       if($today > $date_3)
       {
              $query_responsables = "SELECT * FROM users WHERE department_id = '$responsible_dept_id' AND scale3 = 1;";
              $run_query_responsables = mysqli_query($connection, $query_responsables);


             while($row_responsable = mysqli_fetch_array($run_query_responsables))
             {

                 $destino = $row_responsable['user_email'];

                 require 'mail/vendor/autoload.php';

                 $mail = new PHPMailer(true);                                         // Passing `true` enables exceptions
                 try {
                     //Server settings

                     $mail->SMTPDebug = 2;                                            // Enable verbose debug output
                     $mail->isSMTP();                                                 // Set mailer to use SMTP
                     $mail->Host = 'mail.martechsender.com;mail.martechsender.com';   // Specify main and backup SMTP servers
                     $mail->SMTPAuth = true;                                          // Enable SMTP authentication
                     $mail->Username = 'noreply@martechsender.com';                   // SMTP username
                     $mail->Password = 'smartsender1!';                              // SMTP password
                     $mail->SMTPSecure = 'tls';                                      // Enable TLS encryption, `ssl` also accepted
                     $mail->Port = 587;                                              // TCP port to connect to 587
                     //antes en 465

                     //Recipients
                     $mail->setFrom('noreply@martechsender.com', 'Cuarentena');

                     $mail->addAddress($destino, 'Responsable');     // Add a recipient

                     $mail->addReplyTo('noreply@martechmedical.com', 'Information');


                     //Content
                     $mail->isHTML(true);                                  // Set email format to HTML
                     $mail->Subject = 'Aviso de Caurentena';
                     $mail->Body    = $row_message['message']."<br>Material:".$part."<br>Lote:$lote"."<br>Cantidad:$quantity"."<br>Dias de Retraso:$days_overdue"."<br>Fecha promesa:$date_end";
                     $mail->AltBody = $row_message['message']."<br>Material:".$part."<br>Lote:$lote"."<br>Cantidad:$quantity"."<br>Dias de Retraso:$days_overdue"."<br>Fecha promesa:$date_end";

                     $mail->send();
                     //echo 'Message has been sent';
                 }
                 catch (Exception $e)
                 {
                     echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                     //INTENTAR SEGUNDO SERVIDOR DE CORREOS
                 }//TERMINA TRY CATCH
             }//termina while incluyendo direcciones y enviando correos
       }//termina if de fechas

    }//PRIMER CICLO


















    //CUARTA ESCALACION: TODOS LOS MENSAJES QUE SE ENVIAN EN CUANTO SE VENCE LA FECHA.
    $today = date("Y-m-d");
    $query = "SELECT * FROM incoming_log WHERE out_quarantine = 0 AND date_end < '$today' AND scale3 = 1 AND scale4 = 0 ;";
    $result = mysqli_query($connection, $query);


      while($row = mysqli_fetch_array($result))
      {

        $responsible            = $row['responsible'];
        $responsible_dept_id    = $row['responsible_dept_id'];
        $part                   = $row['part'];
        $lot                    = $row['lot'];
        $quantity               = $row['quantity'];
        $days_overdue           = $row['days_overdue'];
        $date_end               = $row['date_end'];


        //dates para ESCALACION

        $date_2       =  date('Y-m-d', strtotime($date_end. " + 5 days"));
        $date_3       =  date('Y-m-d', strtotime($date_end. " + 10 days"));
        $date_4       =  date('Y-m-d', strtotime($date_end. " + 15 days"));
        $date_5       =  date('Y-m-d', strtotime($date_end. " + 30 days"));

        //dates para ESCALACION end


        if($today > $date_4)
        {
               $query_responsables = "SELECT * FROM users WHERE department_id = '$responsible_dept_id' AND scale4 = 1;";
               $run_query_responsables = mysqli_query($connection, $query_responsables);


              while($row_responsable = mysqli_fetch_array($run_query_responsables))
              {

                  $destino = $row_responsable['user_email'];

                  require 'mail/vendor/autoload.php';

                  $mail = new PHPMailer(true);                                         // Passing `true` enables exceptions
                  try {
                      //Server settings

                      $mail->SMTPDebug = 2;                                            // Enable verbose debug output
                      $mail->isSMTP();                                                 // Set mailer to use SMTP
                      $mail->Host = 'mail.martechsender.com;mail.martechsender.com';   // Specify main and backup SMTP servers
                      $mail->SMTPAuth = true;                                          // Enable SMTP authentication
                      $mail->Username = 'noreply@martechsender.com';                   // SMTP username
                      $mail->Password = 'smartsender1!';                              // SMTP password
                      $mail->SMTPSecure = 'tls';                                      // Enable TLS encryption, `ssl` also accepted
                      $mail->Port = 587;                                              // TCP port to connect to 587
                      //antes en 465

                      //Recipients
                      $mail->setFrom('noreply@martechsender.com', 'Cuarentena');

                      $mail->addAddress($destino, 'Responsable');     // Add a recipient

                      $mail->addReplyTo('noreply@martechmedical.com', 'Information');


                      //Content
                      $mail->isHTML(true);                                  // Set email format to HTML
                      $mail->Subject = 'Aviso de Caurentena';
                      $mail->Body    = $row_message['message']."<br>Material:".$part."<br>Lote:$lote"."<br>Cantidad:$quantity"."<br>Dias de Retraso:$days_overdue"."<br>Fecha promesa:$date_end";
                      $mail->AltBody = $row_message['message']."<br>Material:".$part."<br>Lote:$lote"."<br>Cantidad:$quantity"."<br>Dias de Retraso:$days_overdue"."<br>Fecha promesa:$date_end";

                      $mail->send();
                      //echo 'Message has been sent';
                  }
                  catch (Exception $e)
                  {
                      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                      //INTENTAR SEGUNDO SERVIDOR DE CORREOS
                  }//TERMINA TRY CATCH
              }//termina while incluyendo direcciones y enviando correos
        }//termina if de fechas

     }//PRIMER CICLO




















         //CUARTA ESCALACION: TODOS LOS MENSAJES QUE SE ENVIAN EN CUANTO SE VENCE LA FECHA.
         $today = date("Y-m-d");
         $query = "SELECT * FROM incoming_log WHERE out_quarantine = 0 AND date_end < '$today' AND scale4 = 1 AND scale5 = 0 ;";
         $result = mysqli_query($connection, $query);


           while($row = mysqli_fetch_array($result))
           {

             $responsible            = $row['responsible'];
             $responsible_dept_id    = $row['responsible_dept_id'];
             $part                   = $row['part'];
             $lot                    = $row['lot'];
             $quantity               = $row['quantity'];
             $days_overdue           = $row['days_overdue'];
             $date_end               = $row['date_end'];


             //dates para ESCALACION

             $date_2       =  date('Y-m-d', strtotime($date_end. " + 5 days"));
             $date_3       =  date('Y-m-d', strtotime($date_end. " + 10 days"));
             $date_4       =  date('Y-m-d', strtotime($date_end. " + 15 days"));
             $date_5       =  date('Y-m-d', strtotime($date_end. " + 30 days"));

             //dates para ESCALACION end


             if($today > $date_5)
             {
                    $query_responsables = "SELECT * FROM users WHERE department_id = '$responsible_dept_id' AND scale5 = 1;";
                    $run_query_responsables = mysqli_query($connection, $query_responsables);


                   while($row_responsable = mysqli_fetch_array($run_query_responsables))
                   {

                       $destino = $row_responsable['user_email'];

                       require 'mail/vendor/autoload.php';

                       $mail = new PHPMailer(true);                                         // Passing `true` enables exceptions
                       try {
                           //Server settings

                           $mail->SMTPDebug = 2;                                            // Enable verbose debug output
                           $mail->isSMTP();                                                 // Set mailer to use SMTP
                           $mail->Host = 'mail.martechsender.com;mail.martechsender.com';   // Specify main and backup SMTP servers
                           $mail->SMTPAuth = true;                                          // Enable SMTP authentication
                           $mail->Username = 'noreply@martechsender.com';                   // SMTP username
                           $mail->Password = 'smartsender1!';                              // SMTP password
                           $mail->SMTPSecure = 'tls';                                      // Enable TLS encryption, `ssl` also accepted
                           $mail->Port = 587;                                              // TCP port to connect to 587
                           //antes en 465

                           //Recipients
                           $mail->setFrom('noreply@martechsender.com', 'Cuarentena');

                           $mail->addAddress($destino, 'Responsable');     // Add a recipient

                           $mail->addReplyTo('noreply@martechmedical.com', 'Information');


                           //Content
                           $mail->isHTML(true);                                  // Set email format to HTML
                           $mail->Subject = 'Aviso de Caurentena';
                           $mail->Body    = $row_message['message']."<br>Material:".$part."<br>Lote:$lote"."<br>Cantidad:$quantity"."<br>Dias de Retraso:$days_overdue"."<br>Fecha promesa:$date_end";
                           $mail->AltBody = $row_message['message']."<br>Material:".$part."<br>Lote:$lote"."<br>Cantidad:$quantity"."<br>Dias de Retraso:$days_overdue"."<br>Fecha promesa:$date_end";

                           $mail->send();
                           //echo 'Message has been sent';
                       }
                       catch (Exception $e)
                       {
                           echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                           //INTENTAR SEGUNDO SERVIDOR DE CORREOS
                       }//TERMINA TRY CATCH
                   }//termina while incluyendo direcciones y enviando correos
             }//termina if de fechas

          }//PRIMER CICLO





?>
