<?php

	define('DB_SERVER', $_ENV['DB_SERVER'] ?? 'localhost');
	define('DB_PORT',   $_ENV['DB_PORT']   ?? '3306');
	define('DB_NAME',   $_ENV['DB_NAME']   ?? 'dbminivend');
	define('DB_USER',   $_ENV['DB_USER']   ?? 'root');
	define('DB_PASS',   $_ENV['DB_PASS']   ?? '');