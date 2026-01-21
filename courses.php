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
    <link rel="stylesheet" href="css/header.css">

    <style>
        /*
---------------------------------------------
Product Carousel
---------------------------------------------
*/

        .owl-nav {
            display: inline-block !important;
            text-align: center;
            position: absolute;
            width: 100%;
            top: 50%;
            transform: translateY(-25px);
        }

        .owl-nav .owl-prev {
            margin-right: 10px;
            outline: none;
            position: absolute;
            left: -80px;
        }

        .owl-nav .owl-prev span,
        .owl-nav .owl-next span {
            opacity: 0;
        }

        .owl-nav .owl-prev:before {
            display: inline-block;
            font-family: 'FontAwesome';
            color: #1e1e1e;
            font-size: 25px;
            font-weight: 700;
            content: '\f104';
            background-color: #fff;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            line-height: 50px;
        }

        .owl-nav .owl-prev {
            opacity: 1;
            transition: all .5s;

        }

        .owl-nav .owl-prev:hover {
            opacity: 0.9;
        }

        .owl-nav .owl-next {
            opacity: 1;
            transition: all .5s;
        }

        .owl-nav .owl-next:hover {
            opacity: 0.9;
        }

        .owl-nav .owl-next {
            margin-left: 10px;
            outline: none;
            position: absolute;
            right: -85px;
        }

        .owl-nav .owl-next:before {
            display: inline-block;
            font-family: 'FontAwesome';
            color: #1e1e1e;
            font-size: 25px;
            font-weight: 700;
            content: '\f105';
            background-color: #fff;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            line-height: 50px;
        }

        .pageBtn {
            border: 1px solid #fff !important;
        }

        .pageBtn:hover {
            border: 1px solid rgb(40, 167, 69) !important;
        }

        /* 
---------------------------------------------
responsive
--------------------------------------------- 
*/

        @media (max-width: 1300px) {

            .owl-nav .owl-next {
                right: -30px;
            }

            .owl-nav .owl-prev {
                left: -25px;
            }
        }

        @media (max-width: 1200px) {

            .owl-nav .owl-next {
                right: -70px;
            }

            .owl-nav .owl-prev {
                left: -65px;
            }
        }

        @media (max-width: 1085px) {

            .owl-nav .owl-next {
                right: -30px;
            }

            .owl-nav .owl-prev {
                left: -25px;
            }
        }

        @media (max-width: 1000px) {

            .owl-nav .owl-next {
                display: none;
            }

            .owl-nav .owl-prev {
                display: none;
            }
        }


        .h-effect:hover {
            text-decoration: underline;
        }

        .h-effect {
            text-decoration: none;
        }

        .card-h-effect {
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 8px;
            border-radius: 5px;
            overflow: hidden;
        }

        .card-h-effect:hover {
            cursor: pointer;
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .border-bottom-gainboro {
            border-bottom: 1px solid gainsboro;
        }

        @media(max-width: 767px) {
            .reason-border-bottom-gainboro {
                border-bottom: 1px solid gainsboro;
            }
        }

        @media(min-width: 767px) {
            .reason-border-left-gainboro {
                border-left: 1px solid gainsboro;
            }
        }

        .custom-button {
            border: 1px solid rgb(40, 167, 69) !important;
        }
    </style>
    <script src="js/bootstrap.js"></script>
    <title>Courses - TrainMastas</title>
</head>


<body>

    <?php
    include 'navbar.php';
    ?>

    <!--------------------------------------------------------------------------------------------
                                            Courses
    ---------------------------------------------------------------------------------------------->
    <section>
        <div class="pt-navbar">
            <div class="container-fluid mt-4">


                <div class="row mx-1">
                    <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                        <div class="rounded border p-4 mt-lg-0 mb-5 mb-md-0">
                            <!-- Course Type -->
                            <div class="row">
                                <div class="col-6 col-md-12">
                                    <h6 class="fw-semibold py-2">Course Type</h6>
                                    <div class="form-check">
                                        <input class="form-check-input type-checkbox" data-type="type" type="checkbox" value="free" id="Free">
                                        <label class="form-check-label text-muted" for="Free">Free</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input type-checkbox" data-type="type" type="checkbox" value="premium" id="Premium">
                                        <label class="form-check-label text-muted" for="Premium">Premium
                                        </label>
                                    </div>
                                </div>

                                <!-- Period -->
                                <div class="col-6 col-md-12">
                                    <h6 class="fw-semibold py-2">Period</h6>
                                    <div class="form-check">
                                        <input class="form-check-input period-checkbox" data-type="period" type="checkbox" value="newest" id="Newest">
                                        <label class="form-check-label text-muted" for="Newest">Newest</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input period-checkbox" data-type="period" type="checkbox" value="oldest" id="Oldest">
                                        <label class="form-check-label text-muted" for="Oldest">Oldest</label>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="col-6 col-md-12">
                                    <h6 class="fw-semibold py-2">Category</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" data-type="category" type="checkbox" value="technology-it" id="TechnologyIT">
                                        <label class="form-check-label text-muted" for="TechnologyIT">Technology & IT</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" data-type="category" type="checkbox" value="business-management" id="BusinessManagement">
                                        <label class="form-check-label text-muted" for="BusinessManagement">Business & Management</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" data-type="category" type="checkbox" value="health-wellness" id="HealthWellness">
                                        <label class="form-check-label text-muted" for="HealthWellness">Health & Wellness</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" data-type="category" type="checkbox" value="creative-arts-design" id="CreativeArtsDesign">
                                        <label class="form-check-label text-muted" for="CreativeArtsDesign">Creative Arts & Design</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" data-type="category" type="checkbox" value="personal-development" id="PersonalDevelopment">
                                        <label class="form-check-label text-muted" for="PersonalDevelopment">Personal Development</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" data-type="category" type="checkbox" value="languages-literature" id="LanguagesLiterature">
                                        <label class="form-check-label text-muted" for="LanguagesLiterature">Languages & Literature</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" data-type="category" type="checkbox" value="science-engineering" id="ScienceEngineering">
                                        <label class="form-check-label text-muted" for="ScienceEngineering">Science & Engineering</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" data-type="category" type="checkbox" value="religion" id="Religion">
                                        <label class="form-check-label text-muted" for="Religion">Religion</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" data-type="category" type="checkbox" value="others" id="Others">
                                        <label class="form-check-label text-muted" for="Others">Others</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12 col-xl-10" id="saved_id">
                        <div>
                            <p class=" text-muted fs-7 ms-2 mb-1 d-none" id="showing-div">Showing <span id="showing-span">12</span> Courses</p>
                            <div class="row d-none" id="course-container">

                            </div>
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
                                        <div class="card-img-top spinner rounded-circle my-0" role="status" style="padding-bottom:25px;width:30px">
                                        </div>
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
                                        <div class="card-img-top spinner rounded-circle my-0" role="status" style="padding-bottom:25px;width:30px">
                                        </div>
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
                                        <div class="card-img-top spinner rounded-circle my-0" role="status" style="padding-bottom:25px;width:30px">
                                        </div>
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
                                        <div class="card-img-top spinner rounded-circle my-0" role="status" style="padding-bottom:25px;width:30px">
                                        </div>
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
                <div class="col-12 text-end d-flex justify-content-center d-none mt-4" id="btn-container">
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
            </div>
        </div>
    </section>

    <!--------------------------------------------------------------------------------------------
                                           End Of Courses
    ---------------------------------------------------------------------------------------------->



    <?php
    include "footer.php";
    ?>

    </script>
    <script src="js/owl-carousel.js"></script>
    <script src="js/course.js"></script>
    <script>
        $(".course").addClass("active2");
    </script>

</body>

</html>