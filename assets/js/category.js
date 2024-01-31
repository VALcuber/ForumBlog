
const toggleBtn = document.querySelector('.btn-add');

const addArticleMenu = document.querySelector('.add-article-menu');

const closeMenuBtn = document.querySelector('.add-article-menu__close-btn');

const getBtnCoordinates = function(){
  let elem = toggleBtn;
  const coordinates = {
    top: 0,
    left: 0
  };

  do {
    if (!isNaN(elem.offsetLeft)) {
      coordinates.left += elem.offsetLeft;
    }

    if (!isNaN(elem.offsetTop)) {
      coordinates.top += elem.offsetTop;
    }
  }
  while (elem = elem.offsetParent);

  return coordinates;
};

const toggleMenuHandler  = () => {
  addArticleMenu.classList.toggle('add-article-menu_open');

  if (addArticleMenu.classList.contains('add-article-menu_open')) {
    const coord = getBtnCoordinates();
    const modalMenuIndentation = 4;

    addArticleMenu.style.top = coord.top + toggleBtn.offsetHeight + modalMenuIndentation +'px';
    addArticleMenu.style.left = coord.left - addArticleMenu.offsetWidth +toggleBtn.offsetWidth/2 + 'px';
  }
};

const windowResizeHandler = () => {
  if (addArticleMenu.classList.contains('add-article-menu_open')) {
    const coord = getBtnCoordinates();
    const modalMenuIndentation = 4;

    addArticleMenu.style.top = coord.top + toggleBtn.offsetHeight + modalMenuIndentation + 'px';
    addArticleMenu.style.left = coord.left - addArticleMenu.offsetWidth + toggleBtn.offsetWidth/2 +'px';
  }
};

toggleBtn.onclick = toggleMenuHandler;
closeMenuBtn.onclick = toggleMenuHandler;
window.onresize = windowResizeHandler;

