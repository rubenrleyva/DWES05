<?php

require_once 'Funciones.php';

// Se generan las rutas del archivo
$enlaceUri = str_replace("/funciones.wsdl", "", "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$server = new SoapServer(null, array('uri'=>$enlaceUri));
$server->setClass('funciones');
$server->handle();

