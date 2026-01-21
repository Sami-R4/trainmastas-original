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
            if (window.isLoggedIn) {
                window.location.href = 'dashboard.php';
            } else {
                $("#body-contain").css("display", "grid");
            }
        });
    </script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.css">

    <script src="js/bootstrap.js"></script>
    <title>Reset Password - TrainMastas</title>
    <style>
        /* Success outline for form-control */
        .form-control:focus {
            border-color: #28a745;
            /* Bootstrap's green color for success */
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            /* Optional shadow for better visibility */
        }

        .h-effect:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body style="display:flex;height:100vh;align-items:center;">
    <div class="mx-auto" style="width:500px" style="display: none;" id="body-contain">
        <div class="border rounded-0 " style="padding:30px 30px">

            <div class="text-center">
                <img src="image/logo.png" class="mb-3" width="70" alt="TrainMastas Logo">
            </div>
            <h4 class="text-center mb-4">TrainMastas Reset Password</h4>

            <div class="mt-3 mx-auto" style="width: 400px">
                <div id="alert-account" class="text-danger mx-auto text-center" style="font-size: 13px; display: none;">Please address the issue(s) below:</div>

                <!-- Email input -->
                <div class="form-outline mt-3 mb-4 email-element" style="width: 100%">
                    <input type="email" id="email" placeholder="Email" class="form-control rounded-0" style="padding:4.5px 10px" />
                    <span id="email-error" class="text-danger" style="display: none; font-size: 12px;">Invalid email format.</span>
                </div>
                <a id="verifyEmail" class="btn btn-success fw-semibold rounded-0 email-element" style="width:100%;font-size:14px; padding:4.5px">Next</a>

                <!-- Verification Code Div -->
                <div id="verificationDiv-container" class="d-none code-element">
                    <div class="mb-3">
                        <div class="text-center mb-3">A verification code was sent to <br><span id="email-verification" class="text-muted"></span></div>
                        <input type="text" class="form-control rounded-0" id="verificationCode"
                            placeholder="Enter Verification Code"
                            title="Please enter a 6-digit number"
                            required
                            maxlength="6"
                            oninput="handleInput(this)"
                            onpaste="handlePaste(event)">
                        <div id="alertCode" class="text-danger" style="font-size: 12px;"></div>
                    </div>
                    <button type="button" class="btn btn-success rounded-0" id="verifyCodeBtnReset" style="width:100%;font-size:14px; padding:4.5px">Verify</button>
                    <div class="text-center mt-4"><button class="btn btn-light rounded-0" id="attemptVerifyEmail" style="width:100%;font-size:14px; padding:4.5px">Resend</button></div>
                </div>

                <!-- Password Div -->
                <div id="passwordDiv-container" class="password-element d-none">
                    <div id="alertPassword" class="text-danger fs-7 mt-0 mb-1"></div>
                    <div class="mb-0 position-relative">
                        <input type="password" placeholder="Enter New Password" class="form-control rounded-0" id="newPassword">
                        <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle" id="toggleNewPassword">
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
                    <span id="passwordHint" class="text-danger fs-7"></span>

                    <div class="mt-3 position-relative">
                        <input type="password" placeholder="Confirm Password" class="form-control rounded-0" id="confirmPassword">
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
                    <div id="passwordMatch" class="text-danger fs-7"></div>
                    <button type="button" class="btn btn-success rounded-0 mt-3" id="submitPasswordBtn" style="width:100%;font-size:14px; padding:4.5px">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Hide the spin buttons in Chrome, Safari, Edge, and Opera */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hide the spin buttons in Firefox */
        input[type=number] {
            -moz-appearance: textfield;
            /* Use 'textfield' to style it like a standard textbox */
        }

        .border-danger {
            border-color: #dc3545;
            /* Bootstrap's border-danger color */
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            /* Red shadow */
            outline: none;
            /* Remove the default outline */
        }
    </style>
    <script src="js/resetpassword.js"></script>
</body>


</html>