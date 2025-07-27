// Administrative Panel JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize all components
    initAdminPanel();
    initCharts();
    initAjaxHandlers();
    initMobileMenu();
    
});

// Main initialization
function initAdminPanel() {
    console.log('Administrative panel initialized');
    
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
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
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
            const row = document.querySelector(`[data-user-id="${userId}"]`);
            if (row) {
                row.remove();
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