<!-- app/Views/restaurantes/index.tpl -->
{extends file="../layouts/dashboard.tpl"}
{block name="contenido"}
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
{/block}