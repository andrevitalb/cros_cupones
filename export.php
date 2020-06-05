<?php
    include('connections.php');
    
  	mysqli_set_charset ($connect, "utf8");

	if (isset($_POST["exportCreated"])){
		$queryCreated = "Select CU.cupsusrs_ID as ID, CO.comercios_nombre as Comercio, C.cupones_promocion as Cupón, CU.cupsusrs_folio as Folio, U.usuarios_nombre as Nombre, U.usuarios_correo as Correo, U.usuarios_telefono as Teléfono, CU.cupsusrs_fechaGen as 'Fecha de generación' from cupsusrs as CU inner join cupones as C on CU.cupsusrs_cupon = C.cupones_ID inner join usuarios as U on CU.cupsusrs_usuario = U.usuarios_ID inner join comercios as CO on C.cupones_comercio = CO.comercios_ID order by ID";
    	$resultCreated = mysqli_query($connect, $queryCreated);
		$filename = "cupones_generados.xls";
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		$isPrintHeader = false;

		if (!empty($resultCreated)){
			foreach ($resultCreated as $row){
				if(!$isPrintHeader){
					echo implode("\t", array_keys($row)) . "\n";
					$isPrintHeader = true;
				}
				echo implode("\t", array_values($row)) . "\n";
			}
		}
		exit();
	}

	if (isset($_POST["exportUsed"])){
		$queryUsed = "Select CU.cupsusrs_ID as ID, CO.comercios_nombre as Comercio, C.cupones_promocion as Cupón, CU.cupsusrs_folio as Folio, U.usuarios_nombre as Nombre, U.usuarios_correo as Correo, U.usuarios_telefono as Teléfono, CU.cupsusrs_fechaUso as 'Fecha de utilización' from cupsusrs as CU inner join cupones as C on CU.cupsusrs_cupon = C.cupones_ID inner join usuarios as U on CU.cupsusrs_usuario = U.usuarios_ID inner join comercios as CO on C.cupones_comercio = CO.comercios_ID where CU.cupsusrs_fechaUso is not NULL order by ID";
    	$resultUsed = mysqli_query($connect, $queryUsed);
		$filename = "cupones_utilizados.xls";
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		$isPrintHeader = false;

		if (!empty($resultUsed)){
			foreach ($resultUsed as $row){
				if(!$isPrintHeader){
					echo implode("\t", array_keys($row)) . "\n";
					$isPrintHeader = true;
				}
				echo implode("\t", array_values($row)) . "\n";
			}
		}
		exit();
	}

	if (isset($_POST["exportUsers"])){
		$queryUsers = "Select usuarios_ID as ID, usuarios_nombre as Nombre, usuarios_correo as Correo, usuarios_telefono as Teléfono from usuarios order by usuarios_ID";
    	$resultUsers = mysqli_query($connect, $queryUsers);
		$filename = "usuarios_registrados.xls";
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		$isPrintHeader = false;

		if (!empty($resultUsers)){
			foreach ($resultUsers as $row){
				if(!$isPrintHeader){
					echo implode("\t", array_keys($row)) . "\n";
					$isPrintHeader = true;
				}
				echo implode("\t", array_values($row)) . "\n";
			}
		}
		exit();
	}
?>