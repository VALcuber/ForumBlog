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

function innitTemplates(){
  const templatesMap = new Map();

  templatesMap.set('news',
  `<h2 class="text-center mb-4">News</h2>
  <form method="post">
    <div class="form-group row">
      <label for="title" class="col-3 col-form-label font-weight-bold">Title</label>
      <div class="col-9">
        <input type="text" id ="title" name="title" class="form-control" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="description" class="col-3 col-form-label font-weight-bold">Description</label>
      <div class="col-9">
        <textarea name="description" id="description" rows="10" class="form-control" required></textarea>
      </div>
    </div>
    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-secondary mr-4">Cancel</button>
      <input type="submit" name="act" value="Post" class="btn btn-primary">
    </div>
  </form>`);
  templatesMap.set('blog',
  `<h2 class="text-center mb-4">Blog</h2>
  <form method="post">
    <div class="form-group row">
      <label for="title" class="col-3 col-form-label font-weight-bold">Title</label>
      <div class="col-9">
        <input type="text" id ="title" name="title" class="form-control" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="description" class="col-3 col-form-label font-weight-bold">Description</label>
      <div class="col-9">
        <textarea name="description" id="description" rows="10" class="form-control" required></textarea>
      </div>
    </div>
    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-secondary mr-4">Cancel</button>
      <input type="submit" name="blog_form" value="Post" class="btn btn-primary">
    </div>
  </form>`);
  templatesMap.set('forum',`
  <h2 class="text-center mb-4">Forum topic</h2>
  <form method="post">
    <div class="form-group row">
      <label for="title" class="col-3 col-form-label font-weight-bold">Title</label>
      <div class="col-9">
        <input type="text" id ="title" name="title" class="form-control" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="description" class="col-3 col-form-label font-weight-bold">Description</label>
      <div class="col-9">
        <textarea name="description" id="description" rows="10" class="form-control" required></textarea>
      </div>
    </div>
    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-secondary mr-4">Cancel</button>
      <input type="submit" name="forum_form" value="Post" class="btn btn-primary">
    </div>
  </form>
  `);
  
  return templatesMap;
}