document.addEventListener('DOMContentLoaded', () => {
  const addArticleMenu = document.querySelector('.add-article-menu'); // Menu
  const closeMenuBtn = document.querySelector('.add-article-menu__close-btn'); // Close button inside menu

  // Variable to keep track of which button currently "owns" the menu
  let currentActiveButton = null;

  /**
   * Calculates and sets the menu position relative to the clicked button
   * @param {HTMLElement} button - The specific button that was clicked
   */
  function updateMenuPosition(button) {
    if (!button || !addArticleMenu.classList.contains('add-article-menu_open')) return;

    const rect = button.getBoundingClientRect();
    const coords = {
      top: rect.top + window.scrollY,
      left: rect.left + window.scrollX,
      width: rect.width,
      height: rect.height
    };

    const menuWidth = addArticleMenu.offsetWidth;
    const screenWidth = window.innerWidth;
    const padding = 10;

    // Vertical position (below the button)
    addArticleMenu.style.top = (coords.top + coords.height + 10) + 'px';

    // Horizontal centering relative to the button
    let leftPos = (coords.left + (coords.width / 2)) - (menuWidth / 2);

    // Screen boundary checks to prevent overflow
    if (leftPos < padding) {
      leftPos = padding;
    } else if (leftPos + menuWidth > screenWidth - padding) {
      leftPos = screenWidth - menuWidth - padding;
    }

    addArticleMenu.style.left = leftPos + 'px';
  }

  /**
   * Using Event Delegation:
   * We listen to clicks on the whole document to catch clicks on any '.btn-add'
   * even if they were added dynamically via AJAX later.
   */
  document.addEventListener('click', (event) => {
    // Find if the click was on a .btn-add or inside it (e.g., on the plus icon)
    const btn = event.target.closest('.btn-add');

    if (btn) {
      event.stopPropagation(); // Stop propagation to prevent immediate closing

      // If clicking the same button that is already open - close it
      if (currentActiveButton === btn && addArticleMenu.classList.contains('add-article-menu_open')) {
        addArticleMenu.classList.remove('add-article-menu_open');
        return;
      }

      // Set current button, open menu, and position it
      currentActiveButton = btn;
      addArticleMenu.classList.add('add-article-menu_open');
      updateMenuPosition(btn);
    }
    // Close menu if clicked anywhere else outside the menu
    else if (addArticleMenu && !addArticleMenu.contains(event.target)) {
      addArticleMenu.classList.remove('add-article-menu_open');
    }
  });

  // Re-position the menu if the window is resized
  window.addEventListener('resize', () => {
    updateMenuPosition(currentActiveButton);
  });

  // Explicit close button handler
  if (closeMenuBtn) {
    closeMenuBtn.addEventListener('click', () => {
      addArticleMenu.classList.remove('add-article-menu_open');
    });
  }
});