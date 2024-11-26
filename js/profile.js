document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profile-form');
    const passwordForm = document.getElementById('password-form');

    profileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('../includes/update_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${data.success ? 'success' : 'danger'} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const profileContent = document.querySelector('.profile-content');
            profileContent.insertBefore(alertDiv, profileContent.firstChild);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    passwordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('../includes/update_password.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${data.success ? 'success' : 'danger'} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const profileContent = document.querySelector('.profile-content');
            profileContent.insertBefore(alertDiv, profileContent.firstChild);
            
            if (data.success) {
                this.reset(); // Clear form if successful
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});