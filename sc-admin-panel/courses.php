<?php
include "app/session_checker.php";

if (!$isLoggedIn) {
    // course is not logged in, redirect to login page  
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
    <title id="page-title">Course Management - TrainMastas</title>
</head>

<body id="body-pd">

    <?php include "navbar.php" ?>
    <!--Container Main start-->
    <div class="height-100 pt-3">
        <!-- The message container -->
        <style>
            .displayTextAsItIs {
                white-space: pre-wrap !important;
            }

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

            .course-navLinks {
                font-size: 13px;
                color: rgb(46, 49, 47);
                margin-right: 25px;
                cursor: pointer;
            }

            .course-navLinks:hover {
                text-decoration: underline;
                color: #28a745;
            }

            .active-course-navLinks {
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
        <div class="text-muted mb-3" style="font-size:13px"><span id="student-btn" class="border  rounded bg-light p-2" style="cursor:pointer">courses</span> <span class="fw-bold profile-btn d-none">></span> <span id="profile-btn" class="border rounded bg-light p-2 profile-btn d-none" style="cursor:pointer">Profile</span></div>
        <div id="course-container">
            <div class=" mb-3"><span class="course-navLinks active-course-navLinks" data-id="allCourses">All</span><span class="course-navLinks" data-id="noActionCourses">No Action</span><span class="course-navLinks" data-id="editingCourses">Editing</span><span class="course-navLinks" data-id="submittedCourses">Submitted</span><span class="course-navLinks" data-id="bannedCourses">Banned</span><span class="course-navLinks" data-id="rejectedCourses">Rejected</span><span class="course-navLinks" data-id="deletedCourses">Deleted</span></div>
            <div class="d-flex justify-content-between mb-3">
                <input type="text" class="form-control" id="numberInput" style="width:165px" placeholder="Name, Category Or Description">
                <button class="btn btn-danger rounded-0 fs-7" style="display: none !important;" id="clearAllDeleted" data-bs-toggle="modal" data-bs-target="#confirmClearModal">Clear All</button>
            </div>
            <!-- Delete all modal -->
            <div class="modal fade" id="confirmClearModal" tabindex="-1" aria-labelledby="confirmClearModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmClearModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to clear these courses? All the information of the course will be deleted, and the course won't be able to access TrainMastas anymore with this email.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal" id="confirmClear">Yes, clear all</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="course-message" class="d-none text-muted" style="max-width:300px"></div>
            <div style=" width: 100%; overflow: auto;" id="courseDiv">
                <div id="course-loader">
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
                <div id="message-empty" class="text-muted d-none">No course was found!</div>
                <div id="course-container-table" class="d-none">
                    <div id="total_count" class="text-muted fs-8"></div>
                    <table class="table table-success table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Course</th>
                                <th scope="col">Category</th>
                                <th scope="col">Num Modules</th>
                                <th scope="col">Num Test</th>
                                <th scope="col">Cost</th>
                                <th scope="col">Creator</th>
                                <th scope="col">Registered Users</th>
                                <th scope="col">Active Users</th>
                                <th scope="col">Feedback</th>
                                <th scope="col">Date</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="course-div" class="course-div">
                        </tbody>
                    </table>
                    <div class="col-12 text-end d-flex justify-content-center d-none mt-4 table-div" id="btn-containercourse">
                        <a class="text-black border ms-auto" style="text-decoration:none; border-radius:25px">
                            <button id="prevBtncourse" class="btn pageBtn" style="border-radius:25px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                    <path d="M15 18l-6-6 6-6"></path>
                                </svg>
                            </button>
                            <span id="pagination-Btncourse">

                            </span>
                            <button id="nextBtncourse" class="btn pageBtn" style="border-radius:25px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                    <path d="M9 18l6-6-6-6"></path>
                                </svg>
                            </button>
                        </a>
                    </div>
                </div>

            </div>
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
                <section class="pt-4" style="margin:0 14px" id="courseProfileDiv">
                    <div class="">
                        <div class="text-end mb-2 course-div" id="div-actions">
                            <button class="btn btn-outline-success rounded-0  my-1 action-validate " id="action-validate-btn" data-num="" data-course_id="">
                                Validate
                            </button>
                            <button class="btn btn-outline-danger rounded-0  my-1 action-reject " data-bs-toggle="modal" data-bs-target="#confirmRejection" id="action-reject-btn" data-num="" data-course_id="">
                                Reject
                            </button>
                            <button class="btn btn-outline-success rounded-0  my-1 action-ban " id="action-ban-btn" data-num="" data-course_id="">
                                Ban
                            </button>
                            <button class="fs-7 btn btn-outline-danger rounded-0 ms-1 action-delete" data-can_delete="no" id="action-delete-btn" data-num="" data-course_id="">
                                Delete
                            </button>
                            <span id="reject-message" class="d-none">Rejected</span>
                        </div>
                        <div class="row border">
                            <div class="col-12 col-md-5 col-lg-3  border-md-right">
                                <div class="">
                                    <div class="m-auto text-center p-4">
                                        <img src="" class="rounded-0" alt="course_Cover_image" style="width:100%;height:100%;object-fit:cover" id="course_Cover_image">
                                        <div class="text-center mt-2"><span id="course_date" class="fs-7 text-muted"></span></div>
                                        <div class="text-center mt-2"><span id="course_submitted_date" class="fs-7 text-muted"></span></div>
                                        <div class="text-center mt-2"><span id="course_validated_date" class="fs-7 text-muted"></span></div>
                                    </div>
                                    <div id="progressive_bar_container">
                                        <div class="d-flex justify-content-center">
                                            <div id="progress-bar" class="progress-ring ">
                                                <svg width="100" height="100">
                                                    <circle cx="50" cy="50" r="45" stroke="#e6e6e6" stroke-width="10" fill="none" />
                                                    <circle id="progress" cx="50" cy="50" r="45" stroke="#198754" stroke-width="10" fill="none" stroke-dasharray="283" stroke-dashoffset="0" />
                                                </svg>
                                                <div id="percentage" class="percentage">0%</div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-2">Average Passing Rate</div>
                                    </div>
                                    <style>
                                        .progress-ring {
                                            position: relative;
                                            width: 100px;
                                            /* diameter of the circle */
                                            height: 100px;
                                            /* diameter of the circle */
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            border-radius: 50%;
                                        }

                                        .percentage {
                                            position: absolute;
                                            font-size: 20px;
                                            font-weight: bold;
                                        }
                                    </style>
                                </div>
                            </div>
                            <div class="col-12 col-md-7 col-lg-9 ps-md-0">
                                <hr class="d-md-none">
                                <div class=" p-4">
                                    <p style="word-wrap: break-word; word-break: break-all;" id="course_Title">
                                    </p>
                                    <div class="">
                                        <a href="" class="d-flex text-black" target="_blank" id="creator_link">
                                            <img src="" class="rounded-circle  mt-2" alt="creator_image" style="width:40px;height:40px;object-fit:cover" id="course_creator_image">
                                            <h3 class="fs-6 mt-3 p-0 ms-2" id="course_creator">
                                            </h3>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p id="course_Category" class="mt-2"></p>
                                        <p id="course_action" class="mt-2"></p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p id="course_Num_modules"></p>
                                        <p id="course_Num_test"></p>
                                    </div>

                                    <p style="word-wrap: break-word; word-break: break-all; white-space: pre-wrap !important;" id="course_Description">
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
                    </div>
                </section>


                <!------------------------------------------------------------------------------------------------------------------
            -------------------------------------------------- End Modules ------------------------------------------------------
            ----------------------------------------------------------------------------------------------------------------->
                <section class="pt-4 p-0 m-0" id="modulecourseDiv">
                    <div class="border p-4 mt-3">
                        <div class=" mb-3">
                            <span class="hover ms-3 module-navLinks active-course-navLinks" data-purpose="default" id="actual-btn">Actual</span>
                            <span class="hover ms-3 module-navLinks editing-features d-none" data-purpose="verify">Editing</span>
                        </div>
                        <div id="course-module">
                            <div id="module-buttons-container" class="mb-3"></div>
                            <h3 id="module-number" class=" d-none">Module</h3>
                            <div id="container_module" class="course-module" style="max-height:450px; overflow:auto;"></div>


                            <div class="d-flex justify-content-between mt-2 d-none" id="course-test-loader">
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 d-none" id="course-module-loader">
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                                </div>
                                <div class="spinner w-25" role="status"
                                    style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:2vh">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!------------------------------------------------------------------------------------------------------------------
            -------------------------------------------------- End Modules ------------------------------------------------------
            ----------------------------------------------------------------------------------------------------------------->

                <!------------------------------------------------------------------------------------------------------------------
            -------------------------------------------------- Registered Users ------------------------------------------------------
            ----------------------------------------------------------------------------------------------------------------->
                <section class="pt-4 p-0 m-0" id="RegisteredCourseDiv">
                    <div class="border p-4 mt-3">
                        <p class="fs-6 text-muted fw-semibold mb-0">User Registered (<span id="registered-num"></span>)</p>
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
                                        <a href="#" class="fs-7 py-0 my-0 text-muted hv-underline">View course</a>
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
            ---------------------------------------------- End Your courses ------------------------------------------------------
            ----------------------------------------------------------------------------------------------------------------->

                <!------------------------------------------------------------------------------------------------------------------
            ----------------------------------------------- Feedback courses -------------------------------------------------
            ----------------------------------------------------------------------------------------------------------------->
                <section class="pt-4" style="margin-bottom:60px !important" id="FeedbackCourseDiv">
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
                                    <a href="#" class="fs-7 py-0 my-0 text-muted hv-underline">View course</a>
                                </div>
                            </div>
                            <hr class="py-0 my-0">

                        </div>
                        <div class="col-12 text-end d-flex justify-content-center d-none mt-4" id="btn-containerFeedbackCourse">
                            <a class="text-black border ms-auto" style="text-decoration:none; border-radius:25px">
                                <button id="prevBtnFeedbackCourse" class="btn pageBtn" style="border-radius:25px">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                        <path d="M15 18l-6-6 6-6"></path>
                                    </svg>
                                </button>
                                <span id="pagination-BtnFeedbackCourse">

                                </span>
                                <button id="nextBtnFeedbackCourse" class="btn pageBtn" style="border-radius:25px">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                        <path d="M9 18l6-6-6-6"></path>
                                    </svg>
                                </button>
                            </a>
                        </div>

                    </div>
                </section>
                <!------------------------------------------------------------------------------------------------------------------
    ---------------------------------------------- End Instructor courses ------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
            </div>

        </div>
    </div>


</body>
<script src="js/courses.js"></script>

<script>
    $(document).ready(function() {
        $("#course-link").addClass("active");
    })
</script>

</html>