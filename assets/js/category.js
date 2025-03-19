document.addEventListener('DOMContentLoaded', () => {
  const toggleBtn = document.querySelector('.btn-add'); // Кнопка, которая будет открывать меню
  const addArticleMenu = document.querySelector('.add-article-menu'); // Меню
  const closeMenuBtn = document.querySelector('.add-article-menu__close-btn'); // Кнопка для закрытия меню

  // Функция для вычисления координат кнопки
  const getBtnCoordinates = function() {
    let elem = toggleBtn;
    const coordinates = { top: 0, left: 0 };

    do {
      if (!isNaN(elem.offsetLeft)) coordinates.left += elem.offsetLeft;
      if (!isNaN(elem.offsetTop)) coordinates.top += elem.offsetTop;
    } while (elem = elem.offsetParent);

    return coordinates;
  };

  // Обработчик клика для открытия и закрытия меню
  const toggleMenuHandler = () => {
    addArticleMenu.classList.toggle('add-article-menu_open'); // Открыть/закрыть меню

    // Позиционируем меню
    if (addArticleMenu.classList.contains('add-article-menu_open')) {
      const coord = getBtnCoordinates();
      const modalMenuIndentation = 4;

      // Позиционируем меню относительно кнопки
      addArticleMenu.style.top = coord.top + toggleBtn.offsetHeight + modalMenuIndentation + 'px';
      addArticleMenu.style.left = coord.left - addArticleMenu.offsetWidth + toggleBtn.offsetWidth / 2 + 'px';
    }
  };

  // Обработчик клика по кнопке для открытия/закрытия меню
  toggleBtn.addEventListener('click', (event) => {
    event.stopPropagation(); // Не даём событию распространяться на другие элементы
    toggleMenuHandler(); // Переключаем видимость меню
  });

  // Обработчик закрытия меню
  closeMenuBtn.addEventListener('click', (event) => {
    addArticleMenu.classList.remove('add-article-menu_open'); // Закрываем меню
  });

  // Закрыть меню, если кликнули вне меню и кнопки
  document.addEventListener('click', (event) => {
    if (!addArticleMenu.contains(event.target) && !toggleBtn.contains(event.target)) {
      addArticleMenu.classList.remove('add-article-menu_open'); // Закрываем меню
    }
  });
});
