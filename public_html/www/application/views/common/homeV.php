<?php

$rr = array('rs' => (int)$meminf[0]['su'], 'tel' => $meminf[0]['tel'], 'name' => $meminf[0]['name'], 'potion' => (int)$meminf[0]['potion'], 'cogubun' => (int)$meminf[0]['cogubun'], 'coid' => (int)$meminf[0]['coid'], 'passwd' => $meminf[0]['passwd']);

echo json_encode($rr);

?>
