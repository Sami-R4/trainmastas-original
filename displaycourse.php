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
    <title id="courseTitle">Course - TrainMastas</title>
</head>

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

    #course_creator_name {
        text-decoration: none;
    }

    #course_creator_name:hover {
        text-decoration: underline;
    }

    .displayTextAsItIs {
        white-space: pre-wrap !important;
    }
</style>

<body>
    <?php
    include "navbar.php"
    ?>
    <div id="fullScreenLoader" style="height:100%; align-items:center;justify-content:center;margin-top:30px">
        <div class="spinner-circle-1 spinner-grow-customized rounded-circle" role="status" style="background-color:rgba(40, 167, 69,0.5);padding:0.5vh">
        </div>
        <div class="spinner-circle-2 spinner-grow-customized rounded-circle mx-2" role="status" style="background-color:rgba(40, 167, 69,0.5);padding:0.5vh">
        </div>
        <div class="spinner-circle-3 spinner-grow-customized rounded-circle" role="status" style="background-color:rgba(40, 167, 69,0.5);padding:0.5vh">
        </div>
    </div>
    <div id="page" class="d-none">

        <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- Main ------------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->
        <main class="pt-navbar mb-2">
            <div class="container">
                <div class="row border p-4 rounded">
                    <div class="col-12 col-md-5 col-lg-4 col-xl-3 d-flex d-column">
                        <img src="" id="cover_image" alt="" class="m-auto rounded mb-4 mb-md-auto" style="width:100%;height:300px;object-fit:cover;">
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 col-xl-9">
                        <div class="ms-2">
                            <h1 class="fs-4 mb-3" id="course_title"></h1>
                            <a href="#" id="course_creator_link" class="fs-7 text-muted fw-bold" style="text-decoration: none;">
                                <img src="" id="course_creator_image" alt="" class="me-2 rounded-circle" style="width:33px;height:33px;object-fit:cover;">
                                <span id="course_creator_name" style="text-decoration: underline;"></span>
                            </a>
                            <p id="course_description" class="mt-2 displayTextAsItIs"></p>
                            <p class="" id="course_modules"></p>
                            <p class="fw-semibold" id="course_price"></p>
                            <div class="mt-3" id="course_scope">

                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="text-muted fs-7 mt-2" id="date_posted"></div>
                                <div class="text-muted fs-7 mt-2" id="certificate"></div>
                            </div>
                            <div class="text-center mt-3 get_started">
                                <a href="" class="btn btn-success rounded-0 my-2 d-none" id="go_to_course">Go To Course</a>
                                <a class="btn btn-success rounded-0 my-2" id="get_started_1">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Confirm Registration Modal -->
            <div class="modal fade get_started" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="registerModalLabel">Confirm Registration</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-3">
                            <div class="">You are about to register for this course. Would you like to proceed with the registration?</div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger rounded-0" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <button class="btn btn-success rounded-0" id="get_started">Register</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Login Modal -->
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginModalLabel">Login To Continue</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-3">
                            <div class="">To begin, please log in to your account. You’ll be redirected back here to continue enrolling in this course.
                                If you don’t have an account yet, you can create one!</div>
                        </div>
                        <div class="modal-footer">
                            <a href="" class="btn btn-outline-success mx-2 rounded-0" id="login_account">Login</a>
                            <a href="" class="btn btn-success rounded-0" id="create_account">Create Account</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recharge Modal -->
            <div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog" aria-labelledby="rechargeModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rechargeModalLabel">Insufficient Balance</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-3">
                            <div class="">Your balance is insufficient. Recharge now</div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger rounded-0" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <a href="recharge.php" target="_blank" class="btn btn-success rounded-0">Recharge</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!------------------------------------------------------------------------------------------------------------------
    -------------------------------------------------- End Main --------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------------->

        <!--------------------------------------------------------------------------------------------
                                            Courses
    ---------------------------------------------------------------------------------------------->
        <section>
            <div class=" mt-5" id='course-carousel-section'>
                <h2 class="text-center fs-4 mb-0 mx-2">Similar Courses</h2>
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

        <?php
        include "footer.php";
        ?>
    </div>


    <script src="js/owl-carousel.js"></script>
    <script src="js/displaycourse.js"></script>
    <script>
        $(".course").addClass("active2");
        checkSession().then(({ isLoggedIn, userType }) => {
        var temp_isLoggedIn = isLoggedIn;
        $("#get_started_1").click(function() {
            if (temp_isLoggedIn) {
                $("#registerModal").modal("show");
            } else {
                var urlParams = new URLSearchParams(window.location.search);
                var cValue = urlParams.get('v');
                $("#login_account").attr("href", "login.php?v=" + cValue)
                $("#create_account").attr("href", "signup.php?v=" + cValue)
                $("#loginModal").modal("show");
            }
        })
        });
    </script>

    <script src="js/get_these_course.js"> </script>
</body>


</html>