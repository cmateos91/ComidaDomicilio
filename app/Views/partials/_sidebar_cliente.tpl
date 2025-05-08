<!-- app/Views/partials/_sidebar_cliente.tpl -->
<div class="left-panel cliente-panel">
  <div class="brand">
    <div class="brand-logo">
      <img src="/favicon.svg" alt="Logo" width="40" height="40" />
    </div>
    <div class="brand-name">ComidaDomicilio</div>
  </div>
  
  <nav class="nav-menu">
    <a href="/cliente/inicio" class="nav-item {if $seccion_activa == 'inicio'}active{/if}">
      <div class="nav-icon">⌂</div>
      <div class="nav-text">Inicio</div>
    </a>
    
    <a href="/cliente/restaurantes" class="nav-item {if $seccion_activa == 'restaurantes'}active{/if}">
      <div class="nav-icon">🍽️</div>
      <div class="nav-text">Restaurantes</div>
    </a>
    
    <a href="/cliente/pedidos" class="nav-item {if $seccion_activa == 'pedidos'}active{/if}">
      <div class="nav-icon">📦</div>
      <div class="nav-text">Mis Pedidos</div>
    </a>
    
    <a href="/cliente/favoritos" class="nav-item {if $seccion_activa == 'favoritos'}active{/if}">
      <div class="nav-icon">⭐</div>
      <div class="nav-text">Favoritos</div>
    </a>
    
    <a href="/cliente/perfil" class="nav-item {if $seccion_activa == 'perfil'}active{/if}">
      <div class="nav-icon">👤</div>
      <div class="nav-text">Mi Perfil</div>
    </a>
    
    <a href="/logout" class="nav-item">
      <div class="nav-icon">🔒</div>
      <div class="nav-text">Cerrar sesión</div>
    </a>
  </nav>
</div>