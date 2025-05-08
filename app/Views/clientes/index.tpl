{extends file="../layouts/dashboard.tpl"}
{block name="contenido"}
<!-- Content for Clientes section -->
<div class="content-container">
  <div class="section-header">
    <h2>Clientes</h2>
  </div>
  
  {if empty($clientes)}
    <div class="empty-state">
      <div class="empty-icon">👥</div>
      <h3>No hay clientes registrados</h3>
      <p>Aquí se mostrarán los clientes cuando se registren en el sistema.</p>
    </div>
  {else}
    <div class="clientes-grid">
      {foreach $clientes as $cliente}
        <div class="cliente-card">
          <div class="cliente-header">
            <h3 class="cliente-name">{$cliente->getNombre()} {$cliente->getApellidos()}</h3>
          </div>
          <div class="cliente-info">
            {if $cliente->getEmail()}
              <p><strong>Email:</strong> <span>📧</span> {$cliente->getEmail()}</p>
            {/if}
            {if $cliente->getTelefono()}
              <p><strong>Teléfono:</strong> <span>📞</span> {$cliente->getTelefono()}</p>
            {/if}
            {if $cliente->getDireccion()}
              <p><strong>Dirección:</strong> <span>📍</span> {$cliente->getDireccion()}</p>
            {/if}
          </div>
          <div class="cliente-stats">
            <div class="stat-card">
              <div class="stat-icon">🛒</div>
              <div class="stat-content">
                <p class="stat-label">Pedidos</p>
                <p class="stat-value">{$cliente->getTotalPedidos()}</p>
              </div>
            </div>
          </div>
          <div class="cliente-actions">
            <a href="/cliente/{$cliente->getId()}" class="btn-action">Ver detalles</a>
            <a href="/cliente/{$cliente->getId()}/pedidos" class="btn-action">Ver pedidos</a>
          </div>
        </div>
      {/foreach}
    </div>
  {/if}
</div>
{/block}