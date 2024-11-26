
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profile-form');
    const passwordForm = document.getElementById('password-form');

    profileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // Add AJAX call to update profile
        alert('Profile updated successfully!');
    });

    passwordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // Add AJAX call to change password
        alert('Password changed successfully!');
    });
});