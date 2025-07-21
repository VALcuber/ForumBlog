<main class="main" xmlns="http://www.w3.org/1999/html">

    <div class="container-fluid wrapper bg-white">

      <div class="row px-4">

          <div class="user_image">
              <form id="uploadForm" method="post" action="/user_profile" enctype="multipart/form-data">
                  <label for="file-upload" id="uploadButton" class="user_image custom-upload-button header__profile d-flex align-items-center justify-content-center rounded-circle">
                      <?= $pageData['check'] ?>
                  </label>
                  <input id="file-upload" type="file" name="image" accept="image/*" onchange="previewImage(event)">
              </form>
              <?= $pageData['admin_panel_switch'] ?>
          </div>

          <div class="col d-flex flex-column">
              <div class="user_nickname col-2">
                  <h1><?= $pageData['nickname'] ?></h1>
              </div>

              <ul class="user_profile col-4 list-group list-group-horizontal">
                  <li class="user-profile_li">
                      <button class="list-group-item">SETTINGS</button>
                  </li>
                  <li class="user-profile_li">
                      <button class="list-group-item">MESSAGES</button>
                  </li>
                  <li class="user-profile_li">
                      <input type="hidden" id="hiddenblogData" value="<?=htmlspecialchars($pageData['user_blog_posts'], ENT_QUOTES, 'UTF-8')?>">
                      <button id="p.b.blog" class="list-group-item">BLOG</button>
                  </li>
                  <li class="user-profile_li">
                      <input type="hidden" id="hiddenforumData" value="<?=htmlspecialchars($pageData['user_forum_posts'], ENT_QUOTES, 'UTF-8')?>">
                      <button id="p.b.forum" class="list-group-item">FORUM</button>
                  </li>
                  <li class="user-profile_li">
                      <button class="list-group-item">FRIENDS</button>
                  </li>
              </ul>
          </div>
          <div id="infoContainer" class="info-container"></div>
      </div>

    </div>
  </main>
