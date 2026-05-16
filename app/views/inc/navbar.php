<div class="navBar">
    <div class="navbar-left">
        <i class="ri-menu-line" id="btn-menu" title="Alternar menú"></i>
        <span class="navbar-page-title"><?php echo APP_NAME; ?></span>
    </div>
    <div class="navbar-right">
        <div class="navbar-user">
            <?php
                if(is_file("./app/views/fotos/".$_SESSION['foto'])){
                    echo '<img class="navbar-user-img" src="'.APP_URL.'app/views/fotos/'.$_SESSION['foto'].'" alt="foto">';
                }else{
                    echo '<img class="navbar-user-img" src="'.APP_URL.'app/views/fotos/default.svg" alt="foto">';
                }
            ?>
            <span class="navbar-user-name"><?php echo $_SESSION['usuario']; ?></span>
        </div>
        <a class="navbar-logout" href="<?php echo APP_URL."logOut/"; ?>">
            <i class="ri-logout-circle-r-line"></i>
            <span>Salir</span>
        </a>
    </div>
</div>
