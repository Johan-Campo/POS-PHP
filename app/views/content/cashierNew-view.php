<div class="content-wrapper">

<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-breadcrumb"><i class="ri-home-4-line"></i> Cajas</div>
        <div class="page-header-title">
            <div class="page-header-icon"><i class="ri-add-circle-line"></i></div>
            Nueva caja
        </div>
    </div>
</div>
<div>

	<form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/cajaAjax.php" method="POST" autocomplete="off" >

		<input type="hidden" name="modulo_caja" value="registrar">

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Numero de caja <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="caja_numero" pattern="[0-9]{1,5}" maxlength="5" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre o código de caja <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="caja_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ:# ]{3,70}" maxlength="70" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Efectivo en caja <?php echo CAMPO_OBLIGATORIO; ?></label>
				  	<input class="input" type="text" name="caja_efectivo" pattern="[0-9.]{1,25}" maxlength="25" value="0.00" required >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="reset" class="button is-link is-light is-rounded"><i class="ri-eraser-line"></i> &nbsp; Limpiar</button>
			<button type="submit" class="button is-info is-rounded"><i class="ri-save-line"></i> &nbsp; Guardar</button>
		</p>
		<p class="has-text-centered pt-6">
            <small>Los campos marcados con <?php echo CAMPO_OBLIGATORIO; ?> son obligatorios</small>
        </p>
	</form>
</div>
</div>