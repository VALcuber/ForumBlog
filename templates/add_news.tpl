<div class="col-12 p-3 main news">
    <h2 class="text-center mb-4">Adding News</h2>
    
    <?php if(isset($pageData['success_message'])): ?>
        <div class="alert alert-success text-center" role="alert">
            <i class="fas fa-check-circle"></i> <?= $pageData['success_message'] ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group row d-flex justify-content-center">
            <div class="col-9">
                <input type="text" id ="title" name="title" class="form-control" placeholder="Title" required>
            </div>
        </div>
        <div class="form-group row d-flex justify-content-center">
            <div class="col-9">
                <textarea name="description" id="description" rows="10" class="form-control" placeholder="Description" required></textarea>
            </div>
        </div>
        <div class="d-flex justify-content-around">
            <button type="button" class="btn btn-secondary mr-4" onclick="window.location.href='/'">Cancel</button>
            <input type="submit" name="act" value="Post-NEWS" class="btn btn-primary">
        </div>
    </form>
</div>
<?php if(isset($pageData['clear_url_script'])): ?>
    <?= $pageData['clear_url_script'] ?>
<?php endif; ?>

<script>
// Automatically hide success message after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.querySelector('.alert-success');
    if (successMessage) {
        setTimeout(function() {
            successMessage.style.opacity = '0';
            setTimeout(function() {
                successMessage.remove();
            }, 300);
        }, 3000);
    }
});
</script>
