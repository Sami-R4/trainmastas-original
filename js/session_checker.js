// // Send an AJAX request to check the user's session status
    window.checkSession = function () {
        return new Promise((resolve) => {
            $.ajax({
                url: 'app/session_checker.php',
                method: 'POST',
                data: { check_session: true },
                headers:{'Authorization': 'Bearer ' + localStorage.getItem('access_token')},
                dataType: "json",
                success: function (response) {
                    window.isLoggedIn = false;
                    window.UserType = null;
                    if (response.state === 'success') {
                        window.isLoggedIn = true;
                        window.UserType = response.UserType;
                    } else {
                        localStorage.removeItem('access_token');
                        localStorage.removeItem('refresh_token');
                    }
                    resolve({ isLoggedIn: window.isLoggedIn, userType: window.UserType });
                }
            });
        });
    };


