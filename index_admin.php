<?php session_start();
    if(!isset($_SESSION['usr']) || ($_SESSION['usr'] != 1)) {
        header('Location: login.php');
        die();
    }

    include('export.php');
    include('comercios.php');
    include('cupones.php');
    include('usuarios.php');
    include('connections.php');
    include('general.php');

    mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    getShops();
    $contShops = 0;

    getCoupons();
    $contCoupons = 0;

    getCreatedCoups(0);
    $contCreated = 0;

    getUsedCoups();
    $contUsed = 0;

    getUsers();
    $contUsers = 0;
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no" />
        <meta name="author" content = "André Vital">

        <title>Dashboard Administrador | CROS</title>

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
                                    <a value = "new_Shop" class = "sidebarLink">
                                        <i class="far fa-font"></i>Comercios
                                    </a>
                                </li>
                                <li>
                                    <a value = "new_Coupon" class = "sidebarLink">
                                        <i class="far fa-th-list"></i>Cupones
                                    </a>
                                </li>
                                <li>
                                    <a value = "view_Users" class = "sidebarLink">
                                        <i class="far fa-desktop"></i>Usuarios
                                    </a>
                                </li>
                                <li>
                                    <a value = "new_Ad" class = "sidebarLink">
                                        <i class="far fa-desktop"></i>Anuncios
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </li>
                <div class = "ownRow navRow justify-content-between">
                    <a href="login.php" class="logo"><img src="img/logo.png" alt="Cros"></a>
                    <h2 id = "shopName">Cros Seguros</h2>
                    <a href = "cerrar.php" id = "log_out"><span>Cerrar Sesión</span></a>
                </div>
            </ul>

            <div id="content" class="content container-fluid">
                <!-- Comercios -->
                <div class="content-box big-box propForms" id = "new_Shop">
                    <div class="container">
                        <div class="row titleRow">
                            <div class="col-lg-12">
                                <h2>Crear nuevo comercio:</h2>
                            </div>
                        </div>

                        <form action = "" method = "post" enctype = "multipart/form-data" onsubmit="return validateUser(document.getElementById('shopUser').value)">
                            <div class="row form-data-holder justify-content-evenly">
                                <div class="content-form form-horizontal row">
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="shopName" class="col-sm-3 control-label">Nombre comercio</label>
                                        <div class="col-sm-9">
                                            <input type="text" name = "shopName" class="form-control material" id="shopName" placeholder="Nombre del comercio" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="shopLogo" class="col-sm-3 control-label">Logotipo comercio</label>
                                        <div class="col-sm-9" style = "padding-top: 10px;">
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <span class="input-group-addon btn btn-default btn-file">
                                                    <span class="fileinput-new">
                                                        <i class="far fa-file"></i> Seleccionar archivo</span>
                                                        <span class="fileinput-exists">Cambiar</span>
                                                    <input type="file" name="shopLogo" id="shopLogo">
                                                </span>

                                                <div class="form-control" data-trigger="fileinput">
                                                    <span class="fileinput-filename"></span>
                                                </div>
                                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                            </div>
                                        </div>
                                        <input type="checkbox" class="validateCheck" id="vCreateLogo" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="shopUser" class="col-sm-3 control-label">Usuario comercio</label>
                                        <div class="col-sm-9">
                                            <input type="text" name = "shopUser" class="form-control material" id="shopUser" placeholder = "Solo minúsculas, sin tildes o ñ y números del 0-9" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="shopPassword" class="col-sm-3 control-label">Contraseña comercio</label>
                                        <div class="col-sm-9">
                                            <input type="text" name = "shopPassword" class="form-control material" id="shopPassword" placeholder = "Contraseña del comercio" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label for="shopCategories" class="col-sm-3 control-label">Categorías comercio</label>
                                        <input type="hidden" id="shopCategories" name="shopCategories">
                                        <div class="col-sm-9 checkboxHolder">
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "localCategories" class="material localCategories" value="turismo">
                                                    <i></i>
                                                    Turismo
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "localCategories" class="material localCategories" value="autos">
                                                    <i></i>
                                                    Autos
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "localCategories" class="material localCategories" value="entretenimiento">
                                                    <i></i>
                                                    Entretenimiento
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "localCategories" class="material localCategories" value="restaurantes">
                                                    <i></i>
                                                    Restaurantes
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "localCategories" class="material localCategories" value="hogar">
                                                    <i></i>
                                                    Hogar
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "localCategories" class="material localCategories" value="empresa">
                                                    <i></i>
                                                    Empresa
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right form-group">
                                        <input type="checkbox" id = "categoryValidate" style = "display:none;" required>
                                        <button type = "submit" class = "btn btn-primary" id="shopCreate" name = "shopCreate">Crear</button>
                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-sm-12 col-lg-6 notifClear">
                                        <?php if(isset($_POST['shopCreate'])) addShop(); ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="content-box big-box" id = "view_Shops">
                    <div class="row titleRow">
                        <div class="col-lg-12">
                            <h2>Administrar comercios existentes:</h2>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="datatable display">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Comercio</th>
                                    <th>Logo</th>
                                    <th>Usuario</th>
                                    <th>Contraseña</th>
                                    <th>Categorías</th>
                                    <th><i class="far fa-edit"></i> / <i class="far fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($resultShops) while($rowShops = mysqli_fetch_array($resultShops)):;?>
                                    <?php if($rowShops[5]):;?>
                                        <tr>
                                            <td><?php echo ++$contShops;?></td>
                                            <td><?php echo $rowShops[1];?></td>
                                            <td>
                                                <img src="<?php echo $rowShops[2];?>" alt="<?php echo $rowShops[1];?>">
                                            </td>
                                            <td><?php echo $rowShops[3];?></td>
                                            <td><?php echo $rowShops[4];?></td>
                                            <td><?php echo $rowShops[6];?></td>
                                            <td>
                                                <?php
                                                    if($contShops > 1) echo '<form method = "post"><button type = "button" class="btn btn-info tableButton editShops" name = "editShop" id = "editShop'.$rowShops[0].'" value = "'.$rowShops[0].'">Editar</button><button type = "button" class="btn btn-danger tableButton disableShops" name = "disableShop" id = "disableShop'.$rowShops[0].'">Deshabilitar</button></form>';
                                                    else echo '<form method = "post"><button type = "button" class="btn btn-info tableButton editShops" name = "editShop" id = "editShop'.$rowShops[0].'" value = "'.$rowShops[0].'">Editar</button></form>';
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endif;?>
                                <?php endwhile;?>
                            </tbody>
                        </table>

                        <form action="" method = "post" style="display:none;"><input type = "hidden" name = "disableShopID" id = "disableShopID"><button type="button" name="disShop" id="disShop"></button><button type="submit" name="confDisShop" id="confDisShop"></button></form>
                    </div>
                </div>

                <div class="content-box big-box propForms" id = "edit_Shops">
                    <div class="container">
                        <div class="row titleRow">
                            <div class="col-lg-12">
                                <h2>Editar comercios:</h2>
                            </div>
                        </div>

                        <form action = "" method = "post" enctype = "multipart/form-data" onsubmit="return validateUser(document.getElementById('updUser').value)">
                            <div class="row form-data-holder justify-content-evenly">
                                <div class="content-form form-horizontal">
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="updName" class="col-sm-3 control-label">Nombre comercio</label>
                                        <div class="col-sm-9">
                                            <input type="text" name = "updName" class="form-control material" id="updName" placeholder="Nombre del comercio" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="updLogo" class="col-sm-3 control-label">Logotipo comercio</label>
                                        <div class="col-sm-9" style = "padding-top: 10px;">
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <span class="input-group-addon btn btn-default btn-file">
                                                    <span class="fileinput-new">
                                                        <i class="far fa-file"></i> Seleccionar archivo</span>
                                                        <span class="fileinput-exists">Cambiar</span>
                                                    <input type="file" name="updLogo" id="updLogo">
                                                </span>

                                                <div class="form-control" data-trigger="fileinput">
                                                    <span class="fileinput-filename"></span>
                                                </div>
                                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                            </div>
                                        </div>
                                        <input type="checkbox" class="validateCheck" id="vUpdateLogo" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="updUser" class="col-sm-3 control-label">Usuario comercio</label>
                                        <div class="col-sm-9">
                                            <input type="text" name = "updUser" class="form-control material" id="updUser" placeholder = "Solo minúsculas, sin tildes o ñ y números del 0-9" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="updPassword" class="col-sm-3 control-label">Contraseña comercio</label>
                                        <div class="col-sm-9">
                                            <input type="text" name = "updPassword" class="form-control material" id="updPassword" placeholder = "Contraseña del comercio" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label class="col-sm-3 control-label">Categorías comercio</label>
                                        <input type="hidden" id="updCategories" name="updCategories">
                                        <div class="col-sm-9 checkboxHolder">
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "updLocalCategories" class="material updLocalCategories" value="turismo">
                                                    <i></i>
                                                    Turismo
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "updLocalCategories" class="material updLocalCategories" value="autos">
                                                    <i></i>
                                                    Autos
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "updLocalCategories" class="material updLocalCategories" value="entretenimiento">
                                                    <i></i>
                                                    Entretenimiento
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "updLocalCategories" class="material updLocalCategories" value="restaurantes">
                                                    <i></i>
                                                    Restaurantes
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "updLocalCategories" class="material updLocalCategories" value="hogar">
                                                    <i></i>
                                                    Hogar
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 checkbox checkbox-danger checkbox-big">
                                                <label>
                                                    <input type="checkbox" name = "updLocalCategories" class="material updLocalCategories" value="empresa">
                                                    <i></i>
                                                    Empresa
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right form-group">
                                        <input type="checkbox" id = "updCategoryValidate" style = "display:none;" required>
                                        <input type="number" name = "updIndex" id = "updIndex" style = "display:none;">
                                        <button type = "submit" class = "btn btn-primary" id="shopUpdate" name = "shopUpdate">Actualizar</button>
                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-sm-12 col-lg-6 notifClear">
                                        <?php
                                            if(isset($_POST['shopUpdate'])){
                                                $result = updShop();
                                                if($result) echo '<meta http-equiv="refresh" content="0;URL=index_admin.php"/>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Cupones -->
                <div class="content-box big-box propForms" id = "new_Coupon">
                    <div class="container">
                        <div class="row titleRow">
                            <div class="col-lg-12">
                                <h2>Crear nuevo cupón:</h2>
                            </div>
                        </div>

                        <form action = "" method = "post">
                            <div class="row form-data-holder justify-content-evenly">
                                <div class="content-form form-horizontal">
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="coupShop" class="col-sm-3 control-label">Comercio al que pertence</label>
                                        <div class="col-sm-9">
                                            <select name = "coupShop" class="form-control material" id="coupShop" required>
                                                <option selected disabled>  Selecciona una opción</option>
                                                <?php getShops(); ?>
                                                <?php if($resultShops) while($rowShops = mysqli_fetch_array($resultShops)):;?>
                                                    <?php if($rowShops[5]):?>
                                                    <option value = "<?php echo $rowShops[0];?>"><?php echo $rowShops[1];?></option>
                                                    <?php endif;?>
                                                <?php endwhile;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="coupDiscount" class="col-sm-3 control-label">Promoción</label>
                                        <div class="col-sm-9">
                                            <input type="text" name = "coupDiscount" class="form-control material" id="coupDiscount" placeholder="Promoción" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="coupStartDate" class="col-sm-3 control-label">Inicio Vigencia</label>
                                        <div class="col-md-9">
                                            <input type="date" name = "coupStartDate" class="form-control material" id="coupStartDate" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="coupEndDate" class="col-sm-3 control-label">Final Vigencia</label>
                                        <div class="col-sm-9">
                                            <input type="date" name = "coupEndDate" class="form-control material" id="coupEndDate" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3"></div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="coupRestrictions" class="col-sm-3 control-label">Restricciones</label>
                                        <div class="col-sm-9">
                                            <textarea name = "coupRestrictions" class="form-control material" id="coupRestrictions" placeholder="Separar restricciones por saltos de línea (Enter). No agregar asteriscos (*) al inicio de cada renglón."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label class="col-sm-3 control-label">Ciudad del cupón</label>
                                        <input type="hidden" id="coupCity" name="coupCity">
                                        <div class="col-sm-9 checkboxHolder">
                                            <div class="col-sm-12 col-md-4 radio radio-warning radio-big">
                                                <label>
                                                    <input type="radio" name = "localCity" class="material localCity" value="aguascalientes" required>
                                                    <i></i>
                                                    Aguascalientes
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 radio radio-warning radio-big">
                                                <label>
                                                    <input type="radio" name = "localCity" class="material localCity" value="leon" required>
                                                    <i></i>
                                                    León
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 radio radio-warning radio-big">
                                                <label>
                                                    <input type="radio" name = "localCity" class="material localCity" value="queretaro" required>
                                                    <i></i>
                                                    Querétaro
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 radio radio-warning radio-big">
                                                <label>
                                                    <input type="radio" name = "localCity" class="material localCity" value="puebla" required>
                                                    <i></i>
                                                    Puebla
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right form-group">
                                        <button type = "submit" class = "btn btn-primary" name = "coupCreate">Crear</button>
                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-sm-12 col-sm-12 col-lg-6 notifClear">
                                        <?php if(isset($_POST['coupCreate'])) addCoupon(); ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="content-box big-box" id = "view_Coupons">
                    <div class="row titleRow">
                        <div class="col-lg-12">
                            <h2>Administrar cupones existentes:</h2>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="datatable display">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Comercio</th>
                                    <th>Cupón</th>
                                    <th>Inicio Vigencia</th>
                                    <th>Final Vigencia</th>
                                    <th>Restricciones</th>
                                    <th>Ciudad</th>
                                    <th><i class="far fa-edit"></i> / <i class="far fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($resultCoupons) while($rowCoupons = mysqli_fetch_array($resultCoupons)):;?>
                                    <?php if($rowCoupons[6]):?>
                                        <tr>
                                            <td><?php echo ++$contCoupons;?></td>
                                            <td><?php echo $rowCoupons[1];?></td>
                                            <td><?php echo $rowCoupons[2];?></td>
                                            <td><?php echo dateFormat($rowCoupons[3]);?></td>
                                            <td><?php echo dateFormat($rowCoupons[4]);?></td>
                                            <td><?php echo $rowCoupons[5];?></td>
                                            <td><?php echo $rowCoupons[7];?></td>
                                            <td><?php echo '<form method = "post"><button type = "button" class="btn btn-info tableButton editCoupons" name = "editCoupon" id = "editCoupon'.$rowCoupons[0].'" value = "'.$rowCoupons[0].'">Editar</button><button type = "button" class="btn btn-danger tableButton disableCoupons" name = "disableCoupon" id = "disableCoupon'.$rowCoupons[0].'">Deshabilitar</button></form>';?>
                                            </td>
                                        </tr>
                                    <?php endif;?>
                                <?php endwhile;?>
                            </tbody>
                        </table>

                        <form action="" method = "post" style="display:none;"><input type = "hidden" name = "disableCouponID" id = "disableCouponID"><button type="button" name="disCoupon" id="disCoupon"></button><button type="submit" name="confDisCoupon" id="confDisCoupon"></button></form>
                    </div>
                </div>

                <div class="content-box big-box propForms" id = "edit_Coupons">
                    <div class="container">
                        <div class="row titleRow">
                            <div class="col-lg-12">
                                <h2>Editar cupones:</h2>
                            </div>
                        </div>

                        <form action = "" method = "post">
                            <div class="row form-data-holder justify-content-evenly">
                                <div class="content-form form-horizontal">
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="updCShop" class="col-sm-3 control-label">Comercio al que pertence</label>
                                        <div class="col-sm-9">
                                            <select name = "updCShop" class="form-control material" id="updCShop" required>
                                                <option selected disabled>  Selecciona una opción</option>
                                                <?php getShops(); ?>
                                                <?php if($resultShops) while($rowShops = mysqli_fetch_array($resultShops)):;?>
                                                    <?php if($rowShops[5]):?>
                                                    <option value = "<?php echo $rowShops[0];?>"><?php echo $rowShops[1];?></option>
                                                    <?php endif;?>
                                                <?php endwhile;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="updDiscount" class="col-sm-3 control-label">Promoción</label>
                                        <div class="col-sm-9">
                                            <input type="text" name = "updDiscount" class="form-control material" id="updDiscount" placeholder="Promoción" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="updStartDate" class="col-sm-3 control-label">Inicio Vigencia</label>
                                        <div class="col-md-9">
                                            <input type="date" name = "updStartDate" class="form-control material" id="updStartDate" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="updEndDate" class="col-sm-3 control-label">Final Vigencia</label>
                                        <div class="col-sm-9">
                                            <input type="date" name = "updEndDate" class="form-control material" id="updEndDate" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3"></div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label for="updRestrictions" class="col-sm-3 control-label">Restricciones</label>
                                        <div class="col-sm-9">
                                            <textarea name = "updRestrictions" class="form-control material" id="updRestrictions" placeholder="Separar restricciones por saltos de línea (Enter). No agregar asteriscos (*) al inicio de cada renglón."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label class="col-sm-3 control-label">Ciudad del cupón</label>
                                        <input type="hidden" id="updCity" name="updCity">
                                        <div class="col-sm-9 checkboxHolder">
                                            <div class="col-sm-12 col-md-4 radio radio-warning radio-big">
                                                <label>
                                                    <input type="radio" name = "updLocalCity" class="material updLocalCity" value="aguascalientes" required>
                                                    <i></i>
                                                    Aguascalientes
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 radio radio-warning radio-big">
                                                <label>
                                                    <input type="radio" name = "updLocalCity" class="material updLocalCity" value="leon" required>
                                                    <i></i>
                                                    León
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 radio radio-warning radio-big">
                                                <label>
                                                    <input type="radio" name = "updLocalCity" class="material updLocalCity" value="queretaro" required>
                                                    <i></i>
                                                    Querétaro
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-4 radio radio-warning radio-big">
                                                <label>
                                                    <input type="radio" name = "updLocalCity" class="material updLocalCity" value="puebla" required>
                                                    <i></i>
                                                    Puebla
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right form-group">
                                        <input type="number" name = "updCIndex" id = "updCIndex" style = "display:none;">
                                        <button type = "submit" class = "btn btn-primary" name = "updCoupon">Actualizar</button>
                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-sm-12 col-lg-6 notifClear">
                                        <?php
                                            if(isset($_POST['updCoupon'])) {
                                                $result = updCoupon();
                                                if($result) echo '<meta http-equiv="refresh" content="0;URL=index_admin.php"/>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="content-box big-box" id = "created_Coupons">
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
                                        <th>Comercio</th>
                                        <th>Cupón</th>
                                        <th>Folio</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Teléfono</th>
                                        <th>Fecha de generación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($resultCreated) while($rowCreated = mysqli_fetch_array($resultCreated)):;?>
                                        <tr>
                                            <td><?php echo ++$contCreated;?></td>
                                            <td><?php echo $rowCreated[1];?></td>
                                            <td><?php echo $rowCreated[2];?></td>
                                            <td><?php echo $rowCreated[3];?></td>
                                            <td><?php echo $rowCreated[4];?></td>
                                            <td><?php echo $rowCreated[5];?></td>
                                            <td><?php echo $rowCreated[6];?></td>
                                            <td><?php echo dateFormat($rowCreated[7]);?></td>
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

                <div class="content-box big-box" id = "used_Coupons">
                    <div class="container">
                        <div class="row titleRow">
                            <div class="col-lg-12">
                                <h2>Cupones utilizados:</h2>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="datatable display">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Comercio</th>
                                        <th>Cupón</th>
                                        <th>Folio</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Teléfono</th>
                                        <th>Fecha de utilización</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($resultUsed) while($rowUsed = mysqli_fetch_array($resultUsed)):;?>
                                        <tr>
                                            <td><?php echo ++$contUsed;?></td>
                                            <td><?php echo $rowUsed[1];?></td>
                                            <td><?php echo $rowUsed[2];?></td>
                                            <td><?php echo $rowUsed[3];?></td>
                                            <td><?php echo $rowUsed[4];?></td>
                                            <td><?php echo $rowUsed[5];?></td>
                                            <td><?php echo $rowUsed[6];?></td>
                                            <td><?php echo dateFormat($rowUsed[7]);?></td>
                                        </tr>
                                    <?php endwhile;?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <form action="export.php" method = "post" class="caption text-center col-md-12">
                        <button class = "btn btn-primary" type = "submit" name = "exportUsed">Exportar tabla</button>
                    </form>
                </div>

                <!-- Usuarios -->
                <div class="content-box big-box" id = "view_Users">
                    <div class="container">
                        <div class="row titleRow">
                            <div class="col-lg-12">
                                <h2>Usuarios registrados:</h2>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="datatable display">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Teléfono</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($resultUsers) while($rowUsers = mysqli_fetch_array($resultUsers)):;?>
                                        <tr>
                                            <td><?php echo ++$contUsers;?></td>
                                            <td><?php echo $rowUsers[1];?></td>
                                            <td><?php echo $rowUsers[2];?></td>
                                            <td><?php echo $rowUsers[3];?></td>
                                        </tr>
                                    <?php endwhile;?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <form action="export.php" method = "post" class="caption text-center col-md-12">
                        <button class = "btn btn-primary" type = "submit" name = "exportUsers">Exportar tabla</button>
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
        
        <div id="alertNotifs"></div>

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
        <script src="bower_components/summernote/dist/summernote.min.js"></script>

        <script src="js/menu/classie.js"></script>
        <script src="js/menu/gnmenu.js"></script>
        <script src="js/selects/selectFx.js"></script>
        <script src="js/common.js"></script>

        <script>
            const imageTypes = ['png', 'jpg', 'jpeg'];

            function searchIndex(arr, arrSize, ind){
                for(var i = 0; i < arrSize; i++){
                    if(arr[i][0] == ind) return i;
                }
            }

            function validateUser(x){
                if(/[^a-z0-9]/.test(x)) {
                    alert('Sólo están permitidos valores [a-z] y [0-9] para el usuario del comercio.');
                    return false;
                }
                return true;
            }

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

            document.getElementById("coupStartDate").setAttribute("min", date);
            document.getElementById("coupEndDate").setAttribute("min", date);
            document.getElementById("updStartDate").setAttribute("min", date);
            document.getElementById("updEndDate").setAttribute("min", date);

            $("#coupStartDate").change(function(){
                $("#coupEndDate").attr("min", $("#coupStartDate").val());
            });

            $("#updStartDate").change(function(){
                $("#updEndDate").attr("min", $("#updStartDate").val());
            });

            $('button[name=shopCreate]').click(function(){
                if($('.localCategories:checked').length >= 1) $('#categoryValidate').attr('checked', 'checked');
                else swal({
                    type: 'warning',
                    title: '¡Error!',
                    text: 'Selecciona al menos una categoría'
                });
            });

            $('button[name=shopUpdate]').click(function(){
                if($('.updLocalCategories:checked').length >= 1) $('#updCategoryValidate').attr('checked', 'checked');
                else swal({
                    type: 'warning',
                    title: '¡Error!',
                    text: 'Selecciona al menos una categoría'
                });
            });

            $('.disableShops').click(function(){
                var id = $(this).attr('id').replace(/disableShop/,'');
                $('#disableShopID').val(id);
                $('#disShop').click();
            });

            $('#disShop').click(function(){
                swal({
                    title: '¿Está seguro?',
                    text: "Esto deshabilitará también todos los cupones relacionados a este comercio. Esta operación no es reversible.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3BDF6D',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, deseo continuar',
                    closeOnConfirm: false
                }, function(){
                    $('#confDisShop').click();
                });
            });

            $('.disableCoupons').click(function(){
                var id = $(this).attr('id').replace(/disableCoupon/,'');
                $('#disableCouponID').val(id);
                $('#disCoupon').click();
            });

            $('#disCoupon').click(function(){
                swal({
                    title: '¿Está seguro?',
                    text: "Esto deshabilitará permanentemente este cupón.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3BDF6D',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, deseo continuar',
                    closeOnConfirm: false
                }, function(){
                    $('#confDisCoupon').click();
                });
            })

            $('.sidebarLink').click(function(){
                $('.gn-menu-wrapper').removeClass("gn-open-all");
                $('html, body').animate({
                    scrollTop: $('#' + $(this).attr('value')).offset().top - 75
                }, 500);
            });

            $('.localCategories').click(function(){
                var categories = "";
                $.each($(".localCategories:checked"), function(){
                    categories += $(this).val() + "/";
                });
                categories = categories.substring(0, categories.length - 1);
                $('#shopCategories').val(categories);
            });

            $('#shopCreate').click(function(){
                let filename = $('#shopLogo').val();
                filename = filename.split('.');

                if(filename[0] === "") swal({
                    type: 'warning',
                    title: '¡Error!',
                    text: 'Agrega un logotipo para el comercio'
                });
                else if($.inArray(filename[1], imageTypes) === -1) swal({
                    type: 'warning',
                    title: '¡Error!',
                    text: 'Sube una imagen con extensión png, jpg o jpeg.'
                });
                else $('#vCreateLogo').prop('checked', 'checked');
            });            

            $('#shopUpdate').click(function(){
                let filename = $('#updLogo').val();
                filename = filename.split('.');

                if(filename[0] !== "" && $.inArray(filename[1], imageTypes) === -1) swal({
                    type: 'warning',
                    title: '¡Error!',
                    text: 'Sube una imagen con extensión png, jpg o jpeg.'
                });
                else $('#vUpdateLogo').prop('checked', 'checked');
            });

            $('.updLocalCategories').click(function(){
                var categories = "";
                $.each($(".updLocalCategories:checked"), function(){
                    categories += $(this).val() + "/";
                });
                categories = categories.substring(0, categories.length - 1);
                $('#updCategories').val(categories);
            });

            $('.localCity').click(function(){
                $('#coupCity').val($(".localCity:checked").val());
            });

            $('.updLocalCity').click(function(){
                $('#updCity').val($(".updLocalCity:checked").val());
            });
        </script>

        <script id = "editShopsScript">
            $('.editShops').click(function(){
                var shopSelector = $(this).val();
                var checkName = "";
                $('#edit_Shops').css('display', 'block');
                $('#updIndex').val(shopSelector);

                <?php getShops(); ?>

                <?php if($resultShops) while($itemShops = mysqli_fetch_array($resultShops)):;?>
                    checkName = "<?php echo $itemShops[0];?>";
                    if(checkName == shopSelector){
                        $("#updName").val("<?php echo $itemShops[1];?>");
                        $("#updUser").val("<?php echo $itemShops[3];?>");
                        $("#updPassword").val("<?php echo $itemShops[4];?>");

                        var cats = "<?php echo $itemShops[6];?>";
                        cats = cats.split("/");

                        if(cats[0] != "") for(var i = 0; i < cats.length; i++) $('.updLocalCategories[value=' + cats[i] + ']').prop('checked', true);
                    }
                <?php endwhile;?>

                $('html, body').animate({
                    scrollTop: $("#edit_Shops").offset().top - 75
                }, 500);
            });
        </script>

        <script id = "editCouponsScript">
            $('.editCoupons').click(function(){
                var couponSelector = $(this).val();
                var checkName = "";
                $('#edit_Coupons').css('display', 'block');
                $('#updCIndex').val(couponSelector);

                <?php getCoupons(); ?>

                <?php if($resultCoupons) while($itemCoupons = mysqli_fetch_array($resultCoupons)):;?>
                    checkName = "<?php echo $itemCoupons[0];?>";
                    if(checkName == couponSelector){
                        var shopName = "<?php echo $itemCoupons[1];?>";
                        $("#updCShop option").filter(function(){return $(this).text() == shopName;}).prop('selected', true);
                        $("#updDiscount").val("<?php echo $itemCoupons[2];?>");
                        $("#updStartDate").val("<?php echo $itemCoupons[3];?>");
                        $("#updEndDate").val("<?php echo $itemCoupons[4];?>");
                        $("#updRestrictions").val("<?php echo $itemCoupons[5];?>");
                        if("<?php echo $itemCoupons[7];?>" != "") $(".updLocalCity[value=<?php echo $itemCoupons[7];?>]").prop('checked', true);
                    }
                <?php endwhile;?>

                $('html, body').animate({
                    scrollTop: $("#edit_Coupons").offset().top - 75
                }, 500);
            });
        </script>

        <?php
            if(isset($_POST['confDisShop'])) {
                disableShop($_POST['disableShopID']);
                echo '<meta http-equiv="refresh" content="1;URL=index_admin.php"/>';
            }

            if(isset($_POST['confDisCoupon'])){
                disableCoupon($_POST['disableCouponID']);
                echo '<meta http-equiv="refresh" content="1;URL=index_admin.php"/>';
            }
        ?>
    </body>
</html>