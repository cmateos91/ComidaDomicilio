<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Restaurantes - {$nombre}</title>
  <link rel="stylesheet" href="/assets/css/estilos.css" />
  <link rel="stylesheet" href="/assets/css/botones.css" />
  <link rel="icon" href="/favicon.png" type="image/png" />
  <link rel="stylesheet" href="/assets/css/dashboard.css" />
  <link rel="stylesheet" href="/assets/css/restaurantes.css" />
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
        
        <a href="/restaurantes" class="nav-item active">
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
        <h1 class="dashboard-title">Restaurantes</h1>
        <form method="GET" action="/logout">
          <button class="btn-ani" type="submit"><span>Cerrar sesión</span></button>
        </form>
      </div>
      
      <!-- Content for Restaurantes section -->
      <div class="content-container">
        <div class="section-header">
          <h2>Mis Restaurantes</h2>
          <button class="btn-primary">+ Añadir Restaurante</button>
        </div>
        
        {if empty($restaurantes)}
          <div class="empty-state">
            <div class="empty-icon">🍽️</div>
            <h3>No tienes restaurantes registrados</h3>
            <p>Comienza añadiendo tu primer restaurante para gestionarlo</p>
            <button class="btn-primary">Añadir mi primer restaurante</button>
          </div>
        {else}
          <div class="restaurant-grid">
            {foreach $restaurantes as $restaurante}
              <div class="restaurant-card">
                <div class="restaurant-header">
                  {if $restaurante->getImagen()}
                    <img src="{$restaurante->getImagen()}" alt="{$restaurante->getNombre()}" class="restaurant-image">
                  {else}
                    <div class="restaurant-image-placeholder">
                      <span>{$restaurante->getNombre()|substr:0:1|upper}</span>
                    </div>
                  {/if}
                  <h3 class="restaurant-name">{$restaurante->getNombre()}</h3>
                </div>
                <div class="restaurant-info">
                  <p><strong>Dirección:</strong> {$restaurante->getDireccion()}</p>
                  {if $restaurante->getTelefono()}
                    <p><strong>Teléfono:</strong> {$restaurante->getTelefono()}</p>
                  {/if}
                  {if $restaurante->getEmail()}
                    <p><strong>Email:</strong> {$restaurante->getEmail()}</p>
                  {/if}
                </div>
                <div class="restaurant-status">
                  <span class="status-badge {if $restaurante->isActivo()}status-active{else}status-inactive{/if}">
                    {if $restaurante->isActivo()}Activo{else}Inactivo{/if}
                  </span>
                </div>
                <div class="restaurant-actions">
                  <a href="/restaurante/{$restaurante->getId()}" class="btn-action">Ver detalles</a>
                  <a href="/restaurante/{$restaurante->getId()}/editar" class="btn-action">Editar</a>
                  <a href="/restaurante/{$restaurante->getId()}/menu" class="btn-action">Gestionar menú</a>
                </div>
              </div>
            {/foreach}
          </div>
        {/if}
      </div>
    </div>
  </div>
</body>
</html>