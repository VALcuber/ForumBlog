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
        //toggleBtns.style.position = 'fixed';
        //toggleBtns.style.top = coordinates.top + 'px';
        //toggleBtns.style.left = coordinates.left + 'px';
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
//function for changing user logo
function previewImage(event) {
  var reader = new FileReader();
  reader.onload = function() {
    var button = document.getElementById('uploadButton');
    button.style.backgroundImage = "url('" + reader.result + "')";
    button.classList.add('with-preview'); // Add class for styles with background image
    button.innerText = ''; // clear text in label

    // Отменяем стандартное действие браузера по умолчанию для отправки формы
    event.preventDefault();

    // Отправляем форму на сервер
    var formData = new FormData(document.getElementById('uploadForm'));
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/user_profile', true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        alert('File uploaded successfully!');
      } else {
        alert('Error uploading file!');
      }
    };
    xhr.send(formData);
  };

  reader.readAsDataURL(event.target.files[0]);
}

//Send form after choosing file automatically


//--------------------------------------------------------------------------------------------------------------------------------------------------------//
/*
function removeAdd(){
  document.body.children[document.body.children.length-1].remove();
  document.body.children[document.body.children.length-1].remove();
}*/

//----------------------------------------------------------------------------//

/*
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
*/
//------------------------------------------------------------------------------------//
//from resizeHeaderNavigations
/*
NavItemsColection = categoriesList.children;
resizeHeaderNavigations.clonedCollection = categoriesList.cloneNode(true).children;

while(categories.offsetWidth > maxWidth) {
  if(categories.offsetWidth <= minWidth) {
    break;
  }
  NavItemsColection[NavItemsColection.length - 2].remove();
}*/