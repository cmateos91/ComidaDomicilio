<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Configuración - {$nombre}</title>
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
        
        <a href="/clientes" class="nav-item">
          <div class="nav-icon">👥</div>
          <div class="nav-text">Clientes</div>
        </a>
        
        <a href="/facturacion" class="nav-item">
          <div class="nav-icon">💰</div>
          <div class="nav-text">Facturación</div>
        </a>
        
        <a href="/configuracion" class="nav-item active">
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
        <h1 class="dashboard-title">Configuración</h1>
        <form method="GET" action="/logout">
          <button class="btn-ani" type="submit"><span>Cerrar sesión</span></button>
        </form>
      </div>
      
      <!-- Content for Configuracion section -->
      <div class="content-container">
        <p>Contenido de la sección de configuración</p>
      </div>
    </div>
  </div>
</body>
</html>