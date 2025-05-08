{extends file="../layouts/dashboard.tpl"}

{block name="contenido"}
{assign var="css_adicional" value=["carta.css"] scope="parent"}
{assign var="js_adicional" value=["carta.js"] scope="parent"}

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
          {if isset($menu) && isset($menu.entradas) && count($menu.entradas) > 0}
            {foreach $menu.entradas as $plato}
              <div class="menu-item" data-aos="fade-up">
                <img src="{$plato.imagen|default:'https://images.pexels.com/photos/1211887/pexels-photo-1211887.jpeg'}" alt="{$plato.nombre}">
                <h3>{$plato.nombre}</h3>
                <p>{$plato.descripcion}</p>
                <span class="price">{$plato.precio}€</span>
              </div>
            {/foreach}
          {else}
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
          {/if}
        </div>
      </section>

      <section id="principales" class="menu-section" data-aos="fade-up">
        <h2>Platos Principales</h2>
        <div class="menu-grid">
          {if isset($menu) && isset($menu.principales) && count($menu.principales) > 0}
            {foreach $menu.principales as $plato}
              <div class="menu-item" data-aos="fade-up">
                <img src="{$plato.imagen|default:'https://images.pexels.com/photos/675951/pexels-photo-675951.jpeg'}" alt="{$plato.nombre}">
                <h3>{$plato.nombre}</h3>
                <p>{$plato.descripcion}</p>
                <span class="price">{$plato.precio}€</span>
              </div>
            {/foreach}
          {else}
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
          {/if}
        </div>
      </section>

      <section id="postres" class="menu-section" data-aos="fade-up">
        <h2>Postres</h2>
        <div class="menu-grid">
          {if isset($menu) && isset($menu.postres) && count($menu.postres) > 0}
            {foreach $menu.postres as $plato}
              <div class="menu-item" data-aos="fade-up">
                <img src="{$plato.imagen|default:'https://images.pexels.com/photos/1126359/pexels-photo-1126359.jpeg'}" alt="{$plato.nombre}">
                <h3>{$plato.nombre}</h3>
                <p>{$plato.descripcion}</p>
                <span class="price">{$plato.precio}€</span>
              </div>
            {/foreach}
          {else}
            <div class="menu-item" data-aos="fade-up">
              <img src="https://images.pexels.com/photos/1126359/pexels-photo-1126359.jpeg" alt="Tiramisú">
              <h3>Tiramisú</h3>
              <p>Clásico postre italiano con queso mascarpone, café y cacao</p>
              <span class="price">8.99€</span>
            </div>
          {/if}
        </div>
      </section>

      <section id="bebidas" class="menu-section" data-aos="fade-up">
        <h2>Bebidas</h2>
        <div class="menu-grid">
          {if isset($menu) && isset($menu.bebidas) && count($menu.bebidas) > 0}
            {foreach $menu.bebidas as $bebida}
              <div class="menu-item" data-aos="fade-up">
                <img src="{$bebida.imagen|default:'https://images.pexels.com/photos/602750/pexels-photo-602750.jpeg'}" alt="{$bebida.nombre}">
                <h3>{$bebida.nombre}</h3>
                <p>{$bebida.descripcion}</p>
                <span class="price">{$bebida.precio}€</span>
              </div>
            {/foreach}
          {else}
            <div class="menu-item" data-aos="fade-up">
              <img src="https://images.pexels.com/photos/602750/pexels-photo-602750.jpeg" alt="Vino Tinto">
              <h3>Vino Tinto</h3>
              <p>Selección de vinos tintos de la casa</p>
              <span class="price">5.99€</span>
            </div>
          {/if}
        </div>
      </section>
    </main>

    <footer>
      <p>&copy; {$smarty.now|date_format:"%Y"} Restaurante Gourmet. Todos los derechos reservados.</p>
    </footer>
  </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- AOS initialization is now handled in carta.js to avoid duplicate initialization -->
{/block}