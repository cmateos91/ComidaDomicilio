/**
 * JavaScript para el área de cliente
 */
document.addEventListener('DOMContentLoaded', function() {
    // Manejar el menú desplegable de usuario
    const userInfo = document.querySelector('.user-info');
    if (userInfo) {
        userInfo.addEventListener('click', function(e) {
            const dropdown = this.querySelector('.dropdown-menu');
            if (dropdown) {
                dropdown.classList.toggle('active');
                e.stopPropagation();
            }
        });
        
        // Cerrar el menú al hacer clic en cualquier parte
        document.addEventListener('click', function() {
            const dropdown = userInfo.querySelector('.dropdown-menu');
            if (dropdown && dropdown.classList.contains('active')) {
                dropdown.classList.remove('active');
            }
        });
    }
    
    // Añadir efectos hover a las tarjetas de restaurantes
    const restaurantCards = document.querySelectorAll('.restaurant-card');
    if (restaurantCards.length > 0) {
        restaurantCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 8px 16px rgba(0, 0, 0, 0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 6px rgba(0, 0, 0, 0.08)';
            });
        });
    }
    
    // Formatear correctamente las etiquetas de estado de pedidos
    const orderStatuses = document.querySelectorAll('.order-status');
    if (orderStatuses.length > 0) {
        orderStatuses.forEach(status => {
            const statusText = status.textContent.trim().toLowerCase();
            
            // Aplicar clases según el estado
            if (statusText === 'pendiente') {
                status.classList.add('status-pendiente');
            } else if (statusText === 'preparando' || statusText === 'en preparación') {
                status.classList.add('status-preparando');
            } else if (statusText === 'enviado' || statusText === 'en camino') {
                status.classList.add('status-enviado');
            } else if (statusText === 'entregado') {
                status.classList.add('status-entregado');
            } else if (statusText === 'cancelado') {
                status.classList.add('status-cancelado');
            }
        });
    }
    
    // Controlador para el botón de búsqueda
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const input = this.querySelector('input[type="text"]');
            if (input && input.value.trim() === '') {
                e.preventDefault();
                input.classList.add('error');
                setTimeout(() => {
                    input.classList.remove('error');
                }, 500);
            }
        });
    }
    
    // Simular carga de carrito (para demo)
    const carritoCount = document.querySelector('.carrito-icon .count');
    if (carritoCount) {
        // Comprobar si hay elementos en el carrito desde el almacenamiento local
        const cartItems = localStorage.getItem('cartItems');
        if (cartItems) {
            const itemCount = JSON.parse(cartItems).length;
            carritoCount.textContent = itemCount > 0 ? itemCount : '0';
        }
    }
    
    // Función para mostrar el tiempo de entrega estimado
    function updateEstimatedDeliveryTime() {
        const deliveryTimeElements = document.querySelectorAll('.delivery-time');
        if (deliveryTimeElements.length > 0) {
            const now = new Date();
            const estimatedTime = new Date(now.getTime() + 30 * 60000); // 30 minutos
            
            const formattedTime = estimatedTime.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
            
            deliveryTimeElements.forEach(el => {
                el.textContent = formattedTime;
            });
        }
    }
    
    // Actualizar tiempo estimado si hay elementos relevantes
    if (document.querySelectorAll('.delivery-time').length > 0) {
        updateEstimatedDeliveryTime();
        // Actualizar cada minuto
        setInterval(updateEstimatedDeliveryTime, 60000);
    }
    
    // Funcionalidad de filtrado para la página de restaurantes
    const filterSelects = document.querySelectorAll('.filter-group select');
    if (filterSelects.length > 0) {
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                // Aquí iría la lógica real de filtrado
                // Por ahora solo simularemos un cambio visual
                const restaurantCards = document.querySelectorAll('.restaurant-card');
                restaurantCards.forEach(card => {
                    card.style.opacity = '0.7';
                    setTimeout(() => {
                        card.style.opacity = '1';
                    }, 300);
                });
            });
        });
    }
});
