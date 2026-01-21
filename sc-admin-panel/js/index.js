$(document).ready(function () {
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

    
    // The stateDiv
    function statDiv(num, NAME) {
        return `<div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">  
                    <div class="border rounded shadow text-center p-auto p-md-3 fw-bold text-muted fs-7"   
                        style="height:120px; display: flex; flex-direction: column; align-items: center; justify-content: center;">  
                        <p class="p-0 m-0">${capitalizeFirstLetter(NAME)}</p>  
                        <p class="p-0 m-0 mt-1">${formatAmount(num)}</p>  
                    </div>  
                </div>`
    }

    function appendStatsToDivs(data) {
        // Clear existing stats
        $("#course-div").empty();
        $("#payment-div").empty();
        $("#certificate-div").empty();
        $("#user-div").empty();

        // Loop through each category
        for (const [category, statsArray] of Object.entries(data)) {
            let targetDiv = "";

            // Determine the target div based on the category
            switch (category) {
                case "course":
                    targetDiv = "#course-div";
                    break;
                case "users":
                    targetDiv = "#user-div";
                    break;
                case "payment":
                    targetDiv = "#payment-div";
                    break;
                case "certificate":
                    targetDiv = "#certificate-div";
                    break;
            }

            // Append each stat in the category
            statsArray.forEach(stat => {
                $(targetDiv).append(statDiv(stat.value, stat.name));
            });
        }
    }
    $.ajax({
        url: 'app/index_process.php', // PHP script to handle logout
        type: 'POST',
        data: {
            purpose: "sendIndexDetails",
        },
        success: function (response) {
            const data = JSON.parse(response);
            if (data.state === 'success') {
                appendStatsToDivs(data.data);
                setTimeout(function () {
                    $("#loader").addClass("d-none");
                    $("#main").removeClass("d-none");
                }, 1000);
            } else {
                alert('An error occurred. Please try again.');
            }
        }
    });
});