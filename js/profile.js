$(document).ready(function () {
    var currentPage = 1, course_Id = '', totalPages, max, min;
    var userinput, descriptioninput, portfolioinput, linkedininput, picture, cv, checkUser = {};

    ////////////////////////////////////////////////////////////////
    ////////////////      Create Pages Btns      ///////////////////
    //////////////////////////////////////////////////////////////// 
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


    ///////////////////////////////////////////////////////////////////////
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
    /////////////////////////////////////////////////////////////////
    //                Give Stars
    /////////////////////////////////////////////////////////////////
    function giveStars(num) {
        var full_star = `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"> <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;"/> 
        <g id="Icons1" serif:id="Icons"> <g id="Strike"> </g> <g id="H1"> </g> <g id="H2"> </g> <g id="H3"> </g> <g id="list-ul"> </g> <g id="hamburger-1"> </g> <g id="hamburger-2"> </g> <g id="list-ol"> </g> <g id="list-task"> </g> <g id="trash"> </g> <g id="vertical-menu"> </g> <g id="horizontal-menu"> </g> <g id="sidebar-2"> </g> <g id="Pen"> </g> <g id="Pen1" serif:id="Pen"> </g> <g id="clock"> </g> <g id="external-link"> </g> <g id="hr"> </g> <g id="info"> </g> <g id="warning"> 
        </g> <g id="plus-circle"> </g> <g id="minus-circle"> </g> <g id="vue"> </g> <g id="cog"> </g> <g id="logo"> </g> <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z"/> <g id="radio-check"> </g> <g id="eye-slash"> </g> <g id="eye"> </g> <g id="toggle-off"> </g> <g id="shredder"> </g> <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g> <g id="react"> </g> 
        <g id="check-selected"> </g> <g id="turn-off"> </g> <g id="code-block"> </g> <g id="user"> </g> <g id="coffee-bean"> </g> <g id="coffee-beans"> <g id="coffee-bean1" serif:id="coffee-bean"> </g> </g> <g id="coffee-bean-filled"> </g> <g id="coffee-beans-filled"> <g id="coffee-bean2" serif:id="coffee-bean"> </g> </g> <g id="clipboard"> </g> <g id="clipboard-paste"> </g> <g id="clipboard-copy"> </g> <g id="Layer1"> </g> </g> </svg>`,
            empty_star = `<svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 24 24" fill="none">
        <mask id="path-1-inside-1" fill="white">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9482 4.18011C12.7985 3.71945 12.1468 3.71945 11.9972 4.18011L10.3398 9.28092C10.2729 9.48693 10.0809 9.62641 9.86427 9.62641H4.50096C4.0166 9.62641 3.81521 10.2462 4.20707 10.5309L8.54608 13.6834C8.72132 13.8107 8.79465 14.0364 8.72771 14.2424L7.07036 19.3432C6.92068 19.8039 7.44792 20.1869 7.83978 19.9022L12.1788 16.7498C12.354 16.6224 12.5913 16.6224 12.7666 16.7498L17.1056 19.9022C17.4974 20.1869 18.0247 19.8039 17.875 19.3432L16.2177 14.2424C16.1507 14.0364 16.224 13.8107 16.3993 13.6834L20.7383 10.5309C21.1302 10.2462 20.9288 9.62641 20.4444 9.62641H15.0811C14.8645 9.62641 14.6725 9.48693 14.6056 9.28092L12.9482 4.18011ZM13.7342 11.2527L12.4994 7.79779L11.2646 11.2527H7.26858L10.5014 13.388L9.26657 16.8429L12.4994 14.7076L15.7322 16.8429L14.4974 13.388L17.7302 11.2527H13.7342Z"/>
        </mask>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9482 4.18011C12.7985 3.71945 12.1468 3.71945 11.9972 4.18011L10.3398 9.28092C10.2729 9.48693 10.0809 9.62641 9.86427 9.62641H4.50096C4.0166 9.62641 3.81521 10.2462 4.20707 10.5309L8.54608 13.6834C8.72132 13.8107 8.79465 14.0364 8.72771 14.2424L7.07036 19.3432C6.92068 19.8039 7.44792 20.1869 7.83978 19.9022L12.1788 16.7498C12.354 16.6224 12.5913 16.6224 12.7666 16.7498L17.1056 19.9022C17.4974 20.1869 18.0247 19.8039 17.875 19.3432L16.2177 14.2424C16.1507 14.0364 16.224 13.8107 16.3993 13.6834L20.7383 10.5309C21.1302 10.2462 20.9288 9.62641 20.4444 9.62641H15.0811C14.8645 9.62641 14.6725 9.48693 14.6056 9.28092L12.9482 4.18011ZM13.7342 11.2527L12.4994 7.79779L11.2646 11.2527H7.26858L10.5014 13.388L9.26657 16.8429L12.4994 14.7076L15.7322 16.8429L14.4974 13.388L17.7302 11.2527H13.7342Z" fill="#28a745"/>
        <path d="M11.9972 4.18011L11.0461 3.87109L11.0461 3.87109L11.9972 4.18011ZM12.9482 4.18011L13.8993 3.87109L13.8993 3.87109L12.9482 4.18011ZM10.3398 9.28092L9.38874 8.9719L9.38874 8.9719L10.3398 9.28092ZM4.20707 10.5309L3.61928 11.3399L3.61928 11.3399L4.20707 10.5309ZM8.54608 13.6834L7.95829 14.4924L7.95829 14.4924L8.54608 13.6834ZM8.72771 14.2424L7.77666 13.9334L7.77666 13.9334L8.72771 14.2424ZM7.07036 19.3432L6.1193 19.0342L6.1193 19.0342L7.07036 19.3432ZM7.83978 19.9022L8.42756 20.7113L8.42756 20.7113L7.83978 19.9022ZM12.1788 16.7498L12.7666 17.5588L12.7666 17.5588L12.1788 16.7498ZM12.7666 16.7498L12.1788 17.5588L12.1788 17.5588L12.7666 16.7498ZM17.1056 19.9022L16.5178 20.7113L16.5178 20.7113L17.1056 19.9022ZM17.875 19.3432L16.9239 19.6522L16.9239 19.6522L17.875 19.3432ZM16.2177 14.2424L17.1687 13.9334L17.1687 13.9334L16.2177 14.2424ZM16.3993 13.6834L15.8115 12.8744L15.8115 12.8744L16.3993 13.6834ZM20.7383 10.5309L20.1505 9.7219L20.1505 9.7219L20.7383 10.5309ZM14.6056 9.28092L15.5566 8.9719L15.5566 8.9719L14.6056 9.28092ZM12.4994 7.79779L11.5577 7.46123L12.4994 4.82656L13.4411 7.46123L12.4994 7.79779ZM13.7342 11.2527V12.2527H13.0297L12.7926 11.5893L13.7342 11.2527ZM11.2646 11.2527L12.2062 11.5893L11.9691 12.2527H11.2646V11.2527ZM7.26858 11.2527L6.71745 12.0871L3.9401 10.2527H7.26858V11.2527ZM10.5014 13.388L11.0525 12.5535L11.7071 12.9859L11.4431 13.7245L10.5014 13.388ZM9.26657 16.8429L9.8177 17.6773L7.31576 19.3298L8.32491 16.5063L9.26657 16.8429ZM12.4994 14.7076L11.9483 13.8732L12.4994 13.5092L13.0505 13.8732L12.4994 14.7076ZM15.7322 16.8429L16.6739 16.5063L17.683 19.3298L15.1811 17.6773L15.7322 16.8429ZM14.4974 13.388L13.5557 13.7245L13.2917 12.9859L13.9463 12.5535L14.4974 13.388ZM17.7302 11.2527V10.2527H21.0587L18.2813 12.0871L17.7302 11.2527ZM11.0461 3.87109C11.4951 2.48912 13.4502 2.48912 13.8993 3.87109L11.9972 4.48912C12.1468 4.94978 12.7985 4.94978 12.9482 4.48912L11.0461 3.87109ZM9.38874 8.9719L11.0461 3.87109L12.9482 4.48912L11.2909 9.58994L9.38874 8.9719ZM9.86427 8.62641C9.64766 8.62641 9.45568 8.76589 9.38874 8.9719L11.2909 9.58994C11.09 10.208 10.5141 10.6264 9.86427 10.6264V8.62641ZM4.50096 8.62641H9.86427V10.6264H4.50096V8.62641ZM3.61928 11.3399C2.44371 10.4858 3.04787 8.62641 4.50096 8.62641V10.6264C4.98532 10.6264 5.18671 10.0066 4.79485 9.7219L3.61928 11.3399ZM7.95829 14.4924L3.61928 11.3399L4.79485 9.7219L9.13386 12.8744L7.95829 14.4924ZM7.77666 13.9334C7.70972 14.1394 7.78305 14.3651 7.95829 14.4924L9.13386 12.8744C9.65959 13.2563 9.87958 13.9334 9.67877 14.5514L7.77666 13.9334ZM6.1193 19.0342L7.77666 13.9334L9.67877 14.5514L8.02141 19.6522L6.1193 19.0342ZM8.42756 20.7113C7.25199 21.5654 5.67027 20.4162 6.1193 19.0342L8.02141 19.6522C8.17109 19.1916 7.64385 18.8085 7.25199 19.0932L8.42756 20.7113ZM12.7666 17.5588L8.42756 20.7113L7.25199 19.0932L11.591 15.9407L12.7666 17.5588ZM12.1788 17.5588C12.354 17.6861 12.5913 17.6861 12.7666 17.5588L11.591 15.9407C12.1167 15.5588 12.8286 15.5588 13.3544 15.9407L12.1788 17.5588ZM16.5178 20.7113L12.1788 17.5588L13.3544 15.9407L17.6934 19.0932L16.5178 20.7113ZM18.8261 19.0342C19.2751 20.4162 17.6934 21.5654 16.5178 20.7113L17.6934 19.0932C17.3015 18.8085 16.7743 19.1916 16.9239 19.6522L18.8261 19.0342ZM17.1687 13.9334L18.8261 19.0342L16.9239 19.6522L15.2666 14.5514L17.1687 13.9334ZM16.9871 14.4924C17.1623 14.3651 17.2356 14.1394 17.1687 13.9334L15.2666 14.5514C15.0658 13.9334 15.2858 13.2563 15.8115 12.8744L16.9871 14.4924ZM21.3261 11.3399L16.9871 14.4924L15.8115 12.8744L20.1505 9.7219L21.3261 11.3399ZM20.4444 8.62641C21.8975 8.62641 22.5017 10.4858 21.3261 11.3399L20.1505 9.7219C19.7587 10.0066 19.96 10.6264 20.4444 10.6264V8.62641ZM15.0811 8.62641H20.4444V10.6264H15.0811V8.62641ZM15.5566 8.9719C15.4897 8.76589 15.2977 8.62641 15.0811 8.62641V10.6264C14.4313 10.6264 13.8553 10.208 13.6545 9.58993L15.5566 8.9719ZM13.8993 3.87109L15.5566 8.9719L13.6545 9.58994L11.9972 4.48912L13.8993 3.87109ZM13.4411 7.46123L14.6759 10.9161L12.7926 11.5893L11.5577 8.13435L13.4411 7.46123ZM10.3229 10.9161L11.5577 7.46123L13.4411 8.13435L12.2062 11.5893L10.3229 10.9161ZM7.26858 10.2527H11.2646V12.2527H7.26858V10.2527ZM9.95027 14.2224L6.71745 12.0871L7.81971 10.4183L11.0525 12.5535L9.95027 14.2224ZM8.32491 16.5063L9.55974 13.0514L11.4431 13.7245L10.2082 17.1794L8.32491 16.5063ZM13.0505 15.542L9.8177 17.6773L8.71544 16.0085L11.9483 13.8732L13.0505 15.542ZM15.1811 17.6773L11.9483 15.542L13.0505 13.8732L16.2833 16.0085L15.1811 17.6773ZM15.439 13.0514L16.6739 16.5063L14.7905 17.1794L13.5557 13.7245L15.439 13.0514ZM18.2813 12.0871L15.0485 14.2224L13.9463 12.5535L17.1791 10.4183L18.2813 12.0871ZM13.7342 10.2527H17.7302V12.2527H13.7342V10.2527Z" fill="#28a745" mask="url(#path-1-inside-1)"/>
      </svg>`,
            half_star = `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"> <g transform="matrix(1,0,0,1,-1152,-192)"> <rect id="Icons" x="0" y="0" width="1280" height="800" style="fill:none;"/>
     <g id="Icons1" serif:id="Icons"> <g id="Strike"> </g> <g id="H1"> </g> <g id="H2"> </g> <g id="H3"> </g> <g id="list-ul"> </g> <g id="hamburger-1"> </g> <g id="hamburger-2"> </g> <g id="list-ol"> </g> <g id="list-task"> </g> <g id="trash"> </g> <g id="vertical-menu"> </g> <g id="horizontal-menu"> </g> <g id="sidebar-2"> </g> <g id="Pen"> </g> <g id="Pen1" serif:id="Pen"> </g> <g id="clock"> </g> <g id="external-link"> </g> 
     <g id="hr"> </g> <g id="info"> </g> <g id="warning"> </g> <g id="plus-circle"> </g> <g id="minus-circle"> </g> <g id="vue"> </g> <g id="cog"> </g> <g id="logo"> </g> <g id="star-empty" transform="matrix(1.05152,0,0,1.05152,460.558,-59.6026)"> <path d="M693.388,264.584L710.825,264.584L696.719,274.833L702.107,291.416L688,281.167L673.893,291.416L679.281,274.833L665.175,264.584L682.612,264.584L688,248C689.796,253.528 691.592,259.056 693.388,264.584ZM688,260.391L688,276.434L694.824,281.392L692.217,273.37L699.041,268.413L690.606,268.413L688,260.391Z" style="fill-rule:nonzero;"/> </g> 
     <g id="radio-check"> </g> <g id="eye-slash"> </g> <g id="eye"> </g> <g id="toggle-off"> </g> <g id="shredder"> </g> <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g> <g id="react"> </g> <g id="check-selected"> </g> <g id="turn-off"> </g> <g id="code-block"> </g> <g id="user"> </g> <g id="coffee-bean"> </g> <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,785.021,-208.975)"> <g id="coffee-beans"> <g id="coffee-bean1" serif:id="coffee-bean"> </g> </g> </g> <g id="coffee-bean-filled"> </g> <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,913.062,-208.975)"> 
     <g id="coffee-beans-filled"> <g id="coffee-bean2" serif:id="coffee-bean"> </g> </g> </g> <g id="clipboard"> </g> <g transform="matrix(1,0,0,1,128.011,1.35415)"> <g id="clipboard-paste"> </g> </g> <g id="clipboard-copy"> </g> <g id="Layer1"> </g> </g> </g> </svg>`,
            stars = ``,
            even,
            rem,
            Feven;
        if (num % 2 == 0) {
            even = num / 2;
            Feven = Math.ceil(num / 2);
            rem = 0;
        } else {
            even = (num - 1) / 2;
            Feven = Math.ceil(num / 2);
            rem = 1;
        }
        for (var i = 1; i <= even; i++) {
            stars = stars + full_star;
        }
        if (rem == 1) {
            stars = stars + half_star;
        }
        if (Feven <= 4) {
            for (var i = Feven; i < 5; i++) {
                if (num != 9 || num != 10) {
                    stars = stars + empty_star;
                }
            }
        }
        return stars;
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
    /////////////////////////////////////////////////////////////////
    //                  TO put Years Ago
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
    //                Format Currency
    /////////////////////////////////////////////////////////////////
    function formatCurrency(value) {
        return '$' + parseFloat(value).toFixed(2);
    }
    /////////////////////////////////////////////////////////////////
    //                            Capitalizer
    /////////////////////////////////////////////////////////////////
    function capitalizeFirstLetter(statement) {
       
        // Escape the input statement  
        const escapedStatement = statement;
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
        const escapedStatement = statement;
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
    /////////////////////////////////////////////////////
    //                  Create Check
    /////////////////////////////////////////////////////
    function createUserCheckObject(user) {
        const check = {};
        if (user) {
            check.name = user.Name ? user.Name.toLowerCase() : "";
            check.description = user.Description ? user.Description.toLowerCase() : "";
            check.cvLink = user.cvLink ? user.cvLink.toLowerCase() : "";
            check.image = user.Image ? user.Image.toLowerCase() : "";
            if (Array.isArray(user.fields) && user.fields.length > 0) {
                check['fields[]'] = user.fields.map(item => item.Field).join(',');
            } else {
                check['fields[]'] = "";
            }
            check.linkedinLink = user.linkedinLink ? user.linkedinLink : "";
            check.portfolioLink = user.portfolioLink ? user.portfolioLink : "";
        }
        return check;
    }


    ////////////////////////////////////////////////////////////////
    ////////////////         Produce PDF         ///////////////////
    ////////////////////////////////////////////////////////////////
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

    ////////////////////////////////////
    // Show pdf
    $("#cvLink").click(function (e) {
        e.preventDefault(); // prevent default link behavior if it's <a>
        $("#pdf-main-container").slideToggle(300); // smooth slide up/down
        loadPDF(pdfLink);
    });

    // Extract the value of `p` from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const pValue = urlParams.get("p");
    var pdfLink,userType=null;

    if (pValue) {
        $.ajax({
            url: "app/profile_process.php",
            method: "POST",
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            data: {
                purpose: "sendOtherProfile",
                OtherUser_ID: pValue // Send the value of `p` to the backend
            },
            dataType: "json",
            success: function (response) {
                setTimeout(function () {
                    if (response.state === "success") {
                        // Assign values to elements
                        $("#username").text(capitalizeFirstLetter(response.Name));
                        $("#page-title").text(capitalizeFirstLetter(response.Name) + "'s Profile Page");
                        $("#userNameLesson").text(capitalizeFirstLetter(response.Name + "'s"));
                        $("#userprofile").attr("src", (response.Image === "" || response.Image === null ? "image/default-profile.png" : "profile/" + response.Image));
                        $("#userprofile").attr("alt", capitalizeFirstLetter(response.Name));
                        $("#description").text(
                            capitalizeFirstLetterOfPhrase(response.Description) || "No description available"
                        );
                        if (response.linkedinLink != "") {
                            $("#linkedinLink").attr("href", response.linkedinLink).removeClass("d-none");
                        }
                        if (response.portfolioLink != "") {
                            $("#portfolioLink").attr("href", response.portfolioLink).removeClass("d-none");
                        }
                        if (response.cvLink != "") {
                            $("#cvLink").removeClass("d-none");
                            pdfLink = "cv/" + response.cvLink;
                        }
                        $("#userinput").val(capitalizeFirstLetter(response.Name));
                        $("#descriptioninput").val(capitalizeFirstLetter(response.Description));
                        $("#linkedininput").val(response.linkedinLink);
                        $("#portfolioinput").val(response.portfolioLink);
                        $("#dateJoin").text("Join on the " + formatDate(response.Date));

                        // Remove these elements
                        $("#fields").remove();
                        $("#edit").remove();
                        $("#email").remove();
                        $("#field-hr").remove();
                        $("#icon-profile-container").remove();
                        $("#passwordDiv").remove();

                        $("#fullScreenLoader").addClass("d-none");
                    } else if (response.state === "error") {
                        alert("An error occurred. Please try again later. If it persists, contact the support team.");
                    } else {
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
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
            data: {
                purpose: "sendUserProfileDetails"
            },
            dataType: "json",
            success: function (response) {
                if (response.state === "success") {
                    setTimeout(function () {
                            // Assign values to elements
                        $("#username").text(capitalizeFirstLetter(response.Name));
                        $("#page-title").text(capitalizeFirstLetter(response.Name) + "'s Profile Page");
                        $("#userprofile").attr("src", (response.Image === "" || response.Image === null ? "image/default-profile.png" : "profile/" + response.Image));
                        $("#userprofile").attr("alt", capitalizeFirstLetter(response.Name));
                        $("#email").text(response.Email);
                        $("#description").text(capitalizeFirstLetterOfPhrase(response.Description) || "No description available");
                        userType = response.type;
                        if(response.type !== "s"){
                            if (response.linkedinLink != "") {
                                $("#linkedinLink").attr("href", response.linkedinLink).removeClass("d-none");
                            }
                            if (response.portfolioLink != "") {
                                $("#portfolioLink").attr("href", response.portfolioLink).removeClass("d-none");
                            }
                            if (response.cvLink != "") {
                                $("#cvLink").removeClass("d-none");
                                pdfLink = "cv/" + response.cvLink;
                            }
                            $("#descriptioninput").val(capitalizeFirstLetter(response.Description));
                            $("#linkedininput").val(response.linkedinLink);
                            $("#portfolioinput").val(response.portfolioLink);
                        }
    
                        $("#dateJoin").text("Join on the " + formatDate(response.Date));
                        $("#userinput").val(capitalizeFirstLetter(response.Name));
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
                                    var newOption = new Option(capitalizeFirstLetterOfPhrase(field.Field),
                                    capitalizeFirstLetterOfPhrase(field.Field), true, true);
                                    $(fieldSelect).append(newOption).trigger("change");
                                }
                            });
                        } else {
                            fieldsContainer.append(`<p class="text-muted">No fields available</p>`);
                        }
                        $("#fullScreenLoader").addClass("d-none");
                        checkUser = createUserCheckObject(response);
                    }, 1000);
                }else if (response.state === "error"){
                    window.location.href = "login.php";
                }
            }
        });
    }

    $('#fieldSelect').select2({
        placeholder: "Select fields",
        allowClear: true
    });
    var uploaded_image = "", uploaded_cv = "";
    $("#picture").on("change", function () {
        $(".alertProfile").text('');

        let file = this.files[0];
        let pictureWarning = $("#picture-warning");
        let saveButton = $("#save");

        if (file) {
            let allowedTypes = ["image/jpeg", "image/png"];

            // Validate file type
            if (!allowedTypes.includes(file.type)) {
                pictureWarning.text("Accepted file types: PNG and JPG images only.").removeClass("d-none");
                $(this).addClass("border-danger").val(""); // Clear input
                return;
            } else {
                pictureWarning.addClass("d-none");
                $(this).removeClass("border-danger");
            }

            // Validate file size
            if (file.size > maxFileSize) {
                pictureWarning.text("File size exceeds 2MB.").removeClass("d-none");
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
                uploaded_image = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    $("#cv").on("change", function () {
        $(".alertProfile").text('');

        let file = this.files[0];
        let cvWarning = $("#cv-warning");
        let saveButton = $("#save");

        if (file) {
            // Validate file type
            if (file.type !== "application/pdf") {
                cvWarning.text("Accepted file type: PDF document only.").removeClass("d-none");
                $(this).addClass("border-danger").val(""); // Clear input
                return;
            } else {
                cvWarning.addClass("d-none");
                $(this).removeClass("border-danger");
            }

            // Validate file size
            if (file.size > maxFileSize) {
                cvWarning.text("File size exceeds 2MB.").removeClass("d-none");
                $(this).addClass("border-danger").val(""); // Clear input
                return;
            } else {
                cvWarning.addClass("d-none");
                $(this).removeClass("border-danger");
            }

            // Read the file (if valid)
            const reader = new FileReader();
            reader.onload = function (e) {
                uploaded_cv = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    ////////////////////////////////////////////////////////////////////////
    ///// Add Protocol to the href
    function ensureAbsoluteUrl(url) {
        if (url == null || url.trim() === "") {
            return ""; // Return null or handle the case where the URL is empty  
        }
        // Check if the URL contains http or https  
        if (!/^https?:\/\//i.test(url)) {
            // Prepend https:// if the url doesn't have a protocol  
            return "https://" + url;
        }
        return url; // Return the URL as is if it already has a protocol  
    }
    $("#save").click(function () {
        // Ensure input values are absolute URLs
        userinput = $("#userinput").val();
        picture = $("#picture")[0].files[0]; // Get the file from the input with ID 'picture'];
        if(userType !== 's'){
            descriptioninput = $("#descriptioninput").val();
            portfolioinput = ensureAbsoluteUrl($("#portfolioinput").val());
            linkedininput = ensureAbsoluteUrl($("#linkedininput").val());
            cv = $("#cv")[0].files[0];
            
            
            var descriptionChanged = descriptioninput.toLowerCase() !== checkUser.description;
            var linkedinChanged = linkedininput !== checkUser.linkedinLink;
            var portfolioChanged = portfolioinput !== checkUser.portfolioLink;
            var cvChanged = cv && cv.name !== "" && cv.name !== checkUser.cvLink;
        }
        var selectedFields = $("#fieldSelect").val() || [];

        // Collect existing fields in the div 'fields' for comparison
        var currentFields = [];
        $("#fields .btn").each(function () {
            if ($(this).text().trim() !== "") {
                currentFields.push($(this).text().trim());
            }
        });

        // Check if any values are different using checkUser object
        var nameChanged = userinput.toLowerCase() !== checkUser.name;
        var fieldsChanged = !arraysEqual(selectedFields, checkUser["fields[]"].split(","));
        var pictureChanged = picture && picture.name !== "" && picture.name !== checkUser.image;
        // Prepare FormData to send to the server
        var dataToSend = new FormData();

        if (nameChanged) {
            dataToSend.append("userName", userinput);
        }
        if (descriptionChanged && userType !== 's') {
            dataToSend.append("description", descriptioninput);
        }
        if (linkedinChanged && userType !== 's') {
            dataToSend.append("linkedin", linkedininput);
        }
        if (portfolioChanged && userType !== 's') {
            dataToSend.append("portfolio", portfolioinput);
        }
        if (fieldsChanged) {
            dataToSend.append("selectedFields", selectedFields);
        }
        if (pictureChanged) {
            dataToSend.append("picture", picture);
            dataToSend.append("currentPicture", checkUser.image);
        }
        if (cvChanged && userType !== 's') {
            dataToSend.append("cv", cv);
            dataToSend.append("currentCV", checkUser.cvLink);
        }
        dataToSend.append("purpose", "save");

        // If there are any changes, send them to the server
        if (dataToSend.has("userName") || dataToSend.has("cv") || dataToSend.has("description") || dataToSend.has("portfolio") || dataToSend.has("linkedin") || dataToSend.has("selectedFields") || dataToSend.has("picture")) {
            $("#save").addClass("d-none");
            $("#save-loader").removeClass("d-none");
            $("#close-btn").prop("disabled", true);
            $(".btn-close").prop("disabled", true);

            $.ajax({
                url: "app/profile_process.php",
                method: "POST",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
                },
                data: dataToSend,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    setTimeout(function () {
                        if (response.state === "success") {
                            // Update checkUser with new values after successful update
                            if (dataToSend.has("userName")) {
                                checkUser.name = userinput;
                                $(".userName").text(capitalizeFirstLetter(userinput));
                                $("#username").text(capitalizeFirstLetter(userinput));
                                $("#page-title").text(capitalizeFirstLetter(userinput) + "'s Profile Page");
                            }
                            if (dataToSend.has("portfolio")) {
                                checkUser.portfolioLink = portfolioinput;
                                $("#portfolioLink").attr("href", portfolioinput).removeClass("d-none");
                            }
                            if (dataToSend.has("linkedin")) {
                                checkUser.linkedinLink = linkedininput;
                                $("#linkedinLink").attr("href", linkedininput).removeClass("d-none");
                            }
                            if (dataToSend.has("description")) {
                                checkUser.description = descriptioninput;
                                $("#description").text(capitalizeFirstLetterOfPhrase(descriptioninput));
                            }
                            if (uploaded_image != "") {
                                checkUser.image = picture.name;
                                $(".userImage").attr("src", uploaded_image);
                                $("#userprofile").attr("src", uploaded_image);
                                uploaded_image = "";
                            }
                            if (uploaded_cv != "") {
                                checkUser.cvLink = cv.name;
                                $("#cvLink").removeClass("d-none");
                                pdfLink = uploaded_cv;
                                loadPDF(pdfLink);

                                uploaded_cv = "";
                            }
                            if (dataToSend.has("selectedFields")) {
                                checkUser["fields[]"] = selectedFields.join(",");
                                $("#fields").empty();
                                selectedFields.forEach(field => {
                                    let fieldButton = `<button class="btn btn-secondary disabled fs-7 rounded-0 my-2 me-2">${field.trim()}</button>`;
                                    $("#fields").append(fieldButton);
                                });
                            }
                            $("#edit").modal('hide');
                            $("#save").removeClass("d-none");
                            $("#save-loader").addClass("d-none");
                            $("#close-btn").prop("disabled", false);
                            $(".btn-close").prop("disabled", false);
                        } else {
                            $(".alertProfile").text("Ops! An error occurred! Please try again. If it persists, contact the support team.");
                        }
                    }, 1000);
                }
            });
        } else {
            $(".alertProfile").text("No changes were made!");
        }
    })
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
        $(".alertProfile").text('');
    });

    $('#portfolioinput, #linkedininput, #descriptioninput').on('input', function () {
        const inputId = $(this).attr('id');
        checkCharLimit(this, `#${inputId}-warning`, otherCharLimit);
        $(".alertProfile").text('');
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
            $("#eye-confirm-password").addClass("d-none");
            $("#eye-confirm-password-slash").removeClass("d-none");
        } else {
            confirmPasswordInput.attr('type', 'password');
            $("#eye-confirm-password").removeClass("d-none");
            $("#eye-confirm-password-slash").addClass("d-none");
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
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
            },
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
                } else if (data.state === "samePassword") {
                    $("#newPassword").val("");
                    $("#confirmPassword").val("");
                    $("#alertPassword").text("New Password Must be different from old password.");
                } else if (data.state === "verified") {
                    $("#newPassword").val("");
                    $("#confirmPassword").val("");
                    $("#alertPassword").text("You recently requested password change. Please try again later.");
                } else if (data.state === "limitReached") {
                    $("#newPassword").val("");
                    $("#confirmPassword").val("");
                    $("#alertPassword").text("Sorry! You have reached the attempt limit. Please try again later.");
                } else if (data.state === "verified_recent") {
                    $("#newPassword").val("");
                    $("#confirmPassword").val("");
                    $("#alertPassword").text("Sorry! You must wait 15 minutes before requesting another code.");
                } else {
                    // 
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
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
                },
                data: {
                    purpose: "verifyPasswordCode",
                    password: password,
                    verificationCode: verificationCode
                },
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.state === "success") {
                        $("#verifyCodeBtn").addClass("disabled");
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
    /////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////
    //                  Fetch User's Courses
    /////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////
    if (pValue) {
        function fetchcoursesDetails(id, page, purpose) {
            // For showing and hiding the courses details table
            $("#course-loader").removeClass("d-none");
            $("#course-container").addClass("d-none");

            $.ajax({
                url: 'app/course_process.php', // PHP script to handle logout
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token')  // Send the stored token
                },
                data: {
                    purpose: purpose,
                    id: id,
                    page: page
                },
                dataType: "json",
                success: function (response) {
                    var elements = "";
                    setTimeout(function () {
                        if (response.state === "success") {
                            var numCourses = response.total;
                            elements = ``;
                            var cost;
                            for (var i = 0; i < response.Courses.length; i++) {
                                cost = "Free";
                                if (response.Courses[i].Cost != 0) {
                                    cost = formatCurrency(response.Courses[i].Cost)
                                }
                                $("#showing-span").text(formatAmount(numCourses));
                                $("#showing-div").removeClass("d-none");
                                var temp_class = response.Courses[i].Total_Rates <= 0 || Number(response.Courses[i].Rate) <= 0 ? "d-none" : "";
                                var element = `<div class="col-12 col-sm-6 col-lg-4 col-xl-3 my-2">
                                        <a href="displaycourse.php?v=`+ response.Courses[i].course_ID + `" style="text-decoration: none;height:450px" class="item d-grid border rounded card-h-effect text-black">
                                            <img style="width:100%; height:200px; object-fit:cover" src="covers/${response.Courses[i].Cover_image ? response.Courses[i].Cover_image : "default-cover.jpg"}" alt="` + capitalizeFirstLetter(response.Courses[i].Title) + `">
                                            <div class="px-3 px-lg-4">
                                                <h4 class="fs-6 my-1" style="word-wrap: break-word; word-break: break-all;">`+ capitalizeFirstLetter(response.Courses[i].Title) + `</h4>
                                                <p class="text-muted fs-7  fw-semibold my-0 py-1">`+ capitalizeFirstLetter(response.Courses[i].Creator_Name) + `</p>
                                                <div class="d-flex my-1 `+ temp_class + `">
                                                    <span class="text-muted me-1 fs-6 fw-semibold ">`+ response.Courses[i].Rate + `</span>
                                                    <span class="text-success ">
                                                        ` +
                                    giveStars(response.Courses[i].Rate) +
                                    `
                                                    </span>
                                                    <span class="text-muted ms-1 fs-7 fw-semibold">(`+ groupNumber(response.Courses[i].Total_Rates) + `)</span>
                                                </div>
                                                <p class="p-free p-price pb-0 fw-bold fs-7 pt-1">`+ cost + `</p>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-muted pb-0 fs-7 pt-1">`+ timeAgo(response.Courses[i].Date, response.Courses[0].Current_Date) + `</p>
                                                    <p class="text-muted pb-0 fs-7 pt-1">${response.Courses[i].Num_test != 0 ? 'With Certificate' : 'No Certificate'}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>`;
                                elements = elements + element;
                            }
                            totalPages = Math.ceil(response.total / 12); // Assuming response.total is a valid numeric value
                            max = (currentPage - 1) * 12 + response.total;
                            min = (currentPage - 1) * 12;
                            if (response.total > 12) {
                                create_pages_btn(currentPage, "", totalPages);
                                $("#btn-container").removeClass("d-none");
                            }
                            $("#course-container").removeClass("d-none").empty().append(elements);
                            $("#saved_id").removeClass("d-none");
                        } else {
                            $("#showing-span").text("0");
                            elements = `<div class="col-12"><div class="rounded border p-4 mt-lg-0 mb-5 mb-md-0">No course Found</div></div>`;
                        }

                        $("#course-loader").addClass("d-none");
                    }, 1000);
                },
            });
        }
        ////////////////////////////////////////////////////////////////////
        ///////                 course Navigation Bnts                 ///////
        ////////////////////////////////////////////////////////////////////
        // operations for prevBtn 
        $("#prevBtn").on("click", function () {
            // Ensure page doesn't go below 1
            if (currentPage > 1) {
                $("#nextBtn").addClass("disabled");
                $("#prevBtn").addClass("disabled");
                currentPage--;
                $("#pagination-Btn .pageBtn").removeClass("custom-button");
                $(`#pagination-Btn .pageBtn:contains('${currentPage}')`).addClass("custom-button");

                setTimeout(function () {
                    fetchcoursesDetails(pValue, currentPage, "sendUserCourses");
                }, 800);
            }
        });
        // operations for nextBtn
        $("#nextBtn").on("click", function () {
            // Ensure current page doesn't exceed total pages
            if (currentPage < totalcoursePages) {
                $("#nextBtn").addClass("disabled");
                $("#prevBtn").addClass("disabled");

                currentPage++;

                $("#pagination-Btn .pageBtn").removeClass("custom-button");
                $(`#pagination-Btn .pageBtn:contains('${currentPage}')`).addClass("custom-button");
                setTimeout(function () {
                    fetchcoursesDetails(pValue, currentPage, "sendUserCourses");
                }, 800);
            }
        });
        // operations for in between prevBtn and nextBtn
        $("#pagination-Btn").on("click", ".pageBtn", function () {
            $("#pagination-Btn .pageBtn").removeClass("custom-button");
            $(this).addClass("custom-button");
            currentPage = $(this).text();
            setTimeout(function () {
                fetchcoursesDetails(pValue, currentPage, "sendUserCourses");
            }, 800);
        });

        ////////////////////////////////////////////////////////////
        // Initial Start
        fetchcoursesDetails(pValue, currentPage, "sendUserCourses");
    }
});
