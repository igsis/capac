<?php
    define('SERVER', "localhost");
    define('DB', "capac");
    define('USER', "root", true);
    define('PASS', "", true);

    define('SGBD', "mysql:host=".SERVER.";dbname=".DB);

    define('METHOD', 'AES-256-CBC', true);
    define('SECRET_KEY', 'S3cr3t', true);
    define('SECRET_IV', '123456', true);
