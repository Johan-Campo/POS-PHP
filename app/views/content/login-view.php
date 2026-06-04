<div class="main-container">
    <div class="login-card">

        <div class="login-logo">
            <img src="<?php echo APP_URL; ?>app/views/img/logo.svg"
                 width="56" height="56" alt="MiniVend"
                 style="border-radius:14px; box-shadow:0 8px 24px rgba(79,70,229,.45);">
            <div class="login-logo-text">Mini<span>Vend</span></div>
        </div>

        <p class="login-title">Bienvenido de vuelta</p>
        <p class="login-subtitle">Ingresa tus credenciales para continuar</p>

        <div class="login-demo-box">
            <p class="login-demo-title"><i class="ri-information-line"></i> Credenciales de prueba</p>
            <p><span>Usuario:</span> Administrador</p>
            <p><span>Contraseña:</span> Administrador</p>
        </div>

        <?php
            if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
                try {
                    $insLogin->iniciarSesionControlador();
                } catch (Exception $e) {
                    if($e->getMessage() === 'db_connection_error'){ ?>
                    <div class="login-db-error">
                        <div class="login-db-error-icon"><i class="ri-database-2-line"></i></div>
                        <p class="login-db-error-title">Servicio temporalmente no disponible</p>
                        <p class="login-db-error-body">
                            El servidor de base de datos se encuentra en estado de suspensión automática
                            debido a un periodo de inactividad. Este comportamiento es propio del plan
                            gratuito del proveedor de infraestructura.<br><br>
                            Por favor, <strong>espere unos minutos</strong> e intente nuevamente.
                            Si el problema persiste, contacte al administrador del sistema.
                        </p>
                    </div>
                    <?php } else { ?>
                    <article class="message is-danger">
                      <div class="message-body">
                        <strong>Ocurrió un error inesperado</strong><br>
                        Por favor, intente nuevamente o contacte al administrador.
                      </div>
                    </article>
                    <?php }
                }
            }
        ?>

        <form action="" method="POST" autocomplete="off">
            <div class="login-field">
                <label class="login-label">
                    <i class="ri-user-line"></i> Usuario
                </label>
                <input class="login-input" type="text" name="login_usuario"
                       pattern="[a-zA-Z0-9]{4,20}" maxlength="20"
                       placeholder="Tu nombre de usuario" required autofocus>
            </div>

            <div class="login-field">
                <label class="login-label">
                    <i class="ri-lock-line"></i> Contraseña
                </label>
                <div class="login-password-wrapper">
                    <input class="login-input" type="password" name="login_clave" id="login_clave"
                           pattern="[a-zA-Z0-9$@.\-]{7,100}" maxlength="100"
                           placeholder="Tu contraseña" required>
                    <button type="button" class="login-eye-btn" onclick="togglePassword()" title="Mostrar/ocultar contraseña">
                        <i class="ri-eye-line" id="eye-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="login-btn">
                <i class="ri-login-circle-line"></i> &nbsp; Iniciar sesión
            </button>
        </form>

        <script>
        function togglePassword() {
            var input = document.getElementById('login_clave');
            var icon  = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'ri-eye-off-line';
            } else {
                input.type = 'password';
                icon.className = 'ri-eye-line';
            }
        }
        </script>

    </div>
</div>
