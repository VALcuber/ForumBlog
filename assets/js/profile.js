document.addEventListener('DOMContentLoaded', function () {
    // Search buttons
    const blogButton = document.querySelector('#p\\.b\\.blog');
    const forumButton = document.querySelector('#p\\.b\\.forum');

    // Search container for content
    const infoContainer = document.getElementById('infoContainer');

    // Variables for  tracking current content display
    let currentContent = null;

    // Receive data from hidden area
    const blogData = document.getElementById('hiddenblogData').value;
    const forumData = document.getElementById('hiddenforumData').value;

    // Handler for button BLOG
    blogButton.addEventListener('click', function() {
        //console.log("BLOG button clicked");

        if (currentContent === 'blog') {
            // If we show already content - then hide it
            infoContainer.innerHTML = '';
            currentContent = null;
            //console.log("BLOG content hidden");
        } else {
            // If we don't show content - then show it
            infoContainer.innerHTML = `<div class="info-box-blog">${blogData}</div>`;
            currentContent = 'blog';
            //console.log("BLOG content displayed");
        }
    });

    // Handler for button FORUM
    forumButton.addEventListener('click', function() {
        //console.log("FORUM button clicked");

        if (currentContent === 'forum') {
            // If we show already content - then hide it
            infoContainer.innerHTML = '';
            currentContent = null;
           //console.log("FORUM content hidden");
        } else {
            // If we don't show content - then show it
            infoContainer.innerHTML = `<div class="info-box-forum">${forumData}</div>`;
            currentContent = 'forum';
            //console.log("FORUM content displayed");
        }
    });
});
