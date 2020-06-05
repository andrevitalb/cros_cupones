<?php
    include('connections.php');

    function nameFormat($cadena){
        $cadena = str_replace('Á', 'á', $cadena);
        $cadena = str_replace('É', 'é', $cadena);
        $cadena = str_replace('Í', 'í', $cadena);
        $cadena = str_replace('Ó', 'ó', $cadena);
        $cadena = str_replace('Ú', 'ú', $cadena);
        $cadena = str_replace('Ñ', 'ñ', $cadena);
        $cadena = strtolower($cadena);
        
        return ucwords($cadena);
    }

    function cleanString($cadena){
        $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'),
        $cadena
        );
 
        $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('e', 'e', 'e', 'e', 'e', 'e', 'e', 'e'),
        $cadena);
 
        $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('i', 'i', 'i', 'i', 'i', 'i', 'i', 'i'),
        $cadena);
 
        $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('o', 'o', 'o', 'o', 'o', 'o', 'o', 'o'),
        $cadena);
 
        $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('u', 'u', 'u', 'u', 'u', 'u', 'u', 'u'),
        $cadena);
 
        $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç'),
        array('n', 'n', 'C', 'c'),
        $cadena
        );
        
        return strtolower($cadena);
    }

    mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    function getShops(){
        global $resultShops, $connect;

        $queryShops = "Select comercios_ID, comercios_nombre as Comercio, comercios_logo as Logo, comercios_usuario as Usuario, comercios_password as Contraseña, comercios_habilitado as Habilitado, comercios_categorias as Categorías from comercios order by comercios_ID";
        $resultShops = mysqli_query($connect, $queryShops);
    }

    function addShop() {
        global $connect;

        $nombre = nameFormat($_POST["shopName"]);
        $usuario = cleanString($_POST["shopUser"]);
        $password = $_POST["shopPassword"];
        $categories = $_POST["shopCategories"];
        $uploadOk = 1;

        $queryMax = "Select MAX(comercios_ID) from comercios";
        $takeMax = mysqli_query($connect, $queryMax);
        $maxInd = mysqli_fetch_array($takeMax);
        $maxInd[0] += 1;

        $queryNew = 'Insert into comercios (comercios_ID, comercios_nombre, comercios_logo, comercios_usuario, comercios_password, comercios_categorias) values ('.$maxInd[0].', "'.$nombre.'", ';

        $target_dir = "img/custom-img/logos/";
        $logoFileName = $target_dir . basename($_FILES["shopLogo"]["name"]);
        $logoFileType = strtolower(pathinfo($logoFileName,PATHINFO_EXTENSION));
        $logoFileName = $target_dir . "comercio_" . $maxInd[0] . "." . $logoFileType;
        $uploadOk = 1;

        $check = getimagesize($_FILES["shopLogo"]["tmp_name"]);
        if($check !== false)  $uploadOk = 1;
        else $uploadOk = 0;

        if ($uploadOk == 0) echo '<div class="alert alert-danger alert-dismissible" role="alert" id = "add_error"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Error!</strong> Ocurrió un error, tu archivo no se pudo subir.</div>';
        else {
            move_uploaded_file($_FILES["shopLogo"]["tmp_name"], $logoFileName);

            $queryNew .= "'$logoFileName', '$usuario','$password','$categories')";

            $resultAddComercio = mysqli_query($connect, $queryNew);

            if($resultAddComercio) echo '<div class="alert alert-success alert-dismissible" role="alert" id = "add_correct"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Éxito!</strong> Comercio creado satisfactoriamente.</div>';
            else echo '<div class="alert alert-danger alert-dismissible" role="alert" id = "add_error"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Error!</strong> Ocurrió un problema, vuelve a intentarlo más tarde.</div>';
        }

        getShops();
    }

    function updShop(){
        global $connect;

        $id = $_POST['updIndex'];
        $nombre = nameFormat($_POST["updName"]);
        $usuario = cleanString($_POST["updUser"]);
        $password = $_POST["updPassword"];
        $categories = $_POST["updCategories"];
        $uploadOk = 1;

        $queryUpd = 'Update comercios set comercios_nombre = "'.$nombre.'", comercios_usuario = "'.$usuario.'", comercios_password = "'.$password.'", comercios_categorias = "'.$categories.'"';

        if($_FILES['updLogo']['size'] > 0) {
            $queryUpd .= ', comercios_logo = "';
            $target_dir = "img/custom-img/logos/";
            $logoFileName = $target_dir . basename($_FILES["updLogo"]["name"]);
            $logoFileType = strtolower(pathinfo($logoFileName,PATHINFO_EXTENSION));
            $logoFileName = $target_dir . "comercio_" . $id . "." . $logoFileType;
            $uploadOk = 1;

            $check = getimagesize($_FILES["updLogo"]["tmp_name"]);
            if($check !== false)  $uploadOk = 1;
            else $uploadOk = 0;

            if ($uploadOk == 0) echo '<div class="alert alert-danger alert-dismissible" role="alert" id = "add_error"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Error!</strong> Ocurrió un error, tu archivo no se pudo subir.</div>';
            else move_uploaded_file($_FILES["updLogo"]["tmp_name"], $logoFileName);

            $queryUpd .= $logoFileName.'"';
        }

        $queryUpd .= ' where comercios_ID = '. $id;

        $resultUpdComercio = mysqli_query($connect, $queryUpd);

        if($resultUpdComercio) echo '<div class="alert alert-success alert-dismissible" role="alert" id = "add_correct"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Éxito!</strong> Comercio actualizado satisfactoriamente.</div>';
        else echo '<div class="alert alert-danger alert-dismissible" role="alert" id = "add_error"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>¡Error!</strong> Ocurrió un problema, vuelve a intentarlo más tarde.</div>';

        getShops();
        return 1;
    }

    function disableShop($shopID){
        global $connect;

        $queryDisable = "Update comercios set comercios_habilitado = 0 where comercios_ID = $shopID";
        $resultDisable = mysqli_query($connect, $queryDisable);

        if($resultDisable){
            getShops();
            $queryDisableCs = "Update cupones set cupones_habilitado = 0 where cupones_comercio = $shopID";
            $resultDisableCs = mysqli_query($connect, $queryDisableCs);

            if($resultDisableCs){
                getCoupons();
                echo '<script>swal("¡Éxito!", "Comercio eliminado satisfactoriamente.", "success");</script>';
            }
        }
        else echo '<script>swal("¡Error!", "Occurió un problema, por favor vuelve a intentarlo.", "error");</script>';
    }
?>