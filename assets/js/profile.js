document.addEventListener('DOMContentLoaded', function () {
    // Find the buttons
    const blogButton = document.querySelector('#p\\.b\\.blog');
    const forumButton = document.querySelector('#p\\.b\\.forum');

    // Find the container for the content
    const infoContainer = document.getElementById('infoContainer');

    // Get hidden input values (data from PHP)
    const blogData = document.getElementById("hiddenblogData").value;
    const forumData = document.getElementById("hiddenforumData").value;

    // Variable to track currently displayed info box
    let currentBox = null;

    // Function to hide all info boxes
    function hideAllInfoBoxes() {
        if (currentBox) {
            currentBox.remove(); // Remove only the currently active box
            currentBox = null;
        }
    }

    // Function to toggle content display
    function toggleContent(type, content) {
        if (currentBox && currentBox.dataset.type === type) {
            hideAllInfoBoxes(); // If the same box is open, hide it
        } else {
            hideAllInfoBoxes();
            let infoBox = document.createElement("div");
            infoBox.classList.add(type === 'blog' ? 'info-box-blog' : 'info-box-forum');
            infoBox.innerHTML = content;
            infoBox.dataset.type = type; // Store the type to track state
            infoContainer.appendChild(infoBox);
            infoBox.style.display = 'grid';
            currentBox = infoBox;
        }
    }

    // Event listeners for buttons
    blogButton.addEventListener('click', function (event) {
        event.stopPropagation(); // Prevent event from bubbling up
        toggleContent('blog', blogData); // Load real blog data
    });

    forumButton.addEventListener('click', function (event) {
        event.stopPropagation(); // Prevent event from bubbling up
        toggleContent('forum', forumData); // Load real forum data
    });

    // Close info box when clicking outside of it
    document.addEventListener('click', function (event) {
        if (currentBox && !infoContainer.contains(event.target) && event.target !== blogButton && event.target !== forumButton) {
            hideAllInfoBoxes();
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var adminToggle = document.getElementById('adminPanelToggle');
    if (adminToggle) {
        // Установить состояние слайдера из cookie
        var matches = document.cookie.match(/(?:^|; )admin_panel=([^;]*)/);
        if (matches && matches[1] === '1') {
            adminToggle.checked = true;
        } else {
            adminToggle.checked = false;
        }
        // Сохранять состояние в cookie при изменении
        adminToggle.addEventListener('change', function() {
            document.cookie = 'admin_panel=' + (this.checked ? '1' : '0') + '; path=/';
            // Можно добавить перезагрузку, если нужно: location.reload();
        });
    }
});
