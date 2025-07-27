document.addEventListener('DOMContentLoaded', () => {
  const toggleBtn = document.querySelector('.btn-add'); // Button that will open the menu
  const addArticleMenu = document.querySelector('.add-article-menu'); // Menu
  const closeMenuBtn = document.querySelector('.add-article-menu__close-btn'); // Button to close the menu

  // Function to calculate button coordinates
  function getButtonCoordinates() {
    const rect = toggleBtn.getBoundingClientRect();
    return {
      top: rect.top + window.scrollY,
      left: rect.left + window.scrollX,
      width: rect.width,
      height: rect.height
    };
  }

  // Click handler for opening and closing menu
  function toggleMenuHandler() {
    addArticleMenu.classList.toggle('add-article-menu_open'); // Open/close menu

    // Position the menu
    if (addArticleMenu.classList.contains('add-article-menu_open')) {
      const coords = getButtonCoordinates();
      // Position menu relative to button
      addArticleMenu.style.top = (coords.top + coords.height + 10) + 'px';
      addArticleMenu.style.left = (coords.left - addArticleMenu.offsetWidth + coords.width) + 'px';
    }
  }

  // Click handler for button to open/close menu
  toggleBtn.addEventListener('click', function(event) {
    event.stopPropagation(); // Don't let event propagate to other elements
    toggleMenuHandler(); // Toggle menu visibility
  });

  // Menu close handler
  closeMenuBtn.addEventListener('click', function() {
    addArticleMenu.classList.remove('add-article-menu_open'); // Close menu
  });

  // Close menu if clicked outside menu and button
  document.addEventListener('click', function(event) {
    if (!addArticleMenu.contains(event.target) && !toggleBtn.contains(event.target)) {
      addArticleMenu.classList.remove('add-article-menu_open'); // Close menu
    }
  });
});
