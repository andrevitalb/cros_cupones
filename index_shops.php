<?php session_start();
    if(!isset($_SESSION['usr'])) {
        header('Location: login.php');
        die();
    }

    include('export.php');
    include('cupones.php');
    include('connections.php');

    mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    $usr =  $_SESSION['usr'];

    $queryCurrent = "Select comercios_nombre from comercios where comercios_ID = $usr";
    $resultCurrent = mysqli_query($connect, $queryCurrent);
    $comercio = mysqli_fetch_array($resultCurrent);

    getCreatedCoups($usr);
    $contCreated = 0;
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no" />
        <meta name="author" content = "André Vital">

        <title>Dashboard Comercios | CROS</title>

        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="bower_components/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="bower_components/metisMenu/dist/metisMenu.min.css">
        <link rel="stylesheet" href="bower_components/Waves/dist/waves.min.css">
        <link rel="stylesheet" href="bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">

        <link rel="stylesheet" href="js/selects/cs-select.css">
        <link rel="stylesheet" href="js/selects/cs-skin-elastic.css">

        <link rel="stylesheet" href="bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css">
        <link rel="stylesheet" href="bower_components/DataTables/media/css/jquery.dataTables.css">
        <link rel="stylesheet" href="bower_components/datatables-tabletools/css/dataTables.tableTools.css">
        <link rel="stylesheet" href="bower_components/sweetalert/dist/sweetalert.css">
        <link rel="stylesheet" href="bower_components/smoke/dist/css/smoke.min.css">
        <link rel="stylesheet" href="js/notifications/ns-style-growl.css">
        <link rel="stylesheet" href="js/notifications/ns-style-other.css">

        <script src="js/menu/modernizr.custom.js"></script>
        <script src="js/notifications/snap.svg-min.js"></script>
        <script src="bower_components/sweetalert/dist/sweetalert.min.js"></script>

        <link rel="stylesheet" href="css/all.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/custom.css">

        <link rel="icon" href="img/favicon.ico" type="image/x-icon"/>
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
        <!--[if lt IE 9]>
            <script src="bower_components/html5shiv/dist/html5shiv.min.js"></script>
            <script src="bower_components/respondJs/dest/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <!--Preloader-->
        <div id="preloader" class="preloader table-wrapper">
            <div class="table-row">
                <div class="table-cell">
                    <div class="la-ball-fussion la-2x">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="main-wrapper" class="main-wrapper">
            <!-- Navbar -->
            <ul id="gn-menu" class="navbar gn-menu-main">
                <li class="gn-trigger">
                    <a id="menu-toggle" class="menu-toggle gn-icon gn-icon-menu">
                        <div class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="cross">
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <nav class="gn-menu-wrapper">
                        <div class="gn-scroller">
                            <ul class="gn-menu metismenu">
                                <li>
                                    <a value = "enter_Coupon" class = "sidebarLink">
                                        <i class="far fa-font"></i>Ingresar cupón
                                    </a>
                                </li>
                                <li>
                                    <a value = "generated_Coupons" class = "sidebarLink">
                                        <i class="far fa-th-list"></i>Cupones existentes
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </li>
                <div class = "ownRow navRow justify-content-between">
                    <a href="login.php" class="logo"><img src="img/logo.png" alt="Cros"></a>
                    <h2 id = "shopName"><?php echo $comercio[0]; ?></h2>
                    <a href = "cerrar.php" id = "log_out"><span>Cerrar Sesión</span></a>
                </div>
            </ul>

            <div id="content" class="content container-fluid">
                <div class="content-box big-box propForms" id = "enter_Coupon">
                    <div class="container">
                        <form action = "" method = "post">
                            <div class="row form-data-holder">
                                <div class="content-form form-horizontal row justify-content-center">
                                    <div class="col-sm-12 col-md-3">
                                        <h2>Ingresar cupón:</h2>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="couponFolio" class="col-sm-3 control-label">Folio cupón</label>
                                        <div class="col-sm-9">
                                            <input type="text" name = "couponFolio" class="form-control material" id="couponFolio" placeholder="Folio del cupón" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 text-right form-group">
                                        <button type = "submit" class = "btn btn-primary" name = "coupEnter">Utilizar</button>
                                    </div>
                                    <div class="col-sm-12 col-lg-3"></div>
                                    <div class="col-sm-12 col-lg-6 notifClear">
                                        <?php 
                                            if(isset($_POST['couponFolio'])) {
                                                useCoupon($usr); 
                                                getCreatedCoups($usr);
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="content-box big-box" id = "generated_Coupons">
                    <div class="container">
                        <div class="row titleRow">
                            <div class="col-lg-12">
                                <h2>Cupones generados:</h2>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="datatable display">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cupón</th>
                                        <th>Folio</th>
                                        <th>Nombre</th>
                                        <th>Fecha de generación</th>
                                        <th>Fecha de utilización</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($resultCreated) while($rowCreated = mysqli_fetch_array($resultCreated)):;?>
                                        <tr>
                                            <td><?php echo ++$contCreated;?></td>
                                            <td><?php echo $rowCreated[0];?></td>
                                            <td><?php echo $rowCreated[1];?></td>
                                            <td><?php echo $rowCreated[2];?></td>
                                            <td><?php echo $rowCreated[3];?></td>
                                            <td><?php if($rowCreated[4] != NULL) echo $rowCreated[4]; else echo "No Utilizado";?></td>
                                        </tr>
                                    <?php endwhile;?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <form action="export.php" method = "post" class="caption text-center col-md-12">
                        <button class = "btn btn-primary" type = "submit" name = "exportCreated">Exportar tabla</button>
                    </form>
                </div>

                <!--Footer-->
                <div class = "footer">
                    <p>
                        &copy; 2019 <b id="normal">Cros Seguros</b>. Todos los derechos reservados. <b><a target="_blank" href="aviso_de_privacidad.pdf" id="aviso"> Aviso de Privacidad</a></b>.<br>
                        Sitio desarrollado por <a target="_blank" href="http://yellowpath.mx/" id="yellow">Yellowpath Digital Branding</a>
                    </p>
                </div>
            </div>
        </div>

        <!--Scripts-->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
        <script src="bower_components/Waves/dist/waves.min.js"></script>
        <script src="bower_components/moment/min/moment.min.js"></script>
        <script src="bower_components/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js"></script>
        <script src="bower_components/cta/dist/cta.min.js"></script>
        <script src="bower_components/DataTables/media/js/jquery.dataTables.js"></script>
        <script src="bower_components/datatables.net-responsive/js/dataTables.responsive.js"></script>
        <script src="bower_components/datatables-tabletools/js/dataTables.tableTools.js"></script>
        <script src="bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.js"></script>
        <script src="bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>

        <script src="js/menu/classie.js"></script>
        <script src="js/menu/gnmenu.js"></script>
        <script src="js/selects/selectFx.js"></script>
        <script src="js/common.js"></script>

        <script>
            $('.fileinput').fileinput();

            $(function () {
                $('.datatable').DataTable({
                    "language": {
                        "lengthMenu": 'Mostrar <select>'+
                        '<option value="10">10</option>'+
                        '<option value="25">25</option>'+
                        '<option value="50">50</option>'+
                        '<option value="100">100</option>'+
                        '<option value="250">250</option>'+
                        '<option value="500">500</option>'+
                        '</select> entradas'
                    },
                    displayLength: 10,
                    dom: 'T<"clear">lfrtip',
                    tableTools: {
                        "sSwfPath": "js/datatables/copy_csv_xls_pdf.swf"
                    },
                    responsive: true
                });
            });

            var today = new Date();
            var date = today.getFullYear() + '-';

            if((today.getMonth() + 1) < 10) date += '0';
            date += (today.getMonth() + 1) + '-';

            if(today.getDate() < 10) date += '0';
            date += today.getDate();

            $('.sidebarLink').click(function(){
                $('.gn-menu-wrapper').removeClass("gn-open-all");
                $('html, body').animate({
                    scrollTop: $('#' + $(this).attr('value')).offset().top - 75
                }, 500);
            })
        </script>
    </body>
</html>