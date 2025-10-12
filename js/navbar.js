document.addEventListener("DOMContentLoaded", function() {
  
  const navbarPlaceholder = document.getElementById('navbar');

  if (navbarPlaceholder) {
    // 🎯 CAMINHO 
    fetch('../components/navbar.html')
      .then(response => response.text())
      .then(data => {
        navbarPlaceholder.innerHTML = data;

        // Lógica para marcar o link ativo
        const currentPage = window.location.pathname.split('/').pop();
        const navLinks = navbarPlaceholder.querySelectorAll('.main-nav a');
        
        navLinks.forEach(link => {
          const linkPage = link.getAttribute('href');
          if (linkPage === currentPage || (currentPage === '' && linkPage === 'index.html')) {
            link.classList.add('active');
          }
        });
      })
      .catch(error => console.error('Erro ao carregar a navbar:', error));
  }
});