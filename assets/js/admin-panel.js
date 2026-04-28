// Administrative Panel JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize all components
    initAdminPanel();
    initCharts();
    initAjaxHandlers();
    initUsersPagination();
    initMobileMenu();
    
});

// Main initialization
function initAdminPanel() {
    // Highlight active menu item
    highlightActiveMenuItem();
    
    // Initialize tooltips
    initTooltips();
    
    // Initialize modals
    initModals();
}

// Highlight active menu item
function highlightActiveMenuItem() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.admin-nav-link');
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
}

// Initialize tooltips
function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Initialize modals
function initModals() {
    const modalTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="modal"]'));
    modalTriggerList.map(function (modalTriggerEl) {
        return new bootstrap.Modal(modalTriggerEl);
    });
}

// Initialize charts
function initCharts() {
    // User activity chart
    const userActivityChart = document.getElementById('userActivityChart');
    if (userActivityChart) {
        new Chart(userActivityChart, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'New Users',
                    data: [12, 19, 3, 5, 2, 3, 7],
                    borderColor: '#0071b8',
                    backgroundColor: 'rgba(0, 113, 184, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    
    // Content chart
    const contentChart = document.getElementById('contentChart');
    if (contentChart) {
        new Chart(contentChart, {
            type: 'doughnut',
            data: {
                labels: ['Blog', 'Forum', 'Comments'],
                datasets: [{
                    data: [300, 150, 100],
                    backgroundColor: [
                        '#0071b8',
                        '#5cb85c',
                        '#f0ad4e'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    }
}

// Initialize AJAX handlers
function initAjaxHandlers() {
    const editUserBtns = document.querySelectorAll('.edit-user-btn');
    editUserBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            openEditUserModal(this);
        });
    });

    // User status change
    const statusSelects = document.querySelectorAll('.user-status-select');
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const userId = this.getAttribute('data-user-id');
            const status = this.value;
            updateUserStatus(userId, status);
        });
    });
    
    // Delete user buttons
    const deleteUserBtns = document.querySelectorAll('.delete-user-btn');
    deleteUserBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            if (confirm('Are you sure you want to delete this user?')) {
                deleteUser(userId);
            }
        });
    });
    
    // Delete content buttons
    const deleteContentBtns = document.querySelectorAll('.delete-content-btn');
    deleteContentBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const contentId = this.getAttribute('data-content-id');
            const contentType = this.getAttribute('data-content-type');
            if (confirm('Are you sure you want to delete this content?')) {
                deleteContent(contentId, contentType);
            }
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('userSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterUsersTable();
        });
    }

    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            filterUsersTable();
        });
    }

    const createUserBtn = document.getElementById('createUserBtn');
    if (createUserBtn) {
        createUserBtn.addEventListener('click', function() {
            createUser();
        });
    }

    const saveUserBtn = document.getElementById('saveUserBtn');
    if (saveUserBtn) {
        saveUserBtn.addEventListener('click', function() {
            updateUser();
        });
    }
}

const USERS_PER_PAGE = 12;
let usersCurrentPage = 1;
let currentEditUserId = null;
let usersSortKey = null;
let usersSortDirection = null;

function initUsersPagination() {
    if (!document.getElementById('usersPagination') || !document.querySelector('.user-row')) {
        return;
    }

    setInitialUsersOrder();
    initUsersSorting();
    filterUsersTable();
}

function setInitialUsersOrder() {
    const rows = Array.from(document.querySelectorAll('.user-row'));
    rows.forEach((row, index) => {
        row.dataset.initialOrder = String(index);
    });
}

function initUsersSorting() {
    const sortButtons = document.querySelectorAll('.user-sort-btn');
    sortButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nextKey = this.getAttribute('data-sort-key');

            if (usersSortKey !== nextKey) {
                usersSortKey = nextKey;
                usersSortDirection = 'asc';
            } else if (usersSortDirection === 'asc') {
                usersSortDirection = 'desc';
            } else {
                usersSortKey = null;
                usersSortDirection = null;
            }

            updateUsersSortButtons();
            renderUsersPage();
        });
    });

    updateUsersSortButtons();
}

function filterUsersTable() {
    const searchInput = document.getElementById('userSearch');
    const statusFilter = document.getElementById('statusFilter');
    const rows = Array.from(document.querySelectorAll('.user-row'));
    const searchTerm = searchInput ? searchInput.value.trim().toLowerCase() : '';
    const selectedStatus = statusFilter ? statusFilter.value.trim().toLowerCase() : '';

    rows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        const badge = row.querySelector('.badge');
        const rowStatus = badge ? badge.textContent.trim().toLowerCase() : '';
        const matchesSearch = searchTerm === '' || rowText.includes(searchTerm);
        const matchesStatus = selectedStatus === '' || rowStatus === selectedStatus;

        row.dataset.matchesFilter = matchesSearch && matchesStatus ? 'true' : 'false';
    });

    usersCurrentPage = 1;
    renderUsersPage();
}

function renderUsersPage() {
    const rows = Array.from(document.querySelectorAll('.user-row'));
    const matchedRows = rows
        .filter(row => row.dataset.matchesFilter !== 'false')
        .sort(compareUserRows);

    const totalPages = Math.ceil(matchedRows.length / USERS_PER_PAGE);
    const tbody = document.querySelector('tbody');
    let noUsersRow = Array.from(document.querySelectorAll('tbody tr')).find(row => row.classList.contains('users-empty-row'));

    if (tbody) {
        matchedRows.forEach(row => {
            tbody.appendChild(row);
        });
    }

    if (!noUsersRow && tbody) {
        noUsersRow = document.createElement('tr');
        noUsersRow.className = 'users-empty-row';
        noUsersRow.style.display = 'none';
        noUsersRow.innerHTML = '<td colspan="6" class="text-center text-muted">No users found</td>';
        tbody.appendChild(noUsersRow);
    }

    if (totalPages > 0 && usersCurrentPage > totalPages) {
        usersCurrentPage = totalPages;
    }

    rows.forEach(row => {
        row.style.display = 'none';
    });

    if (noUsersRow) {
        noUsersRow.style.display = matchedRows.length === 0 ? '' : 'none';
    }

    const start = (usersCurrentPage - 1) * USERS_PER_PAGE;
    const end = start + USERS_PER_PAGE;

    matchedRows.slice(start, end).forEach(row => {
        row.style.display = '';
    });

    renderUsersPagination(totalPages);
}

function compareUserRows(a, b) {
    if (!usersSortKey || !usersSortDirection) {
        return Number(a.dataset.initialOrder || 0) - Number(b.dataset.initialOrder || 0);
    }

    const left = (a.dataset[usersSortKey] || '').toLowerCase();
    const right = (b.dataset[usersSortKey] || '').toLowerCase();
    const result = left.localeCompare(right, undefined, { sensitivity: 'base' });

    return usersSortDirection === 'asc' ? result : -result;
}

function updateUsersSortButtons() {
    const sortButtons = document.querySelectorAll('.user-sort-btn');
    sortButtons.forEach(button => {
        const key = button.getAttribute('data-sort-key');
        const baseLabel = key.charAt(0).toUpperCase() + key.slice(1);

        if (key === usersSortKey && usersSortDirection) {
            button.textContent = `${baseLabel} ${usersSortDirection === 'asc' ? '↑' : '↓'}`;
        } else {
            button.textContent = baseLabel;
        }
    });
}

function renderUsersPagination(totalPages) {
    const paginationNav = document.getElementById('usersPaginationNav');
    const pagination = document.getElementById('usersPagination');

    if (!paginationNav || !pagination) {
        return;
    }

    pagination.innerHTML = '';

    if (totalPages <= 1) {
        paginationNav.classList.add('d-none');
        return;
    }

    paginationNav.classList.remove('d-none');

    pagination.appendChild(createPaginationItem('Previous', usersCurrentPage - 1, usersCurrentPage === 1));

    for (let page = 1; page <= totalPages; page++) {
        pagination.appendChild(createPaginationItem(String(page), page, false, page === usersCurrentPage));
    }

    pagination.appendChild(createPaginationItem('Next', usersCurrentPage + 1, usersCurrentPage === totalPages));
}

function createPaginationItem(label, targetPage, disabled = false, active = false) {
    const item = document.createElement('li');
    item.className = `page-item${disabled ? ' disabled' : ''}${active ? ' active' : ''}`;

    const link = document.createElement('button');
    link.type = 'button';
    link.className = 'page-link';
    link.textContent = label;

    if (!disabled) {
        link.addEventListener('click', function() {
            usersCurrentPage = targetPage;
            renderUsersPage();
        });
    }

    item.appendChild(link);
    return item;
}

function openEditUserModal(button) {
    currentEditUserId = button.getAttribute('data-user-id');

    const firstNameInput = document.getElementById('editFirstName');
    const lastNameInput = document.getElementById('editLastName');
    const nicknameInput = document.getElementById('editNickname');
    const emailInput = document.getElementById('editEmail');
    const statusInput = document.getElementById('editStatus');

    if (firstNameInput) {
        firstNameInput.value = '';
        firstNameInput.placeholder = button.getAttribute('data-user-first-name') || '';
    }

    if (lastNameInput) {
        lastNameInput.value = '';
        lastNameInput.placeholder = button.getAttribute('data-user-last-name') || '';
    }

    if (nicknameInput) {
        nicknameInput.value = '';
        nicknameInput.placeholder = button.getAttribute('data-user-nickname') || '';
    }

    if (emailInput) {
        emailInput.value = '';
        emailInput.placeholder = button.getAttribute('data-user-email') || '';
    }

    if (statusInput) {
        statusInput.value = button.getAttribute('data-user-status') || 'user';
    }
}

function createUser() {
    const firstName = document.getElementById('addFirstName')?.value.trim() || '';
    const lastName = document.getElementById('addLastName')?.value.trim() || '';
    const nickname = document.getElementById('addNickname')?.value.trim() || '';
    const birthday = document.getElementById('addBirthday')?.value || '';
    const email = document.getElementById('addEmail')?.value.trim() || '';
    const password = document.getElementById('addPassword')?.value.trim() || '';
    const status = document.getElementById('addStatus')?.value || 'user';

    if (!firstName || !lastName || !nickname || !birthday || !email || !password) {
        showNotification('Please fill in all fields', 'warning');
        return;
    }

    const body = new URLSearchParams({
        action: 'create_user',
        first_name: firstName,
        last_name: lastName,
        nickname: nickname,
        birthday: birthday,
        email: email,
        password: password,
        status: status
    });

    fetch('/admin/ajax', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: body.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('User created successfully', 'success');
            window.location.reload();
        } else {
            showNotification(data.message || 'Error creating user', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error creating user', 'danger');
    });
}

function updateUser() {
    if (!currentEditUserId) {
        showNotification('User is not selected', 'danger');
        return;
    }

    const firstName = document.getElementById('editFirstName')?.value.trim() || '';
    const lastName = document.getElementById('editLastName')?.value.trim() || '';
    const nickname = document.getElementById('editNickname')?.value.trim() || '';
    const email = document.getElementById('editEmail')?.value.trim() || '';
    const status = document.getElementById('editStatus')?.value || 'user';

    const body = new URLSearchParams({
        action: 'update_user',
        user_id: currentEditUserId,
        first_name: firstName,
        last_name: lastName,
        nickname: nickname,
        email: email,
        status: status
    });

    fetch('/admin/ajax', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: body.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('User updated successfully', 'success');
            window.location.reload();
        } else {
            showNotification(data.message || 'Error updating user', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating user', 'danger');
    });
}

// Delete user function
function deleteUser(userId) {
    fetch('/admin/ajax', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=delete_user&user_id=${userId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('User deleted successfully', 'success');
            // Remove row from table
            const row = document.querySelector(`[data-user-id="${userId}"]`)?.closest('tr');
            if (row) {
                row.remove();
                renderUsersPage();
            }
        } else {
            showNotification('Error deleting user', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error deleting user', 'error');
    });
}

// Update user status function
function updateUserStatus(userId, status) {
    fetch('/admin/ajax', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=update_user_status&user_id=${userId}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('User status updated successfully', 'success');
        } else {
            showNotification('Error updating user status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating user status', 'error');
    });
}

// Delete content function
function deleteContent(contentId, contentType) {
    fetch('/admin/ajax', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=delete_content&content_id=${contentId}&content_type=${contentType}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Content deleted successfully', 'success');
            // Remove row from table
            const row = document.querySelector(`[data-content-id="${contentId}"]`);
            if (row) {
                row.remove();
            }
        } else {
            showNotification('Error deleting content', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error deleting content', 'error');
    });
}

// Update statistics
function updateStats() {
    fetch('/admin/ajax', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=get_stats'
    })
    .then(response => response.json())
    .then(data => {
        updateStatsDisplay(data);
    })
    .catch(error => {
        console.error('Error updating stats:', error);
    });
}

// Update statistics display
function updateStatsDisplay(stats) {
    const statElements = document.querySelectorAll('.admin-stat-content h3');
    statElements.forEach(element => {
        const statType = element.closest('.admin-stat-card').querySelector('p').textContent.toLowerCase();
        if (stats[statType]) {
            element.textContent = stats[statType];
        }
    });
}

// Initialize mobile menu
function initMobileMenu() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const sidebar = document.querySelector('.admin-sidebar');
    
    if (mobileMenuToggle && sidebar) {
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('mobile-open');
        });
    }
}

// Show notification
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
} 
