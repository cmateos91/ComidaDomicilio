<!-- app/Views/dashboard/index.tpl -->
{extends file="../layouts/dashboard.tpl"}
{block name="contenido"}
<!-- Metrics Cards -->
<div class="metrics-container">
  <div class="metric-card">
    <div class="metric-icon" style="color: #4285f4;">🛒</div>
    <div>
      <p class="metric-label">Pedidos de hoy</p>
      <p class="metric-value">{$totalPedidosHoy}</p>
    </div>
  </div>
  
  <div class="metric-card">
    <div class="metric-icon" style="color: #4285f4;">€</div>
    <div>
      <p class="metric-label">Ingresos del día</p>
      <p class="metric-value">450 €</p>
    </div>
  </div>
  
  <div class="metric-card">
    <div class="metric-icon" style="color: #4285f4;">⏱️</div>
    <div>
      <p class="metric-label">Pedidos pendientes</p>
      <p class="metric-value"></p>
    </div>
  </div>
  
  <div class="metric-card">
    <div class="metric-icon" style="color: #ffc107;">4,8</div>
    <div>
      <p class="metric-label">Valoración promedio</p>
      <p class="metric-value"></p>
    </div>
  </div>
</div>

<!-- Layout with main content and sidebar -->
<div class="layout-container">
  <div class="main-content">
    <!-- Charts -->
    <div class="charts-container">
      <div class="chart-card">
        <h3 class="chart-title">Pedidos por día</h3>
        <div class="chart">
          <div class="bar" style="height: 30%;"></div>
          <div class="bar" style="height: 40%;"></div>
          <div class="bar" style="height: 50%;"></div>
          <div class="bar" style="height: 60%;"></div>
          <div class="bar" style="height: 70%;"></div>
          <div class="bar" style="height: 85%;"></div>
          <div class="bar" style="height: 100%;"></div>
        </div>
      </div>
      
      <div class="chart-card">
        <h3 class="chart-title">Categorías más vendidas</h3>
        <div class="pie-charts">
          <div class="pie-chart-small"></div>
          <div class="pie-chart"></div>
        </div>
      </div>
    </div>
    
    <!-- Orders Table -->
    <div class="orders-table">
      <h3 class="orders-title">Últimos pedidos</h3>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Hora</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1001</td>
            <td>Ana García</td>
            <td>€25,00</td>
            <td><span class="status status-completed">Completado</span></td>
            <td>11:30</td>
            <td><a href="#" class="action-link">Ver</a></td>
          </tr>
          <tr>
            <td>1002</td>
            <td>Pedro López</td>
            <td>€25,00</td>
            <td><span class="status status-pending">Pendiente</span></td>
            <td>10:45</td>
            <td><a href="#" class="action-link">Ver</a></td>
          </tr>
          <tr>
            <td>1003</td>
            <td>María Sánchez</td>
            <td>€25,00</td>
            <td><span class="status status-progress">En progreso</span></td>
            <td>10:45</td>
            <td><a href="#" class="action-link">Ver</a></td>
          </tr>
          <tr>
            <td>1004</td>
            <td>David Martín</td>
            <td>€13,00</td>
            <td><span class="status status-action">Accion</span></td>
            <td>09:20</td>
            <td><a href="#" class="action-link">Ver</a></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  
  <div class="sidebar">
    <!-- Menu options -->
    <div class="sidebar-menu">
      <a href="#" class="menu-button">
        <span class="menu-icon">📋</span>
        Ver todos los pedidos
      </a>
      <a href="#" class="menu-button">
        <span class="menu-icon">🍔</span>
        Gestionar menú
      </a>
      <a href="#" class="menu-button">
        <span class="menu-icon">🕒</span>
        Cambiar horario
      </a>
      <a href="#" class="menu-button">
        <span class="menu-icon">👤</span>
        Editar perfil restaurante
      </a>
    </div>
  </div>
</div>

<!-- Keep welcome message but make it less prominent -->
<div style="margin-top: 20px; text-align: center; color: #666;">
  <p>¡Bienvenido, {$nombre}!</p>
</div>
{/block}