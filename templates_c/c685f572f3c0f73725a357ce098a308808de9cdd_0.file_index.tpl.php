<?php
/* Smarty version 5.5.0, created on 2025-05-08 14:08:11
  from 'file:configuracion/index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_681c9eab51ff82_68318831',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c685f572f3c0f73725a357ce098a308808de9cdd' => 
    array (
      0 => 'configuracion/index.tpl',
      1 => 1746703050,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_681c9eab51ff82_68318831 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\configuracion';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_431355239681c9eab51e468_10057682', "contenido");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "../layouts/dashboard.tpl", $_smarty_current_dir);
}
/* {block "contenido"} */
class Block_431355239681c9eab51e468_10057682 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\configuracion';
?>

<!-- Content for Configuracion section -->
<div class="content-container">
  <p>Contenido de la sección de configuración</p>
</div>
<?php
}
}
/* {/block "contenido"} */
}
