<?php

	const DB_SERVER = $_ENV['DB_SERVER'] ?? 'localhost';
	const DB_PORT   = $_ENV['DB_PORT']   ?? '3306';
	const DB_NAME   = $_ENV['DB_NAME']   ?? 'dbminivend';
	const DB_USER   = $_ENV['DB_USER']   ?? 'root';
	const DB_PASS   = $_ENV['DB_PASS']   ?? '';