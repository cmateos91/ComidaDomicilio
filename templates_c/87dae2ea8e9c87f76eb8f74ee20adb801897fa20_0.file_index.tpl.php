<?php
/* Smarty version 5.5.0, created on 2025-05-08 13:17:17
  from 'file:pedidos/index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_681c92bd254007_32083830',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '87dae2ea8e9c87f76eb8f74ee20adb801897fa20' => 
    array (
      0 => 'pedidos/index.tpl',
      1 => 1746702997,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_681c92bd254007_32083830 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\pedidos';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1883689190681c92bd2528d6_47976092', "contenido");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "../layouts/dashboard.tpl", $_smarty_current_dir);
}
/* {block "contenido"} */
class Block_1883689190681c92bd2528d6_47976092 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\pedidos';
?>

<!-- Content for Pedidos section -->
<div class="content-container">
  <p>Contenido de la sección de pedidos</p>
</div>
<?php
}
}
/* {/block "contenido"} */
}
