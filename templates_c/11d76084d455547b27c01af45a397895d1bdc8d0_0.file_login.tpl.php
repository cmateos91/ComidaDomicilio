<?php
/* Smarty version 5.5.0, created on 2025-05-07 12:48:28
  from 'file:auth/login.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_681b3a7ccac3b3_25391489',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '11d76084d455547b27c01af45a397895d1bdc8d0' => 
    array (
      0 => 'auth/login.tpl',
      1 => 1746614906,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_681b3a7ccac3b3_25391489 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\auth';
?><!DOCTYPE html>
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
      <div id="loginError" class="modal-msg"><?php echo $_smarty_tpl->getValue('error');?>
</div>
    </form>
  </div>

  <?php echo '<script'; ?>
 src="assets/js/login.js"><?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
