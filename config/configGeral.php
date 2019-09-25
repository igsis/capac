<?php
define('SERVERURL', "http://{$_SERVER['HTTP_HOST']}/capac/");
define('NOMESIS', "CAPAC");
define('UPLOADDIR', "../uploads/");
date_default_timezone_set('America/Sao_Paulo');
ini_set('session.gc_maxlifetime', 60*60); // 60 minutos