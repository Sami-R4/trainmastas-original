<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="./image/logo.png">

    <script src="js/jquery.js"></script>
    <script src="js/session_checker.js"></script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.css">
    <link href="css/select2.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/header.css">
    <script src="js/bootstrap.js"></script>
    <title>Privacy Policy - TrainMastas</title>
    <style>
        @media (max-width: 991px) {
            .btn-modified {
                width: 95%;
                margin-left: 2.5% !important;
                margin-right: 2.5% !important;
            }



            .Welcome-image-cover {
                padding-top: 80px !important;
            }

        }

        @media (min-width: 991px) and (max-width:992px) {
            .Welcome-image-cover {
                padding-top: 77px !important;
            }

        }

        @media (max-width: 575px) {
            .centralized-footer {
                text-align: center;
            }

        }


        .dropdown-item:hover {
            background-color: #38b6ff !important;
        }

        nav {
            z-index: 999;
            background-color: rgb(18, 58, 83);
        }

        a {
            text-decoration: none;
        }

        .nav-link {
            font-size: 14px;
        }

        @media (min-width:992px) {
            .mt-md-7 {
                margin-top: 15vh;
            }

            .mb-md-7 {
                margin-bottom: 11vh;
            }

        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php
    include "navbar.php";
    ?>
    <div class="container" style="padding-top:18vh;">
        <div class="col-12 col-md-10 mx-auto">
            <h2 class="text-muted text-center" style="margin-bottom:7vh">TrainMastas Privacy Policy</h2>

            <p class="fs-6 fw-normal">
                Welcome to TrainMastas – your all-in-one platform for creating and consuming educational content powered by YouTube.
                At TrainMastas, we’re committed to protecting your privacy and ensuring a safe, secure learning environment for all users, whether you're a student or a course creator.
            </p>

            <ol class="mx-5">
                <li class="fw-semibold mb-4">
                    <p class="fs-6 my-3">Information We Collect</p>
                    <ul class="ms-3 fs-6 fw-normal" style="list-style-type:disc;">
                        <li>When users register, we collect your name, email address, and password.</li>
                        <li>Course creators may provide extra profile information to showcase their expertise and course material.</li>
                        <li>Basic technical data such as device type and browser may be logged for security and performance improvements.</li>
                    </ul>
                </li>

                <li class="fw-semibold mb-4">
                    <p class="fs-6 my-3">User Roles and Course Access</p>
                    <ul class="ms-3 fs-6 fw-normal" style="list-style-type:disc;">
                        <li>Users are categorized as either students or course creators.</li>
                        <li>Both students and course creators can register and enroll in courses.</li>
                        <li>Only verified course creators can publish and manage courses.</li>
                    </ul>
                </li>

                <li class="fw-semibold mb-4">
                    <p class="fs-6 my-3">Free and Premium Courses</p>
                    <ul class="ms-3 fs-6 fw-normal" style="list-style-type:disc;">
                        <li>TrainMastas hosts both free and premium courses.</li>
                        <li>Free courses may include exams. If a student wants a certificate after completion, they must pay to obtain it.</li>
                        <li>Premium courses include automatic access to a downloadable certificate upon successful completion of all modules and the final exam.</li>
                    </ul>
                </li>

                <li class="fw-semibold mb-4">
                    <p class="fs-6 my-3">Wallet and Payments</p>
                    <ul class="ms-3 fs-6 fw-normal" style="list-style-type:disc;">
                        <li>Users can add money to their wallet to purchase courses or certificates.</li>
                        <li>Course creators can earn money through their courses and withdraw earnings at any time.</li>
                        <li>All transactions are secured, and sensitive payment data is handled by trusted third-party payment processors.</li>
                    </ul>
                </li>

                <li class="fw-semibold mb-4">
                    <p class="fs-6 my-3">Course Withdrawal and Refunds</p>
                    <ul class="ms-3 fs-6 fw-normal" style="list-style-type:disc;">
                        <li>Users can withdraw from any course before reaching the completion stage.</li>
                        <li>If a user reaches Module 2 or beyond, they can still withdraw, but no refund will be issued.</li>
                        <li>No withdrawals or refunds are permitted once a course is completed and certified.</li>
                    </ul>
                </li>

                <li class="fw-semibold mb-4">
                    <p class="fs-6 my-3">Password and Account Security</p>
                    <ul class="ms-3 fs-6 fw-normal" style="list-style-type:disc;">
                        <li>User passwords are encrypted and securely stored.</li>
                        <li>Password recovery is available via email verification.</li>
                        <li>Your login credentials are private and will never be shared by TrainMastas.</li>
                    </ul>
                </li>

                <li class="fw-semibold mb-4">
                    <p class="fs-6 my-3">Platform Rights and Moderation</p>
                    <ul class="ms-3 fs-6 fw-normal" style="list-style-type:disc;">
                        <li>TrainMastas reserves the right to ban, suspend, or delete any user accounts or courses suspected of malicious activity, fraud, or abuse.</li>
                        <li>This includes, but is not limited to, content that violates our policies or terms of service.</li>
                        <li>Disciplinary actions may be taken without prior notice if a violation is confirmed.</li>
                    </ul>
                </li>

                <li class="fw-semibold mb-4">
                    <p class="fs-6 my-3">Data Protection and Security</p>
                    <ul class="ms-3 fs-6 fw-normal" style="list-style-type:disc;">
                        <li>We use advanced security protocols and encryption to keep your data safe.</li>
                        <li>TrainMastas does not sell or share personal information with third-party companies.</li>
                        <li>All communication is secured using HTTPS and user data access is restricted to authorized personnel only.</li>
                    </ul>
                </li>

                <li class="fw-semibold mb-4">
                    <p class="fs-6 my-3">Updates to This Policy</p>
                    <ul class="ms-3 fs-6 fw-normal" style="list-style-type:disc;">
                        <li>We may revise this Privacy Policy to align with platform improvements or legal requirements.</li>
                        <li>Significant updates will be communicated through email or in-app notifications.</li>
                    </ul>
                </li>
            </ol>

            <p class="fs-6 mb-5 fw-normal">
                By using TrainMastas, you agree to the terms outlined in this Privacy Policy. For any inquiries or support, please contact us at
                <a href="mailto:support@trainmastas.com">support@trainmastas.com</a>.
            </p>
        </div>
    </div>



    <!-- -------------------------------------------------------------------
-------------------------Let's Build It----------------------------------------------
------------------------------------------------------------------------>


    <?php
    include "footer.php"
    ?>
    <!-- Endfooter -->

</body>

</html>