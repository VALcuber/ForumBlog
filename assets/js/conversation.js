document.addEventListener('DOMContentLoaded', () => {
    const usersList = document.getElementById('usersList');
    const chatroomCard = document.getElementById('chatroomCard');
    const chatContent = document.getElementById('chatContent');
    const sendBtn = document.getElementById('sendBtn');
    const messageInput = document.getElementById('messageInput');

    // Function to load messages (extracted to avoid duplication)
    async function loadConversation(item) {
        const otherId = item.dataset.userId;
        const userName = item.dataset.user;

        // UI: Show loading only if the container is empty (first load)
        if (chatContent.innerHTML === '') {
            chatContent.innerHTML = '<div class="text-center mt-3"><em>Loading...</em></div>';
        }

        try {
            const response = await fetch(`/user_profile/messages?ajax=get_conversation&other_id=${otherId}`);
            if (!response.ok) throw new Error('Server returned ' + response.status);

            const data = await response.json();

            // Remove bold only AFTER successful data fetch
            const strongTag = item.querySelector('strong');
            if (strongTag) {
                strongTag.replaceWith(strongTag.innerText);
            }

            // Remove the "new message" dot as well
            const dot = item.querySelector('.new-message-dot');
            if (dot) {
                dot.remove();
            }

            chatContent.innerHTML = '';

            if (data.messages.length === 0) {
                chatContent.innerHTML = '<div class="text-center text-muted mt-3">No messages yet.</div>';
            } else {
                data.messages.forEach(msg => {
                    const isMe = msg.sender_id == data.current_user_id;
                    const msgHtml = `
                        <div class="d-flex mb-3 ${isMe ? 'justify-content-end' : ''}">
                            <div class="p-2 rounded ${isMe ? 'bg-primary text-white' : 'bg-light'} " style="max-width: 80%;">
                                <small class="d-block border-bottom mb-1 ${isMe ? 'text-white-50' : 'text-muted'}">
                                    ${isMe ? 'Me' : userName}
                                </small>
                                <div>${msg.content}</div>
                            </div>
                        </div>`;
                    chatContent.insertAdjacentHTML('beforeend', msgHtml);
                });
            }
            chatContent.scrollTop = chatContent.scrollHeight;
        } catch (error) {
            console.error('Chat Error:', error);
            chatContent.innerHTML = '<div class="alert alert-danger m-3">Failed to load messages.</div>';
        }
    }

    // Handle user selection
    usersList.addEventListener('click', async e => {
        const item = e.target.closest('.user-item');
        if (!item) return;

        // If already active, just refresh content without resetting UI
        if (item.classList.contains('active')) {
            loadConversation(item);
            return;
        }

        document.querySelectorAll('.user-item').forEach(u => u.classList.remove('active'));
        item.classList.add('active');
        chatroomCard.classList.add('chat-open');

        chatContent.innerHTML = ''; // Clear for new user
        loadConversation(item);
    });

    // Handle message sending
    sendBtn.addEventListener('click', async (e) => { // Added 'e' here
        e.stopPropagation(); // Now 'e' is defined and won't crash

        const content = messageInput.value.trim();
        const activeUser = document.querySelector('.user-item.active');

        if (!content || !activeUser) return;

        const receiverId = activeUser.dataset.userId;
        const formData = new FormData();
        formData.append('ajax', 'send_message');
        formData.append('receiver_id', receiverId);
        formData.append('content', content);

        try {
            const response = await fetch('/user_profile/messages', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.status === 'success') {
                messageInput.value = '';
                // Refresh specifically for the active user
                loadConversation(activeUser);
            }
        } catch (err) {
            console.error('Send error:', err);
        }
    });

    // Send on Enter
    messageInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendBtn.click();
        }
    });

    // Handle clicks outside the chat area to close it
    document.addEventListener('click', e => {
        // English comment: Check if the click was on the send button or input field
        const isInput = e.target.closest('#messageInput');
        const isBtn = e.target.closest('#sendBtn');
        const isChatCard = e.target.closest('#chatroomCard');
        const isUserList = e.target.closest('#usersList');

        // English comment: If the click is NOT on any of these elements, then close
        if (!isChatCard && !isUserList && !isInput && !isBtn) {
            chatroomCard.classList.remove('chat-open');
            document.querySelectorAll('.user-item').forEach(u => u.classList.remove('active'));
        }
    });

    // Live update: periodically ask the server for a fresh inbox list.
    // PHP builds the HTML (including the unread dots), JS only redraws it and keeps the selected user active.
    const POLL_INTERVAL_MS = 2000; // how often to check for new messages
    let pollInFlight = false;
    let lastInboxHtml = null;      // last HTML received from the server

    async function refreshInbox() {
        // Skip when the tab is hidden or the previous request is still running
        if (document.hidden || pollInFlight) return;
        pollInFlight = true;

        try {
            const response = await fetch('/user_profile/messages?ajax=get_inbox');
            if (!response.ok) return;

            const data = await response.json();
            if (data.status !== 'success') return;

            // Nothing changed since the last check: do not touch the DOM
            if (data.html === lastInboxHtml) return;
            lastInboxHtml = data.html;

            const active = usersList.querySelector('.user-item.active');
            const activeId = active ? active.dataset.userId : null;

            usersList.innerHTML = data.html;

            // Restore the selection after the list was redrawn
            if (activeId) {
                const restored = usersList.querySelector(`.user-item[data-user-id="${activeId}"]`);
                if (restored) restored.classList.add('active');
            }
        } catch (err) {
            console.error('Inbox refresh error:', err);
        } finally {
            pollInFlight = false;
        }
    }

    setInterval(refreshInbox, POLL_INTERVAL_MS);

    // Check right away when the user returns to this tab
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden) refreshInbox();
    });

    // Opened from the profile page: open the conversation marked by PHP (data-selected="1")
    const preselected = usersList.querySelector('.user-item[data-selected="1"]');
    if (preselected) {
        preselected.click();
    }
});