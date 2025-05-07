<?php
/* Smarty version 5.5.0, created on 2025-05-08 01:47:44
  from 'file:restaurantes/index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_681bf120851571_24476409',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fa0035e137389a5aab0cd28b9f8d6e2cde2217bb' => 
    array (
      0 => 'restaurantes/index.tpl',
      1 => 1746661662,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_681bf120851571_24476409 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\restaurantes';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>
<!-- app/Views/restaurantes/index.tpl -->

<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_478061374681bf1208453b5_33270999', "contenido");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "../layouts/dashboard.tpl", $_smarty_current_dir);
}
/* {block "contenido"} */
class Block_478061374681bf1208453b5_33270999 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\restaurantes';
?>

<div class="section-header">
  <h2>Mis Restaurantes</h2>
  <button class="btn-primary">+ Añadir Restaurante</button>
</div>

<?php if (( !$_smarty_tpl->hasVariable('restaurantes') || empty($_smarty_tpl->getValue('restaurantes')))) {?>
  <div class="empty-state">
    <div class="empty-icon">🍽️</div>
    <h3>No tienes restaurantes registrados</h3>
    <p>Comienza añadiendo tu primer restaurante para gestionarlo</p>
    <button class="btn-primary">Añadir mi primer restaurante</button>
  </div>
<?php } else { ?>
  <div class="restaurant-grid">
    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('restaurantes'), 'restaurante');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('restaurante')->value) {
$foreach0DoElse = false;
?>
      <div class="restaurant-card">
                <div class="restaurant-header">
                  <?php if ($_smarty_tpl->getValue('restaurante')->getImagen()) {?>
                    <img src="<?php echo $_smarty_tpl->getValue('restaurante')->getImagen();?>
" alt="<?php echo $_smarty_tpl->getValue('restaurante')->getNombre();?>
" class="restaurant-image">
                  <?php } else { ?>
                    <div class="restaurant-image-placeholder">
                      <span><?php echo mb_strtoupper((string) substr((string) $_smarty_tpl->getValue('restaurante')->getNombre(), (int) 0, (int) 1) ?? '', 'UTF-8');?>
</span>
                    </div>
                  <?php }?>
                  <h3 class="restaurant-name"><?php echo $_smarty_tpl->getValue('restaurante')->getNombre();?>
</h3>
                </div>
                <div class="restaurant-info">
                  <p><strong>Dirección:</strong> <?php echo $_smarty_tpl->getValue('restaurante')->getDireccion();?>
</p>
                  <?php if ($_smarty_tpl->getValue('restaurante')->getTelefono()) {?>
                    <p><strong>Teléfono:</strong> <?php echo $_smarty_tpl->getValue('restaurante')->getTelefono();?>
</p>
                  <?php }?>
                  <?php if ($_smarty_tpl->getValue('restaurante')->getEmail()) {?>
                    <p><strong>Email:</strong> <?php echo $_smarty_tpl->getValue('restaurante')->getEmail();?>
</p>
                  <?php }?>
                </div>
                <div class="restaurant-status">
                  <span class="status-badge <?php if ($_smarty_tpl->getValue('restaurante')->isActivo()) {?>status-active<?php } else { ?>status-inactive<?php }?>">
                    <?php if ($_smarty_tpl->getValue('restaurante')->isActivo()) {?>Activo<?php } else { ?>Inactivo<?php }?>
                  </span>
                </div>
                <div class="restaurant-actions">
                  <a href="/restaurante/<?php echo $_smarty_tpl->getValue('restaurante')->getId();?>
" class="btn-action">Ver detalles</a>
                  <a href="/restaurante/<?php echo $_smarty_tpl->getValue('restaurante')->getId();?>
/editar" class="btn-action">Editar</a>
                  <a href="/restaurante/<?php echo $_smarty_tpl->getValue('restaurante')->getId();?>
/menu" class="btn-action">Gestionar menú</a>
                </div>
              </div>
    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
  </div>
<?php }
}
}
/* {/block "contenido"} */
}
