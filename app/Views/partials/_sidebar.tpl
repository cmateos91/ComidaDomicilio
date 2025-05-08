<!-- app/Views/partials/_sidebar.tpl -->
<div class="left-panel">
  <div class="brand">
    <div class="brand-logo">
      <img src="/favicon.svg" alt="Logo" width="40" height="40" />
    </div>
    <div class="brand-name">ComidaDomicilio</div>
  </div>
  
  <nav class="nav-menu">
    <a href="/dashboard" class="nav-item {if $seccion_activa == 'dashboard'}active{/if}">
      <div class="nav-icon">⌂</div>
      <div class="nav-text">Dashboard</div>
    </a>
    
    <a href="/restaurantes" class="nav-item {if $seccion_activa == 'restaurantes'}active{/if}">
      <div class="nav-icon">🍽️</div>
      <div class="nav-text">Restaurantes</div>
    </a>
    
    <a href="/menus" class="nav-item {if $seccion_activa == 'menus'}active{/if}">
      <div class="nav-icon">📋</div>
      <div class="nav-text">Menu</div>
    </a>
    
    <a href="/pedidos" class="nav-item {if $seccion_activa == 'pedidos'}active{/if}">
      <div class="nav-icon">👤</div>
      <div class="nav-text">Pedidos</div>
    </a>
    
    <a href="/clientes" class="nav-item {if $seccion_activa == 'clientes'}active{/if}">
      <div class="nav-icon">👥</div>
      <div class="nav-text">Clientes</div>
    </a>
    
    <a href="/facturacion" class="nav-item {if $seccion_activa == 'facturacion'}active{/if}">
      <div class="nav-icon">💰</div>
      <div class="nav-text">Facturación</div>
    </a>
    
    <a href="/configuracion" class="nav-item {if $seccion_activa == 'configuracion'}active{/if}">
      <div class="nav-icon">⚙️</div>
      <div class="nav-text">Configuración</div>
    </a>
    
    <a href="/logout" class="nav-item">
      <div class="nav-icon">🔒</div>
      <div class="nav-text">Cerrar sesión</div>
    </a>
  </nav>
</div>