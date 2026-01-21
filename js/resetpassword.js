$(document).ready(function() {
    //////////////////////////////////////////////////////////////
    // Toggle New Password Visibility  
    $('#toggleNewPassword').on('click', function() {
        const newPasswordInput = $('#newPassword');
        if (newPasswordInput.attr('type') === 'password') {
            newPasswordInput.attr('type', 'text');
            $("#eye-password").addClass("d-none");
            $("#eye-password-slash").removeClass("d-none");
        } else {
            newPasswordInput.attr('type', 'password');
            $("#eye-password").removeClass("d-none");
            $("#eye-password-slash").addClass("d-none");
        }
    });

    // Toggle Confirm Password Visibility  
    $('#toggleConfirmPassword').on('click', function() {
        const confirmPasswordInput = $('#confirmPassword');
        if (confirmPasswordInput.attr('type') === 'password') {
            confirmPasswordInput.attr('type', 'text');
            $("#eye-password").addClass("d-none");
            $("#eye-password-slash").removeClass("d-none");
        } else {
            confirmPasswordInput.attr('type', 'password');
            $("#eye-password").removeClass("d-none");
            $("#eye-password-slash").addClass("d-none");
        }
    });
    ////////////////////////////////////////////////////////////// 
    // Password validation and matching
    $("#newPassword").on("input", function() {
        const newPassword = $("#newPassword").val();
        $("#newPassword").removeClass("border-danger")
        $("#alertPassword").text("");
        // Password hint validation
        const passwordRegex = /^(?=.*[!@#$%^&*])(?=.*\d)(?=.*[A-Z]).{8,}$/;
        if (!passwordRegex.test(newPassword)) {
            $("#passwordHint").addClass("text-danger").removeClass("text-success").removeClass("d-none").text("At least 8 characters, 1 special character(!@#$%^&*), 1 numeric, and 1 uppercase letter.");
        } else {
            $("#passwordHint").removeClass("text-danger").addClass("text-success").text("Password meets the criteria.");
        }
    });
    $("#confirmPassword").on("input", function() {
        const newPassword = $("#newPassword").val();
        const confirmPassword = $("#confirmPassword").val();
        $("#alertPassword").text("");
        // Password match validation
        if (newPassword !== confirmPassword) {
            $("#passwordMatch").text("Passwords do not match.");
        } else {
            $("#passwordMatch").text("");
        }
    });
    $("#confirmPassword").on("focus", function() {
        $("#confirmPassword").removeClass("border-danger");
        $("#passwordMatch").text("");
    });

    $("#newPassword").on("focus", function() {
        $("#newPassword").removeClass("border-danger")
        $("#passwordHint").text("");
    });
    // Function to handle input events and ensure it is only numeric
    function handleInput(input) {
        let value = input.value;
        // Keep only numbers and truncate to 6 digits
        value = value.replace(/\D/g, '').slice(0, 6);
        input.value = value;
    }

    // Function to handle pasting of text and ensure it is only numeric
    function handlePaste(event) {
        // Prevent the default paste action
        event.preventDefault();
        // Get the pasted text and remove non-numeric characters
        let pasteData = event.clipboardData.getData('text');
        pasteData = pasteData.replace(/\D/g, '').slice(0, 6);
        // Set the value of the input to the cleaned text
        document.getElementById('verificationCode').value = pasteData;
    }
    //     Verification Input Box


    $("#email").on("input", function() {
        $("#email-error").text("").hide();
        $("#email").removeClass("border-danger");
    })
    var email;

    function receiveCode() {
        $("#alert-account").text("").hide()
        email = $("#email").val().trim(); // Get and trim the email input  

        // Check if email is empty  
        if (email === "") {
            $("#email-error").text("Please enter your email address.").show();
            $("#email").addClass("border-danger");
            return; // Prevent further execution  
        }

        // Basic email validation using a regex pattern  
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            $("#email-error").text("Please enter a valid email address.").show();
            $("#email").addClass("border-danger");
            return; // Prevent further execution  
        }

        // If email is valid, proceed with the AJAX request  
        $.ajax({
            url: "app/resetpassword_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            data: {
                purpose: "verifyEmailAction",
                email: email
            },
            dataType: "json",
            success: function(response) {
                const data = response;
                if (data.state === "verifying") {
                    $("#email-verification").text(data.email);
                    $(".email-element").addClass("d-none");
                    $(".code-element").removeClass("d-none");
                    if (data.attemptNum >= 3) {
                        $("#attemptVerifyEmail").remove();
                    }
                } else if (data.state === "not_found") {
                    $("#alert-account").text("This email account does not exist.").show();
                } else if (data.state === "verified" || data.state === "verified_recent") {
                    $("#alert-account").text("You recently requested password change. Please try again later.").show();
                } else if (data.state === "samePassword") {
                    $("#alert-account").text("New Password Must be different from old password.").show();
                } else if (data.state === "limitReached") {
                    $("#alert-account").text("Sorry! You have reached the attempt limit. Please try again later.").show();
                    $("#email").val("");
                } else {
                    $("#alert-account").text("An error occurred. Please try again. If the issue persists, contact the support team.").show();
                }
            },
            error: function() {
                $("#alert-account").text("An error occurred while processing your request.").show();
            }
        });
    }
    $("#verifyEmail").click(function() {
        receiveCode()
    });
    $("#attemptVerifyEmail").click(function() {
        receiveCode()
    });
    $("#verifyCodeBtnReset").on("click", function() {
        const verificationCode = $("#verificationCode").val();

        // Send AJAX request to verify code
        if (verificationCode !== "") {
            $.ajax({
                url: "app/resetpassword_process.php",
                method: "POST",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
                },
                data: {
                    purpose: "verifyPasswordCodeReset",
                    verificationCode: verificationCode
                },
                dataType: "json",
                success: function(response) {
                    const data = response;
                    if (data.state === "verified") {
                        $(".code-element").addClass("d-none");
                        $(".password-element").removeClass("d-none");
                    } else if (data.state === "wrong") {
                        $("#alertCode").text("Incorrect Code.");
                    } else if (data.state === "expired") {
                        $("#alertCode").text("Code has expired.");
                    } else if (data.state === "verified" || data.state === "verified_recent") {
                        $("#alertCode").text("You recently requested password change request. Please try again later");
                    } else {
                        $("#alertCode").text("Verification failed. Please try again.");
                    }
                }
            });
        } else {
            // 
            alert("Verification input must not be empty")
        }
    });

    $("#submitPasswordBtn").on("click", function() {
        const newPassword = $("#newPassword").val();
        const confirmPassword = $("#confirmPassword").val();
        var tempcontrol = true;
        // Validate passwords before submitting
        const passwordRegex = /^(?=.*[!@#$%^&*])(?=.*\d)(?=.*[A-Z]).{8,}$/;
        if (!passwordRegex.test(newPassword) && newPassword != "") {
            $("#passwordHint").text("Password does not meet the criteria.");
            $("#newPassword").addClass("border-danger");
            tempcontrol = false;
        } else if (newPassword == "") {
            $("#passwordHint").text("This field is required.");
            $("#newPassword").addClass("border-danger");
            tempcontrol = false;
        }

        if (newPassword !== confirmPassword) {
            $("#passwordMatch").text("Passwords do not match.");
            $("#confirmPassword").addClass("border-danger");
            tempcontrol = false;
        } else if (newPassword == "") {
            $("#passwordMatch").text("This field is required.");
            $("#confirmPassword").addClass("border-danger");
            tempcontrol = false;
        }
        if (tempcontrol == false) {
            return;
        }
        password = newPassword; // Store the password

        // Send AJAX request to backend
        $.ajax({
            url: "app/resetpassword_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            data: {
                purpose: "verifyPasswordActionReset",
                password: password
            },
            success: function(response) {
                const data = JSON.parse(response);
                $("#passwordMatch").text("");
                $("#passwordHint").text("");
                if (data.state === "success") {
                    window.location.href = "login.php"
                } else if (data.state === "samePassword") {
                    $("#newPassword").val("");
                    $("#confirmPassword").val("");
                    $("#alertPassword").text("New Password Must be different from old password.");
                } else {
                    alert("An error occurred. Please try again.");
                }
            }
        });
    });
})
