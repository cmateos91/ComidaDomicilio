<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="assets/css/estilos.css" />
  <link rel="stylesheet" href="/assets/css/botones.css">
  <link rel="icon" type="image/png" href="favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
  <link rel="manifest" href="/site.webmanifest" />
</head>
<body>
  <div class="login-container">
    <h1 class="main-title">Inicia sesion</h1>
    <form id="loginForm">
      <input type="email" name="email" placeholder="Correo electrónico" required />
      <input type="password" name="password" placeholder="Contraseña" required />
      <button class="btn-ani" type="submit"><span>Entrar</span></button>
      <div id="loginError" class="modal-msg">{$error}</div>
    </form>
  </div>

  <script src="assets/js/login.js"></script>
</body>
</html>
