<?php
/* Smarty version 5.5.0, created on 2025-05-08 13:17:12
  from 'file:facturacion/index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_681c92b868c582_13432722',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8714bf490847c23146774db01f4dabb8653b7c46' => 
    array (
      0 => 'facturacion/index.tpl',
      1 => 1746703021,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_681c92b868c582_13432722 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\facturacion';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_52158450681c92b8689741_81676226', "contenido");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "../layouts/dashboard.tpl", $_smarty_current_dir);
}
/* {block "contenido"} */
class Block_52158450681c92b8689741_81676226 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\facturacion';
?>

<!-- Content for Facturacion section -->
<div class="content-container">
  <p>Contenido de la sección de facturación</p>
</div>
<?php
}
}
/* {/block "contenido"} */
}
