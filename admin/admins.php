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
    <title id="page-title">Admins Management - TrainMastas</title>
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


            /* Updated CSS for select element */
            .select2-selection--multiple {
                background-color: #fff !important;
                border: 1px solid #ced4da !important;
                /* Bootstrap's form-control border color */
                border-radius: 0 !important;
                margin-top: 3px !important;
                /* Remove default outline */
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            .select2-container--default:active,
            .select2-selection:focus,
            .select2-container--default:focus {
                border-color: #80bdff !important;
                /* Bootstrap's form-control focus border color */
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
                /* Bootstrap's form-control focus box shadow */
            }

            .select2-selection__choice {
                background-color: #f0f0f0 !important;
                border: 1px solid #ccc !important;
                color: #333 !important;
                font-family: Arial,
                    sans-serif !important;
            }

            .select2-results__option[aria-selected="true"] {
                color: #6c757d !important;
                cursor: default !important;
                background-color: transparent !important;
                pointer-events: none;
            }

            /* Custom CSS for select element */
            .select2-selection--single {
                background-color: #fff !important;
                border: 1px solid #ced4da !important;
                border-radius: 0 !important;
                margin-top: 3px !important;
                margin-bottom: 2px !important;
                padding-top: 3px !important;
                height: 38px !important;
                outline: none !important;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                /* Adjust padding as needed */
                color: #333 !important;
                /* Change text color */
            }

            .select2-selection--single:focus {
                border-color: #80bdff !important;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
            }

            #cv-link:hover {
                text-decoration: underline !important;
            }

            @media (min-width:768px) {
                .border-md-right {
                    border-right: 1px solid gainsboro;

                }
            }


            /* Additional CSS to ensure the select2 dropdown appears above the modal */
            .select2-container--open {
                z-index: 1060 !important;
            }

            /* Change the background color of select2 options on hover to bg-success */
            .select2-results__option--highlighted {
                background-color: #198754 !important;
                /* Bootstrap's bg-success color */
                color: white;
                /* Ensures the text is readable */
            }

            /* Change the border color of Select2 to success on focus */
            .select2-container--focus .select2-selection {
                border-color: #198754 !important;
                /* Bootstrap's border-success color */
                box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25) !important;
                /* Add a subtle shadow */
            }

            /* Adjust the border and outline for the Select2 component */
            .select2-container--default .select2-selection--multiple {
                border-color: #ced4da;
                /* Default border color */
            }

            .select2-container--default .select2-selection--multiple:focus,
            .select2-container--default .select2-selection--multiple:hover {
                border-color: #198754;
                /* Success border color on focus or hover */
            }
        </style>
        <div id="message" class="fade-message" style="display:none">
            Your message goes here!
        </div>
        <!-- ////////////////////////////////////////////////////// -->

        <style>
            .sparkling-text {
                font-weight: bold;
                position: relative;
                overflow: hidden;
                text-shadow: 0 0 10px #fff, 0 0 20px #f39c12, 0 0 30px #e74c3c;
            }

            .sparkles {
                position: absolute;
                width: 100px;
                height: 100%;
                top: 0;
                left: -1;
                pointer-events: none;
            }

            .sparkle {
                position: absolute;
                width: 5px;
                height: 5px;
                background-color: yellow;
                border-radius: 50%;
                box-shadow: 0 0 5px #fff;
                animation: sparkle-animation 1s infinite;
            }

            @keyframes sparkle-animation {
                0% {
                    opacity: 0;
                    transform: scale(0);
                }

                50% {
                    opacity: 1;
                    transform: scale(1.5);
                }

                100% {
                    opacity: 0;
                    transform: scale(0);
                }
            }
        </style>

        <script>
            function createSparkle() {
                const sparkle = document.createElement("div");
                sparkle.classList.add("sparkle");

                const size = Math.random() * 5 + 3; // Random size
                sparkle.style.width = `${size}px`;
                sparkle.style.height = `${size}px`;

                const x = Math.random() * 100; // Random X position
                const y = Math.random() * 100; // Random Y position

                sparkle.style.left = `${x}%`;
                sparkle.style.top = `${y}%`;

                document.querySelector(".sparkles").appendChild(sparkle);

                setTimeout(() => sparkle.remove(), 1000); // Remove after animation
            }

            setInterval(createSparkle, 200); // Create sparkles every 200ms
        </script>
        <div class="modal fade" id="alertLessonSuccess" tabindex="-1" aria-labelledby="alertLessonSuccessLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="d-flex justify-content-center sparkling-text">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#198754" width="100px" height="100px" viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve">
                                <path d="M26,2C12.7,2,2,12.7,2,26s10.7,24,24,24s24-10.7,24-24S39.3,2,26,2z M39.4,20L24.1,35.5  c-0.6,0.6-1.6,0.6-2.2,0L13.5,27c-0.6-0.6-0.6-1.6,0-2.2l2.2-2.2c0.6-0.6,1.6-0.6,2.2,0l4.4,4.5c0.4,0.4,1.1,0.4,1.5,0L35,15.5  c0.6-0.6,1.6-0.6,2.2,0l2.2,2.2C40.1,18.3,40.1,19.3,39.4,20z" />
                            </svg>
                            <div class="sparkles"></div>
                        </div>
                        <div>Congratulations✨! You've successfully added new admins.</div>
                        <div class="fs-7 text-muted mt-3 mb-2" id="numberAdded"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addLessonModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLessonModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl modal-fullscreen-down" style="min-width: 85%; min-height: 95%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addLessonModalLabel">Register Lessons</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Form with enctype for file upload -->
                    <form id="lessonForm" enctype="multipart/form-data">
                        <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                            <!-- Container for all lesson rows -->
                            <div id="alertIssue" class="fs-7 text-danger">Resolve the issues below</div>
                            <div id="lessonsContainer">
                                <!-- Row 1: Main row (includes author fields) -->
                                <div class="fw-semibold text-muted">
                                    Admin 1:
                                </div>
                                <div class="lesson-row row mb-3" data-row="1">
                                    <!-- Name and Email -->
                                    <div class="col mt-2">
                                        <input type="text" value="" name="name[]" style="min-width:100px" class="form-control" placeholder="Name *" required>
                                        <span class="char-alert text-muted" style="display:none;"></span>
                                    </div>
                                    <div class="col mt-2">
                                        <input type="email" value="" name="email[]" style="min-width:100px" class="form-control" placeholder="Email *" required>
                                        <span class="char-alert text-muted" style="display:none;"></span>
                                    </div>
                                    <!-- Type Select -->
                                    <div class="col mt-2" id="type-container">
                                        <select name="type[]" class="form-control select2 select-form-lesson type-select" required>
                                            <option value="">Select Admin Type *</option>
                                            <option value="middle">Middle</option>
                                            <option value="lower">Lower</option>
                                        </select>
                                    </div>
                                    <hr class="mt-3 mx-auto" style="width:95%">
                                </div>
                            </div>
                            <!-- Add More Button -->
                            <div class="text-end">
                                <button type="button" class="btn btn-outline-success rounded-0 me-3" style="display:none" id="removeLessonRow">Remove</button>
                                <button type="button" class="btn btn-outline-success rounded-0" id="addLessonRow">Add More</button>
                            </div>
                        </div>
                        <p class="mt-2 ms-3">
                            <small>
                                Note: Fields marked with <span class="text-danger">*</span> must be filled.
                            </small>
                        </p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success rounded-0" id="submit-btn-admin">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /////////////////////////////////////////////////////////////// -->

        <div class="text-muted mt-2 mb-2 d-flex justify-content-between" style="font-size:13px">
            <div>
                <span id="admin-btn" class="border rounded bg-light p-2" style="cursor:pointer">Admins</span> <span class="fw-bold profile-btn d-none">></span> <span id="profile-btn" class="border rounded bg-light p-2 profile-btn d-none" style="cursor:pointer">Profile</span>
            </div>
            <div class="text-end" id="newAdmin-btn-container">
                <span data-bs-toggle=" tooltip" title="New Lesson">
                    <button type="button" class="btn btn-success rounded-0" id="newAdmin-btn" data-bs-toggle="modal" data-bs-target="#addLessonModal">
                        New Admin
                    </button>
                </span>
            </div>
        </div>
        <div id="user-container">
            <div class=" mb-3"><span class="user-navLinks active-user-navLinks" data-id="allUsers">All</span><span class="user-navLinks" data-id="noActionUsers">No Action</span><span class="user-navLinks" data-id="bannedUsers">Banned</span><span class="user-navLinks" data-id="deletedUsers">Deleted</span></div>
            <div class="d-flex justify-content-between mb-3">
                <input type="text" class="form-control" id="numberInput" style="width:165px" placeholder="Enter Filter Value">
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
                                <td class="text-center">
                                    <div class="spinner me-2 hideThisLoader" style="width: 70%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                    <div class="spinner me-2" style="width: 100%; height: 40px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div id="message-empty" class="text-muted d-none">No admin was found!</div>
                <div id="user-container-table" class="d-none">
                    <div id="total_count" class="text-muted fs-8"></div>
                    <table class="table table-success table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Profile</th>
                                <th scope="col">Email</th>
                                <th scope="col">Admin Type</th>
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
                                    <p class="text-primary my-2 py-0">
                                    <div class="spinner me-2" style="width: 100%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-7 col-lg-9 ps-md-0">
                            <hr class="d-md-none">

                            <div class=" p-4 d-grid" style="min-height: 130px;">
                                <div class="spinner mb-2" style="width: 60%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="spinner my-0" style="width: 60%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                            </div>
                            <div class=" mt-3" style="min-height: 130px;">
                            </div>
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
                        <div class="text-end mb-2 user-div user-profile-btn-div">
                            <button class="btn btn-outline-success rounded-0  my-1 action-ban " id="action-ban-btn" data-num="" data-user_id="">
                                Ban
                            </button>
                            <button class="fs-7 btn btn-outline-danger rounded-0 ms-1 action-delete" data-can_delete=" no" id=" action-delete-btn" data-num="" data-user_id="">
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-7 col-lg-9 ps-md-0">
                                <hr class="d-md-none">
                                <div class="p-4">
                                    <div>Admin Type: <span id="adminType"></span></div>
                                    <div class="mt-3"><span id="dateJoin" class="fs-7 text-muted"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>

        <script src="js/select2.js"></script>
        <script src="js/admins.js"></script>

        <script>
            $(document).ready(function() {
                $("#admin-link").addClass("active");
                $(".select-form-lesson").select2({
                    placeholder: "Select a value *",
                    width: '100%',
                    minimumResultsForSearch: Infinity // Hides the search box
                });
            })
        </script>
</body>


</html>