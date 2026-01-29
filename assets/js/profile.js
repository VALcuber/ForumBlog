document.addEventListener('DOMContentLoaded', function () {
    // Find the buttons
    const blogButton = document.querySelector('#p\\.b\\.blog');
    const forumButton = document.querySelector('#p\\.b\\.forum');
    const messagesButton = document.querySelector('#p\\.b\\.messages');

    // Find the container for the content
    const infoContainer = document.getElementById('infoContainer');

    // Get hidden input values (data from PHP)
    const blogData = document.getElementById("hiddenblogData").value;
    const forumData = document.getElementById("hiddenforumData").value;
    const messagesData = document.getElementById("hiddenmessagesData").value;

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
            infoBox.classList.add(type === 'blog' ? 'info-box-blog' : (type === 'messages' ? 'info-box-messages' : 'info-box-forum'));
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

    messagesButton.addEventListener('click', function (event) {
        event.stopPropagation(); // Prevent event from bubbling up
        toggleContent('messages', messagesData); // Load real messages data
    });

    // Close info box when clicking outside of it
    document.addEventListener('click', function (event) {
        if (currentBox && !infoContainer.contains(event.target) && event.target !== blogButton && event.target !== forumButton && event.target !== messagesButton) {
            hideAllInfoBoxes();
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var adminToggle = document.getElementById('adminPanelToggle');
    if (adminToggle) {
        // Set slider state from cookie
        var matches = document.cookie.match(/(?:^|; )admin_panel=([^;]*)/);
        if (matches && matches[1] === '1') {
            adminToggle.checked = true;
        } else {
            adminToggle.checked = false;
        }
        // Save state to cookie when changed
        adminToggle.addEventListener('change', function() {
            // You can add reload if needed: location.reload();
            if (this.checked) {
                showPanel();
            } else {
                hidePanel();
            }
        });
    }
});
