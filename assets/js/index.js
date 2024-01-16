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
      } else {
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
    let categoriesIsActive = false;

    overlay.classList.add('overlay');
    resizeHeaderNavigations();

    toggleBtn.addEventListener('click',onToggleMenuHadler);
    overlay.addEventListener('click', onToggleMenuHadler);

    document.getElementById('signinModal').onclick = function(e){
      if(e.target.classList.contains('btn') && e.target.innerHTML === 'Log In'){
        $('#signinModal').modal('show');
        setTimeout(()=>{
          $('#registrationModal').modal('hide');
        },300)
      }
    }

    document.getElementById('registrationModal').onclick = function(e){
      if(e.target.classList.contains('btn') && e.target.innerHTML === 'Registration'){
        $('#registrationModal').modal('show');
        setTimeout(()=>{
          $('#signinModal').modal('show');

        },300)
      }
    }

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
});

/*function removeAdd(){
  document.body.children[document.body.children.length-1].remove();
  document.body.children[document.body.children.length-1].remove();
}*/

function resizeHeaderNavigations() {
  const maxWidth = document.documentElement.clientWidth;
  const minWidth = 330;
  const categories = document.getElementById('categories');
  const categoriesList = document.getElementById('categories-list');
  let NavItemsColection;
  
  if(resizeHeaderNavigations.clonedCollection) {
    NavItemsColection = resizeHeaderNavigations.clonedCollection;
    categoriesList.innerHTML = '';

    while(NavItemsColection.length > 0) {
      categoriesList.appendChild(NavItemsColection[0]);
    }
  }
  
  NavItemsColection = categoriesList.children;
  resizeHeaderNavigations.clonedCollection = categoriesList.cloneNode(true).children;

  while(categories.offsetWidth > maxWidth) {
    if(categories.offsetWidth <= minWidth) {
      break;
    }
    NavItemsColection[NavItemsColection.length - 2].remove();
  }
}