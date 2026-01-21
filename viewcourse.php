<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="./image/logo.png">

    <script src="js/jquery.js"></script>
    <script src="js/session_checker.js"></script>
    <script>
        // Redirecting script
        checkSession().then(({ isLoggedIn, userType }) => {
            if (!isLoggedIn) {
                window.location.href = 'login.php';
            }
        });
    </script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.css">
    <link href="css/select2.css" rel="stylesheet" />
    <script src="js/jspdf.min.js"></script>
    <script src="js/html2canvas.min.js"></script>

    <script src="js/bootstrap.js"></script>
    <title id="page-title">View Course - TrainMastas</title>
</head>
<?php
include "navbar.php"
?>
<style>
    .activity-hover:hover {
        background-color: rgb(40, 167, 69, 0.7);
    }

    .hv-underline {
        text-decoration: none;
    }

    .hv-underline:hover {
        text-decoration: underline;
    }

    .displayTextAsItIs {
        white-space: pre-wrap !important;
    }

    .or-with-lines {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .line {
        flex-grow: 1;
        height: 2.2px;
        background-color: gainsboro;
        margin: 0 10px;
    }

    .or-text {
        font-weight: 450;
        font-size: 16px;
    }

    .progress-number {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 5px;
        width: 45px;
        /* Set a fixed width */
        height: 45px;
        /* Set a fixed height */
        min-width: 45px;
        /* Minimum width */
        min-height: 45px;

    }

    @media (max-width:768px) {
        .line {
            display: none;
        }

        .progress-number {
            margin: 5px 10px;

        }
    }

    .active-success {
        border-color: rgb(40, 167, 69) !important;
        color: #28a745 !important;
    }

    .active-line-success {
        background-color: rgb(40, 167, 69) !important;
    }

    .btn-activity {
        cursor: default
    }

    .active-success {
        cursor: pointer
    }

    /* Radio Style */

    /* Hide the default radio input */
    input[type="radio"] {
        display: none;
        /* Hides the original radio button */
    }

    /* Style for the custom radio button */
    .custom-radio {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid #ccc;
        border-radius: 50%;
        position: relative;
        margin-right: 10px;
        cursor: pointer;
        vertical-align: middle;
        /* Aligns the radio button in the middle */
    }

    /* Check if the radio is checked */
    input[type="radio"]:checked+.custom-radio {
        border: 2px solid #28a745;
        /* Bootstrap success color */
        background-color: #28a745;
        /* Bootstrap success color */
    }

    /* Inner circle when checked */
    input[type="radio"]:checked+.custom-radio:after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 12px;
        height: 12px;
        background-color: white;
        border-radius: 50%;
        transform: translate(-50%, -50%);
    }

    /* Align the label vertically */
    label {
        display: flex;
        align-items: center;
        margin: 12px 0;
        /* Vertically center aligns the text with the radio button */
    }

    .input-radio-disabled {
        pointer-events: none;
        /* Prevents all mouse events */
        opacity: 0.95;
        /* Makes the radio buttons look disabled */
    }

    .bg-custom-danger {
        background-color: rgb(220, 53, 69, 0.4);
    }

    .bg-custom-success {
        background-color: rgb(40, 167, 69, 0.4);

    }
</style>

<body style="padding-bottom:20px">
    <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- Main ------------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
    <main class="pt-navbar">
        <!-------------------------------------------------------------------------------------------------
        ------------------------------------------- Loader ---------------------------------------------
        --------------------------------------------------------------------------------------------------->
        <div class="text-end container d-course d-none" id="containerWithdrawal"><button class="btn btn-danger rounded-0 mb-2" data-bs-toggle="modal" data-bs-target="#withdrawModal">Withdraw From Course</button></div>
        <div class="container my-auto  d-none pe-2 pe-sm-0" id="viewcourse-loader">

            <div class=" rounded-0 border p-5 ">
                <div class="">
                    <h1 class="fs-4 mb-3" style="word-wrap: break-word; word-break: break-all;">
                        <div class="card-img-top spinner w-50 my-0" role="status" style="padding-bottom:30px">
                        </div>
                    </h1>
                    <p class="fs-6" style="word-wrap: break-word; word-break: break-all;">
                    <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:80px">
                    </div>
                    </p>
                    <div class="pt-4 col-12 col-md-8 col-lg-7">
                        <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:300px">
                        </div>
                        <hr class="my-4">
                    </div>
                </div>
            </div>

        </div>
        <!-------------------------------------------------------------------------------------------------
        ------------------------------------------- End Loader ---------------------------------------------
        --------------------------------------------------------------------------------------------------->

        <!-------------------------------------------------------------------------------------------------
        -------------------------------------------- Modules ----------------------------------------------
        --------------------------------------------------------------------------------------------------->
        <div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="withdrawModalLabel">Confirm Course Withdrawal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="">You are about to withdraw from this course. <span id="withdrawal-span"></span> Are you sure you want to withdraw?</div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger rounded-0" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button class="btn btn-success rounded-0" id="withdraw">Withdraw</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="or-with-lines container mb-4 d-course" id="navNum">

        </div>
        <!-- <div class="text-end container mb-4  pe-2 pe-sm-0 d-course ">
            <button class="btn btn-outline-success rounded-0">Message Course Creator</button>
        </div> -->
        <div class="container my-auto pe-2 pe-sm-0 d-course">
            <div class=" rounded-0 border p-5 ">
                <div class="">
                    <h1 class="fs-4 mb-3" style="word-wrap: break-word; word-break: break-all;">Module <span id="moduleNumber"></span>: <span id="module-title" class="displayTextAsItIs"></span></h1>
                    <p class="fs-6" id="module-description" style="word-wrap: break-word; word-break: break-all;"></p>
                    <div class="mt-5" id="iframe-container">

                    </div>
                    <p class="text-muted small mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25px" height="25px" viewBox="0 -3 20 20" version="1.1">
   
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)" fill="#FF0000">
                                    <g id="icons" transform="translate(56.000000, 160.000000)">
                                        <path d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289" id="youtube-[#168]">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        YouTube-hosted content. 
                        Click the YouTube logo in player to view original. 
                        TrainMastas doesn't own this video.
                    </p>
                </div>

            </div>


        </div>

        <!-------------------------------------------------------------------------------------------------
        ----------------------------------------- End Modules ---------------------------------------------
        --------------------------------------------------------------------------------------------------->
    </main>
    <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- End Main --------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->

    <!-------------------------------------------------------------------------------------------------
        ------------------------------------------- Score ---------------------------------------------
        --------------------------------------------------------------------------------------------------->
    <div class="container mb-4 d-none" id="score-loader">
        <div class="border p-5">
            <hr>
            <div class="m-0 p-0">
                <div class="row">
                    <div class="col-2" style="padding-bottom:0px">
                        <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:20px">
                        </div>
                    </div>
                    <div class="col-2 fs-semibold">
                        <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:20px">
                        </div>
                    </div>
                    <div class="col-6 text-muted">
                        <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:20px">
                        </div>
                    </div>

                </div>
                <hr>
                <div class="card-img-top spinner w-25 my-0" role="status" style="padding-bottom:20px">
                </div>
            </div>
        </div>

    </div>
    <!-------------------------------------------------------------------------------------------------
        ------------------------------------------- End Score ---------------------------------------------
        --------------------------------------------------------------------------------------------------->

    <!-------------------------------------------------------------------------------------------------
        ------------------------------------------- Score ---------------------------------------------
        --------------------------------------------------------------------------------------------------->
    <div class="container mb-4 d-none" id="score-div">
        <div class="border p-5">
            <div class="text-muted fs-7 mb-3">Maximum of 3 attempts are allowed.</div>
            <hr>
            <div class="m-0 p-0" id="score-elements">

            </div>
            <div class="text-muted fs-7 my-2 text-center" id="alertTestMessage"></div>
            <div class="p-0 m-0 text-center">
                <button id="reAttempt" class="btn btn-outline-success rounded-0 mt-1">Re-attempt</button>
                <button target="_blank" id="downloadCertificate" class="btn btn-outline-success rounded-0 mt-1 d-none">Download Certificate</button>
                <button id="buyCertificate" class="btn btn-outline-success rounded-0 mt-1 d-none" data-bs-toggle="modal" data-bs-target="#buyModal">Buy Certificate</button>
            </div>
        </div>
        <!-- Confirm Transaction Modal -->
        <div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="buyModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buyModalLabel">Confirm Transaction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="">You are about to buy this course certificate. $<span id="amount"></span> will be deducted from your balance. Would you like to proceed with the transaction?</div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger rounded-0" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button class="btn btn-success rounded-0" id="buyCertificate_bnt">Buy</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recharge Modal -->
        <div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog" aria-labelledby="rechargeModalLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rechargeModalLabel">Insufficient Balance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="">Your balance is insufficient. Recharge now</div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger rounded-0" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <a href="recharge.php" target="_blank" class="btn btn-success rounded-0">Recharge</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------------------------------------------------------------------------------------------------
        ------------------------------------------- End Score ---------------------------------------------
        --------------------------------------------------------------------------------------------------->

    <!-------------------------------------------------------------------------------------------------
        ------------------------------------------- Questions Loader ---------------------------------------------
        --------------------------------------------------------------------------------------------------->
    <div class="container mb-4 d-none" id="test-loader">
        <div class="mb-3 d-flex">
            <p class="p-0 my-1">
            <div class="card-img-top spinner w-25 my-0" role="status" style="padding-bottom:20px">
            </div>
            </p>
            <p class="p-0 my-1 me-4">
            <div class="card-img-top spinner w-25 my-0" role="status" style="padding-bottom:20px">
            </div>
            </p>
            <p class="p-0 my-1 me-4">
            <div class="card-img-top spinner w-25 my-0" role="status" style="padding-bottom:20px">
            </div>
            </p>
        </div>
        <div class="mb-4">
            <div class="border rounded-0 p-4">
                <p class="mb-4">
                <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:20px">
                </div>
                </p>
                <p class="ms-2">
                <div class="card-img-top spinner w-75 my-2" role="status" style="padding-bottom:20px">
                </div><br>
                <div class="card-img-top spinner w-75 my-0" role="status" style="padding-bottom:20px">
                </div><br>
                <div class="card-img-top spinner w-75 my-2" role="status" style="padding-bottom:20px">
                </div><br>
                <div class="card-img-top spinner w-75 my-0" role="status" style="padding-bottom:20px">
                </div><br>
                </p>
            </div>
        </div>
    </div>
    <!-------------------------------------------------------------------------------------------------
        ----------------------------------------- End Questions Loader -------------------------------------------
        --------------------------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------------------------
        ------------------------------------------- Questions ---------------------------------------------
        --------------------------------------------------------------------------------------------------->
    <div class="text-end mb-2 container mb-1">
        <span class=" d-test d-none rounded-0 border p-3" id="countdown">
        </span>
    </div>

    <div class="container mb-4 d-none mt-5" id="test-div">


    </div>
    <div class="text-end container d-test d-none">
        <button class="btn btn-success rounded-0" id="verifyAnswer">Submit Your Answers</button>
    </div>

    <div class="p-5 border container rounded-0 text-center d-none" id="taketest">
        <p class="mb-0 pb-0">Congratulations! You have reached the end of this course. One step left. Note if you exit or refresh the page you automatically score a zero.</p>
        <button class="btn btn-outline-success rounded-0 mt-3" id="startExam">Start Exam</button>
        <div id="testDuration" class=" fs-7 text-muted mt-1 pt-0"></div>
    </div>
    <!-------------------------------------------------------------------------------------------------
        ----------------------------------------- End Questions -------------------------------------------
        --------------------------------------------------------------------------------------------------->
    <div class="text-end pe-0 container mt-3 d-course" id="container-btn">
        <button class="btn btn-outline-success rounded-0" id="previous">Previous</button>
        <button class="btn btn-outline-success rounded-0 ms-3" id="next">Next</button>
    </div>


    <!-------------------------------------------------------------------------------------------------
        ----------------------------------------- Test Modal -------------------------------------------
        --------------------------------------------------------------------------------------------------->
    <div class="modal fade" id="verify" aria-labelledby="verifyTitle" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="verifyTitle">Confirm Your Answers</h1>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body" style="height:400px;overflow:auto;">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success rounded-0 ms-3" data-bs-dismiss="modal" id="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-------------------------------------------------------------------------------------------------
        ----------------------------------------- End Test Modal -------------------------------------------
        --------------------------------------------------------------------------------------------------->
    <script src="js/viewcourse.js">

    </script>
    <script>

    </script>
</body>


</html>