const AdminPanelMenu = document.getElementById('actions-panel');
const AdminPanelMenuItems = Array.from(document.getElementById('actions-panel').children);
const adminContainer = document.getElementById('admin-container');
const templatesMap = innitTemplates();


AdminPanelMenu.addEventListener('click',function(event){
  const target = event.target;

  AdminPanelMenuItems.forEach(el => {
    el.classList.remove('bg-secondary');
    el.classList.remove('text-white');
  });

  target.classList.add('bg-secondary');
  target.classList.add('text-white');
  adminContainer.lastElementChild.innerHTML = templatesMap.get(target.dataset.action);
}); 

function removeAdd(){
  document.body.children[document.body.children.length-1].remove();
  document.body.children[document.body.children.length-1].remove();
}


