<div class="navBar">
    <div class="navbar-left">
        <i class="ri-menu-line" id="btn-menu" title="Alternar menú"></i>
        <span class="navbar-page-title"><?php echo APP_NAME; ?></span>
    </div>
    <div class="navbar-right">
        <div class="navbar-user">
            <?php
                $user_foto = isset($_SESSION['foto']) ? $_SESSION['foto'] : '';
                $user_name = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Usuario';
                if(is_file("./app/views/fotos/".$user_foto)){
                    echo '<img class="navbar-user-img" src="'.APP_URL.'app/views/fotos/'.$user_foto.'" alt="foto">';
                }else{
                    echo '<img class="navbar-user-img" src="'.APP_URL.'app/views/fotos/default.svg" alt="foto">';
                }
            ?>
            <span class="navbar-user-name"><?php echo htmlspecialchars($user_name); ?></span>
        </div>
        <a class="navbar-logout" href="<?php echo APP_URL."logOut/"; ?>">
            <i class="ri-logout-circle-r-line"></i>
            <span>Salir</span>
        </a>
    </div>
</div>
