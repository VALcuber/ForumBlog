<h2>Настройки сайта</h2>

<?php if(isset($_GET['success']) && $_GET['success'] == '1'): ?>
    <div class="alert alert-success" role="alert">
        <i class="fas fa-check-circle"></i> Settings saved successfully!
    </div>
    <script>
        // Clear URL parameters
        history.replaceState({}, document.title, window.location.pathname);
        
        // Automatically hide message after 3 seconds
        setTimeout(function() {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            }
        }, 3000);
    </script>
<?php endif; ?>

<form method="post" action="/settings" enctype="multipart/form-data">
  <fieldset>
    <legend>Основные</legend>
    <label>Название сайта: <input type="text" name="site_title" value="<?=$pageData['settings']['site']['title']?>"></label><br>
    <label>Режим обслуживания: <input type="checkbox" name="maintenance_mode" <?= $pageData['settings']['site']['maintenance_mode'] ? 'checked' : '' ?>></label><br>
    <label>Язык по умолчанию: <input type="text" name="default_language" value="<?=$pageData['settings']['site']['default_language']?>"></label><br>
    <label>Email: <input type="email" name="contact_email" value="<?=$pageData['settings']['site']['contact_email']?>"></label><br>
    <label>Приветствие: <textarea name="welcome_message"><?=$pageData['settings']['site']['welcome_message']?></textarea></label><br>
    <label>Регистрация: <input type="checkbox" name="registration_enabled" <?= $pageData['settings']['site']['registration_enabled'] ? 'checked' : '' ?>></label><br>
    <label>Логотип: <input type="file" name="site_logo"></label><br>
    <label>Favicon: <input type="file" name="site_favicon"></label><br>
  </fieldset>

  <fieldset>
    <legend>Категории</legend>
    <label>Сортировка: 
      <select name="categories_sort_order">
        <option value="asc" <?= $pageData['settings']['categories']['sort_order']=='asc'?'selected':'' ?>>По возрастанию</option>
        <option value="desc" <?= $pageData['settings']['categories']['sort_order']=='desc'?'selected':'' ?>>По убыванию</option>
      </select>
    </label><br>
    <label>Показывать пустые: <input type="checkbox" name="categories_show_empty" <?= $pageData['settings']['categories']['show_empty']?'checked':'' ?>></label><br>
    <label>Макс. глубина: <input type="number" name="categories_max_depth" value="<?=$pageData['settings']['categories']['max_depth']?>"></label><br>
  </fieldset>

  <!-- Similarly for other sections: moderation, news, files, seo, security, backup, theme -->

  <button type="submit">Сохранить</button>
</form>