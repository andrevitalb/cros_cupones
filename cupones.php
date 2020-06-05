<?php
    include('connections.php');

    // function $cadena){
    //     $cadena = str_replace(
    //     array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    //     array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'),
    //     $cadena
    //     );
 
    //     $cadena = str_replace(
    //     array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    //     array('e', 'e', 'e', 'e', 'e', 'e', 'e', 'e'),
    //     $cadena);
 
    //     $cadena = str_replace(
    //     array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    //     array('i', 'i', 'i', 'i', 'i', 'i', 'i', 'i'),
    //     $cadena);
 
    //     $cadena = str_replace(
    //     array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    //     array('o', 'o', 'o', 'o', 'o', 'o', 'o', 'o'),
    //     $cadena);
 
    //     $cadena = str_replace(
    //     array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    //     array('u', 'u', 'u', 'u', 'u', 'u', 'u', 'u'),
    //     $cadena);
 
    //     $cadena = str_replace(
    //     array('Ñ', 'ñ', 'Ç', 'ç'),
    //     array('n', 'n', 'C', 'c'),
    //     $cadena
    //     );
        
    //     return strtolower($cadena);
    // }

    mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    function getCoupons(){
        global $resultCoupons, $connect;

        $queryCoupons = "Select cupones_ID, CM.comercios_nombre as Comercio, cupones_promocion as Cupón, cupones_vigenciaInicio as 'Inicio Vigencia', cupones_vigenciaFin as 'Final Vigencia', cupones_restricciones as Restricciones, cupones_habilitado as Activo, cupones_ubicacion as Ubicación from cupones inner join comercios as CM on cupones_comercio = CM.comercios_ID order by cupones_ID";
        $resultCoupons = mysqli_query($connect, $queryCoupons);
    }

    function addCoupon() {
        global $connect;

        $comercio = $_POST["coupShop"];
        $descuento = $_POST["coupDiscount"];
        $inicioVigencia = $_POST["coupStartDate"];
        $finVigencia = $_POST["coupEndDate"];
        $restricciones = $_POST["coupRestrictions"];
        $ciudad = $_POST["coupCity"];
        $rest = explode("\n", $restricciones);
        $lines = sizeof($rest);
        $restricciones = "";

        for($i = 0; $i < $lines; $i++) {
            $rest[$i] = trim($rest[$i], " \n<br>*");
            if($rest[$i] != "") $restricciones .= "* " . $rest[$i] ."<br>";
        }

        $queryMax = "Select MAX(cupones_ID) from cupones";
        $takeMax = mysqli_query($connect, $queryMax);
        $maxInd = mysqli_fetch_array($takeMax);
        $maxInd[0] += 1;

        $queryNew = 'Insert into cupones (cupones_ID, cupones_comercio, cupones_promocion, cupones_vigenciaInicio, cupones_vigenciaFin, cupones_restricciones, cupones_ubicacion) values ('.$maxInd[0].', '.$comercio.', "'.$descuento.'","'.$inicioVigencia.'","'.$finVigencia.'","'.$restricciones.'","'.$ciudad.'")';

        $resultAddCoupon = mysqli_query($connect, $queryNew);

        if($resultAddCoupon) echo '<div class="alert alert-success alert-dismissible" role="alert" id = "add_correct"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Éxito!</strong> Cupón creado satisfactoriamente.</div>';
        else echo '<div class="alert alert-danger alert-dismissible" role="alert" id = "add_error"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Error!</strong> Ocurrió un problema, vuelve a intentarlo más tarde.</div>';

        getCoupons();
    }

    function updCoupon(){
        global $connect;

        $id = $_POST["updCIndex"];
        $comercio = $_POST["updCShop"];
        $descuento = $_POST["updDiscount"];
        $inicioVigencia = $_POST["updStartDate"];
        $finVigencia = $_POST["updEndDate"];
        $restricciones = $_POST["updRestrictions"];
        $ciudad = $_POST["updCity"];
        $rest = explode("\n", $restricciones);
        $lines = sizeof($rest);
        $restricciones = "";

        for($i = 0; $i < $lines; $i++) {
            $rest[$i] = trim($rest[$i], " \n<br>*");
            if($rest[$i] != "") $restricciones .= "* " . $rest[$i] ."<br>";
        }

        $queryUpd = 'Update cupones set cupones_comercio = '.$comercio.', cupones_promocion = "'.$descuento.'", cupones_vigenciaInicio = "'.$inicioVigencia.'", cupones_vigenciaFin = "'.$finVigencia.'", cupones_restricciones = "'.$restricciones.'", cupones_ubicacion = "'.$ciudad.'" where cupones_ID = '.$id;

        $resultUpdCoupon = mysqli_query($connect, $queryUpd);

        if($resultUpdCoupon) echo '<div class="alert alert-success alert-dismissible" role="alert" id = "add_correct"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Éxito!</strong> Cupón actualizado satisfactoriamente.</div>';
        else echo '<div class="alert alert-danger alert-dismissible" role="alert" id = "add_error"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Error!</strong> Ocurrió un problema, vuelve a intentarlo más tarde.</div>';

        getCoupons();
        return 1;
    }

    function disableCoupon($couponID){
        global $connect;

        $queryDisable = "Update cupones set cupones_habilitado = 0 where cupones_ID = $couponID";
        $resultDisable = mysqli_query($connect, $queryDisable);

        if($resultDisable){
            getCoupons();
            echo '<script>swal("¡Éxito!", "Cupón eliminado satisfactoriamente.", "success");</script>';
        }
        else echo '<script>swal("¡Error!", "Occurió un problema, por favor vuelve a intentarlo.", "error");</script>';
    }

    function getCreatedCoups($shop){
        global $connect, $resultCreated;

        if($shop) $queryCreated = "Select C.cupones_promocion as Cupón, CU.cupsusrs_folio as Folio, U.usuarios_nombre as Nombre, CU.cupsusrs_fechaGen as 'Fecha de generación', CU.cupsusrs_fechaUso as 'Fecha de utilización' from cupsusrs as CU inner join cupones as C on CU.cupsusrs_cupon = C.cupones_ID inner join usuarios as U on CU.cupsusrs_usuario = U.usuarios_ID inner join comercios as CO on C.cupones_comercio = CO.comercios_ID where C.cupones_comercio = $shop";
        else $queryCreated = "Select CU.cupsusrs_ID as ID, CO.comercios_nombre as Comercio, C.cupones_promocion as Cupón, CU.cupsusrs_folio as Folio, U.usuarios_nombre as Nombre, U.usuarios_correo as Correo, U.usuarios_telefono as Teléfono, CU.cupsusrs_fechaGen as 'Fecha de generación' from cupsusrs as CU inner join cupones as C on CU.cupsusrs_cupon = C.cupones_ID inner join usuarios as U on CU.cupsusrs_usuario = U.usuarios_ID inner join comercios as CO on C.cupones_comercio = CO.comercios_ID order by ID";
        $resultCreated = mysqli_query($connect, $queryCreated);
    }

    function getUsedCoups(){
        global $connect, $resultUsed;

        $queryUsed = "Select CU.cupsusrs_ID as ID, CO.comercios_nombre as Comercio, C.cupones_promocion as Cupón, CU.cupsusrs_folio as Folio, U.usuarios_nombre as Nombre, U.usuarios_correo as Correo, U.usuarios_telefono as Teléfono, CU.cupsusrs_fechaUso as 'Fecha de utilización' from cupsusrs as CU inner join cupones as C on CU.cupsusrs_cupon = C.cupones_ID inner join usuarios as U on CU.cupsusrs_usuario = U.usuarios_ID inner join comercios as CO on C.cupones_comercio = CO.comercios_ID where CU.cupsusrs_fechaUso is not NULL order by ID";
        $resultUsed = mysqli_query($connect, $queryUsed);
    }

    function useCoupon($shop){
        global $connect;

        $couponFolio = strtoupper($_REQUEST['couponFolio']);

        $queryCheckUsed = "Select cupsusrs_fechaUso from cupsusrs where cupsusrs_folio = '$couponFolio'";
        $resultCheckUsed = mysqli_query($connect, $queryCheckUsed);
        $rCheckUsed = mysqli_fetch_array($resultCheckUsed);

        if(!$rCheckUsed[0]){
            $queryShopCheck = "Select C.cupones_comercio from cupsusrs as CU inner join cupones as C on CU.cupsusrs_cupon = C.cupones_ID where cupsusrs_folio = '$couponFolio'";
            $resultShopCheck = mysqli_query($connect, $queryShopCheck);
            $rShopCheck = mysqli_fetch_array($resultShopCheck);

            if($shop == $rShopCheck[0]){
                $queryCheckDate = "Select cupones_vigenciaInicio, cupones_vigenciaFin, CURDATE() from cupsusrs as CU inner join cupones as C on CU.cupsusrs_cupon = C.cupones_ID where cupsusrs_folio = '$couponFolio'";
                $resultCheckDate = mysqli_query($connect, $queryCheckDate);
                $rCheckDate = mysqli_fetch_array($resultCheckDate);

                if($rCheckDate[0] <= $rCheckDate[2] && $rCheckDate[1] >= $rCheckDate[2]){
                    $queryUseCoupon = "Update cupsusrs set cupsusrs_fechaUso = CURDATE() where cupsusrs_folio = '$couponFolio'";
                    $resultUseCoupon = mysqli_query($connect, $queryUseCoupon);

                    $queryCheckCoupon = "Select cupones_promocion from cupsusrs inner join cupones on cupsusrs_cupon = cupones_ID where cupsusrs_folio = '$couponFolio'";
                    $resultCheckCoupon = mysqli_query($connect, $queryCheckCoupon);
                    $rCheckCoupon = mysqli_fetch_array($resultCheckCoupon);

                    if($resultUseCoupon) echo "<div class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Cupón a aplicar:</strong> $rCheckCoupon[0]</div><div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>¡Éxito!</strong> Cupón utilizado correctamente.</div>";
                    else echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Error!</strong> Ocurrió un problema, vuelve a intentarlo más tarde.</div>';
                }
                else echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Error!</strong> La vigencia de este cupón no es válida.</div>';
            }
            else echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Error!</strong> Este cupón no es para este comercio.</div>';
        }
        else echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Error!</strong> Cupón ya utilizado, por favor verifica el folio ingresado.</div>';
    }
?>