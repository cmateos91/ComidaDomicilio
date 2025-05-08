<?php
/* Smarty version 5.5.0, created on 2025-05-08 13:30:55
  from 'file:menus/index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.0',
  'unifunc' => 'content_681c95efd837f2_90933569',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b192e22b5f9cdfd25002f0c4fa1962c2999e543a' => 
    array (
      0 => 'menus/index.tpl',
      1 => 1746703819,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_681c95efd837f2_90933569 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\menus';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1869038377681c95efd510e3_21452776', "contenido");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "../layouts/dashboard.tpl", $_smarty_current_dir);
}
/* {block "contenido"} */
class Block_1869038377681c95efd510e3_21452776 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\comida-domicilio-2\\app\\Views\\menus';
?>

<?php $_smarty_tpl->assign('css_adicional', array("carta.css"), false, 2);
$_smarty_tpl->assign('js_adicional', array("carta.js"), false, 2);?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<div class="carta-preview">
  <div class="preview-header">
    <h2>Vista previa de su carta digital</h2>
    <div class="preview-controls">
      <button class="btn-primary">Editar carta</button>
      <button class="btn-secondary">Ver público</button>
    </div>
  </div>

  <!-- Simulación de carta digital -->
  <div class="carta-container">
    <header class="hero">
      <nav class="nav">
        <div class="logo">Gourmet</div>
        <div class="menu-toggle">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <ul class="nav-links">
          <li><a href="#entradas">Entradas</a></li>
          <li><a href="#principales">Platos Principales</a></li>
          <li><a href="#postres">Postres</a></li>
          <li><a href="#bebidas">Bebidas</a></li>
        </ul>
      </nav>
      <div class="hero-content">
        <h1 data-aos="fade-up">Bienvenidos a Gourmet</h1>
        <p data-aos="fade-up" data-aos-delay="200">Una experiencia culinaria única</p>
      </div>
    </header>

    <main>
      <section id="entradas" class="menu-section" data-aos="fade-up">
        <h2>Entradas</h2>
        <div class="menu-grid">
          <?php if ((true && ($_smarty_tpl->hasVariable('menu') && null !== ($_smarty_tpl->getValue('menu') ?? null))) && (true && (true && null !== ($_smarty_tpl->getValue('menu')['entradas'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('menu')['entradas']) > 0) {?>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('menu')['entradas'], 'plato');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('plato')->value) {
$foreach0DoElse = false;
?>
              <div class="menu-item" data-aos="fade-up">
                <img src="<?php echo (($tmp = $_smarty_tpl->getValue('plato')['imagen'] ?? null)===null||$tmp==='' ? 'https://images.pexels.com/photos/1211887/pexels-photo-1211887.jpeg' ?? null : $tmp);?>
" alt="<?php echo $_smarty_tpl->getValue('plato')['nombre'];?>
">
                <h3><?php echo $_smarty_tpl->getValue('plato')['nombre'];?>
</h3>
                <p><?php echo $_smarty_tpl->getValue('plato')['descripcion'];?>
</p>
                <span class="price"><?php echo $_smarty_tpl->getValue('plato')['precio'];?>
€</span>
              </div>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
          <?php } else { ?>
            <div class="menu-item" data-aos="fade-up">
              <img src="https://images.pexels.com/photos/1211887/pexels-photo-1211887.jpeg" alt="Ensalada César">
              <h3>Ensalada César</h3>
              <p>Lechuga romana, crutones, parmesano y aderezo césar</p>
              <span class="price">12.99€</span>
            </div>
            <div class="menu-item" data-aos="fade-up">
              <img src="https://images.pexels.com/photos/2097090/pexels-photo-2097090.jpeg" alt="Carpaccio de Res">
              <h3>Carpaccio de Res</h3>
              <p>Finas láminas de res con aceite de oliva, alcaparras y parmesano</p>
              <span class="price">14.99€</span>
            </div>
          <?php }?>
        </div>
      </section>

      <section id="principales" class="menu-section" data-aos="fade-up">
        <h2>Platos Principales</h2>
        <div class="menu-grid">
          <?php if ((true && ($_smarty_tpl->hasVariable('menu') && null !== ($_smarty_tpl->getValue('menu') ?? null))) && (true && (true && null !== ($_smarty_tpl->getValue('menu')['principales'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('menu')['principales']) > 0) {?>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('menu')['principales'], 'plato');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('plato')->value) {
$foreach1DoElse = false;
?>
              <div class="menu-item" data-aos="fade-up">
                <img src="<?php echo (($tmp = $_smarty_tpl->getValue('plato')['imagen'] ?? null)===null||$tmp==='' ? 'https://images.pexels.com/photos/675951/pexels-photo-675951.jpeg' ?? null : $tmp);?>
" alt="<?php echo $_smarty_tpl->getValue('plato')['nombre'];?>
">
                <h3><?php echo $_smarty_tpl->getValue('plato')['nombre'];?>
</h3>
                <p><?php echo $_smarty_tpl->getValue('plato')['descripcion'];?>
</p>
                <span class="price"><?php echo $_smarty_tpl->getValue('plato')['precio'];?>
€</span>
              </div>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
          <?php } else { ?>
            <div class="menu-item" data-aos="fade-up">
              <img src="https://images.pexels.com/photos/675951/pexels-photo-675951.jpeg" alt="Salmón a la Parrilla">
              <h3>Salmón a la Parrilla</h3>
              <p>Salmón fresco con vegetales de temporada</p>
              <span class="price">24.99€</span>
            </div>
            <div class="menu-item" data-aos="fade-up">
              <img src="https://images.pexels.com/photos/769289/pexels-photo-769289.jpeg" alt="Risotto de Hongos">
              <h3>Risotto de Hongos</h3>
              <p>Arroz arborio cremoso con variedad de hongos y parmesano</p>
              <span class="price">18.99€</span>
            </div>
          <?php }?>
        </div>
      </section>

      <section id="postres" class="menu-section" data-aos="fade-up">
        <h2>Postres</h2>
        <div class="menu-grid">
          <?php if ((true && ($_smarty_tpl->hasVariable('menu') && null !== ($_smarty_tpl->getValue('menu') ?? null))) && (true && (true && null !== ($_smarty_tpl->getValue('menu')['postres'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('menu')['postres']) > 0) {?>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('menu')['postres'], 'plato');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('plato')->value) {
$foreach2DoElse = false;
?>
              <div class="menu-item" data-aos="fade-up">
                <img src="<?php echo (($tmp = $_smarty_tpl->getValue('plato')['imagen'] ?? null)===null||$tmp==='' ? 'https://images.pexels.com/photos/1126359/pexels-photo-1126359.jpeg' ?? null : $tmp);?>
" alt="<?php echo $_smarty_tpl->getValue('plato')['nombre'];?>
">
                <h3><?php echo $_smarty_tpl->getValue('plato')['nombre'];?>
</h3>
                <p><?php echo $_smarty_tpl->getValue('plato')['descripcion'];?>
</p>
                <span class="price"><?php echo $_smarty_tpl->getValue('plato')['precio'];?>
€</span>
              </div>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
          <?php } else { ?>
            <div class="menu-item" data-aos="fade-up">
              <img src="https://images.pexels.com/photos/1126359/pexels-photo-1126359.jpeg" alt="Tiramisú">
              <h3>Tiramisú</h3>
              <p>Clásico postre italiano con queso mascarpone, café y cacao</p>
              <span class="price">8.99€</span>
            </div>
          <?php }?>
        </div>
      </section>

      <section id="bebidas" class="menu-section" data-aos="fade-up">
        <h2>Bebidas</h2>
        <div class="menu-grid">
          <?php if ((true && ($_smarty_tpl->hasVariable('menu') && null !== ($_smarty_tpl->getValue('menu') ?? null))) && (true && (true && null !== ($_smarty_tpl->getValue('menu')['bebidas'] ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('menu')['bebidas']) > 0) {?>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('menu')['bebidas'], 'bebida');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('bebida')->value) {
$foreach3DoElse = false;
?>
              <div class="menu-item" data-aos="fade-up">
                <img src="<?php echo (($tmp = $_smarty_tpl->getValue('bebida')['imagen'] ?? null)===null||$tmp==='' ? 'https://images.pexels.com/photos/602750/pexels-photo-602750.jpeg' ?? null : $tmp);?>
" alt="<?php echo $_smarty_tpl->getValue('bebida')['nombre'];?>
">
                <h3><?php echo $_smarty_tpl->getValue('bebida')['nombre'];?>
</h3>
                <p><?php echo $_smarty_tpl->getValue('bebida')['descripcion'];?>
</p>
                <span class="price"><?php echo $_smarty_tpl->getValue('bebida')['precio'];?>
€</span>
              </div>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
          <?php } else { ?>
            <div class="menu-item" data-aos="fade-up">
              <img src="https://images.pexels.com/photos/602750/pexels-photo-602750.jpeg" alt="Vino Tinto">
              <h3>Vino Tinto</h3>
              <p>Selección de vinos tintos de la casa</p>
              <span class="price">5.99€</span>
            </div>
          <?php }?>
        </div>
      </section>
    </main>

    <footer>
      <p>&copy; <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')(time(),"%Y");?>
 Restaurante Gourmet. Todos los derechos reservados.</p>
    </footer>
  </div>
</div>

<?php echo '<script'; ?>
 src="https://unpkg.com/aos@2.3.1/dist/aos.js"><?php echo '</script'; ?>
>
<!-- AOS initialization is now handled in carta.js to avoid duplicate initialization -->
<?php
}
}
/* {/block "contenido"} */
}
