<main class="main" xmlns="http://www.w3.org/1999/html">

    <div class="container-fluid wrapper bg-white">

      <div class="row px-4">

          <div class="user_image">

              <form id="uploadForm" method="post" action="/user_profile" enctype="multipart/form-data">
                  <!-- Button for upload image -->
                  <label for="file-upload" id="uploadButton" class="user_image custom-upload-button header__profile d-flex align-items-center justify-content-center rounded-circle"><?= $pageData['check'] ?></label>
                  <!-- Hidden element input, which we use to upload file -->
                  <input id="file-upload" type="file" name="image" accept="image/*" onchange="previewImage(event)">
              </form>

          </div>
          <ul class="user_profile col-6 align-items-center list-group list-group-horizontal">

                  <li class="user-profile_li">
                      <button class="col d-flex justify-content-center list-group-item">SETTINGS</button>
                  </li>

                  <li class="user-profile_li">
                      <button class="col d-flex justify-content-center list-group-item">MESSAGES</button>
                  </li>

                  <li class="user-profile_li">
                      <input type="hidden" id="hiddenblogData" value="<?=htmlspecialchars($pageData['user_blog_posts'], ENT_QUOTES, 'UTF-8')?>">
                      <button id="p.b.blog" class="col d-flex justify-content-center list-group-item">BLOG</button>
                  </li>

                  <li class="user-profile_li">
                      <input type="hidden" id="hiddenforumData" value="<?=htmlspecialchars($pageData['user_forum_posts'], ENT_QUOTES, 'UTF-8')?>">
                      <button id="p.b.forum" class="col d-flex justify-content-center list-group-item">FORUM</button>
                  </li>

                  <li class="user-profile_li">
                      <button class="col d-flex justify-content-center list-group-item">FRIENDS</button>
                  </li>
          </ul>
          <div id="infoContainer" class="info-container"></div>
      </div>

    </div>
  </main>
