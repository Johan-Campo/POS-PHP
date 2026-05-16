<div class="content-wrapper">

<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-breadcrumb"><i class="ri-home-4-line"></i> Ventas</div>
        <div class="page-header-title">
            <div class="page-header-icon"><i class="ri-search-line"></i></div>
            Buscar venta
        </div>
    </div>
</div>
<div>
    <?php
    
        use app\controllers\saleController;
        $insVenta = new saleController();

        if(!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])){
    ?>
    <div class="columns">
        <div class="column">
            <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="buscar">
                <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="Código de venta" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\- ]{1,30}" maxlength="30" required >
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit" >Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php }else{ ?>
    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6 FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="eliminar">
                <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                <p><i class="ri-search-line"></i> &nbsp; Estas buscando por código <strong>“<?php echo $_SESSION[$url[0]]; ?>”</strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded"><i class="ri-delete-back-line"></i> &nbsp; Eliminar busqueda</button>
            </form>
        </div>
    </div>
    <?php
            echo $insVenta->listarVentaControlador($url[1],15,$url[0],$_SESSION[$url[0]]);

            include "./app/views/inc/print_invoice_script.php";
        }
    ?>
</div>
</div>