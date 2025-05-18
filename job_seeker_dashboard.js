const sidebar = document.querySelector('.sidebar');
const hamburger = document.getElementById('hamburger');
const mainContent = document.querySelector('.main-content');
const links = document.querySelectorAll('.sidebar .nav-link');
const sections = document.querySelectorAll('.section');

hamburger.addEventListener('click', () => {
  // Toggle sidebar visibility on small screens
  if (window.innerWidth <= 768) {
    sidebar.classList.toggle('show');
  } else {
    // On larger screens, toggle sidebar slide
    sidebar.classList.toggle('hidden');
    mainContent.classList.toggle('fullwidth');
  }
});

// Sidebar navigation functionality (section switching)
links.forEach(link => {
  link.addEventListener('click', () => {
    // Remove active from all links
    links.forEach(l => l.classList.remove('active'));
    // Add active to clicked link
    link.classList.add('active');

    const target = link.getAttribute('data-section');
    // Hide all sections
    sections.forEach(section => section.classList.remove('active'));
    // Show target section
    document.getElementById(target).classList.add('active');

    // If on small screen, hide sidebar after selection
    if (window.innerWidth <= 768) {
      sidebar.classList.remove('show');
    }
  });
});

// Optional: Close sidebar if window resized from small to large to avoid stuck sidebar
window.addEventListener('resize', () => {
  if (window.innerWidth > 768) {
    sidebar.classList.remove('show');
    sidebar.classList.remove('hidden');
    mainContent.classList.remove('fullwidth');
  }
});
