$(document).ready(function () {
    var urlParams = new URLSearchParams(window.location.search);
    var cValue = urlParams.get('v');
    if (cValue) {
        $("#otherLink").attr('href', 'signup.php?v=' + cValue);
    }
    // Function for submission
    function submitForm() {
        // Retrieve form values
        var email = $('#email').val().trim();
        var password = $('#pwd').val().trim();
        var valid = true;

        // Clear previous errors
        $('#alert-account').text('').hide();
        $('#email-error').hide();
        $('#password-error').hide();
        $('input').css('border', '');

        // Perform client-side validation
        if (email === '') {
            $('#email-error').text('Email is required.').show();
            $('#email').css('border', '1px solid red');
            valid = false;
        } else if (!validateEmail(email)) {
            $('#email-error').text('Invalid email format.').show();
            $('#email').css('border', '1px solid red');
            valid = false;
        }

        if (password === '') {
            $('#password-error').text('Password is required.').show();
            $('#pwd').css('border', '1px solid red');
            valid = false;
        }

        if (!valid) {
            $('#alert-account').text('Please address the issue(s) below:').show();
            return;
        }

       
        $("#signup").prop("disabled", true);
        // Perform AJAX request
        $.ajax({
            url: 'app/login_process.php', // Adjust URL to your backend script
            type: 'POST',
            data: {
                email: email,
                password: password,
                login: "login",
            },
            dataType: "json",
            success: function (response) {
                if (response.state === 'success') {
                    localStorage.setItem('access_token', response.access_token);
                    localStorage.setItem('refresh_token', response.refresh_token);
                    var urlParams = new URLSearchParams(window.location.search);
                    var cValue = urlParams.get('v');
                    if (cValue) {
                        window.location.href = 'displaycourse.php?v=' + cValue; // Redirect to displaycourse.php?v=
                    } else {
                        window.location.href = 'dashboard.php'; // Redirect to dashboard
                    }
                    return;
                } else if (response.state === 'invalid') {
                    $('#alert-account').text('Invalid email or password.').show();
                } else if (response.state === 'error') {
                    $('#alert-account').text('An error occurred. Please try again.').show();
                } else if (response.state === 'wrong') {
                    $('#alert-account').text('Wrong email or password.').show();
                } else if (response.state === 'notfound') {
                    $('#alert-account').text('Account does not exist. Create one').show();
                } else if (response.state === 'banned') {
                    $('#alert-account').text('Account was banned. If you think this was an error, contact the support team.').show();
                } else if (response.state === 'deleted') {
                    $('#alert-account').text('Account was deleted. If you think this was an error, contact the support team.').show();
                } else if (response.state === 'deleted_forever') {
                    $('#alert-account').text('Account was deleted. This email do not have access to this platform.').show();
                }
                $('#email').val("");
                $('#pwd').val("");
                $("#signup").prop("disabled", false);
            },error: function(xhr, status, error) {
                // Re-enable the signup button
                $('#signupBtn').prop('disabled', false);
                // Show error message
                $('#alert-account').text("An Error Occurred! Please try Again.").show();
              }
        });
    }
    // Function to handle form submission
    $('#signup').click(function (e) {
        e.preventDefault(); // Prevent default anchor behavior
        submitForm();
    });
    // Email input event handler
    $('#email').on('focus', function () {
        $('#email-error').hide();
        $('#alert-account').hide();
        $(this).css('border', ''); // Reset border color to default
    });
    // Password input event handler
    $('#pwd').on('focus', function () {
        $('#password-error').hide();
        $('#alert-account').hide();
        $(this).css('border', ''); // Reset border color to default
    });
    // Submit on enter key on the password input
    $('#pwd').on('keypress', function (event) {
        if (event.which === 13) {
            event.preventDefault();
            submitForm();
        }
    })
    // Email validation function
    function validateEmail(email) {
        var re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return re.test(email);
    }
});
