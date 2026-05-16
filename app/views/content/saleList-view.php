<div class="content-wrapper">

<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-breadcrumb"><i class="ri-home-4-line"></i> Ventas</div>
        <div class="page-header-title">
            <div class="page-header-icon"><i class="ri-list-check"></i></div>
            Lista de ventas
        </div>
    </div>
</div>
<div>

	<div class="form-rest mb-6 mt-6"></div>

	<?php
		use app\controllers\saleController;

		$insVenta = new saleController();

		echo $insVenta->listarVentaControlador($url[1],15,$url[0],"");

		include "./app/views/inc/print_invoice_script.php";
	?>
</div>
</div>