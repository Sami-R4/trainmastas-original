<?php
include "app/session_checker.php";

if (!$isLoggedIn) {
    // User is not logged in, redirect to login page  
    header("Location: login.php");
    exit(); // Make sure to exit after the redirect to stop further script execution  
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href=".././image/logo.png">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="css/select2.css" rel="stylesheet" />

    <script src="js/jquery.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <title id="page-title">Teachers Management - TrainMastas</title>
</head>

<body id="body-pd">

    <?php include "navbar.php" ?>
    <!--Container Main start-->
    <div class="height-100 pt-3">
        <!-- The message container -->
        <style>
            /* Style for the fading message */
            .fade-message {
                position: fixed;
                /* Position it at the top of the screen */
                top: 60px;
                /* Space from the top */
                right: 30%;
                /* Space from the right */
                background-color: #28a745;
                /* Green background */
                color: white;
                /* White text */
                padding: 20px;
                /* Padding around the text */
                border-radius: 5px;
                /* Rounded corners */
                opacity: 1;
                /* Fully opaque */
                transition: opacity 1s ease;
                /* Fade out transition */
            }


            @media (min-width:768px) {
                .border-md-right {
                    border-right: 1px solid gainsboro;

                }
            }

            .user-navLinks {
                font-size: 13px;
                color: rgb(46, 49, 47);
                margin-right: 25px;
                cursor: pointer;
            }

            .user-navLinks:hover {
                text-decoration: underline;
                color: #28a745;
            }

            .active-user-navLinks {
                text-decoration: underline;
                color: #28a745;
            }

            .profile-link :hover,
            .profile-link span:hover {
                cursor: pointer;
                text-decoration: underline;
            }
        </style>
        <div id="message" class="fade-message" style="display:none">
            Your message goes here!
        </div>
        <div class="text-muted mb-3" style="font-size:13px"><span id="student-btn" class="border  rounded bg-light p-2" style="cursor:pointer">teachers</span> <span class="fw-bold profile-btn d-none">></span> <span id="profile-btn" class="border rounded bg-light p-2 profile-btn d-none" style="cursor:pointer">Profile</span></div>
        <div id="user-container">
            <div class=" mb-3"><span class="user-navLinks active-user-navLinks" data-id="allUsers">All</span><span class="user-navLinks" data-id="noActionUsers">No Action</span><span class="user-navLinks" data-id="admittedUsers">Admitted</span><span class="user-navLinks" data-id="requestedUsers">Requested</span><span class="user-navLinks" data-id="bannedUsers">Banned</span><span class="user-navLinks" data-id="deletedUsers">Deleted</span></div>
            <div class="d-flex justify-content-between mb-3">
                <input type="number" class="form-control" id="numberInput" style="width:165px" placeholder="Registered Courses">
                <button class="btn btn-danger rounded-0 fs-7" style="display: none !important;" id="clearAllDeleted" data-bs-toggle="modal" data-bs-target="#confirmClearModal">Clear All</button>
            </div>
            <!-- Delete all modal -->
            <div class="modal fade" id="confirmClearModal" tabindex="-1" aria-labelledby="confirmClearModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmClearModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to clear these users? All the information of the user will be deleted, and the user won't be able to access TrainMastas anymore with this email.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal" id="confirmClear">Yes, clear all</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="user-message" class="d-none text-muted"></div>
            <style>
                /* Remove arrow buttons from input[type=number] */
                #numberInput[type=number]::-webkit-inner-spin-button,
                #numberInput[type=number]::-webkit-outer-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }

                #numberInput[type=number] {
                    -moz-appearance: textfield;
                    /* Firefox */
                }
            </style>
            <div style=" width: 100%; overflow: auto;" id="UserDiv">
                <div id="user-loader">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </th>
                                <th scope="col">
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </th>
                                <th scope="col">
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </th>
                                <th scope="col">
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </th>
                                <th scope="col">
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </th>
                                <th scope="col">
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </th>
                                <td>
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                                <td>
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                                <td>
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                                <td>
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                                <td>
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                                <td class="text-center">
                                    <div class="spinner me-2 hideThisLoader" style="width: 70%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                    <div class="spinner me-2" style="width: 100%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </th>
                                <td>
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                                <td>
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                                <td>
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                                <td>
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                                <td>
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                                <td class="text-center">
                                    <div class="spinner me-2 hideThisLoader" style="width: 70%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                    <div class="spinner me-2" style="width: 100%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div id="message-empty" class="text-muted d-none">No teacher was found!</div>
                <div id="user-container-table" class="d-none">
                    <div id="total_count" class="text-muted fs-8"></div>
                    <table class="table table-success table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Profile</th>
                                <th scope="col">Email</th>
                                <th scope="col">Registered Courses</th>
                                <th scope="col">Produced Courses</th>
                                <th scope="col">Date</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="user-div" class="user-div">
                        </tbody>
                    </table>
                    <div class="col-12 text-end d-flex justify-content-center d-none mt-4 table-div" id="btn-containerUser">
                        <a class="text-black border ms-auto" style="text-decoration:none; border-radius:25px">
                            <button id="prevBtnUser" class="btn pageBtn" style="border-radius:25px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                    <path d="M15 18l-6-6 6-6"></path>
                                </svg>
                            </button>
                            <span id="pagination-BtnUser">

                            </span>
                            <button id="nextBtnUser" class="btn pageBtn" style="border-radius:25px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                    <path d="M9 18l6-6-6-6"></path>
                                </svg>
                            </button>
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <!-----------------------------------------------------------------------------------------------------------------
          -----------------------------------------------------------------------------------------------------------------
          ------------------------------------------   Profile Section   --------------------------------------------------
          -----------------------------------------------------------------------------------------------------------------
          ----------------------------------------------------------------------------------------------------------------->
        <div id="profile-container" class="d-none">
            <div id="profile-loader-student" class="pt-4 container-fluid">
                <div style="margin:0 12px">
                    <div class="text-end mb-2">
                        <div class="spinner me-2" style="width: 60px; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                        <div class="spinner" style="width: 60px; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                    </div>
                    <div class="row border">
                        <div class="col-12 col-md-5 col-lg-3  border-md-right">
                            <div class="d-flex d-column">
                                <div class="m-auto text-center p-4">
                                    <div>
                                        <div class="spinner me-2 rounded-circle" style="width: 100px; height: 100px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                    </div>

                                    <h3 class="fs-6 mt-3 p-0">
                                        <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                    </h3>
                                    <p class="text-success my-2 py-0">
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                    </p>
                                    <div class="text-center mt-3">
                                        <div class="spinner me-2 rounded-circle" style="width: 30px; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                        <div class="spinner me-2 rounded-circle" style="width: 30px; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                        <div class="spinner me-2 rounded-circle" style="width: 30px; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                    </div>
                                    <div class="text-center mt-2">
                                        <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-7 col-lg-9 ps-md-0">
                            <hr class="d-md-none">

                            <div class=" mt-3 d-flex justify-content-center" style="min-height: 130px;">
                                <div class="spinner" style="width: 93%; height: 80px; background-color: rgba(56, 182, 255, 0.1);"></div>
                            </div>
                            <hr class="w-100" id="field-hr">
                            <div class="mt-4 p-4">
                                <div class="spinner me-2 my-1" style="width: 22%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="spinner me-2 my-1" style="width: 22%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="spinner me-2 my-1" style="width: 22%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="spinner me-2 my-1" style="width: 22%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="spinner me-2 my-1" style="width: 22%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="spinner me-2 my-1" style="width: 22%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="spinner me-2 my-1" style="width: 22%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="spinner me-2 my-1" style="width: 22%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="spinner me-2 my-1" style="width: 22%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="spinner me-2 my-1" style="width: 22%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="border p-4 mt-3">
                        <div class="fs-6 text-muted fw-semibold mb-0">
                            <div class="spinner w-25" role="status"
                                style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                            </div>
                        </div>
                        <div class="py-3">
                            <hr class="py-0 my-0 mb-3">

                            <div class="spinner w-50" role="status"
                                style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                            </div>
                            <div class="mt-1 mb-0">
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                            </div>
                            <hr class="py-0 my-0 mt-3">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="p-4 border">
                        <div class="fs-6 text-muted fw-semibold mb-0">
                            <div class="spinner w-25" role="status"
                                style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                            </div>
                        </div>
                        <hr class="py-0 my-0 mb-3">
                        <div class="py-3" style="cursor:default">
                            <div class="spinner w-50" role="status"
                                style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                            </div>
                            <div class="d-flex justify-content-between my-3">
                                <div class="spinner" role="status"
                                    style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner" role="status"
                                    style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner" role="status"
                                    style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner" role="status"
                                    style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                            </div>
                        </div>
                        <hr class="py-0 my-0">
                        <hr class="py-0 my-0 mb-3">
                        <div class="py-3" style="cursor:default">
                            <div class="spinner w-50" role="status"
                                style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                            </div>
                            <div class="d-flex justify-content-between my-3">
                                <div class="spinner" role="status"
                                    style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner" role="status"
                                    style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner" role="status"
                                    style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner" role="status"
                                    style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                            </div>
                        </div>
                        <hr class="py-0 my-0">
                    </div>
                </div>

                <div class="">
                    <div class="border p-4 mt-3">
                        <div class="fs-6 text-muted fw-semibold mb-0">
                            <div class="spinner w-25" role="status"
                                style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                            </div>
                        </div>
                        <div class="py-3">
                            <hr class="py-0 my-0 mb-3">
                            <div class="spinner w-50" role="status"
                                style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                            </div>
                            <hr class="py-0 my-0 mt-3">
                        </div>
                    </div>
                </div>
            </div>
            <div id="entire-profile-div" class="d-none container-fluid">
                <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- Main ------------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
                <section class="pt-4" style="margin:0 14px" id="userProfileDiv">
                    <div class="">


                        <div class="text-end mb-2 user-div">
                            <button class="btn btn-outline-success rounded-0  my-1 action-ban " id="action-ban-btn" data-num="" data-user_id="">
                                Ban
                            </button>
                            <button class="fs-7 btn btn-outline-danger rounded-0 ms-1 action-delete" id="action-delete-btn" data-num="" data-user_id="">
                                Delete
                            </button>
                        </div>
                        <div class="row border">
                            <div class="col-12 col-md-5 col-lg-3  border-md-right">
                                <div class="d-flex d-column">
                                    <div class="m-auto text-center p-4">
                                        <div>
                                            <img src="" class="rounded-circle" alt="username" style="width:100px;height:100px;object-fit:cover" id="userprofile">
                                        </div>

                                        <h3 class="fs-6 mt-3 p-0" id="username">
                                        </h3>
                                        <p class="text-success my-2 py-0" id="email">
                                        </p>
                                        <div class="text-center mt-3">
                                            <a href="#" class="text-success d-none me-2 " class="social-media-links" style="text-decoration:none" target="_blank" id="linkedinLink">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="userSocialMedia" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#198754" height="30px" width="30px" version="1.1" id="Layer_1" viewBox="-143 145 512 512" xml:space="preserve">
                                                    <path d="M113,145c-141.4,0-256,114.6-256,256s114.6,256,256,256s256-114.6,256-256S254.4,145,113,145z M41.4,508.1H-8.5V348.4h49.9  V508.1z M15.1,328.4h-0.4c-18.1,0-29.8-12.2-29.8-27.7c0-15.8,12.1-27.7,30.5-27.7c18.4,0,29.7,11.9,30.1,27.7  C45.6,316.1,33.9,328.4,15.1,328.4z M241,508.1h-56.6v-82.6c0-21.6-8.8-36.4-28.3-36.4c-14.9,0-23.2,10-27,19.6  c-1.4,3.4-1.2,8.2-1.2,13.1v86.3H71.8c0,0,0.7-146.4,0-159.7h56.1v25.1c3.3-11,21.2-26.6,49.8-26.6c35.5,0,63.3,23,63.3,72.4V508.1z  " />
                                                </svg>
                                            </a>
                                            <a href="#" class="text-success d-none me-2" class="social-media-links" style="text-decoration:none" target="_blank" id="portfolioLink">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="userSocialMedia" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#198754" width="30px" height="30px" viewBox="0 0 512 512" id="_x30_1" version="1.1" xml:space="preserve">
                                                    <g>

                                                        <path d="M157.114,188.969h28.438c3.269-13.719,7.51-26.333,12.545-37.485c-9.62,5.348-18.555,12.064-26.552,20.061   C166.14,176.95,161.323,182.786,157.114,188.969z" />

                                                        <path d="M157.114,323.031c4.21,6.183,9.026,12.019,14.431,17.424c7.997,7.997,16.932,14.713,26.552,20.061   c-5.036-11.152-9.276-23.766-12.545-37.485H157.114z" />

                                                        <path d="M354.886,188.969c-4.21-6.183-9.026-12.019-14.431-17.424c-7.997-7.997-16.932-14.713-26.552-20.061   c5.036,11.152,9.276,23.766,12.545,37.485H354.886z" />

                                                        <path d="M278.452,162.043c-9.626-19.252-19.283-25.48-22.452-25.48s-12.826,6.228-22.452,25.48   c-3.987,7.975-7.409,17.059-10.208,26.926h65.32C285.86,179.102,282.439,170.017,278.452,162.043z" />

                                                        <path d="M233.548,349.957c9.626,19.252,19.283,25.48,22.452,25.48s12.826-6.228,22.452-25.48   c3.987-7.975,7.409-17.059,10.208-26.926h-65.32C226.14,332.898,229.561,341.983,233.548,349.957z" />

                                                        <path d="M178,256c0-10.428,0.516-20.614,1.492-30.469h-39.021c-2.573,9.825-3.909,20.043-3.909,30.469s1.335,20.644,3.909,30.469   h39.021C178.516,276.614,178,266.428,178,256z" />

                                                        <path d="M334,256c0,10.428-0.516,20.614-1.492,30.469h39.021c2.573-9.825,3.909-20.043,3.909-30.469s-1.335-20.644-3.909-30.469   h-39.021C333.484,235.386,334,245.572,334,256z" />

                                                        <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M256,412   c-86.156,0-156-69.844-156-156s69.844-156,156-156c86.156,0,156,69.844,156,156S342.156,412,256,412z" />

                                                        <path d="M216.277,225.531c-1.125,9.901-1.714,20.127-1.714,30.469s0.589,20.568,1.714,30.469h79.447   c1.125-9.901,1.714-20.127,1.714-30.469s-0.589-20.568-1.714-30.469H216.277z" />

                                                        <path d="M313.903,360.516c9.62-5.348,18.555-12.064,26.552-20.061c5.405-5.405,10.221-11.241,14.431-17.424h-28.438   C323.179,336.75,318.939,349.364,313.903,360.516z" />

                                                    </g>
                                                </svg>
                                            </a>
                                            <a class="text-success d-none me-2 " class="social-media-links" style="text-decoration:none" id="cvLink">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#198754" version="1.1" id="Capa_1" width="30px" height="30px" viewBox="0 0 45.057 45.057" xml:space="preserve">
                                                    <g>
                                                        <g id="_x35_8_24_">
                                                            <g>
                                                                <path d="M19.558,25.389c-0.067,0.176-0.155,0.328-0.264,0.455c-0.108,0.129-0.24,0.229-0.396,0.301     c-0.156,0.072-0.347,0.107-0.57,0.107c-0.313,0-0.572-0.068-0.78-0.203c-0.208-0.137-0.374-0.316-0.498-0.541     c-0.124-0.223-0.214-0.477-0.27-0.756c-0.057-0.279-0.084-0.564-0.084-0.852c0-0.289,0.027-0.572,0.084-0.853     c0.056-0.281,0.146-0.533,0.27-0.756c0.124-0.225,0.29-0.404,0.498-0.541c0.208-0.137,0.468-0.203,0.78-0.203     c0.271,0,0.494,0.051,0.666,0.154c0.172,0.105,0.31,0.225,0.414,0.361c0.104,0.137,0.176,0.273,0.216,0.414     c0.04,0.139,0.068,0.25,0.084,0.33h2.568c-0.112-1.08-0.49-1.914-1.135-2.502c-0.644-0.588-1.558-0.887-2.741-0.895     c-0.664,0-1.263,0.107-1.794,0.324c-0.532,0.215-0.988,0.52-1.368,0.912c-0.38,0.392-0.672,0.863-0.876,1.416     c-0.204,0.551-0.307,1.165-0.307,1.836c0,0.631,0.097,1.223,0.288,1.77c0.192,0.549,0.475,1.021,0.847,1.422     s0.825,0.717,1.361,0.949c0.536,0.23,1.152,0.348,1.849,0.348c0.624,0,1.18-0.105,1.668-0.312     c0.487-0.209,0.897-0.482,1.229-0.822s0.584-0.723,0.756-1.146c0.172-0.422,0.259-0.852,0.259-1.283h-2.593     C19.68,25.023,19.627,25.214,19.558,25.389z" />
                                                                <polygon points="26.62,24.812 26.596,24.812 25.192,19.616 22.528,19.616 25.084,28.184 28.036,28.184 30.713,19.616 28,19.616         " />
                                                                <path d="M33.431,0H5.179v45.057h34.699V6.251L33.431,0z M36.878,42.056H8.179V3h23.706v4.76h4.992L36.878,42.056L36.878,42.056z" />
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="text-center mt-2"><span id="dateJoin" class="fs-7 text-muted"></span></div>
                                        <div class="text-center d-none mt-2" id="operationValidate">
                                            <span class=" text-muted fs-7"></span>
                                            <div>
                                                <button class="btn btn-outline-danger rounded-0  my-1 action-reject " data-bs-toggle="modal" data-bs-target="#confirmRejection" id="action-reject-btn" data-num="" data-user_id="">
                                                    Reject
                                                </button>
                                                <button class="btn btn-outline-success rounded-0  my-1 action-approve " id="action-approve-btn" data-num="" data-user_id="">
                                                    Approve
                                                </button>
                                            </div>
                                            <!-- Delete all modal -->
                                            <div class="modal fade" id="confirmRejection" tabindex="-1" aria-labelledby="confirmRejectionLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmRejectionLabel">Reason for Rejection</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="text" class="form-control" id="reason" placeholder="Reason for rejection. Max 100 words.">
                                                            <div id="characterCount" class="text-muted fs-7"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-danger rounded-0  action-validate-reject" data-purpose="reject" data-course_id="" id=" confirmReject">Reject</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-7 col-lg-9 ps-md-0">
                                <hr class="d-md-none">
                                <p class="p-4" style="word-wrap: break-word; word-break: break-all;min-height:130px" id="description">
                                    I'm Salim,a software developer.
                                </p>
                                <hr class="w-100" id="field-hr">
                                <div class="mt-4 p-4" id="fields">
                                    <button class="btn btn-secondary disabled fs-7 rounded-0 my-2">Web Development</button>
                                    <button class="btn btn-secondary disabled fs-7 rounded-0 my-2">Web Development</button>
                                    <button class="btn btn-secondary disabled fs-7 rounded-0 my-2">Web Development</button>
                                    <button class="btn btn-secondary disabled fs-7 rounded-0 my-2">Web Development</button>
                                    <button class="btn btn-secondary disabled fs-7 rounded-0 my-2">Web Development</button>
                                    <button class="btn btn-secondary disabled fs-7 rounded-0 my-2">Web Development</button>
                                    <button class="btn btn-secondary disabled fs-7 rounded-0 my-2">Web Development</button>
                                    <button class="btn btn-secondary disabled fs-7 rounded-0 my-2">Web Development</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- PDF --------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
                <div id="pdf-main-container" style="display:none;">
                    <div class="container mt-5" style="margin-bottom: 15px;">
                        <button class="btn btn-outline-success rounded-0" id="zoom-out">➖ Zoom Out</button>
                        <button class="btn btn-outline-success rounded-0" id="zoom-in">➕ Zoom In</button>
                        <span id="zoom-level">100%</span>
                    </div>
                    <div class="container mt-4 border bg-dark pt-3" style="overflow-x: auto; width: 100%;height:80vh;">
                        <div id="pdf-container"></div>
                    </div>

                </div>
                <!-- PDF.js Library -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
                <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- End PDF --------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->

                <!------------------------------------------------------------------------------------------------------------------
            -------------------------------------------------- Your Courses ------------------------------------------------------
            ----------------------------------------------------------------------------------------------------------------->
                <section class="pt-4 p-0 m-0" id="registeredCourseDiv">
                    <div class="border p-4 mt-3">
                        <p class="fs-6 text-muted fw-semibold mb-0">User's Courses (<span id="registered-num"></span>)</p>
                        <div class="py-3 d-none" id="course-registered-loader">
                            <hr class="py-0 my-0 mb-3">

                            <div class="spinner w-50" role="status"
                                style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                            </div>
                            <div class="mt-1 mb-0">
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                            </div>
                            <hr class="py-0 my-0 mt-3">
                        </div>
                        <div>
                            <div id="course-registered">
                                <hr class="py-0 my-0">

                                <div class="py-3">
                                    <h2 class="fs-6 text-success fw-semibold mb-0">
                                        Master Coding in 4 Days
                                    </h2>
                                    <p class="fs-6 py-0 mb-0 mt-1">By <span>Ngoupayou Habil</span></p>
                                    <div class="d-flex justify-content-between mt-2">
                                        <p class="fs-7 py-0 my-0 text-muted "><span>50%</span> Completed</p>
                                        <a href="#" class="fs-7 py-0 my-0 text-muted hv-underline">View Course</a>
                                    </div>
                                </div>
                                <hr class="py-0 my-0">

                            </div>
                            <div class="col-12 text-end d-flex justify-content-center d-none mt-4" id="btn-containerRegisteredCourse">
                                <a class="text-black border ms-auto" style="text-decoration:none; border-radius:25px">
                                    <button id="prevBtnRegisteredCourse" class="btn pageBtn" style="border-radius:25px">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                            <path d="M15 18l-6-6 6-6"></path>
                                        </svg>
                                    </button>
                                    <span id="pagination-BtnRegisteredCourse">

                                    </span>
                                    <button id="nextBtnRegisteredCourse" class="btn pageBtn" style="border-radius:25px">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                            <path d="M9 18l6-6-6-6"></path>
                                        </svg>
                                    </button>
                                </a>
                            </div>
                        </div>

                    </div>
                </section>
                <!------------------------------------------------------------------------------------------------------------------
            ---------------------------------------------- End Your Courses ------------------------------------------------------
            ----------------------------------------------------------------------------------------------------------------->

                <!------------------------------------------------------------------------------------------------------------------
            -------------------------------------------------- User created Courses ------------------------------------------------------
            ----------------------------------------------------------------------------------------------------------------->
                <section class="pt-4 p-0 m-0" id="createdCourseDiv">
                    <div class="border p-4 mt-3">
                        <p class="fs-6 text-muted fw-semibold mb-0">User's Created Courses (<span id="created-num"></span>)</p>
                        <div class="py-3 d-none" id="course-created-loader">
                            <hr class="py-0 my-0 mb-3">
                            <div class="py-3" style="cursor:default">
                                <div class="spinner w-50" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <div class="spinner" role="status"
                                        style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                    </div>
                                    <div class="spinner" role="status"
                                        style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                    </div>
                                    <div class="spinner" role="status"
                                        style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                    </div>
                                    <div class="spinner" role="status"
                                        style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="spinner w-25" role="status"
                                        style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                    </div>
                                    <div class="spinner w-25" role="status"
                                        style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                    </div>
                                </div>
                            </div>
                            <hr class="py-0 my-0">
                            <hr class="py-0 my-0 mb-3">
                            <div class="py-3" style="cursor:default">
                                <div class="spinner w-50" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <div class="spinner" role="status"
                                        style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                    </div>
                                    <div class="spinner" role="status"
                                        style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                    </div>
                                    <div class="spinner" role="status"
                                        style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                    </div>
                                    <div class="spinner" role="status"
                                        style="width:22%;background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="spinner w-25" role="status"
                                        style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                    </div>
                                    <div class="spinner w-25" role="status"
                                        style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                    </div>
                                </div>
                            </div>
                            <hr class="py-0 my-0">
                        </div>
                        <div>
                            <div id="course-created">
                                <hr class="py-0 my-0">

                                <div class="py-3">
                                    <h2 class="fs-6 text-success fw-semibold mb-0">
                                        Master Coding in 4 Days
                                    </h2>
                                    <p class="fs-6 py-0 mb-0 mt-1">By <span>Ngoupayou Habil</span></p>
                                    <div class="d-flex justify-content-between mt-2">
                                        <p class="fs-7 py-0 my-0 text-muted "><span>50%</span> Completed</p>
                                        <a href="#" class="fs-7 py-0 my-0 text-muted hv-underline">View Course</a>
                                    </div>
                                </div>
                                <hr class="py-0 my-0">

                            </div>
                            <div class="col-12 text-end d-flex justify-content-center d-none mt-4" id="btn-containerCreatedCourse">
                                <a class="text-black border ms-auto" style="text-decoration:none; border-radius:25px">
                                    <button id="prevBtnCreatedCourse" class="btn pageBtn" style="border-radius:25px">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                            <path d="M15 18l-6-6 6-6"></path>
                                        </svg>
                                    </button>
                                    <span id="pagination-BtnCreatedCourse">

                                    </span>
                                    <button id="nextBtnCreatedCourse" class="btn pageBtn" style="border-radius:25px">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                            <path d="M9 18l6-6-6-6"></path>
                                        </svg>
                                    </button>
                                </a>
                            </div>
                        </div>

                    </div>
                </section>
                <!------------------------------------------------------------------------------------------------------------------
            ---------------------------------------------- End User created Courses ------------------------------------------------------
            ----------------------------------------------------------------------------------------------------------------->


                <!------------------------------------------------------------------------------------------------------------------
            ----------------------------------------------- Feedback Courses -------------------------------------------------
            ----------------------------------------------------------------------------------------------------------------->
                <section class="pt-4" style="margin-bottom:60px !important" id="feedbackCourseDiv">
                    <div class="border p-4 mt-3">
                        <p class="fs-6 text-muted fw-semibold mb-0">Feedback Given (<span id="feedback-num"></span>)</p>
                        <div class="py-3 d-none" id="course-feedback-loader">
                            <hr class="py-0 my-0 mb-3">
                            <div class="spinner w-50" role="status"
                                style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                            </div>
                            <hr class="py-0 my-0 mt-3">
                        </div>
                        <div id="course-feedback">
                            <hr class="py-0 my-0">

                            <div class="py-3">
                                <h2 class="fs-6 text-success fw-semibold mb-0">
                                    Master Coding in 4 Days
                                </h2>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="text-muted fs-7 py-0 mx-0">Mon, 13 July 2023</div>
                                    <a href="#" class="fs-7 py-0 my-0 text-muted hv-underline">View Course</a>
                                </div>
                            </div>
                            <hr class="py-0 my-0">

                        </div>
                        <div class="col-12 text-end d-flex justify-content-center d-none mt-4" id="btn-containerfeedbackCourse">
                            <a class="text-black border ms-auto" style="text-decoration:none; border-radius:25px">
                                <button id="prevBtnfeedbackCourse" class="btn pageBtn" style="border-radius:25px">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                        <path d="M15 18l-6-6 6-6"></path>
                                    </svg>
                                </button>
                                <span id="pagination-BtnfeedbackCourse">

                                </span>
                                <button id="nextBtnfeedbackCourse" class="btn pageBtn" style="border-radius:25px">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                        <path d="M9 18l6-6-6-6"></path>
                                    </svg>
                                </button>
                            </a>
                        </div>

                    </div>
                </section>
                <!------------------------------------------------------------------------------------------------------------------
    ---------------------------------------------- End Instructor Courses ------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
            </div>

        </div>
    </div>


</body>
<script src="js/teachers.js"></script>

<script>
    $(document).ready(function() {
        $("#teacher-link").addClass("active");
    })
</script>

</html>