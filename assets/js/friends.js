document.addEventListener('DOMContentLoaded', () => {
    const userItems = document.querySelectorAll('.user-item');
    const defaultMessage = document.getElementById('defaultMessage');
    const infoContent = document.getElementById('InfoContent');
    let currentRequest = null; // used to cancel an unfinished request

    userItems.forEach(item => {
        item.addEventListener('click', function () {
            const friendId = this.getAttribute('data-user-id');

            if (!friendId) return;

            // Highlight selected item
            userItems.forEach(el => el.classList.remove('active'));
            this.classList.add('active');

            // Hide placeholder text "Please choose friend"
            if (defaultMessage) {
                defaultMessage.style.display = 'none';
                defaultMessage.style.setProperty('display', 'none', 'important');
            }

            infoContent.innerHTML = '<div class="text-center mt-3"><em>Loading profile...</em></div>';

            // Cancel the previous request if it has not finished yet
            if (currentRequest) currentRequest.abort();
            currentRequest = new AbortController();

            // Exact route path to handle AJAX
            fetch(`/user_profile/friends?ajax=get_friend_info&friends_id=${friendId}`, {
                signal: currentRequest.signal
            })
                .then(async response => {
                    const text = await response.text();
                    try {
                        return JSON.parse(text);
                    } catch (err) {
                        console.error('Server returned non-JSON response:', text);
                        throw new Error('Invalid JSON format');
                    }
                })
                .then(response => {
                    infoContent.innerHTML = '';

                    if (response.status === 'success' && response.html) {
                        // Profile HTML is already built and escaped in PHP
                        infoContent.innerHTML = response.html;
                    } else {
                        infoContent.innerHTML = '<div class="alert alert-warning m-3">Friend profile not found.</div>';
                    }
                })
                .catch(error => {
                    if (error.name === 'AbortError') return; // request was cancelled on purpose
                    console.error('AJAX Error:', error);
                    infoContent.innerHTML = '<div class="alert alert-danger m-3">Failed to load friend profile.</div>';
                });
        });
    });

    // Click on empty space: reset the selection and show "Please choose friend" again
    document.addEventListener('click', (e) => {
        // A click on a friend or on the profile itself does not reset the selection
        if (e.target.closest('.user-item') || e.target.closest('#InfoContent > *')) return;

        if (currentRequest) currentRequest.abort();

        userItems.forEach(el => el.classList.remove('active'));
        infoContent.innerHTML = '';

        if (defaultMessage) {
            defaultMessage.style.display = ''; // restore the display style defined by the CSS classes
        }
    });
});