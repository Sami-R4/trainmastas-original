$(document).ready(function () {

    //////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////
    ////////// Change Password and Verification Processes ////////
    //////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////

    //     Verification Input Box
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

    //////////////////////////////////////////////////////////////
    // Toggle New Password Visibility  
    $('#toggleNewPassword').on('click', function () {
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
    $('#toggleConfirmPassword').on('click', function () {
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
    let password = "";

    // Password validation and matching
    $("#newPassword").on("input", function () {
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
    $("#confirmPassword").on("input", function () {
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
    $("#confirmPassword").on("focus", function () {
        $("#confirmPassword").removeClass("border-danger");
        $("#passwordMatch").text("");
    });

    $("#newPassword").on("focus", function () {
        $("#newPassword").removeClass("border-danger")
        $("#passwordHint").text("");
    });
    // Submit password
    $("#submitPasswordBtn").on("click", function () {
        submitPassword();
    });
    $("#attemptNumBtn").on("click", function () {
        submitPassword();
    });

    function submitPassword() {
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
            data: {
                purpose: "verifyPasswordAction",
                password: password
            },
            success: function (response) {
                const data = JSON.parse(response);
                $("#passwordMatch").text("");
                $("#passwordHint").text("");
                if (data.state === "verifying") {
                    $("#passwordDiv-container").addClass("d-none");
                    $("#verificationDiv-container").removeClass("d-none");
                    $("#email-verification").text(data.email);
                    if (data.attemptNum >= 3) {
                        $("#attemptNumBtn").remove();
                    }
                }else if (data.state === "verified") {
                    $("#newPassword").val("");
                    $("#confirmPassword").val("");
                    $("#alertPassword").text("Your recently requested password change. Please try again later.");
                } else if (data.state === "samePassword") {
                    $("#newPassword").val("");
                    $("#confirmPassword").val("");
                    $("#alertPassword").text("New Password Must be different from old password.");
                }
                else if (data.state === "verified_recent") {
                    $("#newPassword").val("");
                    $("#confirmPassword").val("");
                    $("#alertPassword").text("Sorry! You must wait 15 minutes before requesting another code.");
                } else if (data.state === "limitReached") {
                    $("#newPassword").val("");
                    $("#confirmPassword").val("");
                    $("#alertPassword").text("Sorry! You have reached the attempt limit. Please try again later.");
                } else {
                    alert("An error occurred. Please try again.");
                }
            }
        });
    }

    $("#verificationCode").on("input", function () {
        $("#alertCode").text("");
    })
    // Verify code
    $("#verifyCodeBtn").on("click", function () {
        const verificationCode = $("#verificationCode").val();

        // Send AJAX request to verify code
        if (verificationCode !== "") {
            $.ajax({
                url: "app/resetpassword_process.php",
                method: "POST",
                data: {
                    purpose: "verifyPasswordCode",
                    password: password,
                    verificationCode: verificationCode
                },
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.state === "success") {
                        alert("Password successfully changed.");
                        location.reload();
                    } else if (data.state === "wrong") {
                        $("#alertCode").text("Incorrect Code.");
                        location.reload();
                    } else if (data.state === "expired") {
                        $("#alertCode").text("Code has expired.");
                        location.reload();
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
});