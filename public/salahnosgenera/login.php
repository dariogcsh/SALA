<?php session_start(); ?>
<!doctype html>
<html>
<head>
   <?php 
     // include("funciones/getDataEficiencia.php"); // PHP que genera las consulta y obtiene los datos para todas las graficas.
      ?>
  <title>Login Sala</title> 
  
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <!-- Bootstrap CSS -->
   <link rel="icon" type="image/png" href="imagen/john.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet" />
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">

         <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

        <!-- jsPDF -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
        
 
        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/i18n/defaults-*.min.js"></script>
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">

      //Generacion de PDF
      function genPDF(){
        html2canvas(document.getElementById("content"), {
            onrendered: function(canvas) {

                var imgData = canvas.toDataURL('image/png');
                console.log('Report Image URL: '+imgData);
                var doc = new jsPDF('p', 'mm', [400, 130]); //height - width
                
                doc.addImage(imgData, 'PNG', 10, 10);
                doc.save('sample.pdf');
            }
        });
      }


             $(document).ready(function(){

              $('#login').on('click',function(){
                      var user=$("#user").val();
                      var pass=$("#pass").val();
                      var dataString = 'user='+user+'&pass='+pass;
                      if($.trim(user).length>0 && $.trim(pass).length>0)
                      {

                            $.ajax({
                                type: "POST",
                                url: "funciones/sesion.php",
                                data: dataString,
                                cache: false,
                                success: function(data){
                                  
                                if(data == 2)
                                    {
                                      /*
                                    $("body").load("home.php").hide().fadeIn(1500).delay(6000);
                                    //or
                                    window.location.href = "home.php";
                                    */
                                     $("#error").html("<div class='alert alert-warning' role='alert'> Usuario o contraseña inconrrectos. </div>");
                                    }
                                else if (data == 0)
                                {
                                 window.location.href = "menu.php";
                                } else {
                                  window.location.href = "menu.php";
                                }}
                            });
                            return false;
                            } else {
                            $("#error").html("<div class='alert alert-warning' role='alert'> Debe completar Usuario y Contraseña.</div>");
                      return false;
                    }
                      });
                    });
                         
             
     
    </script>
        
   

      <style type="text/css">
        .minh-100 {
            height: 100vh;
          }
      </style>

</head>
<body>


<div class="container">
  <div class="row justify-content-center align-items-center minh-100">
    <div class="col-sm-12 col-md-3 col-lg-4 col-xl-4"></div>
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4" id="content">
      <div>
        <img class="img-fluid rounded mx-auto d-block" src="imagen/logo_sesion2.jpg" alt="logo" width="60%" height="60%">
        <br>
      </div>

                      <form style="align-items: center;">
                        <div class="form-group">
                          <h1 style="text-align: center;">Sala Hnos.</h1>
                        </div>
                        <div class="form-group">
                          <input type="text" class="form-control" id="user" placeholder="Usuario">
                        </div>
                        <div class="form-group">
                          <input type="password" class="form-control" id="pass" placeholder="Contraseña">
                        </div>
                        <button type="submit" class="btn btn-success btn-block" id="login">Iniciar Sesión</button>
                        <button onclick="genPDF();" class="btn btn-success btn-block" >PDF</button>
                        <div id="error" style="padding-top: 20px;"></div>
                      </form>

    </div>
    <div class="col-sm-12 col-md-3 col-lg-4 col-xl-4"></div>
  </div>
</div>

</body>


</html>