<!-- app/Views/layouts/cliente.tpl -->
{include file="../partials/_header.tpl"}
<body>
  <div class="cliente-container">
    <!-- Left Navigation Panel para clientes -->
    {include file="../partials/_sidebar_cliente.tpl"}
    
    <!-- Main Content -->
    <div class="cliente-content">
      <div class="cliente-header">
        <h1 class="cliente-title">{$titulo}</h1>
        <div class="user-profile">
          <span class="user-name">{$nombre}</span>
          <form method="GET" action="/logout">
            <button class="btn-ani" type="submit"><span>Cerrar sesión</span></button>
          </form>
        </div>
      </div>
      
      <!-- Content for specific section -->
      <div class="content-container">
        {block name="contenido"}
          <!-- El contenido específico de cada vista se insertará aquí -->
        {/block}
      </div>
    </div>
  </div>

  {if isset($js_adicional)}
    {foreach $js_adicional as $js}
      <script src="/assets/js/{$js}"></script>
    {/foreach}
  {/if}
</body>
</html>