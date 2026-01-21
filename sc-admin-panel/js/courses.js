$(document).ready(function () {
    var courseCurrentPage = 1, course_id = '', moduleButtonsHtml = '', test_add_btn = true, totalcoursePages, courseMax, courseTab = "allCourses", filterValue = "", registeredCurrentPage = 1, UserCurrentPage = 1, feedbackCurrentPage = 1, totalfeedbackPages, totalRegisteredPages, totalUserPages, feedbackMax, registeredMax, UserMax, fetchcourses = false, modulePurpose = "default", moduleVal = 1, editing = false;
    ///////////////////////////////////////////////////////////////////////
    ///////// Capitalize first letters of words //////////////////
    ///////////////////////////////////////////////////////////////////////

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
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Format Amount to smaller character(eg 1000=1M, 1000000=1M, 1000000000=1B)
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
    var num = 0;
    function displayCourses(courses, purpose) {
        const courseDiv = document.getElementById("course-div");
        if (num >= courses.total_courses || num >= courseMax) {
            num = 0;
        }
        var display = "";
        if (purpose == "deletedCourses") {
            display = "d-none";
            $(".hideThisLoader").addClass("d-none");
        }
        $("#total_count").text(formatAmount("Showing " + courses.total_courses) + " items");
        courses.data.forEach(course => {
            let actionText = course.action === 'd' ? 'Restored' :
                course.action === 'b' ? 'Unban' :
                    course.action; // Leave as is for "n" or others

            let img = course.Cover_image ? "../covers/" + course.Cover_image : "../image/default-course.jpg";
            let creatorImg = course.creator_image ? "../profile/" + course.creator_image : "../image/default-profile.png";
            var tr = ``, tr_action = ``;
            if (course.rejected_date == null) {
                if (course.action == "e" && course.submitted_date != null) {
                    tr += ` 
                     <button class="btn btn-outline-success rounded-0 my-1 ${display} action-validate" id="action-validate-${num}" data-num="${num}" data-course_id="${course.course_ID}">
                        Validate
                    </button> 
                     <button class="btn btn-outline-danger rounded-0 my-1 ${display} action-reject"data-bs-toggle="modal" data-bs-target="#confirmRejection" id="action-reject-${num}" data-num="${num}" data-course_id="${course.course_ID}">
                        Reject
                    </button>`;
                    tr_action = "d-none";
                }
                tr += ` <button class="btn btn-outline-success rounded-0 my-1 ${display} ${tr_action} action-ban" id="action-ban-${num}" data-num="${num}" data-course_id="${course.course_ID}">
                ${actionText === 'Unban' ? 'Unban' : 'Ban'}
                </button> 
                <button class="fs-7 btn btn-outline-danger rounded-0 my-1 ${tr_action} action-delete" id="action-delete-${num}" data-num="${num}" data-can_delete="${course.registered_users > 0 ? 'yes' : 'no'}" data-course_id="${course.course_ID}">
                    ${actionText === 'Restored' ? 'Restore' : 'Delete'}
                </button>`;
            } else {
                tr += "Rejected";
            }

            const courseRow = `
            <tr id="course-element-${++num}">
                <th scope="row">${num}</th>
                <td class="profile-link" data-course_id="${course.course_ID}" data-num="${num}" id="profile-link-${num}">
                    <img src="${img}" alt="${course.Title}" class="rounded me-1" style="width:40px; height:40px; object-fit:cover">
                    <span>${course.Title}</span>
                </td>
                <td>${course.Category}</td>
                <td>${formatAmount(course.Num_modules)}</td>
                <td>${course.Num_test != 0 ? formatAmount(course.Num_test) : "N/A"}</td>
                <td>${course.Cost == 0 ? "Free" : formatAmount(course.Cost) + " USD"}</td>
                <td>
                <a href="teachers.php?c=${course.user_ID}" class="hover text-black">
                    <img src="${creatorImg}" alt="${course.creator_name}" class="rounded-circle me-1" style="width:30px; height:30px; object-fit:cover">
                    <span>${course.creator_name}</span>
                </a>
                </td>
                <td>${formatAmount(course.registered_users)}</td>
                <td>${formatAmount(course.active_users)}</td>
                <td>${formatAmount(course.feedback_count)}</td>
                <td>${formatDate(course.Date)}</td>
                <td class="text-center">
                   ${tr}
                </td>
            </tr>
        `;

            courseDiv.innerHTML += courseRow;
        });

        $("#btn-containercourse").addClass("d-none");

        if (courses.total_courses > 20) {
            var tempVal = (courseMax !== null && courseMax !== undefined) ? courseMax : courses.total_courses;
            totalcoursePages = Math.ceil(tempVal / 20);
            courseMax = courses.total_courses;
            create_pages_btn(courseCurrentPage, "course", totalcoursePages);
            $("#btn-containercourse").removeClass("d-none");
        }
    }
    //////////////////////////////////////////////////////////////////// 
    ////////////////    Display Feedback   /////////////////// 
    //////////////////////////////////////////////////////////////////// 
    function displayFeedback(response) {
        if (!response || !response.courseFeedback) return;

        var feedbackHtml = "";
        // Update total feedback count (if provided)
        if (response.totalFeedback !== undefined) {
            $("#feedback-num").text(response.totalFeedback);
        }
        // Iterate over each feedback entry
        response.courseFeedback.forEach(function (fb) {

            var temp_link_url = "students.php?c=";
            if (fb.type == "c") {
                temp_link_url = "teachers.php?c=";
            }
            var imageSrc = "../image/default-profile.png";
            if (fb.feedback_giver_image) {
                imageSrc = "../profile/" + fb.feedback_giver_image;
            }
            feedbackHtml += `
            <div class="feedback-item py-3" style="cursor:default">
                <div>
                    <span class="fs-7 text-muted fw-semibold mb-0">
                        <a class="hover" style="color:#6c757d;" href="${temp_link_url + fb.feedback_giver_ID}">
                        <img src="${imageSrc}" class="rounded-circle  mt-2" alt="${capitalizeFirstLetter(fb.feedback_giver_name)}" style="width:40px;height:40px;object-fit:cover">
                        ${capitalizeFirstLetter(fb.feedback_giver_name)}</a>
                    </span>
                </div>
                <p class="fs-6 py-0 mb-0 mt-1"><span>${capitalizeFirstLetterOfPhrase(fb.Feedback)}</span></p>
                <div class="d-flex justify-content-between mt-2">
                <p class="fs-6 py-0 mb-0 mt-1"><span>${generateStarRating(fb.Rate)}</span></p>
                    <div class="text-muted fs-7">${formatDate(fb.Date)}</div>
                </div>
            </div>
            <hr class="py-0 my-0">`;
        });

        // Fallback if no feedback exists
        if (feedbackHtml === "") {
            feedbackHtml = `<div class="text-center py-2">
                             <hr class="py-0 mb-3 mt-0">
                             No feedback provided.
                         </div>`;
        } else {
            feedbackHtml = '<hr class="py-0 my-0 mt-3">' + feedbackHtml;
            if (response.totalFeedback > 5 || feedbackMax > 5) {
                var tempVal = feedbackMax || response.totalFeedback;
                totalfeedbackPages = Math.ceil(tempVal / 5);
                feedbackMax = response.totalFeedback;
                create_pages_btn(feedbackCurrentPage, "FeedbackCourse", totalfeedbackPages);
                $("#btn-containerFeedbackCourse").removeClass("d-none");
            }
        }

        $("#course-feedback").empty().append(feedbackHtml);
    }


    //////////////////////////////////////////////////////////////////// 
    ////////////////     Display Registered Users    /////////////////// 
    //////////////////////////////////////////////////////////////////// 
    function displayRegisteredUsers(response) {
        if (!response || !response.registeredUsers) return;

        var registeredHtml = "";
        // Update total registered users count (if provided)
        if (response.totalRegisteredUsers !== undefined) {
            $("#registered-num").text(response.totalRegisteredUsers);
        }

        // Iterate over each registered user entry
        response.registeredUsers.forEach(function (reg) {
            var levelDisplay = (reg.Level === "c") ? "Completed" : reg.Level;
            registeredHtml += `
            <div class="registered-item py-3" style="cursor:default">
                <h2 class="fs-6 text-success fw-semibold mb-0">${capitalizeFirstLetter(reg.Name)}</h2>
                <div class="d-flex justify-content-between mt-2">
                    <p class="fs-6 py-0 mb-0 mt-1">Level: <span>${levelDisplay}</span></p>
                    <p class="fs-7 py-0 my-0 text-muted">${formatDate(reg.Date)}</p>
                </div>
            </div>
            <hr class="py-0 my-0">`;
        });

        // Fallback if no registered users exist
        if (registeredHtml === "") {
            registeredHtml = `<div class="text-center py-2">
                             <hr class="py-0 mb-3 mt-0">
                             This course has no registered users.
                         </div>`;
        } else {
            registeredHtml = '<hr class="py-0 my-0 mt-3">' + registeredHtml;
            if (response.totalRegisteredUsers > 5 || registeredMax > 5) {
                var tempVal = registeredMax || response.totalRegisteredUsers;
                totalRegisteredPages = Math.ceil(tempVal / 5);
                registeredMax = response.totalRegisteredUsers;
                create_pages_btn(registeredCurrentPage, "RegisteredCourse", totalRegisteredPages);
                $("#btn-containerRegisteredCourse").removeClass("d-none");
            }
        }
        $("#course-registered").empty().append(registeredHtml);
    }


    //////////////////////////////////////////////////////////////////// 
    ////////////////    Display Course Basic Details   /////////////////// 
    //////////////////////////////////////////////////////////////////// 
    function displayCourseBasicDetails(response) {
        if (!response || !response.courseData) return;

        var courseData = response.courseData;

        // /////////////////////////////////////
        var actionText = response.courseData.action === 'd' ? 'Restored' :
            response.courseData.action === 'b' ? 'Unban' :
                response.courseData.action; // Leave as is for "n" or others  
        $("#reject-message").addClass("d-none");
        if (response.courseData.rejected_date == null) {
            $("#action-ban-btn").text(actionText === 'Unban' ? 'Unban' : 'Ban');
            $("#action-delete-btn").text(actionText === 'Restored' ? 'Restore' : 'Delete');
        } else {
            $(".div-actions").addClass("d-none");
            $("#action-validate-btn").addClass("d-none");
            $("#action-reject-btn").addClass("d-none");
            $("#reject-message").removeClass("d-none");
        }
        $(".editing-features").addClass("d-none");
        // Assign basic course details using where needed
        $("#course_Title").text(capitalizeFirstLetter(courseData.Title));
        $("#course_Description").text(capitalizeFirstLetterOfPhrase(courseData.Description));
        $("#course_Category").text(capitalizeFirstLetterOfPhrase(courseData.Category));
        $("#course_Cost").text(formatAmount(courseData.Cost));
        $("#course_Num_modules").text("Module Num: " + courseData.Num_modules);
        $("#course_Num_test").text(`Test Num: ${courseData.Num_test != 0 ? formatAmount(courseData.Num_test) : "N/A"}`);
        $("#creator_link").attr("href", "teachers.php?c=" + courseData.user_ID);
        $("#course_creator").text(capitalizeFirstLetter(courseData.creator_name));
        $("#course_action").text("State: " +
            (courseData.action === 'n' ? 'None' :
                (courseData.action === 'e' ? 'Editing' :
                    (courseData.action === 'd' ? 'Deleted' :
                        (courseData.action === 'b' ? 'Banned' :
                            (courseData.action === 'none' ? 'None' : 'Unknown, Report this to the support team.')))))
        );
        $("#course_date").text(formatDate(courseData.Date));
        $("#course_submitted_date").text(courseData.submitted_date ? "Edited and submitted on: " + formatDate(courseData.submitted_date) : "");
        $("#course_validated_date").text(courseData.validated_date ? "Validated on: " + formatDate(courseData.validated_date) : "");

        // Set cover image if available
        if (courseData.Cover_image) {
            $("#course_Cover_image").attr("src", "../covers/" + courseData.Cover_image);
        } else {
            $("#course_Cover_image").attr("src", "../image/default-course.jpg");
        }
        // Set cover image if available
        if (courseData.creator_image) {
            $("#course_creator_image").attr("src", "../profile/" + courseData.creator_image);
        } else {
            $("#course_creator_image").attr("src", "../image/default-profile.png");
        }
        var temp_elements = ""; // Initialize temp_elements as an empty string  
        for (var i = 0; i < response.scopes.length; i++) { // Corrected loop condition  
            // Use template literal correctly to include the Scope value  
            var btn = `<button class="btn btn-secondary disabled fs-7 rounded-0 my-2 me-2">${response.scopes[i].Scope}</button>`;
            temp_elements += btn; // Append the button to temp_elements  
        }
        if (response.registeredUsers.length == 0) {
            $("#action-delete-btn").data("can_delete", "yes");
        }

        var numModules = parseInt(response.courseData.Num_modules, 10);
        moduleButtonsHtml = "";
        // Create buttons with a common class "module-btn" 
        for (var i = 1; i <= numModules; i++) {
            moduleButtonsHtml += `<button class="module-btn btn btn-outline-success rounded-0 me-2 mt-3" data-purposeval="${i}">Module ${i}</button>`;
        }
        if (response.courseData.Num_test != 0) {
            moduleButtonsHtml += `<button class="module-btn btn btn-outline-success rounded-0 me-2 mt-3" data-purposeval="test">Test</button>`;
            test_add_btn = false;
        }
        $("#module-buttons-container").html(moduleButtonsHtml);
        $("#fields").empty().append(temp_elements); // Empty the container and append the buttons
    }

    //////////////////////////////////////////////////////////////////// 
    ////////////////    Display Modules and Videos   /////////////////// 
    //////////////////////////////////////////////////////////////////// 
    function displayModulesAndVideos(response) {
        if (!response || (!response.module || response.module == "") || (!response.video || response.video.length == 0 || response.video == "")) {
            $("#module-buttons-container").addClass("d-none");
            $("#container_module").html('<span>No result found</span>');
            return;
        };
        var temp_controller = false;
        $("#module-buttons-container").removeClass("d-none");
        if (response.editng_module_Nums) {
            // Create buttons with a common class "module-btn" 
            var temp_moduleButtonsHtml = '';
            for (var i = 0; i < response.editng_module_Nums.length; i++) {
                temp_moduleButtonsHtml += `<button class="module-btn btn btn-outline-success rounded-0 me-2 mt-3" data-purposeval="${response.editng_module_Nums[i]}">Module ${response.editng_module_Nums[i]}</button>`;
            }
            if (response.test == "yes") {
                temp_moduleButtonsHtml += `<button class="module-btn btn btn-outline-success rounded-0 me-2 mt-3" data-purposeval="test">Test</button>`;
            }
            if (editing == true && response.courseData.rejected_date == null) {
                temp_moduleButtonsHtml += `<div class="mt-3" id="action-validate-reject-container-btn">
                    <button class="btn btn-outline-success rounded-0 me-2 action-validate-reject" data-purpose="validate" data-course_id="${response.module.course_ID}">Validate</button>
                    <button class="btn btn-outline-danger rounded-0  action-reject" data-bs-toggle="modal" data-bs-target="#confirmRejection" data-course_id="${response.module.course_ID}">Reject</button> 
                    </div>`;
                $("#confirmReject").data("course_id", response.module.course_ID);
            }
            $("#module-buttons-container").empty().html(temp_moduleButtonsHtml);
        } else {
            if (response.test == "yes" && test_add_btn == true) {
                moduleButtonsHtml += `<button class="module-btn btn btn-outline-success rounded-0 me-2 mt-3" data-purposeval="test">Test</button>`;
                test_add_btn = false;
            }
            $("#module-buttons-container").html(moduleButtonsHtml);
        }
        // Display module details – assuming response.module holds details for Module 1
        var moduleHtml = '';
        var moduleTitle = "Video Lesson"
        if (response.module && response.module.Module_num) {
            moduleHtml = `
            <div class="module-details mb-5">  
                <h3>Module ${response.module ? response.module.Module_num : ""}: ${response.module && response.module.Title ? capitalizeFirstLetter(response.module.Title) : ""}</h3>  
                <p class="displayTextAsItIs">${response.module && response.module.Description ? capitalizeFirstLetterOfPhrase(response.module.Description) : ""}</p>  
            </div>`;
            moduleTitle = capitalizeFirstLetter(response.module.Title);
            temp_controller = true;
        }
        var videoHtml = '';
        if (response.video && response.video.length > 0) { // Check if response.video exists and has elements  
            videoHtml = response.video.map(item => `  
            <div class="col-12 col-md-8 col-lg-7">  
                <iframe style="width:100%; height:300px" src="${item.URL}"   
                    title="${moduleTitle}" frameborder="0"  
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"   
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>  
                </iframe>  
                <hr class='my-4'> 
            </div>  
        `).join(''); // Join the array of HTML strings into a single string  
        }
        $("#module-number").addClass("d-none");
        if (temp_controller == false) {
            $("#module-number").removeClass("d-none");
        }

        // Append module and video info to the container div
        $("#container_module").empty().html(moduleHtml + videoHtml);
    }



    //////////////////////////////////////////////////////////////////// 
    ////////////////            Display Test         /////////////////// 
    //////////////////////////////////////////////////////////////////// 
    function displayTest(response) {
        if (!response || response.test == "") {
            $("#module-buttons-container").addClass("d-none");
            $("#container_module").html('<span>No result found</span>');
            return;
        };
        $("#module-buttons-container").removeClass("d-none");
        // Build HTML for test questions
        var testHtml = `<div class="test-container"><h3>Test Questions</h3>`;
        if (response.test && response.test.length > 0) {
            response.test.forEach(function (question) {
                testHtml += `
                <div class="test-question py-3 border-bottom container-fluid">
                    <h5>Question ${question.Question_num}: <span class="displayTextAsItIs">${capitalizeFirstLetterOfPhrase(question.Question)}</span></h5>
                    <div class="row">
                        <div class="col ps-2 mt-2"><span class="fw-semibold">A.</span> <span class="displayTextAsItIs">${capitalizeFirstLetterOfPhrase(question.Option_A)}</span></div>
                        <div class="col ps-2 mt-2"><span class="fw-semibold">B.</span> <span class="displayTextAsItIs">${capitalizeFirstLetterOfPhrase(question.Option_B)}</span></div>
                        <div class="col ps-2 mt-2"><span class="fw-semibold">C.</span> <span class="displayTextAsItIs">${capitalizeFirstLetterOfPhrase(question.Option_C)}</span></div>
                        <div class="col ps-2 mt-2"><span class="fw-semibold">D.</span> <span class="displayTextAsItIs">${capitalizeFirstLetterOfPhrase(question.Option_D)}</span></div>
                    </div>
                    <p class="text-muted mt-2">Answer: ${question.Answer}</p>
                </div>`;
            });
        } else {
            testHtml += `<p>No test questions available.</p>`;
        }
        testHtml += `</div>`;

        // Append the test questions HTML to the module container
        $("#container_module").html(testHtml);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////          Start Rating Generation        //////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function generateStarRating(value) {
        let half_full_svg = `<svg xmlns="http://www.w3.org/2000/svg" fill="#28a745" width="24px" height="24px" viewBox="0 0 56 56"><path d="M 11.9688 52.2930 C 12.9298 53.0195 14.1485 52.7617 15.6016 51.7071 L 28.0001 42.6133 L 40.4220 51.7071 C 41.8751 52.7617 43.0704 53.0195 44.0548 52.2930 C 45.0157 51.5664 45.2267 50.3711 44.6407 48.6602 L 39.7422 34.0820 L 52.2578 25.0820 C 53.7112 24.0508 54.2968 22.9727 53.9219 21.8008 C 53.5470 20.6758 52.4454 20.1133 50.6406 20.1367 L 35.2891 20.2305 L 30.6251 5.5820 C 30.0626 3.8476 29.2188 2.9805 28.0001 2.9805 C 26.8048 2.9805 25.9610 3.8476 25.3985 5.5820 L 20.7344 20.2305 L 5.3829 20.1367 C 3.5782 20.1133 2.4766 20.6758 2.1016 21.8008 C 1.7032 22.9727 2.3126 24.0508 3.7657 25.0820 L 16.2813 34.0820 L 11.3829 48.6602 C 10.7969 50.3711 11.0079 51.5664 11.9688 52.2930 Z M 28.0001 38.5820 L 28.0001 8.6758 C 28.0704 8.6758 28.1173 8.7227 28.1407 8.8633 L 32.2188 22.4336 C 32.5001 23.3945 33.1329 23.7930 34.0938 23.7695 L 48.2733 23.5117 C 48.4139 23.5117 48.4610 23.5117 48.4845 23.5820 C 48.508 23.6524 48.4610 23.6992 48.3674 23.7695 L 36.6954 31.8320 C 35.8751 32.3945 35.6876 33.1211 36.0157 34.0352 L 40.6798 47.4414 C 40.7032 47.5820 40.7266 47.6055 40.6798 47.6524 C 40.6329 47.7227 40.5626 47.6758 40.4688 47.6055 L 29.1954 39.0039 C 28.8204 38.7227 28.4220 38.5586 28.0001 38.5820 Z"/></svg>`;
        let full_svg = `<svg xmlns="http://www.w3.org/2000/svg" fill="#28a745" width="24px" height="24px" viewBox="0 0 56 56"><path d="M 11.9688 52.2930 C 12.9298 53.0195 14.1485 52.7617 15.6016 51.7071 L 28.0001 42.6133 L 40.4220 51.7071 C 41.8751 52.7617 43.0704 53.0195 44.0548 52.2930 C 45.0157 51.5664 45.2267 50.3711 44.6407 48.6602 L 39.7422 34.0820 L 52.2578 25.0820 C 53.7112 24.0508 54.2968 22.9727 53.9219 21.8008 C 53.5470 20.6758 52.4454 20.1133 50.6406 20.1367 L 35.2891 20.2305 L 30.6251 5.5820 C 30.0626 3.8476 29.2188 2.9805 28.0001 2.9805 C 26.8048 2.9805 25.9610 3.8476 25.3985 5.5820 L 20.7344 20.2305 L 5.3829 20.1367 C 3.5782 20.1133 2.4766 20.6758 2.1016 21.8008 C 1.7032 22.9727 2.3126 24.0508 3.7657 25.0820 L 16.2813 34.0820 L 11.3829 48.6602 C 10.7969 50.3711 11.0079 51.5664 11.9688 52.2930 Z"/></svg>`;
        let empty_svg = `<svg xmlns="http://www.w3.org/2000/svg" fill="#28a745" width="24px" height="24px" viewBox="0 -0.34 15.996 15.996" id="star-16px">
                            <path id="Path_33" data-name="Path 33" d="M-14,1.689l1.965,4.143a1,1,0,0,0,.815.568L-7,6.774l-3.049,2.94a1,1,0,0,0-.295.87L-9.677,15l-3.808-2.31A1,1,0,0,0-14,12.544a1,1,0,0,0-.519.146l-3.8,2.31.668-4.416a1,1,0,0,0-.294-.869L-21,6.774l4.215-.374a1,1,0,0,0,.815-.567L-14,1.689m0-1a1,1,0,0,0-.9.571L-16.873,5.4l-4.215.373a1,1,0,0,0-.855.663,1,1,0,0,0,.249,1.053l3.046,2.941-.668,4.416a1,1,0,0,0,.435.982.993.993,0,0,0,.554.168,1,1,0,0,0,.519-.145L-14,13.544l3.807,2.311A1,1,0,0,0-9.677,16a1,1,0,0,0,.554-.168,1,1,0,0,0,.434-.982l-.67-4.416L-6.31,7.493a1,1,0,0,0,.249-1.052,1,1,0,0,0-.855-.664L-11.134,5.4-13.1,1.261A1,1,0,0,0-14,.689Z" transform="translate(22 -0.689)"/>
                        </svg>`;
        // Ensure the value is within the range of 0 to 10  
        value = Math.max(0, Math.min(10, value));

        // Calculate the number of full, half, and empty stars  
        const fullStars = Math.floor(value / 2);  // Number of full stars  
        const halfStars = value % 2;               // Number of half stars  
        const emptyStars = 5 - fullStars - halfStars;  // Number of empty stars  

        // Create the rating HTML string  
        let rating = '';
        rating += full_svg.repeat(fullStars);        // Add full stars  
        rating += half_full_svg.repeat(halfStars);   // Add half star  
        rating += empty_svg.repeat(emptyStars);      // Add empty stars  

        // Return the stars to the target element  
        return rating;
    }



    ////////////////////////////////////////////////////////////////////
    ///////             Fetch the courses details                  ///////
    ////////////////////////////////////////////////////////////////////
    // courseTab filterValue
    function fetchcoursesDetails(id, page, purpose, filterValue) {

        // For showing and hiding the courses details table
        if (id == "") {
            $("#course-div").empty();
            $("#course-loader").removeClass("d-none");
            $("#course-container-table").addClass("d-none");
            $("#course-message").addClass("d-none");
            id = course_id;
        }

        $.ajax({
            url: 'app/courses_process.php', // PHP script to handle logout
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
                    fetchcourses = true;
                    displayCourses(data, purpose);
                    setTimeout(function () {
                        $("#course-loader").addClass("d-none");
                        if (data.total_courses == 0) {
                            $("#user-container-table").addClass("d-none");
                            $("#message-empty").removeClass("d-none");
                            return;
                        }
                        $("#course-container-table").removeClass("d-none");
                        if (purpose == "deletedCourses" && data.total_courses > 0 && data.user_type == "super") {
                            $("#clearAllDeleted").css("display", "flex");
                        } else {
                            $("#clearAllDeleted").css("display", "none");
                        }
                    }, 1000);
                } else if (data.state === 'nocourse') {
                    setTimeout(function () {
                        $("#course-loader").addClass("d-none");
                        $("#course-message").removeClass("d-none").text("No course found.");
                    }, 1000);
                } else if (data.state === 'deleted_success') {
                    $('#message').text("These courses were successfully deleted.").fadeIn(1000);
                    setTimeout(function () {
                        $("#course-loader").addClass("d-none");
                        $("#course-message").removeClass("d-none").text("No course found.");
                        $('#message').fadeOut(1500); // 1000 ms = 1 second to fade out  
                    }, 1000);
                } else if (data.state === 'hasRegistered') {
                    $('#message').text("This course has registered users, it can not be deleted.").fadeIn(1500);
                    setTimeout(function () {
                        $('#message').fadeOut(1500); // 1000 ms = 1 second to fade out  
                    }, 3000);
                } else if (data.state === 'incomplete_module') {
                    $('#message').text("This course has incomplete modules. It can't be validated.").fadeIn(1500);
                    setTimeout(function () {
                        $('#message').fadeOut(1500); // 1000 ms = 1 second to fade out  
                    }, 3000);
                } else if (data.state === 'incomplete_test') {
                    $('#message').text("Tests must have 10, 20, 30, or 40 questions for it to be validated.").fadeIn(1500);
                    setTimeout(function () {
                        $('#message').fadeOut(1500); // 1000 ms = 1 second to fade out  
                    }, 3000);
                } else if (data.state === 'successRejecting') {
                    $("#action-validate-reject-container-btn").remove();
                    $("#action-validate-" + filterValue).remove();
                    $("#action-reject-" + filterValue).remove();
                    $("#action-delete-" + filterValue).removeClass("d-none");
                    $("#action-ban-" + filterValue).removeClass("d-none");
                    $('#message').text("This course has been rejected successfully!").fadeIn(1500);
                    $(".course-module").addClass("d-none");
                    $("#course-test-loader").addClass("d-none");
                    $("#course-module-loader").removeClass("d-none");
                    moduleVal = 1;
                    modulePurpose = "default";
                    setTimeout(function () {
                        $('#message').fadeOut(1500); // 1000 ms = 1 second to fade out  
                    }, 3000);
                } else if (data.state === 'successValidatingModules') {
                    $('#message').text(data.message).fadeIn(1500);
                    $("#action-validate-reject-container-btn").remove();
                    $(".course-module").addClass("d-none");
                    $("#course-test-loader").addClass("d-none");
                    $("#course-module-loader").removeClass("d-none");
                    moduleVal = 1;
                    modulePurpose = "default";
                    setTimeout(function () {
                        $('#message').fadeOut(1500); // 1000 ms = 1 second to fade out  
                    }, 3000);
                } else if (data.state === "course_marked_deleted") {
                    $('#message').text("Course was successfully deleted.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "successFetchingRegistered") {
                    setTimeout(function () {
                        displayRegisteredUsers(data);
                        $("#course-registered-loader").addClass("d-none");
                        $("#course-registered").removeClass("d-none");
                    }, 1000);
                } else if (data.state === "successFetchingUser") {
                    setTimeout(function () {
                        displayUser(data);
                        $("#course-User-loader").addClass("d-none");
                        $("#course-User").removeClass("d-none");
                    }, 1000);
                } else if (data.state === "successFetchingModules") {
                    setTimeout(function () {
                        displayModulesAndVideos(data);
                        $("#course-module-loader").addClass("d-none");
                        $("#course-test-loader").addClass("d-none");
                        $(".course-module").removeClass("d-none");
                    }, 1000);
                } else if (data.state === "successFetchingTest") {
                    setTimeout(function () {
                        displayTest(data);
                        $("#course-test-loader").addClass("d-none");
                        $("#course-module-loader").addClass("d-none");
                        $(".course-module").removeClass("d-none");
                    }, 1000);
                } else if (data.state === "successFetchingFeedback") {
                    setTimeout(function () {
                        displayFeedback(data);
                        $("#course-feedback-loader").addClass("d-none");
                        $("#course-feedback").removeClass("d-none");
                    }, 1000);
                } else if (data.state === "course_marked_banned") {
                    // Show the message  
                    $('#message').text("course was successfully banned.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "course_ban_free") {
                    // Show the message  
                    $('#message').text("course was successfully unban.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "course_validated") {
                    // Show the message  
                    $('#message').text("Course was successfully validated.").fadeIn(1000);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "course_delete_free") {
                    // Show the message  
                    $('#message').text("course was successfully restored.").fadeIn(1000);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "successFetching") {
                    setTimeout(function () {
                        if (data.courseData.action == "e" && data.courseData.submitted_date != null) {
                            $("#action-validate-btn").removeClass("d-none");
                            $("#action-reject-btn").removeClass("d-none");
                            $("#action-ban-btn").addClass("d-none");
                            $("#action-delete-btn").addClass("d-none");
                        } else {
                            $("#action-ban-btn").removeClass("d-none");
                            $("#action-delete-btn").removeClass("d-none");
                            $("#action-validate-btn").addClass("d-none");
                            $("#action-reject-btn").addClass("d-none");
                        }

                        $("#profile-loader-student").addClass("d-none");
                        $("#entire-profile-div").removeClass("d-none");
                        $("#feedback-num").text(formatAmount(data.totalFeedback))
                        $("#users-num").text(formatAmount(data.totalRegisteredUsers))
                        $("#page-title").text(capitalizeFirstLetter(data.courseData.creator_name) + "'s setting.");
                        createProgressBar(data.averagePassingRate);
                        displayCourseBasicDetails(data);
                        displayModulesAndVideos(data);
                        displayFeedback(data);
                        displayRegisteredUsers(data);
                    }, 1000);
                } else if (data.state === "notfound") {
                    // Show the message  
                    $('#message').text("courses not found. You will be redirected.").fadeIn(1000);
                    $(".profile-btn").addClass("d-none");
                    $("#profile-container").addClass("d-none");
                    $("#course-container-table").addClass("d-none");
                    $("#course-container").removeClass("d-none");
                    $("#course-loader").removeClass("d-none");
                    var url = new URL(window.location);
                    url.searchParams.delete('c'); // Remove the 'c' parameter from the URL
                    window.history.replaceState({}, document.title, url); // Update the URL without reloading the page
                    if (fetchcourses == false) {
                        fetchcoursesDetails("", courseCurrentPage, courseTab, filterValue);
                    } else {
                        setTimeout(function () {
                            $("#course-container-table").removeClass("d-none");
                            $("#course-loader").addClass("d-none");
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
    $("#course-div").empty();
    var urlParams = new URLSearchParams(window.location.search);
    var cValue = urlParams.get('c');
    if (cValue) {
        course_id = cValue;
        $("#action-ban-btn").data("course_id", course_id);
        $("#action-delete-btn").data("course_id", course_id);
        $("#action-validate-btn").data("course_id", course_id);
        $("#action-reject-btn").data("course_id", course_id);
        $(".profile-btn").removeClass("d-none");
        $("#course-container").addClass("d-none");
        $("#profile-container").removeClass("d-none");
        fetchcoursesDetails(course_id, "1", "sentThisCourseDetails", "");
    } else {
        $("#page-title").text("Course Management")
        fetchcoursesDetails("", '1', "allCourses", filterValue);
    }

    ////////////////////////////////////////////////////////////////////
    ///////                 course Navigation Bnts                 ///////
    ////////////////////////////////////////////////////////////////////
    // operations for prevBtn 
    $("#prevBtncourse").on("click", function () {
        // Ensure page doesn't go below 1
        if (courseCurrentPage > 1) {
            $("#nextBtncourse").addClass("disabled");
            $("#prevBtncourse").addClass("disabled");
            var containerTop = $("#courseDiv").offset().top;
            $("html, body").scrollTop(containerTop);
            courseCurrentPage--;
            $("#pagination-Btncourse .pageBtn").removeClass("custom-button");
            $(`#pagination-Btncourse .pageBtn:contains('${courseCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                fetchcoursesDetails("", courseCurrentPage, "allCourses", filterValue);
            }, 800);
        }
    });
    // operations for nextBtn
    $("#nextBtncourse").on("click", function () {
        // Ensure current page doesn't exceed total pages
        if (courseCurrentPage < totalcoursePages) {
            $("#nextBtncourse").addClass("disabled");
            $("#prevBtncourse").addClass("disabled");
            var containerTop = $("#courseDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            courseCurrentPage++;

            $("#pagination-Btncourse .pageBtn").removeClass("custom-button");
            $(`#pagination-Btncourse .pageBtn:contains('${courseCurrentPage}')`).addClass("custom-button");
            setTimeout(function () {
                fetchcoursesDetails("", courseCurrentPage, "allCourses", filterValue);
            }, 800);
        }
    });
    // operations for in between prevBtn and nextBtn
    $("#pagination-Btncourse").on("click", ".pageBtn", function () {
        $("#pagination-Btncourse .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        courseCurrentPage = $(this).text();
        var containerTop = $("#courseDiv").offset().top;
        $("html, body").scrollTop(containerTop);
        setTimeout(function () {
            fetchcoursesDetails("", courseCurrentPage, "allCourses", filterValue);
        }, 800);
    });
    ////////////////////////////////////////////////////////////////////
    ///////           Registered course Navigation Bnts          ///////
    ////////////////////////////////////////////////////////////////////
    // operations for prevBtn 
    $("#prevBtnRegisteredCourse").on("click", function () {
        // Ensure page doesn't go below 1
        if (registeredCurrentPage > 1) {
            $("#nextBtnRegisteredCourse").addClass("disabled");
            $("#prevBtnRegisteredCourse").addClass("disabled");
            var containerTop = $("#registeredCourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);
            registeredCurrentPage--;
            $("#pagination-BtnRegisteredCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnRegisteredCourse .pageBtn:contains('${registeredCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#course-registered").empty();
                $("#course-registered-loader").removeClass("d-none");
                fetchcoursesDetails(course_id, registeredCurrentPage, "fetchRegistered", "");
            }, 800);
        }
    });

    // operations for nextBtn
    $("#nextBtnRegisteredCourse").on("click", function () {
        // Ensure current page doesn't exceed total pages
        if (registeredCurrentPage < totalRegisteredPages) {
            $("#nextBtnRegisteredCourse").addClass("disabled");
            $("#prevBtnRegisteredCourse").addClass("disabled");
            var containerTop = $("#registeredCourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            registeredCurrentPage++;

            $("#pagination-BtnRegisteredCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnRegisteredCourse .pageBtn:contains('${registeredCurrentPage}')`).addClass("custom-button");
            setTimeout(function () {
                $("#course-registered").empty();
                $("#course-registered-loader").removeClass("d-none");
                fetchcoursesDetails(course_id, registeredCurrentPage, "fetchRegistered", "");
            }, 800);
        }
    });
    // Create Progressive Bar
    function createProgressBar(value) {
        if (value == null) {
            $("#progressive_bar_container").addClass("d-none");
            return;
        }
        const progressCircle = document.getElementById('progress');
        const percentageDisplay = document.getElementById('percentage');

        // Ensure value is between 0 and 100  
        if (value < 0 || value > 100) {
            console.error('Value should be between 0 and 100');
            return;
        }

        // Calculate the stroke dash offset  
        const radius = 45; // radius of the circle  
        const circumference = 2 * Math.PI * radius; // circumference of the circle  
        const offset = circumference - (value / 100 * circumference); // calculated offset  

        // Update the progress circle and percentage display  
        progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
        progressCircle.style.strokeDashoffset = offset;
        percentageDisplay.textContent = `${value}%`;
    }
    // operations for in between prevBtn and nextBtn
    $("#pagination-BtnRegisteredCourse").on("click", ".pageBtn", function () {
        $("#pagination-BtnRegisteredCourse .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        registeredCurrentPage = $(this).text();
        var containerTop = $("#RegisteredCourseDiv").offset().top;
        $("html, body").scrollTop(containerTop);
        setTimeout(function () {
            $("#course-registered").empty();
            $("#course-registered-loader").removeClass("d-none");
            fetchcoursesDetails(course_id, registeredCurrentPage, "fetchRegistered", "");
        }, 800);
    });
    ////////////////////////////////////////////////////////////////////
    ///////           User course Navigation Bnts          ///////
    ////////////////////////////////////////////////////////////////////
    // operations for prevBtn 
    $("#prevBtnUsercourse").on("click", function () {
        // Ensure page doesn't go below 1
        if (UserCurrentPage > 1) {
            $("#nextBtnUsercourse").addClass("disabled");
            $("#prevBtnUsercourse").addClass("disabled");
            var containerTop = $("#UsercourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);
            UserCurrentPage--;
            $("#pagination-BtnUsercourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnUsercourse .pageBtn:contains('${UserCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#course-User").empty();
                $("#course-User-loader").removeClass("d-none");
                fetchcoursesDetails(course_id, UserCurrentPage, "fetchUser", "");
            }, 800);
        }
    });

    // operations for nextBtn
    $("#nextBtnUsercourse").on("click", function () {
        // Ensure current page doesn't exceed total pages
        if (UserCurrentPage < totalUserPages) {
            $("#nextBtnUsercourse").addClass("disabled");
            $("#prevBtnUsercourse").addClass("disabled");
            var containerTop = $("#UsercourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            UserCurrentPage++;

            $("#pagination-BtnUsercourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnUsercourse .pageBtn:contains('${UserCurrentPage}')`).addClass("custom-button");
            setTimeout(function () {
                $("#course-User").empty();
                $("#course-User-loader").removeClass("d-none");
                fetchcoursesDetails(course_id, UserCurrentPage, "fetchUser", "");
            }, 800);
        }
    });
    // operations for in between prevBtn and nextBtn
    $("#pagination-BtnUsercourse").on("click", ".pageBtn", function () {
        $("#pagination-BtnUsercourse .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        UserCurrentPage = $(this).text();
        var containerTop = $("#UsercourseDiv").offset().top;
        $("html, body").scrollTop(containerTop);
        setTimeout(function () {
            $("#course-User").empty();
            $("#course-User-loader").removeClass("d-none");
            fetchcoursesDetails(course_id, UserCurrentPage, "fetchUser", "");
        }, 800);
    });
    ////////////////////////////////////////////////////////////////////
    ///////           feedback course Navigation Bnts          ///////
    ////////////////////////////////////////////////////////////////////
    // operations for prevBtn 
    $("#prevBtnFeedbackCourse").on("click", function () {
        if (feedbackCurrentPage > 1) {
            $(this).addClass("disabled");
            $("#prevBtnFeedbackCourse").addClass("disabled");
            $("#nextBtnFeedbackCourse").addClass("disabled");
            var containerTop = $("#FeedbackCourseDiv").offset().top();
            $("html, body").scrollTop(containerTop);

            feedbackCurrentPage--;

            $("#pagination-BtnFeedbackCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnFeedbackCourse .pageBtn:contains('${feedbackCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#course-feedback").empty();
                $("#course-feedback-loader").removeClass("d-none");
                fetchcoursesDetails(course_id, feedbackCurrentPage, "fetchFeedback", "");
            }, 800);
        }
    });

    // Operations for nextBtn for feedback courses
    $("#nextBtnFeedbackCourse").on("click", function () {
        if (feedbackCurrentPage < totalfeedbackPages) {
            $(this).addClass("disabled");
            var containerTop = $("#FeedbackCourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            feedbackCurrentPage++;

            $("#pagination-BtnFeedbackCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnFeedbackCourse .pageBtn:contains('${feedbackCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#course-feedback").empty();
                $("#course-feedback-loader").removeClass("d-none");
                fetchcoursesDetails(course_id, feedbackCurrentPage, "fetchFeedback", "");
            }, 800);
        }
    });
    // operations for in between prevBtn and nextBtn
    $("#pagination-BtnFeedbackCourse").on("click", ".pageBtn", function () {
        feedbackCurrentPage = $(this).text();
        $("#pagination-BtnFeedbackCourse .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        var containerTop = $("#FeedbackCourseDiv").offset().top;
        $("html, body").scrollTop(containerTop);
        setTimeout(function () {
            $("#course-feedback").empty();
            $("#course-feedback-loader").removeClass("d-none");
            fetchcoursesDetails(course_id, feedbackCurrentPage, "fetchFeedback", "");
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
            $("#message-empty").addClass("d-none");
            num = 0;
            event.preventDefault(); // Prevent the default action (form submission)  
            filterValue = $(this).val(); // Collect the input value  
            courseCurrentPage = 1;
            fetchcoursesDetails("", courseCurrentPage, courseTab, filterValue);
        }
    });
    $(".course-navLinks").click(function () {
        $("#message-empty").addClass("d-none");
        $("#clearAllDeleted").css("display", "none");
        num = 0;
        courseTab = $(this).data("id");
        courseCurrentPage = 1;
        $("#numberInput").val("");
        filterValue = "";
        fetchcoursesDetails("", courseCurrentPage, courseTab, filterValue);
        $(".course-navLinks").removeClass("active-course-navLinks");
        $(this).addClass("active-course-navLinks");
    })
    $("#confirmClear").click(function () {
        fetchcoursesDetails("", "", "clearAll", "");
    })
    var temp_container_element_id, temp_container_btn, temp_container_btn_value;
    $(".course-div").on("click", ".action-ban", function () {
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
        var temp_id = $(this).data("course_id");
        fetchcoursesDetails(temp_id, "", temp_action, "");
    })

    // 
    $(".course-div").on("click", ".action-validate", function () {
        var num = $(this).data("num");
        var temp_delete_id = "#action-delete-" + num;
        var temp_ban_id = "#action-ban-" + num;
        var temp_reject_id = "#action-reject-" + num;
        $(this).remove();
        $(temp_reject_id).remove();
        $("#action-validate-btn").addClass("d-none");
        $("#action-reject-btn").addClass("d-none");
        $("#action-delete-btn").removeClass("d-none");
        $("#action-ban-btn").removeClass("d-none");
        $(temp_ban_id).removeClass("d-none");
        $(temp_delete_id).removeClass("d-none");

        var temp_id = $(this).data("course_id");

        fetchcoursesDetails(temp_id, "", "validateThis", "");
    })


    $(".course-div").on("click", ".action-delete", function () {
        var num = $(this).data("num");
        var temp_element_id_div = "#course-element-" + num;
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
            if ($(this).data("can_delete") == "yes") {
                $(temp_element_id).text("Ban");
                $("#action-ban-btn").text("Ban");
            }
        }
        if (courseTab == "deletedCourses") {
            $(temp_element_id_div).remove();
            if (num == 1) {
                $("#course-message").removeClass("d-none").text("No course found.");
                $("#course-container-table").addClass("d-none");
                $("#clearAllDeleted").css("display", "none");
            }
        }
        var temp_id = $(this).data("course_id");
        fetchcoursesDetails(temp_id, "", temp_action, "");
    })
    $("#course-div").on("click", ".profile-link", function () {
        var num = $(this).data("num");
        course_id = $(this).data("course_id");
        var temp_element_id = "#profile-link" + num;
        $("#action-delete-btn").data("num", num).data("course_id", course_id);
        $("#action-ban-btn").data("num", num).data("course_id", course_id);
        $("#action-validate-btn").data("num", num).data("course_id", course_id);
        $("#action-reject-btn").data("num", num).data("course_id", course_id);
        $(".profile-btn").removeClass("d-none");
        $("#profile-container").removeClass("d-none");
        $("#profile-loader-student").removeClass("d-none");
        $("#entire-profile-div").addClass("d-none");
        $("#course-container").addClass("d-none");
        // Assuming course_Id is defined and your variable is named correctly  
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        params.set('c', course_id); // Update or add the 'c' parameter  
        url.search = params.toString();
        // Use history.replaceState to update the URL without reloading  
        history.replaceState(null, '', url.toString());

        fetchcoursesDetails(course_id, "1", "sentThisCourseDetails", "");
    })
    $("#student-btn").on("click", function () {
        $(".div-actions").removeClass("d-none");

        $("#message-empty").addClass("d-none");
        $(".profile-btn").addClass("d-none");
        $("#profile-container").addClass("d-none");
        $("#course-container-table").addClass("d-none");
        $("#course-container").removeClass("d-none");
        $("#course-loader").removeClass("d-none");
        var url = new URL(window.location);
        url.searchParams.delete('c'); // Remove the 'c' parameter from the URL
        window.history.replaceState({}, document.title, url); // Update the URL without reloading the page  
        if (fetchcourses == false) {
            filterValue = "";
            courseTab = "allCourses";
            fetchcoursesDetails("", '1', "allCourses", filterValue);
            $("#page-title").text("Course Management")
        }
        setTimeout(function () {
            $("#course-loader").addClass("d-none");
            $("#course-container-table").removeClass("d-none");
        }, 800);
    })
    var temp_control = "";
    var element_open = false;

    $("#course-registered").on("click", ".view-score", function () {
        var temp_num = $(this).data("num");
        var temp_course_id = "#view-score-" + temp_num;
        if (temp_control == temp_num) {
            if (element_open == true) {
                element_open = false;
                $(temp_course_id).hide("slow");
            } else {
                element_open = true;
                $(temp_course_id).show("slow");
            }
        } else {
            element_open = true;
            temp_control = temp_num;
            $("#course-registered .view-score-div").hide("slow")
            $(temp_course_id).show("slow");
        }
    });
    $("#module-buttons-container").on("click", ".module-btn", function () {
        moduleVal = $(this).data("purposeval");
        if (moduleVal == "test") {
            $("#course-module-loader").addClass("d-none");
            $("#course-test-loader").removeClass("d-none");
            $("#module-number").text("Test:");
        } else {
            $("#course-test-loader").addClass("d-none");
            $("#course-module-loader").removeClass("d-none");
            $("#module-number").text("Module " + moduleVal + ":");
        }
        $(".course-module").addClass("d-none");
        fetchcoursesDetails(course_id, moduleVal, modulePurpose, "");
    });
    $(".module-navLinks").click(function () {
        if (moduleVal == "test") {
            $("#course-module-loader").addClass("d-none");
            $("#course-test-loader").removeClass("d-none");
        } else {
            $("#course-test-loader").addClass("d-none");
            $("#course-module-loader").removeClass("d-none");
        }
        editing = false;
        if ($(this).text().trim() == "Editing") {
            editing = true; moduleVal = 0;
            $("#module-number").text("First Edited Module:");
        } else {
            editing = true; moduleVal = 0;
            $("#module-number").text("");
        }
        $(".course-module").addClass("d-none");
        $("#module-buttons-container").addClass("d-none");
        $(".module-navLinks").removeClass("active-course-navLinks");
        $(this).addClass("active-course-navLinks");
        modulePurpose = $(this).data("purpose");
        fetchcoursesDetails(course_id, moduleVal, modulePurpose, "");
    })
    //////////////////////////////////////////////////////////////////////////////
    /////////////////      Text Length Controller       //////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    function checkCharacterCount(text, maxLimit) {
        // Get the current character count  
        const currentCount = text.length;

        // Check if the maximum limit is exceeded  
        if (currentCount == 0) {
            return "cant"; // Return false if exceeded  
        } else if (currentCount > maxLimit) {
            return "exceed"; // Return false if exceeded  
        } else {
            // Update the character display or do something else as needed  
            $("#characterCount").text(currentCount + " / " + maxLimit).removeClass("text-danger").addClass("text-muted");
            return "within"; // Return true if within limit  
        }
    }
    $("#reason").on("input", function () {
        if (checkCharacterCount($(this).val(), 200) == "exceed") {
            // False
            $("#characterCount").text("You have exceeded the maximum character limit of 100 characters.").removeClass("text-muted").addClass("text-danger");
        } else if (checkCharacterCount($(this).val(), 200) == "cant") {
            // False
            $("#characterCount").text("This field can not be empty.").removeClass("text-muted").addClass("text-danger");
        }
    })

    $(".course-div").on("click", ".action-reject", function () {
        num = $(this).data("num");
        course_id = $(this).data("course_id");

    });

    $("#module-buttons-container, #confirmRejection").on("click", ".action-validate-reject", function () {
        if ($(this).text().trim() == "Reject") {
            // It's rejection
            if (checkCharacterCount($("#reason").val(), 200) == "exceed") {
                // False
                $("#characterCount").text("You have exceeded the maximum character limit of 100 characters.").removeClass("text-muted").addClass("text-danger");
            } else if (checkCharacterCount($("#reason").val(), 200) == "cant") {
                // False
                $("#characterCount").text("This field can not be empty.").removeClass("text-muted").addClass("text-danger");
            } else {
                $("#confirmRejection").modal("hide");
                $(".editing-features").addClass("d-none").removeClass("active-course-navLinks");
                $("#actual-btn").addClass("active-course-navLinks");
                fetchcoursesDetails(course_id, $("#reason").val().trim(), $(this).data("purpose"), num);
            }
        }
    })

})