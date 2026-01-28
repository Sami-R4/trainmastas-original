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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <script src="js/bootstrap.js"></script>
    <title>Signup - TrainMastas</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        /* Breadcrumbs */
        .breadcrumb-nav {
            padding: 8px 40px;
            background: transparent;
            border-bottom: none;
            font-size: 14px;
            position: fixed;
            top: 20px;
            left: 1.2em;
            z-index: 50;
        }

        .breadcrumb-brand {
            font-size: 25px;
            font-weight: 700;
            color: #10b981;
            margin-bottom: 4px;
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.5px;
        }

        .breadcrumb-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .breadcrumb-nav a {
            color: #10b981;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .breadcrumb-nav a:hover {
            color: #059669;
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: #d1d5db;
            font-weight: 300;
        }

        .breadcrumb-nav .current {
            color: #6b7280;
            font-weight: 400;
        }

        /* Select2 Styling */
        .select2-selection--multiple {
            background-color: #fff !important;
            border: 1.5px solid #e0e6ed !important;
            border-radius: 8px !important;
            margin-top: 3px !important;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .select2-container--default:active,
        .select2-selection:focus,
        .select2-container--default:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }

        .select2-selection__choice {
            background-color: #dbeafe !important;
            border: 1px solid #93c5fd !important;
            color: #1e40af !important;
            font-family: 'Inter', sans-serif !important;
            border-radius: 4px !important;
        }

        .select2-results__option[aria-selected="true"] {
            color: #6c757d !important;
            cursor: default !important;
            background-color: transparent !important;
            pointer-events: none;
        }

        .select2-selection--single {
            background-color: #fff !important;
            border: 1.5px solid #e0e6ed !important;
            border-radius: 8px !important;
            margin-top: 3px !important;
            margin-bottom: 2px !important;
            padding: 8px 12px !important;
            height: 48px !important;
            outline: none !important;
            transition: all 0.15s ease-in-out;
            color: #333 !important;
            font-family: 'Inter', sans-serif !important;
        }

        .select2-selection--single:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }

        .select2-container--open {
            z-index: 1060 !important;
        }

        .select2-results__option--highlighted {
            background-color: #10b981 !important;
            color: white;
        }

        .select2-container--focus .select2-selection {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }

        .fs-8 {
            font-size: 13px;
        }

        /* Premium Two-Column Layout */
        .signup-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            min-height: 100vh;
            align-items: center;
            margin: 0 auto;
        }

        .signup-hero {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 80px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .signup-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .signup-hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-logo {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 40px;
            letter-spacing: -0.5px;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
            font-family: 'Poppins', sans-serif;
        }

        .hero-subtitle {
            font-size: 16px;
            margin-bottom: 40px;
            line-height: 1.6;
            opacity: 0.95;
            font-weight: 400;
        }

        .hero-benefits {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .hero-benefits li {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            font-size: 15px;
            opacity: 0.9;
        }

        .hero-benefits li svg {
            width: 24px;
            height: 24px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .signup-form-section {
            background: white;
            padding: 30px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 18px;
        }

        .form-logo-small {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
        }

        .form-title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #1f2937;
            font-family: 'Poppins', sans-serif;
        }

        .form-subtitle {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 0;
        }

        .form-group-custom {
            margin-bottom: 14px;
        }

        .form-control {
            background-color: #fff !important;
            border: 1.5px solid #e0e6ed !important;
            border-radius: 8px !important;
            padding: 10px 14px !important;
            height: 42px !important;
            font-size: 13px !important;
            font-family: 'Inter', sans-serif !important;
            transition: all 0.2s ease-in-out !important;
            color: #1f2937 !important;
        }

        .form-control::placeholder {
            color: #9ca3af;
            opacity: 1;
        }

        .form-control:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1) !important;
            outline: none !important;
        }

        .form-outline {
            width: 100%;
        }

        .form-check {
            margin-bottom: 12px;
            padding-left: 0;
        }

        .form-check-input {
            width: 16px;
            height: 16px;
            margin-top: 2px;
            border: 1.5px solid #d1d5db;
            border-radius: 4px;
            cursor: pointer;
            accent-color: #10b981;
        }

        .form-check-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .form-check-label {
            font-size: 12px;
            color: #6b7280;
            margin-left: 8px;
            cursor: pointer;
            line-height: 1.4;
        }

        .form-check-label a {
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .form-check-label a:hover {
            color: #059669;
            text-decoration: underline;
        }

        .btn-signup {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-signup:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .btn-signup:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-login {
            background: white;
            color: #10b981;
            border: 2px solid #10b981;
            border-radius: 8px;
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-login:hover {
            background: #f0fdf4;
            color: #059669;
        }

        .text-danger {
            color: #ef4444 !important;
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }

        .alert-text {
            color: #ef4444;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
            padding: 12px;
            background: #fef2f2;
            border-radius: 6px;
            border-left: 3px solid #ef4444;
        }

        .position-relative {
            position: relative;
        }

        .eye-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .eye-toggle:hover svg {
            stroke: #10b981;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .breadcrumb-nav {
                padding: 8px 30px;
            }

            .signup-container {
                grid-template-columns: 1fr;
                min-height: 100vh;
            }

            .signup-hero {
                padding: 40px 30px;
                min-height: auto;
            }

            .signup-form-section {
                padding: 40px 30px;
            }

            .hero-title {
                font-size: 32px;
            }

            .form-title {
                font-size: 28px;
            }
        }

        @media (max-width: 640px) {
            .breadcrumb-nav {
                display: none;
            }

            .breadcrumb-brand {
                font-size: 16px;
                margin-bottom: 2px;
            }

            .signup-hero {
                display: none;
            }

            .signup-container {
                grid-template-columns: 1fr;
                min-height: 100vh;
                margin-top: 0;
            }

            .signup-form-section {
                padding: 30px 20px;
                overflow-y: auto;
                max-height: 100vh;
            }

            .hero-title {
                font-size: 24px;
            }

            .form-title {
                font-size: 24px;
            }

            .hero-subtitle {
                font-size: 14px;
            }

            .form-subtitle {
                font-size: 13px;
            }

            .form-control {
                font-size: 16px !important;
            }
        }

        .d-none {
            display: none !important;
        }
    </style>

</head>
<script src="js/select2.js"></script>

<body style="display:none;height:100vh;align-items:center;" id="body-contain">
    <!-- Breadcrumbs Header -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-brand">TrainMastas</div>
        <div class="breadcrumb-links">
            <a href="index.php">Home</a>
            <span class="breadcrumb-separator">></span>
            <span class="current">Sign Up</span>
        </div>
    </nav>

    <div class="signup-container">
        <!-- Left Hero Column -->
        <div class="signup-hero">
            <div class="hero-content">
                <h1 class="hero-title">Start Learning Today</h1>
                <p class="hero-subtitle">Join thousands of learners & creators on the most trusted platform for skill development.</p>
                
                <ul class="hero-benefits">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        <span>Learn at your own pace</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        <span>Expert instructors & mentors</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        <span>Industry-recognized certificates</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        <span>Lifetime access to courses</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Right Form Column -->
        <div class="signup-form-section">
            <form class="w-100">
                <div class="form-header">
                    <img src="image/logo.png" alt="TrainMastas" class="form-logo-small">
                    <h2 class="form-title">Create Account</h2>
                    <p class="form-subtitle">Get started on your learning journey</p>
                </div>

                <div class="alert-text d-none" id="alert-div">Please address the issues below:</div>
                <div id="alert-account" class="alert-text" style="display: none;"></div>

                <div class="form-group-custom">
                    <div class="form-outline">
                        <input type="text" id="name" placeholder="Full Name" class="form-control" />
                        <span id="name-error" class="text-danger d-none">Name is required.</span>
                    </div>
                </div>

                <div class="form-group-custom">
                    <div class="form-outline">
                        <input type="email" id="email" placeholder="Email Address" class="form-control" />
                        <span id="email-error" class="text-danger d-none">Email is required.</span>
                    </div>
                </div>

                <div class="form-group-custom">
                    <div class="form-outline position-relative">
                        <input type="password" id="pwd" placeholder="Password" class="form-control" />
                        <button type="button" class="eye-toggle" id="togglePassword">
                            <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none">
                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1 12C1 12 5 20 12 20C19 20 23 12 23 12" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="12" cy="12" r="3" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <svg id="eye-password-slash" class="d-none" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 28 28" fill="none">
                                <path clip-rule="evenodd" d="M22.6928 1.55018C22.3102 1.32626 21.8209 1.45915 21.6 1.84698L19.1533 6.14375C17.4864 5.36351 15.7609 4.96457 14.0142 4.96457C9.32104 4.96457 4.781 7.84644 1.11993 13.2641L1.10541 13.2854L1.09271 13.3038C0.970762 13.4784 0.967649 13.6837 1.0921 13.8563C3.79364 17.8691 6.97705 20.4972 10.3484 21.6018L8.39935 25.0222C8.1784 25.4101 8.30951 25.906 8.69214 26.1299L9.03857 26.3326C9.4212 26.5565 9.91046 26.4237 10.1314 26.0358L23.332 2.86058C23.553 2.47275 23.4219 1.97684 23.0392 1.75291L22.6928 1.55018ZM18.092 8.00705C16.7353 7.40974 15.3654 7.1186 14.0142 7.1186C10.6042 7.1186 7.07416 8.97311 3.93908 12.9239C3.63812 13.3032 3.63812 13.8561 3.93908 14.2354C6.28912 17.197 8.86102 18.9811 11.438 19.689L12.7855 17.3232C11.2462 16.8322 9.97333 15.4627 9.97333 13.5818C9.97333 11.2026 11.7969 9.27368 14.046 9.27368C15.0842 9.27368 16.0317 9.68468 16.7511 10.3612L18.092 8.00705ZM15.639 12.3137C15.2926 11.7767 14.7231 11.4277 14.046 11.4277C12.9205 11.4277 12 12.3906 12 13.5802C12 14.3664 12.8432 15.2851 13.9024 15.3624L15.639 12.3137Z" fill="#9ca3af" fill-rule="evenodd" />
                                <path d="M14.6873 22.1761C19.1311 21.9148 23.4056 19.0687 26.8864 13.931C26.9593 13.8234 27 13.7121 27 13.5797C27 13.4535 26.965 13.3481 26.8956 13.2455C25.5579 11.2677 24.1025 9.62885 22.5652 8.34557L21.506 10.2052C22.3887 10.9653 23.2531 11.87 24.0894 12.9239C24.3904 13.3032 24.3904 13.8561 24.0894 14.2354C21.5676 17.4135 18.7903 19.2357 16.0254 19.827L14.6873 22.1761Z" fill="#9ca3af" />
                            </svg>
                        </button>
                        <span id="pwd-error" class="text-danger d-none">Password is required.</span>
                    </div>
                </div>

                <div class="form-group-custom">
                    <div class="form-outline position-relative">
                        <input type="password" id="cpwd" placeholder="Confirm Password" class="form-control" />
                        <button type="button" class="eye-toggle" id="toggleConfirmPassword">
                            <svg id="eye-confirm-password" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none">
                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1 12C1 12 5 20 12 20C19 20 23 12 23 12" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="12" cy="12" r="3" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <svg id="eye-confirm-password-slash" class="d-none" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 28 28" fill="none">
                                <path clip-rule="evenodd" d="M22.6928 1.55018C22.3102 1.32626 21.8209 1.45915 21.6 1.84698L19.1533 6.14375C17.4864 5.36351 15.7609 4.96457 14.0142 4.96457C9.32104 4.96457 4.781 7.84644 1.11993 13.2641L1.10541 13.2854L1.09271 13.3038C0.970762 13.4784 0.967649 13.6837 1.0921 13.8563C3.79364 17.8691 6.97705 20.4972 10.3484 21.6018L8.39935 25.0222C8.1784 25.4101 8.30951 25.906 8.69214 26.1299L9.03857 26.3326C9.4212 26.5565 9.91046 26.4237 10.1314 26.0358L23.332 2.86058C23.553 2.47275 23.4219 1.97684 23.0392 1.75291L22.6928 1.55018ZM18.092 8.00705C16.7353 7.40974 15.3654 7.1186 14.0142 7.1186C10.6042 7.1186 7.07416 8.97311 3.93908 12.9239C3.63812 13.3032 3.63812 13.8561 3.93908 14.2354C6.28912 17.197 8.86102 18.9811 11.438 19.689L12.7855 17.3232C11.2462 16.8322 9.97333 15.4627 9.97333 13.5818C9.97333 11.2026 11.7969 9.27368 14.046 9.27368C15.0842 9.27368 16.0317 9.68468 16.7511 10.3612L18.092 8.00705ZM15.639 12.3137C15.2926 11.7767 14.7231 11.4277 14.046 11.4277C12.9205 11.4277 12 12.3906 12 13.5802C12 14.3664 12.8432 15.2851 13.9024 15.3624L15.639 12.3137Z" fill="#9ca3af" fill-rule="evenodd" />
                                <path d="M14.6873 22.1761C19.1311 21.9148 23.4056 19.0687 26.8864 13.931C26.9593 13.8234 27 13.7121 27 13.5797C27 13.4535 26.965 13.3481 26.8956 13.2455C25.5579 11.2677 24.1025 9.62885 22.5652 8.34557L21.506 10.2052C22.3887 10.9653 23.2531 11.87 24.0894 12.9239C24.3904 13.3032 24.3904 13.8561 24.0894 14.2354C21.5676 17.4135 18.7903 19.2357 16.0254 19.827L14.6873 22.1761Z" fill="#9ca3af" />
                            </svg>
                        </button>
                        <span id="cpwd-error" class="text-danger d-none">Confirm Password is required.</span>
                    </div>
                </div>

                <div class="form-group-custom">
                    <select id="accountType" class="questions-answer select2">
                        <option value="student">I'm a student</option>
                        <option value="creator">I'm a course creator</option>
                    </select>
                    <span id="accountType-error" class="text-danger d-none">Account Type is required.</span>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="agree" id="check-box2" />
                    <label class="form-check-label" for="check-box2">
                        I acknowledge and accept the TrainMastas <a href="term-of-service.php">Terms of Service</a> and <a href="privacy-policy.php">Privacy Policy</a>.
                    </label>
                </div>

                <button type="button" id="signup" class="btn-signup" disabled>Create Account</button>
                <p style="text-align: center; color: #6b7280; margin-bottom: 8px; font-size: 12px;">
                    Already have an account?
                </p>
                <a href="login.php" class="btn-login">Sign In</a>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Toggle New Password Visibility  
            $('#togglePassword').on('click', function(e) {
                e.preventDefault();
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
            $('#toggleConfirmPassword').on('click', function(e) {
                e.preventDefault();
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

            // Checkbox toggle for signup button
            $('#check-box2').change(function() {
                $('#signup').prop('disabled', !this.checked);
            });

            $(".signup").addClass("active2");
        })
    </script>
    <script src="js/select2.js"></script>
    <script src="js/signup.js"></script>
</body>


</html>