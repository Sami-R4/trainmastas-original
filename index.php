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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="js/bootstrap.js"></script>
    <title>Home - TrainMastas</title>
    <style>
        *{
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        .bouncing-image {
            animation: bounce 2s infinite;
            /* 2 seconds duration */
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
                /* Original position */
            }

            50% {
                transform: translateY(20px);
                /* Move up by 20px */
            }
        }

        .scroll-animation {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.6s, transform 0.6s;
        }

        .scroll-animation.animate {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>

    <?php
    include 'navbar.php';
    ?>
    <!--------------------------------------------------------------------------------------------
                                            Hero
    ---------------------------------------------------------------------------------------------->
    <section class="pm-hero">
        <header class="container-fluid pt-navbar">
            <div class="row mx-md-4">
                <div class="col-12 col-md-6 d-flex flex-column">
                    <div class="my-auto">
                        <h1 class="fs-2 pm-hero-heading">Your All-in-One Platform for YouTube-Based Courses</h1>
                        <p class="my-3 my-md-5 pm-hero-text">Connect with passionate instructors and a thriving learning community. Access high-quality YouTube content transformed into structured courses, complete with direct communication with course creators.</p>
                        <div class="my-3 my-md-5 visitor-elements">
                            <a href="signup.php" class="btn btn-outline-success rounded-pill pm-btn pm-btn-green">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mt-3 mt-md-0 text-center">
                    <img src="image/cover.png" alt="TrainMatas" class="bouncing-image pm-hero-img" style="width:95%; height:380px; object-fit:cover;">
                </div>
            </div>
        </header>
    </section>

    <!--------------------------------------------------------------------------------------------
                                           End Of Hero
    ---------------------------------------------------------------------------------------------->


    <!--------------------------------------------------------------------------------------------
                                            Courses
    ---------------------------------------------------------------------------------------------->
    <section class="">
        <div class=" mt-5" id="course-carousel-section">
            <div class="pm-courses-header">
                <h2 class="text-center fs-4 mb-0 mx-2">Your Journey to Mastery Begins Here</h2>
                <p class="text-center text-muted mt-1 pt-0 mx-2">Discover, learn, and grow with our diverse selection of courses designed to elevate your skills.</p>
            </div>
            <div class="container mt-4">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="owl-service-item owl-carousel project" id="course-container">

                        </div>
                    </div>

                    <!-------------------------------------------------------------------------------------------------
                        ------------------------------------------- Loader ---------------------------------------------
                        --------------------------------------------------------------------------------------------------->
                    <div class="row" id="course-loader">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 my-2">
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

                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-none d-sm-grid my-2">
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

                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-none d-md-grid my-2">
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

                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-none d-lg-grid my-2">
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
    </section>

    <!--------------------------------------------------------------------------------------------
                                           End Of Courses
    ---------------------------------------------------------------------------------------------->

    <!--------------------------------------------------------------------------------------------
                                            Learners Feedback
    ---------------------------------------------------------------------------------------------->
    <section class="">
        <div class=" mt-5">
            <h2 class="text-center fs-4 mb-0 mx-2">Hear from Our Learners</h2>
            <p class="text-center text-muted mt-1 pt-0 mx-2">Insightful feedback from those who have unlocked new skills and opportunities with us.</p>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="students owl-carousel project">
                            <div class="item d-grid border rounded text-black">
                                <div class="p-4 d-flex flex-column" style="height:300px">
                                    <svg class="quote-icon opening" xmlns="http://www.w3.org/2000/svg" fill="#000000" width="20px" height="20px" viewBox="0 0 24 24">
                                        <path d="M3.691 6.292C5.094 4.771 7.217 4 10 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 6.925 10H10a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2H3a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789zM20 20h-6a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789C16.094 4.771 18.217 4 21 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 17.925 10H21a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2z"></path>
                                    </svg>
                                    <h4 class="fs-6 my-2 fw-normal">The way TrainMastas organizes YouTube videos into structured courses is brilliant! It feels like I'm getting a curated learning experience, with all the important points highlighted. The descriptions for each module are super helpful too.</h4>
                                    <div class="w-100 mt-auto">
                                        <p class="text-muted fs-7  fw-semibold my-0 py-1 ">Sarah Johnson</p>
                                        <div class="d-flex mb-1 ">
                                            <span class="text-muted me-1 fs-6 fw-semibold">5.0</span>
                                            <span class="text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item d-grid border rounded text-black">
                                <div class="p-4 d-flex flex-column" style="height:300px">
                                    <svg class="quote-icon opening" xmlns="http://www.w3.org/2000/svg" fill="#000000" width="20px" height="20px" viewBox="0 0 24 24">
                                        <path d="M3.691 6.292C5.094 4.771 7.217 4 10 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 6.925 10H10a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2H3a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789zM20 20h-6a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789C16.094 4.771 18.217 4 21 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 17.925 10H21a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2z"></path>
                                    </svg>
                                    <h4 class="fs-6 my-2 fw-normal">I love how TrainMastas uses YouTube content to create comprehensive courses. It's like having the best of YouTube with a clear learning path. The instructors make complex topics easy to understand, and I appreciate the added context and summaries.</h4>
                                    <div class="w-100 mt-auto">
                                        <p class="text-muted fs-7  fw-semibold my-0 py-1 ">David Lee</p>
                                        <div class="d-flex mb-1 ">
                                            <span class="text-muted me-1 fs-6 fw-semibold">4.5</span>
                                            <span class="text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <g transform="matrix(1,0,0,1,-1152,-192)">
                                                        <rect id="Icons" x="0" y="0" width="1280" height="800" style="fill:none;" />
                                                        <g id="Icons1" serif:id="Icons">
                                                            <g id="Strike"> </g>
                                                            <g id="H1"> </g>
                                                            <g id="H2"> </g>
                                                            <g id="H3"> </g>
                                                            <g id="list-ul"> </g>
                                                            <g id="hamburger-1"> </g>
                                                            <g id="hamburger-2"> </g>
                                                            <g id="list-ol"> </g>
                                                            <g id="list-task"> </g>
                                                            <g id="trash"> </g>
                                                            <g id="vertical-menu"> </g>
                                                            <g id="horizontal-menu"> </g>
                                                            <g id="sidebar-2"> </g>
                                                            <g id="Pen"> </g>
                                                            <g id="Pen1" serif:id="Pen"> </g>
                                                            <g id="clock"> </g>
                                                            <g id="external-link"> </g>
                                                            <g id="hr"> </g>
                                                            <g id="info"> </g>
                                                            <g id="warning"> </g>
                                                            <g id="plus-circle"> </g>
                                                            <g id="minus-circle"> </g>
                                                            <g id="vue"> </g>
                                                            <g id="cog"> </g>
                                                            <g id="logo"> </g>
                                                            <g id="star-empty" transform="matrix(1.05152,0,0,1.05152,460.558,-59.6026)">
                                                                <path d="M693.388,264.584L710.825,264.584L696.719,274.833L702.107,291.416L688,281.167L673.893,291.416L679.281,274.833L665.175,264.584L682.612,264.584L688,248C689.796,253.528 691.592,259.056 693.388,264.584ZM688,260.391L688,276.434L694.824,281.392L692.217,273.37L699.041,268.413L690.606,268.413L688,260.391Z" style="fill-rule:nonzero;" />
                                                            </g>
                                                            <g id="radio-check"> </g>
                                                            <g id="eye-slash"> </g>
                                                            <g id="eye"> </g>
                                                            <g id="toggle-off"> </g>
                                                            <g id="shredder"> </g>
                                                            <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                            <g id="react"> </g>
                                                            <g id="check-selected"> </g>
                                                            <g id="turn-off"> </g>
                                                            <g id="code-block"> </g>
                                                            <g id="user"> </g>
                                                            <g id="coffee-bean"> </g>
                                                            <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,785.021,-208.975)">
                                                                <g id="coffee-beans">
                                                                    <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                                </g>
                                                            </g>
                                                            <g id="coffee-bean-filled"> </g>
                                                            <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,913.062,-208.975)">
                                                                <g id="coffee-beans-filled">
                                                                    <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                                </g>
                                                            </g>
                                                            <g id="clipboard"> </g>
                                                            <g transform="matrix(1,0,0,1,128.011,1.35415)">
                                                                <g id="clipboard-paste"> </g>
                                                            </g>
                                                            <g id="clipboard-copy"> </g>
                                                            <g id="Layer1"> </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item d-grid border rounded text-black">
                                <div class="p-4 d-flex flex-column" style="height:300px">
                                    <svg class="quote-icon opening" xmlns="http://www.w3.org/2000/svg" fill="#000000" width="20px" height="20px" viewBox="0 0 24 24">
                                        <path d="M3.691 6.292C5.094 4.771 7.217 4 10 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 6.925 10H10a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2H3a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789zM20 20h-6a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789C16.094 4.771 18.217 4 21 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 17.925 10H21a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2z"></path>
                                    </svg>
                                    <h4 class="fs-6 my-2 fw-normal">TrainMastas made learning so accessible! The courses are well-structured, and the YouTube videos are integrated seamlessly. It's great to have all the information laid out in a way that's easy to follow. It's helped me grasp concepts I struggled with before.</h4>
                                    <div class="w-100 mt-auto">
                                        <p class="text-muted fs-7  fw-semibold my-0 py-1 ">Michael Nguyen</p>
                                        <div class="d-flex mb-1 ">
                                            <span class="text-muted me-1 fs-6 fw-semibold">4.0</span>
                                            <span class="text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 24 24" fill="none">
                                                    <mask id="path-1-inside-1" fill="white">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9482 4.18011C12.7985 3.71945 12.1468 3.71945 11.9972 4.18011L10.3398 9.28092C10.2729 9.48693 10.0809 9.62641 9.86427 9.62641H4.50096C4.0166 9.62641 3.81521 10.2462 4.20707 10.5309L8.54608 13.6834C8.72132 13.8107 8.79465 14.0364 8.72771 14.2424L7.07036 19.3432C6.92068 19.8039 7.44792 20.1869 7.83978 19.9022L12.1788 16.7498C12.354 16.6224 12.5913 16.6224 12.7666 16.7498L17.1056 19.9022C17.4974 20.1869 18.0247 19.8039 17.875 19.3432L16.2177 14.2424C16.1507 14.0364 16.224 13.8107 16.3993 13.6834L20.7383 10.5309C21.1302 10.2462 20.9288 9.62641 20.4444 9.62641H15.0811C14.8645 9.62641 14.6725 9.48693 14.6056 9.28092L12.9482 4.18011ZM13.7342 11.2527L12.4994 7.79779L11.2646 11.2527H7.26858L10.5014 13.388L9.26657 16.8429L12.4994 14.7076L15.7322 16.8429L14.4974 13.388L17.7302 11.2527H13.7342Z" />
                                                    </mask>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9482 4.18011C12.7985 3.71945 12.1468 3.71945 11.9972 4.18011L10.3398 9.28092C10.2729 9.48693 10.0809 9.62641 9.86427 9.62641H4.50096C4.0166 9.62641 3.81521 10.2462 4.20707 10.5309L8.54608 13.6834C8.72132 13.8107 8.79465 14.0364 8.72771 14.2424L7.07036 19.3432C6.92068 19.8039 7.44792 20.1869 7.83978 19.9022L12.1788 16.7498C12.354 16.6224 12.5913 16.6224 12.7666 16.7498L17.1056 19.9022C17.4974 20.1869 18.0247 19.8039 17.875 19.3432L16.2177 14.2424C16.1507 14.0364 16.224 13.8107 16.3993 13.6834L20.7383 10.5309C21.1302 10.2462 20.9288 9.62641 20.4444 9.62641H15.0811C14.8645 9.62641 14.6725 9.48693 14.6056 9.28092L12.9482 4.18011ZM13.7342 11.2527L12.4994 7.79779L11.2646 11.2527H7.26858L10.5014 13.388L9.26657 16.8429L12.4994 14.7076L15.7322 16.8429L14.4974 13.388L17.7302 11.2527H13.7342Z" fill="#28a745" />
                                                    <path d="M11.9972 4.18011L11.0461 3.87109L11.0461 3.87109L11.9972 4.18011ZM12.9482 4.18011L13.8993 3.87109L13.8993 3.87109L12.9482 4.18011ZM10.3398 9.28092L9.38874 8.9719L9.38874 8.9719L10.3398 9.28092ZM4.20707 10.5309L3.61928 11.3399L3.61928 11.3399L4.20707 10.5309ZM8.54608 13.6834L7.95829 14.4924L7.95829 14.4924L8.54608 13.6834ZM8.72771 14.2424L7.77666 13.9334L7.77666 13.9334L8.72771 14.2424ZM7.07036 19.3432L6.1193 19.0342L6.1193 19.0342L7.07036 19.3432ZM7.83978 19.9022L8.42756 20.7113L8.42756 20.7113L7.83978 19.9022ZM12.1788 16.7498L12.7666 17.5588L12.7666 17.5588L12.1788 16.7498ZM12.7666 16.7498L12.1788 17.5588L12.1788 17.5588L12.7666 16.7498ZM17.1056 19.9022L16.5178 20.7113L16.5178 20.7113L17.1056 19.9022ZM17.875 19.3432L16.9239 19.6522L16.9239 19.6522L17.875 19.3432ZM16.2177 14.2424L17.1687 13.9334L17.1687 13.9334L16.2177 14.2424ZM16.3993 13.6834L15.8115 12.8744L15.8115 12.8744L16.3993 13.6834ZM20.7383 10.5309L20.1505 9.7219L20.1505 9.7219L20.7383 10.5309ZM14.6056 9.28092L15.5566 8.9719L15.5566 8.9719L14.6056 9.28092ZM12.4994 7.79779L11.5577 7.46123L12.4994 4.82656L13.4411 7.46123L12.4994 7.79779ZM13.7342 11.2527V12.2527H13.0297L12.7926 11.5893L13.7342 11.2527ZM11.2646 11.2527L12.2062 11.5893L11.9691 12.2527H11.2646V11.2527ZM7.26858 11.2527L6.71745 12.0871L3.9401 10.2527H7.26858V11.2527ZM10.5014 13.388L11.0525 12.5535L11.7071 12.9859L11.4431 13.7245L10.5014 13.388ZM9.26657 16.8429L9.8177 17.6773L7.31576 19.3298L8.32491 16.5063L9.26657 16.8429ZM12.4994 14.7076L11.9483 13.8732L12.4994 13.5092L13.0505 13.8732L12.4994 14.7076ZM15.7322 16.8429L16.6739 16.5063L17.683 19.3298L15.1811 17.6773L15.7322 16.8429ZM14.4974 13.388L13.5557 13.7245L13.2917 12.9859L13.9463 12.5535L14.4974 13.388ZM17.7302 11.2527V10.2527H21.0587L18.2813 12.0871L17.7302 11.2527ZM11.0461 3.87109C11.4951 2.48912 13.4502 2.48912 13.8993 3.87109L11.9972 4.48912C12.1468 4.94978 12.7985 4.94978 12.9482 4.48912L11.0461 3.87109ZM9.38874 8.9719L11.0461 3.87109L12.9482 4.48912L11.2909 9.58994L9.38874 8.9719ZM9.86427 8.62641C9.64766 8.62641 9.45568 8.76589 9.38874 8.9719L11.2909 9.58994C11.09 10.208 10.5141 10.6264 9.86427 10.6264V8.62641ZM4.50096 8.62641H9.86427V10.6264H4.50096V8.62641ZM3.61928 11.3399C2.44371 10.4858 3.04787 8.62641 4.50096 8.62641V10.6264C4.98532 10.6264 5.18671 10.0066 4.79485 9.7219L3.61928 11.3399ZM7.95829 14.4924L3.61928 11.3399L4.79485 9.7219L9.13386 12.8744L7.95829 14.4924ZM7.77666 13.9334C7.70972 14.1394 7.78305 14.3651 7.95829 14.4924L9.13386 12.8744C9.65959 13.2563 9.87958 13.9334 9.67877 14.5514L7.77666 13.9334ZM6.1193 19.0342L7.77666 13.9334L9.67877 14.5514L8.02141 19.6522L6.1193 19.0342ZM8.42756 20.7113C7.25199 21.5654 5.67027 20.4162 6.1193 19.0342L8.02141 19.6522C8.17109 19.1916 7.64385 18.8085 7.25199 19.0932L8.42756 20.7113ZM12.7666 17.5588L8.42756 20.7113L7.25199 19.0932L11.591 15.9407L12.7666 17.5588ZM12.1788 17.5588C12.354 17.6861 12.5913 17.6861 12.7666 17.5588L11.591 15.9407C12.1167 15.5588 12.8286 15.5588 13.3544 15.9407L12.1788 17.5588ZM16.5178 20.7113L12.1788 17.5588L13.3544 15.9407L17.6934 19.0932L16.5178 20.7113ZM18.8261 19.0342C19.2751 20.4162 17.6934 21.5654 16.5178 20.7113L17.6934 19.0932C17.3015 18.8085 16.7743 19.1916 16.9239 19.6522L18.8261 19.0342ZM17.1687 13.9334L18.8261 19.0342L16.9239 19.6522L15.2666 14.5514L17.1687 13.9334ZM16.9871 14.4924C17.1623 14.3651 17.2356 14.1394 17.1687 13.9334L15.2666 14.5514C15.0658 13.9334 15.2858 13.2563 15.8115 12.8744L16.9871 14.4924ZM21.3261 11.3399L16.9871 14.4924L15.8115 12.8744L20.1505 9.7219L21.3261 11.3399ZM20.4444 8.62641C21.8975 8.62641 22.5017 10.4858 21.3261 11.3399L20.1505 9.7219C19.7587 10.0066 19.96 10.6264 20.4444 10.6264V8.62641ZM15.0811 8.62641H20.4444V10.6264H15.0811V8.62641ZM15.5566 8.9719C15.4897 8.76589 15.2977 8.62641 15.0811 8.62641V10.6264C14.4313 10.6264 13.8553 10.208 13.6545 9.58993L15.5566 8.9719ZM13.8993 3.87109L15.5566 8.9719L13.6545 9.58994L11.9972 4.48912L13.8993 3.87109ZM13.4411 7.46123L14.6759 10.9161L12.7926 11.5893L11.5577 8.13435L13.4411 7.46123ZM10.3229 10.9161L11.5577 7.46123L13.4411 8.13435L12.2062 11.5893L10.3229 10.9161ZM7.26858 10.2527H11.2646V12.2527H7.26858V10.2527ZM9.95027 14.2224L6.71745 12.0871L7.81971 10.4183L11.0525 12.5535L9.95027 14.2224ZM8.32491 16.5063L9.55974 13.0514L11.4431 13.7245L10.2082 17.1794L8.32491 16.5063ZM13.0505 15.542L9.8177 17.6773L8.71544 16.0085L11.9483 13.8732L13.0505 15.542ZM15.1811 17.6773L11.9483 15.542L13.0505 13.8732L16.2833 16.0085L15.1811 17.6773ZM15.439 13.0514L16.6739 16.5063L14.7905 17.1794L13.5557 13.7245L15.439 13.0514ZM18.2813 12.0871L15.0485 14.2224L13.9463 12.5535L17.1791 10.4183L18.2813 12.0871ZM13.7342 10.2527H17.7302V12.2527H13.7342V10.2527Z" fill="#28a745" mask="url(#path-1-inside-1)" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item d-grid border rounded text-black">
                                <div class="p-4 d-flex flex-column" style="height:300px">
                                    <svg class="quote-icon opening" xmlns="http://www.w3.org/2000/svg" fill="#000000" width="20px" height="20px" viewBox="0 0 24 24">
                                        <path d="M3.691 6.292C5.094 4.771 7.217 4 10 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 6.925 10H10a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2H3a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789zM20 20h-6a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789C16.094 4.771 18.217 4 21 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 17.925 10H21a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2z"></path>
                                    </svg>
                                    <h4 class="fs-6 my-2 fw-normal">The platform's unique approach of using YouTube videos for courses is genius. It's like having a personal tutor guiding me through the best educational content on the internet. The detailed module descriptions are a great touch, making it easy to focus on what's important.</h4>
                                    <div class="w-100 mt-auto">
                                        <p class="text-muted fs-7  fw-semibold my-0 py-1 ">Emily Martinez</p>
                                        <div class="d-flex mb-1 ">
                                            <span class="text-muted me-1 fs-6 fw-semibold">4.5</span>
                                            <span class="text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <g transform="matrix(1,0,0,1,-1152,-192)">
                                                        <rect id="Icons" x="0" y="0" width="1280" height="800" style="fill:none;" />
                                                        <g id="Icons1" serif:id="Icons">
                                                            <g id="Strike"> </g>
                                                            <g id="H1"> </g>
                                                            <g id="H2"> </g>
                                                            <g id="H3"> </g>
                                                            <g id="list-ul"> </g>
                                                            <g id="hamburger-1"> </g>
                                                            <g id="hamburger-2"> </g>
                                                            <g id="list-ol"> </g>
                                                            <g id="list-task"> </g>
                                                            <g id="trash"> </g>
                                                            <g id="vertical-menu"> </g>
                                                            <g id="horizontal-menu"> </g>
                                                            <g id="sidebar-2"> </g>
                                                            <g id="Pen"> </g>
                                                            <g id="Pen1" serif:id="Pen"> </g>
                                                            <g id="clock"> </g>
                                                            <g id="external-link"> </g>
                                                            <g id="hr"> </g>
                                                            <g id="info"> </g>
                                                            <g id="warning"> </g>
                                                            <g id="plus-circle"> </g>
                                                            <g id="minus-circle"> </g>
                                                            <g id="vue"> </g>
                                                            <g id="cog"> </g>
                                                            <g id="logo"> </g>
                                                            <g id="star-empty" transform="matrix(1.05152,0,0,1.05152,460.558,-59.6026)">
                                                                <path d="M693.388,264.584L710.825,264.584L696.719,274.833L702.107,291.416L688,281.167L673.893,291.416L679.281,274.833L665.175,264.584L682.612,264.584L688,248C689.796,253.528 691.592,259.056 693.388,264.584ZM688,260.391L688,276.434L694.824,281.392L692.217,273.37L699.041,268.413L690.606,268.413L688,260.391Z" style="fill-rule:nonzero;" />
                                                            </g>
                                                            <g id="radio-check"> </g>
                                                            <g id="eye-slash"> </g>
                                                            <g id="eye"> </g>
                                                            <g id="toggle-off"> </g>
                                                            <g id="shredder"> </g>
                                                            <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                            <g id="react"> </g>
                                                            <g id="check-selected"> </g>
                                                            <g id="turn-off"> </g>
                                                            <g id="code-block"> </g>
                                                            <g id="user"> </g>
                                                            <g id="coffee-bean"> </g>
                                                            <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,785.021,-208.975)">
                                                                <g id="coffee-beans">
                                                                    <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                                </g>
                                                            </g>
                                                            <g id="coffee-bean-filled"> </g>
                                                            <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,913.062,-208.975)">
                                                                <g id="coffee-beans-filled">
                                                                    <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                                </g>
                                                            </g>
                                                            <g id="clipboard"> </g>
                                                            <g transform="matrix(1,0,0,1,128.011,1.35415)">
                                                                <g id="clipboard-paste"> </g>
                                                            </g>
                                                            <g id="clipboard-copy"> </g>
                                                            <g id="Layer1"> </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--------------------------------------------------------------------------------------------
                                           End Of Learners Feedback
    ---------------------------------------------------------------------------------------------->

    <!--------------------------------------------------------------------------------------------
                                            Course Category 
    ---------------------------------------------------------------------------------------------->
    <section class="">
        <div class=" mt-5 py-5 shadow">
            <h2 class="text-center fs-4 mb-0 mx-2">Find the Perfect Course to Match Your Learning Goals</h2>
            <p class="text-center text-muted mt-1 pt-0 mx-2">Browse through our curated categories to discover courses designed to enhance your skills and knowledge across various fields.</p>
            <div class="container mt-4">
                <div class="text-center">
                    <a href="courses.php" class="btn btn-outline-success rounded-pill">Explore Courses</a>
                </div>

            </div>
        </div>
    </section>
    <!--------------------------------------------------------------------------------------------
                                           End Of Category
    ---------------------------------------------------------------------------------------------->


    <!--------------------------------------------------------------------------------------------
                                            Instructors Feedback
    ---------------------------------------------------------------------------------------------->
    <section class="">
        <div class=" mt-5 mb-5">
            <h2 class="text-center fs-4 mb-0 mx-2">Insights from Our Course Creators</h2>
            <p class="text-center text-muted mt-1 pt-0 mx-2">Discover what our expert creators have to say about shaping impactful learning experiences.</p>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="students owl-carousel project" id="course-container">
                            <div class="item d-grid border rounded text-black">
                                <div class="p-4 d-flex flex-column" style="height:455px">
                                    <div class="text-center mb-3">
                                        <img src="image/Founder_and_CEO_of_TrainMastas.png" alt="Founder and CEO of TrainMastas" class="rounded-circle mx-auto" style="width:140px; height:140px; object-fit:cover">
                                    </div>
                                    <svg class="quote-icon opening" xmlns="http://www.w3.org/2000/svg" fill="#000000" width="20px" height="20px" viewBox="0 0 24 24">
                                        <path d="M3.691 6.292C5.094 4.771 7.217 4 10 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 6.925 10H10a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2H3a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789zM20 20h-6a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789C16.094 4.771 18.217 4 21 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 17.925 10H21a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2z"></path>
                                    </svg>
                                    <h4 class="fs-6 my-2 fw-normal">As Founder and CEO of TrainMastas, creating courses on our platform has been transformative. The seamless integration with YouTube allows creators to focus on high-quality content without technical challenges. TrainMastas is an innovative space for sharing knowledge and connecting with a wider audience.</h4>
                                    <div class="w-100 mt-auto">
                                        <p class="text-muted fs-7  fw-semibold my-0 py-1 ">Ngoupayou Habil Salim - Founder & CEO</p>
                                        <div class="d-flex mb-1 ">
                                            <span class="text-muted me-1 fs-6 fw-semibold">5.0</span>
                                            <span class="text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item d-grid border rounded text-black">
                                <div class="p-4 d-flex flex-column" style="height:455px">
                                    <div class="text-center mb-3">
                                        <img src="image/awah.png" alt="Tchinda Awa Kenny - Course Creator & Coordinator" class="rounded-circle mx-auto" style="width:140px; height:140px; object-fit:cover">
                                    </div>
                                    <svg class="quote-icon opening" xmlns="http://www.w3.org/2000/svg" fill="#000000" width="20px" height="20px" viewBox="0 0 24 24">
                                        <path d="M3.691 6.292C5.094 4.771 7.217 4 10 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 6.925 10H10a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2H3a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789zM20 20h-6a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789C16.094 4.771 18.217 4 21 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 17.925 10H21a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2z"></path>
                                    </svg>
                                    <h4 class="fs-6 my-2 fw-normal">TrainMastas has given me the tools to create structured and engaging courses. The option to use YouTube videos as the foundation for my lessons has allowed me to curate the best content and present it in an accessible way. It's been a great experience sharing my expertise.</h4>
                                    <div class="w-100 mt-auto">
                                        <p class="text-muted fs-7  fw-semibold my-0 py-1 ">Tchinda Awa Kenne - Course Creator & Coordinator</p>
                                        <div class="d-flex mb-1 ">
                                            <span class="text-muted me-1 fs-6 fw-semibold">5.0</span>
                                            <span class="text-success">

                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item d-grid border rounded text-black">
                                <div class="p-4 d-flex flex-column" style="height:455px">
                                    <div class="text-center mb-3">
                                        <img src="image/edison.jpg" alt="Mushieh Edison - Course Creator" class="rounded-circle mx-auto" style="width:140px; height:140px; object-fit:cover">
                                    </div>
                                    <svg class="quote-icon opening" xmlns="http://www.w3.org/2000/svg" fill="#000000" width="20px" height="20px" viewBox="0 0 24 24">
                                        <path d="M3.691 6.292C5.094 4.771 7.217 4 10 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 6.925 10H10a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2H3a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789zM20 20h-6a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789C16.094 4.771 18.217 4 21 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 17.925 10H21a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2z"></path>
                                    </svg>
                                    <h4 class="fs-6 my-2 fw-normal">TrainMastas has given me the tools to create structured and engaging courses. The option to use YouTube videos as the foundation for my lessons has allowed me to curate the best content and present it in an accessible way. It's been a great experience sharing my expertise.</h4>
                                    <div class="w-100 mt-auto">
                                        <p class="text-muted fs-7  fw-semibold my-0 py-1 ">Mushieh Edison - Course Creator</p>
                                        <div class="d-flex mb-1 ">
                                            <span class="text-muted me-1 fs-6 fw-semibold">4.5</span>
                                            <span class="text-success">

                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <g transform="matrix(1,0,0,1,-1152,-192)">
                                                        <rect id="Icons" x="0" y="0" width="1280" height="800" style="fill:none;" />
                                                        <g id="Icons1" serif:id="Icons">
                                                            <g id="Strike"> </g>
                                                            <g id="H1"> </g>
                                                            <g id="H2"> </g>
                                                            <g id="H3"> </g>
                                                            <g id="list-ul"> </g>
                                                            <g id="hamburger-1"> </g>
                                                            <g id="hamburger-2"> </g>
                                                            <g id="list-ol"> </g>
                                                            <g id="list-task"> </g>
                                                            <g id="trash"> </g>
                                                            <g id="vertical-menu"> </g>
                                                            <g id="horizontal-menu"> </g>
                                                            <g id="sidebar-2"> </g>
                                                            <g id="Pen"> </g>
                                                            <g id="Pen1" serif:id="Pen"> </g>
                                                            <g id="clock"> </g>
                                                            <g id="external-link"> </g>
                                                            <g id="hr"> </g>
                                                            <g id="info"> </g>
                                                            <g id="warning"> </g>
                                                            <g id="plus-circle"> </g>
                                                            <g id="minus-circle"> </g>
                                                            <g id="vue"> </g>
                                                            <g id="cog"> </g>
                                                            <g id="logo"> </g>
                                                            <g id="star-empty" transform="matrix(1.05152,0,0,1.05152,460.558,-59.6026)">
                                                                <path d="M693.388,264.584L710.825,264.584L696.719,274.833L702.107,291.416L688,281.167L673.893,291.416L679.281,274.833L665.175,264.584L682.612,264.584L688,248C689.796,253.528 691.592,259.056 693.388,264.584ZM688,260.391L688,276.434L694.824,281.392L692.217,273.37L699.041,268.413L690.606,268.413L688,260.391Z" style="fill-rule:nonzero;" />
                                                            </g>
                                                            <g id="radio-check"> </g>
                                                            <g id="eye-slash"> </g>
                                                            <g id="eye"> </g>
                                                            <g id="toggle-off"> </g>
                                                            <g id="shredder"> </g>
                                                            <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                            <g id="react"> </g>
                                                            <g id="check-selected"> </g>
                                                            <g id="turn-off"> </g>
                                                            <g id="code-block"> </g>
                                                            <g id="user"> </g>
                                                            <g id="coffee-bean"> </g>
                                                            <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,785.021,-208.975)">
                                                                <g id="coffee-beans">
                                                                    <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                                </g>
                                                            </g>
                                                            <g id="coffee-bean-filled"> </g>
                                                            <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,913.062,-208.975)">
                                                                <g id="coffee-beans-filled">
                                                                    <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                                </g>
                                                            </g>
                                                            <g id="clipboard"> </g>
                                                            <g transform="matrix(1,0,0,1,128.011,1.35415)">
                                                                <g id="clipboard-paste"> </g>
                                                            </g>
                                                            <g id="clipboard-copy"> </g>
                                                            <g id="Layer1"> </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item d-grid border rounded text-black">
                                <div class="p-4 d-flex flex-column" style="height:455px">
                                    <div class="text-center mb-3">
                                        <img src="image/ngonjoh.png" alt="Ngonjoh Providence - Course Creator" class="rounded-circle mx-auto" style="width:140px; height:140px; object-fit:cover">
                                    </div>
                                    <svg class="quote-icon opening" xmlns="http://www.w3.org/2000/svg" fill="#000000" width="20px" height="20px" viewBox="0 0 24 24">
                                        <path d="M3.691 6.292C5.094 4.771 7.217 4 10 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 6.925 10H10a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2H3a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789zM20 20h-6a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789C16.094 4.771 18.217 4 21 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 17.925 10H21a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2z"></path>
                                    </svg>
                                    <h4 class="fs-6 my-2 fw-normal">As CEO of Spektralsoft, I’m proud to have collaborated on TrainMastas' platform development. Their platform has truly transformed how we deliver structured video courses—empowering learners and creators alike. It’s fulfilling to see our content making real impact through such an intuitive tool.</h4>
                                    <div class="w-100 mt-auto">
                                        <p class="text-muted fs-7  fw-semibold my-0 py-1 ">Ngonjoh Providence - CEO at Spektralsoft</p>
                                        <div class="d-flex mb-1 ">
                                            <span class="text-muted me-1 fs-6 fw-semibold">5.0</span>
                                            <span class="text-success">

                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item d-grid border rounded text-black">
                                <div class="p-4 d-flex flex-column" style="height:455px">
                                    <div class="text-center mb-3">
                                        <img src="image/achille.jpg" alt="TAMNGWAH ACHILLE NDI - Course Creator" class="rounded-circle mx-auto" style="width:140px; height:140px; object-fit:cover">
                                    </div>
                                    <svg class="quote-icon opening" xmlns="http://www.w3.org/2000/svg" fill="#000000" width="20px" height="20px" viewBox="0 0 24 24">
                                        <path d="M3.691 6.292C5.094 4.771 7.217 4 10 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 6.925 10H10a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2H3a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789zM20 20h-6a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789C16.094 4.771 18.217 4 21 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 17.925 10H21a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2z"></path>
                                    </svg>
                                    <h4 class="fs-6 my-2 fw-normal">Creating courses with TrainMastas feels effortless and rewarding. The way it lets me organize my YouTube content into clear, guided modules has completely elevated how I teach online. Learner engagement and feedback have never been better.</h4>
                                    <div class="w-100 mt-auto">
                                        <p class="text-muted fs-7  fw-semibold my-0 py-1 ">TAMNGWAH ACHILLE NDI - Course Creator</p>
                                        <div class="d-flex mb-1 ">
                                            <span class="text-muted me-1 fs-6 fw-semibold">5.0</span>
                                            <span class="text-success">

                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item d-grid border rounded text-black">
                                <div class="p-4 d-flex flex-column" style="height:455px">
                                    <div class="text-center mb-3">
                                        <img src="image/malaloum.png" alt="Malaloum Djou Mireille - Course Creator" class="rounded-circle mx-auto" style="width:140px; height:140px; object-fit:cover">
                                    </div>
                                    <svg class="quote-icon opening" xmlns="http://www.w3.org/2000/svg" fill="#000000" width="20px" height="20px" viewBox="0 0 24 24">
                                        <path d="M3.691 6.292C5.094 4.771 7.217 4 10 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 6.925 10H10a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2H3a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789zM20 20h-6a1 1 0 0 1-1-1v-5l.003-2.919c-.009-.111-.199-2.741 1.688-4.789C16.094 4.771 18.217 4 21 4h1v2.819l-.804.161c-1.37.274-2.323.813-2.833 1.604A2.902 2.902 0 0 0 17.925 10H21a1 1 0 0 1 1 1v7c0 1.103-.897 2-2 2z"></path>
                                    </svg>
                                    <h4 class="fs-6 my-2 fw-normal">As CTO of Spektralsoft, I’ve been impressed by TrainMastas’ technical vision. Collaborating on its development was a great experience. The platform’s smart structure and smooth delivery make it a powerful tool for scalable, engaging online learning.</h4>
                                    <div class="w-100 mt-auto">
                                        <p class="text-muted fs-7  fw-semibold my-0 py-1 ">Malaloum Djou Mireille - Course Creator & CTO at Spektralsoft</p>
                                        <div class="d-flex mb-1 ">
                                            <span class="text-muted me-1 fs-6 fw-semibold">4.5</span>
                                            <span class="text-success">

                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <rect id="Icons" x="-512" y="-192" width="1280" height="800" style="fill:none;" />
                                                    <g id="Icons1" serif:id="Icons">
                                                        <g id="Strike"> </g>
                                                        <g id="H1"> </g>
                                                        <g id="H2"> </g>
                                                        <g id="H3"> </g>
                                                        <g id="list-ul"> </g>
                                                        <g id="hamburger-1"> </g>
                                                        <g id="hamburger-2"> </g>
                                                        <g id="list-ol"> </g>
                                                        <g id="list-task"> </g>
                                                        <g id="trash"> </g>
                                                        <g id="vertical-menu"> </g>
                                                        <g id="horizontal-menu"> </g>
                                                        <g id="sidebar-2"> </g>
                                                        <g id="Pen"> </g>
                                                        <g id="Pen1" serif:id="Pen"> </g>
                                                        <g id="clock"> </g>
                                                        <g id="external-link"> </g>
                                                        <g id="hr"> </g>
                                                        <g id="info"> </g>
                                                        <g id="warning">
                                                        </g>
                                                        <g id="plus-circle"> </g>
                                                        <g id="minus-circle"> </g>
                                                        <g id="vue"> </g>
                                                        <g id="cog"> </g>
                                                        <g id="logo"> </g>
                                                        <path id="star" d="M32.001,9.188l5.666,17.438l18.335,0l-14.833,10.777l5.666,17.438l-14.834,-10.777l-14.833,10.777l5.666,-17.438l-14.834,-10.777l18.335,0l5.666,-17.438Z" />
                                                        <g id="radio-check"> </g>
                                                        <g id="eye-slash"> </g>
                                                        <g id="eye"> </g>
                                                        <g id="toggle-off"> </g>
                                                        <g id="shredder"> </g>
                                                        <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                        <g id="react"> </g>
                                                        <g id="check-selected"> </g>
                                                        <g id="turn-off"> </g>
                                                        <g id="code-block"> </g>
                                                        <g id="user"> </g>
                                                        <g id="coffee-bean"> </g>
                                                        <g id="coffee-beans">
                                                            <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="coffee-bean-filled"> </g>
                                                        <g id="coffee-beans-filled">
                                                            <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                        </g>
                                                        <g id="clipboard"> </g>
                                                        <g id="clipboard-paste"> </g>
                                                        <g id="clipboard-copy"> </g>
                                                        <g id="Layer1"> </g>
                                                    </g>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:serif="http://www.serif.com/" fill="#28a745" width="25px" height="25px" viewBox="0 0 64 64" version="1.1" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                                                    <g transform="matrix(1,0,0,1,-1152,-192)">
                                                        <rect id="Icons" x="0" y="0" width="1280" height="800" style="fill:none;" />
                                                        <g id="Icons1" serif:id="Icons">
                                                            <g id="Strike"> </g>
                                                            <g id="H1"> </g>
                                                            <g id="H2"> </g>
                                                            <g id="H3"> </g>
                                                            <g id="list-ul"> </g>
                                                            <g id="hamburger-1"> </g>
                                                            <g id="hamburger-2"> </g>
                                                            <g id="list-ol"> </g>
                                                            <g id="list-task"> </g>
                                                            <g id="trash"> </g>
                                                            <g id="vertical-menu"> </g>
                                                            <g id="horizontal-menu"> </g>
                                                            <g id="sidebar-2"> </g>
                                                            <g id="Pen"> </g>
                                                            <g id="Pen1" serif:id="Pen"> </g>
                                                            <g id="clock"> </g>
                                                            <g id="external-link"> </g>
                                                            <g id="hr"> </g>
                                                            <g id="info"> </g>
                                                            <g id="warning"> </g>
                                                            <g id="plus-circle"> </g>
                                                            <g id="minus-circle"> </g>
                                                            <g id="vue"> </g>
                                                            <g id="cog"> </g>
                                                            <g id="logo"> </g>
                                                            <g id="star-empty" transform="matrix(1.05152,0,0,1.05152,460.558,-59.6026)">
                                                                <path d="M693.388,264.584L710.825,264.584L696.719,274.833L702.107,291.416L688,281.167L673.893,291.416L679.281,274.833L665.175,264.584L682.612,264.584L688,248C689.796,253.528 691.592,259.056 693.388,264.584ZM688,260.391L688,276.434L694.824,281.392L692.217,273.37L699.041,268.413L690.606,268.413L688,260.391Z" style="fill-rule:nonzero;" />
                                                            </g>
                                                            <g id="radio-check"> </g>
                                                            <g id="eye-slash"> </g>
                                                            <g id="eye"> </g>
                                                            <g id="toggle-off"> </g>
                                                            <g id="shredder"> </g>
                                                            <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g>
                                                            <g id="react"> </g>
                                                            <g id="check-selected"> </g>
                                                            <g id="turn-off"> </g>
                                                            <g id="code-block"> </g>
                                                            <g id="user"> </g>
                                                            <g id="coffee-bean"> </g>
                                                            <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,785.021,-208.975)">
                                                                <g id="coffee-beans">
                                                                    <g id="coffee-bean1" serif:id="coffee-bean"> </g>
                                                                </g>
                                                            </g>
                                                            <g id="coffee-bean-filled"> </g>
                                                            <g transform="matrix(0.638317,0.368532,-0.368532,0.638317,913.062,-208.975)">
                                                                <g id="coffee-beans-filled">
                                                                    <g id="coffee-bean2" serif:id="coffee-bean"> </g>
                                                                </g>
                                                            </g>
                                                            <g id="clipboard"> </g>
                                                            <g transform="matrix(1,0,0,1,128.011,1.35415)">
                                                                <g id="clipboard-paste"> </g>
                                                            </g>
                                                            <g id="clipboard-copy"> </g>
                                                            <g id="Layer1"> </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!--------------------------------------------------------------------------------------------
                                           End Of Instructors Feedback
    ---------------------------------------------------------------------------------------------->





    <!--------------------------------------------------------------------------------------------
                                          Become
    ---------------------------------------------------------------------------------------------->
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 mb-4 mb-lg-0 text-center">
                    <img src="image/become_instructor.png" alt="Become Instructor" class="" style="width:90%;height:400px;object-fit:cover;">
                </div>
                <div class="col-12 col-lg-6 text-center text-lg-start d-flex">
                    <div class="my-auto">
                        <h3 class="fs-3">Become A Course Creators</h3>
                        <div class="my-4 fs-5">Join a community of innovative course creators who are transforming their knowledge into engaging online learning experiences</div>
                        <a href="#" class="btn btn-outline-success rounded-pill visitor-elements">Get Started</a>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!--------------------------------------------------------------------------------------------
                                           End Of Become Course Creator
    ---------------------------------------------------------------------------------------------->


    <?php
    include "footer.php";
    ?>

    </script>
    <script src="js/owl-carousel.js"></script>

    <script>
        $(document).ready(function() {

            $('.students').owlCarousel({
                items: 3,
                loop: true,
                dots: true,
                nav: true,
                margin: 15,
                autoplayTimeout: 5000, // Set your desired autoplay speed
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1,
                        autoplay: true // Enable autoplay for small screens
                    },
                    700: {
                        items: 2,
                        autoplay: true // Disable autoplay for medium screens
                    },
                    1200: {
                        items: 3,
                        autoplay: false // Disable autoplay for large screens
                    }
                }
            });
        })
    </script>

    <script>
        let lastScrollY = 0;

        function revealSections() {
            const sections = document.querySelectorAll('.scroll-animation');
            const currentScrollY = window.scrollY;

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                const windowHeight = window.innerHeight;

                // Check if the section is within the viewport
                if (sectionTop < currentScrollY + windowHeight * 0.8 && sectionTop + sectionHeight > currentScrollY) {
                    section.classList.add('animate');
                } else {
                    section.classList.remove('animate');
                }
            });
            lastScrollY = currentScrollY;
        }

        window.addEventListener('scroll', revealSections);
        revealSections();
    </script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $("#items").removeClass("d-none");
                $("#loader").addClass("d-none");
            }, 1000)
        })
        $(".home").addClass("active2");
    </script>

    <script src="js/get_these_course.js"> </script>
</body>

</html>