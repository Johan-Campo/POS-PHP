<div class="content-wrapper">

<div class="page-header">
    <div class="page-header-left">
        <div class="page-header-breadcrumb"><i class="ri-home-4-line"></i> Productos</div>
        <div class="page-header-title">
            <div class="page-header-icon"><i class="ri-inbox-line"></i></div>
            Productos por categoría
        </div>
    </div>
</div>
<div>
    <?php
        use app\controllers\productController;
        $insProducto = new productController();
    ?>
    <div class="columns">



        <div class="column is-one-third">
            <h2 class="title has-text-centered">Categorías</h2>
            <?php

                $datos_categorias=$insProducto->seleccionarDatos("Normal","categoria","*",0);

                if($datos_categorias->rowCount()>0){
                    $datos_categorias=$datos_categorias->fetchAll();
                    foreach($datos_categorias as $row){
                        echo '<a href="'.APP_URL.$url[0].'/'.$row['categoria_id'].'/" class="button is-link is-inverted is-fullwidth">'.$row['categoria_nombre'].'</a>';
                    }
                }else{
                    echo '<p class="has-text-centered" >No hay categorías registradas</p>';
                }
            ?>
        </div>



        <div class="column pb-6">
            <?php
                $categoria_id=(isset($url[1])) ? $url[1] : 0;

                $categoria=$insProducto->seleccionarDatos("Unico","categoria","categoria_id",$categoria_id);
                if($categoria->rowCount()>0){

                    $categoria=$categoria->fetch();

                    echo '
                        <h2 class="title has-text-centered">'.$categoria['categoria_nombre'].'</h2>
                        <p class="has-text-centered pb-6" >'.$categoria['categoria_ubicacion'].'</p>
                    ';

                    echo $insProducto->listarProductoControlador($url[2],10,$url[0],"",$url[1]);
                }else{
                    echo '
                    <p class="has-text-centered pb-6"><i class="ri-emotion-happy-line"></i></p>
                    <h2 class="has-text-centered title" >Seleccione una categoría para empezar</h2>';
                }
            ?>
        </div>

    </div>
</div>
</div>