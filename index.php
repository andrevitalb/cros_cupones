<?php
    include('connections.php');

    mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    $queryCoupons = "Select CU.cupones_ID as ID, C.comercios_logo as Logo, CU.cupones_promocion as Promoción, CU.cupones_restricciones as Restricciones, C.comercios_categorias as Categorias, CU.cupones_ubicacion as Ubicación, C.comercios_nombre as Nombre from cupones as CU inner join comercios as C on CU.cupones_comercio = C.comercios_ID where cupones_habilitado = 1 and cupones_vigenciaInicio <= CURDATE() and cupones_vigenciaFin >= CURDATE() order by ID";
    $resultCoupons = mysqli_query($connect, $queryCoupons);
    $contCoupons = 1;
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
        <link rel="stylesheet" href="css/custom.css">
        <link rel="stylesheet" href="css/all.min.css">
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
            <div class="container-fluid" id = "couponHolder">
                <div class="ownRow justify-content-center" id = "filterHolder">
                    <div class="col-md-2 col-xs-6 text-center">
                        <a href="#" id = "categoryCaller" data-toggle='modal' data-target='#categoryModal' class="filterCaller"><i class="far fa-box"></i>Categorías</a>
                    </div>
                    <div class="col-md-2 col-xs-6 text-center">
                        <a href="#" id = "locationCaller" data-toggle='modal' data-target='#locationModal' class="filterCaller"><i class="far fa-map-pin"></i>Ciudad</a>
                    </div>
                </div>
                <div class="ownRow">
                    <?php 
                        if($resultCoupons) {
                            while($rowCoupons = mysqli_fetch_array($resultCoupons)){
                                $contCoupons++;
                                $cats = explode("/", $rowCoupons[4]);
                                $categories = "";

                                for($i = 0; $i < sizeof($cats); $i++) $categories .= $cats[$i] . " ";

                                echo "<div class='col-md-3 col-xs-12 text-center coupon dCat dLoc $categories$rowCoupons[5]'><div class='logo-negocio'><a href='#' data-toggle='modal' data-target='#miModal' class='modalCaller' value='$rowCoupons[0]'><img src='$rowCoupons[1]' alt='$rowCoupons[7]'></a></div><h2 class='promo'>$rowCoupons[2]</h2><p class='restricciones'>$rowCoupons[3]</p><button type='button' class='btn btn-primary btn-lg modalCaller' value = '$rowCoupons[0]' data-toggle='modal' data-target='#miModal'>Obtener cupón</button></div>";
                            }
                        }
                        
                        if($contCoupons == 1) echo '<div class = "col-sm-12 text-center" id = "noCoups"><h2>Lo sentimos, por el momento no hay cupones disponibles</h2></div>';
                    ?>
                    <div class = "col-sm-12 text-center d-none" id = "noFilteredCoups"><h2>Lo sentimos, no hay cupones que coincidan con los filtros seleccionados.</h2></div>
                </div>

                <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Introduce tus datos</h4>
                            </div>
                            <div class="modal-body">
                                <form method = "post" action = "regCoupons.php">
                                    <div class="form-group">
                                        <label for="couponName">Nombre</label>
                                        <input type="text" class="form-control " id="couponName" name="couponName" placeholder="Indica tu nombre completo" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="couponMail">Email</label>
                                        <input type="email" class="form-control " id="couponMail" name="couponMail" placeholder="Indica tu correo electrónico" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="couponTel">Teléfono</label>
                                        <input type="text" class="form-control " id="couponTel" name="couponTel" placeholder="Indica tu teléfono" required>
                                    </div>
                                    <input type="text" style="display:none;" name = "coupId" id = "coupId">
                                    <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade filterModal" id="categoryModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="ownRow justify-content-end">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="ownContainer">
                                    <div class="ownRow justify-content-center">
                                        <div class="col-md-3 col-sm-6 text-center filter category activeFilter" value="all">
                                            <div>
                                                <i class="far fa-dot-circle"></i>
                                                <p class = "filterTag">Todas</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 text-center filter category" value="turismo">
                                            <div>
                                                <i class="far fa-hotel"></i>
                                                <p class = "filterTag">Turismo</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 text-center filter category" value="autos">
                                            <div>
                                                <i class="far fa-car"></i>
                                                <p class = "filterTag">Autos</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 text-center filter category" value="entretenimiento">
                                            <div>
                                                <i class="far fa-popcorn"></i>
                                                <p class = "filterTag">Entretenimiento</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 text-center filter category" value="restaurantes">
                                            <div>
                                                <i class="far fa-utensils-alt"></i>
                                                <p class = "filterTag">Restaurantes</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 text-center filter category" value="hogar">
                                            <div>
                                                <i class="far fa-home"></i>
                                                <p class = "filterTag">Hogar</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 text-center filter category" value="empresa">
                                            <div>
                                                <i class="far fa-briefcase"></i>
                                                <p class = "filterTag">Empresa</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade filterModal" id="locationModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="ownRow justify-content-end">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="ownContainer">
                                    <div class="ownRow">
                                        <div class="col-md-3 col-sm-6 text-center filter location activeFilter" value="all">
                                            <div>
                                                <p class = "filterTag">Todas</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 text-center filter location" value="aguascalientes">
                                            <div>
                                                <p class = "filterTag">Aguascalientes</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 text-center filter location" value="leon">
                                            <div>
                                                <p class = "filterTag">León</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 text-center filter location" value="queretaro">
                                            <div>
                                                <p class = "filterTag">Querétaro</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 text-center filter location" value="puebla">
                                            <div>
                                                <p class = "filterTag">Puebla</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="destacados-seguros2" class="row">
                </div>
            </div>
        </div><!--Fin bloque-type1-->

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
        <script>
            let categories = {
                "all": true,
                "turismo": false, 
                "autos": false,
                "entretenimiento": false,
                "restaurantes": false,
                "hogar": false,
                "empresa": false
            };

            let locations = {
                "all": true,
                "aguascalientes": false,
                "queretaro": false,
                "leon": false,
                "puebla": false
            }

            function loopFilts(arr){
                let str = "";
                for(let fil in arr) if(arr[fil]) str += "." + fil;
                return str;
            }

            $('.modalCaller').click(function(){
                $('#coupId').val($(this).attr('value'));
            });

            $('.filter').click(function(){
                let catVal = " ", locVal = " ";

                if($(this).hasClass('category')) catVal = $(this).attr('value');
                else locVal = $(this).attr('value');

                if(catVal != " "){
                    if(catVal != 'all'){
                        categories['all'] = false;
                        $('.category[value=all]').removeClass('activeFilter');

                        if(!($(this).hasClass('activeFilter'))) {
                            $('.category.activeFilter').removeClass('activeFilter');
                            $(this).addClass('activeFilter');

                            for(let cat in categories) categories[cat] = false;
                            categories[catVal] = true;
                        }
                        else {
                            $(this).removeClass('activeFilter');
                            categories[catVal] = false;
                            categories['all'] = true;
                            $('.category[value=all]').addClass('activeFilter');
                        }

                        $('.coupon').addClass('dCat');
                        $('.coupon:not(' + loopFilts(categories) +')').removeClass('dCat');
                    }
                    else {
                        $('.category.activeFilter').removeClass('activeFilter');
                        $(this).addClass('activeFilter');
                        $('.coupon').addClass('dCat');
                    }

                    if($('.category[value=all]').hasClass('activeFilter') && categories['all'] == true) $('.coupon').addClass('dCat');

                    $('#categoryModal .close').click();
                }
                else {
                    if(locVal != 'all'){
                        locations['all'] = false;
                        $('.location[value=all]').removeClass('activeFilter');

                        if(!($(this).hasClass('activeFilter'))) {
                            $('.location.activeFilter').removeClass('activeFilter');
                            $(this).addClass('activeFilter');

                            for(let city in locations) locations[city] = false;
                            locations[locVal] = true;
                        }
                        else {
                            $(this).removeClass('activeFilter');
                            locations[locVal] = false;
                            locations['all'] = true;
                            $('.location[value=all]').addClass('activeFilter');
                        }

                        $('.coupon').addClass('dLoc');
                        $('.coupon:not(' + loopFilts(locations) +')').removeClass('dLoc');
                    }
                    else {
                        $('.location.activeFilter').removeClass('activeFilter');
                        $(this).addClass('activeFilter');
                        $('.coupon').addClass('dLoc');
                    }

                    if($('.location[value=all]').hasClass('activeFilter') && locations['all'] == true) $('.coupon').addClass('dLoc');

                    $('#locationModal .close').click();
                }

                if($('.coupon').length == $('.coupon:not(.dCat), .coupon:not(.dLoc)').length) $('#noFilteredCoups').removeClass('d-none');
                else $('#noFilteredCoups').addClass('d-none');
            });
        </script>
    </body>
</html>