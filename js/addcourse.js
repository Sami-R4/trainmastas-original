$(document).ready(function () {
    $.ajax({
        url: "app/addcourse_process.php",
        method: "POST",
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
        },
        data: { purpose: "checkUser" },
        dataType: "json",
        success: function (response) {
            if (response.state !== "creator") {
                alert("You don't have access to this page. You will be redirected.")
                window.location.href = "index.php";
            } else if (response.state == "creator" && (response.verified === null || response.verified == 0)) {
                alert("You are not a verified course creator. You will be redirected.")
                window.location.href = "dashboard.php";
            } else {
                // Remove the loader
                setTimeout(function () {
                    $("#fullScreenLoader").addClass("d-none");
                    $("#main").removeClass("d-none");
                }, 1000);
                var temp = response.courseProduced;
                if (temp < 5) {
                    $("#type option[value='premium']").prop("disabled", true).addClass("premium-message");
                    $('#type-span').text('Premium option was disabled. You must have at least 5 free courses').show();
                }
            }
        }
    });
    var course_ID_to_send = "", submitted_date = null, course_response = "", temp_cover = "", sendDetail = false, checkCourseDetail = {}, haveTest = false;

    // Validate and collect module data
    let previousModuleData = [];
    let previousCourseData = {}; // Object to store previous values
    let previousTestData = []; // Store previous test data for duplicate checking
    $("#type").change(function () {  // Use change event on the select element  
        var selectedOption = $(this).find("option[value='free']");

        if (selectedOption.is(':selected') && selectedOption.hasClass("premium-message")) {
            $('#type-span').text('').hide();
        }
    });

    /////////////////////////////////////////////////////////////////
    //                          Replace with enter space /$$**$$/
    /////////////////////////////////////////////////////////////////
    function replacePatternWithEnterSpace(content) {
        // Replace all occurrences of /$$**$$/ with an enter space
        var replacedContent = content.replace(/\/\$\$\*\*\$\$\//g, "\n");

        // Remove any space before or after \n
        replacedContent = replacedContent.replace(/\s*\n\s*/g, "\n");

        // Capitalize the letter that follows the newline character
        replacedContent = replacedContent.replace(/\n([a-z])/g, function (match, p1) {
            return "\n" + p1.toUpperCase();
        });

        // Return the output with an enter space and capitalized letter
        return replacedContent;
    }

    /////////////////////////////////////////////////////////////////
    // Replace all occurrences of newline characters with /$$**$$/
    /////////////////////////////////////////////////////////////////
    function replaceNewlineWithPattern(content) {
        // Replace single newlines with /$$**$$/ and handle spaces around it
        var replacedContent = content
            .replace(/\r\n|\n|\r/g, "/$$$**$$$/") // Escape dollar signs and asterisks
            .replace(/\s*\\\/\\$\\$\\*\\*\\$\\$\s*/g, "/$$$**$$$/"); // Escape dollar signs and asterisks

        // Return the modified content
        return replacedContent;
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
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    // Fetch The Stored Course
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    const urlParams = new URLSearchParams(window.location.search);
    const cValue = urlParams.get('c');
    var checkTestNum = false, canDelete = false;
    if (cValue) {
        course_ID_to_send = cValue;

        // Send the cValue to the backend using AJAX
        $.ajax({
            url: "app/addcourse_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            data: { course_ID: cValue, purpose: "sendthis" },
            dataType: "json",
            success: function (response) {
                setTimeout(function () {
                    if (response.state == "success") {
                        $("#main-body").css("display","block");
                        course_response = response;
                        // Set course details
                        // checkCourseDetail = createCourseObject(response.course);
                        $('#title').val(capitalizeFirstLetter(response.course.Title));
                        $('#description').val(capitalizeFirstLetterOfPhrase(replacePatternWithEnterSpace(response.course.Description)));
                        document.title = "Editing - " + capitalizeFirstLetter(response.course.Title);
                        submitted_date = response.course.submitted_date;
                        // Set cover image preview
                        var imageUrl = response.course.Cover_image ? "covers/" + response.course.Cover_image : "image/default-cover.jpg";
                        $('#cover-image').attr('src', imageUrl).removeClass("d-none");
                        // Remove full stop at the end
                        function modifyString(text) {
                            if (text.length > 0 && /[a-zA-Z0-9]$/.test(text) && text.charAt(text.length - 1) !== '.') {
                                text += '.'; // Append a full stop  
                            }
                            return text; // Return the modified string  
                        }
                        // Populate category dropdown
                        $('#category').val(response.course.Category).trigger('change');
                        if (response.rejected != null) {
                            // $("#rejection-message").removeClass("d-none").text("This course was rejected due to the following reason: \n\n" + modifyString(response.rejected) + "  \n \nIf you think this was a mistake, contact the support team at support@trainmastas.com");
                            $("#rejection-message").removeClass("d-none").html(
                                'This course was rejected due to the following reason:<p class="my-2">"' +
                                modifyString(response.rejected) +
                                '"</p>If you think this was a mistake, contact the support team at support@trainmastas.com'
                            ); $('#rejectionModal').modal('show');
                        }
                        // Populate keys (areas covered)
                        var keysSelect = $('#keys');

                        for (var j = 0; j < response.scopes.length; j++) {
                            var key = response.scopes[j].Scope;
                            if (key && key !== "") {
                                if ($(keysSelect).find("option[value='" + key + "']").length) {
                                    $(keysSelect)
                                        .val($(keysSelect).val().concat(key))
                                        .trigger("change");
                                } else {
                                    var newOption = new Option(
                                        capitalizeFirstLetterOfPhrase(key),
                                        capitalizeFirstLetterOfPhrase(key),
                                        true,
                                        true
                                    );
                                    $(keysSelect).append(newOption).trigger("change");
                                }
                            }
                        }

                        // Set modules number
                        $('#modulesNum').val(response.course.Num_modules).trigger('change').addClass("disabled-select").prop("disabled", true);
                        // Set test question type
                        $('input[name="testQuestion"][value="' + (response.course.Num_test == 0 ? 'no' : 'yes') + '"]').prop('checked', true);

                        // Handle visibility of the test number container based on the presence of tests
                        if (response.course.Num_test == 0) {
                            $('#testNumContainer').hide();
                            if (response.total_registered > 0) {
                                checkTestNum = true;
                                $('#testNum').val(response.course.Num_test).trigger('change').prop("disabled", true).addClass("disabled-select");
                                $('input[name="testQuestion"]').prop("disabled", true).addClass("disabled-select");
                            }
                            $("#nextSaveModule").text("Submit");
                        } else {
                            // To determine if it have test
                            haveTest = true;
                            checkTestNum = true;
                            $('#testNumContainer').show();
                            $('#testNum').val(response.course.Num_test).trigger('change').prop("disabled", true).addClass("disabled-select");
                            $('input[name="testQuestion"]').prop("disabled", true).addClass("disabled-select");
                        }
                        temp_cover = response.course.Cover_image;

                        // Set course cost and determine if it's free or premium
                        var cost = response.course.Cost;
                        if (cost == 0) {
                            // If cost is not a number, it's free
                            $('#type').val('free').trigger('change');
                            $('#price-div').addClass('d-none');
                        } else {
                            // If cost is a number, it's premium
                            $('#type').val('premium').trigger('change');
                            $('#price').val(formatPrice(cost));
                            $('#price-div').removeClass('d-none');
                        }
                        if (response.freeCount < 5 && cost != 0) {
                            $('#type').val('free').trigger('change');
                            $('#price').val(formatPrice(0));
                            $('#type option[value="premium"]').remove();
                            $("#type").select2({
                                placeholder: "Select course type",
                                width: '100%',
                                minimumResultsForSearch: Infinity // Hides the search box
                            });
                        }
                        previousCourseData = structureCourseDetails(response.course, response.scopes);
                        previousCourseData.cover = response.course.Cover_image;
                        previousModuleData = structureCourseData(response.modules, response.videos);
                        previousTestData = structureTestData(response.tests);
                        console.log(previousModuleData);
                        $("#deleteContainer").removeClass("d-none");
                        if (response.total_registered == 0) {
                            $("#delete").removeClass("disabled");
                            canDelete = true;
                        } else {
                            $("#delete").addClass("disabled");
                            $("#deleteModal").remove();
                            canDelete = false;
                        }

                        $("#fullScreenLoader").addClass("d-none");
                        $("#main").removeClass("d-none");
                        sendDetail = false;
                        if (window.$select) {
                            sortSelectedOptions2(window.$select); // Calling the function from the external file
                        }
                    } else if (response.state == "cant") {
                        alert("Opps! This course currently has active users enrolled. As a result, modifications cannot be made at this time. Please try again later.")
                        window.location.href = "dashboard.php";
                    } else {
                        alert("Sorry! You do not have access to this course or it was not found. Contact the support team if you think it is an error.")
                        window.location.href = "dashboard.php";
                    }
                }, 800);

            },
        });
    }
    // sortSelectOptions.js
    function sortSelectedOptions2(selectElement) {
        // Get selected options as an array and sort them
        var selectedOptions = selectElement.find('option:selected').sort(function (a, b) {
            return a.text.localeCompare(b.text);
        });

        // Clear the select options and re-add them in sorted order
        selectedOptions.each(function () {
            var $option = $(this).detach();
            selectElement.append($option);
        });

        // Refresh the select2 display
        selectElement.trigger('change');
    }

    //////////////////////////////////////////////////////////////////
    //////////////     Structure Course Details Data     ////////////////////
    /////////////////////////////////////////////////////////////////
    function structureCourseDetails(courseData, scope) {
        return {
            title: courseData.Title,
            description: courseData.Description,
            cover: courseData.Cover_image,
            keys: scope.map(scopeItem => scopeItem.Scope), // Change here to directly push the scope as an array  
            // keys: scope.map(scopeItem => scopeItem.Scope).join(','),
            type: courseData.Cost,
            category: courseData.Category,
            modulesNum: courseData.Num_modules,
            testQuestion: courseData.Num_test === "0" ? "no" : "yes",
            testNum: courseData.Num_test,
            price: Number(courseData.Cost),
            type: Number(courseData.Cost) == 0 ? "free" : 'premium'
        };
    }

    //////////////////////////////////////////////////////////////////
    //////////////     Structure Modules Data     ////////////////////
    /////////////////////////////////////////////////////////////////
    function structureCourseData(modules, videos) {
        let structuredData = [];
        modules.forEach(module => {
            // Filter videos related to the current module
            let moduleVideos = videos.filter(video => video.Module_num == module.Module_num);

            // Prepare module data with dynamic keys
            let moduleData = {
                [`description-${module.Module_num}`]: module.Description,
                [`title-${module.Module_num}`]: module.Title,
                ["moduleNum"]: module.Module_num,
                [`moduleExtras-${module.Module_num}`]: {}
            };

            // Organize video data
            moduleVideos.forEach(video => {
                moduleData[`moduleExtras-${module.Module_num}`][`extra-${video.Video_num}`] = [
                    { name: "url", value: video.URL }
                ];
            });

            structuredData.push(moduleData);
        });
        return structuredData;
    }


    //////////////////////////////////////////////////////////////////
    //////////////       Structure Test Data      ////////////////////
    /////////////////////////////////////////////////////////////////
    function structureTestData(questions) {
        return questions.map(question => ({
            question_num: question.Question_num,
            question: question.Question,
            options: {
                a: question.Option_A,
                b: question.Option_B,
                c: question.Option_C,
                d: question.Option_D
            },
            correctAnswer: question.Answer
        }));
    }

    //////////////////////////////////////////////////////////////////
    // Function to format a price in dollars with 2 decimal places  
    //////////////////////////////////////////////////////////////////
    function formatPrice(value) {
        return "$" + parseFloat(value).toFixed(2);
    }

    //////////////////////////////////////////////////////////////////
    // Function to format a price to number 
    //////////////////////////////////////////////////////////////////
    function Priceformat(value) {
        // Remove invalid characters except for digits and one decimal point  
        const regex = /^(\d+(\.\d{0,2})?)?$/; // Accepts numbers like 123, 123.45, 0.99, etc.  
        if (regex.test(value)) {
            return value;
        } else {
            // If not valid, return previous state or empty  
            return value.slice(0, -1); // Remove the last invalid character  
        }
    }
    //////////////////////////////////////////////////////////////////
    // Function to extract the numerical value from a price string  
    //////////////////////////////////////////////////////////////////
    function extractValue(priceStr) {
        if (priceStr == "") {
            return "";
        }
        return parseFloat(priceStr.replace(/[$,]/g, '').trim());
    }

    //////////////////////////////////////////////////////////////////
    ////////////           Check string size           ///////////////
    //////////////////////////////////////////////////////////////////
    function isStringWithinSizeLimit(inputString, sizeLimit) {
        // Check if the length of inputString exceeds sizeLimit  
        return inputString.length <= sizeLimit;
    }

    var isValid = true;

    /////////////////////////////////////////////////////////////////
    //                Get Current form data
    ///////////////////////////////////////////////////////////////// 
    function getCurrentFormData() {
        return {
            title: $('#title').val().trim(),
            description: replacePatternWithEnterSpace(replaceNewlineWithPattern($('#description').val())),
            cover: $('#cover')[0].files[0],
            keys: $('#keys').val(),
            type: $('#type').val(),
            category: $('#category').val(),
            modulesNum: $('#modulesNum').val(),
            testQuestion: $('input[name="testQuestion"]:checked').val(),
            testNum: $('#testNum').val(),
            price: extractValue($('#price').val().trim()) // New input for premium courses
        };
    }


    /////////////////////////////////////////////////////////////////
    //              Validate basic information
    ///////////////////////////////////////////////////////////////// 
    function validateBasicDetails() {
        let isValid = true;

        // Collect current values from the form
        let courseData = getCurrentFormData();

        // Ensure courseData and previousCourseData both have keys
        if (!courseData.keys) {
            courseData.keys = [];
        }
        if (!courseData.deleteKey) {
            courseData.deleteKey = [];
        }
        if (!previousCourseData.keys) {
            previousCourseData.keys = [];
        }
        // Keep both old and new keys in courseData.keys
        const updatedKeys = [];

        // Process keys in courseData
        courseData.keys.forEach(value => {
            if (previousCourseData.keys.includes(value)) {
                // Key is in both courseData and previousCourseData (old key)
                updatedKeys.push(value);
            } else {
                // Key is new (in courseData but not in previousCourseData)
                updatedKeys.push(value);
                // courseData.addKey.push(value);
            }
        });
        // Process keys in previousCourseData that are not in courseData (to be deleted)
        previousCourseData.keys.forEach(value => {
            if (!courseData.keys.includes(value)) {
                courseData.deleteKey.push(value);
            }
        });
        // Update courseData.keys, ensuring deleted keys are removed
        courseData.keys = updatedKeys.filter(value => !courseData.deleteKey.includes(value));
        if (courseData.hasOwnProperty('title') && !courseData.title) {
            $('#title').addClass('border-danger');
            $('#title-span').text('Course title is required.').show();
            isValid = false;
        }
        if (courseData.hasOwnProperty('title') && !isStringWithinSizeLimit(courseData.title, "100")) {
            $('#title').addClass('border-danger');
            $('#title-span').text('The maximum string length is 100.').show();
            isValid = false;
        }
        if (courseData.hasOwnProperty('description') && !courseData.description) {
            $('#description').addClass('border-danger');
            $('#description-span').text('Course description is required.').show();
            isValid = false;
        }
        if (courseData.hasOwnProperty('description') && !isStringWithinSizeLimit(courseData.description, "1000")) {
            $('#description').addClass('border-danger');
            $('#description-span').text('The maximum string length is 1000.').show();
            isValid = false;
        }
        if (courseData.hasOwnProperty('cover') && !courseData.cover) {
            // For editing
            if (temp_cover !== "") {
                courseData.cover = temp_cover;
            } else {
                // For creating
                $('#cover').addClass('border-danger');
                $('#cover-span').text('Cover image is required.').show();
                isValid = false;
            }
        }
        if (courseData.hasOwnProperty('keys') && (!courseData.keys || courseData.keys.length === 0)) {
            $('#keys').addClass('border-danger');
            $('#keys-span').text('At least one area covered is required.').show();
            isValid = false;
        }
        if (courseData.hasOwnProperty('type') && !courseData.type) {
            $('#type').addClass('border-danger');
            $('#type-span').text('Course type is required.').show();
            isValid = false;
        }
        if (courseData.hasOwnProperty('category') && !courseData.category) {
            $('#category').addClass('border-danger');
            $('#category-span').text('Course category is required.').show();
            isValid = false;
        }
        if (courseData.hasOwnProperty('modulesNum') && !courseData.modulesNum) {
            $('#modulesNum').addClass('border-danger');
            $('#modulesNum-span').text('Number of modules is required.').show();
            isValid = false;
        }
        if (courseData.hasOwnProperty('testQuestion') && !courseData.testQuestion) {
            $('input[name="testQuestion"]').addClass('border-danger');
            $('#testQuestion-span').text('Please select if there is a test.').show();
            isValid = false;
        }
        if (courseData.hasOwnProperty('testNum') && courseData.testQuestion === 'yes' && !courseData.testNum && course_ID_to_send == "") {
            $('#testNum').addClass('border-danger');
            $('#testNum-span').text('Please select the number of test questions.').show();
            isValid = false;
        }
        if (courseData.hasOwnProperty('price') && courseData.type === 'premium' && (!courseData.price || courseData.price > 300)) {
            $('#price').addClass('border-danger');
            var temp_message = 'Price is required for premium courses.';
            if (courseData.price > 300) {
                temp_message = "Maximum price is $300.";
            }
            $('#price-span').text(temp_message).show();
            isValid = false;
        }
        // If all validations pass, proceed with submission
        if (isValid) {

            sendDetail = false;
            $("#details").addClass("d-none");
            $("#modules").removeClass("d-none");
            $('html, body').animate({
                scrollTop: $('#modules').offset().top
            }, 'slow');
            // Submit or process the courseData
            var formdata = new FormData;
            formdata.append('course_ID', course_ID_to_send); // Append course ID
            formdata.append('purpose', 'details'); // Append the purpose       
            for (let key in courseData) {
                if (key === "cover") {
                    // Handle cover comparison
                    if ($('#cover')[0].files.length > 0 && $('#cover')[0].files[0].name !== previousCourseData.cover) {
                        formdata.append('cover', $('#cover')[0].files[0]); // Attach the new file directly
                        previousCourseData[key] = $('#cover')[0].files[0].name;
                        sendDetail = true;
                    }
                } else if (key === "testQuestion" && $('input[name="testQuestion"]:checked').val() !== null && $('input[name="testQuestion"]:checked').val() != previousCourseData.testQuestion && temp_cover == "") {
                    // Handle testQuestion comparison
                    previousCourseData[key] = $('input[name="testQuestion"]:checked').val();
                    formdata.append('testQuestion', $('input[name="testQuestion"]:checked').val()); // Attach the selected value
                    sendDetail = true;
                } else if (key == "testNum" && $("#" + key).val() != null && $("#" + key).val() != previousCourseData[key]) {
                    previousCourseData[key] = $("#" + key).val();
                    formdata.append(key, $("#" + key).val()); // Attach the updated value
                    sendDetail = true;
                } else if (key == "price" && $("#" + key).val() != '') {
                    if (extractValue($("#" + key).val()) != previousCourseData[key]) {
                        previousCourseData[key] = extractValue($("#" + key).val());
                        formdata.append(key, extractValue($("#" + key).val())); // Attach the updated value
                        sendDetail = true;
                    }
                } else if (key == "keys") {
                    const keys = previousCourseData[key].join(',');
                    if (keys != $("#" + key).val()) {
                        previousCourseData[key] = $("#" + key).val();
                        formdata.append(key, $("#" + key).val()); // Attach the updated value
                        sendDetail = true;
                    }
                } else if (key !== "testQuestion" && key !== "testNum" && key !== "keys" && key !== "price") {
                    // General comparison for other keys
                    if ($("#" + key).val() != previousCourseData[key]) {
                        previousCourseData[key] = $("#" + key).val();
                        formdata.append(key, $("#" + key).val()); // Attach the updated value
                        sendDetail = true;
                    }
                }
            }
            if (course_ID_to_send !== "") {
                formdata.append("course_ID", course_ID_to_send);
            }
            if (sendDetail == true) {
                $.ajax({
                    url: "app/addcourse_process.php",
                    method: "POST",
                    data: formdata, // Use FormData as the data
                    processData: false, // Prevent jQuery from automatically transforming the data into a query string
                    contentType: false, // Ensure multipart/form-data is used
                    dataType: "json",
                    success: function (response) {
                        setTimeout(function () {
                            if (response.state == "insert_success" || response.state == "update_success") {
                                if (course_ID_to_send == "") {
                                    course_ID_to_send = response.course_ID;
                                    formdata.append('course_ID', course_ID_to_send);
                                    previousCourseData = courseData;
                                    sendDetail = false;
                                    let params = new URLSearchParams(window.location.search);
                                    params.set('c', response.course_ID); // Use 'set' to update or add the parameter  
                                    window.history.replaceState({}, '', `${window.location.pathname}?${params}`);
                                    document.title = "Editing - " + capitalizeFirstLetter(courseData.title);
                                    $("#deleteContainer").removeClass("d-none");
                                    $("#delete").removeClass("disabled");
                                    $("#deleteModal").remove();

                                    canDelete = true;
                                }
                                $(".btn-toDisabled").prop("disabled", false).removeClass("non-clickable");
                            } else {
                                alert("An error occurred, please try again. If it persists, contact the support team.")
                            }
                        }, 1000);
                    }
                });
            }

        } else {
            $(".an_error_exist").text("Errors were found. Attain to them.")
        }
        if ($("#testNum").val() == "") {
            $("#nextSaveModule").text("Submit");
        }

    }



    $('#next').on('click', function () {
        isValid = true;
        // Clear previous error messages, hide spans, and remove border-danger class
        $('span[id$="-span"]').hide().text('');
        $('.border-danger').removeClass('border-danger');
        validateBasicDetails();
    });

    // Remove border-danger class, clear error message, and hide span on input focus or change
    $('input, textarea, select').on('input change focus', function () {
        $(this).removeClass('border-danger');
        let spanID = $(this).attr('id') + '-span';
        $('#' + spanID).hide().text('');
        $(".an_error_exist").text("")
    });
    $("#price").on("input", function () {
        var temp = $(this).val();
        if (temp > 300) {
            $('#price').addClass('border-danger');
            $('#price-span').text("Maximum price is $300.").show();
        } else {
            $('#price').removeClass('border-danger');
            $('#price-span').text("").hide();
            $(this).val(Priceformat(temp));
            $(".an_error_exist").text("")
        }
    })
    $("#price").on("blur", function () {
        var temp = $(this).val();
        if (temp > 300) {
            $('#price').addClass('border-danger');
            $('#price-span').text("Maximum price is $300.").show();
        } else {
            $('#price').removeClass('border-danger');
            $('#price-span').text("").hide();
            $(this).val(Priceformat(temp));
            $(".an_error_exist").text("")
        }
    })
    // Show price input if course type is premium
    $('#type').on('change', function () {
        var temp = isValid;
        if ($(this).val() == "premium") {
            $("#price-div").removeClass("d-none");
            isValid = false;
        } else {
            isValid = temp;
            $("#price-div").addClass("d-none");
            $("#price").val(''); // Clear the price input if switching back to free
            $('#price').removeClass('border-danger');
            $('#price-span').hide().text('');
            $(".an_error_exist").text("")
        }
    });
    // Remove border-danger class, clear error message, and hide span on radio button click
    var tempPrice = '';
    $('input[name="testQuestion"]').on('change', function () {
        $('input[name="testQuestion"]').removeClass('border-danger');
        $(".an_error_exist").text("")
        $('#testQuestion-span').hide().text('');
        if ($(this).val() == "no") {
            $("#type").val("free").change(); // Set value to "free" and trigger change event  
            $("#price-div").addClass("d-none");
            tempPrice = extractValue($('#price').val().trim());
            $("#price").val('');
        } else {
            $("#price-div").removeClass("d-none");
            if (tempPrice != '') {
                $("#price").val(tempPrice);
            }
        }
    });


    /////////////////////////////////////////////
    // Check Cover image type
    const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
    $("#cover").on("change", function () {
        let file = this.files[0];
        let pictureWarning = $("#cover-warning");
        let saveButton = $("#save");

        if (file) {
            let allowedTypes = ["image/jpeg", "image/png"];

            // Validate file type  
            if (!allowedTypes.includes(file.type)) {
                pictureWarning.text("Accepted file types: PNG and JPG images only.").removeClass("d-none");
                $(this).addClass("border-danger").val(""); // Clear input  
                saveButton.addClass("disabled"); // Disable the save button  
                return;
            } else {
                pictureWarning.addClass("d-none");
                $(this).removeClass("border-danger");
            }

            // Validate file size  
            if (file.size > maxFileSize) {
                pictureWarning.text("File size exceeds 2MB.").removeClass("d-none");
                saveButton.addClass("disabled");
                $(this).addClass("border-danger").val(""); // Clear input  
                return;
            } else {
                pictureWarning.addClass("d-none");
                saveButton.removeClass("disabled");
                $(this).removeClass("border-danger");
            }

            // Load the image preview  
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#cover-image').attr('src', e.target.result).removeClass("d-none");
                $('#cover-span').hide(); // Hide the span if the image is uploaded  
            };
            reader.readAsDataURL(file);
        } else {
            // No file selected, show error message if needed  
            $('#cover-span').show(); // Show error if no file is selected  
            $('#cover-image').attr('src', '').addClass("d-none"); // Clear the image preview  
            saveButton.addClass("disabled"); // Disable the save button  
        }
    });

    $("#testNumContainer").click(function () {
        if (course_response !== "" && checkTestNum == true) {
            $("#testNum-span").text("Sorry! You can't change the number of questions for the test.").show();
        }
    });
    $("#testQuestionContainer").click(function () {
        if (course_response !== "" && checkTestNum === true) {
            $("#testQuestion-span").text("Sorry! You can't change this field because it has registered users.").show();
        }
    });
    $("#moduleNumContainer").click(function () {
        if (course_response !== "") {
            $("#modulesNum-span").text("Sorry! You can't change the number of modules.").show();
        }
    })
    $("#moduleNumContainer").focusout(function () {
        if (course_response !== "") {
            $("#modulesNum-span").hide();
        }
    });
    $("#testNumContainer").focusout(function () {
        if (course_response !== "" && checkTestNum == true) {
            $("#testNum-span").hide();
        }
    });
    $(document).click(function (event) {
        // Check if the click is outside the test question container and message span  
        if (!$(event.target).closest("#testQuestionContainer").length && !$(event.target).is("#testQuestion-span")) {
            $("#testQuestion-span").hide(); // Hide the message  
        }
    });

    $("#testNum").change(function () {
        $("#nextSaveModule").text("Next");
    });

    /////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    //////////////                  Module Processes                    /////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    let modulesAppended = 0;
    let totalModules = parseInt($('#modulesNum').val()) || 0;
    let moduleExtraCount = {};

    // Function to create a module element
    function createModule(index) {
        return `
        <div id="module-${index}">
            <div class="text-muted fs-7">Module ${index}</div>
            <div class="form-outline mt-3" style="width: 100%">
                <input type="text" value="" placeholder="Module ${index} Title" id="title-${index}" class="form-control mb-2" style="width:100%;" required />
                <textarea class="form-control" style="resize: none;height: 110px;" placeholder="Module ${index} description" id="description-${index}" required></textarea>
            </div>
            <div id="moduleExtra-${index}" class="mt-2">
                <div class="mt-3 moduleExtra">
                    <input type="text" id="url-${index}-1" value="" placeholder="Video ${index} Iframe(YouTube Iframe)" class="form-control me-2 iframe" style="width:100%;" required />
                </div>
            </div>
            <div class="text-end">
                <svg class="me-3 d-none removeVidModule" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="removeVidModule-${index}" fill="red" width="20px" height="20px" viewBox="0 0 128 128" id="Layer_1" version="1.1" xml:space="preserve">
                    <g>
                        <polygon points="82.4,40 64,58.3 45.6,40 40,45.6 58.3,64 40,82.4 45.6,88 64,69.7 82.4,88 88,82.4 69.7,64 88,45.6  "/>
                        <path d="M1,127h126V1H1V127z M9,9h110v110H9V9z"/>
                    </g>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="addVidModule" width="20px" height="20px" viewBox="0 0 24 24" fill="none" id="addVidModule-${index}">
                    <path d="M11 8C11 7.44772 11.4477 7 12 7C12.5523 7 13 7.44771 13 8V11H16C16.5523 11 17 11.4477 17 12C17 12.5523 16.5523 13 16 13H13V16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16V13H8C7.44772 13 7 12.5523 7 12C7 11.4477 7.44771 11 8 11H11V8Z" fill="#0F0F0F" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23 4C23 2.34315 21.6569 1 20 1H4C2.34315 1 1 2.34315 1 4V20C1 21.6569 2.34315 23 4 23H20C21.6569 23 23 21.6569 23 20V4ZM21 4C21 3.44772 20.5523 3 20 3H4C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V4Z" fill="#0F0F0F" />
                </svg>
            </div>
        </div>`;
    }
    // createModuleWithValue
    function createModuleWithValue(index, modules) {
        const module = modules.modules[index - 1] || {};
        let relatedVideos = modules.videos.filter(video => video.Module_num === index.toString());

        // If no related videos, insert one empty object to render a blank video input
        if (relatedVideos.length === 0) {
            relatedVideos = [{
                URL: ''
            }];
        }

        const videoInputsHTML = relatedVideos.slice(0, 5).map((video, videoIndex) => {
            const hasURL = video.URL && video.URL.trim() !== '';
            const iframeValue = hasURL
                ? `<iframe style="width:100%;height: 300px" src="${video.URL}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>`
                : ''; // No iframe if URL is empty

            return `
                <div class="mt-3 moduleExtra">
                    <input type="text" id="url-${index}-${videoIndex + 1}" value='${iframeValue}' placeholder="Video ${videoIndex + 1} URL (YouTube Iframe)" class="form-control me-2 iframe" style="width:100%;" />
                </div>
            `;
        }).join('');

        const d_show = relatedVideos.length > 1 ? "" : " d-none";
        moduleExtraCount[index] = relatedVideos.length != 0 ? relatedVideos.length : 1;
        const moduleTitle = module.Title ? capitalizeFirstLetter(module.Title) : '';
        const moduleDescription = module.Description ? replacePatternWithEnterSpace(capitalizeFirstLetterOfPhrase(module.Description)) : '';

        return `
            <div id="module-${index}">
                <div class="text-muted fs-7">Module ${index}</div>
                <div class="form-outline mt-3" style="width: 100%">
                    <input type="text" value="${moduleTitle}" placeholder="Module ${index} Title" id="title-${index}" class="form-control mb-2" style="width:100%;" />
                    <textarea class="form-control" style="resize: none;height: 110px;" placeholder="Module ${index} Description" id="description-${index}">${moduleDescription}</textarea>
                </div>
                <div id="moduleExtra-${index}" class="mt-2">
                    ${videoInputsHTML}
                </div>
                <div class="text-end">
                    <svg class="me-3 ${d_show} removeVidModule" xmlns="http://www.w3.org/2000/svg" id="removeVidModule-${index}" fill="red" width="20px" height="20px" viewBox="0 0 128 128">
                        <g>
                            <polygon points="82.4,40 64,58.3 45.6,40 40,45.6 58.3,64 40,82.4 45.6,88 64,69.7 82.4,88 88,82.4 69.7,64 88,45.6"/>
                            <path d="M1,127h126V1H1V127z M9,9h110v110H9V9z"/>
                        </g>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="addVidModule" width="20px" height="20px" viewBox="0 0 24 24" fill="none" id="addVidModule-${index}">
                        <path d="M11 8C11 7.44772 11.4477 7 12 7C12.5523 7 13 7.44771 13 8V11H16C16.5523 11 17 11.4477 17 12C17 12.5523 16.5523 13 16 13H13V16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16V13H8C7.44772 13 7 12.5523 7 12C7 11.4477 7.44771 11 8 11H11V8Z" fill="#0F0F0F" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M23 4C23 2.34315 21.6569 1 20 1H4C2.34315 1 1 2.34315 1 4V20C1 21.6569 2.34315 23 4 23H20C21.6569 23 23 21.6569 23 20V4ZM21 4C21 3.44772 20.5523 3 20 3H4C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V4Z" fill="#0F0F0F" />
                    </svg>
                </div>
            </div>
        `;
    }

    // Append the initial set of modules
    function appendInitialModules() {
        for (let i = 1; i <= Math.min(5, totalModules); i++) {
            if (course_response == "") {
                $('#module-div').append(createModule(i));
                moduleExtraCount[i] = 1;
            } else {
                $('#module-div').append(createModuleWithValue(i, course_response));
            }
            modulesAppended++;
        }
    }

    // Event handler for adding more modules on "Next Module" click
    $('#nextModule').on('click', function () {
        let nextModules = Math.min(modulesAppended + 3, totalModules);
        for (let i = modulesAppended + 1; i <= nextModules; i++) {
            if (course_response == "") {
                $('#module-div').append(createModule(i));
            } else {
                $('#module-div').append(createModuleWithValue(i, course_response));
            }
            moduleExtraCount[i] = 1;
        }
        modulesAppended = nextModules;

        // Hide the Next Module button if all modules are appended
        if (modulesAppended >= totalModules) {
            $('#nextModule').hide();
            $('#nextSaveModule').removeClass("d-none");
            $('#saveAndExitModule').removeClass("d-none");
        }
    });

    // Event handler for adding module extra sections
    $(document).on('click', '.addVidModule', function () {
        // moduleExtra
        let moduleIndex = $(this).attr('id').split('-')[1];
        let moduleID = "#moduleExtra-" + $(this).attr('id').split('-')[1];

        // Assuming that the containing div has an ID like "moduleContainer-{moduleIndex}"  
        let videoIndex = $(`${moduleID} .moduleExtra`).length;
        moduleExtraCount[moduleIndex] = videoIndex;
        let extraIndex = ++moduleExtraCount[moduleIndex];
        if (extraIndex <= 5) {
            $(`#removeVidModule-${moduleIndex}`).removeClass("d-none");
            $(`#moduleExtra-${moduleIndex}`).append(`
                <div class="mt-3 moduleExtra">
                    <input type="text" id="url-${moduleIndex}-${extraIndex}" value="" placeholder="Video ${moduleIndex} URL (YouTube Iframe)" class="form-control me-2 iframe"  style="width:100%;" required />
                </div>
            `);
        }
        if (extraIndex == 5) {
            $(this).addClass("d-none")
        }
    });

    // Event handler for removing module extra sections
    $(document).on('click', '.removeVidModule', function () {
        let ids = $(this).attr('id').split('-');
        let moduleIndex = ids[1];
        let extraIndex = ids[2];
        $(`#addVidModule-${moduleIndex}`).removeClass("d-none")
        // Remove the specific extra div
        $(`#moduleExtra-${moduleIndex} .moduleExtra:last`).remove();

        // Decrement the extra count for this module
        moduleExtraCount[moduleIndex]--;
        // If only one extra remains, hide the remove button
        if (moduleExtraCount[moduleIndex] <= 1) {
            $(`#removeVidModule-${moduleIndex}`).addClass("d-none");
        }
    });

    // Initialize the modules section when modulesNum changes
    $('#modulesNum').on('change', function () {
        totalModules = parseInt($(this).val());
        modulesAppended = 0;
        $('#module-div').empty();
        $('#nextModule').show();
        appendInitialModules();
    });

    // Initialize the form and hide the modules section
    appendInitialModules();


    // Handle the course type change
    $('#type').on('change', function () {
        if ($(this).val() == "premium") {
            $("#price").removeClass("d-none");
            $('input[name="testQuestion"][value="yes"]').prop('checked', true).change(); // Set the "yes" radio button as checked  
        } else {
            $("#price").addClass("d-none");
            if (checkTestNum == true) {
                $('input[name="testQuestion"]').prop("disabled", true).addClass("disabled-select");

            }
        }
    });


    /////////////////////////////////////////////////////////////////
    //////                     Explode at "-"                 ///////
    /////////////////////////////////////////////////////////////////
    function explodeString(str) {
        // Use the indexOf method to find the first occurrence of '-'  
        var index = str.indexOf('-');

        // If the hyphen is found, split the string  
        if (index !== -1) {
            var beforeHyphen = str.substring(0, index);
            return beforeHyphen;
        }

        // Return the original string if no hyphen is found  
        return [str];
    }
    ////////////////////////////////////////////////////////////////////////
    ///////////// Check YouTube Iframe
    ////////////////////////////////////////////////////////////////////////
    function isValidYouTubeIframe(value) {
        // Create a temporary DOM element to parse the input
        var tempDiv = $('<div>').html(value);

        // Find iframe element
        var iframe = tempDiv.find('iframe');

        // Check if iframe exists and the src matches YouTube
        if (iframe.length && /^(https?:)?\/\/(www\.)?(youtube\.com|youtu\.be)\//.test(iframe.attr('src'))) {
            return true;  // Valid YouTube iframe
        }

        return false;  // Not a valid YouTube iframe
    }
    ////////////////////////////////////////////////////////////////////////
    ///////////// Extract YouTube Iframe Src
    ////////////////////////////////////////////////////////////////////////
    function extractIframeSrc(value) {
        // Create a temporary DOM element to parse the input
        var tempDiv = $('<div>').html(value);

        // Find iframe element
        var iframe = tempDiv.find('iframe');

        // Check if iframe exists
        if (iframe.length) {
            return iframe.attr('src');  // Return the src attribute value
        }

        return '';  // No iframe found
    }

    //////////////////////////////////////////////////////////////////////////
    //////////////////         NEXT SAVE MODULE         //////////////////////
    //////////////////////////////////////////////////////////////////////////

    $("#nextSaveModule").on("click", function () {
        let isValid = true;
        let hasNonDuplicate = false;
        let moduleData = [];
        let currentModuleData = [];
        let deleteExtra = []; // Array to store deleted extras in the desired format
        var check = 'added';
        let warnings = { textF: '', textL: '', textI: '', textV: '' };

        for (let i = 1; i <= modulesAppended; i++) {
            let description = replaceNewlineWithPattern($(`#description-${i}`).val().trim());
            let title = $(`#title-${i}`).val().trim();
            let moduleExtras = {};
            let currentModuleExtraValues = {}; // To compare with previous extras

            // Validate description
            if (!description) {
                markInvalid(`#description-${i}`);
                isValid = false;
            } else if (!isStringWithinSizeLimit(description, "1000")) {
                markInvalid(`#description-${i}`);
                isValid = false;
                warnings.textF = "The maximum string length for the description is 1000. ";
            } else {
                markValid(`#description-${i}`);
            }

            // Validate title
            if (!title) {
                markInvalid(`#title-${i}`);
                isValid = false;
            } else if (!isStringWithinSizeLimit(title, "100")) {
                markInvalid(`#title-${i}`);
                isValid = false;
                warnings.textL = "The maximum string length for the title is 100. ";
            } else {
                markValid(`#title-${i}`);
            }

            window.iframeTracker = {};
            // Validate and collect moduleExtras
            $(`#moduleExtra-${i} input`).each(function () {
                let inputValue = $(this).val().trim();
                const temp = explodeString($(this).attr("id"));
                const temp_id = $(this).attr("id").slice(-1);
                const extraKey = `extra-${temp_id}`;

                // Initialize trackers for this module
                if (!window.iframeTracker) window.iframeTracker = {};

                if (!window.iframeTracker[i]) window.iframeTracker[i] = new Set();

                if (!inputValue) {
                    markInvalid(this);
                    isValid = false;
                    warnings.textF = "Please fill out all required fields. ";
                    return;
                }

                // Length check (non-iframe inputs)
                if (!$(this).hasClass("iframe") && !isStringWithinSizeLimit(inputValue, "200")) {
                    markInvalid(this);
                    isValid = false;
                    warnings.textL = "The maximum string length for the associated field is 200. ";
                    return;
                }

                // Invalid YouTube iframe
                if ($(this).hasClass("iframe")) {
                    if (!isValidYouTubeIframe(inputValue)) {
                        markInvalid(this);
                        isValid = false;
                        warnings.textI = "The video URL should be a valid YouTube Iframe. ";
                        return;
                    }

                    const extracted = extractIframeSrc(inputValue);

                    // Duplicate iframe
                    if (window.iframeTracker[i].has(extracted)) {
                        markInvalid(this);
                        isValid = false;
                        warnings.textI = "Duplicate video iframe detected in the same module. ";
                        return;
                    } else {
                        window.iframeTracker[i].add(extracted);
                        inputValue = extracted;
                    }
                }

                // Passed all checks
                markValid(this);
                if (!moduleExtras[extraKey]) moduleExtras[extraKey] = [];
                moduleExtras[extraKey].push({ name: temp, value: inputValue });

                // Store current extra values for comparison
                if (!currentModuleExtraValues[extraKey]) currentModuleExtraValues[extraKey] = [];
                currentModuleExtraValues[extraKey].push(inputValue);
            });


            const moduleObject = {
                [`description-${i}`]: description,
                [`title-${i}`]: title,
                moduleNum: i,
                [`moduleExtras-${i}`]: moduleExtras
            };

            currentModuleData.push(moduleObject);

            if (hasModuleChanged(i, moduleObject)) {
                hasNonDuplicate = true;
                moduleData.push(moduleObject);
                check = 'notAdded';
            }

            // Check for deleted extras
            const previousModule = previousModuleData.find(m => m.moduleNum === i);
            if (previousModule) {
                const previousExtras = previousModule[`moduleExtras-${i}`] || {};
                for (const prevExtraKey in previousExtras) {
                    const prevValues = previousExtras[prevExtraKey].map(item => item.value);
                    const currentValues = currentModuleExtraValues[prevExtraKey] || [];

                    prevValues.forEach(prevValue => {
                        if (!currentValues.includes(prevValue)) {
                            const match = prevExtraKey.match(/extra-(\d+)/);
                            if (match && match[1]) {
                                const extraVideoNumToDelete = parseInt(match[1]);
                                const existingDeleteExtraModule = deleteExtra.find(item => item.moduleNum === i);
                                if (existingDeleteExtraModule) {
                                    if (!existingDeleteExtraModule.extraVideoNum.includes(extraVideoNumToDelete)) {
                                        existingDeleteExtraModule.extraVideoNum.push(extraVideoNumToDelete);
                                    }
                                } else {
                                    deleteExtra.push({
                                        moduleNum: i,
                                        extraVideoNum: [extraVideoNumToDelete]
                                    });
                                }
                            }
                        }
                    });
                }
            }
        }
        if ($("#testNum").val() === "") {
            $("#saveAndExitModule").prop("disabled", true).addClass("non-clickable");
        }
        if (Object.values(warnings).some(w => w)) {
            $(".module-warning").text(Object.values(warnings).join("")).removeClass("d-none");
        } else if (!hasNonDuplicate && isValid) {
            handleNoChangeNextStep();
            return;
        } else if (isValid) {
            previousModuleData = [...currentModuleData];
            $(".btn-toDisabled").prop("disabled", true).addClass("non-clickable");

            $.ajax({
                url: "app/addcourse_process.php",
                method: "POST",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
                },
                data: {
                    moduleData: moduleData,
                    course_ID: course_ID_to_send,
                    purpose: "modules",
                    check: check,
                    status: ($("#testNum").val() === "") ? "save" : "",
                    deleteExtra: deleteExtra // Send the deleteExtra array
                },
                dataType: "json",
                success: function (response) {
                    $(".btn-toDisabled").prop("disabled", false).removeClass("non-clickable");
                    if (["insert_success", "update_success"].includes(response.state)) {
                        handleNoChangeNextStep();
                    } else {
                        alert("An error occurred, please try again. If it persists, contact the support team.");
                    }
                }
            });
        } else {
            $(".module-warning").text("Issues were found. Attain to them.");
            $(".module-warning").addClass("d-none");
        }
    });

    function markInvalid(selector) {
        $(selector).addClass('border-danger');
    }
    function markValid(selector) {
        $(selector).removeClass('border-danger');
    }

    function hasModuleChanged(index, current) {
        const previous = previousModuleData.find(m => m.moduleNum === index);
        if (!previous) return true;

        if (
            previous[`description-${index}`] !== current[`description-${index}`] ||
            previous[`title-${index}`] !== current[`title-${index}`]
        ) return true;

        const prevExtras = previous[`moduleExtras-${index}`] || {};
        const currExtras = current[`moduleExtras-${index}`] || {};

        const prevExtraKeys = Object.keys(prevExtras).sort();
        const currExtraKeys = Object.keys(currExtras).sort();

        if (prevExtraKeys.length !== currExtraKeys.length) return true;

        for (let i = 0; i < prevExtraKeys.length; i++) {
            if (prevExtraKeys[i] !== currExtraKeys[i]) return true;

            const prevArr = prevExtras[prevExtraKeys[i]] || [];
            const currArr = currExtras[currExtraKeys[i]] || [];

            if (prevArr.length !== currArr.length) return true;
            for (let j = 0; j < currArr.length; j++) {
                if (currArr[j]?.name !== prevArr[j]?.name || currArr[j]?.value !== prevArr[j]?.value) {
                    return true;
                }
            }
        }

        return false;
    }

    function handleNoChangeNextStep() {
        if ($("#testNum").val() !== "" || haveTest === true) {
            $('#test-details').removeClass("d-none");
            $("#modules").addClass("d-none");
        } else {
            $("#nextSaveModule").addClass("d-none");
            $("#btn-loader-nextSaveModule").removeClass("d-none");

            setTimeout(() => {
                $(".btn-toDisabled").prop("disabled", false).removeClass("non-clickable");
                $('#modules').addClass("d-none");
                $('#success-div').removeClass("d-none");
            }, 1000);
        }
    }

    //////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////
    //////////////////////          Save and Exit module         ////////////////////
    /////////////////////////////////////////////////////////////////////////////////

    $("#saveAndExitModule").on("click", function () {
        let isValid = true;
        var check = 'added';
        let hasNonDuplicate = false;
        let moduleData = []; // Will contain only changed modules
        let currentModuleData = []; // Full current state of the modules
        let deleteExtra = []; // Array to store deleted extras
        let warnings = { textF: '', textL: '', textI: '', textV: '' };

        for (let i = 1; i <= modulesAppended; i++) {
            let description = replaceNewlineWithPattern($(`#description-${i}`).val().trim());
            let title = replaceNewlineWithPattern($(`#title-${i}`).val().trim());
            let moduleExtras = {};
            let currentModuleExtraValues = {}; // To compare with previous extras

            // Validate description
            if (!isStringWithinSizeLimit(description, "1000")) {
                markInvalid(`#description-${i}`);
                isValid = false;
                warnings.textF = "The maximum string length for the description is 1000.";
            } else {
                markValid(`#description-${i}`);
            }

            // Validate title
            if (!isStringWithinSizeLimit(title, "100")) {
                markInvalid(`#title-${i}`);
                isValid = false;
                warnings.textL = "The maximum string length for the title is 100.";
            } else {
                markValid(`#title-${i}`);
            }

            // Gather Extras and Validate
            window.iframeTracker = {};
            $(`#moduleExtra-${i} input`).each(function () {
                let inputValue = $(this).val().trim();
                const temp = explodeString($(this).attr("id"));
                const temp_id = $(this).attr("id").slice(-1);
                const extraKey = `extra-${temp_id}`;

                if (!moduleExtras[extraKey]) {
                    moduleExtras[extraKey] = [];
                }

                // Initialize duplicate trackers
                if (!window.iframeTracker[i]) window.iframeTracker[i] = new Set();


                let originalInput = inputValue;
                let extractedIframe = "";

                if ($(this).hasClass("iframe")) {
                    extractedIframe = extractIframeSrc(inputValue);
                    if (window.iframeTracker[i].has(extractedIframe)) {
                        markInvalid(this);
                        isValid = false;
                        warnings.textI = "Duplicate video iframe detected in the same module.";
                        return;
                    } else {
                        window.iframeTracker[i].add(extractedIframe);
                        inputValue = extractedIframe;
                    }
                }

                if (!$(this).hasClass("iframe") && originalInput && !isStringWithinSizeLimit(originalInput, "200")) {
                    markInvalid(this);
                    isValid = false;
                    warnings.textL = "The maximum string length for the associated field is 200.";
                    return;
                } else if ($(this).hasClass("iframe") && originalInput && !isValidYouTubeIframe(originalInput)) {
                    markInvalid(this);
                    isValid = false;
                    warnings.textI = "The video URL should be a valid YouTube Iframe.";
                    return;
                } else {
                    markValid(this);
                }

                moduleExtras[extraKey].push({ name: temp, value: inputValue });

                // Store current extra values for comparison
                if (!currentModuleExtraValues[extraKey]) currentModuleExtraValues[extraKey] = [];
                currentModuleExtraValues[extraKey].push(inputValue);
            });

            // Always Push Full Current State
            currentModuleData.push({
                [`description-${i}`]: description,
                [`title-${i}`]: title,
                [`moduleExtras-${i}`]: moduleExtras,
                moduleNum: i
            });

            // Compare With Previous for Changes
            const previous = previousModuleData.find(m => m.moduleNum === i);
            const changes = { moduleNum: i };
            let somethingChanged = false;

            if (previous?.[`description-${i}`] !== description) {
                changes[`description-${i}`] = description;
                somethingChanged = true;
            }

            if (previous?.[`title-${i}`] !== title) {
                changes[`title-${i}`] = title;
                somethingChanged = true;
            }

            const prevExtras = previous?.[`moduleExtras-${i}`] || {};
            for (const key in moduleExtras) {
                const currArr = moduleExtras[key];
                const prevArr = prevExtras[key] || [];
                if (JSON.stringify(currArr) !== JSON.stringify(prevArr)) {
                    if (!changes[`moduleExtras-${i}`]) {
                        changes[`moduleExtras-${i}`] = {};
                    }
                    changes[`moduleExtras-${i}`][key] = currArr;
                    somethingChanged = true;
                }
            }
            for (const key in prevExtras) {
                if (!moduleExtras[key]) {
                    if (!changes[`moduleExtras-${i}`]) {
                        changes[`moduleExtras-${i}`] = {};
                    }
                    changes[`moduleExtras-${i}`][key] = []; // Indicate deletion by sending an empty array
                    somethingChanged = true;
                }
            }

            // Push Only Changes
            if (somethingChanged) {
                moduleData.push(changes);
                hasNonDuplicate = true;
                check = 'notAdded';
            }

            // Check for deleted extras
            if (previous) {
                const previousExtras = previous[`moduleExtras-${i}`] || {};
                for (const prevExtraKey in previousExtras) {
                    const prevValues = previousExtras[prevExtraKey].map(item => item.value);
                    const currentValues = currentModuleExtraValues[prevExtraKey] || [];

                    prevValues.forEach(prevValue => {
                        if (!currentValues.includes(prevValue)) {
                            const match = prevExtraKey.match(/extra-(\d+)/);
                            if (match && match[1]) {
                                const extraVideoNumToDelete = parseInt(match[1]);
                                const existingDeleteExtraModule = deleteExtra.find(item => item.moduleNum === i);
                                if (existingDeleteExtraModule) {
                                    if (!existingDeleteExtraModule.extraVideoNum.includes(extraVideoNumToDelete)) {
                                        existingDeleteExtraModule.extraVideoNum.push(extraVideoNumToDelete);
                                    }
                                } else {
                                    deleteExtra.push({
                                        moduleNum: i,
                                        extraVideoNum: [extraVideoNumToDelete]
                                    });
                                }
                            }
                        }
                    });
                }
            }
        }

        if (Object.values(warnings).some(w => w)) {
            $(".module-warning").text(Object.values(warnings).join("")).removeClass("d-none");
        } else if (!hasNonDuplicate) {
            $("#btn-loader-saveAndExitModule").removeClass("d-none");
            $("#saveAndExitModule").addClass("d-none");
            $(".btn-toDisabled").prop("disabled", true).addClass("non-clickable");
            setTimeout(function () {
                allowPageReload = true;
                window.location.href = "dashboard.php";
            }, 1000);
            return;
        } else if (isValid) {
            previousModuleData = [...currentModuleData];
            $("#saveAndExitModule").addClass("d-none");
            $("#btn-loader-saveAndExitModule").removeClass("d-none");
            $.ajax({
                url: "app/addcourse_process.php",
                method: "POST",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
                },
                data: {
                    moduleData: moduleData,
                    course_ID: course_ID_to_send,
                    purpose: "modules",
                    check: check,
                    deleteExtra: deleteExtra // Include deleteExtra for save and exit
                },
                dataType: "json",
                success: function (response) {
                    $(".btn-toDisabled").off("click").addClass("non-clickable");
                    setTimeout(function () {
                        allowPageReload = true;
                        window.location.href = "dashboard.php";
                    }, 1000);
                }
            });
        } else {
            $(".module-warning").text("Issues were found. Attain to them.");
        }
    });
    /////////////////////////////////////////////////////////////////////////////////

    // Remove border-danger and hide warning on input change
    $(document).on('focus', 'textarea, input', function () {
        if ($(this).hasClass('border-danger')) {
            $(this).removeClass('border-danger');
            $(".module-warning").addClass("d-none");
            $(".an_error_exist").text("")
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    //////////////                  Test Processes                    /////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    const $testDiv = $('#test-div');
    const $testNumInput = $('#testNum');
    const $testNextButton = $('#test-next');
    const $testPreviousButton = $('#test-previous');

    // Tracking number of questions and the current question index
    let questionsToAdd = 0;
    let currentQuestionIndex = 1;

    // Function to create a question element
    function createQuestionElement(index) {
        return `
        <div class="mb-3 question-container">
            <div class="text-muted fs-7 fw-semibold">Question ${index}</div>
            <div class="form-outline mt-3" style="width: 100%">
                <textarea class="form-control" style="resize: none;" placeholder="Question ${index}" id="question-${index}"></textarea>
            </div>
            <div class="">
                <div class="mb-2 d-flex mt-2">
                    <div class="d-flex">
                        <span class="mt-2 me-2">A </span> <input id="question${index}-optionA" value="" type="text" class="form-control me-2" />
                        <span class="mt-2 me-2">B </span> <input id="question${index}-optionB" value="" type="text" class="form-control me-2" />
                        <span class="mt-2 me-2">C </span> <input id="question${index}-optionC" value="" type="text" class="form-control me-2" />
                        <span class="mt-2 me-2">D </span> <input id="question${index}-optionD" value="" type="text" class="form-control me-2" />
                    </div>
                    <div class=" questions-answer-container" data-num="${index}"> 
                        <select id="question${index}-answer" data-num="${index}" class="ms-2 questions-answer select2">
                            <option></option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                    </div>
                </div>
                <div id="question${index}-answer-warning-${index}" class="text-end d-none text-danger my-0">This field is required</div>
            </div>
        </div>`;
    }

    // Function to create a question element with values
    function createQuestionElementWithValues(index, questions) {
        const questionData = questions.tests.find(q => q.Question_num == index); // Find question by Question_num  

        // If questionData doesn't exist or index does not match Question_num, create a default structure  
        const questionNum = questionData ? questionData.Question_num : index; // Use Question_num if found, otherwise use index  
        const questionText = questionData ? capitalizeFirstLetterOfPhrase(questionData.Question) : ''; // Get question text or empty  
        const optionA = questionData ? capitalizeFirstLetterOfPhrase(questionData.Option_A) : '';
        const optionB = questionData ? capitalizeFirstLetterOfPhrase(questionData.Option_B) : '';
        const optionC = questionData ? capitalizeFirstLetterOfPhrase(questionData.Option_C) : '';
        const optionD = questionData ? capitalizeFirstLetterOfPhrase(questionData.Option_D) : '';
        // Determine the selected answer  
        const answer = questionData && questionData.Answer ? questionData.Answer.toLowerCase() : '';

        return `  
            <div class="mb-3 question-container">  
                <div class="text-muted fs-7 fw-semibold">Question ${questionNum}</div>  
                <div class="form-outline mt-3" style="width: 100%">  
                    <textarea class="form-control" style="resize: none;" placeholder="Question ${questionNum}" id="question-${questionNum}">${questionText}</textarea>  
                </div>  
                <div>  
                    <div class="mb-3 d-flex mt-3">  
                        <div class="d-flex">  
                            <span class="mt-2 me-2">A </span>   
                            <input id="question${questionNum}-optionA" value="${optionA}" type="text" class="form-control me-2" />  
                            <span class="mt-2 me-2">B </span>   
                            <input id="question${questionNum}-optionB" value="${optionB}" type="text" class="form-control me-2" />  
                            <span class="mt-2 me-2">C </span>   
                            <input id="question${questionNum}-optionC" value="${optionC}" type="text" class="form-control me-2" />  
                            <span class="mt-2 me-2">D </span>   
                            <input id="question${questionNum}-optionD" value="${optionD}" type="text" class="form-control me-2" />  
                        </div>   
                        <div class="questions-answer-container" data-num="${questionNum}">   
                            <select id="question${questionNum}-answer" data-num="${questionNum}" class="ms-2 questions-answer select2">  
                                <option></option>  
                                <option value="a" ${answer === "a" ? "selected" : ""}>A</option>  
                                <option value="b" ${answer === "b" ? "selected" : ""}>B</option>  
                                <option value="c" ${answer === "c" ? "selected" : ""}>C</option>  
                                <option value="d" ${answer === "d" ? "selected" : ""}>D</option>  
                            </select>  
                        </div>  
                    </div>  
                    <div id="question${questionNum}-answer-warning-${questionNum}" class="text-end d-none text-danger">This field is required</div>  
                </div>  
            </div>`;
    }

    // Function to add questions
    function addQuestions(count) {
        let questionsHTML = '';
        for (let i = 0; i < count; i++) {
            if (course_response == "" || (course_response && course_response.tests && course_response.tests.length == 0)) {
                questionsHTML += createQuestionElement(currentQuestionIndex);
            } else {
                questionsHTML += createQuestionElementWithValues(currentQuestionIndex, course_response);
            }
            currentQuestionIndex++;
        }
        $testDiv.append(questionsHTML);
        updateNextButtonVisibility();
        $(".questions-answer").select2({
            placeholder: "Select the answer",
            width: '100%',
            minimumResultsForSearch: Infinity // Hides the search box
        });
    }
    // Remove required field
    $testDiv.on("click", ".questions-answer-container", function () {
        var num = $(this).data("num");
        $(`#question${num}-answer-warning-${num}`).addClass('d-none')
    })

    // Function to update the visibility of the "Next Questions" button
    function updateNextButtonVisibility() {
        if (questionsToAdd <= 10) {
            $testNextButton.addClass("d-none");
            $("#submit").removeClass("d-none");
            $("#submitTestExit").removeClass("d-none");
        } else {
            $testNextButton.removeClass("d-none");
            $("#submit").addClass("d-none");
            $("#submitTestExit").addClass("d-none");
        }
    }

    // Event listener for the "Next Questions" button
    $testNextButton.on('click', function () {
        if (questionsToAdd > 10) {
            const batchSize = Math.min(10, questionsToAdd);
            questionsToAdd -= batchSize;
            addQuestions(batchSize);
            updateNextButtonVisibility();
        }
    });

    // Event listener for the number input to set the number of questions
    $testNumInput.on('change', function () {
        questionsToAdd = parseInt($testNumInput.val(), 10);
        currentQuestionIndex = 1;
        $testDiv.empty();
        if (questionsToAdd > 0) {
            addQuestions(Math.min(10, questionsToAdd));
        }
        updateNextButtonVisibility();
    });

    // Event listener for the "Submit" button

    $('#submit').on('click', function (e) {
        e.preventDefault();

        const testData = [];
        let isValid = true;
        let hasNonDuplicate = false;

        let warning1 = ""; // question text
        let warning2 = ""; // options
        let warning3 = ""; // correct answer

        $('.question-container').each(function (index) {
            const questionData = {};
            const questionNum = index + 1;

            const question = $(`#question-${questionNum}`).val().trim();
            const options = {
                a: $(`#question${questionNum}-optionA`).val().trim(),
                b: $(`#question${questionNum}-optionB`).val().trim(),
                c: $(`#question${questionNum}-optionC`).val().trim(),
                d: $(`#question${questionNum}-optionD`).val().trim()
            };
            const correctAnswer = $(`#question${questionNum}-answer`).val();

            questionData.question_num = questionNum;

            // Validate question
            if (!question) {
                $(`#question-${questionNum}`).addClass('border-danger');
                isValid = false;
                if (!warning1) warning1 = "All fields are required.\n";
            } else {
                $(`#question-${questionNum}`).removeClass('border-danger');
                questionData.question = question;
            }

            // Validate options
            questionData.options = {};
            for (let key in options) {
                if (!options[key]) {
                    $(`#question${questionNum}-option${key.toUpperCase()}`).addClass('border-danger');
                    isValid = false;
                    if (!warning2) warning2 = "All options must be filled.\n";
                } else {
                    $(`#question${questionNum}-option${key.toUpperCase()}`).removeClass('border-danger');
                    questionData.options[key] = options[key];
                }
            }

            // Validate correct answer
            if (!correctAnswer) {
                $(`#question${questionNum}-answer-warning-${questionNum}`).removeClass('d-none');
                isValid = false;
                if (!warning3) warning3 = "A correct answer must be selected.\n";
            } else {
                $(`#question${questionNum}-answer-warning-${questionNum}`).addClass('d-none');
                questionData.correctAnswer = correctAnswer;
            }

            if (isValid) {
                let isDuplicate = previousTestData.some(prev => {
                    return (
                        prev.question === question &&
                        JSON.stringify(prev.options) === JSON.stringify(questionData.options) &&
                        prev.correctAnswer === correctAnswer
                    );
                });

                if (!isDuplicate) {
                    testData.push(questionData);
                    hasNonDuplicate = true;
                }
            }
        });

        // Show warning messages if invalid
        if (!isValid) {
            $(".test-warning").text(warning1 + warning2 + warning3).removeClass("d-none");
            return;
        } else if (!hasNonDuplicate && submitted_date != null) {
            // No new data?
            $(".test-warning").text("No new data to submit. All the information has been stored.").removeClass("d-none");
            return;
        } else {
            // Submit valid data
            previousTestData = [...previousTestData, ...testData];
            $(".btn-toDisabled").off("click").addClass("non-clickable");

            $.ajax({
                url: "app/addcourse_process.php",
                method: "POST",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
                },
                data: { testData: testData, course_ID: course_ID_to_send, purpose: "test" },
                dataType: "json",
                success: function (response) {
                    setTimeout(function () {
                        $("#test-details").addClass("d-none");
                        if (response.state === "insert_success") {
                            $("#success-div").removeClass("d-none");
                        } else if (response.state === "error") {
                            alert("An error occurred. Please try again later.");
                            allowPageReload = true;
                        } else {
                            $("#success-div").removeClass("d-none");
                            $("#success-message").text("Your modifications were stored successfully!");
                        }
                    }, 1000);
                }
            });

            $("#btn-loader-test").removeClass("d-none");
            $("#submit").addClass("d-none");
            $("#submitTestExit").prop("disabled", true);
            $("#test-previous").prop("disabled", true);
        }
    });



    $('#submitTestExit').on('click', function (e) {
        e.preventDefault();

        const testExitData = [];
        let hasNonDuplicate = false;
        const currentQuestions = new Set();
        var warning = '';

        $('.question-container').each(function (index) {
            const questionData = {};
            const questionNum = index + 1;

            const question = $(`#question-${questionNum}`).val().trim();
            const options = {
                a: $(`#question${questionNum}-optionA`).val().trim(),
                b: $(`#question${questionNum}-optionB`).val().trim(),
                c: $(`#question${questionNum}-optionC`).val().trim(),
                d: $(`#question${questionNum}-optionD`).val().trim()
            };
            const correctAnswer = $(`#question${questionNum}-answer`).val();

            // If everything is empty, skip
            const hasAnyData = question || options.a || options.b || options.c || options.d || correctAnswer;
            if (!hasAnyData) return;

            // Always include question_num
            questionData.question_num = questionNum;

            // Check for duplicate question text in current session
            const lowerCaseQuestion = question.toLowerCase();
            if (question && currentQuestions.has(lowerCaseQuestion)) {
                $(`#question-${questionNum}`).addClass("border-danger");
                warning = "Duplicate questions found.";
                return; // Skip this duplicate
            } else if (question) {
                currentQuestions.add(lowerCaseQuestion);
                questionData.question = question;
            }

            // Add non-empty options
            questionData.options = {};
            let hasOption = false;
            for (let key in options) {
                if (options[key]) {
                    questionData.options[key] = options[key];
                    hasOption = true;
                }
            }

            if (correctAnswer) {
                questionData.correctAnswer = correctAnswer;
            }

            // Check if this specific entry already exists
            let isDuplicate = previousTestData.some(prev => {
                const sameQuestion = (prev.question || '') === (questionData.question || '');
                const sameAnswer = (prev.correctAnswer || '') === (questionData.correctAnswer || '');

                let sameOptions = true;
                if (hasOption) {
                    for (let key in questionData.options) {
                        if ((prev.options?.[key] || '') !== questionData.options[key]) {
                            sameOptions = false;
                            break;
                        }
                    }
                }

                return sameQuestion && sameOptions && sameAnswer;
            });

            if (!isDuplicate) {
                testExitData.push(questionData);
                hasNonDuplicate = true;
            }
        });
        if (warning !== '') {
            $(".test-warning").text(warning).removeClass("d-none");
        } else if (!hasNonDuplicate) {
            $("#submitTestExit").addClass("d-none");
            $("#btn-loader-submitTestExit").removeClass("d-none");
            $(".btn-toDisabled").off("click").addClass("non-clickable");
            allowPageReload = true;
            window.location.href = "dashboard.php";
            return;
        } else {
            previousTestData = [...previousTestData, ...testExitData];
            $(".btn-toDisabled").off("click").addClass("non-clickable");

            $.ajax({
                url: "app/addcourse_process.php",
                method: "POST",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
                },
                data: {
                    testData: testExitData,
                    course_ID: course_ID_to_send,
                    purpose: "test"
                },
                dataType: "json",
                success: function (response) {
                    $("#submitTestExit").addClass("d-none");
                    $("#btn-loader-submitTestExit").removeClass("d-none");
                    setTimeout(function () {
                        allowPageReload = true;
                        window.location.href = "dashboard.php";
                    }, 1000);
                }
            });
        }
    });

    $testDiv.on('input', 'textarea, input[type="text"]', function () {
        if ($(this).val()) {
            $(this).removeClass('border-danger');
            $(".test-warning").addClass('d-none');
            $(".an_error_exist").addClass("d-none")
        }
    });

    $testDiv.on('select', function () {
        if ($(this).val()) {
            var temp_num = "#" + $(this).attr("id") + "-warning-" + $(this).data("num");
            $(temp_num).addClass("d-none");
            $(".test-warning").addClass('d-none');
        }
    });

    // Placeholder for "Previous" button functionality
    $testPreviousButton.on('click', function () {
        // Logic to handle previous questions can be added here
    });

    let allowPageReload = false;

    // Show confirmation dialog when the user tries to leave or refresh the page
    $(window).on('beforeunload', function (e) {
        if (!allowPageReload) {
            const confirmationMessage = 'Are you sure you want to leave this page? Any unsaved changes will be lost.';
            e.returnValue = confirmationMessage; // For most browsers
            return confirmationMessage; // For some older browsers
        }
    });

    // Handle Ctrl + R key combination
    $(document).on('keydown', function (e) {
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault(); // Prevent the default reload action
            if (confirm('Are you sure you want to reload this page? Any unsaved changes will be lost.')) {
                allowPageReload = true; // Allow reload after confirmation
                location.reload(); // Reload the page if confirmed
            }
        }
    });

    // Handle click event for specific buttons that should allow reload
    $(document).on('click', '.btn-reload', function () {
        allowPageReload = true; // Set this flag to allow the page reload for these buttons
    });

    /////////////////////////////////////////////////////////////////////////////////// 
    /////////////////////////////////////////////////////////////////////////////////// 
    /////////////////////////////////////////////////////////////////////////////////// 
    /////////////////                   Previous BTN                /////////////////// 
    /////////////////////////////////////////////////////////////////////////////////// 
    /////////////////////////////////////////////////////////////////////////////////// 
    /////////////////////////////////////////////////////////////////////////////////// 
    $("#test-previous").click(function () {
        $("#test-details").addClass("d-none");
        $("#modules").removeClass("d-none");
    })

    $("#previous").click(function () {
        $("#nextSaveModule").removeClass("d-none");
        $("#btn-loader-module").addClass("d-none");
        $("#details").removeClass("d-none");
        $("#modules").addClass("d-none");
    });
    ////////////////////////////////////////////////////////////////////////////////////////////
    // Delete the course
    $("#deleteContainerSpan").click(function () {
        if (canDelete == false) {
            $("#delete-span").removeClass("d-none");
        }
    })

    $(document).click(function (event) {
        if (!$(event.target).closest("#deleteContainerSpan").length) {
            $("#delete-span").addClass("d-none");
        }
    });
    $("#confirmDelete").click(function () {
        $(this).addClass("disabled").addClass("d-none");
        $("#btn-loader-delete").removeClass("d-none");
        $("#cancelDelete").addClass("disabled");
        $.ajax({
            url: "app/addcourse_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            data: { course_ID: course_ID_to_send, purpose: "delete" },
            dataType: "json",
            success: function (response) {
                if (response.state == "delete_success") {
                    setTimeout(function () {
                        alert("This course was successfully deleted. You will be redirected to your dashboard.");
                        allowPageReload = true;
                        window.location.href = "dashboard.php";
                    }, 1000);
                } else {
                    alert("An error occurred, please try again. If it persists, contact the support team.")
                }
            }
        });
    })
});
