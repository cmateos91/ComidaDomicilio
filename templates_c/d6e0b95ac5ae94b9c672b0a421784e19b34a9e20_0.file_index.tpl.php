<?php
/* Smarty version 5.5.0, created on 2025-05-08 01:06:54
  from 'file:clientes/index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_681be78ead3a33_76108600',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd6e0b95ac5ae94b9c672b0a421784e19b34a9e20' => 
    array (
      0 => 'clientes/index.tpl',
      1 => 1746658725,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_681be78ead3a33_76108600 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\clientes';
?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Clientes - <?php echo $_smarty_tpl->getValue('nombre');?>
</title>
  <link rel="stylesheet" href="/assets/css/estilos.css" />
  <link rel="stylesheet" href="/assets/css/botones.css" />
  <link rel="icon" href="/favicon.png" type="image/png" />
  <link rel="stylesheet" href="/assets/css/dashboard.css" />
</head>
<body>
  <div class="dashboard-container">
    <!-- Left Navigation Panel -->
    <div class="left-panel">
      <div class="brand">
        <div class="brand-logo">
          <img src="/favicon.svg" alt="Logo" width="40" height="40" />
        </div>
        <div class="brand-name">ComidaDomicilio</div>
      </div>
      
      <nav class="nav-menu">
        <a href="/dashboard" class="nav-item">
          <div class="nav-icon">⌂</div>
          <div class="nav-text">Dashboard</div>
        </a>
        
        <a href="/restaurantes" class="nav-item">
          <div class="nav-icon">🍽️</div>
          <div class="nav-text">Restaurantes</div>
        </a>
        
        <a href="/menus" class="nav-item">
          <div class="nav-icon">📋</div>
          <div class="nav-text">Menús</div>
        </a>
        
        <a href="/pedidos" class="nav-item">
          <div class="nav-icon">👤</div>
          <div class="nav-text">Pedidos</div>
        </a>
        
        <a href="/clientes" class="nav-item active">
          <div class="nav-icon">👥</div>
          <div class="nav-text">Clientes</div>
        </a>
        
        <a href="/facturacion" class="nav-item">
          <div class="nav-icon">💰</div>
          <div class="nav-text">Facturación</div>
        </a>
        
        <a href="/configuracion" class="nav-item">
          <div class="nav-icon">⚙️</div>
          <div class="nav-text">Configuración</div>
        </a>
        
        <a href="/logout" class="nav-item">
          <div class="nav-icon">🔒</div>
          <div class="nav-text">Cerrar sesión</div>
        </a>
      </nav>
    </div>
    
    <!-- Main Content -->
    <div class="dashboard-content">
      <div class="dashboard-header">
        <h1 class="dashboard-title">Clientes</h1>
        <form method="GET" action="/logout">
          <button class="btn-ani" type="submit"><span>Cerrar sesión</span></button>
        </form>
      </div>
      
      <!-- Content for Clientes section -->
      <div class="content-container">
        <p>Contenido de la sección de clientes</p>
      </div>
    </div>
  </div>
</body>
</html><?php }
}
