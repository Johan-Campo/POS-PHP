<?php

	// Configuración de conexión a base de datos Aiven Cloud
	// Usar variables de entorno del servidor, o los valores por defecto de Aiven
	define('DB_SERVER', $_ENV['DB_SERVER'] ?? 'mysql-135c57c5-johancampo12-9d61.c.aivencloud.com');
	define('DB_PORT',   $_ENV['DB_PORT']   ?? '22942');
	define('DB_NAME',   $_ENV['DB_NAME']   ?? 'defaultdb');
	define('DB_USER',   $_ENV['DB_USER']   ?? 'avnadmin');
	define('DB_PASS',   $_ENV['DB_PASS']   ?? '');
