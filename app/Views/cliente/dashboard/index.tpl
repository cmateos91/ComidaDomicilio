{extends file="../../layouts/cliente.tpl"}
{block name="contenido"}

<div class="restaurants-section">
  <h2 class="section-title">Restaurantes recomendados</h2>
  
  <div class="restaurants-grid">
    {foreach $restaurantesPopulares as $restaurante}
      <div class="restaurant-card">
        <div class="restaurant-image">
          {if isset($restaurante.imagen) && $restaurante.imagen}
            <img src="{$restaurante.imagen}" alt="{$restaurante.nombre}">
          {else}
            <div class="placeholder-img">
              <span>{$restaurante.nombre|substr:0:1|upper}</span>
            </div>
          {/if}
        </div>
        <div class="restaurant-info">
          <h3>{$restaurante.nombre}</h3>
        </div>
        <a href="/cliente/restaurante/{$restaurante.id}" class="btn-ver-menu">Ver menú</a>
      </div>
    {/foreach}
  </div>
</div>

<div class="recent-orders-section">
  <div class="section-header">
    <h2 class="section-title">Tus pedidos recientes</h2>
    <a href="/cliente/pedidos" class="link-ver-historial">Ver historial</a>
  </div>
  
  {if empty($pedidosRecientes)}
    <div class="empty-orders">
      <p>Aún no has realizado ningún pedido</p>
      <a href="/cliente/restaurantes" class="btn-primary">Explorar restaurantes</a>
    </div>
  {else}
    <div class="orders-list">
      {foreach $pedidosRecientes as $pedido}
        <div class="order-item">
          <div class="order-header">
            <div class="order-id">Pedido #{$pedido.id}</div>
            <div class="order-date">{$pedido.fecha|date_format:"%d/%m/%Y"}</div>
          </div>
          <div class="order-details">
            <div class="order-restaurant">Restaurante</div>
            <div class="order-status status-{$pedido.estado}">{$pedido.estado}</div>
            <div class="order-total">{$pedido.total}€</div>
            <a href="/cliente/pedido/{$pedido.id}" class="btn-ver-detalles">Ver detalles</a>
          </div>
        </div>
      {/foreach}
    </div>
  {/if}
</div>
{/block}