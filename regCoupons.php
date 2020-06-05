<?php 
	include('connections.php');
	include('general.php');

    mysqli_set_charset ($connect, "utf8");
    date_default_timezone_set('America/Mexico_City');

    $name = $_REQUEST['couponName'];
    $mail = $_REQUEST['couponMail'];
    $phone = $_REQUEST['couponTel'];
    $coupon = $_REQUEST['coupId'];

    if(isset($name, $mail, $phone, $coupon) && $name != "" && $mail != "" && $phone != "" && $coupon != ""){
	    $queryMax = "Select MAX(cupsusrs_ID) from cupsusrs";
	    $takeMax = mysqli_query($connect, $queryMax);
	    $maxInd = mysqli_fetch_array($takeMax);
	    $maxInd[0] += 1;

	    $queryUserID = "Select usuarios_ID from usuarios where usuarios_correo = '$mail'";
	    $resultUsr = mysqli_query($connect, $queryUserID);
	    $usrID = mysqli_fetch_array($resultUsr);
	    if(!$usrID) {
	    	$queryMaxUsr = "Select MAX(usuarios_ID) from usuarios";
		    $takeMaxUsr = mysqli_query($connect, $queryMaxUsr);
		    $maxUsrInd = mysqli_fetch_array($takeMaxUsr);
		    $maxUsrInd[0] += 1;
		    $usrID[0] = $maxUsrInd[0];

		    $queryNewUser = "Insert into usuarios (usuarios_ID, usuarios_nombre, usuarios_correo, usuarios_telefono) values ($usrID[0], '$name', '$mail', '$phone')";
		    $resultNewUser = mysqli_query($connect, $queryNewUser);
	    }

	    $queryComercio = "Select comercios_nombre, comercios_logo from cupones inner join comercios on cupones_comercio = comercios_ID where cupones_ID = $coupon";
	    $resultComercio = mysqli_query($connect, $queryComercio);
	    $shop = mysqli_fetch_array($resultComercio);

	    $logo = $shop[1];
	    $folio = "";

	    $queryCheckPromo = "Select cupsusrs_folio from cupsusrs where cupsusrs_cupon = $coupon and cupsusrs_usuario = $usrID[0]";
	    $resultCheckPromo = mysqli_query($connect, $queryCheckPromo);
	    $rCheckPromo = mysqli_fetch_array($resultCheckPromo);

	    if(!$rCheckPromo[0]){
	    	$tempFolio = "";

		    $splittedShop = explode(' ', $shop[0]);
		    for($i = 0; $i < count($splittedShop); $i++) $folio .= strtoupper(substr($splittedShop[$i], 0, 1));

		    $rFolio[0] = 1;

		    while($rFolio[0]){
		    	$tempFolio = $folio;
		    	$folioNumber = strval(rand(0, 99999));	
				$tempFolio .= sprintf("%05d", $folioNumber);

				$queryFolio = "Select cupsusrs_folio from cupsusrs where cupsusrs_folio = '$tempFolio'";
				$resultFolio = mysqli_query($connect, $queryFolio);
				$rFolio = mysqli_fetch_array($resultFolio);
		    }

		    $folio = $tempFolio;
		}
		else $folio = $rCheckPromo[0];

	    $queryCup = "Select cupones_vigenciaInicio, cupones_vigenciaFin, cupones_promocion, cupones_restricciones from cupones where cupones_ID = $coupon";
	    $resultCup = mysqli_query($connect, $queryCup);
	    $cupData = mysqli_fetch_array($resultCup);
	    $vigenciaInicio = dateFormat($cupData[0]);
	    $vigenciaFin = dateFormat($cupData[1]);
	    $promocion = $cupData[2];
	    $restricciones = $cupData[3];

		$subject = "Tu cupón de $shop[0]";

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: noreply@cros.com.mx'."\r\n";

		$message = "
		<html>
		<head>
		<title>$subject</title>
		</head>
		<body>
		<table width='50%' border='0' align='center' cellpadding='0' cellspacing='0' style='border-radius:15px; border: 1.5px solid #CF222C !important;'>
		<tr>
		<td colspan='2' align='center' valign='top'><img style='width: 250px; margin-top: 15px;' src='https://www.cros.com.mx/cupones/$logo'></td>
		</tr>
		<tr>
		<td width='50%' align='right'>&nbsp;</td>
		<td align='left'>&nbsp;</td>
		</tr>
		<tr>
		<td colspan='2' align='center' valign='top' style='border-top:1px solid #dfdfdf; border-bottom:1px solid #dfdfdf;font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#000; padding:20px 15px;'>
			<span style = 'font-size:30px;'>$promocion</span><br><br>
			Vigencia:<strong>$vigenciaInicio</strong> al <strong>$vigenciaFin</strong><br><br>
			<span style = 'font-size:28px'>$folio</span><br><br>
			<span style='font-size:13px'>$restricciones</span><br><br>
		</td>
		</tr>
		<tr>
		<td colspan='2' align='center' valign='top'><img style='width: 100px; margin-top: 15px;' src='https://cros.com.mx/cupones/img/logo_azul.png'></td>
		</tr>
		<tr>
		<td width='50%' align='right'>&nbsp;</td>
		<td align='left'>&nbsp;</td>
		</tr>
		</table>
		</body>
		</html>
		";

	    if(!$rCheckPromo){
		    $queryInsert = "Insert into cupsusrs (cupsusrs_ID, cupsusrs_cupon, cupsusrs_usuario, cupsusrs_folio, cupsusrs_fechaGen) values ($maxInd[0], $coupon, $usrID[0], '$folio', CURDATE())";
		    $resultInsert = mysqli_query($connect, $queryInsert);

		    if($resultInsert) {
				if(mail($mail, $subject, $message, $headers)) echo'<body><link href="https://fonts.googleapis.com/css?family=Lato|Ubuntu&display=swap" rel="stylesheet"><div><div><img src="https://cros.com.mx/images/CrosLogoBlanco.png" alt="Logo Cros"></div><h1>Cupón Generado</h1><h4>Revisa tu correo para obtener el código de tu cupón y preséntalo en el establecimiento seleccionado</h4></div><style>*{color:#fff;}body{margin: 0;padding: 0;background-color: #005CAA;background-size: cover;height: 100vh;width: 100vw;}body>div {position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);display: block;text-align: center;width: 85%;}img{width: 14rem;display: inline-block;margin: 0 0 5rem;}h1{font-family: Lato, sans-serif;font-size: 50px;font-weight: 700;text-transform: uppercase;display: inline-block;margin: 0 0 1.5rem;}h4{font-size: 32px;font-family: Ubuntu, sans-serif;font-weight: 400;margin: 0;}</style></body><meta http-equiv="refresh" content="2.5;URL=index.php"/>';
		    }
		    else echo '<body><link href="https://fonts.googleapis.com/css?family=Lato|Ubuntu&display=swap" rel="stylesheet"><div><div><img src="https://cros.com.mx/images/CrosLogoBlanco.png" alt="Logo Cros"></div><h1>Ocurrió un problema</h1><h4>Por favor, vuelve a intentar generar tu cupón.</h4></div><style>*{color:#fff;}body{margin: 0;padding: 0;background-color: #005CAA;background-size: cover;height: 100vh;width: 100vw;}body>div {position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);display: block;text-align: center;width: 85%;}img{width: 14rem;display: inline-block;margin: 0 0 5rem;}h1{font-family: Lato, sans-serif;font-size: 50px;font-weight: 700;text-transform: uppercase;display: inline-block;margin: 0 0 1.5rem;}h4{font-size: 32px;font-family: Ubuntu, sans-serif;font-weight: 400;margin: 0;}</style></body><meta http-equiv="refresh" content="2.5;URL=index.php"/>';
		}
		else {
			if(mail($mail, $subject, $message, $headers)) echo '<body><link href="https://fonts.googleapis.com/css?family=Lato|Ubuntu&display=swap" rel="stylesheet"><div><div><img src="https://cros.com.mx/images/CrosLogoBlanco.png" alt="Logo Cros"></div><h1>Cupón reenviado</h1><h4>Consulta en tu correo el cupón ya generado para esta promoción.</h4></div><style>*{color:#fff;}body{margin: 0;padding: 0;background-color: #005CAA;background-size: cover;height: 100vh;width: 100vw;}body>div {position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);display: block;text-align: center;width: 85%;}img{width: 14rem;display: inline-block;margin: 0 0 5rem;}h1{font-family: Lato, sans-serif;font-size: 50px;font-weight: 700;text-transform: uppercase;display: inline-block;margin: 0 0 1.5rem;}h4{font-size: 32px;font-family: Ubuntu, sans-serif;font-weight: 400;margin: 0;}</style></body><meta http-equiv="refresh" content="2.5;URL=index.php"/>';
		    else echo '<body><link href="https://fonts.googleapis.com/css?family=Lato|Ubuntu&display=swap" rel="stylesheet"><div><div><img src="https://cros.com.mx/images/CrosLogoBlanco.png" alt="Logo Cros"></div><h1>Ocurrió un problema</h1><h4>Por favor, vuelve a intentar generar tu cupón.</h4></div><style>*{color:#fff;}body{margin: 0;padding: 0;background-color: #005CAA;background-size: cover;height: 100vh;width: 100vw;}body>div {position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);display: block;text-align: center;width: 85%;}img{width: 14rem;display: inline-block;margin: 0 0 5rem;}h1{font-family: Lato, sans-serif;font-size: 50px;font-weight: 700;text-transform: uppercase;display: inline-block;margin: 0 0 1.5rem;}h4{font-size: 32px;font-family: Ubuntu, sans-serif;font-weight: 400;margin: 0;}</style></body><meta http-equiv="refresh" content="2.5;URL=index.php"/>';
		}
	}
	else echo '<body><link href="https://fonts.googleapis.com/css?family=Lato|Ubuntu&display=swap" rel="stylesheet"><div><div><img src="https://cros.com.mx/images/CrosLogoBlanco.png" alt="Logo Cros"></div><h1>Ocurrió un problema</h1><h4>Por favor, llena todos los campos del formulario para generar tu cupón.</h4></div><style>*{color:#fff;}body{margin: 0;padding: 0;background-color: #005CAA;background-size: cover;height: 100vh;width: 100vw;}body>div {position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);display: block;text-align: center;width: 85%;}img{width: 14rem;display: inline-block;margin: 0 0 5rem;}h1{font-family: Lato, sans-serif;font-size: 50px;font-weight: 700;text-transform: uppercase;display: inline-block;margin: 0 0 1.5rem;}h4{font-size: 32px;font-family: Ubuntu, sans-serif;font-weight: 400;margin: 0;}</style></body><meta http-equiv="refresh" content="2.5;URL=index.php"/>';
?>