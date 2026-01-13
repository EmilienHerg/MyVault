<?php

// On récupère les variables d'environnement (Docker) OU on garde les valeur par défaut (Laragon/Local)
define('HOST', getenv('DB_HOST') !== false ? getenv('DB_HOST') : 'localhost');
define('DB_NAME', getenv('DB_NAME') !== false ? getenv('DB_NAME') : 'my_vault');
define('USER', getenv('DB_USER') !== false ? getenv('DB_USER') : 'root');
define('PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
