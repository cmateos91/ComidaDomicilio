document.addEventListener('DOMContentLoaded', function() {
  // Initialize AOS animation library if present
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true
    });
  }

  // Mobile menu toggle
  const menuToggle = document.querySelector('.menu-toggle');
  const navLinks = document.querySelector('.nav-links');
  
  if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', function() {
      navLinks.classList.toggle('active');
      // Create a simple animation for the hamburger icon
      const spans = menuToggle.querySelectorAll('span');
      spans[0].classList.toggle('rotate-down');
      spans[1].classList.toggle('fade-out');
      spans[2].classList.toggle('rotate-up');
    });
  }

  // Smooth scrolling for navigation links
  const scrollLinks = document.querySelectorAll('a[href^="#"]');
  
  scrollLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Close mobile menu if open
      if (navLinks && navLinks.classList.contains('active')) {
        navLinks.classList.remove('active');
      }
      
      const targetId = this.getAttribute('href');
      const targetElement = document.querySelector(targetId);
      
      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop - 80, // Offset for fixed header
          behavior: 'smooth'
        });
      }
    });
  });

  // Preview functionality in admin dashboard
  const previewControls = document.querySelectorAll('.preview-controls button');
  
  if (previewControls.length > 0) {
    previewControls.forEach(button => {
      button.addEventListener('click', function() {
        // Toggle active state for buttons
        previewControls.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        
        // Example of functionality that could be expanded
        if (this.textContent.includes('Editar')) {
          console.log('Activando modo edición');
          // Code to enable edit mode would go here
        } else if (this.textContent.includes('público')) {
          console.log('Mostrando vista pública');
          // Code to show public view would go here
        }
      });
    });
  }

  // Placeholder for lazy loading images
  const menuImages = document.querySelectorAll('.menu-item img');
  
  if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          const src = img.getAttribute('data-src');
          if (src) {
            img.src = src;
            img.removeAttribute('data-src');
          }
          observer.unobserve(img);
        }
      });
    });
    
    menuImages.forEach(img => {
      if (img.getAttribute('data-src')) {
        imageObserver.observe(img);
      }
    });
  }
});