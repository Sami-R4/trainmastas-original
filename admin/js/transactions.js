$(document).ready(function () {
    var transactionCurrentPage = 1, transaction_Id = '', totaltransactionPages, transactionMax, transactionTab = "course_payment", filterValue1 = "", filterValue2 = "", registeredCurrentPage = 1, createdCurrentPage = 1, feedbackCurrentPage = 1, totalfeedbackPages, totalRegisteredPages, totalCreatedPages, feedbackMax, registeredMax, createdMax, fetchtransactions = false;
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
    function Displaytransaction(transactions, purpose) {
        let transactionDiv = $("#transaction-div");
        if (num >= transactions.total_Transactions || num >= transactionMax) {
            num = 0;
        }
        let display = "";
        if (purpose === "deletedtransactions") {
            display = "d-none";
            $(".hideThisLoader").addClass("d-none");
        }
        $("#total_count").text("Showing " + formatAmount(transactions.total_Transactions) + " items");

        transactions.transactions.forEach(transaction => {
            let img = transaction.Image ? `../profile/${transaction.Image}` : "../image/default-profile.png";
            let state = "";
            if (transaction.status === 'failed') {
                state = "Failed";
            } else if (transaction.status == 'success') {
                state = "Ready";
            } else if (transaction.status == 'pending') {
                state = "Pending";
            } else if (transaction.approved_date) {
                state = "Withdrew";
            } else {
                state = "Not Withdrawn";
            }
            let temp_url = "teachers.php?c=";
            if (transaction.type == "s") {
                temp_url = "students.php?c=";
            }
            let courseTitle = "N/A";
            if (transaction.Title) {
                courseTitle = `<a href="courses.php?c=${transaction.course_ID}"  target="_blank" class="hover text-black">${capitalizeFirstLetter(transaction.Title)}</a>`
            }
            let transactionRow = `
                <tr id="transaction-element-${++num}">
                    <th scope="row">${num}</th>
                    <td><a href="${temp_url + transaction.user_ID}" target="_blank" class="hover text-black">
                        <img src="${img}" alt="${transaction.Name}" class="rounded-circle me-1" style="width:30px; height:30px; object-fit:cover">
                        <span>${capitalizeFirstLetter(transaction.Name)}</span>
                        </a>
                    </td>
                    <td  class="profile-link" data-transaction_id="${transaction.payment_ID}" data-num="${num}" id="profile-link-${num}">${(transaction.Purpose === "cer") ? "Certificate" : "Course Fee"}</td>
                    <td>${transaction.Payment_method?capitalizeFirstLetter(transaction.Payment_method):'N/A'}</td>
                    <td>${courseTitle}</td>
                    <td class="text-center">
                    ${state}
                    </td>
                    <td>${formatDate(transaction.Date)}</td>
                </tr>`;

            transactionDiv.append(transactionRow);
        });

        $("#btn-containertransaction").addClass("d-none");

        if (transactions.total_Transactions > 20) {
            let tempVal = transactionMax ?? transactions.total_Transactions;
            totaltransactionPages = Math.ceil(tempVal / 20);
            transactionMax = transactions.total_Transactions;
            create_pages_btn(transactionCurrentPage, "transaction", totaltransactionPages);
            $("#btn-containertransaction").removeClass("d-none");
        }
    }
    function updatetransactionProfileAndFields(response) {
        // Update transaction details
        $("#transactionname").text(capitalizeFirstLetter(response.transaction.Name));
        let temp_url = "teachers.php?c=";
        if (response.transaction.type == "s") {
            temp_url = "students.php?c=";
        }
        $("#transactionname").attr("href", temp_url + response.transaction.user_ID);

        // Profile Image
        $("#transactionprofile").attr("src", response.transaction.Image ? "../profile/" + response.transaction.Image : "../image/default-profile.png");
        $("#transactionprofile").attr("alt", capitalizeFirstLetter(response.transaction.Name));

        // Payment Method
        $("#Payment_method").text(response.transaction.Payment_method ? capitalizeFirstLetter(response.transaction.Payment_method) : "N/A");

        // Purpose of Transaction
        $("#Purpose").text(response.transaction.Purpose === "cer" ? "Certificate" :  response.transaction.Purpose === "fee" ? "Course Fee" : "N/A");

        // Transaction State
        let state = "";
        if (response.transaction.status == 'failed') {
            state = "Failed";
        } else if (response.transaction.status == 'success') {
            state = "Successful";
        }else if (response.transaction.approved_date) {
            state = "Withdrew";
        } else if (response.transaction.status == 'pending') {
            state = "Pending";
        } else {
            state = "Not Withdrawn";
        }
        $("#State").text(state);
        if (response.transaction.Title) {
            $("#Title").text(capitalizeFirstLetter(response.transaction.Title));
            $("#Title").attr("href", "courses.php?c=" + response.transaction.course_ID);
        }
        // Transaction Date
        $("#dateJoin").text("Transaction Date: " + formatDate(response.transaction.Date));
    }



    ////////////////////////////////////////////////////////////////////
    ///////             Fetch the transactions details                  ///////
    ////////////////////////////////////////////////////////////////////
    function fetchtransactionsDetails(id, page, purpose, filterValue1, filterValue2) {
        // For showing and hiding the transactions details table
        if (id == "") {
            $("#transaction-div").empty();
            $("#transaction-loader").removeClass("d-none");
            $("#transaction-container-table").addClass("d-none");
            $("#transaction-message").addClass("d-none");
        }

        $.ajax({
            url: 'app/Transactions_process.php', // PHP script to handle logout
            type: 'POST',
            data: {
                purpose: purpose,
                id: id,
                page: page,
                filterValue1: filterValue1,
                filterValue2: filterValue2,
            },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.state === 'success') {
                    fetchtransactions = true;
                    Displaytransaction(data, purpose);
                    setTimeout(function () {
                        $("#transaction-loader").addClass("d-none");
                        if (data.total_Transactions == 0) {
                            $("#transaction-container-table").addClass("d-none");
                            $("#message-empty").removeClass("d-none");
                        } else {
                            $("#transaction-container-table").removeClass("d-none");
                        }
                    }, 1000);
                } else if (data.state === 'notransaction') {
                    setTimeout(function () {
                        $("#transaction-loader").addClass("d-none");
                        $("#transaction-message").removeClass("d-none").text("No Admin found.");
                    }, 1000);
                } else if (data.state === "successFetching") {
                    setTimeout(function () {
                        $("#profile-loader-student").addClass("d-none");
                        $("#entire-profile-div").removeClass("d-none");
                        $("#page-title").text(capitalizeFirstLetter(data.transaction.Name) + "'s Profile setting.");
                        updatetransactionProfileAndFields(data);
                    }, 1000);
                } else if (data.state === "deleted_success") {
                    $('#confirmClearModal').modal('hide');
                    $("#clearAllDeleted").css("display", "none");
                    // Show the message  
                    $('#message').text("Admin cleared successfully!").fadeIn(1000);
                    setTimeout(function () {
                        $("#transaction-loader").addClass("d-none");
                        $("#transaction-message").removeClass("d-none").text("No transaction found.");
                        $('#message').fadeOut(1000); // 1000 ms = 1 second to fade out  
                    }, 1000); // Wait 2 seconds before starting to fade out
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
                    $('#message').text("transactions not found. You will be redirected.").fadeIn(1000);
                    $(".profile-btn").addClass("d-none");
                    $("#profile-container").addClass("d-none");
                    $("#transaction-container-table").addClass("d-none");
                    $("#transaction-container").removeClass("d-none");
                    $("#transaction-loader").removeClass("d-none");
                    var url = new URL(window.location);
                    url.searchParams.delete('c'); // Remove the 'c' parameter from the URL
                    window.history.replaceState({}, document.title, url); // Update the URL without reloading the page
                    if (fetchtransactions == false) {
                        fetchtransactionsDetails("", transactionCurrentPage, transactionTab, filterValue1, filterValue2);
                    } else {
                        setTimeout(function () {
                            $("#transaction-container-table").removeClass("d-none");
                            $("#transaction-loader").addClass("d-none");
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
    $("#transaction-div").empty();
    var urlParams = new URLSearchParams(window.location.search);
    var cValue = urlParams.get('c');
    if (cValue) {
        transaction_Id = cValue;
        $("#action-ban-btn").data("transaction_id", transaction_Id);
        $("#action-delete-btn").data("transaction_id", transaction_Id);
        $(".profile-btn").removeClass("d-none");
        $("#transaction-container").addClass("d-none");
        $("#profile-container").removeClass("d-none");
        fetchtransactionsDetails(transaction_Id, "", "sentThisDetails", "");
    } else {
        $("#page-title").text("Transactions Management")
        fetchtransactionsDetails("", '1', "course_payment", filterValue1, filterValue2);
    }

    ////////////////////////////////////////////////////////////////////
    ///////                 transaction Navigation Bnts                 ///////
    ////////////////////////////////////////////////////////////////////
    // operations for prevBtn 
    $("#prevBtntransaction").on("click", function () {
        // Ensure page doesn't go below 1
        if (transactionCurrentPage > 1) {
            $("#nextBtntransaction").addClass("disabled");
            $("#prevBtntransaction").addClass("disabled");
            var containerTop = $("#transactionDiv").offset().top;
            $("html, body").scrollTop(containerTop);
            transactionCurrentPage--;
            $("#pagination-Btntransaction .pageBtn").removeClass("custom-button");
            $(`#pagination-Btntransaction .pageBtn:contains('${transactionCurrentPage}')`).addClass("custom-button");

            setTimeout(function () {
                fetchtransactionsDetails("", transactionCurrentPage, "course_payment", filterValue1, filterValue2);
            }, 800);
        }
    });

    // operations for nextBtn
    $("#nextBtntransaction").on("click", function () {
        // Ensure current page doesn't exceed total pages
        if (transactionCurrentPage < totaltransactionPages) {
            $("#nextBtntransaction").addClass("disabled");
            $("#prevBtntransaction").addClass("disabled");
            var containerTop = $("#transactionDiv").offset().top;
            $("html, body").scrollTop(containerTop);

            transactionCurrentPage++;

            $("#pagination-Btntransaction .pageBtn").removeClass("custom-button");
            $(`#pagination-Btntransaction .pageBtn:contains('${transactionCurrentPage}')`).addClass("custom-button");
            setTimeout(function () {
                fetchtransactionsDetails("", transactionCurrentPage, "course_payment", filterValue1, filterValue2);
            }, 800);
        }
    });
    // operations for in between prevBtn and nextBtn
    $("#pagination-Btntransaction").on("click", ".pageBtn", function () {
        $("#pagination-Btntransaction .pageBtn").removeClass("custom-button");
        $(this).addClass("custom-button");
        transactionCurrentPage = $(this).text();
        var containerTop = $("#transactionDiv").offset().top;
        $("html, body").scrollTop(containerTop);
        setTimeout(function () {
            fetchtransactionsDetails("", transactionCurrentPage, "course_payment", filterValue1, filterValue2);
        }, 800);
    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////    End Pagination btns    ///////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Press enter on the filter by registered course
    $("#transactionState").on("change", function (event) {
        num = 0;
        filterValue1 = $(this).val(); // Collect the input value  
        $("#message-empty").addClass("d-none");
        transactionCurrentPage = 1;
        fetchtransactionsDetails("", transactionCurrentPage, transactionTab, filterValue1, filterValue2);
    });
    $('#transactionType').on('change', function () {
        num = 0;
        $("#message-empty").addClass("d-none");
        filterValue2 = $(this).val(); // Get the selected value  
        transactionCurrentPage = 1;
        fetchtransactionsDetails("", transactionCurrentPage, transactionTab, filterValue1, filterValue2);
    });
    $(".transaction-navLinks").click(function () {
        $("#message-empty").addClass("d-none");
        $("#clearAllDeleted").css("display", "none");
        num = 0;
        transactionTab = $(this).data("id");
        transactionCurrentPage = 1;
        $("#transactionState").val("");
        $("#transactionType").val("");
        filterValue1 = "";
        filterValue2 = "";
        fetchtransactionsDetails("", transactionCurrentPage, transactionTab, filterValue1, filterValue2);
        $(".transaction-navLinks").removeClass("active-transaction-navLinks");
        $(this).addClass("active-transaction-navLinks");
    })
    $("#confirmClear").click(function () {
        fetchtransactionsDetails("", "", "clearAll", "");
    })

    var temp_container_element_id, temp_container_btn, temp_container_btn_value;
    $("#transaction-div").on("click", ".profile-link", function () {
        $("#message-empty").addClass("d-none");
        var num = $(this).data("num");
        transaction_Id = $(this).data("transaction_id");
        var temp_element_id = "#profile-link-" + num;
        $("#action-delete-btn").data("num", num).data("transaction_id", transaction_Id);
        $("#action-ban-btn").data("num", num).data("transaction_id", transaction_Id);
        $(".profile-btn").removeClass("d-none");
        $("#profile-container").removeClass("d-none");
        $("#profile-loader-student").removeClass("d-none");
        $("#entire-profile-div").addClass("d-none");
        $("#transaction-container").addClass("d-none");
        // Assuming transaction_Id is defined and your variable is named correctly  
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        params.set('c', transaction_Id); // Update or add the 'c' parameter  
        url.search = params.toString();
        // Use history.replaceState to update the URL without reloading  
        history.replaceState(null, '', url.toString());

        fetchtransactionsDetails(transaction_Id, "", "sentThisDetails", "");
    })
    $("#admin-btn").on("click", function () {

        $("#message-empty").addClass("d-none");
        $(".transaction-profile-btn-div").removeClass("d-none");
        $(".profile-btn").addClass("d-none");
        $("#profile-container").addClass("d-none");
        $("#transaction-container-table").addClass("d-none");
        $("#transaction-container").removeClass("d-none");
        $("#transaction-loader").removeClass("d-none");
        var url = new URL(window.location);
        url.searchParams.delete('c'); // Remove the 'c' parameter from the URL
        window.history.replaceState({}, document.title, url); // Update the URL without reloading the page  
        if (fetchtransactions == false) {
            filterValue1 = "";
            filterValue2 = "";
            transactionTab = "course_payment";
            fetchtransactionsDetails("", '1', "course_payment", filterValue1, filterValue2);
            $("#page-title").text("Teacher Management")
        }
        setTimeout(function () {
            $("#transaction-loader").addClass("d-none");
            $("#transaction-container-table").removeClass("d-none");
        }, 800);
    })

})