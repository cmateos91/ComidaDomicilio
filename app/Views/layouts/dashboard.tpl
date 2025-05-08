<!-- app/Views/layouts/dashboard.tpl -->
{include file="../partials/_header.tpl"}
<body>
  <div class="dashboard-container">
    <!-- Left Navigation Panel -->
    {include file="../partials/_sidebar.tpl"}
    
    <!-- Main Content -->
    <div class="dashboard-content">
      <div class="dashboard-header">
        <h1 class="dashboard-title">{$titulo}</h1>
        <form method="GET" action="/logout">
          <button class="btn-ani" type="submit"><span>Cerrar sesión</span></button>
        </form>
      </div>
      
      <!-- Content for specific section - Aseguramos ancho completo -->
      <div class="content-container" style="width: 100%; max-width: 100%;">
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