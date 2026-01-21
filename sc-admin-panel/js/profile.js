$(document).ready(function () {

    var max, totalPages;
   /////////////////////////////////////////////////////////////////
    //                            Capitalizer
    /////////////////////////////////////////////////////////////////
    function capitalizeFirstLetter(statement) {  
        // Escape quotes to prevent conflicts in HTML  
        function escapeQuotes(value) {  
            return value.replace(/"/g, '&quot;').replace(/'/g, '&#39;');  
        }  
    
        // Escape the input statement  
        const escapedStatement = escapeQuotes(statement);  
        var words = escapedStatement.split(" ");  
        var capitalizedWords = [];  
    
        for (var i = 0; i < words.length; i++) {  
            var word = words[i];  
            if (word.length > 0) {  
                // Capitalize the first letter if it's an alphabetical character  
                if (/^[a-zA-Z]/.test(word.charAt(0))) {  
                    word = word.charAt(0).toUpperCase() + word.slice(1);  
                }  
            }  
            capitalizedWords.push(word);  
        }  
    
        return capitalizedWords.join(" ");  
    }  

    /////////////////////////////////////////////////////////////////
    //                 Capitalizer of first letter of phrase
    /////////////////////////////////////////////////////////////////
    function capitalizeFirstLetterOfPhrase(statement) {  
        // Escape quotes to prevent conflicts in HTML  
        function escapeQuotes(value) {  
            return value.replace(/"/g, '&quot;').replace(/'/g, '&#39;');  
        }  
        // Escape the input statement  
        const escapedStatement = escapeQuotes(statement);  
        // Capitalize the first letter if the first character is a letter  
        if (escapedStatement.length > 0) {  
            const firstChar = escapedStatement.charAt(0);  
            // Check if the first character is a letter (using regex)  
            if (/^[a-zA-Z]/.test(firstChar)) {  
                return escapedStatement.charAt(0).toUpperCase() + escapedStatement.slice(1);  
            }  
        }  
        // Return the escaped statement unchanged if no capitalization is applied or if it's empty  
        return escapedStatement;  
    }  

    /////////////////////////////////////////////////////////////////
    //             Format date to Day Month Year
    /////////////////////////////////////////////////////////////////
    function formatDate(date) {
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        let d = new Date(date);
        let day = d.getDate();
        let month = months[d.getMonth()];
        let year = d.getFullYear();
        return `${day} ${month} ${year}`;
    }
    // Extract the value of `p` from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const pValue = urlParams.get("p");

    if (pValue) {
        $.ajax({
            url: "app/profile_process.php",
            method: "POST",
            data: {
                purpose: "sendOtherProfile",
                OtherUser_ID: pValue // Send the value of `p` to the backend
            },
            dataType: "json",
            success: function (response) {
                setTimeout(function () {
                    if (response.status === "success") {
                        // Assign values to elements
                        $("#username").text(capitalizeFirstLetter(response.Name));
                        $("#userprofile").attr("src", "profile/" + (response.Image || "image/default-profile.png"));
                        $("#userprofile").attr("alt", capitalizeFirstLetter(response.Name));
                        $("#description").text(
                            capitalizeFirstLetterOfPhrase(response.Description) || "No description available"
                        );
                        if (response.linkedinLink != "") {
                            $("#linkedinLink").attr("href", response.linkedinLink).removeClass("d-none");
                        }
                        if (response.portfolioLink != "") {
                            $("#portfolioLink").attr("href", response.PortfolioLink).removeClass("d-none");
                        }

                        $("#userinput").val(capitalizeFirstLetter(response.Name));
                        $("#descriptioninput").val(capitalizeFirstLetter(response.Description));
                        $("#linkedinput").val(response.linkedinLink);
                        $("#portfolioinput").val(response.PortfolioLink);
                        $("#dateJoin").text("Join on the " + formatDate(response.Date));

                        // Remove these elements
                        $("#fields").remove();
                        $("#edit").remove();
                        $("#email").remove();
                        $("#field-hr").remove();
                        $("#icon-profile-container").remove();
                        $("#passwordDiv").remove();

                        $("#fullScreenLoader").addClass("d-none");
                    }else if(response.status === "error") {
                        alert("An error occurred. Please try again later. If it persists, contact the support team.");
                    }else {
                        alert("User was not found. You will be redirected.");
                        // window.location.href = "dashboard.php";
                    }
                }, 1000);
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
        });
    } else {
        $.ajax({
            url: "app/profile_process.php",
            method: "POST",
            data: {
                purpose: "sendUserProfileDetails"
            },
            dataType: "json",
            success: function (response) {
                setTimeout(function () {
                    if (response.status === "success") {
                        // Assign values to elements
                        $("#username").text(capitalizeFirstLetter(response.Name));
                        $("#userprofile").attr("src", "../profile/" + response.Image || "../image/default-profile.png");
                        $("#userprofile").attr("alt", capitalizeFirstLetter(response.Name));
                        $("#email").text(response.Email);
                        $("#description").text(capitalizeFirstLetterOfPhrase(response.Description) || "No description available");
                        if (response.linkedinLink != "") {
                            $("#linkedinLink").attr("href", response.linkedinLink).removeClass("d-none");
                        }
                        if (response.portfolioLink != "") {
                            $("#portfolioLink").attr("href", response.PortfolioLink).removeClass("d-none");
                        }

                        $("#dateJoin").text("Join on the " + formatDate(response.Date));
                        $("#userinput").val(capitalizeFirstLetter(response.Name));
                        $("#descriptioninput").val(capitalizeFirstLetter(response.Description));
                        $("#linkedinput").val(response.linkedinLink);
                        $("#portfolioinput").val(response.PortfolioLink);
                        let fieldSelect = $("#fieldSelect");

                        // Append fields
                        let fieldsContainer = $("#fields");
                        fieldsContainer.empty();  // Clear previous fields if any
                        if (response.fields && response.fields.length > 0) {
                            response.fields.forEach(function (field) {
                                // Append each field as a button to #fields container
                                let fieldButton = `<button class="btn btn-secondary disabled fs-7 rounded-0 my-2 me-2">${field.Field}</button>`;
                                fieldsContainer.append(fieldButton);

                                // Add each field as an option in #fieldSelect

                                if ($(fieldSelect).find("option[value='" + field.Field + "']").length) {
                                    $(fieldSelect)
                                        .val($(fieldSelect).val().concat(field.Field))
                                        .trigger("change");
                                } else {
                                    var newOption = new Option(
                                        capitalizeFirstLetterOfPhrase(field.Field),
                                        capitalizeFirstLetterOfPhrase(field.Field),
                                        true,
                                        true
                                    );
                                    $(fieldSelect).append(newOption).trigger("change");
                                }
                            });

                        } else {
                            fieldsContainer.append(`<p class="text-muted">No fields available</p>`);
                        }
                        $("#fullScreenLoader").addClass("d-none");
                    }

                }, 1000);
            }

        });
    }

    $('#fieldSelect').select2({
        placeholder: "Select fields",
        allowClear: true
    });
    var uploaded_image = "";
    $("#picture").change(function () {
        const file = this.files[0]; // Get the selected file  
        if (file) {
            const reader = new FileReader(); // Create a FileReader object  
            reader.onload = function (e) {
                uploaded_image = e.target.result;
            };
            reader.readAsDataURL(file); // Read the file as a Data URL  
        }
    });
    ////////////////////////////////////////////////////////////////////////
    ///// Add Protocol to the href
    function ensureAbsoluteUrl(url) {
        // Check if the URL contains http or https  
        if (!/^https?:\/\//i.test(url)) {
            // Prepend https:// if the url doesn't have a protocol  
            return "https://" + url;
        }
        return url; // Return the URL as is if it already has a protocol  
    }
    $("#save").click(function () {
        // Collect form data
        var userinput = $("#userinput").val();
        var descriptioninput = $("#descriptioninput").val();
        var portfolioinput = ensureAbsoluteUrl($("#portfolioinput").val());
        var linkedininput = ensureAbsoluteUrl($("#linkedininput").val());
        var picture = $("#picture")[0].files[0]; // Get the file from the input with ID 'picture'
        // var picture = $("#picture").val(); // Assuming there's an input with ID picture for the image
        var selectedFields = $("#fieldSelect").val(); // Get selected fields from the fieldSelect

        // Collect existing fields in the div 'fields' for comparison
        var currentFields = [];
        $("#fields .btn").each(function () {
            currentFields.push($(this).text().trim());
        });

        // Check if any of the values are different
        var nameChanged = userinput !== $("#username").text().trim();
        var descriptionChanged = descriptioninput !== $("#description").text().trim();
        var linkedinChanged = linkedininput !== $("#linkedinLink").attr('href').trim();
        var portfolioChanged = portfolioinput !== $("#portfolioLink").attr('href').trim();
        var fieldsChanged = !arraysEqual(selectedFields, currentFields);
        var pictureChanged = picture && picture.name !== "" && picture !== $("#userprofile").attr("src");

        // Prepare FormData to send to the server
        var dataToSend = new FormData();

        if (nameChanged) {
            dataToSend.append("userName", userinput);
        }

        if (descriptionChanged) {
            dataToSend.append("description", descriptioninput);
        }

        if (linkedinChanged) {
            dataToSend.append("linkedin", linkedininput);
        }

        if (portfolioChanged) {
            dataToSend.append("portfolio", portfolioinput);
        }

        if (fieldsChanged) {
            dataToSend.append("selectedFields", selectedFields);
        }

        if (pictureChanged) {
            dataToSend.append("picture", picture); // Add the picture file to the form data
            dataToSend.append("currentPicture", $("#userprofile").attr("src")); // Add the picture file to the form data
        }
        dataToSend.append("purpose", "save");
        // If there are any changes, send them to the server
        if (dataToSend.has("userName") || dataToSend.has("description") || dataToSend.has("portfolio") || dataToSend.has("linkedin") || dataToSend.has("selectedFields") || dataToSend.has("picture")) {
            $("#save").addClass("d-none");
            $("#save-loader").removeClass("d-none");
            $("#close-btn").prop("disabled", true);
            $(".btn-close").prop("disabled", true);
            $.ajax({
                url: "app/profile_process.php",
                method: "POST",
                data: dataToSend,
                contentType: false, // Not to set any content header
                processData: false, // Not to process data
                dataType: "json",
                success: function (response) {
                    setTimeout(function () {
                        if (response.status === "success") {
                            // uploaded_image

                            if (dataToSend.has("userName")) {
                                $("#username").text(capitalizeFirstLetter(dataToSend.get('userName')));
                            }
                            if (dataToSend.has("portfolio")) {
                                $("#portfolioLink").attr("href", dataToSend.get('portfolio')).removeClass("d-none");
                            }

                            if (dataToSend.has("linkedin")) {
                                $("#linkedinLink").attr("href", dataToSend.get('linkedin')).removeClass("d-none");
                            }

                            if (dataToSend.has("description")) {
                                $("#description").text(capitalizeFirstLetterOfPhrase(dataToSend.get('description')));
                            }
                            if (uploaded_image != "") {
                                $("#userprofile").attr("src", uploaded_image);
                                uploaded_image = "";
                            }
                            if (dataToSend.has("selectedFields")) {
                                $("#fields").empty();
                                let fieldsArray = dataToSend.get('selectedFields').split(',');
                                fieldsArray.forEach(field => {
                                    let fieldButton = `<button class="btn btn-secondary disabled fs-7 rounded-0 my-2 me-2">${field.trim()}</button>`;
                                    $("#fields").append(fieldButton); // Append each button to the #fields container  
                                });
                            }
                            $("#edit").modal('hide');
                            $("#save").removeClass("d-none");
                            $("#save-loader").addClass("d-none");
                            $("#close-btn").prop("disabled", false);
                            $(".btn-close").prop("disabled", false);
                        } else {
                            alert("Ops! An error occurred! Please try again. If it persists, contact the support team.")
                        }
                    }, 1000);
                }
            });
        } else {
            alert("No changes was made!");
        }
    });

    // Function to compare two arrays
    function arraysEqual(arr1, arr2) {
        if (arr1.length !== arr2.length) return false;
        for (var i = arr1.length; i--;) {
            if (arr1[i] !== arr2[i]) return false;
        }
        return true;
    }

    const nameCharLimit = 100; // Character limit for name
    const otherCharLimit = 200; // Character limit for portfolio, LinkedIn, and description
    const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes

    function checkCharLimit(element, warningElement, limit) {
        if ($(element).val().length > limit) {
            $(warningElement).removeClass('d-none');
            $('#save').addClass('disabled');
            $(element).addClass("border-danger");
        } else {
            $(warningElement).addClass('d-none');
            $(element).removeClass("border-danger");
            $('#save').removeClass('disabled');
        }
    }

    $('#userinput').on('input', function () {
        checkCharLimit(this, '#name-warning', nameCharLimit);
    });

    $('#portfolioinput, #linkedininput, #descriptioninput').on('input', function () {
        const inputId = $(this).attr('id');
        checkCharLimit(this, `#${inputId}-warning`, otherCharLimit);
    });

    $('#picture').on('change', function () {
        const file = this.files[0];
        if (file.size > maxFileSize) {
            $('#picture-warning').removeClass('d-none');
            $('#save').addClass('disabled');
            $(this).addClass("border-danger");
        } else {
            $('#picture-warning').addClass('d-none');
            $('#save').removeClass('disabled');
            $(this).removeClass("border-danger");
        }
    });

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
            let password = "";

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
            // Submit password
            $("#submitPasswordBtn").on("click", function() {
                submitPassword();
            });
            $("#attemptNumBtn").on("click", function() {
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
                    success: function(response) {
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
                        } else if (data.state === "samePassword") {
                            $("#newPassword").val("");
                            $("#confirmPassword").val("");
                            $("#alertPassword").text("New Password Must be different from old password.");
                        } else if (data.state === "limitReached") {
                            $("#newPassword").val("");
                            $("#confirmPassword").val("");
                            $("#alertPassword").text("Sorry! You have reached the attempt limit. Please try again later.");
                        } else {
                            // 
                            alert("An error occurred. Please try again.");
                        }
                    }
                });
            }

            $("#verificationCode").on("input", function() {
                $("#alertCode").text("");
            })
            // Verify code
            $("#verifyCodeBtn").on("click", function() {
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
                        success: function(response) {
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
