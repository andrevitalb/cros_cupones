<?php session_start();
    if(isset($_SESSION['usr'])) {
        if(($_SESSION['usr'] == 1)) header('Location: index_admin.php');
        else if($_SESSION['usr'] > 1) header('Location: index_shops.php');
        die();
    }

    include('loginData.php');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
    	<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    	<title>CROS Seguros</title>
        <link rel="shortcut icon" href="../CrosFavicon.ico">
        <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Lato:900' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="../flexslider.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="../css/reset.css" type="text/css" media="screen" />

        <link rel="stylesheet" href="../css/layout.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/skeleton.css" type="text/css" media="screen" />
        <link href="../css/media.css" rel="stylesheet" type="text/css">
        <link href="css/custom.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    	<header>
            <div id="head_menu" class="cupones">
                <div class="container">
                      <div class="logo">
                          <a href="../index.html"><img src="../images/CrosLogoBlanco.png" alt="Logotipo CROS"></a>
                          <h1>Tu seguro consultor</h1>
                      </div>
                      <div id="frase-header">
                          <h1>Nos encargamos de tus siniestros</h1>
                      </div>
                      <div id="coparmex">
                        <figure class="logo-copar">
                          <img src="../images/logo-coparmex.png" alt="Logotipo COPARMEX">
                        </figure> 

                      </div>
                      <div id="redes-head-cont">
                          <div id="redes_top">
                              <ul id="redes_head">
                                  <li><a href="https://www.facebook.com/seguros.CROS" target="_blank" ><img src="../images/social-facebook-icon.png" alt="Logotipo Facebook"></a></li>
                                  <li><a href="https://www.twitter.com/CROSseguros" target="_blank" ><img src="../images/social-twitter-icon.png" alt="Logotipo Twitter"></a></li>
                                  <li><a href="https://api.whatsapp.com/send?phone=5214772415476" target="_blank" ><img src="../images/social-whatsapp-icon.png" alt="Logotipo Whatsapp"></a></li>
                              </ul>

                          </div>
                          <div id="pagar-header-btn">
                              <a href="../formas-de-pago.html">PAGO</a>
                          </div>
                      </div><!--Fin de redes-head-cont-->
                      <div class="clear"></div>
                  </div><!--Fin Container-->
            </div><!--Fin head_menu-->
            <div id="main_menu" class="cupones">
                <div class="container">
                    <div id="menu-btn">
                        <span>MENU</span>
                    </div>
                    <ul id="menu">
                        <li><a href="../index.html">INICIO</a></li>
                        <li><a href="../divisiones.html">DIVISIONES</a></li>
                        <li><a href="../seguros.html">SEGUROS</a></li>
                        <li><a href="../quien-somos.html">QUIÉNES SOMOS</a></li>
                        <li><a href="../mas-servicios/" target="_blank">MÁS SERVICIOS</a></li>
                        <li><a href="index.php">CUPONES</a></li>
                        <li><a href="../contacto.html">CONTACTO</a></li>
                      <div class="clear"></div>
                    </ul>
                </div>
            </div>
        </header>
        
        <div class="clear"></div>
        <div class="bloque-type4">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-8">
                        <form action="" method = "post" id = "loginForm" class = "row">
                            <div class="col-sm-12">
                              <h3>Login de comerciantes</h3>
                            </div>
                            <div class="col-sm-12">
                                <label for="loginMail">Usuario</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" name = "loginMail" id = "loginMail" placeholder = "Usuario">
                            </div>
                            <div class="col-sm-12">
                                <label for="loginPassword">Contraseña</label>
                            </div>
                            <div class="col-sm-12">
                                <input type="password" name = "loginPassword" id = "loginPassword" placeholder = "Contraseña">
                            </div>
                            <div class="col-sm-12">
                                <button type = "submit" class = "btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-3"></div>
                    <div class="col-sm-12 col-md-6">
                      <?php
                        if(isset($_POST['loginMail']) && isset($_POST['loginPassword'])){
                          if(userEx() != -1){
                            $_SESSION['usr'] = $usuario;

                            if($usuario == 1) echo '<meta http-equiv="refresh" content="0; url=index_admin.php">';
                            else echo '<meta http-equiv="refresh" content="0; url=index_shops.php">';
                          }
                          else echo $errorMsg;
                        }
                      ?>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="sub_footer">
                <div class="container">
                  <div class="row mtop30">
                        <div class="col-md-4 borde-derecho">
                            <h2>Oficina Central</h2>
                            <p>Plaza del Angel<br>
                               Sierra Fria No. 116-A,<br>
                               Bosques del Prado Nte., C.P. 20120<br>
                               Aguascalientes, Ags.
                            </p>
                        </div>
                        <div class="col-md-4 borde-derecho txt_center">
                          <h2>Teléfonos</h2>
                            <p>(449) 153-3162</p>

                            <p>(449) 153-2973</p>
                            <h2>e-Mail</h2>
                            <p>cros@cros.com.mx</p>
                        </div>
                        <div class="col-md-4 txt_right">
                          <h2>Si tienes alguna duda o comentario comunicate con nosotros, sera un placer atenderte.</h2>
                        </div>
                  </div>
                </div>
                <div id="contenedor-oculto">
                    <div id="boton-mapa">
                        <p>UBICACIÓN</p>
                    </div>
                    <div id="cabecera-mapa">
                    </div>
                    <div id="contenido-mapa">
                        <iframe frameBorder='0' src='https://a.tiles.mapbox.com/v4/omarbautista72.j438060d/attribution.html?access_token=pk.eyJ1Ijoib21hcmJhdXRpc3RhNzIiLCJhIjoiX1JsMGdSSSJ9.Oyldsl_llCJEnuhy2LVyWQ'></iframe>
                    </div>
                </div>
            </div>
            <div class="bottom_footer">
                <div class="container">
                  <div class="row">
                        <div class="col-md-6">
                            <p class="text-left"><a href="../AvisoPrivacidad.pdf" target="_blank">Aviso de privacidad</a> | <a href="../TeRMINOS_DE_SERVICIO.pdf" target="_blank">Términos y condiciones</a></p>
                        </div>
                        <div class="col-md-6">
                            <p>Sitio Web desarrollado por YellowPath&reg; Digital Branding.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="../jquery.flexslider-min.js"></script>

        <script type='text/javascript' src='../js/script.js'></script>
        <script type='text/javascript' src='../js/menu-btn.js'></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>        
    </body>
</html>