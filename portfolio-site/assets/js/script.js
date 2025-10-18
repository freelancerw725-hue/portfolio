// JavaScript for smooth scrolling, form handling, and responsive menu toggle

document.addEventListener('DOMContentLoaded', function() {
  // Smooth scrolling for navigation links
  const navLinks = document.querySelectorAll('.nav-links a');
  navLinks.forEach(function(link) {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const targetId = this.getAttribute('href').substring(1);
      const targetSection = document.getElementById(targetId);
      if (targetSection) {
        targetSection.scrollIntoView({ behavior: 'smooth' });
      }
      // Close the mobile menu when a nav link is clicked
      const menuToggle = document.querySelector('.menu-toggle');
      const navLinksContainer = document.querySelector('.nav-links');
      if (menuToggle && navLinksContainer) {
        navLinksContainer.classList.remove('active');
        menuToggle.classList.remove('active');
      }
    });
  });

  // Simple form submission handler (no backend)
  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      // Allow form to submit to backend
      // Show success message after submission
      const successMessage = document.getElementById('success-message');
      if (successMessage) {
        successMessage.style.display = 'block';
      }
    });
  }

  // Hamburger menu toggle functionality
  const menuToggle = document.querySelector('.menu-toggle');
  const navLinksContainer = document.querySelector('.nav-links');

  if (menuToggle && navLinksContainer) {
    menuToggle.addEventListener('click', function() {
      navLinksContainer.classList.toggle('active');
      menuToggle.classList.toggle('active');
    });

    // Close menu when clicking outside nav or menu toggle
    document.addEventListener('click', function(event) {
      if (!navLinksContainer.contains(event.target) && !menuToggle.contains(event.target)) {
        navLinksContainer.classList.remove('active');
        menuToggle.classList.remove('active');
      }
    });
  }
});
