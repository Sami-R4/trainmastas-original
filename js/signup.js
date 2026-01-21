$(document).ready(function () {
    $('#alert-div').text('Please address the issues below:');

    function validateForm() {
        let isValid = true;

        // Hide previous error messages
        $('.text-danger').addClass('d-none');
        $('.form-control, .questions-answer').removeClass('border-danger');

        // Validate Name
        if ($('#name').val().trim() === '') {
            isValid = false;
            $('#name-error').removeClass('d-none');
            $('#name').addClass('border-danger');
        }

        // Validate Email
        const email = $('#email').val().trim();
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (email === '') {
            isValid = false;
            $('#email-error').text('Email is required.');
            $('#email-error').removeClass('d-none');
            $('#email').addClass('border-danger');
        } else if (!emailPattern.test(email)) {
            isValid = false;
            $('#email-error').text('Not a valid email address.');
            $('#email-error').removeClass('d-none');
            $('#email').addClass('border-danger');
        }

        // Validate Password
        const passwordRegex = /^(?=.*[!@#$%^&*])(?=.*\d)(?=.*[A-Z]).{8,}$/;

        const pwd = $('#pwd').val().trim();
        if (pwd === '') {
            isValid = false;
            $('#pwd-error').text('Password is required.');
            $('#pwd-error').removeClass('d-none');
            $('#pwd').addClass('border-danger');
        } else if (!passwordRegex.test(pwd)) {
            isValid = false;
            $('#pwd-error').text('Password must be at least 8 characters, 1 special character(!@#$%^&*), 1 numeric, and 1 uppercase letter.');
            $('#pwd-error').removeClass('d-none');
            $('#pwd').addClass('border-danger');
        } else {
            $('#pwd-error').addClass('d-none');
            $('#pwd').removeClass('border-danger');
        }


        // Validate Confirm Password
        const cpwd = $('#cpwd').val().trim();
        if (cpwd === '') {
            isValid = false;
            $('#cpwd-error').text('Confirm Password is required.');
            $('#cpwd-error').removeClass('d-none');
            $('#cpwd').addClass('border-danger');
        } else if (pwd !== cpwd) {
            isValid = false;
            $('#cpwd-error').text('Passwords do not match.');
            $('#cpwd-error').removeClass('d-none');
            $('#pwd, #cpwd').addClass('border-danger');
        }

        // Validate Account Type
        if ($('#accountType').val() === '') {
            isValid = false;
            $('#accountType-error').removeClass('d-none');
            $('#select2-accountType-container').addClass('border-danger');
        }

        return isValid;
    }

    // Password match checking
    $('#cpwd').on('input', function () {
        const pwd = $('#pwd').val().trim();
        const cpwd = $(this).val().trim();

        if (pwd !== cpwd) {
            $('#cpwd-error').text('Passwords do not match.');
            $('#cpwd-error').removeClass('d-none');
            $('#pwd, #cpwd').addClass('border-danger');
        } else {
            $('#cpwd-error').addClass('d-none');
            $('#pwd, #cpwd').removeClass('border-danger');
        }
    });
    var urlParams = new URLSearchParams(window.location.search);
    var cValue = urlParams.get('v');
    if (cValue) {
        $("#otherLink").attr('href', 'login.php?v=' + cValue);
    }
    // Submit button click event
    $('#signup').on('click', function (e) {
        e.preventDefault();
        $('#alert-div').addClass('d-none');

        if (validateForm()) {
            $('#alert-div').addClass('d-none');

            // Collect form data
            const name = $('#name').val().trim().toLowerCase();
            const email = $('#email').val().trim().toLowerCase();
            const pwd = $('#pwd').val().trim();
            const accountType = $('#accountType').val();

            
            $("#signup").prop("disabled", true);
            // Send data to backend via AJAX
            $.ajax({
                url: 'app/signup_process.php', // Replace with your backend URL
                method: 'POST',
                data: {
                    name: name,
                    email: email,
                    password: pwd,
                    accountType: accountType,
                    signup: "true"
                },
                dataType: "json",
                success: function (response) {
                    // Handle success response
                    if (response.state == "success") {
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
                    } else if (response.state == "invalid") {
                        $('#alert-div').removeClass('d-none');
                        $('#alert-div').text('You have invalid inputs. Please check and resubmit.');
                    } else if (response.state == "exist") {
                        $('#alert-div').removeClass('d-none');
                        $('#alert-div').text('You already have an account with us, login instead.');
                    } else {
                        alert('An error occurred. Please try again or contact support team.');
                    }
                    // Redirect or further actions
                    $("#signup").prop("disabled", false);
                },error: function(xhr, status, error) {
                    // Re-enable the signup button
                    $('#signup').prop('disabled', false);
                    // Show error message
                    $('#alert-div').text("An Error Occurred! Please try Again.").removeClass('d-none');
                }
            });
        } else {
            $('#alert-div').removeClass('d-none');
        }
    });

    // Hide error message and reset border color on focus
    $('.form-control, .questions-answer').on('focus', function () {
        $(this).removeClass('border-danger');
        const errorSpanId = `#${$(this).attr('id')}-error`;
        $(errorSpanId).addClass('d-none');
        $('#alert-div').addClass('d-none');
    });

    // Special case for Select2, since it doesn't directly use form-control class
    $('#accountType').on('select2:select', function () {
        $('#select2-accountType-container').removeClass('border-danger');
        $('#accountType-error').addClass('d-none');
        $('#alert-div').addClass('d-none');
    });
});






$(document).ready(function () {
    $("#accountType").select2({
        placeholder: "Select the account type",
        width: '100%',
        minimumResultsForSearch: Infinity // Hides the search box
    });
})