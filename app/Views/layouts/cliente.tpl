<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{$titulo|default:'ComidaDomicilio'}</title>
  <link rel="stylesheet" href="/assets/css/estilos.css">
  <link rel="stylesheet" href="/assets/css/cliente.css">
  <link rel="stylesheet" href="/assets/css/cliente-fix.css">
  {if isset($css_adicional)}
    {foreach $css_adicional as $css}
      <link rel="stylesheet" href="/assets/css/{$css}">
    {/foreach}
  {/if}
  <link rel="icon" type="image/svg+xml" href="/favicon.svg">
  <link rel="shortcut icon" href="/favicon.ico">
</head>
<body>
  <header class="top-header">
    <div class="container">
      <div class="header-content">
        <div class="logo">
          <a href="/cliente/dashboard">
            <span class="icon">🍔</span> ComidaDomicilio
          </a>
        </div>
        <nav class="main-nav">
          <ul>
            <li><a href="/cliente/dashboard" class="{if $seccion_activa == 'inicio'}active{/if}">Inicio</a></li>
            <li><a href="/cliente/restaurantes" class="{if $seccion_activa == 'restaurantes'}active{/if}">Restaurantes</a></li>
            <li><a href="/cliente/pedidos" class="{if $seccion_activa == 'pedidos'}active{/if}">Mis Pedidos</a></li>
            <li><a href="/cliente/perfil" class="{if $seccion_activa == 'perfil'}active{/if}">Mi Perfil</a></li>
            <li>
              <a href="/cliente/carrito" class="carrito-icon">
                <span class="icon">🛒</span>
                <span class="count">0</span>
              </a>
            </li>
          </ul>
        </nav>
        <div class="user-info">
          <span>Hola, {$nombre|default:'Usuario'}</span>
          <span class="dropdown-arrow">▼</span>
          <div class="dropdown-menu">
            <a href="/cliente/perfil">Mi Perfil</a>
            <a href="/cliente/pedidos">Mis Pedidos</a>
            <a href="/logout">Cerrar Sesión</a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main class="main-content">
    <div class="container">
      {block name="contenido"}{/block}
    </div>
  </main>

  <footer class="main-footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-info">
          <h3>ComidaDomicilio</h3>
          <p>Tu plataforma de entrega de comida favorita</p>
        </div>
        <div class="footer-links">
          <h3>Enlaces útiles</h3>
          <ul>
            <li><a href="/cliente/restaurantes">Restaurantes</a></li>
            <li><a href="/cliente/pedidos">Mis Pedidos</a></li>
            <li><a href="/cliente/perfil">Mi Perfil</a></li>
          </ul>
        </div>
        <div class="footer-contact">
          <h3>Contacto</h3>
          <p>Email: info@comidadomicilio.com</p>
          <p>Teléfono: +34 600 123 456</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© {$smarty.now|date_format:"%Y"} ComidaDomicilio. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>

  <script src="/assets/js/cliente.js"></script>
  {if isset($js_adicional)}
    {foreach $js_adicional as $js}
      <script src="/assets/js/{$js}"></script>
    {/foreach}
  {/if}
</body>
</html>
