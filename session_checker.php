<script>
    // Send an AJAX request to check the user's session status
    $.ajax({
        url: 'app/session_checker.php', // Backend script that checks if the user is logged in
        method: 'POST',
        data: {
            check_session: true
        },
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('access_token') // Send the stored token
        },
        dataType: "json",
        success: function(response) {
            window.isLoggedIn = false;
            if (response.state === 'success') {
                window.isLoggedIn = true;
                window.UserType = response.UserType;
            }
            // Trigger custom event
            const event = new Event('sessionChecked');
            window.dispatchEvent(event);
        },
    });
</script>