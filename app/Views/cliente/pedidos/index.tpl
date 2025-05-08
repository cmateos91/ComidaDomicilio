{extends file="../../layouts/cliente.tpl"}

{block name="contenido"}
<h2 class="section-title">Mis Pedidos</h2>

{if empty($pedidos)}
  <div class="empty-orders">
    <p>No tienes pedidos aún</p>
    <a href="/cliente/restaurantes" class="btn-primary">Explorar restaurantes</a>
  </div>
{else}
  <div class="orders-list">
    {foreach $pedidos as $pedido}
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
{/block}