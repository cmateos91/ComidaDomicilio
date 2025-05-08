{extends file="../../layouts/cliente.tpl"}

{block name="contenido"}
<h2 class="section-title">Restaurantes</h2>

{if empty($restaurantes)}
  <div class="empty-orders">
    <p>No hay restaurantes disponibles en este momento</p>
  </div>
{else}
  <div class="restaurants-grid">
    {foreach $restaurantes as $restaurante}
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
          {if isset($restaurante.direccion) && $restaurante.direccion}
            <p class="restaurant-address">{$restaurante.direccion}</p>
          {/if}
        </div>
        <a href="/cliente/restaurante/{$restaurante.id}" class="btn-ver-menu">Ver menú</a>
      </div>
    {/foreach}
  </div>
{/if}
{/block}