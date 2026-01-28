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
        document.addEventListener('sessionChecked', function() {
            const urlParams = new URLSearchParams(window.location.search); // Get URL parameters  
            const pValue = urlParams.get('p'); // Get the value of 'p'  
            var logged = window.isLoggedIn; // Convert PHP boolean to JS boolean  
            if (!logged) {
                if (!pValue || pValue.trim() === '') { // Check if 'p' is not null or empty  
                    window.location.href = 'index.php'; // Redirect to index.php  
                }
            }
        });
    </script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.css">
    <link href="css/select2.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/premium.css">

    <script src="js/bootstrap.js"></script>
    <title id="page-title">Profile</title>
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


    /* Updated CSS for select element */
    .select2-selection--multiple {
        background-color: #fff !important;
        border: 1px solid #ced4da !important;
        /* Bootstrap's form-control border color */
        border-radius: 0.25rem !important;
        margin-top: 8px !important;
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
        border-radius: 0.25rem !important;
        margin-top: 8px !important;
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

    .icon-profile {
        cursor: pointer;
    }

    .userSocialMedia {
        color: #28a745;
        /* Success color (green) */
        transition: transform 0.3s ease, text-shadow 0.3s ease;
        /* Smooth transition for both properties */
    }

    .userSocialMedia:hover {
        text-shadow: 2px 2px 5px rgba(40, 167, 69, 0.5);
        /* Green shadow */
        transform: translateY(-2px);
        /* Move text up on hover */
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

    /* Enhanced UI Styling */
    main.pt-navbar {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .container.rounded-0 {
        background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin: 20px auto;
        max-width: 1200px;
        border: 1px solid rgba(27,125,58,0.05) !important;
    }

    .border-md-right {
        background: linear-gradient(180deg, rgba(27,125,58,0.04) 0%, rgba(27,125,58,0.02) 100%);
        border: none !important;
        border-radius: 12px 0 0 12px;
        position: relative;
    }

    .border-md-right::after {
        content: '';
        position: absolute;
        right: -1px;
        top: 0;
        bottom: 0;
        width: 1px;
        background: linear-gradient(to bottom, rgba(27,125,58,0.1), transparent, rgba(27,125,58,0.1));
    }

    .m-auto.text-center {
        animation: fadeInDown 0.6s ease-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #userprofile {
        box-shadow: 0 12px 36px rgba(27,125,58,0.2), inset 0 0 0 2px rgba(255,255,255,0.5);
        border: 4px solid #fff;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        padding: 4px;
    }

    #userprofile:hover {
        transform: scale(1.08) rotate(2deg);
        box-shadow: 0 16px 48px rgba(27,125,58,0.3), inset 0 0 0 2px rgba(27,125,58,0.1);
    }

    #username {
        font-weight: 600;
        color: #0f1724;
    }

    #email {
        font-weight: 500;
    }

    .instructor-section .text-center {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .userSocialMedia {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 8px;
        border-radius: 50%;
        background: rgba(27,125,58,0.08);
        display: inline-block;
    }

    .userSocialMedia:hover {
        background: rgba(27,125,58,0.15);
        transform: translateY(-3px) scale(1.1);
        text-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    }

    #description {
        border: none !important;
        background: transparent;
        border-radius: 0;
        padding: 24px 32px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        line-height: 1.7;
        color: #2d3748;
        font-weight: 400;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    #fields {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    #fields > div {
        display: inline-block;
        padding: 10px 16px;
        background: linear-gradient(135deg, rgba(27,125,58,0.08) 0%, rgba(27,125,58,0.04) 100%);
        border: 1px solid rgba(27,125,58,0.12);
        border-radius: 24px;
        font-weight: 500;
        color: #1b7d3a;
        font-size: 0.85rem;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 2px 8px rgba(27,125,58,0.1);
    }

    #fields > div:hover {
        background: linear-gradient(135deg, rgba(27,125,58,0.12) 0%, rgba(27,125,58,0.08) 100%);
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(27,125,58,0.18);
        border-color: rgba(27,125,58,0.2);
    }

    .modal-content {
        border: none !important;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15) !important;
    }

    .modal-header {
        background: linear-gradient(135deg, rgba(27,125,58,0.05), rgba(27,125,58,0.02));
        border-bottom: none !important;
        border-radius: 12px 12px 0 0;
    }

    .modal-title {
        font-weight: 600;
        color: #0f1724;
    }

    .form-control {
        border: none !important;
        border-radius: 8px !important;
        transition: all 0.3s ease;
        background: rgba(27,125,58,0.03);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .form-control:focus {
        border: none !important;
        background: rgba(27,125,58,0.05);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.04), 0 0 0 3px rgba(27,125,58,0.1) !important;
    }

    .btn-success {
        background: linear-gradient(135deg, #1b7d3a 0%, #23a054 100%);
        border: none;
        box-shadow: 0 4px 14px rgba(27,125,58,0.25);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        font-weight: 600;
    }

    .btn-success:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(27,125,58,0.35);
    }

    .btn-success:active {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(27,125,58,0.25);
    }

    .btn-outline-success {
        border: 2px solid #1b7d3a;
        color: #1b7d3a;
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background: #1b7d3a;
        color: #fff;
        transform: translateY(-2px);
    }

    #passwordDiv {
        background: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .modal-dialog-scrollable {
        max-height: 90vh;
    }

    /* End */
</style>

<body style="padding-bottom:20px">
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
    <main class="pt-navbar d-flex d-column">
        <div class="container rounded-0 border p-0 my-auto">
            <div class="row">
                <div class="col-12 col-md-5 col-lg-3  border-md-right">
                    <div class="d-flex d-column">
                        <div class="m-auto text-center p-4">
                            <div class="mb-4">
                                <img src="" class="rounded-circle" alt="username" style="width:120px;height:120px;object-fit:cover" id="userprofile">
                            </div>
                            <div class="d-flex gap-2 justify-content-center mb-3">
                                <button type="button" class="btn btn-success rounded-pill px-3 py-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal" style="box-shadow: 0 4px 12px rgba(27,125,58,0.2); border: none; font-weight: 500; font-size: 0.9rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; margin-right: 6px; vertical-align: -2px;">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <path d="M4.93 4.93a24 24 0 0 0 0 33.86"></path>
                                        <path d="M2.69 6.59L4.93 4.93"></path>
                                    </svg>
                                    Password
                                </button>
                                <button type="button" class="btn btn-success rounded-pill px-3 py-2" data-bs-toggle="modal" data-bs-target="#edit" style="box-shadow: 0 4px 12px rgba(27,125,58,0.2); border: none; font-weight: 500; font-size: 0.9rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 -0.5 25 25" fill="none" style="display: inline-block; margin-right: 6px; vertical-align: -2px;">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.265 4.16231L19.21 5.74531C19.3978 5.9283 19.5031 6.17982 19.5015 6.44201C19.5 6.70421 19.3919 6.9545 19.202 7.13531L17.724 8.93531L12.694 15.0723C12.6069 15.1749 12.4897 15.2473 12.359 15.2793L9.75102 15.8793C9.40496 15.8936 9.10654 15.6384 9.06702 15.2943L9.18902 12.7213C9.19806 12.5899 9.25006 12.4652 9.33702 12.3663L14.15 6.50131L15.845 4.43331C16.1743 3.98505 16.7938 3.86684 17.265 4.16231Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5.5 18.2413C5.08579 18.2413 4.75 18.5771 4.75 18.9913C4.75 19.4056 5.08579 19.7413 5.5 19.7413V18.2413ZM19.2 19.7413C19.6142 19.7413 19.95 19.4056 19.95 18.9913C19.95 18.5771 19.6142 18.2413 19.2 18.2413V19.7413ZM14.8455 6.22062C14.6904 5.83652 14.2534 5.65082 13.8693 5.80586C13.4852 5.9609 13.2995 6.39796 13.4545 6.78206L14.8455 6.22062ZM17.8893 9.66991C18.2933 9.57863 18.5468 9.17711 18.4556 8.77308C18.3643 8.36904 17.9628 8.1155 17.5587 8.20678L17.8893 9.66991ZM5.5 19.7413H19.2V18.2413H5.5V19.7413ZM13.4545 6.78206C13.6872 7.35843 14.165 8.18012 14.8765 8.8128C15.6011 9.45718 16.633 9.95371 17.8893 9.66991L17.5587 8.20678C16.916 8.35198 16.3609 8.12551 15.8733 7.69189C15.3725 7.24656 15.0128 6.63526 14.8455 6.22062L13.4545 6.78206Z" fill="white" />
                                    </svg>
                                    Edit
                                </button>
                            </div>

                            <h3 class="fs-6 mt-2 p-0" id="username" style="font-weight: 700; color: #0f1724;">
                            </h3>
                            <p class="text-success my-2 py-0" id="email">
                            </p>
                            <div class="text-center mt-3 instructor-section">
                                <a href="" class="text-success d-none me-2 " style="text-decoration:none" target="_blank" id="linkedinLink">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="userSocialMedia" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#198754" height="30px" width="30px" version="1.1" id="Layer_1" viewBox="-143 145 512 512" xml:space="preserve">
                                        <path d="M113,145c-141.4,0-256,114.6-256,256s114.6,256,256,256s256-114.6,256-256S254.4,145,113,145z M41.4,508.1H-8.5V348.4h49.9  V508.1z M15.1,328.4h-0.4c-18.1,0-29.8-12.2-29.8-27.7c0-15.8,12.1-27.7,30.5-27.7c18.4,0,29.7,11.9,30.1,27.7  C45.6,316.1,33.9,328.4,15.1,328.4z M241,508.1h-56.6v-82.6c0-21.6-8.8-36.4-28.3-36.4c-14.9,0-23.2,10-27,19.6  c-1.4,3.4-1.2,8.2-1.2,13.1v86.3H71.8c0,0,0.7-146.4,0-159.7h56.1v25.1c3.3-11,21.2-26.6,49.8-26.6c35.5,0,63.3,23,63.3,72.4V508.1z  " />
                                    </svg>
                                </a>
                                <a href="" class="text-success d-none me-2" style="text-decoration:none" target="_blank" id="portfolioLink">
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
                                <span class="text-success d-none me-2 " class="social-media-links" style="text-decoration:none" id="cvLink">
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
                                </span>
                            </div>
                            <div class="text-center mt-2"><span id="dateJoin" class="fs-7 text-muted"></span></div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-7 col-lg-9 ps-md-0">
                    <hr class="d-md-none">
                    <p class="p-4 instructor-section" style="word-wrap: break-word; word-break: break-all; white-space: pre-wrap !important; min-height:130px; background: linear-gradient(135deg, rgba(27,125,58,0.03) 0%, rgba(27,125,58,0.01) 100%); margin: 0;" id="description">

                    </p>
                    <hr class="w-100 instructor-section" id="field-hr">
                    <div class="mt-4 p-4" id="fields">
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alertPassword" class="text-danger fs-7 mt-0 mb-1"></div>
                        <!-- Password Div -->
                        <form id="passwordDiv-container">
                            <input type="text" name="username" id="username" style="display:none;" autocomplete="username" />
                            <div class="mb-0 position-relative">
                                <input type="password" autocomplete="new-password" placeholder="Enter New Password" class="form-control" id="newPassword">
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
                                <input type="password" autocomplete="new-password" placeholder="Confirm Password" class="form-control" id="confirmPassword">
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
                            <button type="button" class="btn btn-success rounded-pill mr-2 mt-3" id="submitPasswordBtn" style="margin-left: auto !important;">Submit</button>
                        </form>

                        <!-- Verification Code Div -->
                        <div id="verificationDiv-container" class="d-none">
                            <div class="mb-3">
                                <div class="text-center mb-3">A verification code was sent to <br><span id="email-verification" class="text-muted"></span></div>
                                <input type="text" class="form-control" id="verificationCode"
                                    placeholder="Enter Verification Code"
                                    title="Please enter a 6-digit number"
                                    required
                                    maxlength="6"
                                    oninput="handleInput(this)"
                                    onpaste="handlePaste(event)">
                            </div>
                            <div id="alertCode" class="text-danger fs-7"></div>
                            <div class="d-flex justify-content-between mt-2">
                                <button type="button" class="btn btn-success rounded-0" id="verifyCodeBtn">Verify</button>
                                <button class="btn btn-light rounded-0" id="attemptNumBtn">Resend</button>
                            </div>
                        </div>
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
    </div>
    <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- End Main --------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->

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
    -------------------------------------------------- User Info --------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
    <div class="d-none mt-5" id="saved_id">
        <div>
            <h3 class="fs-4 fw-semibold my-4 text-center"><span id="userNameLesson"></span> Lessons</h3>
            <div class="border p-4 container" style="height: 85vh; overflow-y: auto; overflow-x: hidden;">
                <p class=" text-muted fs-7 ms-2 mb-1 d-none" id="showing-div">Showing <span id="showing-span">12</span> Courses</p>
                <div class="row d-none" id="course-container">

                </div>
                <!-------------------------------------------------------------------------------------------------
                        ------------------------------------------- Loader ---------------------------------------------
                        --------------------------------------------------------------------------------------------------->
                <div class="row" id="course-loader">
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 my-2">
                        <div style="text-decoration: none;height:450px" class="item d-grid border rounded mx-2 shadow text-black">
                            <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:200px">
                            </div>
                            <div class="px-3 px-lg-4 mt-2">
                                <h4 class="fs-6 my-1" style="word-wrap: break-word; word-break: break-all;">
                                    <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:70px">
                                    </div>
                                </h4>
                                <p class="text-muted fs-7  fw-semibold my-0 py-1">
                                <div class="card-img-top spinner w-50 my-0" role="status" style="padding-bottom:30px">
                                </div>
                                </p>
                                <div class="d-flex my-1">
                                    <div class="card-img-top spinner w-75 my-0" role="status" style="padding-bottom:30px">
                                    </div>
                                </div>
                                <p class="p-free p-price pb-0 fw-bold fs-7 pt-1">
                                <div class="card-img-top spinner w-25 my-0" role="status" style="padding-bottom:30px">
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 my-2">
                        <div style="text-decoration: none;height:450px" class="item d-grid border rounded mx-2 shadow text-black">
                            <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:200px">
                            </div>
                            <div class="px-3 px-lg-4 mt-2">
                                <h4 class="fs-6 my-1" style="word-wrap: break-word; word-break: break-all;">
                                    <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:70px">
                                    </div>
                                </h4>
                                <p class="text-muted fs-7  fw-semibold my-0 py-1">
                                <div class="card-img-top spinner w-50 my-0" role="status" style="padding-bottom:30px">
                                </div>
                                </p>
                                <div class="d-flex my-1">
                                    <div class="card-img-top spinner w-75 my-0" role="status" style="padding-bottom:30px">
                                    </div>
                                </div>
                                <p class="p-free p-price pb-0 fw-bold fs-7 pt-1">
                                <div class="card-img-top spinner w-25 my-0" role="status" style="padding-bottom:30px">
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 my-2">
                        <div style="text-decoration: none;height:450px" class="item d-grid border rounded mx-2 shadow text-black">
                            <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:200px">
                            </div>
                            <div class="px-3 px-lg-4 mt-2">
                                <h4 class="fs-6 my-1" style="word-wrap: break-word; word-break: break-all;">
                                    <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:70px">
                                    </div>
                                </h4>
                                <p class="text-muted fs-7  fw-semibold my-0 py-1">
                                <div class="card-img-top spinner w-50 my-0" role="status" style="padding-bottom:30px">
                                </div>
                                </p>
                                <div class="d-flex my-1">
                                    <div class="card-img-top spinner w-75 my-0" role="status" style="padding-bottom:30px">
                                    </div>
                                </div>
                                <p class="p-free p-price pb-0 fw-bold fs-7 pt-1">
                                <div class="card-img-top spinner w-25 my-0" role="status" style="padding-bottom:30px">
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 d-lg-none d-xl-grid my-2">
                        <div style="text-decoration: none;height:450px" class="item d-grid border rounded mx-2 shadow text-black">
                            <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:200px">
                            </div>
                            <div class="px-3 px-lg-4 mt-2">
                                <h4 class="fs-6 my-1" style="word-wrap: break-word; word-break: break-all;">
                                    <div class="card-img-top spinner w-100 my-0" role="status" style="padding-bottom:70px">
                                    </div>
                                </h4>
                                <p class="text-muted fs-7  fw-semibold my-0 py-1">
                                <div class="card-img-top spinner w-50 my-0" role="status" style="padding-bottom:30px">
                                </div>
                                </p>
                                <div class="d-flex my-1">
                                    <div class="card-img-top spinner w-75 my-0" role="status" style="padding-bottom:30px">
                                    </div>
                                </div>
                                <p class="p-free p-price pb-0 fw-bold fs-7 pt-1">
                                <div class="card-img-top spinner w-25 my-0" role="status" style="padding-bottom:30px">
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>


                </div>
                <!-------------------------------------------------------------------------------------------------
                ------------------------------------------- End Loader ---------------------------------------------
                --------------------------------------------------------------------------------------------------->
            </div>
        </div>
    </div>
    <div class="container text-end d-flex justify-content-center d-none mt-4" id="btn-container">
        <a class="text-black border ms-auto" style="text-decoration:none; border-radius:25px">
            <button id="prevBtn" class="btn pageBtn" style="border-radius:25px">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                    <path d="M15 18l-6-6 6-6"></path>
                </svg>
            </button>
            <span id="pagination-Btn">

            </span>
            <button id="nextBtn" class="btn pageBtn" style="border-radius:25px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs">
                    <path d="M9 18l6-6-6-6"></path>
                </svg>
            </button>
        </a>
    </div>
    <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- End User Info --------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->


    <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- Modal --------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
    <div class="modal fade" id="edit" aria-labelledby="editTitle" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTitle">Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="text-danger alertProfile fs-8"></div>
                        <div class="mb-3">
                            <label for="userinput" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="userinput">
                            <span class="text-danger d-none" id="name-warning">Character limit exceeded.</span>
                        </div>
                        <div class="mb-3">
                            <label for="picture" class="col-form-label">Picture:</label>
                            <input type="file" accept="image/*" class="form-control" id="picture">
                            <span class="text-danger d-none" id="picture-warning">File size exceeds 2MB.</span>

                        </div>
                        <div class="mb-3 instructor-section">
                            <label for="cv" class="col-form-label">CV:</label>
                            <input type="file" accept="application/pdf" class="form-control" id="cv">
                            <span class="text-danger d-none" id="cv-warning">File size exceeds 2MB.</span>
                        </div>
                        <div class="mb-3 instructor-section">
                            <label for="portfolioinput" class="col-form-label">Portfolio:</label>
                            <input type="text" class="form-control" id="portfolioinput">
                            <span class="text-danger d-none" id="portfolioinput-warning">Character limit exceeded.</span>
                        </div>
                        <div class="mb-3 instructor-section">
                            <label for="linkedininput" class="col-form-label">LinkedIn Profile:</label>
                            <input type="text" class="form-control" id="linkedininput">
                            <span class="text-danger d-none" id="linkedininput-warning">Character limit exceeded.</span>
                        </div>
                        <div class="mb-3">
                            <label for="fieldSelect" class="col-form-label">Areas of Interest:</label>
                            <select id="fieldSelect" multiple class="select2 rounded-0">
                                <?php
                                include "skills.php";
                                ?>
                            </select>
                            <span class="text-danger fs-8 my-0 fw-semibold" id="fieldSelect-warning" style="display:none">At least one skill is required.</span>
                        </div>
                        <div class="mb-3 instructor-section">
                            <label for="descriptioninput" class="col-form-label">Description:</label>
                            <textarea class="form-control" style="resize: none;" id="descriptioninput"></textarea>
                            <span class="text-danger d-none" id="descriptioninput-warning">Character limit exceeded.</span>
                        </div>
                        <div class="text-danger alertProfile fs-8"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal" id="close-btn">Close</button>
                    <button type="button" class="btn btn-success rounded-pill" id="save">Save</button>
                    <button class="btn btn-success px-4 rounded-0 d-none my-0" type="button" disabled id="save-loader">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!------------------------------------------------------------------------------------------------------------------
-------------------------------------------------- End Modal --------------------------------------------------------
----------------------------------------------------------------------------------------------------------------->

    <script src="js/select2.js"></script>
    <script src="js/profile.js"></script>
    <script>
        $(document).ready(function() {
            var $select = $('#fieldSelect').select2({
                tags: true,
                maximumSelectionLength: 10,
                width: '100%',
                createTag: function(params) {
                    var term = params.term.trim();
                    if (term.length > 0 && term.length <= 50) { // Set the length limit here
                        return {
                            id: term,
                            text: term,
                            newTag: true // add additional parameters
                        };
                    } else {
                        $("#fieldSelect-warning").text("The skill should not be more than 50 characters.");
                        $("#fieldSelect-warning").show();
                    }
                    // Return null if the term length is not within the limit
                    return null;
                },
                closeOnSelect: false // prevent closing on select
            });

            // Adjust the z-index of the select2 dropdown to ensure it appears above the modal
            $select.on('select2:open', function() {
                $('.select2-container--open').css('z-index', '1060'); // Bootstrap modal z-index is 1050
            });
        });
    </script>

</body>


</html>