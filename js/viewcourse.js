$(document).ready(function () {

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
    //                        Determine time ago
    /////////////////////////////////////////////////////////////////
    function timeAgo(date, now) {
        var now = new Date(now);
        let secondsPast = (now.getTime() - new Date(date).getTime()) / 1000;
        if (secondsPast < 60) {
            return `${Math.floor(secondsPast)}s ago`;
        }
        if (secondsPast < 3600) {
            return `${Math.floor(secondsPast / 60)}m ago`;
        }
        if (secondsPast < 86400) {
            return `${Math.floor(secondsPast / 3600)}h ago`;
        }
        if (secondsPast < 604800) {
            return `${Math.floor(secondsPast / 86400)}d ago`;
        }
        if (secondsPast < 2592000) {
            return `${Math.floor(secondsPast / 604800)}w ago`;
        }
        if (secondsPast < 31536000) {
            return `${Math.floor(secondsPast / 2592000)}m ago`;
        }
        if (secondsPast < 3153600000) {
            return `${Math.floor(secondsPast / 31536000)}y ago`;
        }
        return `${Math.floor(secondsPast / 3153600000)}00y ago`; // handling for 100 years and beyond
    }

    /////////////////////////////////////////////////////////////////
    //                        Calculate Percentage
    /////////////////////////////////////////////////////////////////
    function calculatePercentage(score, total) {
        if (total === 0) {
            return 0;
        } else {
            let percentage = (score / total) * 100;
            return `${percentage.toFixed(2)}/100`;
        }
    }


    /////////////////////////////////////////////////////////////////
    //                        Format Date
    /////////////////////////////////////////////////////////////////
    function formatDate(date) {
        const options = { weekday: 'short', year: 'numeric', month: 'long', day: '2-digit' };
        const formattedDate = date.toLocaleDateString('en-US', options);
        let hours = date.getHours();
        const minutes = date.getMinutes().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'  

        return `${formattedDate} at ${hours}:${minutes}${ampm}`;
    }


    /////////////////////////////////////////////////////////////////
    //                        Format Date DDMMYY
    /////////////////////////////////////////////////////////////////
    function formatDateAsDDMMYY(date) {
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        let d = new Date(date);
        let day = d.getDate();
        let month = months[d.getMonth()];
        let year = d.getFullYear();
        return `${day} ${month} ${year}`;
    }

    /////////////////////////////////////////////////////////////////
    //                      Determine if user passed
    /////////////////////////////////////////////////////////////////
    function determinePass(score, totalQuestions) {
        // Calculate the percentage  
        const percentage = (score / totalQuestions) * 100;

        // Check if the percentage is greater than or equal to 80  
        if (percentage >= 80) {
            return "pass";
        } else {
            return "fail";
        }
    }
    /////////////////////////////////////////////////////////////////
    //                          Convert Text To Paragraph
    /////////////////////////////////////////////////////////////////
    function convertTextToParagraphs(content) {
        // Replace all occurrences of /$$**$$/ with </p><p class="m-1">
        var replacedContent = content.replace(/\/\$\$\*\*\$\$\//g, '</p><p class="my-1">');

        // Wrap the entire content in <p> tags
        replacedContent = '<p class="my-1">' + replacedContent + "</p>";

        // Capitalize the first letter that follows each opening <p> tag
        replacedContent = replacedContent.replace(/<p class="my-1">(\s*[^<])/g, function (match, p1) {
            return '<p class="my-1">' + p1.toUpperCase();
        });

        // Return the output with <p> tags and capitalized letters
        return replacedContent;
    }
    var isUserTriggeredRefresh = false;

    // Listen for a custom event to trigger refresh  
    $(window).on('beforeunload', function (event) {
        if (!isUserTriggeredRefresh) {
            // Show the confirmation dialog  
            event.preventDefault(); // Prevents the default action  
            event.returnValue = ''; // For some browsers  
        }
    });

    // Example function to simulate a user-triggered refresh  
    $(window).on('keydown', function (e) {
        if (e.key === 'r' && (e.ctrlKey || e.metaKey)) { // Ctrl + R or Command + R  
            isUserTriggeredRefresh = true; // Set the flag to true  
        }
    });
    var url = window.location.href, certificateCost = null, maxLimit, totalBtnNum, test = "", level = "", testNum, refresh = "yes", questionNum = '';

    function CourseNavNum(response) {
        var active_span = `active-success`, current_span = `shadow`, active_line = ` active-line-success`, totalBtn = ``, i = 1;
        level = response.level;
        testNum = response.testNum;
        for (i = 1; i <= response.moduleNum; i++) {
            current_span = "";

            if ("level" in response) {
                active_span = "";
                active_line = "";

                if (response.level == "c" && i == 1) {
                    current_span = "shadow";
                }
                if (response.level == i) {
                    current_span = "shadow";
                    if (i == 1) {
                        $("#previous").addClass("d-none");
                    }
                }
                if (response.level >= i || response.level == "t" || response.level == "c") {
                    active_span = `active-success`;
                    active_line = ` active-line-success`;
                    maxLimit = i;
                }
                if (response.level == response.moduleNum && response.testNum == "no") {
                    $("#next").addClass("d-none");
                }
                totalBtnNum = i;
            }
            var line = `<span class="line ` + active_line + ` span-` + (i - 1) + `"></span>`;
            if (i == 1) {
                line = '';
            }
            var navNum = line + ` <span class="progress-number border rounded-circle btn-activity ` + active_span + ` ` + current_span + `">` + i + `</span>`;
            totalBtn = totalBtn + navNum;
        }
        active_span = ``;
        if ("testNum" in response && response.testNum == 'yes') {
            totalBtnNum++;
            var temp_type = "Test";
            current_span = '';
            active_line = '';
            if (("level" in response) && (response.level == "c" || response.level == "t") && response.testNum == "yes") {
                if (response.level == "c") {
                    temp_type = "Score"
                    level = 1;
                    $("#previous").addClass("d-none");
                } else if (response.level == "t") {
                    level = totalBtnNum;
                    temp_type = "Test"
                    current_span = `shadow`;
                    $("#next").addClass("d-none");
                }
                active_line = ' active-line-success';
                active_span = `active-success`;
                test = response.level;

            }
            if (line !== "") {
                line = `<span class="line span-` + (i - 1) + ` ` + active_line + ` "></span>`;
            }
            totalBtn = totalBtn + line + ` <span class="progress-number border rounded-circle btn-activity  ` + active_span + ` ` + current_span + `">` + temp_type + `</span>`;
        }
        $("#navNum").empty().append(totalBtn);
    }
    var currentTime = 0,
        testDuration = 0, limitTime = 0, remainingTime = "";
    if (url.includes("?v=")) {
        refresh = "yes";
        var params = new URLSearchParams(window.location.search);
        var id = params.get("v");
        function fetchItems(id, currentVal, purpose) {
            var submit = true;
            $("#taketest").addClass("d-none");
            $(".d-course").addClass("d-none");
            $("#score-div").addClass("d-none");
            $("#score-loader").addClass("d-none");
            $("#test-loader").addClass("d-none");
            $("#viewcourse-loader").addClass("d-none");
            $("#test-div").addClass("d-none");
            $(".d-test").addClass("d-none");
            if (currentVal == "startTest") {
                $("#score-loader").removeClass("d-none");
                submit = false;
                setTimeout(function () {
                    $("#navNum").removeClass("d-none");
                    $("#taketest").removeClass("d-none");
                    $("#viewcourse-loader").addClass("d-none");
                    $("#score-loader").addClass("d-none");
                    $("#container-btn").removeClass("d-none");
                }, 1000);
            }
            if (submit == true) {
                if (currentVal == "test" || (level > totalBtnNum && test == "t") || purpose == "testTaken") {
                    $("#test-loader").removeClass("d-none");
                } else if ((currentVal == "score") || (level > totalBtnNum && test == "c")) {
                    $("#score-loader").removeClass("d-none");
                } else {
                    $("#viewcourse-loader").removeClass("d-none");
                }
                $.ajax({
                    url: "app/viewcourse_process.php",
                    method: "POST",
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
                    },
                    data: { id: id, currentVal: currentVal, purpose: purpose },
                    dataType: "json",
                    success: function (response) {
                        // Display the course details
                        setTimeout(function () {
                            if (response.state == "success") {
                                var videos = ``;
                                if (currentVal == "initial") {
                                    CourseNavNum(response);
                                    if (response.testStatus == "tooSoon") {
                                        $("#alertTestMessage").text("You will be able to reattempt the exam on the " + formatDateAsDDMMYY(response.nextAttemptDate));
                                        $("#reAttempt").remove();
                                    } else if (response.testStatus == "limitReached") {
                                        $("#alertTestMessage").text("You have reached the allowed number of attempt.");
                                        $("#reAttempt").remove();
                                    }
                                    if (response.level == "t") {
                                        $("#testDuration").text("You will be given " + response.duration + " minutes.")
                                    }
                                    $("#page-title").text(capitalizeFirstLetter(response.courseTitle));
                                    if (response.level == "c" || response.level == "t" || response.moduleNum == response.level) {
                                        $("#containerWithdrawal").remove();
                                    }else{
                                        $("#containerWithdrawal").removeClass("d-none");
                                    }
                                    // courseNum_test
                                    certificateCost = 0;

                                    switch (response.courseNum_test) {
                                        case 10:
                                            certificateCost = 2.5;
                                            $("#amount").text(certificateCost);
                                            break;
                                        case 20:
                                            certificateCost = 5;
                                            $("#amount").text(certificateCost);
                                            break;
                                        case 30:
                                            certificateCost = 7.5;
                                            $("#amount").text(certificateCost);
                                            break;
                                        case 40:
                                            certificateCost = 10;
                                            $("#amount").text(certificateCost);
                                            break;
                                        default:
                                            break;
                                    }
                                    $("#moduleNumber").text(response.level != "c" && response.level != "t" ? response.level : 1)
                                } else {
                                    $("#moduleNumber").text(response.moduleNum)
                                }
                                $("#module-title").text(capitalizeFirstLetter(response.module.Title));

                                $("#module-description").empty().append(convertTextToParagraphs(capitalizeFirstLetterOfPhrase(response.module.Description)));
                                for (var i = 0; i < response.videos.length; i++) {
                                    var iframe = `<div class="col-12 col-md-8 col-lg-7">
                                                    <iframe style="width:100%;height: 300px" src="`+ response.videos[i].URL + `" title="` + response.Title + `" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                                    <hr class='my-4'>  
                                                </div>`;
                                    videos = videos + iframe;
                                }
                                if (response.level == 2 && response.refundEligible == true) {
                                    updateFund(id);
                                }
                                $("#viewcourse-loader").addClass("d-none");
                                $(".d-course").removeClass("d-none");
                                $("#iframe-container").empty().append(videos);

                                if (response.refundEligible == true) {
                                    $("#withdrawal-span").empty().text("You will be refunded.")
                                } else if (response.refundEligible == false) {
                                    $("#withdrawal-span").empty().text("You won't be refunded.")
                                }
                            } else if (response.state == "startTest") {
                                $("#page-title").text(capitalizeFirstLetter(response.courseTitle));
                                if (response.level == "c" || response.level == "t") {
                                    $("#containerWithdrawal").remove();
                                }else{
                                    $("#containerWithdrawal").removeClass("d-none");
                                }
                                response.state = 'test';
                                CourseNavNum(response);
                                if (response.testStatus == "tooSoon") {
                                    $("#alertTestMessage").text("You will be able to reattempt the exam on the " + formatDateAsDDMMYY(response.nextAttemptDate));
                                    $("#reAttempt").remove();
                                } else if (response.testStatus == "limitReached") {
                                    $("#alertTestMessage").text("You have reached the allowed number of attempt.");
                                    $("#reAttempt").remove();
                                }
                                if (response.level == "t") {
                                    $("#testDuration").text("You will be given " + response.duration + " minutes.")
                                }
                                $("#viewcourse-loader").addClass("d-none");
                                $("#navNum").removeClass("d-none");
                                $("#taketest").removeClass("d-none");
                                $("#container-btn").removeClass("d-none");
                            } else if (response.state == "tooSoon") {
                                $("#alertTestMessage").text("You will be able to reattempt the exam on the " + formatDateAsDDMMYY(response.nextAttemptDate));
                                $("#reAttempt").remove();
                            } else if (response.state == "test") {
                                if (currentVal == "initial") {
                                    CourseNavNum(response)
                                }
                                $("#withdrawal-span").empty().text("You won't be refunded.")
                                currentTime = new Date(response.currentTime).getTime(); // Current time in milliseconds
                                limitTime = new Date(response.limitTime).getTime(); // Limit time in milliseconds
                                testDuration = response.duration; // Assuming this is already in milliseconds or a number
                                remainingTime = limitTime - currentTime; // Remaining time in milliseconds ;
                                var questions = ``;
                                $('#countdown').text(testDuration + ':00');

                                questionNum = response.test.length;
                                for (var i = 0; i < response.test.length; i++) {
                                    var question = `<div class="mb-4">
                                                <div class="border rounded-0 p-4">
                                                    <p class="mb-4"><span class="fw-bold">`+ response.test[i].Question_num + `.</span> <span class="displayTextAsItIs">` + capitalizeFirstLetterOfPhrase(response.test[i].Question) + `</span></p>
                                                    <p class="ms-2">
                                                        <label>
                                                            <input type="radio" name="question-`+ (i + 1) + `" value="a">
                                                            <span class="custom-radio displayTextAsItIs"></span>A. `+ response.test[i].Option_A + `
                                                        </label>

                                                        <label>
                                                            <input type="radio" name="question-`+ (i + 1) + `" value="b">
                                                            <span class="custom-radio displayTextAsItIs"></span>B. `+ response.test[i].Option_B + `
                                                        </label>

                                                        <label>
                                                            <input type="radio" name="question-`+ (i + 1) + `" value="c">
                                                            <span class="custom-radio displayTextAsItIs"></span>C. `+ response.test[i].Option_C + `
                                                        </label>

                                                        <label class="">
                                                            <input type="radio" name="question-`+ (i + 1) + `" value="d">
                                                            <span class="custom-radio displayTextAsItIs"></span>D. `+ response.test[i].Option_D + `
                                                        </label>
                                                    </p>
                                                </div>
                                            </div>`;
                                    questions = questions + question;
                                }
                                $("#test-loader").addClass("d-none");
                                $("#test-div").empty().append(questions).removeClass("d-none");
                                $(".d-test").removeClass("d-none");
                                $("#container-btn").addClass("d-none");
                                refresh = 'no';

                            } else if (response.state == "noModule") {
                                alert("Sorry, this module was not found. Try again. If you believe it's an error, report it to the support team.")
                            } else if (response.state == "score") {
                                // Handle score(show it)
                                var scores = ``;
                                var highestScore = 0;
                                for (var i = 0; i < response.scores.length; i++) {
                                    var score = `<div class="d-flex justify-content-between">
                                            <div class="me-2">`+ response.scores[i].attempt + `.</div>
                                            <div class="fs-semibold me-2">`+ calculatePercentage(response.scores[i].score, response.total_questions) + `</div>
                                            <div class="text-muted">`+ formatDate(new Date(response.scores[i].date)) + `</div>
                                            <button class=" btn btn-outline-success rounded-0 review p-2" data-num="`+ response.scores[i].attempt + `">Review</button>
                                        </div>
                                        <hr>`;
                                    if (Number(response.scores[i].score) > highestScore) {
                                        highestScore = response.scores[i].score;
                                    }
                                    scores = scores + score;
                                }
                                // score-elements
                                $("#score-elements").empty().append(scores);
                                $("#score-loader").addClass("d-none");
                                $("#navNum").removeClass("d-none");
                                $("#score-div").removeClass("d-none");
                                $("#container-btn").removeClass("d-none");
                                if (response.scores.length >= 3) {
                                    $("#reAttempt").addClass("d-none");
                                }
                                if (response.testStatus == "tooSoon") {
                                    $("#alertTestMessage").text("You will be able to reattempt the exam on the " + formatDateAsDDMMYY(response.nextAttemptDate));
                                    $("#reAttempt").remove();
                                } else if (response.testStatus == "limitReached") {
                                    $("#alertTestMessage").text("You have reached the allowed number of attempt.");
                                    $("#reAttempt").remove();
                                }
                                if (determinePass(highestScore, response.total_questions) == "pass") {
                                    if (response.courseType == "free") {
                                        if (response.is_bought == true) {
                                            $("#downloadCertificate").removeClass("d-none");
                                        } else {
                                            $("#buyCertificate").removeClass("d-none").attr("href", "buynow.php?cc=" + id);
                                        }
                                    } else {
                                        $("#downloadCertificate").removeClass("d-none");
                                    }
                                    $("#alertTestMessage").text("Congratulations! You validated this course.");
                                    $("#reAttempt").addClass("d-none");
                                } else {
                                    $("#downloadCertificate").addClass("d-none");
                                    $("#reAttempt").removeClass("d-none");
                                }
                            } else if (response.state == "noTest") {
                                alert("This course don't have a test.");
                            } else if (response.state == "review") {
                                $(".d-test").addClass("d-none");
                                $("#navNum").removeClass("d-none");
                                var questions = ``, message = ``, bg = '', svg = '';
                                // 
                                var stat = `<button class="btn btn-outline-success rounded-0 mb-3" id="backReview">Back to Score</button> <div class="mb-3 d-flex">
                                        <p class="p-0 my-1 me-4"><span class="fw-bold">Score:</span> `+ calculatePercentage(response.scores.score, response.total_questions) + `</p>
                                        <p class="p-0 my-1 me-4"> <span class="fw-bold">Date taken:</span> `+ formatDate(new Date(response.scores.date)) + `</p>
                                        <p class="p-0 my-1"> <span class="fw-bold">Total questions:</span> `+ response.total_questions + `</p>
                                    </div>`;
                                for (var i = 0; i < response.questions.length; i++) {
                                    var A = ``, B = ``, C = ``, D = ``, svg_a = ``, svg_b = ``, svg_c = '', svg_d = '', svg_div = '';
                                    //response.questions[i].user_answer == response.questions[i].correct_answer answerIs
                                    if (response.questions[i].answerIs == "correct") {
                                        message = "You had it right!";
                                        bg = " bg-custom-success";
                                        svg = `<svg class="ms-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="green" version="1.1" id="Capa_1" width="18px" height="18px" viewBox="0 0 31.963 31.963" xml:space="preserve">
                                                <g>
                                                    <path d="M31.453,9.17c0.372-0.439,0.554-1.011,0.501-1.585c-0.055-0.574-0.338-1.102-0.785-1.466l-3.811-3.084   c-0.92-0.744-2.27-0.602-3.014,0.317L12.675,17.773l-5.536-4.667c-1.054-0.889-2.61-0.822-3.585,0.151l-2.927,2.926   c-0.421,0.421-0.647,0.999-0.626,1.594c0.022,0.596,0.291,1.152,0.742,1.542l11.108,9.565c0.432,0.373,0.994,0.558,1.562,0.513   c0.568-0.044,1.096-0.312,1.465-0.747L31.453,9.17z"/>
                                                </g>
                                            </svg>`;
                                    } else {
                                        message = `Oops! You had it wrong.`;
                                        bg = " bg-custom-danger";
                                        svg = `<svg xmlns="http://www.w3.org/2000/svg" fill="red" width="25px" height="25px" viewBox="0 0 32 32">
                                                <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5  c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4  C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"/>
                                            </svg>`;
                                    }
                                    if (response.questions[i].user_answer == "a") {
                                        A = "checked";
                                        svg_a = svg
                                    } else if (response.questions[i].user_answer == "b") {
                                        B = "checked";
                                        svg_b = svg
                                    } else if (response.questions[i].user_answer == "c") {
                                        C = "checked";
                                        svg_c = svg
                                    } else if (response.questions[i].user_answer == "d") {
                                        D = "checked";
                                        svg_d = svg
                                    } else {
                                        svg_div = svg;
                                    }
                                    var question = `<div class="mb-4">
                                                <div class="border rounded-0 p-4">
                                                    <p class="mb-4"><span class="fw-bold">`+ response.questions[i].question_num + `.</span> <span class="displayTextAsItIs">` + capitalizeFirstLetterOfPhrase(response.questions[i].question) + `</span>` + svg_div + `</p>
                                                    <p class="ms-2">
                                                        <label class="input-radio-disabled">
                                                            <input type="radio" name="viewquestions-`+ (i + 1) + `"  value="a" ` + A + `>
                                                            <span class="custom-radio"></span>A. <span class="displayTextAsItIs">`+ response.questions[i].option_a + `</span>
                                                            `+ svg_a + `
                                                        </label>

                                                        <label class="input-radio-disabled">
                                                            <input type="radio" name="viewquestions-`+ (i + 1) + `" value="b" ` + B + `>
                                                            <span class="custom-radio"></span>B. <span class="displayTextAsItIs">`+ response.questions[i].option_b + `</span>
                                                            `+ svg_b + `
                                                        </label>

                                                        <label class="input-radio-disabled">
                                                            <input type="radio" name="viewquestions-`+ (i + 1) + `" value="c" ` + C + `>
                                                            <span class="custom-radio"></span>C. <span class="displayTextAsItIs">`+ response.questions[i].option_c + `</span>
                                                            `+ svg_c + `
                                                        </label>

                                                        <label class="input-radio-disabled">
                                                            <input type="radio" name="viewquestions-`+ (i + 1) + `" value="d" ` + D + `>
                                                            <span class="custom-radio "></span>D. <span class="displayTextAsItIs">`+ response.questions[i].option_d + `</span>
                                                            `+ svg_d + `
                                                        </label>
                                                    </p>
                                                </div>
                                            <div class="rounded-0 p-4 text-white `+ bg + `">
                                                `+ message + `
                                            </div>
                                            </div>`;
                                    questions = questions + question;
                                }
                                questions = stat + questions;

                                $("#test-loader").addClass("d-none");
                                $("#test-div").empty().append(questions).removeClass("d-none");
                                $(".d-test").addClass("d-none");
                                $("#container-btn").removeClass("d-none");
                            } else if (response.state == "noScore") {
                                if (currentVal == "initial") {
                                    CourseNavNum(response)
                                }
                            } else if (response.state == "error") {
                                alert("Ops! An error occurred. Please try again.");
                            } else if (response.state == "userOwnsCourse") {
                                refresh = 'yes';
                                alert("You can not register for a course that belongs to you. You will be redirected to the course page.");
                                window.location.href = "courses.php";
                            } else if (response.state == "tooSoon") {
                                refresh = 'yes';
                                alert("You have to wait before re-attempting. The page will be reloaded.");
                                window.location.reload;
                            } else if (response.state == "notRegistered") {
                                refresh = 'yes';
                                alert("You have not register for this course. You will be redirected to the course.");
                                window.location.href = "displaycourse.php?v=" + id;
                            } else if (response.state == "noCourse") {
                                // 
                                refresh = 'yes';
                                alert("This course wasn't found. You will be redirected.");
                                window.location.href = "courses.php";
                            }

                        }, 1000);
                    },
                });
            }
        }
        ////////////////////////////////////////////////////////// 
        //  When they click on any of the navigation buttons 
        $("#navNum").on("click", ".active-success", function () {
            $(".active-success").removeClass("shadow");
            $(this).addClass("shadow");
            var num = $(this).text().trim().toLowerCase();
            $("#previous").removeClass("d-none");
            $("#next").removeClass("d-none");
            // If it's on the number buttons(eg. 1, 2, 3, etc)
            if (num != "test" && num != "score" && !isNaN(num) && isFinite(num)) {
                level = num;
                fetchItems(id, num, "viewCourse");
                if (level == 1) {
                    $("#previous").addClass("d-none");
                    $("#next").removeClass("d-none");
                } else if (level == totalBtnNum && testNum != "yes") {

                    $("#previous").removeClass("d-none");
                    $("#next").addClass("d-none");
                } else if (test == "" && (level == "c" || level == "t")) {
                    $("#next").addClass("d-none");
                    $("#previous").removeClass("d-none");
                }
            } else if (num == "test") {
                // If it's on the test button
                level = totalBtnNum;
                fetchItems(id, "startTest", "viewCourse");
                $("#next").addClass("d-none");
                $("#previous").removeClass("d-none");
            } else if (num == "score") {
                // If it's on the score button
                level = totalBtnNum;
                fetchItems(id, "score", "score");
                $("#previous").removeClass("d-none");
                $("#next").addClass("d-none");
            }
        });

        // Initial call on page load
        fetchItems(id, "initial", "viewCourse");


        ////////////////////////////////////////////////////////// 
        //  When they click the next button
        $("#next").click(function () {
            // Check if the element exists and retrieve its text  
            if ($("#navNum .active-success.shadow").length) {
                var containerTop = $(".pt-navbar").offset().top;
                $("html, body").scrollTop(containerTop);
                $("#navNum .btn-activity").removeClass("shadow")
                var elements = $("#navNum .active-success");
                var shadowText = level, temp_num = totalBtnNum, condition = "";
                if (shadowText <= totalBtnNum || shadowText == "t") {
                    // shadowText is a number
                    ++shadowText;
                    ++level;
                    // Check if there is test for this course
                    if (testNum == "yes" && (shadowText) >= totalBtnNum) {
                        condition = "d";
                    }
                    // alert(condition+"                "+shadowText+"            "+totalBtnNum)
                    if ((shadowText !== "t") && !isNaN(shadowText) && isFinite(shadowText) && (shadowText <= totalBtnNum) && condition == "") {
                        $("#navNum .btn-activity").each(function () {
                            if (shadowText == $(this).text().toLowerCase().trim()) {
                                $(this).addClass("shadow");
                                if (!$(this).hasClass("active-success")) {
                                    $(this).addClass("active-success");
                                    $(".span-" + (shadowText - 1)).addClass("active-line-success");
                                    fetchItems(id, shadowText, "viewCourse");
                                    fetchItems(id, shadowText, "update");
                                } else {
                                    fetchItems(id, shadowText, "viewCourse");
                                };
                            }
                        })
                    } else if ((shadowText >= totalBtnNum && testNum == "yes") || (shadowText == "t") || (shadowText == "c") || (testNum == "yes")) {
                        elements.removeClass("shadow");
                        $("#navNum .btn-activity").each(function () {
                            var temp_text = $(this).text().trim().toLowerCase(); // Get the text  
                            if (temp_text == "test" || temp_text == "score") {
                                shadowText = totalBtnNum;
                                level = totalBtnNum;
                                // Add shadow and active-success to the active button
                                $(this).addClass("shadow active-success");
                                $(".span-" + (totalBtnNum - 1)).addClass("active-line-success");
                                if (temp_text == "score") {
                                    fetchItems(id, temp_text, "score");
                                } else {
                                    fetchItems(id, "test", "update");
                                    fetchItems(id, "startTest", "viewCourse");
                                }
                            }
                        });
                        $("#next").addClass("d-none");
                    }
                    $("#previous").removeClass("d-none");
                }
                if (shadowText <= 1) {
                    $("#next").addClass("d-none");
                }
                if (level >= totalBtnNum && testNum == "no") {
                    $("#next").addClass("d-none");
                }
            }
        });

        ////////////////////////////////////////////////////////// 
        //  When they click the previous button
        $("#previous").click(function () {
            if ($("#navNum .btn-activity.shadow").length) {
                var containerTop = $(".pt-navbar").offset().top;
                $("html, body").scrollTop(containerTop);
                $("#navNum .btn-activity").removeClass("shadow")
                var elements = $("#navNum .btn-activity");
                var shadowText = level;
                // Check if the button is within the range of buttons
                if (shadowText > 1 || shadowText == "c" || shadowText == "t") {
                    // shadowText is a number(button is a number)
                    if ((shadowText !== "t" || shadowText !== "c") && !isNaN(shadowText) && isFinite(shadowText)) {
                        $(this).addClass("shadow active-success");
                        shadowText--;
                        level--;
                        fetchItems(id, shadowText, "viewCourse");
                    } else if (shadowText == "t" || shadowText == "c") {
                        // shadowText is a number(button is either test or score)
                        elements.each(function () {
                            var temp_text = $(this).text().trim().toLowerCase(); // Get the text  
                            if (temp_text == "test" || temp_text == "score") {
                                shadowText = totalBtnNum - 1;
                                level = totalBtnNum - 1;
                                $(this).removeClass("shadow");
                            }
                            if (maxLimit == $(this).text().trim().toLowerCase()) {
                                $(this).addClass("shadow");
                            }
                        });
                        if (test == 't') {
                            shadowText = "test"
                            fetchItems(id, "startTest", "viewCourse");
                        } else if (test == 'c') {
                            shadowText = "score"
                            fetchItems(id, shadowText, "viewCourse");
                        }
                    }

                    // Add shadow to the active button
                    $("#navNum .btn-activity").each(function () {
                        if (shadowText == $(this).text().toLowerCase().trim()) {
                            $(this).addClass("shadow");
                        } else if (shadowText == "t" || shadowText == "c") {
                            $(this).addClass("shadow");
                        }
                    })
                    $("#next").removeClass("d-none");
                }
                if (shadowText <= 1) {
                    $("#previous").addClass("d-none");
                }

            }
        });
        // To attempt the exam again
        $("#reAttempt").click(function () {
            test = 't';
            fetchItems(id, "test", "viewCourse");
        })
        /////////////////////////////////////////////////////////////////////////
        //                       Update countdown Function
        /////////////////////////////////////////////////////////////////////////
        function updateCountdown() {
            if (remainingTime === 0) {
                // Time's up, submit the form  
                var temp_answer = verifyAnswers(questionNum);
                submitAnswers(id, temp_answer);
                var minutes = Math.floor((remainingTime / 1000) / 60);
                var seconds = Math.floor((remainingTime / 1000) % 60);

                // Format time to always show two digits  
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                // Update the countdown display  
                $('#countdown').text(minutes + ':' + seconds);

                // Decrease remaining time by 1000 milliseconds (1 second)  
                remainingTime -= 1000;
            } else if (remainingTime > 0) {
                // Calculate minutes and seconds  
                var minutes = Math.floor((remainingTime / 1000) / 60);
                var seconds = Math.floor((remainingTime / 1000) % 60);

                // Format time to always show two digits  
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                // Update the countdown display  
                $('#countdown').text(minutes + ':' + seconds);

                // Decrease remaining time by 1000 milliseconds (1 second)  
                remainingTime -= 1000;
            }
        }

        // Update countdown every second  
        setInterval(updateCountdown, 1000);

        // Prevent default refresh action  
        let confirmRefresh = false;

        $(window).on('beforeunload', function (e) {
            if (refresh == "no") {
                e.preventDefault();
                e.returnValue = ''; // For older browsers  
            }
        });

        // Detect Ctrl + R  
        $(window).on('keydown', function (e) {
            if (e.ctrlKey && e.key === 'r') { // Check for Ctrl + R  
                if (refresh == "no") {
                    e.preventDefault(); // Prevent the default refresh action  
                    if (confirm("Are you sure you want to refresh the page?")) {
                        confirmRefresh = true; // Set flag to allow the refresh  
                        location.reload(); // Refresh the page  
                    }
                } else {
                    location.reload(); // Refresh the page  
                }
            }
        });

        $("#score-div").on("click", ".review", function () {
            var attempt_num = $(this).data("num");
            fetchItems(id, attempt_num, "testTaken");
        })

        $("#test-div").on("click", "#backReview", function () {
            fetchItems(id, "score", "score");
        })
        // Start the exam
        $("#startExam").click(function () {
            fetchItems(id, "test", "viewCourse");
            $("#previous").addClass("d-none");
        })

        var answers = [];
        // Function to verify answers
        function verifyAnswers(questionNum) {
            if (questionNum !== "") {
                var verificationHtml = '';

                // Loop through each question
                for (var i = 1; i <= questionNum; i++) {
                    // Get the selected answer for the current question
                    var selectedAnswer = $('input[name="question-' + i + '"]:checked').val();

                    // Check if the question is answered or not
                    if (selectedAnswer) {
                        // If answered, show "Answered"
                        verificationHtml += `<div> <span class="me-4">${i}.</span> <span class="ms-5">Answered</span> </div><hr>`;
                    } else {
                        // If not answered, show "Not Answered"
                        verificationHtml += `<div> <span class="me-4">${i}.</span> <span class="ms-5 text-danger">Not Answered</span> </div><hr>`;
                    }

                    // Store the answer or 'N' for no answer
                    answers.push(selectedAnswer ? selectedAnswer : 'n');
                }

                // Append the verificationHtml to the modal content
                $('#verify .modal-body').html(verificationHtml);
                return answers; // Return the answers array
            } else {
                alert("Ops! An error occurred. Please try again!");
                return null; // Return null if an error occurred
            }
        }

        // Function to submit answers via AJAX
        function submitAnswers(id, answers_values) {

            $.ajax({
                url: "app/viewcourse_process.php",
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
                },
                data: { course_id: id, answers: answers_values, purpose: "testAnswered" },
                dataType: "json",
                success: function (response) {
                    // Handle the response from the server
                    if (response.state === "success") {
                        $("#navNum .btn-activity").each(function () {
                            if ($(this).text().trim().toLowerCase() === "test") {
                                $(this).text("Score");
                            }
                        });
                        $("#verifyAnswer").addClass("d-none");
                        $(".d-test").addClass("d-none");
                        $("#test-div").addClass("d-none");
                        test = "c";
                        level = "c";
                        fetchItems(id, response.attempt_num, "testTaken");

                    }
                }
            });
        }

        // Event handler for verifying test answers
        $('#verifyAnswer').on('click', function () {
            // Call the verifyAnswers function and store the result
            answers = verifyAnswers(questionNum);
            // Show the modal
            $('#verify').modal('show');
        });

        // Event handler for submitting answers
        $("#submit").click(function () {
            submitAnswers(id, answers);
        });


        ////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////
        ////////////        Download Certificate        ////////////////
        ////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////

        async function generatePDF(data) {
            const { jsPDF } = window.jspdf;

            // Create a new jsPDF instance (Landscape mode)
            const pdf = new jsPDF({
                orientation: "landscape",
                unit: "px",
                format: [1000, 700] // Match certificate dimensions
            });
            // certificate_expired_Date
            // Get certificate details
            const name = data.studentName;
            const courseTitle = data.CourseTitle;
            const instructorName = data.InstructorName;
            const certificateDate = new Date(data.CertificateDate).toLocaleDateString();
            const certificateCode = data.CertificateCode;
            const certificateExpiredDate = new Date(data.certificate_expired_Date).toLocaleDateString();
            // Add a border
            // pdf.setLineWidth(3);
            // pdf.setDrawColor(40, 167, 69); // Green border
            // pdf.rect(20, 20, 960, 660); // x, y, width, height
            // Set outer border
            pdf.setLineWidth(5); // Thickness of the outer border
            pdf.setDrawColor(40, 167, 69); // Green color
            pdf.rect(20, 20, 960, 660); // Outer rectangle (x, y, width, height)

            // Set inner border
            pdf.setLineWidth(2); // Thickness of the inner border
            pdf.setDrawColor(0, 0, 0); // Black color
            pdf.rect(30, 30, 940, 640); // Inner rectangle (slightly smaller)

            // Add the logo image and center it
            const logo = 'image/logo.png';
            pdf.addImage(logo, "PNG", 390, 70, 40, 40); // Adjust x, y, width, height for centering
            // pdf.addImage(logo, "PNG", 440, 480, 115, 115); // Adjust x, y, width, height for centering

            // Add "TRAINMASTAS" text below the logo, centered
            pdf.setFont("Varela Round", "bold");
            pdf.setFontSize(27);
            pdf.setTextColor(40, 167, 69); // Green color for TRAINMASTAS
            pdf.text("TRAINMASTAS", 510, 100, null, null, 'center'); // Centered at the top

            // Add the student name in bold
            pdf.setFontSize(50);
            pdf.setFont("Georgia", "bold"); // Bold font
            pdf.setTextColor(40, 175, 69); // Green color
            pdf.text(name, 500, 180, null, null, 'center'); // Centered name

            // Add additional text content
            pdf.setFont("Georgia", "normal"); // Normal font for body text
            pdf.setFontSize(23);
            pdf.setTextColor(0, 0, 0); // Default black color
            pdf.text("is hereby awarded this certificate of accomplishment for successfully completing the course", 500, 240, null, null, 'center');
            pdf.setFontSize(22);
            pdf.setFont("Georgia", "bold"); // Bold font
            pdf.text(courseTitle, 500, 290, null, null, 'center');
            pdf.setFontSize(22);
            pdf.setFont("Georgia", "normal"); // Normal font for body text
            pdf.text("under the guidance of", 500, 335, null, null, 'center');
            pdf.setFontSize(22);
            pdf.setFont("Georgia", "bold"); // Normal font for body text
            pdf.text(instructorName, 500, 375, null, null, 'center');
            pdf.setFontSize(18);
            pdf.setFont("Georgia", "normal"); // Normal font for body text
            pdf.text("Date of Completion:", 500, 415, null, null, 'center');
            pdf.setFontSize(22);
            pdf.setFont("Georgia", "bold"); // Normal font for body text
            pdf.text(certificateDate, 500, 455, null, null, 'center');
            pdf.setFontSize(18);
            pdf.setFont("Georgia", "normal"); // Normal font for body text
            pdf.text("Expiring Date:", 500, 495, null, null, 'center');
            pdf.setFontSize(22);
            pdf.setFont("Georgia", "bold"); // Normal font for body text
            pdf.text(certificateExpiredDate, 500, 535, null, null, 'center');
            // 
            pdf.setFont("Georgia", "normal"); // Normal font for body text

            // Add the signature image
            const signature = "image/signature.png";
            pdf.addImage(signature, "PNG", 730, 570, 200, 60); // Adjust x, y, width, height as needed

            // Add the President's name in bold and larger size
            pdf.setFont("Georgia", "bold"); // Bold font
            pdf.setFontSize(20); // Larger size
            pdf.text("CEO - NGOUPAYOU HABIL SALIM", 700, 640);
            pdf.line(700, 620, 950, 620);

            // Add verification code
            pdf.setFont("Georgia", "normal"); // Normal font
            pdf.setFontSize(16);
            pdf.text("Verification Code: " + certificateCode, 60, 620);
            pdf.setFontSize(14.5);
            pdf.text("To verify this certificate, visit: https://verify.trainmastas.com", 60, 640);

            // Open PDF in the current window
            const pdfBlob = pdf.output('blob'); // Get PDF as a blob
            const pdfUrl = URL.createObjectURL(pdfBlob); // Create a URL for the blob
            window.open(pdfUrl, "blank"); // Open in the current window
        }

        function fetchDownload(id) {
            $.ajax({
                url: "app/course_process.php",
                method: "POST",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
                },
                data: {
                    purpose: "certificate",
                    course_ID: id
                },
                dataType: "json",
                success: function (response) {
                    if (response.state === "success") {
                        generatePDF(response.Detail);
                    } else if (response.state === "Invalid") {
                        alert(response.message);
                    } else if (response.state === "error") {
                        alert(response.message);
                    } else {
                        alert("Failed to fetch certificate details. Try again later. Contact the support team if it persist.");
                    };
                }
            });
        }
        // Simulating AJAX call success response
        $("#downloadCertificate").click(function () {
            if (id) {
                fetchDownload(id);
            }
        })
    } else {
        refresh = 'yes';
        window.location.href = "courses.php";
    }


    $("#buyCertificate_bnt").on("click", function () {
        $(this).prop("disabled", true);
        $.ajax({
            url: "app/displaycourse_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            data: { course_ID: id, purpose: "buy_certificate" },
            dataType: "json",
            success: function (response) {
                setTimeout(function () {
                    if (response.state === "success") {
                        $("#buyModal").modal("hide");
                        $("#buyCertificate").addClass("d-none");
                        $("#downloadCertificate").removeClass("d-none");
                        var temp_balance = parseFloat($(".userBalance").text().trim().replace("$", ""));
                        var new_balance = temp_balance - parseFloat(certificateCost);
                        $(".userBalance").text("$" + new_balance.toFixed(2)); // Optionally format to 2 decimal places  
                        alert("Successfully bought this course certificate. The certificate will be loaded.");

                        fetchDownload(id);
                    } else if (response.state === "recharge") {
                        $("#buyCertificate_bnt").prop("disabled", false);
                        $("#buyModal").modal("hide");
                        $("#rechargeModal").modal("show");
                    } else {
                        $("#buyModal").modal("hide");
                        setTimeout(function () {
                            alert(response.message);
                        }, 50);
                        $("#buyCertificate_bnt").prop("disabled", false);
                    }
                }, 1000);
            },
        });
    })

    $("#withdraw").on("click", function () {
        $(this).prop("disabled", true);
        $.ajax({
            url: "app/displaycourse_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            data: { course_ID: id, purpose: "withdraw_course" },
            dataType: "json",
            success: function (response) {
                setTimeout(function () {
                    if (response.state === "success") {
                        $("#withdrawModal").modal("hide");
                        $("#withdraw").addClass("d-none");
                        setTimeout(function () {
                            refresh = 'yes';
                            alert("You successfully withdrawn from this course. You will be redirected to your dashboard.");
                            window.location.href = "dashboard.php";
                        }, 50);
                    } else {
                        $("#withdrawModal").modal("hide");
                        setTimeout(function () {
                            alert(response.message);
                        }, 50);
                        $("#buyCertificate_bnt").prop("disabled", false);
                    }
                }, 1000);
            },
        });
    })
});