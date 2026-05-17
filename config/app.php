<?php

	define('APP_URL', $_ENV['APP_URL'] ?? 'http://localhost/');
	const APP_NAME="MiniVend";
	const APP_SESSION_NAME="MINIVEND";

	const DOCUMENTOS_USUARIOS=["DUI","DNI","Cedula","Licencia","Pasaporte","Otro"];

	const PRODUCTO_UNIDAD=["Unidad","Libra","Kilogramo","Caja","Paquete","Lata","Galon","Botella","Tira","Sobre","Bolsa","Saco","Tarjeta","Otro"];

	const MONEDA_SIMBOLO="$";
	const MONEDA_NOMBRE="USD";
	const MONEDA_DECIMALES="2";
	const MONEDA_SEPARADOR_MILLAR=",";
	const MONEDA_SEPARADOR_DECIMAL=".";

	const CAMPO_OBLIGATORIO='&nbsp; <i class="ri-edit-line"></i> &nbsp;';

	date_default_timezone_set("America/El_Salvador");
