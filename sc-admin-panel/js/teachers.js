$(document).ready(function () {
    var userCurrentPage = 1, user_Id = '', totalUserPages, userMax, userTab = "allUsers", filterValue = "", registeredCurrentPage = 1, createdCurrentPage = 1, feedbackCurrentPage = 1, totalfeedbackPages, totalRegisteredPages, totalCreatedPages, feedbackMax, registeredMax, createdMax, fetchUsers = false;
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
    function DisplayUser(users, purpose) {
        const userDiv = document.getElementById("user-div");
        if (num >= users.total_users || num >= userMax) {
            num = 0;
        }
        var display = "";
        if (purpose == "deletedUsers") {
            display = "d-none";
            $(".hideThisLoader").addClass("d-none");
        }
        $("#total_count").text(formatAmount("Showing " + users.total_users) + " items");
        users.data.forEach(user => {
            // Update the action value
            let actionText = user.action === 'd' ? 'Restored' :
                user.action === 'b' ? 'Unban' :
                    user.action; // Leave as is for "n" or others
            if (user.Image == ""||user.Image == null) {
                img = "../image/default-profile.png";
            } else {
                img = "../profile/" + user.Image;
            }
            // Create a new row
            const userRow = `
                <tr id="user-element-${++num}">
                    <th scope="row">${num}</th>
                    <td class="profile-link" data-user_id="${user.user_ID}" data-num="${num}" id="profile-link-${num}"><img src="${img}" alt="${capitalizeFirstLetter(user.Name)}" class="rounded-circle me-1" style="width:30px; height:30px; object-fit:cover"><span>${capitalizeFirstLetter(user.Name)}</span></td>
                    <td>${user.Email}</td>
                    <td>${formatAmount(user.registered_courses)}</td>
                    <td>${formatAmount(user.produced_courses)}</td>
                    <td>${formatDate(user.Date)}</td>
                    <td class="text-center">
                        <button class="btn btn-outline-success rounded-0  my-1 ${display} action-ban" id="action-ban-${num}" data-num="${num}" data-user_id="${user.user_ID}">
                            ${actionText === 'Unban' ? 'Unban' : 'Ban'}
                        </button> 
                        <button class="fs-7 btn btn-outline-danger rounded-0 my-1 action-delete" id="action-delete-${num}" data-num="${num}" data-user_id="${user.user_ID}">
                            ${actionText === 'Restored' ? 'Restore' : 'Delete'}
                        </button>
                    </td>
                </tr>
            `;

            // Append the new row to the user-div
            userDiv.innerHTML += userRow;
        });
        $("#btn-containerUser").addClass("d-none");

        if (users.total_users > 20) {
            var tempVal = (userMax !== null && userMax !== undefined) ? userMax : users.total_users;
            totalUserPages = Math.ceil(tempVal / 20);
            userMax = users.total_users;
            create_pages_btn(userCurrentPage, "User", totalUserPages);
            $("#btn-containerUser").removeClass("d-none");

        }
    }

    function displayRegisteredCourse(response) {
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// Registered Course Section
        var elements = '';
        var element = ``;
        if (response.totalCourses && response.totalCourses !== undefined) {
            $("#registered-num").text(response.totalCourses);
        }
        for (var i = 0; i < response.registeredCourses.length; i++) {
            var levelTemp = "Completed";
            if (response.registeredCourses[i].Level !== "c") {
                levelTemp = response.registeredCourses[i].Level;
            }
            var temp_element = "";
            if (response.registeredCourses[i].Scores.length > 0) {
                temp_element += `<div class="view-score hover text-muted" data-num="${i}">View Score</div><div class="container mt-1 view-score-div" style="display:none; width: 100%; overflow: auto;"id="view-score-${i}">  
                                    <h2 class="text-center">Scores Overview</h2>  
                                    <table class="table table-bordered">  
                                        <thead class="table-light">  
                                            <tr>  
                                                <th>Attempt</th>  
                                                <th>Score</th>  
                                                <th>Percentage</th>  
                                                <th>Answers</th>  
                                            </tr>  
                                        </thead>  
                                        <tbody>`;
                for (var n = 0; n < response.registeredCourses[i].Scores.length; n++) {
                    temp_element += `<tr>
                        <td>${response.registeredCourses[i].Scores[n].Attempt_num}</td>
                        <td>${response.registeredCourses[i].Scores[n].Score}/${response.registeredCourses[i].Num_test}</td>
                        <td>${calculatePercentage(response.registeredCourses[i].Scores[n].Score, response.registeredCourses[i].Num_test)}%</td>
                        <td>${response.registeredCourses[i].Scores[n].Answers}</td>
                    </tr>`;
                }
                temp_element += `</tbody></table> </div> <div class="mt-2 text-muted" style="font-size:13px">NB: "N" in answers means it was not answered.</div>`;
            } else {
                temp_element = ``;
            }
            var element = `
                <div class="py-3" style="cursor:default">
                    <h2 class="fs-6 text-success fw-semibold mb-0">
                        ${capitalizeFirstLetter(response.registeredCourses[i].Title)}
                    </h2>
                    <p class="fs-6 py-0 mb-0 mt-1">Level: <span>${levelTemp}</span></p>
                    ${temp_element}
                    <div class="d-flex justify-content-between mt-2">
                        <p class="fs-7 py-0 my-0 text-muted">${formatDate(response.registeredCourses[i].Date)}</p>
                        <a href="courses.php?v=${response.registeredCourses[i].course_ID}" class="fs-7 py-0 my-0 text-muted hover">View Course</a>
                    </div>
                </div>
                <hr class="py-0 my-0">`;
            elements += element;
        }

        if (elements === '') {
            elements = `<div class="text-center py-2">
                            <hr class="py-0 mb-3 mt-0">
                            User has no registered courses.
                        </div>`;
        } else {
            elements = '<hr class="py-0 my-0 mt-3">' + elements;
            if (response.totalCourses > 5 || registeredMax > 5) {
                var tempVal = registeredMax || response.totalCourses;
                totalRegisteredPages = Math.ceil(tempVal / 5);
                registeredMax = response.totalCourses;
                create_pages_btn(registeredCurrentPage, "RegisteredCourse", totalRegisteredPages);
                $("#btn-containerRegisteredCourse").removeClass("d-none");
            }
        }

        $("#course-registered-loader").addClass("d-none");
        $("#course-registered").empty().append(elements);
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
    }

    function displayCreatedCourse(response) {
        //////////////////////////////////////////////////////////////////////////////////////////////////////////  
        /// Created Course Section  
        var elements = '';
        var element = ``;

        // Display the total number of created courses  
        if (response.totalCreatedCourses && response.totalCreatedCourses !== undefined) {
            $("#created-num").text(response.totalCreatedCourses);
        }

        // Loop through each created course  
        for (var i = 0; i < response.createdCourses.length; i++) {
            // Create the course display element  
            var cost = "Free";
            if (response.createdCourses[i].Cost !== 0) {
                cost = "$" + response.createdCourses[i].Cost;
            }
            element = `  
                <div class="py-3" style="cursor:default">  
                    <h2 class="fs-6 text-success fw-semibold mb-0">  
                        ${capitalizeFirstLetter(response.createdCourses[i].Title)}  
                    </h2> 
                    <div class="d-flex justify-content-between my-3"> 
                    <p class="fs-6 py-0 mb-0 mt-1">Registered: <span>${response.createdCourses[i].registered}</span></p>  
                    <p class="fs-6 py-0 mb-0 mt-1">Tests: <span>${response.createdCourses[i].Num_test}</span></p>  
                    <p class="fs-6 py-0 mb-0 mt-1">Cost: <span>${cost}</span></p>  
                    <p class="fs-6 py-0 mb-0 mt-1">Modules: <span>${response.createdCourses[i].Num_modules}</span></p> 
                    </div> 
                    <div class="d-flex justify-content-between mt-2">  
                    <p class="fs-7 py-0 my-0 text-muted"><span>${formatDate(response.createdCourses[i].Date)}</span></p>  
                        <a href="courses.php?v=${response.createdCourses[i].course_ID}" class="fs-7 py-0 my-0 text-muted hover">View Course</a>  
                    </div>  
                </div>  
                <hr class="py-0 my-0">`;

            elements += element; // Append the course element to elements  
        }

        // If no courses found, display a message  
        if (elements === '') {
            elements = `<div class="text-center py-2">  
                            <hr class="py-0 mb-3 mt-0">  
                            User has no created courses.  
                        </div>`;
        } else {
            elements = '<hr class="py-0 my-0 mt-3">' + elements;
            // Handle pagination if necessary  
            if (response.totalCreatedCourses > 5) {
                totalCreatedPages = Math.ceil(response.totalCreatedCourses / 5);
                create_pages_btn(createdCurrentPage, "CreatedCourse", totalCreatedPages);
                $("#btn-containerCreatedCourse").removeClass("d-none");
            }
        }

        $("#course-created-loader").addClass("d-none"); // Hide loading indicator  
        $("#course-created").empty().append(elements); // Display the courses  
        //////////////////////////////////////////////////////////////////////////////////////////////////////////  
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
    function displayFeedbackCourse(response) {
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        /// Feedback Course Section
        var elements = '';
        var element = ``;
        if (response.totalFeedback && response.totalFeedback !== undefined) {
            $("#feedback-num").text(response.totalFeedback);
        }
        for (var i = 0; i < response.courseFeedback.length; i++) {
            var dt = new Date(response.courseFeedback[i].Date);
            var monthName = dt.toLocaleDateString("en-US", { month: "long" });
            var day = dt.getDate();
            var year = dt.getFullYear();

            var element = `
                <div class="py-3" style="cursor:default">
                    <div>
                    <span class="fs-6 fw-semibold mb-0">
                        <a class="hover" style="color:#28a745;" href="courses.php?c=${response.courseFeedback[i].course_ID}">${capitalizeFirstLetterOfPhrase(response.courseFeedback[i].courseTitle)}</a>
                    </span>
                    <span class="fs-7 text-muted mx-2">
                    Created by
                    </span>
                    <span class="fs-7 text-muted fw-semibold mb-0">
                        <a class="hover" style="color:#6c757d ;" href="teachers.php?p=${response.courseFeedback[i].creator_ID}">${capitalizeFirstLetter(response.courseFeedback[i].creatorName)}</a>
                    </span>
                    </div>
                    <p class="fs-6 py-0 mb-0 mt-1"><span>${capitalizeFirstLetterOfPhrase(response.courseFeedback[i].Feedback)}</span></p>
                    <p class="fs-6 py-0 mb-0 mt-1"><span>${generateStarRating(response.courseFeedback[i].Rate)}</span></p>
                    <div class="d-flex justify-content-between mt-2">
                        <div class="text-muted fs-7 py-0 mx-0">${day} ${monthName} ${year}</div>
                    </div>
                </div>
                <hr class="py-0 my-0">`;
            elements += element;
        }
        if (elements === '') {
            elements = `<div class="text-center py-2">
                            <hr class="py-0 mb-3 mt-0">
                            No feedback provided.
                            
                        </div>`;
        } else {
            elements = '<hr class="py-0 my-0 mt-3">' + elements;
            if (response.totalFeedback > 5 || feedbackMax > 5) {
                var tempVal = feedbackMax || response.totalFeedback;
                totalfeedbackPages = Math.ceil(tempVal / 5);
                feedbackMax = response.totalFeedback;
                create_pages_btn(feedbackCurrentPage, "feedbackCourse", totalfeedbackPages);
                $("#btn-containerfeedbackCourse").removeClass("d-none");
            }
        }

        $("#course-feedback-loader").addClass("d-none");
        $("#course-feedback").empty().append(elements);
        ////////////////////////////////////////////////////////////
    }
    //////////////////////////////////////////////////////////////// 
    ////////////////         Produce PDF         ///////////////////
    ////////////////////////////////////////////////////////////////
    var pdfLink;
    ////////////////////////////////////
    // Show pdf
    $("#cvLink").click(function (e) {
        e.preventDefault(); // prevent default link behavior if it's <a>
        $("#pdf-main-container").slideToggle(300); // smooth slide up/down
        loadPDF(pdfLink);
    });
    let pdfDoc = null;
    let currentScale = 1;
    let baseScale = 1;

    function renderPDFPages(pdf, scale, containerSelector = "#pdf-container") {
        const container = document.querySelector(containerSelector);
        container.innerHTML = "";

        // We'll wait for first page to calculate scale
        pdf.getPage(1).then(function (page) {
            const unscaledViewport = page.getViewport({ scale: 1 });

            const containerWidth = container.clientWidth;
            baseScale = containerWidth / unscaledViewport.width;

            // If this is the initial render, use baseScale
            if (scale === 1) {
                currentScale = baseScale;
            }

            updateZoomUI();

            // Now render all pages using currentScale
            for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                pdf.getPage(pageNum).then(function (page) {
                    const viewport = page.getViewport({ scale: currentScale });

                    const canvas = document.createElement("canvas");
                    const context = canvas.getContext("2d");
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    canvas.style.display = "block";
                    canvas.style.margin = "0 auto 20px auto";

                    container.appendChild(canvas);

                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    });
                });
            }
        });
    }

    function loadPDF(pdfUrl) {
        pdfjsLib.getDocument(pdfUrl).promise.then(function (pdf) {
            pdfDoc = pdf;
            baseScale = 1; // Reset
            renderPDFPages(pdf, currentScale);
        });
    }

    function updateZoomUI() {
        document.getElementById("zoom-level").textContent =
            Math.round((currentScale / baseScale) * 100) + "%";
    }

    // Zoom buttons
    document.getElementById("zoom-in").addEventListener("click", function () {
        if (pdfDoc && currentScale < baseScale * 3) {
            currentScale += baseScale * 0.1;
            renderPDFPages(pdfDoc, currentScale);
            updateZoomUI();
        }
    });

    document.getElementById("zoom-out").addEventListener("click", function () {
        if (pdfDoc && currentScale > baseScale * 0.5) {
            currentScale -= baseScale * 0.1;
            renderPDFPages(pdfDoc, currentScale);
            updateZoomUI();
        }
    });
    function updateUserProfileAndFields(response) {
        // Update user details
        $("#username").text(capitalizeFirstLetter(response.userDetails.Name));
        $("#userprofile").attr("src", response.userDetails.Image ? "../profile/" + response.userDetails.Image : "../image/default-profile.png");
        $("#userprofile").attr("alt", capitalizeFirstLetter(response.userDetails.Name));
        $("#email").text(response.userDetails.Email);
        $("#description").text(capitalizeFirstLetterOfPhrase(response.userDetails.Description) || "No description available");

        if (response.userDetails.applied === true && response.userDetails.rejected === false) {
            $("#operationValidate").removeClass("d-none");
            $("#operationValidate span").empty().text("Recently applied to be a teacher.");
        } else if (response.userDetails.rejected === true && response.userDetails.reapplied === true) {
            $("#operationValidate").removeClass("d-none");
            $("#operationValidate span").empty().text("Was rejected previously due to: " + response.userDetails.rejection_reason);
        } else {
            $("#operationValidate").addClass("d-none")

        }
        // /////////////////////////////////////
        var actionText = response.userDetails.action === 'd' ? 'Restored' :
            response.userDetails.action === 'b' ? 'Unban' :
                response.userDetails.action; // Leave as is for "n" or others  

        $("#action-ban-btn").text(actionText === 'Unban' ? 'Unban' : 'Ban');
        $("#action-delete-btn").text(actionText === 'Restored' ? 'Restore' : 'Delete');

        // Assuming response is your AJAX response object  
        $(".social-media-links").addClass("d-none");
        if (response.userDetails && response.userDetails.links) {
            // Loop through the links array  
            response.userDetails.links.forEach(function (linkObj) {
                // Check if the link type is 'l' for LinkedIn  
                if (linkObj.link_type === 'l') {
                    $("#linkedinLink").attr("href", linkObj.link).removeClass("d-none");
                }

                // Check if the link type is 'c' for CV  
                if (linkObj.link_type === 'c') {
                    $("#cvLink").removeClass("d-none");
                    pdfLink = "../cv/" + linkObj.link;
                }

                // Check if the link type is 'p' for Portfolio  
                if (linkObj.link_type === 'p') {
                    $("#portfolioLink").attr("href", linkObj.link).removeClass("d-none");
                }
            });
        }

        $("#dateJoin").text("Join on the " + formatDate(response.userDetails.Date));


        // Handle fields
        let fieldSelect = $("#fieldSelect");
        let fieldsContainer = $("#fields");

        // Clear previous fields if any
        fieldsContainer.empty();
        fieldSelect.empty(); // Clear fieldSelect options

        if (response.fields && response.fields.length > 0) {
            response.fields.forEach(function (field) {
                // Append each field as a button to #fields container
                let fieldButton = `<button class="btn btn-secondary disabled fs-7 rounded-0 my-2 me-2">${capitalizeFirstLetterOfPhrase(field.Field)}</button>`;
                fieldsContainer.append(fieldButton);

                // Add each field as an option in #fieldSelect
                var newOption = new Option(
                    capitalizeFirstLetterOfPhrase(field.Field), // Option text
                    field.field_num, // Option value
                    false, // Not selected by default
                    false  // Not selected
                );
                $(fieldSelect).append(newOption).trigger("change");
            });
        } else {
            // Display a message if no fields are available
            fieldsContainer.append(`<p class="text-muted">No fields available</p>`);
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
            url: 'app/teachers_process.php', // PHP script to handle logout
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
                            if (purpose == "deletedUsers" && data.total_users > 0 && data.user_type == "super") {
                                $("#clearAllDeleted").css("display", "flex");
                            } else {
                                $("#clearAllDeleted").css("display", "none");
                            }
                        }
                    }, 1000);
                } else if (data.state === 'noUser') {
                    setTimeout(function () {
                        $("#user-loader").addClass("d-none");
                        $("#user-message").removeClass("d-none").text("No user found.");
                    }, 1000);
                } else if (data.state === "user_marked_deleted") {
                    $('#message').text("User was successfully deleted.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "successFetchingRegistered") {
                    setTimeout(function () {
                        displayRegisteredCourse(data);
                        $("#course-registered-loader").addClass("d-none");
                        $("#course-registered").removeClass("d-none");
                    }, 1000);
                } else if (data.state === "successFetchingCreated") {
                    setTimeout(function () {
                        displayCreatedCourse(data);
                        $("#course-created-loader").addClass("d-none");
                        $("#course-created").removeClass("d-none");
                    }, 1000);
                    // 
                } else if (data.state === "userRejected") {
                    $("#operationValidate").addClass("d-none");
                    $('#message').text("Teacher was successfully rejected.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000);
                } else if (data.state === "userValidated") {
                    $("#operationValidate").addClass("d-none");
                    $('#message').text("Teacher was successfully approved.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000);
                } else if (data.state === "successFetchingFeedback") {
                    setTimeout(function () {
                        displayFeedbackCourse(data);
                        $("#course-feedback-loader").addClass("d-none");
                        $("#course-feedback").removeClass("d-none");
                    }, 1000);
                } else if (data.state === "user_marked_banned") {
                    // Show the message  
                    $('#message').text("User was successfully banned.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "user_ban_free") {
                    // Show the message  
                    $('#message').text("User was successfully unban.").fadeIn(1000);
                    $(temp_container_element_id).text(temp_container_btn_value);
                    $(temp_container_btn).text(temp_container_btn_value);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "user_delete_free") {
                    // Show the message  
                    $('#message').text("User was successfully restored.").fadeIn(1000);
                    setTimeout(function () {
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out 
                } else if (data.state === "successFetching") {
                    setTimeout(function () {
                        $("#profile-loader-student").addClass("d-none");
                        $("#entire-profile-div").removeClass("d-none");
                        $("#page-title").text(capitalizeFirstLetter(data.userDetails.Name) + "'s Profile setting.");
                        updateUserProfileAndFields(data);
                        displayRegisteredCourse(data);
                        displayCreatedCourse(data);
                        displayFeedbackCourse(data);
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
                        $('#message').text("Users cleared successfully!").fadeIn(1000);
                        setTimeout(function () {
                            $("#user-loader").addClass("d-none");
                            $("#user-message").removeClass("d-none").text("No user found.");
                            $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                        }, 1000); // Wait 2 seconds before starting to fade out
                    }
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
        $("#action-ban-btn").data("user_id", user_Id);
        $("#action-delete-btn").data("user_id", user_Id);
        $(".profile-btn").removeClass("d-none");
        $("#user-container").addClass("d-none");
        $("#profile-container").removeClass("d-none");
        fetchUsersDetails(user_Id, "", "sentThisUserDetails", "");
    } else {
        $("#page-title").text("Teacher Management")
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
    ////////////////////////////////////////////////////////////////////
    ///////           Registered Course Navigation Bnts          ///////
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
                fetchUsersDetails(user_Id, registeredCurrentPage, "fetchRegistered", "");
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
                fetchUsersDetails(user_Id, registeredCurrentPage, "fetchRegistered", "");
            }, 800);
        }
    });
    // operations for in between prevBtn and nextBtn
    $("#pagination-BtnRegisteredCourse").on("click", ".pageBtn", function () {
        $("#pagination-BtnRegisteredCourse .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        registeredCurrentPage = $(this).text();
        var containerTop = $("#registeredCourseDiv").offset().top;
        $("html, body").scrollTop(containerTop);
        setTimeout(function () {
            $("#course-registered").empty();
            $("#course-registered-loader").removeClass("d-none");
            fetchUsersDetails(user_Id, registeredCurrentPage, "fetchRegistered", "");
        }, 800);
    });
    ////////////////////////////////////////////////////////////////////
    ///////           Created Course Navigation Bnts          ///////
    ////////////////////////////////////////////////////////////////////
    // operations for prevBtn 
    $("#prevBtnCreatedCourse").on("click", function () {
        // Ensure page doesn't go below 1
        if (createdCurrentPage > 1) {
            $("#nextBtnCreatedCourse").addClass("disabled");
            $("#prevBtnCreatedCourse").addClass("disabled");
            var containerTop = $("#createdCourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);
            createdCurrentPage--;
            $("#pagination-BtnCreatedCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnCreatedCourse .pageBtn:contains('${createdCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#course-created").empty();
                $("#course-created-loader").removeClass("d-none");
                fetchUsersDetails(user_Id, createdCurrentPage, "fetchCreated", "");
            }, 800);
        }
    });

    // operations for nextBtn
    $("#nextBtnCreatedCourse").on("click", function () {
        // Ensure current page doesn't exceed total pages
        if (createdCurrentPage < totalCreatedPages) {
            $("#nextBtnCreatedCourse").addClass("disabled");
            $("#prevBtnCreatedCourse").addClass("disabled");
            var containerTop = $("#createdCourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            createdCurrentPage++;

            $("#pagination-BtnCreatedCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnCreatedCourse .pageBtn:contains('${createdCurrentPage}')`).addClass("custom-button");
            setTimeout(function () {
                $("#course-created").empty();
                $("#course-created-loader").removeClass("d-none");
                fetchUsersDetails(user_Id, createdCurrentPage, "fetchCreated", "");
            }, 800);
        }
    });
    // operations for in between prevBtn and nextBtn
    $("#pagination-BtnCreatedCourse").on("click", ".pageBtn", function () {
        $("#pagination-BtnCreatedCourse .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        createdCurrentPage = $(this).text();
        var containerTop = $("#createdCourseDiv").offset().top;
        $("html, body").scrollTop(containerTop);
        setTimeout(function () {
            $("#course-created").empty();
            $("#course-created-loader").removeClass("d-none");
            fetchUsersDetails(user_Id, createdCurrentPage, "fetchCreated", "");
        }, 800);
    });
    ////////////////////////////////////////////////////////////////////
    ///////           feedback Course Navigation Bnts          ///////
    ////////////////////////////////////////////////////////////////////
    // operations for prevBtn 
    $("#prevBtnfeedbackCourse").on("click", function () {
        if (feedbackCurrentPage > 1) {
            $(this).addClass("disabled");
            $("#prevBtnfeedbackCourse").addClass("disabled");
            $("#nextBtnfeedbackCourse").addClass("disabled");
            var containerTop = $("#feedbackCourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            feedbackCurrentPage--;

            $("#pagination-BtnfeedbackCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnfeedbackCourse .pageBtn:contains('${feedbackCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#course-feedback").empty();
                $("#course-feedback-loader").removeClass("d-none");
                fetchUsersDetails(user_Id, feedbackCurrentPage, "fetchFeedback", "");
            }, 800);
        }
    });

    // Operations for nextBtn for feedback courses
    $("#nextBtnfeedbackCourse").on("click", function () {
        if (feedbackCurrentPage < totalfeedbackPages) {
            $(this).addClass("disabled");
            var containerTop = $("#feedbackCourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            feedbackCurrentPage++;

            $("#pagination-BtnfeedbackCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnfeedbackCourse .pageBtn:contains('${feedbackCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#course-feedback").empty();
                $("#course-feedback-loader").removeClass("d-none");
                fetchUsersDetails(user_Id, feedbackCurrentPage, "fetchFeedback", "");
            }, 800);
        }
    });
    // operations for in between prevBtn and nextBtn
    $("#pagination-BtnfeedbackCourse").on("click", ".pageBtn", function () {
        feedbackCurrentPage = $(this).text();
        $("#pagination-BtnfeedbackCourse .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        var containerTop = $("#feedbackCourseDiv").offset().top;
        $("html, body").scrollTop(containerTop);
        setTimeout(function () {
            $("#course-feedback").empty();
            $("#course-feedback-loader").removeClass("d-none");
            fetchUsersDetails(user_Id, feedbackCurrentPage, "fetchFeedback", "");
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
            $("#message-empty").addClass("d-none");
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
    $("#student-btn").on("click", function () {
        $("#message-empty").addClass("d-none");
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
    var temp_control = "";
    var element_open = false;

    $("#course-registered").on("click", ".view-score", function () {
        var temp_num = $(this).data("num");
        var temp_user_id = "#view-score-" + temp_num;
        if (temp_control == temp_num) {
            if (element_open == true) {
                element_open = false;
                $(temp_user_id).hide("slow");
            } else {
                element_open = true;
                $(temp_user_id).show("slow");
            }
        } else {
            element_open = true;
            temp_control = temp_num;
            $("#course-registered .view-score-div").hide("slow")
            $(temp_user_id).show("slow");
        }
    });

    $("#action-approve-btn").click(function () {
        if (!cValue) {
            var urlParams = new URLSearchParams(window.location.search);
            cValue = urlParams.get('c');
        }
        fetchUsersDetails(cValue, "", "approve", "");
    });

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
    $("#confirmRejection").on("click", function () {
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
            if (!cValue) {
                var urlParams = new URLSearchParams(window.location.search);
                cValue = urlParams.get('c');
            }
            fetchUsersDetails(cValue, $("#reason").val().trim(), 'reject', '');
            $("#reason").val("");
        }
    })
})