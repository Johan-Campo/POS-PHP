<section class="navLateral scroll" id="navLateral">

    <a href="<?php echo APP_URL; ?>dashboard/" class="sidebar-brand">
        <img src="<?php echo APP_URL; ?>app/views/img/logo.svg" width="36" height="36" alt="Logo" style="border-radius:9px;flex-shrink:0;">
        <span class="sidebar-brand-name"><?php echo APP_NAME; ?></span>
    </a>

    <div class="sidebar-profile">
        <?php
            $sidebar_foto = isset($_SESSION['foto']) ? $_SESSION['foto'] : '';
            if(is_file("./app/views/fotos/".$sidebar_foto)){
                echo '<img class="sidebar-profile-img" src="'.APP_URL.'app/views/fotos/'.$sidebar_foto.'" alt="foto">';
            }else{
                echo '<img class="sidebar-profile-img" src="'.APP_URL.'app/views/fotos/default.svg" alt="foto">';
            }
        ?>
        <div class="sidebar-profile-info">
            <div class="sidebar-profile-name"><?php echo htmlspecialchars((isset($_SESSION['nombre'])?$_SESSION['nombre']:'')." ".(isset($_SESSION['apellido'])?$_SESSION['apellido']:'')); ?></div>
            <div class="sidebar-profile-user"><?php echo htmlspecialchars(isset($_SESSION['usuario'])?$_SESSION['usuario']:'Usuario'); ?></div>
        </div>
    </div>

    <nav>
        <div class="sidebar-section-title">Principal</div>
        <ul class="menu-principal list-unstyle">

            <li>
                <a href="<?php echo APP_URL; ?>dashboard/">
                    <i class="ri-dashboard-line menu-icon"></i>
                    <span>Inicio</span>
                </a>
            </li>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-title">Gestión</div>

            <li>
                <a href="#" class="btn-subMenu">
                    <i class="ri-bank-card-line menu-icon"></i>
                    <span>Cajas</span>
                    <i class="ri-arrow-down-s-line menu-arrow"></i>
                </a>
                <ul class="menu-principal sub-menu-options list-unstyle">
                    <li>
                        <a href="<?php echo APP_URL; ?>cashierNew/">
                            <i class="ri-add-circle-line menu-icon"></i> Nueva caja
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>cashierList/">
                            <i class="ri-list-check menu-icon"></i> Lista de cajas
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>cashierSearch/">
                            <i class="ri-search-line menu-icon"></i> Buscar caja
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" class="btn-subMenu">
                    <i class="ri-team-line menu-icon"></i>
                    <span>Usuarios</span>
                    <i class="ri-arrow-down-s-line menu-arrow"></i>
                </a>
                <ul class="menu-principal sub-menu-options list-unstyle">
                    <li>
                        <a href="<?php echo APP_URL; ?>userNew/">
                            <i class="ri-user-add-line menu-icon"></i> Nuevo usuario
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>userList/">
                            <i class="ri-list-check menu-icon"></i> Lista de usuarios
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>userSearch/">
                            <i class="ri-search-line menu-icon"></i> Buscar usuario
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" class="btn-subMenu">
                    <i class="ri-contacts-line menu-icon"></i>
                    <span>Clientes</span>
                    <i class="ri-arrow-down-s-line menu-arrow"></i>
                </a>
                <ul class="menu-principal sub-menu-options list-unstyle">
                    <li>
                        <a href="<?php echo APP_URL; ?>clientNew/">
                            <i class="ri-user-add-line menu-icon"></i> Nuevo cliente
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>clientList/">
                            <i class="ri-list-check menu-icon"></i> Lista de clientes
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>clientSearch/">
                            <i class="ri-search-line menu-icon"></i> Buscar cliente
                        </a>
                    </li>
                </ul>
            </li>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-title">Inventario</div>

            <li>
                <a href="#" class="btn-subMenu">
                    <i class="ri-price-tag-3-line menu-icon"></i>
                    <span>Categorías</span>
                    <i class="ri-arrow-down-s-line menu-arrow"></i>
                </a>
                <ul class="menu-principal sub-menu-options list-unstyle">
                    <li>
                        <a href="<?php echo APP_URL; ?>categoryNew/">
                            <i class="ri-add-circle-line menu-icon"></i> Nueva categoría
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>categoryList/">
                            <i class="ri-list-check menu-icon"></i> Lista de categorías
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>categorySearch/">
                            <i class="ri-search-line menu-icon"></i> Buscar categoría
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" class="btn-subMenu">
                    <i class="ri-box-3-line menu-icon"></i>
                    <span>Productos</span>
                    <i class="ri-arrow-down-s-line menu-arrow"></i>
                </a>
                <ul class="menu-principal sub-menu-options list-unstyle">
                    <li>
                        <a href="<?php echo APP_URL; ?>productNew/">
                            <i class="ri-add-circle-line menu-icon"></i> Nuevo producto
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>productList/">
                            <i class="ri-list-check menu-icon"></i> Lista de productos
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>productCategory/">
                            <i class="ri-inbox-line menu-icon"></i> Por categoría
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>productSearch/">
                            <i class="ri-search-line menu-icon"></i> Buscar producto
                        </a>
                    </li>
                </ul>
            </li>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-title">Ventas</div>

            <li>
                <a href="#" class="btn-subMenu">
                    <i class="ri-shopping-cart-line menu-icon"></i>
                    <span>Ventas</span>
                    <i class="ri-arrow-down-s-line menu-arrow"></i>
                </a>
                <ul class="menu-principal sub-menu-options list-unstyle">
                    <li>
                        <a href="<?php echo APP_URL; ?>saleNew/">
                            <i class="ri-shopping-cart-2-line menu-icon"></i> Nueva venta
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>saleList/">
                            <i class="ri-list-check menu-icon"></i> Lista de ventas
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL; ?>saleSearch/">
                            <i class="ri-search-line menu-icon"></i> Buscar venta
                        </a>
                    </li>
                </ul>
            </li>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-title">Cuenta</div>

            <li>
                <a href="#" class="btn-subMenu">
                    <i class="ri-settings-3-line menu-icon"></i>
                    <span>Configuración</span>
                    <i class="ri-arrow-down-s-line menu-arrow"></i>
                </a>
                <ul class="menu-principal sub-menu-options list-unstyle">
                    <li>
                        <a href="<?php echo APP_URL; ?>companyNew/">
                            <i class="ri-building-2-line menu-icon"></i> Datos de empresa
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL."userUpdate/".(isset($_SESSION['id'])?$_SESSION['id']:0)."/"; ?>">
                            <i class="ri-user-settings-line menu-icon"></i> Mi cuenta
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo APP_URL."userPhoto/".(isset($_SESSION['id'])?$_SESSION['id']:0)."/"; ?>">
                            <i class="ri-camera-line menu-icon"></i> Mi foto
                        </a>
                    </li>
                </ul>
            </li>

            <div class="sidebar-divider"></div>

            <li>
                <a href="<?php echo APP_URL."logOut/"; ?>" class="btn-exit">
                    <i class="ri-logout-circle-r-line menu-icon"></i>
                    <span>Cerrar sesión</span>
                </a>
            </li>

        </ul>
    </nav>

</section>
