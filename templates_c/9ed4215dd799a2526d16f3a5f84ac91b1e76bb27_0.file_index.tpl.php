<?php
/* Smarty version 5.5.0, created on 2025-05-08 00:56:57
  from 'file:dashboard/index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_681be539620054_74978134',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9ed4215dd799a2526d16f3a5f84ac91b1e76bb27' => 
    array (
      0 => 'dashboard/index.tpl',
      1 => 1746658614,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_681be539620054_74978134 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\dashboard';
?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Panel - <?php echo $_smarty_tpl->getValue('nombre');?>
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
        <a href="/dashboard" class="nav-item active">
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
        
        <a href="/clientes" class="nav-item">
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
        <h1 class="dashboard-title">Dastaplan</h1>
        <form method="GET" action="/logout">
          <button class="btn-ani" type="submit"><span>Cerrar sesión</span></button>
        </form>
      </div>
      
      <!-- Metrics Cards -->
      <div class="metrics-container">
        <div class="metric-card">
          <div class="metric-icon" style="color: #4285f4;">🛒</div>
          <div>
            <p class="metric-label">Pedidos de hoy</p>
            <p class="metric-value">12</p>
          </div>
        </div>
        
        <div class="metric-card">
          <div class="metric-icon" style="color: #4285f4;">€</div>
          <div>
            <p class="metric-label">Ingresos del día</p>
            <p class="metric-value">450 €</p>
          </div>
        </div>
        
        <div class="metric-card">
          <div class="metric-icon" style="color: #4285f4;">⏱️</div>
          <div>
            <p class="metric-label">Pedidos pendientes</p>
            <p class="metric-value"></p>
          </div>
        </div>
        
        <div class="metric-card">
          <div class="metric-icon" style="color: #ffc107;">4,8</div>
          <div>
            <p class="metric-label">Valoración promedio</p>
            <p class="metric-value"></p>
          </div>
        </div>
      </div>
      
      <!-- Layout with main content and sidebar -->
      <div class="layout-container">
        <div class="main-content">
          <!-- Charts -->
          <div class="charts-container">
            <div class="chart-card">
              <h3 class="chart-title">Pedidos por día</h3>
              <div class="chart">
                <div class="bar" style="height: 30%;"></div>
                <div class="bar" style="height: 40%;"></div>
                <div class="bar" style="height: 50%;"></div>
                <div class="bar" style="height: 60%;"></div>
                <div class="bar" style="height: 70%;"></div>
                <div class="bar" style="height: 85%;"></div>
                <div class="bar" style="height: 100%;"></div>
              </div>
            </div>
            
            <div class="chart-card">
              <h3 class="chart-title">Categorías más vendidas</h3>
              <div class="pie-charts">
                <div class="pie-chart-small"></div>
                <div class="pie-chart"></div>
              </div>
            </div>
          </div>
          
          <!-- Orders Table -->
          <div class="orders-table">
            <h3 class="orders-title">Últimos pedidos</h3>
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Cliente</th>
                  <th>Total</th>
                  <th>Estado</th>
                  <th>Hora</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1001</td>
                  <td>Ana García</td>
                  <td>€25,00</td>
                  <td><span class="status status-completed">Completado</span></td>
                  <td>11:30</td>
                  <td><a href="#" class="action-link">Ver</a></td>
                </tr>
                <tr>
                  <td>1002</td>
                  <td>Pedro López</td>
                  <td>€25,00</td>
                  <td><span class="status status-pending">Pendiente</span></td>
                  <td>10:45</td>
                  <td><a href="#" class="action-link">Ver</a></td>
                </tr>
                <tr>
                  <td>1003</td>
                  <td>María Sánchez</td>
                  <td>€25,00</td>
                  <td><span class="status status-progress">En progreso</span></td>
                  <td>10:45</td>
                  <td><a href="#" class="action-link">Ver</a></td>
                </tr>
                <tr>
                  <td>1004</td>
                  <td>David Martín</td>
                  <td>€13,00</td>
                  <td><span class="status status-action">Accion</span></td>
                  <td>09:20</td>
                  <td><a href="#" class="action-link">Ver</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="sidebar">
          <!-- Menu options -->
          <div class="sidebar-menu">
            <a href="#" class="menu-button">
              <span class="menu-icon">📋</span>
              Ver todos los pedidos
            </a>
            <a href="#" class="menu-button">
              <span class="menu-icon">🍔</span>
              Gestionar menú
            </a>
            <a href="#" class="menu-button">
              <span class="menu-icon">🕒</span>
              Cambiar horario
            </a>
            <a href="#" class="menu-button">
              <span class="menu-icon">👤</span>
              Editar perfil restaurante
            </a>
          </div>
        </div>
      </div>
      
      <!-- Keep welcome message but make it less prominent -->
      <div style="margin-top: 20px; text-align: center; color: #666;">
        <p>¡Bienvenido, <?php echo $_smarty_tpl->getValue('nombre');?>
!</p>
      </div>
    </div>
  </div>
</body>
</html><?php }
}
