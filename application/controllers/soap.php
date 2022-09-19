<?php
require_once 'lib/Nusoap.php';

$cliente = new nusoap_client('https://banguat.gob.gt/variables/ws/TipoCambio.asmx?op=TipoCambioDia');

$parametros = array('');

?>