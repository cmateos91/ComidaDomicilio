<!-- app/Views/cliente/dashboard/index.tpl -->
{extends file="../../layouts/cliente.tpl"}
{block name="contenido"}
<div class="welcome-banner">
  <h2>¡Bienvenido, {$nombre}!</h2>
  <p>¿Qué te apetece comer hoy?</p>
  
  <div class="search-container">
    <form action="/cliente/buscar" method="GET">
      <input type="text" name="q" placeholder="Buscar restaurantes, comida..." />
      <button type="submit" class="btn-primary">Buscar</button>
    </form>
  </div>
</div>

<!-- Restaurantes populares -->
<div class="section">
  <div class="section-header">
    <h3>Restaurantes recomendados</h3>
    <a href="/cliente/restaurantes" class="ver-mas">Ver todos</a>
  </div>
  
  <div class="restaurant-slider">
    {foreach $restaurantesPopulares as $restaurante}
      <div class="restaurant-card-small">
        <div class="restaurant-image">
          {if $restaurante->getImagen()}
            <img src="{$restaurante->getImagen()}" alt="{$restaurante->getNombre()}">
          {else}
            <div class="restaurant-image-placeholder">
              <span>{$restaurante->getNombre()|substr:0:1|upper}</span>
            </div>
          {/if}
        </div>
        <h4>{$restaurante->getNombre()}</h4>
        <a href="/cliente/restaurante/{$restaurante->getId()}" class="btn-action">Ver menú</a>
      </div>
    {/foreach}
  </div>
</div>

<!-- Pedidos recientes -->
<div class="section">
  <div class="section-header">
    <h3>Tus pedidos recientes</h3>
    <a href="/cliente/pedidos" class="ver-mas">Ver historial</a>
  </div>
  
  {if empty($pedidosRecientes)}
    <div class="empty-state small">
      <p>Aún no has realizado ningún pedido</p>
      <a href="/cliente/restaurantes" class="btn-primary">Explorar restaurantes</a>
    </div>
  {else}
    <div class="recent-orders">
      {foreach $pedidosRecientes as $pedido}
        <div class="order-card">
          <div class="order-header">
            <h4>Pedido #{$pedido->getId()}</h4>
            <span class="order-date">{$pedido->getFechaPedido()|date_format:"%d/%m/%Y"}</span>
          </div>
          <div class="order-restaurant">{$pedido->getRestaurante()->getNombre()}</div>
          <div class="order-status status-{$pedido->getEstado()}">{$pedido->getEstado()}</div>
          <div class="order-total">{$pedido->getTotal()}€</div>
          <a href="/cliente/pedido/{$pedido->getId()}" class="btn-action">Ver detalles</a>
        </div>
      {/foreach}
    </div>
  {/if}
</div>

<!-- Categorías populares -->
<div class="section">
  <div class="section-header">
    <h3>Explora por categorías</h3>
  </div>
  
  <div class="categories-grid">
    <a href="/cliente/categoria/pizza" class="category-card">
      <div class="category-icon">🍕</div>
      <div class="category-name">Pizza</div>
    </a>
    <a href="/cliente/categoria/hamburguesa" class="category-card">
      <div class="category-icon">🍔</div>
      <div class="category-name">Hamburguesas</div>
    </a>
    <a href="/cliente/categoria/sushi" class="category-card">
      <div class="category-icon">🍣</div>
      <div class="category-name">Sushi</div>
    </a>
    <a href="/cliente/categoria/pasta" class="category-card">
      <div class="category-icon">🍝</div>
      <div class="category-name">Pasta</div>
    </a>
    <a href="/cliente/categoria/postres" class="category-card">
      <div class="category-icon">🍰</div>
      <div class="category-name">Postres</div>
    </a>
    <a href="/cliente/categoria/bebidas" class="category-card">
      <div class="category-icon">🥤</div>
      <div class="category-name">Bebidas</div>
    </a>
  </div>
</div>
{/block}