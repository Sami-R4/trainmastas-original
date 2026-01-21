$(document).ready(function() {
    // Handle the logout button click event
    $('.log-out').click(function(e) {
        e.preventDefault(); // Prevent the default link behavior
        
        $.ajax({
            url: 'app/logout_process.php', // PHP script to handle logout
            type: 'POST',
            success: function(response) {
                if (response === 'success') {
                    window.location.href = 'login.php'; // Redirect to index.php
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });
});