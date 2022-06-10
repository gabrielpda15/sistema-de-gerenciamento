<?php
defined('HOST') or define('HOST', 'localhost');
defined('USER') or define('USER', 'dev');
defined('PASS') or define('PASS', '102030');
defined('BASE') or define('BASE', 'sistema_gerenciamento');

    $conn = new mysqli(HOST,USER,PASS,BASE);
