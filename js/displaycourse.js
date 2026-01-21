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
//                          Remove /$$**$$/
/////////////////////////////////////////////////////////////////
function replacePatternWithSpace(content) {
    // Replace all occurrences of /$$**$$/ with space
    var replacedContent = content.replace(/\/\$\$\*\*\$\$\//g, " ");

    // Return the output which is an html tag
    return replacedContent;
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

/////////////////////////////////////////////////////////////////
//                            Capitalizer
/////////////////////////////////////////////////////////////////
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
//                Replace Space with underscore
/////////////////////////////////////////////////////////////////
function replaceSpaceWithUnderscore(text) {
    return text.replace(" ", "_");
}
/////////////////////////////////////////////////////////////////
//                Format Currency
/////////////////////////////////////////////////////////////////
function formatCurrency(value) {
    return '$' + parseFloat(value).toFixed(2);
}
/////////////////////////////////////////////////////////////////
//               Group Numbers
/////////////////////////////////////////////////////////////////
function groupNumber(num) {
    if (num < 1000) {
        return num.toString();
    } else if (num < 10000) {
        return Math.floor(num / 1000) + 'k';
    } else if (num < 100000) {
        return Math.floor(num / 1000) + 'K';
    } else if (num < 1000000) {
        return Math.floor(num / 1000) + 'K';
    } else if (num < 10000000) {
        return (num / 1000000).toFixed(1) + 'M'; // One decimal place  
    } else if (num < 1000000000) {
        return (num / 1000000).toFixed(1) + 'M'; // One decimal place  
    } else if (num < 10000000000) {
        return (num / 1000000000).toFixed(1) + 'B'; // One decimal place  
    } else {
        return (num / 1000000000).toFixed(1) + 'B'; // One decimal place  
    }
}
$(document).ready(function () {
    var url = window.location.href, course_ID, premium = false;
    if (url.includes("?v=")) {
        var params = new URLSearchParams(window.location.search);
        course_ID = params.get("v");
        $.ajax({
            url: "app/displaycourse_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            data: { course_ID: course_ID, purpose: "getCourseById" },
            dataType: "json",
            success: function (response) {
                var elements = "";
                setTimeout(function () {
                    if (response.state === "success") {
                        var cost = "Free", show_id = "";
                        if (response.Course.Cost != 0) {
                            cost = formatCurrency(response.Course.Cost);
                            premium = true;
                        }
                        var elements = '';
                        if (response.Course.Scopes != "none") {
                            for (var i = 0; i < response.Course.Scopes.length; i++) {
                                var element = ` <button class="btn btn-secondary disabled fs-7 rounded-0 my-2">` + response.Course.Scopes[i].Scope + `</button>`;
                                elements = elements + element;
                            }
                        } else {
                            $("#course_scope").remove();
                        }
                        var temp_course_img = response.Course.Cover_image ? response.Course.Cover_image : "default-cover.jpg";
                        $("#cover_image").attr("src", "covers/" + temp_course_img).attr("alt", capitalizeFirstLetter(response.Course.Title));
                        $("#course_creator_image").attr("src", response.Course.Creator_image ? "profile/" + response.Course.Creator_image : "image/default-profile.png").attr("alt", capitalizeFirstLetter(response.Course.Creator_Name));
                        $("#course_title").text(capitalizeFirstLetter(response.Course.Title));
                        $("#get_started").attr("href", "buycourse.php?i=" + response.Course.course_ID);
                        if (response.Course.isForUser == "yes") {
                            $(".get_started").remove();
                        }
                        $("#courseTitle").text(capitalizeFirstLetter(response.Course.Title));
                        $("#course_scope").empty().append(elements);
                        $("#course_price").text(cost);
                        $("#course_modules").text(response.Course.Modules + capitalizeFirstLetter(" Modules"));
                        $("#course_description").append(convertTextToParagraphs(capitalizeFirstLetterOfPhrase(response.Course.Description)));
                        $("#course_creator_name").text(capitalizeFirstLetter(response.Course.Creator_Name))
                        $("#course_creator_link").attr("href", "profile.php?p=" + response.Course.user_ID); 
                        $("#date_posted").text(timeAgo(new Date(response.Course.Date), new Date(response.Course.Current_Date)));
                        $("#fullScreenLoader").addClass("d-none");
                        $("#certificate").text(response.Course.Num_test != 0 ? 'With Certificate' : 'No Certificate');
                        if (response.Course.is_registered && response.Course.is_registered == 1) {
                            $("#get_started_1").addClass("d-none");
                            $("#go_to_course").attr("href","viewcourse.php?v="+course_ID).removeClass("d-none");
                        };
                        $("#page").removeClass("d-none");
                    } else if (response.state === "notfound") {
                        alert("Course was not found. You will be redirected to the course page.");
                        window.location.href = "courses.php";
                    } else {
                        alert("An error occurred. Please try again. If it persist, contact the support team.")
                    }
                }, 1000);


            },
        });
    } else {
        window.location.href = "courses.php";
    }
    $("#get_started").on("click", function () {
        $(this).prop("disabled", true);
        $.ajax({
            url: "app/displaycourse_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            data: { course_ID: course_ID, purpose: "register" },
            dataType: "json",
            success: function (response) {
                setTimeout(function () {
                    if (response.state === "success") {
                        $("#registerModal").modal("hide");
                        setTimeout(function () {
                            alert("Successfully registered for this course. You will be redirected to it.");
                            window.location.href = "viewcourse.php?v=" + course_ID;
                        }, 50);
                    } else if (response.state === "recharge") {
                        $("#get_started").prop("disabled", false);
                        $("#registerModal").modal("hide");
                        $("#rechargeModal").modal("show");
                    } else {
                        $("#registerModal").modal("hide");
                        setTimeout(function () {
                            alert(response.message);
                        }, 50);
                        $("#get_started").prop("disabled", false);
                    }
                }, 1000);
            },
        });
    })
})