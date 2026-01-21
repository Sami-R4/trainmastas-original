$(document).ready(function () {
    var registeredCurrentPage = 1, activityCurrentPage = 1, createdCurrentPage = 1, paymentCurrentPage = 1, totalActivityPages, totalCreatedPages, totalPaymentPages, totalRegisteredPages, activityMax, createdMax, registeredMax, paymentMax, paymentTab = "all";
    var payment_numbering = 0, firstLoad = true, filterValue = "all";

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
                fetchValues("registeredCourse", registeredCurrentPage);
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
                fetchValues("registeredCourse", registeredCurrentPage);
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
            fetchValues("registeredCourse", registeredCurrentPage);
        }, 800);
    });


    ////////////////////////////////////////////////////////////////////
    ///////           Created Course Navigation Bnts          ///////
    ////////////////////////////////////////////////////////////////////
    // operations for prevBtn 
    $("#prevBtnCreatedCourse").on("click", function () {
        if (createdCurrentPage > 1) {
            $(this).addClass("disabled");
            $("#prevBtnCreatedCourse").addClass("disabled");
            $("#nextBtnCreatedCourse").addClass("disabled");
            var containerTop = $("#createdCourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            createdCurrentPage--;

            $("#pagination-BtnCreatedCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnCreatedCourse .pageBtn:contains('${createdCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#course-created").empty();
                $("#course-created-loader").removeClass("d-none");
                fetchValues("createdCourse", createdCurrentPage);
            }, 800);
        }
    });

    // Operations for nextBtn for created courses
    $("#nextBtnCreatedCourse").on("click", function () {
        if (createdCurrentPage < totalCreatedPages) {
            $(this).addClass("disabled");
            var containerTop = $("#createdCourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            createdCurrentPage++;

            $("#pagination-BtnCreatedCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnCreatedCourse .pageBtn:contains('${createdCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#course-created").empty();
                $("#course-created-loader").removeClass("d-none");
                fetchValues("createdCourse", createdCurrentPage);
            }, 800);
        }
    });
    // operations for in between prevBtn and nextBtn
    $("#pagination-BtnCreatedCourse").on("click", ".pageBtn", function () {
        createdCurrentPage = $(this).text();
        $("#pagination-BtnCreatedCourse .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        var containerTop = $("#createdCourseDiv").offset().top;
        $("html, body").scrollTop(containerTop);
        setTimeout(function () {
            $("#course-created").empty();
            $("#course-created-loader").removeClass("d-none");
            fetchValues("createdCourse", createdCurrentPage);
        }, 800);
    });


    ////////////////////////////////////////////////////////////////////
    ///////           Payment Course Navigation Bnts          ///////
    ////////////////////////////////////////////////////////////////////
    // operations for prevBtn 
    $("#prevBtnPaymentCourse").on("click", function () {
        if (paymentCurrentPage > 1) {
            $(this).addClass("disabled");
            $("#prevBtnPaymentCourse").addClass("disabled");
            $("#nextBtnPaymentCourse").addClass("disabled");

            paymentCurrentPage--;

            $("#pagination-BtnPaymentCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnPaymentCourse .pageBtn:contains('${paymentCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#transaction-table-body").empty();
                $("#table-div").addClass("d-none");
                $("#course-payment-loader").removeClass("d-none");
                var dataToSend = {
                    purpose: "PaymentCourse",
                    paymentTab: paymentTab,
                    filterValue: filterValue
                };
                fetchValues(dataToSend, paymentCurrentPage);
            }, 800);
        }
    });

    // Operations for nextBtn for payment courses
    $("#nextBtnPaymentCourse").on("click", function () {
        if (paymentCurrentPage < paymentMax) {
            $(this).addClass("disabled");

            paymentCurrentPage++;

            $("#pagination-BtnPaymentCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnPaymentCourse .pageBtn:contains('${paymentCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#transaction-table-body").empty();
                $("#table-div").addClass("d-none");
                $("#course-payment-loader").removeClass("d-none");
                var dataToSend = {
                    purpose: "PaymentCourse",
                    paymentTab: paymentTab,
                    filterValue: filterValue
                };
                fetchValues(dataToSend, paymentCurrentPage);
            }, 800);
        }
    });
    // operations for in between prevBtn and nextBtn
    $("#pagination-BtnPaymentCourse").on("click", ".pageBtn", function () {
        paymentCurrentPage = $(this).text();
        $("#pagination-BtnPaymentCourse .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        setTimeout(function () {
            $("#transaction-table-body").empty();
            $("#table-div").addClass("d-none");
            $("#course-payment-loader").removeClass("d-none");
            var dataToSend = {
                purpose: "PaymentCourse",
                paymentTab: paymentTab,
                filterValue: filterValue
            };
            fetchValues(dataToSend, paymentCurrentPage);
        }, 800);
    });
    ////////////////////////////////////////////////////////////////////
    ///////           Activity Course Navigation Bnts          ///////
    ////////////////////////////////////////////////////////////////////
    // Operations for prevBtn for activity courses
    $("#prevBtnActivityCourse").on("click", function () {
        if (activityCurrentPage > 1) {
            $("#prevBtnActivityCourse").addClass("disabled");
            $("#nextBtnActivityCourse").addClass("disabled");
            var containerTop = $("#activityCourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            activityCurrentPage--;

            $("#pagination-BtnActivityCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnActivityCourse .pageBtn:contains('${activityCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#course-activities").empty();
                $("#course-activities-loader").removeClass("d-none");
                fetchValues("activityCourse", activityCurrentPage);
            }, 800);
        }
    });

    // Operations for nextBtn for activity courses
    $("#nextBtnActivityCourse").on("click", function () {
        if (activityCurrentPage < totalActivityPages) {
            $("#prevBtnActivityCourse").addClass("disabled");
            $("#nextBtnActivityCourse").addClass("disabled");
            var containerTop = $("#activityCourseDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            activityCurrentPage++;

            $("#pagination-BtnActivityCourse .pageBtn").removeClass("custom-button");
            $(`#pagination-BtnActivityCourse .pageBtn:contains('${activityCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                $("#course-activities").empty();
                $("#course-activities-loader").removeClass("d-none");
                fetchValues("activityCourse", activityCurrentPage);
            }, 800);
        }
    });
    // operations for in between prevBtn and nextBtn
    $("#pagination-BtnActivityCourse").on("click", ".pageBtn", function () {
        activityCurrentPage = $(this).text();
        $("#pagination-BtnActivityCourse .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        var containerTop = $("#activityCourseDiv").offset().top;
        $("html, body").scrollTop(containerTop);
        setTimeout(function () {
            $("#course-activities").empty();
            $("#course-activities-loader").removeClass("d-none");
            fetchValues("activityCourse", activityCurrentPage);
        }, 800);
    });
    function displayRegisteredCourse(response) {
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///  Registered Course Section
        var elements = '';
        var element = ``;
        for (var i = 0; i < response.registered_courses.length; i++) {
            var levelTemp = "Completed";
            if (response.registered_courses[i].Level != "c") {
                levelTemp = "Incomplete";
            }
            var element = `
                         <div class="py-3"style="cursor:default">
                             <h2 class="fs-6 text-success fw-semibold mb-0">
                             ${capitalizeFirstLetter(response.registered_courses[i].Title)}
                             </h2>
                             <p class="fs-6 py-0 mb-0 mt-1">By <span>${response.registered_courses[i].creator_name}</span></p>
                             <div class="d-flex justify-content-between mt-2">
                                 <p class="fs-7 py-0 my-0 text-muted ">${levelTemp}</p>
                                 <div>
                                 <a href="viewcourse.php?v=${response.registered_courses[i].course_ID}" class="fs-7 py-0 my-0 text-muted hv-underline me-3">Continue Learning </a>
                                    <a href="displaycourse.php?v=${response.registered_courses[i].course_ID}" class="fs-7 py-0 my-0 text-muted hv-underline">Course Details</a>
                                 </div>
                             </div>
                         </div><hr class="py-0 my-0">`;
            elements = elements + element;
        }
        if (element == '') {
            elements = `<div class="text-center py-2">
                         You have no registered course
                         <div class="mt-3">
                             <a href="courses.php" class="btn btn-outline-success rounded-0">Browse Courses</a>
                         </div>
                     </div>`;
        } else {
            elements = '<hr class="py-0 my-0 mt-3">' + elements;
            if (response.total_registered_courses > 5 || registeredMax > 5) {
                var tempVal = (registeredMax !== null && registeredMax !== undefined) ? registeredMax : response.total_registered_courses;
                totalRegisteredPages = Math.ceil(tempVal / 5);
                registeredMax = response.total_registered_courses;
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
        ///  Created Course Section
        var elements = '';
        var element = ``;
        if (response.userType == "s") {
            $(".instructor-section").remove();
        } else {
            elements = '';
            element = '';
            for (var i = 0; i < response.created_courses.length; i++) {
                var dt = new Date(response.created_courses[i].Date);
                var monthName = dt.toLocaleDateString("en-US", { month: "long" });
                var day = dt.getDate();
                var year = dt.getFullYear();
                var element = `
                                    <div class="py-3" style="cursor:default">
                                    <h2 class="fs-6 text-success fw-semibold mb-0">
                                    ${capitalizeFirstLetter(response.created_courses[i].Title)}
                                    </h2>
                                    <div class="d-flex justify-content-between mt-2">
                                        <div class="text-muted py-0 mx-0">${day} ${monthName} ${year}</div>
                                        <div class="text-muted py-0 mx-0"><span class="me-2">${numRegistered = response.created_courses[i].num_registered > 0 ? response.created_courses[i].num_registered : "No"} Registered</span>
                                        <span class="">${numRegistered = response.created_courses[i].num_active > 0 ? response.created_courses[i].num_active : "No"} Active</span></div>
                                        <a href="addcourse.php?c=${response.created_courses[i].course_ID}" class=" py-0 my-0 text-muted hv-underline">Edit Course</a>
                                    </div>
                                </div>
                                <hr class="py-0 my-0">`;
                elements = elements + element;
            }
            if (element == '') {
                var temp_div = response.isUserVerified !== null && response.isUserVerified != 0 ? '<a href="addcourse.php" class="btn btn-outline-success rounded-0">Create Course</a>' : "";
                elements = `<div class="text-center py-2">
                                            You created no course
                                            <div class="mt-3">
                                                ${temp_div}
                                            </div>
                                        </div>`;
            } else {
                elements = '<hr class="py-0 my-0 mt-3">' + elements;
                if (response.total_created_courses > 5 || createdMax > 5) {
                    var tempVal = (createdMax !== null && createdMax !== undefined) ? createdMax : response.total_created_courses;
                    totalCreatedPages = Math.ceil(tempVal / 5);
                    createdMax = response.total_created_courses;
                    create_pages_btn(createdCurrentPage, "CreatedCourse", totalCreatedPages);
                    $("#btn-containerCreatedCourse").removeClass("d-none");
                }
            }
            $("#course-created-loader").addClass("d-none");
            $("#course-created").empty().append(elements);
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////


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
    function displayFunds(response) {
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Display Funds
        // Update Available, Pending, and Withdrew funds

        if (firstLoad == true) {
            if (response.userType == "s") {
                $(".instructor-section").remove();
                $("#containerStats").removeClass("justify-content-between")
            }
            $("#available-funds span").text(`$${formatAmount(response.total_ready_payments_sum)}`);
            $("#pending-funds span").text(`$${formatAmount(response.total_pending_payments_sum)}`);
            $("#withdrew-funds span").text(`$${formatAmount(response.total_withdrew_payments_sum)}`);
            $("#added-funds span").text(`$${formatAmount(response.total_added_payments_sum)}`);
            $("#spent-funds span").text(`$${formatAmount(response.total_spent_payments_sum)}`);
        }
        if ((response.userType == 'c' && response.total_pending_payments_sum <= 0 && response.total_spent_payments_sum <= 0 && response.total_added_payments_sum <= 0
            && response.total_ready_payments_sum <= 0 && response.total_withdrew_payments_sum <= 0)
            || (response.userType == 's' && response.total_spent_payments_sum <= 0 && response.total_added_payments_sum <= 0)
        ) {
            if (firstLoad == true) {
                $(".payment-nav-stat-divs").addClass("d-none");
                $("#filter-select-div").addClass("d-none");
            }
            $(".table-div").addClass("d-none");
            $("#payment-empty").text("Ops! No payment found.").removeClass("d-none");
        } else {
            if (response.payment_courses.length <= 0) {
                if (filterValue == 'all') {
                    $(".table-div").addClass("d-none");
                } else {
                    $("#paymentCourseDiv").addClass("d-none");
                    $("#filter-select-div").removeClass("d-none");
                }
                $("#payment-empty").text("Ops! No payment found.").removeClass("d-none");
                $("#course-payment-loader").addClass("d-none");
                return;
            }
            // Populate the transaction table
            const transactionTableBody = $("#transaction-table-body");
            transactionTableBody.empty(); // Clear existing rows
            var addToPage = (paymentCurrentPage - 1) * 10;
            if (response.state == 'PaymentWithdrew') {
                $("#table-fund-header").empty().append(`
                        <tr>
                            <th scope="col">Transaction #</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Withdrawal Method</th>
                            <th scope="col">Requested_date</th>
                            <th scope="col">Approved Date</th>
                        </tr>`)
                response.payment_courses.forEach((course, index) => {
                    // Format transaction ID
                    const transactionNumber = `TXN${((index + 1) + addToPage).toString().padStart(3, "0")}`;
                    // Append row
                    transactionTableBody.append(`
                            <tr>
                                <td>${transactionNumber}</td>
                                <td>$${formatAmount(course.Amount)}</td>
                                <td>${course.Withdrawal_method != 'internal' ? capitalizeFirstLetter(course.Withdrawal_method) : "Reused Fund"}</td>
                                <td>${course.requested_date != null ? course.requested_date : "N/A"}</td>
                                <td>${course.approved_date != null ? course.approved_date : "N/A"}</td>
                            </tr>
                        `);
                });
                $("#filter-select-div").addClass("d-none");
            } else if (response.state == 'PaymentAdded' || firstLoad == true) {
                $("#filter-select-div").addClass("d-none");
                $("#table-fund-header").empty().append(`
                        <tr>
                            <th scope="col">Transaction #</th>
                            <th scope="col">Status</th>
                            <th scope="col">Transaction Method</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Date</th>
                        </tr>`)
                response.payment_courses.forEach((course, index) => {
                    // Format transaction ID
                    const transactionNumber = `TXN${((index + 1) + addToPage).toString().padStart(3, "0")}`;
                    // Append row
                    transactionTableBody.append(`
                            <tr>
                                <td>${transactionNumber}</td>
                                <td>${course.status}</td>
                                <td>${capitalizeFirstLetter(course.Payment_method)}</td>
                                <td>$${formatAmount(course.Amount)}</td>
                                <td>${course.Date}</td>
                            </tr>
                        `);
                });
            } else {
                $("#filter-select-div").removeClass("d-none");
                $("#table-fund-header").empty().append(`
                        <tr>
                            <th scope="col">Transaction #</th>
                            <th scope="col">Course Name</th>
                            <th scope="col">Purpose</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Date</th>
                        </tr>`)
                response.payment_courses.forEach((course, index) => {
                    // Format transaction ID
                    const transactionNumber = `TXN${((index + 1) + addToPage).toString().padStart(3, "0")}`;
                    const cost = `$${formatAmount(course.Amount)}`;
                    var purpose = "Fee";
                    if (course.Purpose == 'cer') {
                        purpose = "Certificate"
                    };
                    // Append row
                    transactionTableBody.append(`
                <tr>
                    <td>${transactionNumber}</td>
                    <td>${capitalizeFirstLetter(course.Title)}</td>
                    <td>${purpose}</td>
                    <td>${cost}</td>
                    <td>${course.Date}</td>
                </tr>
            `);
                });
            }
            $("#payment-empty").addClass("d-none");
            $(".table-div").removeClass("d-none");
            if (response.total_payment_courses > 10 || paymentMax > 10) {
                $("#btn-containerPaymentCourse").removeClass("d-none");
                var tempVal = response.total_payment_courses;
                // This code needs to turn twice before the tempval is assigned the correct value(actual max)
                //  var tempVal = (paymentMax !== null && paymentMax !== undefined) ? paymentMax : response.total_payment_courses;
                totalPaymentPages = Math.ceil(tempVal / 10);
                paymentMax = response.total_payment_courses;
                create_pages_btn(paymentCurrentPage, "PaymentCourse", totalPaymentPages);
                $("#btn-containerPaymentCourse").removeClass("d-none");
            }
        }
        $("#course-payment-loader").addClass("d-none");
        $("#table-div").removeClass("d-none");


    }

    function displayActivityCourse(response) {
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///  Activities Course Section
        var elements = '';
        var element = ``;
        for (var i = 0; i < response.activity_courses.length; i++) {
            if (response.activity_courses[i].Level !== "t" || response.activity_courses[i].Level !== "c") {
                element = `<a href="viewcourse.php?v=${response.activity_courses[i].course_ID}" style="text-decoration: none;" class="text-black d-block px-2 py-3 activity-hover">
                                            <span class="me-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="36px" height="40px" viewBox="0 0 1920 1920">
                                                    <path d="M1801.441 0v1920H219.03v-439.216h-56.514c-31.196 0-56.515-25.299-56.515-56.47 0-31.172 25.319-56.47 56.515-56.47h56.514V1029.02h-56.514c-31.196 0-56.515-25.3-56.515-56.471 0-31.172 25.319-56.47 56.515-56.47h56.514V577.254h-56.514c-31.196 0-56.515-25.299-56.515-56.47 0-31.172 25.319-56.471 56.515-56.471h56.514V0h1582.412Zm-113.03 112.941H332.06v351.373h56.515c31.196 0 56.514 25.299 56.514 56.47 0 31.172-25.318 56.47-56.514 56.47H332.06v338.824h56.515c31.196 0 56.514 25.3 56.514 56.471 0 31.172-25.318 56.47-56.514 56.47H332.06v338.824h56.515c31.196 0 56.514 25.299 56.514 56.47 0 31.172-25.318 56.471-56.514 56.471H332.06v326.275h1356.353V112.94ZM640.289 425.201H1388.9v112.94H640.288v-112.94Zm0 214.83h639.439v112.94h-639.44v-112.94Zm0 534.845H1388.9v112.94H640.288v-112.94Zm0 214.83h639.439v112.94h-639.44v-112.94Z" fill-rule="evenodd" />
                                                </svg>
                                            </span>
                                            <span>
                                            Module ${response.activity_courses[i].Level}: ${capitalizeFirstLetter(response.activity_courses[i].moduleTitle)} of ${capitalizeFirstLetter(response.activity_courses[i].Title)}
                                            </span>
                                        </a>
                                        <hr class="py-0 my-0">`
            } else if (response.activity_courses[i].Level !== "t") {
                element = ` <a href="viewcourse.php?v=${response.activity_courses[i].course_ID}" style="text-decoration: none;" class="text-black d-block px-2 py-3 activity-hover">
                                            <span class="me-2 ">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="40px" width="40px" version="1.1" id="Layer_1" viewBox="0 0 512 512" xml:space="preserve">
                                                    <g>
                                                        <g>
                                                            <path d="M434.087,42.402h-93.284h-28.318C305.306,17.472,282.542,0,256,0s-49.305,17.472-56.485,42.402h-28.318H77.913    c-4.391,0-7.95,3.559-7.95,7.95V504.05c0,4.392,3.56,7.95,7.95,7.95h356.174c4.391,0,7.95-3.559,7.95-7.95V50.352    C442.037,45.96,438.478,42.402,434.087,42.402z M179.147,84.273V58.302h26.688c0.038,0,0.075-0.005,0.113-0.005    c0.174-0.002,0.347-0.013,0.518-0.027c0.092-0.007,0.184-0.014,0.276-0.023c0.172-0.019,0.34-0.047,0.509-0.077    c0.092-0.017,0.184-0.032,0.276-0.051c0.159-0.035,0.315-0.077,0.471-0.121c0.098-0.028,0.195-0.053,0.29-0.085    c0.145-0.047,0.286-0.102,0.427-0.156c0.101-0.039,0.202-0.077,0.301-0.12c0.134-0.058,0.262-0.124,0.391-0.189    c0.1-0.05,0.2-0.099,0.297-0.154c0.127-0.071,0.25-0.148,0.373-0.227c0.091-0.057,0.183-0.113,0.272-0.175    c0.125-0.086,0.244-0.179,0.364-0.272c0.08-0.061,0.16-0.122,0.237-0.187c0.122-0.102,0.237-0.211,0.353-0.321    c0.068-0.065,0.137-0.127,0.202-0.194c0.115-0.117,0.222-0.239,0.329-0.363c0.059-0.069,0.122-0.137,0.179-0.208    c0.101-0.124,0.194-0.253,0.287-0.384c0.057-0.08,0.116-0.158,0.17-0.24c0.082-0.124,0.157-0.252,0.232-0.382    c0.056-0.097,0.115-0.194,0.166-0.294c0.061-0.118,0.118-0.239,0.174-0.36c0.055-0.12,0.111-0.238,0.161-0.361    c0.043-0.108,0.082-0.218,0.121-0.329c0.05-0.142,0.1-0.285,0.141-0.43c0.03-0.102,0.054-0.206,0.079-0.31    c0.038-0.156,0.074-0.312,0.104-0.472c0.007-0.04,0.019-0.08,0.026-0.12c3.479-20.726,21.278-35.768,42.324-35.768    c21.045,0,38.846,15.042,42.324,35.767c0.007,0.044,0.02,0.086,0.028,0.129c0.024,0.13,0.053,0.26,0.084,0.388    c0.028,0.118,0.057,0.235,0.09,0.351c0.035,0.123,0.073,0.243,0.113,0.364c0.041,0.122,0.086,0.243,0.133,0.362    c0.042,0.107,0.085,0.213,0.131,0.318c0.058,0.13,0.121,0.258,0.185,0.385c0.046,0.089,0.09,0.178,0.139,0.265    c0.078,0.14,0.162,0.275,0.248,0.408c0.046,0.071,0.088,0.142,0.136,0.212c0.103,0.151,0.213,0.294,0.325,0.436    c0.038,0.049,0.074,0.101,0.115,0.148c0.156,0.187,0.318,0.368,0.49,0.539c0.001,0.001,0.002,0.002,0.003,0.003    c0.172,0.171,0.351,0.333,0.536,0.488c0.071,0.059,0.147,0.112,0.221,0.17c0.116,0.09,0.231,0.18,0.352,0.263    c0.094,0.066,0.193,0.125,0.29,0.185c0.106,0.067,0.212,0.134,0.321,0.195c0.105,0.059,0.212,0.113,0.32,0.167    c0.11,0.056,0.221,0.11,0.334,0.161c0.108,0.049,0.217,0.093,0.328,0.137c0.122,0.049,0.245,0.093,0.37,0.136    c0.105,0.035,0.209,0.07,0.316,0.102c0.144,0.042,0.289,0.078,0.436,0.112c0.092,0.021,0.182,0.044,0.276,0.063    c0.186,0.036,0.374,0.063,0.563,0.086c0.058,0.007,0.117,0.018,0.175,0.023c0.255,0.025,0.513,0.04,0.774,0.04    c0.004,0,0.008-0.001,0.013-0.001h26.685v25.971v21.732H179.147V84.273z M171.197,121.905h169.607c4.391,0,7.95-3.559,7.95-7.95    V92.224h43.462v293.631h-72.613c-4.391,0-7.95,3.559-7.95,7.95v72.613H119.785V92.224h43.462v21.731    C163.246,118.346,166.806,121.905,171.197,121.905z M380.971,401.756l-53.419,53.419v-53.419H380.971z M426.137,496.099H85.863    V58.302h77.383v18.021h-51.412c-4.391,0-7.95,3.559-7.95,7.95v390.095c0,4.392,3.56,7.95,7.95,7.95h207.768    c0.262,0,0.524-0.014,0.784-0.039c0.12-0.012,0.235-0.034,0.354-0.051c0.138-0.02,0.278-0.036,0.414-0.064    c0.136-0.026,0.266-0.064,0.399-0.098c0.119-0.03,0.239-0.056,0.355-0.091c0.129-0.039,0.254-0.088,0.382-0.134    c0.118-0.042,0.236-0.082,0.353-0.129c0.119-0.049,0.233-0.107,0.349-0.162c0.119-0.056,0.24-0.109,0.356-0.172    c0.111-0.059,0.216-0.127,0.324-0.192c0.115-0.069,0.231-0.134,0.343-0.209c0.118-0.078,0.228-0.165,0.34-0.25    c0.095-0.071,0.192-0.137,0.284-0.212c0.19-0.156,0.371-0.32,0.545-0.493c0.012-0.013,0.025-0.022,0.037-0.034l80.563-80.563    c0.011-0.011,0.019-0.022,0.03-0.033c0.174-0.176,0.34-0.358,0.497-0.549c0.075-0.092,0.141-0.189,0.212-0.284    c0.085-0.113,0.173-0.224,0.251-0.341c0.075-0.113,0.141-0.23,0.211-0.347c0.064-0.106,0.13-0.211,0.189-0.32    c0.064-0.12,0.119-0.243,0.176-0.365c0.053-0.113,0.109-0.224,0.158-0.339c0.05-0.12,0.089-0.242,0.133-0.363    c0.044-0.123,0.092-0.246,0.13-0.372c0.037-0.122,0.064-0.245,0.094-0.368c0.032-0.128,0.068-0.255,0.094-0.386    c0.029-0.144,0.046-0.288,0.066-0.434c0.016-0.112,0.037-0.223,0.049-0.336c0.025-0.262,0.04-0.526,0.039-0.789V84.273    c0-4.392-3.56-7.95-7.95-7.95h-51.411V58.302h77.383V496.099z" />
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path d="M256,152.646c-55.821,0-101.234,45.413-101.234,101.234c0,55.821,45.413,101.234,101.234,101.234    s101.234-45.413,101.234-101.234C357.234,198.059,311.821,152.646,256,152.646z M256,339.213    c-47.053,0-85.333-38.28-85.333-85.333c0-47.053,38.28-85.333,85.333-85.333s85.333,38.28,85.333,85.333    C341.333,300.933,303.053,339.213,256,339.213z" />
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <path d="M304.023,212.216c-3.105-3.104-8.139-3.104-11.243,0l-68.581,68.583l-19.82-19.82c-3.105-3.104-8.139-3.104-11.243,0    c-3.105,3.106-3.105,8.139,0,11.244l25.441,25.441c1.552,1.552,3.587,2.328,5.621,2.328c2.034,0,4.07-0.776,5.621-2.328    l74.203-74.203C307.128,220.355,307.128,215.322,304.023,212.216z" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            </span>
                                            <span>
                                            Test of ${capitalizeFirstLetter(response.activity_courses[i].Title)} 
                                            </span>
                                        </a>
                                        <hr class="py-0 my-0">`
            }
            elements = elements + element;
        }
        if (element == '') {
            elements = `<div class="text-center py-2 mt-2">
                            You have no activities
                            <div class="mt-3">
                                <a href="courses.php" class="btn btn-outline-success rounded-0">Browse Courses</a>
                            </div>
                        </div>`;
        } else {
            elements = '<hr class="py-0 my-0 mt-3">' + elements;
            if (response.total_activity_courses > 5 || activityMax > 5) {
                var tempVal = (activityMax !== null && activityMax !== undefined) ? activityMax : response.total_activity_courses;
                totalActivityPages = Math.ceil(tempVal / 5);
                activityMax = response.total_activity_courses;
                create_pages_btn(activityCurrentPage, "ActivityCourse", totalActivityPages);
                $("#btn-containerActivityCourse").removeClass("d-none");
            }
        }
        $("#course-activities-loader").addClass("d-none");
        $("#course-activities").empty().append(elements);
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
    }
    var temp_control = false;
    $(".payment-nav").click(function () {
        temp_control = true;
        $("#filter-select").val('all').change();
        filterValue = 'all';

        paymentTab = $(this).data("id");
        payment_numbering = 0;
        $(".payment-nav").removeClass("activePayment-nav");
        $(this).addClass("activePayment-nav");
        paymentCurrentPage = 1;
        // Create the object to send to the backend  
        var dataToSend = {
            purpose: "PaymentCourse",
            paymentTab: paymentTab
        };
        setTimeout(function () {
            $("#transaction-table-body").empty();
            $("#table-div").addClass("d-none");
            $("#payment-empty").addClass("d-none");
            $("#course-payment-loader").removeClass("d-none");
            $("#btn-containerPaymentCourse").addClass("d-none");
            fetchValues(dataToSend, 1);
        }, 800);
    })

    $("#filter-select").on("change", function () {
        paymentCurrentPage = 1;
        payment_numbering = 0;
        if (temp_control == true) {
            temp_control = false;
        } else {

            // Check if a value has been selected  
            $("#filter-select").val() !== "" ? filterValue = $("#filter-select").val() : "all";
            // Create the object to send to the backend  
            var dataToSend = {
                purpose: "PaymentCourse",
                paymentTab: paymentTab,
                filterValue: filterValue
            };
            setTimeout(function () {
                $("#transaction-table-body").empty();
                $("#table-div").addClass("d-none");
                $("#payment-empty").addClass("d-none");
                $("#course-payment-loader").removeClass("d-none");
                $("#btn-containerPaymentCourse").addClass("d-none");
                fetchValues(dataToSend, 1);
            }, 800);
        }
    });

    function fetchValues(purpose, page) {
        $.ajax({
            url: "app/dashboard_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            data: { purpose: purpose, page: page },
            dataType: "json",
            success: function (response) {
                setTimeout(function () {
                    if (response.state === "success") {
                        if (firstLoad == true) {
                            $('#fullScreenLoader').addClass("d-none");
                            $("#activity-num").text("(" + response.total_activity_courses + ")");
                            $("#registered-num").text("(" + response.total_registered_courses + ")");
                            $("#created-num").text("(" + response.total_created_courses + ")");
                            activityMax = response.total_activity_courses;
                            registeredMax = response.total_registered_courses;
                            createdMax = response.total_created_courses;
                            if (response.userType === 'c') {
                                if (response.isUserVerified == 1) {
                                    // Can start creating courses
                                    $("#body .startCreatingCourses").removeClass("d-none");
                                    $("#verifiedAwaitedDiv").addClass("d-none");
                                }else if (response.isUserVerified === null && response.verifiedDate === null) {
                                    // Initial applying 
                                    $("#verifiedContainerDiv").removeClass("d-none");
                                    $("#body .startCreatingCourses").addClass("d-none");
                                } else if (response.reapplied == 1 || (response.isUserVerified === null && response.verifiedDate !== null)) {
                                    // Under processing
                                    $("#body .startCreatingCourses").addClass("d-none");
                                    $(".verify-btn").addClass("d-none");
                                    $("#verifiedContainerDiv").removeClass("d-none");
                                    $("#verify_message").text("Your account is under verification.")
                                } else if (response.isUserVerified == 0 && response.Reason != null && response.reapplied == 0) {
                                    $("#body .startCreatingCourses").addClass("d-none");
                                    $("#verifiedAwaitedDiv").empty().append(`<span>Your request to start producing courses was declined due to the following reason:</span><div class="my-3">${capitalizeFirstLetter(response.Reason)}</div> <span>If you believe this was an error, contact support team at support@trainmastas.com.</span> <div class="text-center mt-3"><button class="btn btn-outline-success rounded-0 verify-btn" data-bs-toggle="modal" data-bs-target="#verifyModal">Reapply</button></div>`).removeClass("d-none");
                                }
                            }
                        }
                        displayActivityCourse(response);
                        displayCreatedCourse(response);
                        displayRegisteredCourse(response);
                        displayFunds(response);
                    } else if (response.state == "registeredCourse") {
                        displayRegisteredCourse(response)

                    } else if (response.state == "createdCourse") {
                        displayCreatedCourse(response)

                    } else if (response.state == "activityCourse") {
                        displayActivityCourse(response);

                    } else if (response.state == "PaymentCourse" || response.state == "PaymentWithdrew" || response.state == "PaymentAdded") {
                        displayFunds(response);

                    }
                }, 1000);

            }
        });
    }
    var dataToSend_temp = {
        purpose: "sendUserDetails",
        paymentTab: 'transactions'
    };
    fetchValues("sendUserDetails", 0);
    setTimeout(function () {
        firstLoad = false;
    }, 4000);


    ///////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////
    ///////////////         Withdrawal Processes            ///////////////
    ///////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////
    $("#withdraw-bnt").click(function () {
        $("#withdrawModal").modal("show");
    })
    // Show fund-section2 when "Reuse Fund" is clicked
    $('#reuse-btn').on('click', function () {
        $('#fund-section1').addClass('d-none');
        $('#fund-section2').removeClass('d-none');
    });
    $(".backToWithdrawal").click(function () {
        $('#fund-section3').addClass('d-none');
        $('#fund-section2').addClass('d-none');
        $('#fund-section1').removeClass('d-none');
    })
    $("#close-btn-fund").click(function () {
        $('#fund-section3').addClass('d-none');
        $('#fund-section2').addClass('d-none');
        $('#fund-section1').removeClass('d-none');
    })
    // Handle Reuse submission
    $('#confirm-reuse-btn').on('click', function () {
        const amount = parseFloat($('#reuse-amount').val());
        const msgBox = $('#reuse-msg');
        msgBox.text('').removeClass('text-success text-danger');

        // Basic frontend validation
        if (isNaN(amount) || amount <= 0) {
            msgBox.text('Please enter a valid amount.').addClass('text-danger');
            return;
        }

        $.ajax({
            url: "app/dashboard_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            dataType: "json",
            data: {
                purpose: "reuseFund",
                amount: amount
            },
            success: function (response) {
                if (response.state === "success") {
                    msgBox.text(response.message).addClass('text-success');
                    var currentBalance = parseFloat($(".userBalance").first().text().replace(/[$,]/g, ''));
                    var totalAmount = currentBalance + amount;
                    $(".userBalance").text('$' + totalAmount.toFixed(2));
                    $("#fund-balance").text("$" + amount);
                    $('#fund-section2').addClass('d-none');
                    $('#fund-section3').removeClass('d-none');
                    $("#available-funds span").text(`$${formatAmount(response.total_ready_payments_sum)}`);
                    $("#withdrew-funds span").text(`$${formatAmount(response.total_withdrew_payments_sum)}`);
                } else {
                    msgBox.text(response.message).addClass('text-danger');
                }
            },
            error: function () {
                msgBox.text('An error occurred. Please try again.').addClass('text-danger');
            }
        });
    });

    // Verify User
    $("#submitAccountForVerification-btn").click(function () {
        $.ajax({
            url: "app/dashboard_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            dataType: "json",
            data: {
                purpose: "submitForVerification"
            },
            success: function (response) {
                $("#messageVerify").addClass("d-none");
                if (response.state === "success") {
                    $("#alertVerify").text(response.message).addClass('text-success').removeClass('text-danger');
                    $("#submitAccountForVerification-btn").addClass("d-none");
                    $("#verifiedContainerDiv").addClass("d-none");
                } else if (response.state === "error") {
                    $("#alertVerify").text(response.message).addClass('text-danger').removeClass('text-success');
                } else if (response.state == "verified" || response.state == "pending" || response.state == "submittedRequest" || response.state == "rejected") {
                    if (response.state == "submittedRequest") {
                        $("#alertVerify").text(response.message).removeClass("text-danger").addClass("text-success");
                        $("#verify_message").text("Your account is under verification.")
                    } else {
                        $("#alertVerify").text(response.message).addClass("text-danger").removeClass("text-success");
                    }
                    $(".verify-btn").addClass("d-none");
                    $("#submitAccountForVerification-btn").addClass("d-none");
                    $("#verifyProfileLink").removeClass("d-none");
                } else {
                    $("#submitAccountForVerification-btn").addClass("d-none");
                    $("#verifyProfileLink").removeClass("d-none");
                    $("#alertVerify").text(response.message).addClass('text-danger').removeClass('text-success');
                }
            },
            error: function () {
                $("#alertVerify").text('An error occurred. Please try again.').addClass('text-danger');
            }
        });
    })
})