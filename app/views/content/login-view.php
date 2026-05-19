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

        <?php
            if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
                try {
                    $insLogin->iniciarSesionControlador();
                } catch (Exception $e) {
                    echo '<article class="message is-danger">
                      <div class="message-body">
                        <strong>Ocurrió un error inesperado</strong><br>
                        '.$e->getMessage().'
                      </div>
                    </article>';
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
                <input class="login-input" type="password" name="login_clave"
                       pattern="[a-zA-Z0-9$@.\-]{7,100}" maxlength="100"
                       placeholder="Tu contraseña" required>
            </div>

            <button type="submit" class="login-btn">
                <i class="ri-login-circle-line"></i> &nbsp; Iniciar sesión
            </button>
        </form>

    </div>
</div>
