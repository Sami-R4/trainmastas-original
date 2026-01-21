$(document).ready(function () {
    // Handle the logout button click event
    $('.log-out').click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        $.ajax({
            url: 'app/logout_process.php', // PHP script to handle logout
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            dataType: "json",
            success: function (response) {
                if (response.state === 'success') {
                    localStorage.removeItem('access_token');
                    localStorage.removeItem('refresh_token');
                    window.location.href = 'index.php'; // Redirect to index.php
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });
});