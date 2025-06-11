// Recalculate navigation layout when the window is resized
window.onresize = () => {
  resizeHeaderNavigations();
}

document.addEventListener("DOMContentLoaded", () => {
  (function() {
    const overlay = document.createElement('div');
    const categoriesBtn = document.getElementById('categories-btn');
    const separator = document.querySelector('.menu__separator');
    const categoriesMenu = document.querySelector('.menu__categories');
    const toggleBtn = document.querySelector('.toggle-btn');
    const toggleBtns = document.querySelector('.toggle-btns');
    const burgerMenu = document.getElementById('burger-menu');
    const userMenu = document.getElementById('user-menu');
    let categoriesIsActive = false;
    let activeMenu = null;

    overlay.classList.add('overlay');
    resizeHeaderNavigations();

    const barsArr = Array.from(document.querySelectorAll('.toggle-btn__bar'));

    // Open specified menu (burger or user) and apply visual transformations
    function openMenu(menuType) {
      if (menuType === 'burger') {
        const coordinates = toggleBtn.getBoundingClientRect();
        const angleRadian = 24 / 48;
        const angleDeg = Math.atan(angleRadian) * 180 / Math.PI;
        const transformWidth = Math.sqrt(48 * 48 + 24 * 24);

        barsArr[1].style.opacity = 0;
        barsArr[0].style.width = transformWidth + 'px';
        barsArr[0].style.transform = `rotate(${angleDeg}deg)`;
        barsArr[2].style.width = transformWidth + 'px';
        barsArr[2].style.transform = `rotate(-${angleDeg}deg)`;

        toggleBtn.dataset.state = 'opened';
        toggleBtn.style.zIndex = '2';
        toggleBtn.style.position = 'fixed';
        toggleBtn.style.top = coordinates.top + 'px';
        toggleBtn.style.left = coordinates.left + 'px';
        burgerMenu.classList.add('menu_opened');
      }
      else if (menuType === 'user') {
        toggleBtns.dataset.state = 'opened';
        toggleBtns.style.zIndex = '2';
        userMenu.classList.add('menu_opened');
      }
      activeMenu = menuType;
      document.body.append(overlay);
    }

    // Close the active menu and reset its appearance
    function closeMenu() {
      if (activeMenu === 'burger') {
        barsArr[1].style.opacity = '';
        barsArr[0].style.width = '';
        barsArr[0].style.transform = '';
        barsArr[2].style.width = '';
        barsArr[2].style.transform = '';

        toggleBtn.dataset.state = 'closed';
        toggleBtn.style.zIndex = '';
        toggleBtn.style.position = '';
        toggleBtn.style.top = '';
        toggleBtn.style.left = '';
        burgerMenu.classList.remove('menu_opened');
      } else if (activeMenu === 'user') {
        toggleBtns.dataset.state = 'closed';
        toggleBtns.style.zIndex = '';
        toggleBtns.style.position = '';
        toggleBtns.style.top = '';
        toggleBtns.style.left = '';
        userMenu.classList.remove('menu_opened');
      }
      overlay.remove();
      activeMenu = null;

      if (categoriesIsActive) {
        separator.style.display = 'none';
        categoriesMenu.style.display = 'none';
        categoriesIsActive = false;
      }
    }

    // Toggle burger menu open/close
    toggleBtn.addEventListener('click', function() {
      if (toggleBtn.dataset.state === 'closed') {
        openMenu('burger');
      } else {
        closeMenu();
      }
    });

    // Toggle user menu open/close
    toggleBtns.addEventListener('click', function() {
      if (toggleBtns.dataset.state === 'closed') {
        openMenu('user');
      } else {
        closeMenu();
      }
    });

    // Close menu when clicking on the overlay
    overlay.addEventListener('click', closeMenu);

    // Prevent default link behavior on categories button
    categoriesBtn.addEventListener('click', (e) => {
      e.preventDefault();
    });

    // Show categories submenu on hover
    categoriesBtn.addEventListener('mouseenter', () => {
      separator.style.display = 'block';
      categoriesMenu.style.display = 'grid';
      categoriesIsActive = true;
    });

    // Hide submenu if mouse leaves the button and submenu is not hovered
    categoriesBtn.addEventListener('mouseleave', () => {
      setTimeout(() => {
        if (!categoriesMenu.matches(':hover')) {
          separator.style.display = 'none';
          categoriesMenu.style.display = 'none';
          categoriesIsActive = false;
        }
      }, 100);
    });

    // Hide submenu when mouse leaves the submenu
    categoriesMenu.addEventListener('mouseleave', () => {
      separator.style.display = 'none';
      categoriesMenu.style.display = 'none';
      categoriesIsActive = false;
    });

    // Ensure submenu stays visible while hovering over it
    categoriesMenu.addEventListener('mouseenter', () => {
      separator.style.display = 'block';
      categoriesMenu.style.display = 'grid';
      categoriesIsActive = true;
    });
  })();

  // Toggle 'active' class for profile menu buttons
  const buttons = document.querySelectorAll('.user_profile .list-group-item');
  buttons.forEach(function(button) {
    button.addEventListener('click', function() {
      if (this.classList.contains('active')) {
        this.classList.remove('active');
      } else {
        buttons.forEach(function(btn) {
          btn.classList.remove('active');
        });
        this.classList.add('active');
      }
    });
  });
});

// Rebuilds the category navigation menu from saved items
function resizeHeaderNavigations() {
  const maxWidth = document.documentElement.clientWidth;
  const minWidth = 330;
  const categories = document.getElementById('categories');
  const categoriesList = document.getElementById('categories-list');
  let NavItemsColection;

  if (resizeHeaderNavigations.clonedCollection) {
    NavItemsColection = resizeHeaderNavigations.clonedCollection;
    categoriesList.innerHTML = '';

    while (NavItemsColection.length > 0) {
      categoriesList.appendChild(NavItemsColection[0]);
    }
  }
}

// Display selected image as background and submit the form automatically
function previewImage(event) {
  var reader = new FileReader();
  reader.onload = function() {
    var button = document.getElementById('uploadButton');
    button.style.backgroundImage = "url('" + reader.result + "')";
    button.classList.add('with-preview');
    button.innerText = '';
    document.getElementById('uploadForm').submit();
  }
  reader.readAsDataURL(event.target.files[0]);
}

document.addEventListener('DOMContentLoaded', function () {
  const hiddenForm = document.getElementById('hiddenPostForm');

  // Exit if form does not exist
  if (!hiddenForm){
    console.log('net formy');
    return;
  }

  // Intercept link clicks and submit them through hidden form (except categories)
  document.querySelectorAll('a').forEach(link => {
    if (link.id !== 'categories-btn') {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        hiddenForm.action = this.href;
        hiddenForm.submit();
      });
    }
  });
});

//--------------------------------------------------------------------------------------------------------------------------------------------------------//
/*
function removeAdd(){
  document.body.children[document.body.children.length-1].remove();
  document.body.children[document.body.children.length-1].remove();
}*/