<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="./image/logo.png">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
    <title>Verify Certificate - TrainMastas</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white position-fixed w-100" style="border-bottom:1px solid gainsboro;z-index:200">
        <div class="container-fluid">
            <a class="navbar-brand mx-3 logo" href="index.php"><img src="image/logo.png" width="40px" alt="logo"><span class="fw-semibold ms-2 text-success">TrainMastas</span></a>
        </div>
    </nav>
    <!--------------------------------------------------------------------------------------------
                                            Main Section
    ---------------------------------------------------------------------------------------------->
    <main>

        <div class="container text-center" style="padding-top: 160px;padding-bottom: 110px;">
            <h1 style="font-size:50px">Certificate Verification</h1>
            <div class="mt-5 fs-4 col-12 col-md-10 mx-auto">Welcome to the official TrainMastas Certificate Verification Portal.
                You can easily verify the authenticity of any certificate issued by TrainMastas. To get started, click the "Verify Certificate" button below and follow the prompts..
            </div>
            <div class="mt-5">
                <button class="btn btn-outline-success rounded-0 fs-5 me-4 mt-3">Explore TrainMastas</button>
                <button class="btn btn-outline-success rounded-0 fs-5 mt-3" data-bs-toggle="modal" data-bs-target="#verifyModal">Verify Certificate</button>
            </div>
        </div>
    </main>
    <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalLabel">Verify Certificate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-btn-modal"></button>
                </div>
                <div class="modal-body">
                    <div id="section1">
                        Enter certificate code
                        <input type="text" class="form-control rounded-0 mt-3" name="" id="inputCode">
                    </div>
                    <div id="section2" class="mt-4 d-none">
                        <div class="text-success">Valid Certificate</div>
                        <div class="row">
                            <div class="text-center col-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100px" height="100px" viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_429_11195)">
                                        <path d="M15 22L14.3066 23.0401C14.6902 23.2958 15.1834 23.3196 15.5898 23.1021C15.9963 22.8846 16.25 22.461 16.25 22H15ZM12 20L12.6934 18.96C12.2735 18.68 11.7265 18.68 11.3066 18.96L12 20ZM9.00002 22H7.75002C7.75002 22.461 8.00375 22.8846 8.41019 23.1021C8.81664 23.3196 9.30982 23.2958 9.69339 23.0401L9.00002 22ZM8.75086 3.53713L8.65048 4.7831L8.75086 3.53713ZM10.4347 2.83967L9.48267 2.02962L9.48267 2.02962L10.4347 2.83967ZM6.53191 5.68606L5.28595 5.78644L6.53191 5.68606ZM8.68606 3.53191L8.78644 2.28595L8.68606 3.53191ZM5.83967 7.43468L6.64972 8.38669L6.64972 8.38668L5.83967 7.43468ZM6.53713 5.75086L7.7831 5.65048L6.53713 5.75086ZM5.79016 10.5232L4.98011 11.4752L4.98012 11.4752L5.79016 10.5232ZM5.79016 7.4768L4.98012 6.52479L4.98011 6.5248L5.79016 7.4768ZM6.53713 12.2492L5.29117 12.1488L5.29117 12.1488L6.53713 12.2492ZM5.83967 10.5654L6.64972 9.61335L6.64972 9.61334L5.83967 10.5654ZM8.68606 14.4681L8.78644 15.7141H8.78644L8.68606 14.4681ZM6.53191 12.314L7.77788 12.4143L7.77788 12.4143L6.53191 12.314ZM10.4347 15.1604L11.3867 14.3503L11.3867 14.3503L10.4347 15.1604ZM8.75086 14.4629L8.65048 13.2169H8.65048L8.75086 14.4629ZM13.5232 15.2099L14.4752 16.0199L14.4752 16.0199L13.5232 15.2099ZM10.4768 15.2099L9.52479 16.0199L9.5248 16.0199L10.4768 15.2099ZM15.2492 14.4629L15.3496 13.2169H15.3496L15.2492 14.4629ZM13.5654 15.1604L12.6133 14.3503L12.6133 14.3503L13.5654 15.1604ZM17.4681 12.314L18.7141 12.2136V12.2136L17.4681 12.314ZM15.314 14.4681L15.2136 15.7141H15.2136L15.314 14.4681ZM18.1604 10.5654L18.9704 11.5174L18.9704 11.5174L18.1604 10.5654ZM17.4629 12.2492L16.2169 12.3496V12.3496L17.4629 12.2492ZM18.2099 7.4768L19.0199 6.5248L19.0199 6.5248L18.2099 7.4768ZM18.2099 10.5232L17.3998 9.57122L17.3998 9.57122L18.2099 10.5232ZM17.4629 5.75086L16.2169 5.65048V5.65048L17.4629 5.75086ZM18.1604 7.43468L17.3503 8.38668L17.3503 8.38668L18.1604 7.43468ZM15.314 3.53191L15.2136 2.28595L15.2136 2.28595L15.314 3.53191ZM17.4681 5.68606L18.7141 5.78644V5.78644L17.4681 5.68606ZM13.5654 2.83967L14.5174 2.02962L14.5174 2.02962L13.5654 2.83967ZM15.2492 3.53713L15.3496 4.7831L15.3496 4.7831L15.2492 3.53713ZM13.5232 2.79016L12.5712 3.60021L12.5712 3.60022L13.5232 2.79016ZM10.4768 2.79016L11.4288 3.60021L11.4288 3.60021L10.4768 2.79016ZM9.00002 14.4584L9.05526 13.2096L9.00002 14.4584ZM15.6934 20.96L12.6934 18.96L11.3066 21.0401L14.3066 23.0401L15.6934 20.96ZM11.3066 18.96L8.30664 20.96L9.69339 23.0401L12.6934 21.0401L11.3066 18.96ZM12.5712 3.60022L12.6134 3.64973L14.5174 2.02962L14.4752 1.98011L12.5712 3.60022ZM15.3496 4.7831L15.4144 4.77788L15.2136 2.28595L15.1488 2.29117L15.3496 4.7831ZM16.2222 5.58568L16.2169 5.65048L18.7089 5.85124L18.7141 5.78644L16.2222 5.58568ZM17.3503 8.38668L17.3998 8.42881L19.0199 6.5248L18.9704 6.48267L17.3503 8.38668ZM17.3998 9.57122L17.3503 9.61335L18.9704 11.5174L19.0199 11.4752L17.3998 9.57122ZM16.2169 12.3496L16.2222 12.4144L18.7141 12.2136L18.7089 12.1488L16.2169 12.3496ZM15.4144 13.2222L15.3496 13.2169L15.1488 15.7089L15.2136 15.7141L15.4144 13.2222ZM12.6133 14.3503L12.5712 14.3998L14.4752 16.0199L14.5174 15.9704L12.6133 14.3503ZM11.4288 14.3998L11.3867 14.3503L9.48266 15.9704L9.52479 16.0199L11.4288 14.3998ZM8.65048 13.2169L8.58568 13.2222L8.78644 15.7141L8.85124 15.7089L8.65048 13.2169ZM7.77788 12.4143L7.7831 12.3495L5.29117 12.1488L5.28595 12.2136L7.77788 12.4143ZM6.64972 9.61334L6.60021 9.57122L4.98012 11.4752L5.02963 11.5174L6.64972 9.61334ZM6.60021 8.42881L6.64972 8.38669L5.02963 6.48266L4.98012 6.52479L6.60021 8.42881ZM7.7831 5.65048L7.77788 5.58568L5.28595 5.78644L5.29117 5.85124L7.7831 5.65048ZM8.58568 4.77788L8.65048 4.7831L8.85124 2.29117L8.78644 2.28595L8.58568 4.77788ZM11.3867 3.64972L11.4288 3.60021L9.5248 1.98011L9.48267 2.02962L11.3867 3.64972ZM8.65048 4.7831C9.69169 4.86698 10.7098 4.44528 11.3867 3.64972L9.48267 2.02962C9.32645 2.21321 9.09152 2.31053 8.85124 2.29117L8.65048 4.7831ZM7.77788 5.58568C7.74077 5.12504 8.12504 4.74077 8.58568 4.77788L8.78644 2.28595C6.79035 2.12514 5.12514 3.79035 5.28595 5.78644L7.77788 5.58568ZM6.64972 8.38668C7.44528 7.70975 7.86698 6.69169 7.7831 5.65048L5.29117 5.85124C5.31053 6.09152 5.21321 6.32645 5.02962 6.48267L6.64972 8.38668ZM6.60021 9.57122C6.24825 9.27174 6.24825 8.72829 6.60021 8.42881L4.98011 6.5248C3.45495 7.82253 3.45495 10.1775 4.98011 11.4752L6.60021 9.57122ZM7.7831 12.3496C7.86698 11.3083 7.44528 10.2903 6.64972 9.61335L5.02962 11.5174C5.21321 11.6736 5.31053 11.9085 5.29117 12.1488L7.7831 12.3496ZM8.58568 13.2222C8.12504 13.2593 7.74077 12.875 7.77788 12.4143L5.28595 12.2136C5.12514 14.2097 6.79035 15.8749 8.78644 15.7141L8.58568 13.2222ZM12.5712 14.3998C12.2717 14.7518 11.7283 14.7518 11.4288 14.3998L9.5248 16.0199C10.8225 17.5451 13.1775 17.5451 14.4752 16.0199L12.5712 14.3998ZM16.2222 12.4143C16.2593 12.875 15.875 13.2593 15.4143 13.2222L15.2136 15.7141C17.2097 15.8749 18.8749 14.2097 18.7141 12.2136L16.2222 12.4143ZM17.3503 9.61335C16.5547 10.2903 16.1331 11.3083 16.2169 12.3496L18.7089 12.1488C18.6895 11.9085 18.7868 11.6736 18.9704 11.5174L17.3503 9.61335ZM17.3998 8.42881C17.7518 8.72829 17.7518 9.27174 17.3998 9.57122L19.0199 11.4752C20.5451 10.1775 20.5451 7.82253 19.0199 6.5248L17.3998 8.42881ZM16.2169 5.65048C16.1331 6.69169 16.5547 7.70975 17.3503 8.38668L18.9704 6.48267C18.7868 6.32645 18.6895 6.09152 18.7089 5.85124L16.2169 5.65048ZM15.4144 4.77788C15.875 4.74077 16.2593 5.12504 16.2222 5.58568L18.7141 5.78644C18.8749 3.79035 17.2097 2.12514 15.2136 2.28595L15.4144 4.77788ZM12.6133 3.64972C13.2903 4.44528 14.3083 4.86698 15.3496 4.7831L15.1488 2.29117C14.9085 2.31053 14.6736 2.21321 14.5174 2.02962L12.6133 3.64972ZM14.4752 1.98011C13.1775 0.454954 10.8225 0.454952 9.5248 1.98011L11.4288 3.60021C11.7283 3.24825 12.2717 3.24825 12.5712 3.60021L14.4752 1.98011ZM11.3867 14.3503C10.7978 13.6583 9.95101 13.2492 9.05526 13.2096L8.94477 15.7072C9.15141 15.7163 9.34686 15.8108 9.48267 15.9704L11.3867 14.3503ZM9.05526 13.2096C8.9211 13.2037 8.78593 13.206 8.65048 13.2169L8.85124 15.7089C8.88266 15.7063 8.91388 15.7058 8.94477 15.7072L9.05526 13.2096ZM10.25 22V14.4584H7.75002V22H10.25ZM15.3496 13.2169C15.2141 13.206 15.0789 13.2037 14.9448 13.2096L15.0553 15.7072C15.0861 15.7058 15.1174 15.7063 15.1488 15.7089L15.3496 13.2169ZM14.9448 13.2096C14.049 13.2492 13.2022 13.6583 12.6133 14.3503L14.5174 15.9704C14.6532 15.8108 14.8486 15.7163 15.0553 15.7072L14.9448 13.2096ZM13.75 14.4584V22H16.25V14.4584H13.75Z" fill="#198754" />
                                        <path d="M14 8L11 11L10 10" stroke="#198754" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_429_11195">
                                            <rect width="24" height="24" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <div class="col-8">
                                <div class="mt-2">Student: <span id="name" class="fw-semibold">Ngoupayou Habil</span>
                                </div>
                                <div class="mt-2">Course: <span id=" Title" class="fw-semibold">Master Coding</span>
                                </div>
                                <div class="mt-2">Teacher: <span id="Mentor" class="fw-semibold">Kenne Ruby</span>
                                </div>
                                <div class="mt-2">Issued Date: <span id="Date" class="fw-semibold">Today</span>
                                </div>
                                <div class="mt-2">Expiring Date: <span id="expiredDate" class="fw-semibold">Today</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="section3" class="mt-4 d-none">
                        <div style="color:red">Invalid Certificate</div>
                        <div class="row">
                            <div class="text-center col-6">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="red" width="130px" height="130px" viewBox="0 0 200 200" data-name="Layer 1" id="Layer_1">
                                    <title />
                                    <path d="M100,15a85,85,0,1,0,85,85A84.93,84.93,0,0,0,100,15Zm0,150a65,65,0,1,1,65-65A64.87,64.87,0,0,1,100,165Z" />
                                    <path d="M128.5,74a9.67,9.67,0,0,0-14,0L100,88.5l-14-14a9.9,9.9,0,0,0-14,14l14,14-14,14a9.9,9.9,0,0,0,14,14l14-14,14,14a9.9,9.9,0,0,0,14-14l-14-14,14-14A10.77,10.77,0,0,0,128.5,74Z" />
                                </svg>
                            </div>
                            <div class="col-6">
                                The certificate you entered is invalid and doesn't match our records. Please check the verification code for accuracy. If it's correct, then the certificate is fake.
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button id="verify" class="btn btn-success rounded-0">Verify</button>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $("#close-btn-modal").click(function() {
                    $("#section2").addClass("d-none");
                    $("#section3").addClass("d-none");
                    $("#inputCode").val('');
                })

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

                function formatDate(date) {
                    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    let d = new Date(date);
                    let day = d.getDate();
                    let month = months[d.getMonth()];
                    let year = d.getFullYear();
                    return `${day} ${month} ${year}`;
                }
                $("#inputCode").on("input", function() {
                    $("section2").addClass("d-none");
                    $("section3").addClass("d-none");
                })
                $("#verify").click(function() {
                    var val = $("#inputCode").val();
                    if (val !== "") {
                        $.ajax({
                            url: "app/verify_certificate_code.php",
                            method: "POST",
                            dataType: "json",
                            data: {
                                purpose: "verifyCertificate",
                                code: val
                            },
                            success: function(response) {
                                if (response.state === "success") {
                                    $("#inputCode").val('');
                                    $("#name").text(capitalizeFirstLetter(response.student_name));
                                    $("#Title").text(capitalizeFirstLetter(response.course_title));
                                    $("#Mentor").text(capitalizeFirstLetter(response.creator_name));
                                    $("#Date").text(formatDate(response.certificate_date));
                                    $("#expiredDate").text(formatDate(response.certificate_expired_date));
                                    $("#section3").addClass("d-none");
                                    $("#section2").removeClass("d-none");
                                } else if (response.state === "notfound") {
                                    $("#section2").addClass("d-none");
                                    $("#section3").removeClass("d-none");
                                } else {
                                    $("#inputCode").val('');
                                    alert("An Error occurred. Please try again. If it persists, contact support team at support@trainmastas.com")
                                }
                            },
                            error: function() {
                                msgBox.text('An error occurred. Please try again.').addClass('text-danger');
                            }
                        });
                    }
                })
            })
        </script>
    </div>
    <footer class="text-center text-lg-start text-white " style="background-color: rgb(64, 99, 61)">
        <div class="container text-center text-md-start mt-5">
            <div class="row mt-3 py-5">
                <div class="col-12 col-md-3 mt-4">
                    <h6 class="text-uppercase fw-bold">TrainMastas</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: green; height: 2px" />
                </div>

                <div class="col-12 col-md-3 mt-4">
                    <a href="https://trainmastas.com/privacy-policy.php" style="text-decoration:none" class="text-white mx-4">Privacy Policy</a>
                </div>
                <div class="col-12 col-md-3 mt-4">
                    <a href="https://trainmastas.com/term-and-condition.php" class="mx-4 text-white" style="text-decoration:none">Terms</a>
                </div>
                <div class="col-12 col-md-3 mt-4">
                    <a href="https://trainmastas.com/courses.php" style="text-decoration:none" class="text-white mx-4">Courses</a>
                </div>
            </div>
        </div>
        </div>
    </footer>
    <!--------------------------------------------------------------------------------------------
                                            Main Section
    ---------------------------------------------------------------------------------------------->
</body>

</html>