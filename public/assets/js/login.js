document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('loginForm');
  
    form.addEventListener('submit', async function (e) {
      e.preventDefault();
  
      const formData = new FormData(form);
  
      const response = await fetch('/api/login', {
        method: 'POST',
        body: formData
      });
  
      const result = await response.json();
  
      if (response.ok && result.success) {
        //console.log( "Bienvenido, " + result.user.name + "!");
        window.location.href = '/dashboard'; // o cambia a otra ruta
      } else {
        document.getElementById('loginError').textContent = result.error || 'Error de autenticación';
      }
    });
  });
  