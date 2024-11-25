document.addEventListener('DOMContentLoaded', function() {
    // Get toggle buttons and form containers
    const toggleBtns = document.querySelectorAll('.toggle-btn');
    const loginForm = document.getElementById('login');
    const signupForm = document.getElementById('signup');

    // Add click event listeners to toggle buttons
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            toggleBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            // Show the corresponding form
            if (this.dataset.form === 'login') {
                loginForm.classList.add('active');
                signupForm.classList.remove('active');
            } else {
                signupForm.classList.add('active');
                loginForm.classList.remove('active');
            }
        });
    });

    // Optional: Add password validation for signup
    const signupPassword = document.querySelector('#signup input[name="password"]');
    const confirmPassword = document.querySelector('#signup input[name="confirm_password"]');

    function validatePassword() {
        if (signupPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Passwords don't match");
        } else {
            confirmPassword.setCustomValidity('');
        }
    }

    if (signupPassword && confirmPassword) {
        signupPassword.addEventListener('change', validatePassword);
        confirmPassword.addEventListener('keyup', validatePassword);
    }
});