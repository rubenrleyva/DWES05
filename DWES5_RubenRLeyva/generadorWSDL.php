<?php

require 'funciones.php';
require 'WSDLDocument.php';

// Se generan las rutas del archivo
$enlaces = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$wsdl = new WSDLDocument('funciones', $enlaces, $enlaces);

echo $wsdl->saveXML();

