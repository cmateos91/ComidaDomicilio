<?php
/* Smarty version 5.5.0, created on 2025-05-08 13:19:22
  from 'file:clientes/index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_681c933a518671_10703559',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd6e0b95ac5ae94b9c672b0a421784e19b34a9e20' => 
    array (
      0 => 'clientes/index.tpl',
      1 => 1746703134,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_681c933a518671_10703559 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\clientes';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_227493949681c933a48d886_53493660', "contenido");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "../layouts/dashboard.tpl", $_smarty_current_dir);
}
/* {block "contenido"} */
class Block_227493949681c933a48d886_53493660 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\clientes';
?>

<!-- Content for Clientes section -->
<div class="content-container">
  <div class="section-header">
    <h2>Clientes</h2>
  </div>
  
  <?php if (( !$_smarty_tpl->hasVariable('clientes') || empty($_smarty_tpl->getValue('clientes')))) {?>
    <div class="empty-state">
      <div class="empty-icon">👥</div>
      <h3>No hay clientes registrados</h3>
      <p>Aquí se mostrarán los clientes cuando se registren en el sistema.</p>
    </div>
  <?php } else { ?>
    <div class="clientes-grid">
      <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('clientes'), 'cliente');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('cliente')->value) {
$foreach0DoElse = false;
?>
        <div class="cliente-card">
          <div class="cliente-header">
            <h3 class="cliente-name"><?php echo $_smarty_tpl->getValue('cliente')->getNombre();?>
 <?php echo $_smarty_tpl->getValue('cliente')->getApellidos();?>
</h3>
          </div>
          <div class="cliente-info">
            <?php if ($_smarty_tpl->getValue('cliente')->getEmail()) {?>
              <p><strong>Email:</strong> <span>📧</span> <?php echo $_smarty_tpl->getValue('cliente')->getEmail();?>
</p>
            <?php }?>
            <?php if ($_smarty_tpl->getValue('cliente')->getTelefono()) {?>
              <p><strong>Teléfono:</strong> <span>📞</span> <?php echo $_smarty_tpl->getValue('cliente')->getTelefono();?>
</p>
            <?php }?>
            <?php if ($_smarty_tpl->getValue('cliente')->getDireccion()) {?>
              <p><strong>Dirección:</strong> <span>📍</span> <?php echo $_smarty_tpl->getValue('cliente')->getDireccion();?>
</p>
            <?php }?>
          </div>
          <div class="cliente-stats">
            <div class="stat-card">
              <div class="stat-icon">🛒</div>
              <div class="stat-content">
                <p class="stat-label">Pedidos</p>
                <p class="stat-value"><?php echo $_smarty_tpl->getValue('cliente')->getTotalPedidos();?>
</p>
              </div>
            </div>
          </div>
          <div class="cliente-actions">
            <a href="/cliente/<?php echo $_smarty_tpl->getValue('cliente')->getId();?>
" class="btn-action">Ver detalles</a>
            <a href="/cliente/<?php echo $_smarty_tpl->getValue('cliente')->getId();?>
/pedidos" class="btn-action">Ver pedidos</a>
          </div>
        </div>
      <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </div>
  <?php }?>
</div>
<?php
}
}
/* {/block "contenido"} */
}
