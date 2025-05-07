<!-- app/Views/partials/_header.tpl -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>{$titulo} - {$nombre}</title>
  <link rel="stylesheet" href="/assets/css/estilos.css" />
  <link rel="stylesheet" href="/assets/css/botones.css" />
  <link rel="icon" href="/favicon.png" type="image/png" />
  <link rel="stylesheet" href="/assets/css/dashboard.css" />
  {if isset($css_adicional)}
    {foreach $css_adicional as $css}
      <link rel="stylesheet" href="/assets/css/{$css}" />
    {/foreach}
  {/if}
</head>