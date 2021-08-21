<?php
require '../KERNEL-XDRCMS/Init.php';


$prueba['Error'] = [
    'usuario' => 'hola',
    'contraseña' => 'probando',
    'holahola' => 'testing'
];

foreach($prueba['Error'] as $Error):
    echo $Error . "</br>";
endforeach;

?>