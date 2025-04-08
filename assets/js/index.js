window.onresize = () => {
  resizeHeaderNavigations();
}

document.addEventListener("DOMContentLoaded", () => {
  //removeAdd();
  (function(){
    const overlay = document.createElement('div');
    const categoriesBtn = document.getElementById('categories-btn');
    const separator = document.querySelector('.menu__separator');
    const categoriesMenu = document.querySelector('.menu__categories');
    const toggleBtn = document.querySelector('.toggle-btn');
    const toggleBtns = document.querySelector('.toggle-btns');
    const onToggleMenuHadler = function() {
      const barsArr = Array.from(document.querySelectorAll('.toggle-btn__bar'));
      const menu = document.getElementById('burger-menu');
      const coordinates = toggleBtn.getBoundingClientRect();

      if (this.dataset.state === 'closed') {
        const angleRadian = 24 / 48;
        const angleDeg = Math.atan(angleRadian) * 180 / Math.PI;
        const transformWidth = Math.sqrt(48 * 48 + 24 * 24);
        
        barsArr[1].style.opacity = 0;
        barsArr[0].style.width = transformWidth+'px';
        barsArr[0].style.transform = `rotate(${angleDeg}deg)`;
        barsArr[2].style.width = transformWidth+'px';
        barsArr[2].style.transform = `rotate(-${angleDeg}deg)`;
        toggleBtn.dataset.state = 'opened'
        toggleBtn.style.zIndex = '2';
        toggleBtn.style.position = 'fixed';
        toggleBtn.style.top = coordinates.top + 'px';
        toggleBtn.style.left = coordinates.left + 'px';
        menu.classList.add('menu_opened');
        document.body.append(overlay);    
      }
      else {
        barsArr[1].style.opacity = "";
        barsArr[0].style.width = "";
        barsArr[0].style.transform = "";
        barsArr[2].style.width = "";
        barsArr[2].style.transform = "";
        toggleBtn.dataset.state = 'closed'
        toggleBtn.style.zIndex = '';
        toggleBtn.style.position = '';
        toggleBtn.style.top = '';
        toggleBtn.style.left = '';
        menu.classList.remove('menu_opened');
        overlay.remove();

        if (categoriesIsActive) {
          separator.style.display = 'none';
          categoriesMenu.style.display = 'none';
          categoriesIsActive = false;
        }
      }
    };
    const onToggleMenuHadlers = function() {
      const menu = document.getElementById('user-menu');

      if (this.dataset.state === 'closed') {
        toggleBtns.dataset.state = 'opened'
        toggleBtns.style.zIndex = '2';
        menu.classList.add('menu_opened');
        document.body.append(overlay);
      }
      else {
        toggleBtns.dataset.state = 'closed'
        toggleBtns.style.zIndex = '';
        toggleBtns.style.position = '';
        toggleBtns.style.top = '';
        toggleBtns.style.left = '';
        menu.classList.remove('menu_opened');
        overlay.remove();

        if (categoriesIsActive) {
          console.log (3);
          separator.style.display = 'none';
          categoriesMenu.style.display = 'none';
          categoriesIsActive = false;
        }
      }
    };
    let categoriesIsActive = false;

    overlay.classList.add('overlay');
    resizeHeaderNavigations();

    toggleBtn.addEventListener('click',onToggleMenuHadler);
    overlay.addEventListener('click', onToggleMenuHadler);

    toggleBtns.addEventListener('click',onToggleMenuHadlers);
    overlay.addEventListener('click', onToggleMenuHadlers);

    categoriesBtn.onclick = function () {
      if (categoriesIsActive) {
        separator.style.display = 'none';
        categoriesMenu.style.display = 'none';
      } else {
        separator.style.display = 'block';
        categoriesMenu.style.display = 'grid';
      }

      categoriesIsActive = !categoriesIsActive;
    };
  })();
  var buttons = document.querySelectorAll('.user_profile .list-group-item');

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
function previewImage(event) {
  var reader = new FileReader();
  reader.onload = function() {
    var button = document.getElementById('uploadButton');
    button.style.backgroundImage = "url('" + reader.result + "')";
    button.classList.add('with-preview'); // Add class for styles with background image
    button.innerText = ''; // clear text in label

    // Отправляем форму на сервер
    document.getElementById('uploadForm').submit();
  }
  reader.readAsDataURL(event.target.files[0]);
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------//
/*
function removeAdd(){
  document.body.children[document.body.children.length-1].remove();
  document.body.children[document.body.children.length-1].remove();
}*/