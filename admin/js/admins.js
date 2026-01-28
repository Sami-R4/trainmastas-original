$(document).ready(function () {
    var userCurrentPage = 1, user_Id = '', totalUserPages, userMax, userTab = "allUsers", filterValue = "", adminType, createdCurrentPage = 1, feedbackCurrentPage = 1, totalfeedbackPages, totalRegisteredPages, totalCreatedPages, feedbackMax, registeredMax, createdMax, fetchUsers = false;
    ///////////////////////////////////////////////////////////////////////
    ///////// Capitalize first letters of words //////////////////
    ///////////////////////////////////////////////////////////////////////
    function formatAmount(value) {  
        const thresholds = [  
            { value: 1e9, suffix: 'B' }, // Billion  
            { value: 1e6, suffix: 'M' }, // Million  
            { value: 1e3, suffix: 'K' }   // Thousand  
        ];  
    
        // Check if the value is greater than 1000  
        for (const { value: thresholdValue, suffix } of thresholds) {  
            if (value >= thresholdValue) {  
                return (value / thresholdValue).toFixed(1).replace(/\.0$/, '') + suffix;  
            }  
        }  
        // Add "not" if value is less than 1000  
        return value;  
    }  
    function create_pages_btn(PageNbr, id, totalPages) {
        let btns = ""; // Holds the pagination buttons
        const prev = "#prevBtn" + id; // ID for the previous button
        const next = "#nextBtn" + id; // ID for the next button
        const pagination = "#pagination-Btn" + id; // ID for the pagination container

        // Clear existing pagination buttons 
        $(pagination).empty();

        // Determine the range of buttons to display
        let startPage = Math.max(1, PageNbr - 1); // Start from the previous page (if it exists)
        let endPage = Math.min(totalPages, PageNbr + 1); // End at the next page (if it exists)

        // Ensure we always display 3 buttons if possible
        if (PageNbr == 1 && totalPages > 1) {
            // First page: Show the first 3 pages if available
            endPage = Math.min(totalPages, 3);
        } else if (PageNbr == totalPages && totalPages > 1) {
            // Last page: Show the last 3 pages if available
            startPage = Math.max(1, totalPages - 2);
        } else if (totalPages > 1) {
            // Middle page: Adjust start and end to ensure 3 buttons
            startPage = Math.max(1, PageNbr - 1);
            endPage = Math.min(totalPages, PageNbr + 1);
        }

        // Generate pagination buttons
        var temp_counter = 0;

        for (let i = startPage; i <= endPage; i++) {
            var activeClass = i == PageNbr ? "custom-button" : ""; // Add the 'active' class to the current page
            btns += `<button class="btn custom-btn pageBtn ${activeClass} mx-1">${i}</button>`;
            temp_counter++;
            if (temp_counter == 3) {
                break;
            }
        }

        // Add buttons to the pagination container
        $(pagination).append(btns);

        // Manage the previous button state
        if (PageNbr == 1) {
            $(prev).addClass("disabled");
        } else {
            $(prev).removeClass("disabled");
        }

        // Manage the next button state
        if (PageNbr == totalPages) {
            $(next).addClass("disabled");
        } else {
            $(next).removeClass("disabled");
        }
    }

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
    // 
    function calculatePercentage(score, total) {
        if (total === 0) {
            return "Total cannot be zero.";
        } else {
            let percentage = (score / total) * 100;
            return `${percentage.toFixed(2)}/100`;
        }
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

    var num = 0;
    function DisplayUser(users, purpose) {
        const userDiv = document.getElementById("user-div");
        if (num >= users.total_admins || num >= userMax) {
            num = 0;
        }
        var display = "";
        if (purpose == "deletedUsers") {
            display = "d-none";
            $(".hideThisLoader").addClass("d-none");
        }
        $("#total_count").text(formatAmount("Showing " + users.total_admins) + " items");
        adminType = users.AdminType;
        users.data.forEach(user => {
            // Update the action value
            ++num;
            let actionText = user.action === 'd' ? 'Restored' :
                user.action === 'b' ? 'Unban' :
                    user.action; // Leave as is for "n" or others
            img = "../image/default-profile.png";
            var temp_btn = `<button class="btn btn-outline-success rounded-0  my-1 ${display} action-ban" id="action-ban-${num}" data-num="${num}" data-user_id="${user.user_ID}">
                ${actionText === 'Unban' ? 'Unban' : 'Ban'}
            </button> 
            <button class="fs-7 btn btn-outline-danger rounded-0 my-1 action-delete" id="action-delete-${num}" data-num="${num}" data-user_id="${user.user_ID}">
                ${actionText === 'Restored' ? 'Restore' : 'Delete'}
            </button>`;
            if (users.AdminType == "super" && user.Type == "super") {
                temp_btn = "";
            }

            if (users.AdminType == "middle" && (user.Type == "super" || user.Type == "middle")) {
                temp_btn = "";
            }
            var type_btn = `<select name="type[]" class="form-control select2 select-form-lesson type-select" required>
                <option value="">Select Admin Type *</option>
                <option value="middle">Middle</option>
                <option value="lower">Lower</option>
            </select>`;
            if (users.AdminType == "lower") {
                temp_btn = "";
                type_btn = "";
            }
            if (users.AdminType == "middle") {
                type_btn = `<select name="type[]" class="form-control select2 select-form-lesson type-select" required>
                <option value="">Select Admin Type *</option>
                <option value="lower">Lower</option>
            </select>`
            }
            $("#type-container").empty().append(type_btn);
            $(".type-select").select2({
                placeholder: "Select a value",
                width: '100%',
                minimumResultsForSearch: Infinity
            });
            // Create a new row
            const userRow = `
                <tr id="user-element-${num}">
                    <th scope="row">${num}</th>
                    <td class="profile-link" data-user_id="${user.user_ID}" data-num="${num}" id="profile-link-${num}"><img src="${img}" alt="${capitalizeFirstLetter(user.Name)}" class="rounded-circle me-1" style="width:30px; height:30px; object-fit:cover"><span>${capitalizeFirstLetter(user.Name)}</span></td>
                    <td>${user.Email}</td>
                    <td>${capitalizeFirstLetter(user.Type)}</td>
                    <td>${formatDate(user.Date)}</td>
                    <td class="text-center">
                        ${temp_btn}
                    </td>
                </tr>
            `;

            // Append the new row to the user-div
            userDiv.innerHTML += userRow;
        });
        $("#btn-containerUser").addClass("d-none");

        if (users.total_admins > 20) {
            var tempVal = (userMax !== null && userMax !== undefined) ? userMax : users.total_admins;
            totalUserPages = Math.ceil(tempVal / 20);
            userMax = users.total_admins;
            create_pages_btn(userCurrentPage, "User", totalUserPages);
            $("#btn-containerUser").removeClass("d-none");

        }
    }
    function updateUserProfileAndFields(response) {
        // Update user details
        // /////////////////////////////////////
        var actionText = response.userDetails.action === 'd' ? 'Restored' :
            response.userDetails.action === 'b' ? 'Unban' :
                response.userDetails.action; // Leave as is for "n" or others  

        $("#action-ban-btn").text(actionText === 'Unban' ? 'Unban' : 'Ban');
        $("#action-delete-btn").text(actionText === 'Restored' ? 'Restore' : 'Delete');

        $("#username").text(capitalizeFirstLetter(response.userDetails.Name));
        $("#userprofile").attr("src", "../image/default-profile.png");
        $("#userprofile").attr("alt", capitalizeFirstLetter(response.userDetails.Name));
        $("#adminType").text(capitalizeFirstLetter(response.userDetails.Type));
        $("#email").text(capitalizeFirstLetter(response.userDetails.Email));
        $("#dateJoin").text("Join on the " + formatDate(response.userDetails.Date));
        if (response.AdminType == "super" && response.userDetails.Type == "super") {
            $(".user-profile-btn-div").addClass("d-none");
        }
        if (response.AdminType == "middle" && (response.userDetails.Type == "super" || response.userDetails.Type == "middle")) {
            $(".user-profile-btn-div").addClass("d-none");
        }
        if (response.AdminType == "lower") {
            $(".user-profile-btn-div").addClass("d-none");
        }
    }


    ////////////////////////////////////////////////////////////////////
    ///////             Fetch the users details                  ///////
    ////////////////////////////////////////////////////////////////////
    // userTab filterValue
    function fetchUsersDetails(id, page, purpose, filterValue) {
        // For showing and hiding the users details table
        if (id == "") {
            $("#user-div").empty();
            $("#user-loader").removeClass("d-none");
            $("#user-container-table").addClass("d-none");
            $("#user-message").addClass("d-none");
            id = user_Id;
        }

        $.ajax({
            url: 'app/admins_process.php', // PHP script to handle logout
            type: 'POST',
            data: {
                purpose: purpose,
                id: id,
                page: page,
                filterValue: filterValue,
            },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.state === 'success') {
                    fetchUsers = true;
                    DisplayUser(data, purpose);
                    setTimeout(function () {
                        $("#user-loader").addClass("d-none");
                        if (data.total_users == 0) {
                            $("#user-container-table").addClass("d-none");
                            $("#message-empty").removeClass("d-none");
                            return;
                        } else {
                            $("#user-container-table").removeClass("d-none");
                            if (purpose == "deletedUsers" && data.total_admins > 0 && data.AdminType == "super") {
                                $("#clearAllDeleted").css("display", "flex");
                            } else {
                                $("#clearAllDeleted").css("display", "none");
                            }
                        }
                    }, 1000);
                } else if (data.state === 'noUser') {
                    setTimeout(function () {
                        $("#user-loader").addClass("d-none");
                        $("#user-message").removeClass("d-none").text("No Admin found.");
                    }, 1000);
                } else if (data.state === "admin_marked_deleted") {
                    // Show the message  
                    $('#message').text("Admin was successfully deleted.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "admin_marked_banned") {
                    // Show the message  
                    $('#message').text("Admin was successfully banned.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "admin_ban_free") {
                    // Show the message  
                    $('#message').text("Admin was successfully unban.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "admin_delete_free") {
                    // Show the message  
                    $('#message').text("Admin was successfully restored.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "successFetching") {
                    setTimeout(function () {
                        $("#profile-loader-student").addClass("d-none");
                        $("#entire-profile-div").removeClass("d-none");
                        $("#page-title").text(capitalizeFirstLetter(data.userDetails.Name) + "'s Profile setting.");
                        updateUserProfileAndFields(data);
                    }, 1000);
                } else if (data.state === "deleted_success") {
                    $('#confirmClearModal').modal('hide');
                    $("#clearAllDeleted").css("display", "none");
                    if (data.userNotCleared.length > 0) {
                        $('#message').text("Some users were cleared successfully! Users not cleared: " + data.userNotCleared.length).fadeIn(1000);
                        setTimeout(function () {
                            $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                        }, 1000);
                        fetchUsersDetails("", userCurrentPage, userTab, filterValue);
                    } else {
                        // Show the message  
                        $('#message').text("Admin cleared successfully!").fadeIn(1000);
                        setTimeout(function () {
                            $("#user-loader").addClass("d-none");
                            $("#user-message").removeClass("d-none").text("No admin found.");
                            $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                        }, 1000); // Wait 2 seconds before starting to fade out
                    }
                } else if (data.state === "notAuthorized") {
                    $('#message').text(data.message).css("background-color", "red").fadeIn(1000); // 1000 ms = 1 second to fade out  
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000);
                    setTimeout(function () {
                        $('#message').css("background-color", "#28a745");
                    }, 5000);
                } else if (data.state === "notfound") {
                    // Show the message  
                    $('#message').text("Users not found. You will be redirected.").fadeIn(1000);
                    $(".profile-btn").addClass("d-none");
                    $("#profile-container").addClass("d-none");
                    $("#user-container-table").addClass("d-none");
                    $("#user-container").removeClass("d-none");
                    $("#user-loader").removeClass("d-none");
                    var url = new URL(window.location);
                    url.searchParams.delete('c'); // Remove the 'c' parameter from the URL
                    window.history.replaceState({}, document.title, url); // Update the URL without reloading the page
                    if (fetchUsers == false) {
                        fetchUsersDetails("", userCurrentPage, userTab, filterValue);
                    } else {
                        setTimeout(function () {
                            $("#user-container-table").removeClass("d-none");
                            $("#user-loader").addClass("d-none");
                            $('#message').fadeOut(2000); // 2000 ms = 1 second to fade out  
                        }, 1000);
                    }
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 2000 ms = 1 second to fade out  
                    }, 1000);
                    // Wait 2 seconds before starting to fade out
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    }

    // Initial call
    $("#user-div").empty();
    var urlParams = new URLSearchParams(window.location.search);
    var cValue = urlParams.get('c');
    if (cValue) {
        user_Id = cValue;
        $("#newAdmin-btn-container").addClass("d-none");
        $("#action-ban-btn").data("user_id", user_Id);
        $("#action-delete-btn").data("user_id", user_Id);
        $(".profile-btn").removeClass("d-none");
        $("#user-container").addClass("d-none");
        $("#profile-container").removeClass("d-none");
        fetchUsersDetails(user_Id, "", "sentThisUserDetails", "");
    } else {
        $("#page-title").text("Admins Management");
        fetchUsersDetails("", '1', "allUsers", filterValue);
    }

    ////////////////////////////////////////////////////////////////////
    ///////                 User Navigation Bnts                 ///////
    ////////////////////////////////////////////////////////////////////
    // operations for prevBtn 
    $("#prevBtnUser").on("click", function () {
        // Ensure page doesn't go below 1
        if (userCurrentPage > 1) {
            $("#nextBtnUser").addClass("disabled");
            $("#prevBtnUser").addClass("disabled");
            var containerTop = $("#UserDiv").offset().top;
            $("html, body").scrollTop(containerTop);
            userCurrentPage--;
            $("#pagination-BtnUser .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnUser .pageBtn:contains('${userCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                fetchUsersDetails("", userCurrentPage, "allUsers", filterValue);
            }, 800);
        }
    });

    // operations for nextBtn
    $("#nextBtnUser").on("click", function () {
        // Ensure current page doesn't exceed total pages
        if (userCurrentPage < totalUserPages) {
            $("#nextBtnUser").addClass("disabled");
            $("#prevBtnUser").addClass("disabled");
            var containerTop = $("#UserDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            userCurrentPage++;

            $("#pagination-BtnUser .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnUser .pageBtn:contains('${userCurrentPage}')`).addClass("custom-button");
            setTimeout(function () {
                fetchUsersDetails("", userCurrentPage, "allUsers", filterValue);
            }, 800);
        }
    });
    // operations for in between prevBtn and nextBtn
    $("#pagination-BtnUser").on("click", ".pageBtn", function () {
        $("#pagination-BtnUser .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        userCurrentPage = $(this).text();
        var containerTop = $("#UserDiv").offset().top;
        $("html, body").scrollTop(containerTop);
        setTimeout(function () {
            fetchUsersDetails("", userCurrentPage, "allUsers", filterValue);
        }, 800);
    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////    End Pagination btns    ///////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Press enter on the filter by registered course
    $("#numberInput").on("keypress", function (event) {
        // Check if the key pressed is the Enter key (key code 13)  
        if (event.which === 13) {
            num = 0;
            event.preventDefault(); // Prevent the default action (form submission)  
            filterValue = $(this).val(); // Collect the input value  
            userCurrentPage = 1;
            fetchUsersDetails("", userCurrentPage, userTab, filterValue);
        }
    });
    $(".user-navLinks").click(function () {
        $("#clearAllDeleted").css("display", "none");
        $("#message-empty").addClass("d-none");
        num = 0;
        userTab = $(this).data("id");
        userCurrentPage = 1;
        $("#numberInput").val("");
        filterValue = "";
        fetchUsersDetails("", userCurrentPage, userTab, filterValue);
        $(".user-navLinks").removeClass("active-user-navLinks");
        $(this).addClass("active-user-navLinks");
    })
    $("#confirmClear").click(function () {
        fetchUsersDetails("", "", "clearAll", "");
    })

    var temp_container_element_id, temp_container_btn, temp_container_btn_value;
    $(".user-div").on("click", ".action-ban", function () {
        var num = $(this).data("num");
        var temp_element_id = "#action-ban-" + num;
        var temp_action = "banThis";
        temp_container_element_id = temp_element_id;
        temp_container_btn = "#action-ban-btn";

        if ($(this).text().trim() == "Unban") {
            temp_action = "unBanThis";
            temp_container_btn_value = "Ban";
        } else {
            temp_container_btn_value = "Unban";
            temp_element_id = "#action-delete-" + num;
            $(temp_element_id).text("Delete");
            $("#action-delete-btn").text("Delete");
        }
        var temp_id = $(this).data("user_id");
        fetchUsersDetails(temp_id, "", temp_action, "");
    })
    $(".user-div").on("click", ".action-delete", function () {
        var num = $(this).data("num");
        var temp_element_id_div = "#user-element-" + num;
        var temp_element_id = "#action-delete-" + num;
        var temp_action = "deleteThis";
        temp_container_btn = "#action-delete-btn";
        temp_container_element_id = temp_element_id;
        if ($(this).text().trim() == "Restore") {
            temp_action = "restoreThis";
            temp_container_btn_value = "Delete";
        } else {
            temp_container_btn_value = "Restore";
            temp_element_id = "#action-ban-" + num;
            $(temp_element_id).text("Ban");
            $("#action-ban-btn").text("Ban");
        }
        if (userTab == "deletedUsers") {
            $(temp_element_id_div).remove();
            var rowCount = $('#user-div tr').length;
            // Check if there is only one row  
            if (rowCount === 0) {
                $("#user-message").removeClass("d-none").text("No user found.");
                $("#user-container-table").addClass("d-none");
                $("#clearAllDeleted").css("display", "none");
            }
        }
        var temp_id = $(this).data("user_id");
        fetchUsersDetails(temp_id, "", temp_action, "");
    })
    $("#user-div").on("click", ".profile-link", function () {
        $("#message-empty").addClass("d-none");
        var num = $(this).data("num");
        user_Id = $(this).data("user_id");
        var temp_element_id = "#profile-link-" + num;
        $("#action-delete-btn").data("num", num).data("user_id", user_Id);
        $("#action-ban-btn").data("num", num).data("user_id", user_Id);
        $(".profile-btn").removeClass("d-none");
        $("#profile-container").removeClass("d-none");
        $("#profile-loader-student").removeClass("d-none");
        $("#entire-profile-div").addClass("d-none");
        $("#user-container").addClass("d-none");
        // Assuming user_Id is defined and your variable is named correctly  
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        params.set('c', user_Id); // Update or add the 'c' parameter  
        url.search = params.toString();
        // Use history.replaceState to update the URL without reloading  
        history.replaceState(null, '', url.toString());

        fetchUsersDetails(user_Id, "", "sentThisUserDetails", "");
    })
    $("#admin-btn").on("click", function () {
        $("#newAdmin-btn-container").removeClass("d-none");
        $("#message-empty").addClass("d-none");
        $(".user-profile-btn-div").removeClass("d-none");
        $(".profile-btn").addClass("d-none");
        $("#profile-container").addClass("d-none");
        $("#user-container-table").addClass("d-none");
        $("#user-container").removeClass("d-none");
        $("#user-loader").removeClass("d-none");
        var url = new URL(window.location);
        url.searchParams.delete('c'); // Remove the 'c' parameter from the URL
        window.history.replaceState({}, document.title, url); // Update the URL without reloading the page  
        if (fetchUsers == false) {
            filterValue = "";
            userTab = "allUsers";
            fetchUsersDetails("", '1', "allUsers", filterValue);
            $("#page-title").text("Teacher Management")
        }
        setTimeout(function () {
            $("#user-loader").addClass("d-none");
            $("#user-container-table").removeClass("d-none");
        }, 800);
    })

    ///////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////
    ///////////////            Submit the new lesson(s)           /////////////////
    ///////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////
    // Function to check for duplicate lessons
    function isDuplicateLesson() {
        let lessons = [];
        let duplicate = false;

        $(".lesson-row").each(function () {
            let name = $(this).find("input[name='name[]']").val().trim();
            let email = $(this).find("select[name='email[]']").val();
            let type = $(this).find("select[name='type[]']").val();

            let lessonKey = `${name}|${email}|${type}`;

            if (lessons.includes(lessonKey)) {
                duplicate = true;
                return false;
            }
            lessons.push(lessonKey);
        });
        return duplicate;
    }
    var record_controller = true;
    // Function to check character limit
    function checkCharLimit(input, maxLength, alertSpan) {
        let length = $(input).val().length;
        let remaining = maxLength - length;

        if (length > maxLength) {
            $(input).addClass("border-danger");
            $(alertSpan).text(`Exceeded by ${Math.abs(remaining)} characters!`).show().removeClass("text-muted").addClass("text-danger");
            record_controller = false;
        } else {
            $(input).removeClass("border-danger");
            $(alertSpan).text(`Remaining: ${remaining}`).toggle(remaining < maxLength).removeClass("text-danger").addClass("text-muted");
            record_controller = true;
        }
    }

    // Attach character limit check to inputs
    $(document).on("input", "input[name='name[]']", function () {
        let span = $(this).siblings(".char-alert");
        checkCharLimit(this, 100, span);
    });
    // Attach character limit check to inputs
    $(document).on("input", "input[name='email[]']", function () {
        let span = $(this).siblings(".char-alert");
        checkCharLimit(this, 200, span);
    });

    // Function to check file size (max 20MB)
    function isValidFileSize(input) {
        let file = input.files[0];
        if (file && file.size > 20 * 1024 * 1024) {
            record_controller = false;
            return false;
        }
        record_controller = true;
        return true;
    }

    // File size validation
    $(document).on("change", "input[name='file[]']", function () {
        let fileAlert = $(this).siblings(".file-alert");
        if (!isValidFileSize(this)) {
            $(this).addClass("border-danger");
            fileAlert.text("File exceeds 20MB limit!").show();
        } else {
            $(this).removeClass("border-danger");
            fileAlert.hide();
        }
    });
    // Use event delegation for rows dynamically added to #lessonsContainer
    $("#lessonsContainer").on('change', '.subject-select', function () {
        // Get the current row
        var $row = $(this).closest('.lesson-row');

        // Extract the selected subject's data attributes
        var selectedOption = $(this).find('option:selected');
        var subjectLevel = selectedOption.data('level');    // e.g. "Primary" or "Secondary"
        var subjectSection = selectedOption.data('section');  // e.g. "Anglophone", "Francophone", or "Any"
        var subjectField = selectedOption.data('field');    // e.g. "Science", "Commercial", etc.

        // Options to be reused when reinitializing select2
        var select2Options = {
            placeholder: "Select a value",
            width: '100%',
            minimumResultsForSearch: Infinity
        };

        // --- Filter the Class Select ---
        var $classSelect = $row.find('.class-select');
        if (!$classSelect.data('allOptions')) {
            $classSelect.data('allOptions', $classSelect.html());
        }
        var allClassOptions = $classSelect.data('allOptions');
        var filteredClassOptions = $(allClassOptions).filter(function () {
            var val = $(this).val();
            if (val === "") return true; // Always keep the placeholder option
            if (subjectLevel === "Primary") {
                // Primary classes (e.g. values starting with "C")
                return (val.charAt(0) === "C");
            } else if (subjectLevel === "Secondary") {
                // Secondary classes (values starting with "F" or equal to "LS"/"US")
                return (val.charAt(0) === "F" || val === "LS" || val === "US");
            }
            return true;
        });
        $classSelect.select2('destroy').html(filteredClassOptions).select2(select2Options);

        // --- Filter the Sub-System Select ---
        var $subsystemSelect = $row.find('.subsystem-select');
        if (!$subsystemSelect.data('allOptions')) {
            $subsystemSelect.data('allOptions', $subsystemSelect.html());
        }
        var allSubsystemOptions = $subsystemSelect.data('allOptions');
        var filteredSubsystemOptions = $(allSubsystemOptions).filter(function () {
            var val = $(this).val();
            if (val === "") return true;
            if (subjectSection === "Any") {
                return true;
            }
            return (val === subjectSection);
        });
        $subsystemSelect.select2('destroy').html(filteredSubsystemOptions).select2(select2Options);

        // --- Filter the Field Select ---
        var $fieldSelect = $row.find('.field-select');
        if (!$fieldSelect.data('allOptions')) {
            $fieldSelect.data('allOptions', $fieldSelect.html());
        }
        var allFieldOptions = $fieldSelect.data('allOptions');
        var filteredFieldOptions = $(allFieldOptions).filter(function () {
            var val = $(this).val();
            if (val === "") return true;
            if (subjectField === "Any") {
                return true;
            }
            return (val === subjectField);
        });
        $fieldSelect.select2('destroy').html(filteredFieldOptions).select2(select2Options);
    });
    // Add More Lessons
    var temp = 2;
    function addLesson() {
        var temp_btn = "";
        // Only append if the current lesson count is less than 10
        if (adminType == "super" && adminType == "super") {
            temp_btn = `<!-- Type Select -->
                <div class="col mt-2">
                    <select name="type[]" class="form-control select2 select-form-lesson type-select" required>
                        <option value="">Select Admin Type *</option>
                        <option value="middle">Middle</option>
                        <option value="lower">Lower</option>
                    </select>
                </div>`;
        }

        if (adminType == "middle" && (adminType == "super" || adminType == "middle")) {
            temp_btn = `<!-- Type Select -->
                <div class="col mt-2">
                    <select name="type[]" class="form-control select2 select-form-lesson type-select" required>
                        <option value="">Select Admin Type *</option>
                        <option value="lower">Lower</option>
                    </select>
                </div>`;
        }
        if (adminType == "lower") {
            temp_btn = "";
        }
        if (temp <= 10) {
            // Create the lesson HTML using template literals with the current lesson number
            let lessonTemplate = `
            <div class="fw-semibold text-muted">
                Admin ${temp}:
            </div>
            <div class="lesson-row row mb-3" data-row="${temp}">
                <!-- Name and Email -->
                <div class="col mt-2">
                    <input type="text" value="" name="name[]" style="min-width:100px" class="form-control" placeholder="Name *" required>
                    <span class="char-alert text-muted" style="display:none;"></span>
                </div>
                <div class="col mt-2">
                    <input type="email" value="" name="email[]" style="min-width:100px" class="form-control" placeholder="Email *" required>
                    <span class="char-alert text-muted" style="display:none;"></span>
                </div>
                ${temp_btn}
                <hr class="mt-3 mx-auto" style="width:95%">

            </div>
          `;
            // Append the new lesson template to the container
            $("#lessonsContainer").append(lessonTemplate);

            $(".select-form-lesson").select2({
                placeholder: "Select a value",
                width: '100%',
                minimumResultsForSearch: Infinity
            });

            // Increment the lesson counter
            temp++;

            // If temp reaches 10, hide the add button
            if (temp > 10) {
                $("#addLessonRow").hide();
            }
            $("#removeLessonRow").show();
        } else {
            // Already 10 lessons: ensure the add button is hidden
            $("#addLessonRow").hide();
        }
    }

    function removeLesson() {
        if (temp > 1) {
            // Find the last lesson-row and its corresponding title div
            $("#lessonsContainer .lesson-row").last().prev().remove(); // Remove the "Lesson X:" label
            $("#lessonsContainer .lesson-row").last().remove(); // Remove the actual lesson row

            // Decrement the lesson counter
            temp--;

            // If temp goes below 10, show the add button again
            if (temp <= 10) {
                $("#addLessonRow").show();
            }
        }
        if (temp == 2) {
            $("#removeLessonRow").hide();
        }
    }
    // Example usage: Bind the addLesson function to your add button
    $("#addLessonRow").on("click", function (e) {
        addLesson();
    }); $("#removeLessonRow").on("click", function (e) {
        removeLesson();
    });
    $(document).on("click", function (e) {
        // Check if the clicked target is not inside a .char-alert element
        $(".char-alert").hide();
        $("#alertIssue").hide();
    });
    // Form submission with AJAX
    var links = "";
    $("#newAdmin-btn").click(function () {
        $("#submit-btn-admin").prop("false", true);
    })
    $("#lessonForm").on("submit", function (e) {
        e.preventDefault();
        $("#submit-btn-admin").prop("disabled", true);
        if (isDuplicateLesson()) {
            alert("Duplicate lessons detected! Modify entries before submitting.");
            return;
        }

        let formData = new FormData(this);
        formData.append('purpose', 'newAdmin');
        if (record_controller = true) {

            $.ajax({
                url: "app/admins_process.php",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    if (response.state == "success") {
                        $('#addLessonModal').modal('hide');
                        $('#alertLessonSuccess').modal('show');
                        for (temp; temp > 1; temp--) {
                            removeLesson();
                        }
                        temp = 2;
                        $(".lesson-row").find("input, select").val("").trigger("change");
                        $(".lesson-row").find(".char-alert, .file-alert").text("").hide();
                        $(".lesson-row").removeClass("border-danger");
                        $("#numberAdded").text("Number Added: " + response.addedAdmins.length);
                    } else {
                        alert("Error: " + response.message);
                    }
                }
            });

        } else {
            $("#alertIssue").show();
        }
    });
})