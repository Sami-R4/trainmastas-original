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
                alert(isLoggedIn);
                // window.location.href = 'login.php';
            }
        });
    </script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.css">
    <link rel="stylesheet" href="css/premium.css">
    <link href="css/select2.css" rel="stylesheet" />

    <script src="js/bootstrap.js"></script>

    <title>Dashboard - TrainMastas</title>
</head>
<?php
include "navbar.php"
?>
<style>
    /* Tabs */
/* Tabs container */
.tabs-nav {
  display: flex;
  align-items: flex-end;
  border-bottom: 2px solid #e5e7eb;
  margin-top: 2rem;
  margin-left: 5rem;
  flex-wrap: wrap;
  padding: 0 1rem;
}

/* Tab buttons (browser-like) */
.tab-btn {
  padding: 10px 20px;
  background: #f1f5f9;
  border: 1px solid #e5e7eb;
  border-bottom: none;
  cursor: pointer;
  font-weight: 500;
  color: #374151;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  margin-right: 6px;
  position: relative;
  top: 2px;
  font-size: 0.95rem;
}

/* Active tab */
.tab-btn.active {
  background: #ffffff;
  color: linear-gradient(135deg, var(--pm-green) 0%, var(--pm-green-light) 100%);
  border-color: #e5e7eb;
  border-bottom: 2px solid white; /* hides bottom border */
  z-index: 2;
}

.tab-btn.active::after {
  content: "";
  position: absolute;
  left: 0;
  right: 0;
  bottom: -2px;
  height: 2px;
  background: linear-gradient(
    135deg,
    var(--pm-green),
    var(--pm-green-light)
  );
}

.activities-tab,
.courses-tab {
  margin-left: 5em;
  border: 1px solid #e5e7eb;
  border-top: none;
  padding-top: 1rem;
  background: #fff;
}

/* Mobile responsive tabs */
@media (max-width: 768px) {
  .tabs-nav {
    margin-left: 0;
    padding: 0;
    flex-direction: row;
  }

  .tab-btn {
    padding: 8px 16px;
    font-size: 0.85rem;
    margin-right: 4px;
  }

  .activities-tab,
  .courses-tab {
    margin-left: 0;
    border-left: none;
    border-right: none;
    border-bottom: 1px solid #e5e7eb;
  }
}

@media (max-width: 480px) {
  .tabs-nav {
    margin-top: 1rem;
  }

  .tab-btn {
    padding: 8px 12px;
    font-size: 0.75rem;
    margin-right: 2px;
  }

  .activities-tab,
  .courses-tab {
    padding-top: 0.75rem;
  }
}



.activity-hover:hover {
        background-color: rgb(40, 167, 69, 0.5);
    }

.activity-hover {
        transition: background-color 0.3s ease;
    }

    .hv-underline {
        text-decoration: none;
    }

    .hv-underline:hover {
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

    /* Style Pagination Btns */
    .custom-button:hover,
    .custom-button:active {
        border: 1px solid rgb(40, 167, 69);
    }

    .pageBtn {
        border: 1px solid #fff !important;
    }

    .pageBtn:hover {
        border: 1px solid rgb(40, 167, 69) !important;
    }

    .custom-button {
        border: 1px solid rgb(40, 167, 69) !important;
    }

    /* End */

    .payment-nav:hover {
        text-decoration: underline;
        color: rgb(40, 167, 69);
    }

    .activePayment-nav {
        text-decoration: underline;
        color: rgb(40, 167, 69);
    }

    .payment-nav {
        cursor: pointer;
        margin-right: 15px;
        font-size: 17px
    }
</style>

<body style="padding-bottom:20px;" id="body">
    <div id="fullScreenLoader" class="" style="height:100%; align-items:center;justify-content:center;">
        <div class="spinner-circle-1 spinner-grow-customized rounded-circle" role="status" style="background-color:rgba(40, 167, 69,0.5);padding:0.5vh">
        </div>
        <div class="spinner-circle-2 spinner-grow-customized rounded-circle mx-2" role="status" style="background-color:rgba(40, 167, 69,0.5);padding:0.5vh">
        </div>
        <div class="spinner-circle-3 spinner-grow-customized rounded-circle" role="status" style="background-color:rgba(40, 167, 69,0.5);padding:0.5vh">
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- Main ------------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
    <main class="pt-navbar">
        <div class="container" id="main-container">
            <h1 class="fs-3">Welcome Back, <span class="userName"></span></h1>

            <div class="rounded border p-4 mt-3">
                <img src="image/temp.jpg" alt="Student Dashboard" class="" style="height:250px;width:100%;object-fit:cover;">
            </div>
            <div class="rounded border py-4 mt-4 text-center startCreatingCourses instructor-section">
                <div class="mx-3 mb-3">Start earning today by creating courses. Create an engaging course in 20 minutes.</div>
                <a href="addcourse.php" class="btn btn-outline-success rounded-0">Create Course</a>
            </div>

            <div id="verifiedContainerDiv" class="rounded border py-4 mt-4 text-center d-none instructor-section">
                <div class="mx-3 mb-3" id="verify_message">Verify your account today to start producing courses.</div>
                <button class="btn btn-outline-success rounded-0 verify-btn" data-bs-toggle="modal" data-bs-target="#verifyModal">Verify Account</button>
            </div>
            <!-- Modal -->
            <div class="modal fade instructor-section" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verifyModalLabel">Submit account for verification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-btn-fund"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div>
                                <div class="text-danger mb-2 fs-8" id="alertVerify"></div>
                                <div class="mb-4" id="messageVerify">
                                    You are about to verify your account. Please ensure that you complete your profile with all necessary information. You can choose to update your account with your portfolio link (or website), LinkedIn link, or your CV.
                                    Feel free to submit all or just two of these options to proceed.
                                </div>
                                <div class="text-end">
                                    <a href="profile.php" class="btn btn-success rounded-0 d-none" id="verifyProfileLink">Profile Details</a>
                                    <button class="btn btn-success rounded-0 " id="submitAccountForVerification-btn">Submit Account</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div id="verifiedAwaitedDiv" class="rounded border py-4 mt-4 text-center d-none">
                Your account is under verification.
            </div>
        </div>
    </main>

    <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- End Main --------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->


    <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- Activities ------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
    <!-- Fund Button -->
    <div class="text-end container mt-4">
        <button class="btn btn-outline-success rounded-0" data-bs-toggle="modal" data-bs-target="#fundModal">Payment</button>
    </div>
    <!-- Withdraw Modal -->
    <div class="modal fade instructor-section" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawModalLabel">Withdraw Fund</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-btn-fund"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="fund-section1">
                        <div class="mb-4">
                            You are about to withdraw funds from your account. Remember, you can use these funds to register for new courses!
                        </div>
                        <div class="text-center">
                            <button class="btn btn-outline-success me-4 rounded-0" id="reuse-btn">Reuse Fund</button>
                            <a href="withdrawal.php" class="btn btn-outline-success rounded-0">Withdraw Fund</a>
                        </div>
                    </div>

                    <!-- Inside Section 2 -->
                    <div id="fund-section2" class="d-none">
                        <div class="mb-4 mt-2"><span class=" border rounded backToWithdrawal text-muted hv-underline p-3" style="cursor: pointer;">Back to Withdrawal</span></div>
                        <div class="mb-4">
                            Enter the amount to reuse.
                            <input type="number" class="form-control mt-2" id="reuse-amount">
                        </div>
                        <div class="text-end">
                            <button class="btn btn-outline-success me-4 rounded-0" id="confirm-reuse-btn">Reuse</button>
                        </div>
                        <div id="reuse-msg" class="mt-2"></div>
                    </div>
                    <!-- Inside Section 3 -->
                    <div id="fund-section3" class="d-none">
                        <div class="mb-4 mt-2"><span class=" border rounded backToWithdrawal text-muted hv-underline p-3" style="cursor: pointer;">Back to Withdrawal</span></div>
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100px" height="100px" viewBox="0 0 12 12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6 12A6 6 0 106 0a6 6 0 000 12zm2.576-7.02a.75.75 0 00-1.152-.96L5.45 6.389l-.92-.92A.75.75 0 003.47 6.53l1.5 1.5a.75.75 0 001.106-.05l2.5-3z" fill="#198754" />
                            </svg>
                        </div>
                        <div class="my-4 text-center">
                            Congratulations! A total of <span id="fund-balance"></span> has been successfully added to your balance. You’re one step closer to achieving your goals—keep up the great work!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fund Modal -->
    <div class="modal fade " id="fundModal" tabindex="-1" aria-labelledby="fundModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" style="height:100px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fundModalLabel">Payment Transactions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-end mt-2">
                        <a href="recharge.php" target="_blank" class="ms-1 btn btn-outline-success rounded-0 me-3">Recharge</a>
                        <button class="ms-1 btn btn-outline-success rounded-0 instructor-section payment-nav-stat-divs" data-bs-dismiss="modal" id="withdraw-bnt">Withdraw</button>
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center payment-nav-stat-divs" id="containerStats">
                        <div class="pe-1 pe-sm-2 pe-xl-4">
                            <div id="added-funds" class="text-center border rounded-3 p-2 py-3 p-sm-4">
                                Recharged
                                <span>$0</span>
                            </div>
                        </div>

                        <div class="p-1 p-sm-2">
                            <div id="spent-funds" class="text-center border rounded-3 p-2 py-3 p-sm-4">
                                Spent
                                <span>$0</span>
                            </div>
                        </div>

                        <div class="p-1 p-sm-2 instructor-section">
                            <div id="available-funds" class="text-center border rounded-3 p-2 py-3 p-sm-4">
                                Available
                                <span>$0</span>
                            </div>
                        </div>
                        <div class="p-1 p-sm-2 instructor-section">
                            <div id="pending-funds" class="text-center border rounded-3 p-2 py-3 p-sm-4">
                                Pending
                                <span>$0</span>
                            </div>
                        </div>
                        <div class="ps-1 ps-sm-2 pe-2 pe-sm-3 instructor-section">
                            <div id="withdrew-funds" class="text-center border rounded-3 p-2 py-3 p-sm-4">
                                Withdrew
                                <span>$0</span>
                            </div>
                        </div>

                    </div>
                    <div class="my-2 payment-nav-stat-divs">
                        <span class="payment-nav activePayment-nav" data-id="added">Recharged</span>
                        <span class="payment-nav" data-id="transactions">Spent</span>
                        <span class="payment-nav instructor-section" data-id="ready">Successful</span>
                        <span class="payment-nav instructor-section" data-id="pending">Pending</span>
                        <span class="payment-nav instructor-section" data-id="withdrew">Withdrew</span>
                    </div>


                    <div class="table-div" id="table-div">
                        <div id="filter-select-div">
                            <select id="filter-select" class="select2">
                                <option></option>
                                <option value="all">All</option>
                                <option value="cer">Certificate</option>
                                <option value="fee">Fee</option>
                            </select>
                        </div>
                        <!-- Transaction Table -->
                        <div style="overflow-x: auto;" class="mt-3" id="paymentCourseDiv">
                            <table class="table table-success table-striped table-hover" style="min-width:330px">
                                <thead id="table-fund-header">
                                    <!-- <tr>
                                        <th scope="col">Transaction #</th>
                                        <th scope="col">Course Name</th>
                                        <th scope="col">Purpose</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Date</th>
                                    </tr> -->
                                </thead>
                                <tbody id="transaction-table-body">
                                    <!-- Dynamically populated rows will go here -->
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div id="payment-empty" class="text-muted text-center my-3"></div>
                    <div class="py-3 d-none" id="course-payment-loader">
                        <!-- Simulate a table structure -->
                        <hr class="py-0 my-0 mb-1">
                        <div class="loader-table" style="width: 100%; border-collapse: collapse;">
                            <!-- Table header -->
                            <style>
                                .loader-cell {
                                    padding: 30px;
                                }
                            </style>
                            <div class="loader-row" style="display: flex; border-bottom: 1px solid rgba(0, 0, 0, 0.1); padding: 10px 0;">
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.2);"></div>
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.2);"></div>
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.2);"></div>
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.2);"></div>
                            </div>
                            <!-- Table row 1 -->
                            <div class="loader-row" style="display: flex; border-bottom: 1px solid rgba(0, 0, 0, 0.1); padding: 10px 0;">
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
                            </div>
                            <!-- Table row 2 -->
                            <div class="loader-row" style="display: flex; padding: 10px 0;">
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
                                <div class="loader-cell spinner" style="width: 25%; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
                            </div>
                        </div>
                        <hr class="py-0 my-0 mt-1">
                    </div>
                    <div class="col-12 text-end d-flex justify-content-center d-none mt-4 " id="btn-containerPaymentCourse">
                        <a class="text-black border ms-auto" style="text-decoration:none; border-radius:25px">
                            <button id="prevBtnPaymentCourse" class="btn pageBtn" style="border-radius:25px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                    <path d="M15 18l-6-6 6-6"></path>
                                </svg>
                            </button>
                            <span id="pagination-BtnPaymentCourse">

                            </span>
                            <button id="nextBtnPaymentCourse" class="btn pageBtn" style="border-radius:25px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                    <path d="M9 18l6-6-6-6"></path>
                                </svg>
                            </button>
                        </a>
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabs Navigation -->
<div class="tabs-nav mb-3">
  <button id="tab-activities-btn" class="tab-btn active pm-btn-green">
    Activities
  </button>

  <button id="tab-courses-btn" class="tab-btn pm-btn-green">
    Registered Courses
  </button>
</div>
<div class="activities-tab" id="activities-tab">
    
        <section class="student-section" id="activityCourseDiv">
            <div class="container">
                <div class="rounded border p-4 mt-3">
                    <p class="fs-6 text-muted fw-semibold mb-2">Activities <span id="activity-num">(2)</span></p>
                    <hr class="py-0 my-0 mb-3">
                    <div class="mb-3 d-none" id="course-activities-loader">
                        <hr class="py-0 my-0 mb-3">
                        <div class="spinner mx-2" role="status"
                            style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:7vh;width:34px;">
                        </div>
                        <div class="spinner w-25 mb-1" role="status"
                            style="background-color:rgba(56, 182, 255, 0.2);padding-bottom:4vh">
                        </div>
                        <hr class="py-0 my-0 mt-3">
                    </div>
                    <div id="course-activities">
    
                        <a href="#" style="text-decoration: none;" class="text-black d-block px-2 py-3 activity-hover">
                            <span class="me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="36px" height="40px" viewBox="0 0 1920 1920">
                                    <path d="M1801.441 0v1920H219.03v-439.216h-56.514c-31.196 0-56.515-25.299-56.515-56.47 0-31.172 25.319-56.47 56.515-56.47h56.514V1029.02h-56.514c-31.196 0-56.515-25.3-56.515-56.471 0-31.172 25.319-56.47 56.515-56.47h56.514V577.254h-56.514c-31.196 0-56.515-25.299-56.515-56.47 0-31.172 25.319-56.471 56.515-56.471h56.514V0h1582.412Zm-113.03 112.941H332.06v351.373h56.515c31.196 0 56.514 25.299 56.514 56.47 0 31.172-25.318 56.47-56.514 56.47H332.06v338.824h56.515c31.196 0 56.514 25.3 56.514 56.471 0 31.172-25.318 56.47-56.514 56.47H332.06v338.824h56.515c31.196 0 56.514 25.299 56.514 56.47 0 31.172-25.318 56.471-56.514 56.471H332.06v326.275h1356.353V112.94ZM640.289 425.201H1388.9v112.94H640.288v-112.94Zm0 214.83h639.439v112.94h-639.44v-112.94Zm0 534.845H1388.9v112.94H640.288v-112.94Zm0 214.83h639.439v112.94h-639.44v-112.94Z" fill-rule="evenodd" />
                                </svg>
                            </span>
                            <span>
                                Module 1 of Master Coding in 4 Days
                            </span>
                        </a>
                        <hr class="py-0 my-0">
    
                        <a href="#" style="text-decoration: none;" class="text-black d-block px-2 py-3 activity-hover">
                            <span class="me-2 ">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="40px" width="40px" version="1.1" id="Layer_1" viewBox="0 0 512 512" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M434.087,42.402h-93.284h-28.318C305.306,17.472,282.542,0,256,0s-49.305,17.472-56.485,42.402h-28.318H77.913    c-4.391,0-7.95,3.559-7.95,7.95V504.05c0,4.392,3.56,7.95,7.95,7.95h356.174c4.391,0,7.95-3.559,7.95-7.95V50.352    C442.037,45.96,438.478,42.402,434.087,42.402z M179.147,84.273V58.302h26.688c0.038,0,0.075-0.005,0.113-0.005    c0.174-0.002,0.347-0.013,0.518-0.027c0.092-0.007,0.184-0.014,0.276-0.023c0.172-0.019,0.34-0.047,0.509-0.077    c0.092-0.017,0.184-0.032,0.276-0.051c0.159-0.035,0.315-0.077,0.471-0.121c0.098-0.028,0.195-0.053,0.29-0.085    c0.145-0.047,0.286-0.102,0.427-0.156c0.101-0.039,0.202-0.077,0.301-0.12c0.134-0.058,0.262-0.124,0.391-0.189    c0.1-0.05,0.2-0.099,0.297-0.154c0.127-0.071,0.25-0.148,0.373-0.227c0.091-0.057,0.183-0.113,0.272-0.175    c0.125-0.086,0.244-0.179,0.364-0.272c0.08-0.061,0.16-0.122,0.237-0.187c0.122-0.102,0.237-0.211,0.353-0.321    c0.068-0.065,0.137-0.127,0.202-0.194c0.115-0.117,0.222-0.239,0.329-0.363c0.059-0.069,0.122-0.137,0.179-0.208    c0.101-0.124,0.194-0.253,0.287-0.384c0.057-0.08,0.116-0.158,0.17-0.24c0.082-0.124,0.157-0.252,0.232-0.382    c0.056-0.097,0.115-0.194,0.166-0.294c0.061-0.118,0.118-0.239,0.174-0.36c0.055-0.12,0.111-0.238,0.161-0.361    c0.043-0.108,0.082-0.218,0.121-0.329c0.05-0.142,0.1-0.285,0.141-0.43c0.03-0.102,0.054-0.206,0.079-0.31    c0.038-0.156,0.074-0.312,0.104-0.472c0.007-0.04,0.019-0.08,0.026-0.12c3.479-20.726,21.278-35.768,42.324-35.768    c21.045,0,38.846,15.042,42.324,35.767c0.007,0.044,0.02,0.086,0.028,0.129c0.024,0.13,0.053,0.26,0.084,0.388    c0.028,0.118,0.057,0.235,0.09,0.351c0.035,0.123,0.073,0.243,0.113,0.364c0.041,0.122,0.086,0.243,0.133,0.362    c0.042,0.107,0.085,0.213,0.131,0.318c0.058,0.13,0.121,0.258,0.185,0.385c0.046,0.089,0.09,0.178,0.139,0.265    c0.078,0.14,0.162,0.275,0.248,0.408c0.046,0.071,0.088,0.142,0.136,0.212c0.103,0.151,0.213,0.294,0.325,0.436    c0.038,0.049,0.074,0.101,0.115,0.148c0.156,0.187,0.318,0.368,0.49,0.539c0.001,0.001,0.002,0.002,0.003,0.003    c0.172,0.171,0.351,0.333,0.536,0.488c0.071,0.059,0.147,0.112,0.221,0.17c0.116,0.09,0.231,0.18,0.352,0.263    c0.094,0.066,0.193,0.125,0.29,0.185c0.106,0.067,0.212,0.134,0.321,0.195c0.105,0.059,0.212,0.113,0.32,0.167    c0.11,0.056,0.221,0.11,0.334,0.161c0.108,0.049,0.217,0.093,0.328,0.137c0.122,0.049,0.245,0.093,0.37,0.136    c0.105,0.035,0.209,0.07,0.316,0.102c0.144,0.042,0.289,0.078,0.436,0.112c0.092,0.021,0.182,0.044,0.276,0.063    c0.186,0.036,0.374,0.063,0.563,0.086c0.058,0.007,0.117,0.018,0.175,0.023c0.255,0.025,0.513,0.04,0.774,0.04    c0.004,0,0.008-0.001,0.013-0.001h26.685v25.971v21.732H179.147V84.273z M171.197,121.905h169.607c4.391,0,7.95-3.559,7.95-7.95    V92.224h43.462v293.631h-72.613c-4.391,0-7.95,3.559-7.95,7.95v72.613H119.785V92.224h43.462v21.731    C163.246,118.346,166.806,121.905,171.197,121.905z M380.971,401.756l-53.419,53.419v-53.419H380.971z M426.137,496.099H85.863    V58.302h77.383v18.021h-51.412c-4.391,0-7.95,3.559-7.95,7.95v390.095c0,4.392,3.56,7.95,7.95,7.95h207.768    c0.262,0,0.524-0.014,0.784-0.039c0.12-0.012,0.235-0.034,0.354-0.051c0.138-0.02,0.278-0.036,0.414-0.064    c0.136-0.026,0.266-0.064,0.399-0.098c0.119-0.03,0.239-0.056,0.355-0.091c0.129-0.039,0.254-0.088,0.382-0.134    c0.118-0.042,0.236-0.082,0.353-0.129c0.119-0.049,0.233-0.107,0.349-0.162c0.119-0.056,0.24-0.109,0.356-0.172    c0.111-0.059,0.216-0.127,0.324-0.192c0.115-0.069,0.231-0.134,0.343-0.209c0.118-0.078,0.228-0.165,0.34-0.25    c0.095-0.071,0.192-0.137,0.284-0.212c0.19-0.156,0.371-0.32,0.545-0.493c0.012-0.013,0.025-0.022,0.037-0.034l80.563-80.563    c0.011-0.011,0.019-0.022,0.03-0.033c0.174-0.176,0.34-0.358,0.497-0.549c0.075-0.092,0.141-0.189,0.212-0.284    c0.085-0.113,0.173-0.224,0.251-0.341c0.075-0.113,0.141-0.23,0.211-0.347c0.064-0.106,0.13-0.211,0.189-0.32    c0.064-0.12,0.119-0.243,0.176-0.365c0.053-0.113,0.109-0.224,0.158-0.339c0.05-0.12,0.089-0.242,0.133-0.363    c0.044-0.123,0.092-0.246,0.13-0.372c0.037-0.122,0.064-0.245,0.094-0.368c0.032-0.128,0.068-0.255,0.094-0.386    c0.029-0.144,0.046-0.288,0.066-0.434c0.016-0.112,0.037-0.223,0.049-0.336c0.025-0.262,0.04-0.526,0.039-0.789V84.273    c0-4.392-3.56-7.95-7.95-7.95h-51.411V58.302h77.383V496.099z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M256,152.646c-55.821,0-101.234,45.413-101.234,101.234c0,55.821,45.413,101.234,101.234,101.234    s101.234-45.413,101.234-101.234C357.234,198.059,311.821,152.646,256,152.646z M256,339.213    c-47.053,0-85.333-38.28-85.333-85.333c0-47.053,38.28-85.333,85.333-85.333s85.333,38.28,85.333,85.333    C341.333,300.933,303.053,339.213,256,339.213z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M304.023,212.216c-3.105-3.104-8.139-3.104-11.243,0l-68.581,68.583l-19.82-19.82c-3.105-3.104-8.139-3.104-11.243,0    c-3.105,3.106-3.105,8.139,0,11.244l25.441,25.441c1.552,1.552,3.587,2.328,5.621,2.328c2.034,0,4.07-0.776,5.621-2.328    l74.203-74.203C307.128,220.355,307.128,215.322,304.023,212.216z" />
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span>
                                Quiz of Master Coding in 4 Days
                            </span>
                        </a>
                        <hr class="py-0 my-0">
                    </div>
                    <div class="col-12 text-end d-flex justify-content-center d-none mt-4" id="btn-containerActivityCourse">
                        <a class="text-black border ms-auto" style="text-decoration:none; border-radius:25px">
                            <button id="prevBtnActivityCourse" class="btn pageBtn" style="border-radius:25px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                    <path d="M15 18l-6-6 6-6"></path>
                                </svg>
                            </button>
                            <span id="pagination-BtnActivityCourse">
    
                            </span>
                            <button id="nextBtnActivityCourse" class="btn pageBtn" style="border-radius:25px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                                    <path d="M9 18l6-6-6-6"></path>
                                </svg>
                            </button>
                        </a>
                    </div>
    
                </div>
            </div>
        </section>
</div>
    <!------------------------------------------------------------------------------------------------------------------
    ---------------------------------------------- End Activities ------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->


    <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- Your Courses ------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
    <div class="courses-tab" id="courses-tab" style="display: none;">
        <section class="pt-4 student-section" id="registeredCourseDiv">
            <div class="container">
                <div class="rounded border p-4 mt-3">
                    <p class="fs-6 text-muted fw-semibold mb-0">Registered Courses <span id="registered-num">(5)</span></p>
                    <hr class="py-0 my-0 mt-3">
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
                    </div>
                    <div>
                        <!-- <div class="text-muted mb-3 col-6 col-md-4 col-lg-3 col-xl-2">
                            <select id="type" class="select2 form-control">
                                <option selected disabled>Sort by</option>
                                <option value="free">Free</option>
                                <option value="premium">Premium</option>
                            </select>
                        </div> -->
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
            </div>
        </section>
    </div>
    <!------------------------------------------------------------------------------------------------------------------
    ---------------------------------------------- End Your Courses ------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->

    <!------------------------------------------------------------------------------------------------------------------
    ----------------------------------------------- Instructor Courses -------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
    <section style="margin-bottom:60px" id="createdCourseDiv">
        <div class="container pt-4 startCreatingCourses instructor-section">
            <div class="rounded border p-4 mt-3">
                <p class="fs-6 text-muted fw-semibold mb-0">Courses Created <span id="created-num">(5)</span></p>
                <hr class="py-0 my-0 mb-3">
                <div class="py-3 d-none" id="course-created-loader">
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
                <div id="course-created">
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

                <!-- <div class="text-center py-2">
                    <hr class="py-0 mb-3 mt-0">
                    You created no courses
                    <div class="mt-3">
                        <a href="courses.php" class="btn btn-outline-success rounded-0">Start Creating</a>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
    <!------------------------------------------------------------------------------------------------------------------
    ---------------------------------------------- End Instructor Courses ------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->

    <script src="js/dashboard.js"></script>
    <script src="js/select2.js"></script>
    <script>

        // TABS        
        const activitiesBtn = document.getElementById("tab-activities-btn");
  const coursesBtn = document.getElementById("tab-courses-btn");

  const activitiesTab = document.getElementById("activities-tab");
  const coursesTab = document.getElementById("courses-tab");

  activitiesBtn.addEventListener("click", () => {
    activitiesTab.style.display = "block";
    coursesTab.style.display = "none";

    activitiesBtn.classList.add("active");
    coursesBtn.classList.remove("active");
  });

  coursesBtn.addEventListener("click", () => {
    coursesTab.style.display = "block";
    activitiesTab.style.display = "none";

    coursesBtn.classList.add("active");
    activitiesBtn.classList.remove("active");
  });

        $(document).ready(function() {
            // $(".dashboard").addClass("active2");
            function determineActive() {
                const hash = window.location.hash;
                // Check if there is a hash value  
                if (hash) {
                    if (hash === '#createdCourseDiv') {
                        $(".dashboard").removeClass("active2");
                        $(".registeredCourse").removeClass("active2");
                        $(".createdCourse").addClass("active2");
                    } else if (hash === '#registeredCourseDiv') {
                        $(".dashboard").removeClass("active2");
                        $(".createdCourse").removeClass("active2");
                        $(".registeredCourse").addClass("active2");
                    } else {
                        $(".dashboard").addClass("active2");
                        $(".createdCourse").removeClass("active2");
                        $(".registeredCourse").removeClass("active2");
                    }
                } else {
                    $(".dashboard").addClass("active2");
                    $(".createdCourse").removeClass("active2");
                    $(".registeredCourse").removeClass("active2");
                }
            }
            $(".registeredCourse, .createdCourse").click(function() {
                setTimeout(function() {
                    determineActive();
                    $("#offcanvasNavbar").offcanvas('hide');
                }, 200);
            })
            determineActive();

            $('#type').select2({
                placeholder: 'Sort by', // Placeholder text
                width: '100%', // Width of the select box
                minimumResultsForSearch: Infinity // Disable search functionality
                // Additional options can be added here
            });
            $("#filter-select").select2({
                placeholder: "Filter by..",
                width: '20%',
                minimumResultsForSearch: Infinity // Hides the search box
            });
        })
    </script>
</body>


</html>