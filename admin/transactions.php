<?php
include "app/session_checker.php";

if (!$isLoggedIn) {
    // transaction is not logged in, redirect to login page  
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
    <title id="page-title">Transactions Management - TrainMastas</title>
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

            .hover:hover {
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

            .transaction-navLinks {
                font-size: 13px;
                color: rgb(46, 49, 47);
                margin-right: 25px;
                cursor: pointer;
            }

            .transaction-navLinks:hover {
                text-decoration: underline;
                color: #28a745;
            }

            .active-transaction-navLinks {
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
        <div class="text-muted mb-3" style="font-size:13px"><span id="admin-btn" class="border  rounded bg-light p-2" style="cursor:pointer">All Transactions</span> <span class="fw-bold profile-btn d-none">></span> <span id="profile-btn" class="border rounded bg-light p-2 profile-btn d-none" style="cursor:pointer">Transaction</span></div>
        <div id="transaction-container">
            <div class=" mb-3"><span class="transaction-navLinks active-transaction-navLinks" data-id="course_payment">Course Payment</span><span class="transaction-navLinks" data-id="payment">Payment</span></div>
            <div class="d-flex justify-content-between mb-3">
                <select class="select2" id="transactionState">
                    <option value=""></option>
                    <option value="all">All</option>
                    <option value="ready">Ready</option>
                    <option value="pending">Pending</option>
                    <option value="withdrew">Done</option>
                </select>
                <select class="select2" id="transactionType">
                    <option value=""></option>
                    <option value="all">All</option>
                    <option value="fee">Fees</option>
                    <option value="cer">Certificate</option>
                </select>
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
                            Are you sure you want to clear all this transaction? All the information of the transaction will be deleted, and the transaction won't be able to access TrainMastas anymore with this email.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal" id="confirmClear">Yes, clear all</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="transaction-message" class="d-none text-muted"></div>

            <div style=" width: 100%; overflow: auto;" id="transactionDiv">
                <div id="transaction-loader">
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
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div id="message-empty" class="text-muted d-none">No transaction was found!</div>
                <div id="transaction-container-table" class="d-none">
                    <div id="total_count" class="text-muted fs-8"></div>
                    <table class="table table-success table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Initiator</th>
                                <th scope="col">Purpose</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody id="transaction-div" class="transaction-div">
                        </tbody>
                    </table>
                    <div class="col-12 text-end d-flex justify-content-center d-none mt-4 table-div" id="btn-containertransaction">
                        <a class="text-black border ms-auto" style="text-decoration:none; border-radius:25px">
                            <button id="prevBtntransaction" class="btn pageBtn" style="border-radius:25px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                    <path d="M15 18l-6-6 6-6"></path>
                                </svg>
                            </button>
                            <span id="pagination-Btntransaction">

                            </span>
                            <button id="nextBtntransaction" class="btn pageBtn" style="border-radius:25px">
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
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-7 col-lg-9 ps-md-0">
                            <hr class="d-md-none">
                            <div>
                                <div class="spinner m-4" style="width: 80%; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                            </div>
                            <div class="d-flex justify-content-between row" style="margin:13px">
                                <div class="col my-1">
                                    <div class="spinner mb-2" style="width: 70px; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </div>
                                <div class="col my-1">
                                    <div class="spinner mb-2" style="width: 70px; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </div>
                                <div class="col my-1">
                                    <div class="spinner mb-2" style="width: 70px; height: 30px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                </div>
                            </div>
                            <div class=" p-4 d-grid" style="min-height: 130px;">
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
                <section class="pt-4" style="margin:0 14px" id="transactionProfileDiv">
                    <div class="">
                        <div class="row border">
                            <div class="col-12 col-md-5 col-lg-3  border-md-right">
                                <div class="d-flex d-column">
                                    <div class="m-auto text-center p-4">
                                        <div class="mb-3">
                                            <img src="" class="rounded-circle" alt="transactionname" style="width:100px;height:100px;object-fit:cover" id="transactionprofile">
                                        </div>
                                        <a href="" target="_blank" class="text-black hover fs-6 fw-semibold mt-3 p-0" id="transactionname">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-7 col-lg-9 ps-md-0">
                                <hr class="d-md-none">
                                <div class="p-4">
                                    <div class="mb-3">
                                        <a href="" target="_blank" class="text-black hover fs-6 fw-bold mt-3 p-0" id="Title">
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between row">
                                        <div class="col my-1">
                                            <b>Payment Method:</b> <span id="Payment_method"></span>
                                        </div>
                                        <div class="col my-1">
                                            <b>Purpose:</b> <span id="Purpose"></span>
                                        </div>
                                        <div class="col my-1"><b>State: </b><span id="State"></span></div>
                                    </div>
                                    <div class="mt-3"><span id="dateJoin" class="fs-7 text-muted"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>


</body>
<script src="js/transactions.js"></script>
<script src="js/select2.js"></script>

<script>
    $(document).ready(function() {
        $("#transaction-link").addClass("active");
        $('#transactionType').select2({
            placeholder: "Select filter value",
            minimumResultsForSearch: Infinity,
            width: '100px'
        });
        $('#transactionState').select2({
            placeholder: "Select filter value",
            minimumResultsForSearch: Infinity,
            width: '100px'
        });
    })
</script>

</html>