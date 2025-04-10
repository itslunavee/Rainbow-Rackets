document.addEventListener('DOMContentLoaded', function() {
    // ===== Mobile Menu =====
    const hamburger = document.getElementById("mobile-menu-btn");
    const navLinks = document.getElementById("admin-nav");

    if (hamburger && navLinks) {
        hamburger.addEventListener("click", function () {
            navLinks.classList.toggle("active");
        });

        navLinks.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", function () {
                if (window.innerWidth <= 768) {
                    navLinks.classList.remove("active");
                }
            });
        });
    }

    // ===== Approval System =====
    document.querySelectorAll('.btn-approve, .btn-reject').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const userId = this.closest('tr').dataset.userId;
            const action = this.classList.contains('btn-approve') ? 'approve' : 'reject';
            handleApproval(userId, action);
        });
    });

    // ===== Approval Functions =====
    async function handleApproval(userId, action) {
        const formData = new FormData();
        formData.append('user_id', userId);
        formData.append('action', action);

        try {
            const response = await fetch('../../Server/admin/dash_approval.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();

            if (data.success) {
                const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                if (row) row.remove();
                showNotification(data.message, 'success');
            } else {
                showNotification(data.error, 'error');
            }
        } catch (error) {
            showNotification('Network error - please try again', 'error');
        }
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `alert ${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});