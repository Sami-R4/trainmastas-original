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
            if (isLoggedIn) {
                window.location.href = 'dashboard.php';
            } else {
                $(document).ready(function () {
                    $("#body-contain").css('display',"flex");
                });
            }
        });
    </script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.css">
    <link href="css/select2.css" rel="stylesheet" />

    <script src="js/bootstrap.js"></script>
    <title>Signup - TrainMastas</title>
    <style>
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
            border-color: gainsboro;
            /* Default border color */
        }

        .fs-8 {
            font-size: 13px;
        }
    </style>
</head>
<script src="js/select2.js"></script>

<body style="display:none;height:100vh;align-items:center;" id="body-contain">
    <div class="container">
        <form class="border rounded-0 col-12 col-sm-8 col-md-6 col-xl-5 mx-auto" style="padding:30px 30px">

            <div class="text-center">
                <img src="image/logo.png" class="mb-3" width="70" alt="TrainMastas Logo">
            </div>
            <h4 class="text-center mb-4">Sign up to TrainMastas</h4>

            <div class="mt-3 mx-auto">
                <div class="text-danger my-0 p-0 d-none" id="alert-div">Please address the issues below:</div>
                <div id="alert-account" class="text-danger mx-auto text-center" style="font-size: 13px; width:400px"></div>
                <div class="form-outline" style="width: 100%">
                    <input type="text" id="name" placeholder="Name" class="form-control rounded-0" style="padding:4.5px 10px" />
                    <span id="name-error" class="text-danger d-none fs-8">Name is required.</span>
                </div>
                <div class="form-outline mt-3" style="width: 100%">
                    <input type="email" id="email" placeholder="Email" class="form-control rounded-0" style="padding:4.5px 10px" />
                    <span id="email-error" class="text-danger d-none fs-8">Email is required.</span>
                </div>
                <div class="form-outline mt-3" style="width: 100%">
                    <div class="mb-0 position-relative">
                        <input type="password" id="pwd" placeholder="Password" class="form-control rounded-0" style="padding:4.5px 10px" />
                        <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle" id="togglePassword">
                            <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none">
                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1 12C1 12 5 20 12 20C19 20 23 12 23 12" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="12" cy="12" r="3" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <svg id="eye-password-slash" class="d-none" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 28 28" fill="none">
                                <path clip-rule="evenodd" d="M22.6928 1.55018C22.3102 1.32626 21.8209 1.45915 21.6 1.84698L19.1533 6.14375C17.4864 5.36351 15.7609 4.96457 14.0142 4.96457C9.32104 4.96457 4.781 7.84644 1.11993 13.2641L1.10541 13.2854L1.09271 13.3038C0.970762 13.4784 0.967649 13.6837 1.0921 13.8563C3.79364 17.8691 6.97705 20.4972 10.3484 21.6018L8.39935 25.0222C8.1784 25.4101 8.30951 25.906 8.69214 26.1299L9.03857 26.3326C9.4212 26.5565 9.91046 26.4237 10.1314 26.0358L23.332 2.86058C23.553 2.47275 23.4219 1.97684 23.0392 1.75291L22.6928 1.55018ZM18.092 8.00705C16.7353 7.40974 15.3654 7.1186 14.0142 7.1186C10.6042 7.1186 7.07416 8.97311 3.93908 12.9239C3.63812 13.3032 3.63812 13.8561 3.93908 14.2354C6.28912 17.197 8.86102 18.9811 11.438 19.689L12.7855 17.3232C11.2462 16.8322 9.97333 15.4627 9.97333 13.5818C9.97333 11.2026 11.7969 9.27368 14.046 9.27368C15.0842 9.27368 16.0317 9.68468 16.7511 10.3612L18.092 8.00705ZM15.639 12.3137C15.2926 11.7767 14.7231 11.4277 14.046 11.4277C12.9205 11.4277 12 12.3906 12 13.5802C12 14.3664 12.8432 15.2851 13.9024 15.3624L15.639 12.3137Z" fill="#6c757d" fill-rule="evenodd" />
                                <path d="M14.6873 22.1761C19.1311 21.9148 23.4056 19.0687 26.8864 13.931C26.9593 13.8234 27 13.7121 27 13.5797C27 13.4535 26.965 13.3481 26.8956 13.2455C25.5579 11.2677 24.1025 9.62885 22.5652 8.34557L21.506 10.2052C22.3887 10.9653 23.2531 11.87 24.0894 12.9239C24.3904 13.3032 24.3904 13.8561 24.0894 14.2354C21.5676 17.4135 18.7903 19.2357 16.0254 19.827L14.6873 22.1761Z" fill="#6c757d" />
                            </svg>
                        </button>
                    </div>
                    <span id="pwd-error" class="text-danger d-none fs-8">Password is required.</span>
                </div>
                <div class="form-outline mt-3" style="width: 100%">
                    <div class="mt-3 position-relative">
                        <input type="password" id="cpwd" placeholder="Confirm Password" class="form-control rounded-0" style="padding:4.5px 10px" />
                        <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle" id="toggleConfirmPassword">
                            <svg id="eye-confirm-password" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none">
                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1 12C1 12 5 20 12 20C19 20 23 12 23 12" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="12" cy="12" r="3" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <svg id="eye-confirm-password-slash" class="d-none" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 28 28" fill="none">
                                <path clip-rule="evenodd" d="M22.6928 1.55018C22.3102 1.32626 21.8209 1.45915 21.6 1.84698L19.1533 6.14375C17.4864 5.36351 15.7609 4.96457 14.0142 4.96457C9.32104 4.96457 4.781 7.84644 1.11993 13.2641L1.10541 13.2854L1.09271 13.3038C0.970762 13.4784 0.967649 13.6837 1.0921 13.8563C3.79364 17.8691 6.97705 20.4972 10.3484 21.6018L8.39935 25.0222C8.1784 25.4101 8.30951 25.906 8.69214 26.1299L9.03857 26.3326C9.4212 26.5565 9.91046 26.4237 10.1314 26.0358L23.332 2.86058C23.553 2.47275 23.4219 1.97684 23.0392 1.75291L22.6928 1.55018ZM18.092 8.00705C16.7353 7.40974 15.3654 7.1186 14.0142 7.1186C10.6042 7.1186 7.07416 8.97311 3.93908 12.9239C3.63812 13.3032 3.63812 13.8561 3.93908 14.2354C6.28912 17.197 8.86102 18.9811 11.438 19.689L12.7855 17.3232C11.2462 16.8322 9.97333 15.4627 9.97333 13.5818C9.97333 11.2026 11.7969 9.27368 14.046 9.27368C15.0842 9.27368 16.0317 9.68468 16.7511 10.3612L18.092 8.00705ZM15.639 12.3137C15.2926 11.7767 14.7231 11.4277 14.046 11.4277C12.9205 11.4277 12 12.3906 12 13.5802C12 14.3664 12.8432 15.2851 13.9024 15.3624L15.639 12.3137Z" fill="#6c757d" fill-rule="evenodd" />
                                <path d="M14.6873 22.1761C19.1311 21.9148 23.4056 19.0687 26.8864 13.931C26.9593 13.8234 27 13.7121 27 13.5797C27 13.4535 26.965 13.3481 26.8956 13.2455C25.5579 11.2677 24.1025 9.62885 22.5652 8.34557L21.506 10.2052C22.3887 10.9653 23.2531 11.87 24.0894 12.9239C24.3904 13.3032 24.3904 13.8561 24.0894 14.2354C21.5676 17.4135 18.7903 19.2357 16.0254 19.827L14.6873 22.1761Z" fill="#6c757d" />
                            </svg>
                        </button>
                    </div>
                    <span id="cpwd-error" class="text-danger d-none fs-8">Confirm Password is required.</span>
                </div>
                <div class="form-outline mt-3  mb-3" style="width: 100%">
                    <select id="accountType" class="ms-2 questions-answer select2">
                        <!-- <option></option> -->
                        <option value="student">I'm a student</option>
                        <option value="creator">I'm a course creator</option>
                    </select>
                    <span id="accountType-error" class="text-danger d-none fs-7">Account Type is required.</span>
                </div>

                <div class="form-check w-100 ms-2 mb-2">
                    <input class="form-check-input" type="checkbox" value="agree" id="check-box2" />
                    <label class="form-check-label text-muted" style="font-size:14px;" for="check-box2">
                        I acknowledge and accept the TrainMastas <a href="term-of-service.php">Terms of Service</a> and <a
                            href="privacy-policy.php">Privacy Policy</a>.
                    </label>
                </div>
                <script>
                    $(document).ready(function() {
                        // When the checkbox changes  
                        $('#check-box2').change(function() {
                            // Enable the signup button if checked, otherwise disable it  
                            $('#signup').prop('disabled', !this.checked);
                        });
                    });
                </script>
                <!-- Submit button -->
                <button id="signup" class="btn btn-success fw-semibold rounded-0" style="width:100%;font-size:14px; padding:4.5px" disabled>Sign Up</button>
                <div class="mb-0 text-muted mt-2">Already have an account? </div>
                <a href="login.php" id="otherLink" class="btn btn-outline-success rounded-0 mt-2 fw-semibold" style="width:100%;font-size:14px; padding:4.5px">Login</a>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            //////////////////////////////////////////////////////////////
            // Toggle New Password Visibility  
            $('#togglePassword').on('click', function() {
                const newPasswordInput = $('#pwd');
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
            $('#toggleConfirmPassword').on('click', function() {
                const confirmPasswordInput = $('#cpwd');
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
            $(".signup").addClass("active2");
        })
    </script>
    <script src="js/signup.js"></script>
</body>


</html>