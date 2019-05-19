<?php
/*
* Template Name: localidadController
*/
session_start(); //Iniciamos o Continuamos la sesion


include ('../models/transferencia.php');
include ('../models/getCNE.php');
include ('../models/cliente.php');

$mode = $_REQUEST['mode'];
$CNE = new CedulaVE();
$objTransferencia = new Transferencia();
$objcliente = new cliente();

if ($mode == 'loadAll'){

	$Transferencia = $objTransferencia->getAll();
	
	$response = $objTransferencia->formatQueryAll($Transferencia);
	
	echo json_encode($response, JSON_UNESCAPED_UNICODE);

}else if ($mode == 'loadCuentas'){

		$Transferencia = $objTransferencia->getCuentas();
		
		$response = $objTransferencia->formatQuerycuentas($Transferencia);
		
		echo json_encode($response, JSON_UNESCAPED_UNICODE);
} elseif ($mode == "insertarTransferencia") {
	$cedula = $_POST["cedula"];
	$nombre = $_POST["nombre"];
	$monto = $_POST["monto"];
	$banco = $_POST["banco"];
	$cuenta = $_POST["cuenta"];
	$estatus = $_POST["estatus"];
	$response = $objTransferencia->insertTransferencia($cedula,$nombre,$monto,$banco,$cuenta,$estatus);
	if($response>1){
		$result = $objTransferencia->getAll();
		$response = $objTransferencia->formatQueryAll($result);
	}
	echo json_encode($response, JSON_UNESCAPED_UNICODE);

	

}else if($mode == "registrarporcedula"){
	$cedula = $_POST["cedula"];
	$persona = $CNE->get('V',$cedula,false);
	$nombres = $persona["response"]["nombres"];
	$apellidos = $persona["response"]["apellidos"];
	$direccion = $persona["response"]["estado"] . $persona["response"]["municipio"] . $persona["response"]["parroquia"];
	$objcliente->insertcliente($cedula,$nombres,$apellidos,$direccion);
	echo json_encode($persona, JSON_UNESCAPED_UNICODE);
}else if($mode == "obtenercliente"){
	$cedula = $_POST["cedula"];
	$response = $objcliente->getcliente($cedula);
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

?>