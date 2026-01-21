<link rel="stylesheet" href="css/header.css">
<script>
    if (window.location.pathname === '/trainmastas/navbar.php') {
        var newURLT;
        newURLT = '/trainmastas/login.php';
        history.pushState({}, '', newURLT);
        window.location.href = newURLT
    }
    var isLoggedIn = false;
    let lastScroll = 0;
    let navTimeout;
    let isHovering = false;
    let scriptActive = false;
    //////////////////////////////////////////////////// 
    //////////////////////////////////////////////////// 
    /////////////       Mobile Navbar     ////////////// 
    //////////////////////////////////////////////////// 
    //////////////////////////////////////////////////// 
    function shouldShowMobileNavbar() {  
        if (!isLoggedIn) {  
            $("#visitor-toggle").removeClass("d-none");  
            return false; // Not logged in, no need to show mobile navbar  
        }  
        if ($(window).width() >= 992) {  
            // If width is >= 992, hide mobile navbar  
            $("#mobileNavbar").css("bottom", "-100px");  
            return false;  
        }  
        return true; // Show only if logged in and width < 992  
    }  

    function showNavbar() {
        if (!scriptActive) return;
        $("#mobileNavbar").css("bottom", "0px");
        clearTimeout(navTimeout);

        if (!isHovering) {
            navTimeout = setTimeout(() => {
                hideNavbar();
            }, 5000);
        }
    }

    function hideNavbar() {
        if (!scriptActive || isHovering) return;
        $("#mobileNavbar").css("bottom", "-100px");
    }

    function activateMobileNavbar() {
        if (scriptActive) return; // Already active

        scriptActive = true;

        $(window).on("scroll.mobileNavbar", function() {
            if (!shouldShowMobileNavbar()) return;

            let currentScroll = $(this).scrollTop();

            if (currentScroll < lastScroll) {
                showNavbar();
            } else if (currentScroll > lastScroll) {
                hideNavbar();
            }

            lastScroll = currentScroll;
        });

        $("#mobileNavbar").on("mouseenter.mobileNavbar touchstart.mobileNavbar", function() {
            isHovering = true;
            clearTimeout(navTimeout);
            showNavbar();
        });

        $("#mobileNavbar").on("mouseleave.mobileNavbar touchend.mobileNavbar", function() {
            isHovering = false;
            navTimeout = setTimeout(() => {
                hideNavbar();
            }, 5000);
        });

        $(document).on("mousemove.mobileNavbar", function(e) {
            const threshold = 40;
            const distanceFromBottom = $(window).height() - e.clientY;
            if (distanceFromBottom < threshold) {
                showNavbar();
            } else {
                hideNavbar();
            }
        });

        let touchStartY = 0;
        $(document).on("touchstart.mobileNavbar", function(e) {
            touchStartY = e.originalEvent.touches[0].clientY;
        });

        $(document).on("touchmove.mobileNavbar", function(e) {
            const touchY = e.originalEvent.touches[0].clientY;
            if (touchStartY > $(window).height() - 50 && touchY < touchStartY - 20) {
                showNavbar();
            }
        });

        showNavbar();
    }

    function deactivateMobileNavbar() {
        if (!scriptActive) return;

        scriptActive = false;

        $(window).off(".mobileNavbar");
        $("#mobileNavbar").off(".mobileNavbar");
        $(document).off(".mobileNavbar");

        hideNavbar();
    }

    function evaluateNavbarActivation() {
        if (shouldShowMobileNavbar()) {
            activateMobileNavbar();
        } else {
            deactivateMobileNavbar();
        }
    }

    function setupNavbar(isLoggedIn, userType) {
        $(document).ready(function() {
            evaluateNavbarActivation(); // if needed
            if (isLoggedIn) {
              if (userType === 's') {
                $(".instructor-section").remove();
              }
              $('.visitor-elements').remove();
              $('.dashboard-elements').removeClass("d-none");
            } else {
              $('.dashboard-elements').remove();
              $('.visitor-elements').removeClass("d-none");
            }
        
            $(".visitor-dashboard-elements").removeClass("d-none");
        });
    }

    checkSession().then(({ isLoggedIn, userType }) => {
    // Now that session is ready, call navbar setup
        setupNavbar(isLoggedIn, userType);
    });
      
    
    $(document).ready(function() {
        $(window).on("resize", function() {
            evaluateNavbarActivation();
        });
    });
</script>
<style>
    .nav-links-hover:hover {
        border-bottom: 2px solid green;
        color: green;
    }

    @media (max-width:991px) {
        .pt-navbar {
            padding-top: 138px;
        }

        .active2 {
            background-color: rgba(25, 135, 84, 0.4);
        }


    }

    @media (max-width:450px) {
        #mobileNavbar .nav-item {
            font-size: 13px;
            padding: 2px
        }
    }

    @media (min-width:450px) {
        #mobileNavbar .nav-item {
            font-size: 15px;
            padding: 8px
        }
    }

    @media (min-width:992px) {
        .pt-navbar {
            padding-top: 110px;
        }
        

        .active2 {
            border-bottom: 2px solid green;
            color: green;
        }

    }

    .fs-7 {
        font-size: 13px;
    }

    /* Container styles for icons */
    .nav-icon {
        position: relative;
        display: inline-block;
    }

    /* Badge styles */
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        padding: 2px 6px;
        border-radius: 50%;
        background-color: #28a745;
        color: white;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
        line-height: 1;
        text-align: center;
        min-width: 8px;
    }


    /* Additional adjustments for badge positioning */
    #notificationDropdown[data-class="1"] .notification-badge {
        top: -1px;
        right: -1px;
    }

    #notificationDropdown[data-class="2"] .notification-badge {
        top: -1px;
        right: -2px;
    }

    /* Change the border color of form-control inputs to success on focus */
    .form-control:focus {
        border-color: #198754;
        /* Bootstrap's border-success color */
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        /* Add a subtle shadow */
    }

    .border-top-gainboro {
        border-top: 1px solid gainsboro;
        padding: 25px 5px;
    }

    .border-top-gainboro:hover {
        cursor: pointer;
        background-color: gainsboro;
    }
</style>
<script src="js/header.js"></script>

<div id="mobileNavbar">
    <a href="index.php" class="nav-item home">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 16 16" fill="none">
                <path d="M1 6V15H6V11C6 9.89543 6.89543 9 8 9C9.10457 9 10 9.89543 10 11V15H15V6L8 0L1 6Z" fill="#333" />
            </svg>
        </div>
        Home
    </a>
    <a href="dashboard.php" class="nav-item dashboard">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 24 24" fill="none">
                <path d="M12 12C12 11.4477 12.4477 11 13 11H19C19.5523 11 20 11.4477 20 12V19C20 19.5523 19.5523 20 19 20H13C12.4477 20 12 19.5523 12 19V12Z" stroke="#333" stroke-width="2" stroke-linecap="round" />
                <path d="M4 5C4 4.44772 4.44772 4 5 4H8C8.55228 4 9 4.44772 9 5V19C9 19.5523 8.55228 20 8 20H5C4.44772 20 4 19.5523 4 19V5Z" stroke="#333" stroke-width="2" stroke-linecap="round" />
                <path d="M12 5C12 4.44772 12.4477 4 13 4H19C19.5523 4 20 4.44772 20 5V7C20 7.55228 19.5523 8 19 8H13C12.4477 8 12 7.55228 12 7V5Z" stroke="#333" stroke-width="2" stroke-linecap="round" />
            </svg>
        </div>
        Dashboard
    </a>
    <a href="courses.php" class="nav-item course">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#333" version="1.1" id="Layer_1" width="25px" height="25px" viewBox="0 0 256 241" enable-background="new 0 0 256 241" xml:space="preserve">
                <path d="M254,188V2H2v186h111v29H75v22h106v-22h-38v-29H254z M19,19h217v151H19L19,19z M128.049,103.364l-2.077-0.791L92.391,90.011  v30.762c0,6.627,15.925,12.018,35.609,12.018s35.609-5.391,35.609-12.018V90.011l-33.482,12.562L128.049,103.364z M80.472,79.18  v38.23c2.374,1.088,4.006,3.511,4.006,6.33v16.815H70.63V123.74c0-2.77,1.632-5.193,3.957-6.281V77.004l-9.891-3.709l63.354-23.739  l63.255,23.739l-63.255,23.739L80.472,79.18z" />
            </svg>
        </div>
        Courses
    </a>
    <a href="dashboard.php?#registeredCourseDiv" class="nav-item registeredCourse">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="25px" width="25px" version="1.1" id="_x32_" viewBox="0 0 512 512" xml:space="preserve">
                <style type="text/css">
                    .st1 {
                        fill: #333;
                    }
                </style>
                <g>
                    <path class="st1" d="M463.29,305.295v-84.777h-9.38c-39.71,0-75.128,6.873-104.271,15.713c-3.467-7.023-7.264-14.182-10.956-20.92   c1.59-1.441,3.166-2.919,4.682-4.435c22.331-22.316,36.183-53.253,36.168-87.343c0.016-34.089-13.837-65.026-36.168-87.336   C321.035,13.837,290.089,0,256.007,0c-34.082,0-65.027,13.837-87.343,36.198c-22.331,22.309-36.182,53.246-36.182,87.336   c0,34.09,13.851,65.027,36.182,87.343c1.516,1.516,3.076,3.017,4.682,4.435c-3.706,6.738-7.503,13.897-10.97,20.92   c-29.159-8.84-64.547-15.713-104.257-15.713h-9.38v84.777c-28.318,0.526-39.154,23.877-39.154,52.631   c0,28.754,10.836,52.106,39.154,52.631v67.481l9.035,0.315h0.255c2.836,0.098,28.634,1.208,63.586,5.89   c34.938,4.667,79.044,12.958,118.244,27.193l1.545,0.563h29.22l1.545-0.563c40.445-14.692,86.158-23.044,121.59-27.629   c17.739-2.288,32.896-3.661,43.611-4.456c5.358-0.398,9.604-0.646,12.501-0.811c1.441-0.068,2.536-0.128,3.286-0.15   c0.36-0.023,0.646-0.038,0.811-0.038h0.27l9.049-0.315v-67.481c28.319-0.548,39.124-23.877,39.124-52.631   C502.414,329.172,491.609,305.836,463.29,305.295z M49.746,391.821c-0.315,0-0.646,0-1.006-0.015   c-6.438-0.068-20.395-1.756-20.395-33.879c0-32.131,13.957-33.819,20.395-33.88c0.36-0.022,0.691-0.022,1.006-0.022   c6.498,0,12.576,1.861,17.739,5.043c9.694,5.958,16.147,16.673,16.147,28.859c0,12.186-6.453,22.894-16.147,28.852   C62.322,389.967,56.244,391.821,49.746,391.821z M230.63,286.259v202.262c-38.089-12.126-78.069-19.15-109.974-23.314   c-23.502-3.046-42.576-4.48-53.171-5.125V407.51c20.365-7.293,34.906-26.728,34.906-49.584c0-22.856-14.542-42.299-34.906-49.584   v-68.921c48.863,1.395,90.494,13.536,120.389,25.73c15.893,6.453,28.469,12.914,36.978,17.731c2.192,1.246,4.127,2.371,5.778,3.37   V286.259z M268.884,492.708c-0.495,0.165-1.006,0.353-1.501,0.541h-22.736c-0.495-0.188-0.99-0.376-1.516-0.541V292.396h25.753   V492.708z M256.007,228.682c-28.574,0-54.402-11.353-73.341-29.812c-0.33-0.33-0.66-0.646-1.006-0.975   c-10.28-10.296-18.414-22.669-23.742-36.46c18.459-3.482,35.418-10.445,50.545-19.03c25.498-14.452,45.923-33.459,60.09-48.849   c6.123-6.649,11.061-12.629,14.723-17.296c5.898,7.602,14.797,18.752,24.942,30.315c9.11,10.378,19.21,21.086,29.235,29.978   c4.997,4.458,9.995,8.464,14.947,11.773c1.681,1.103,3.347,2.108,5.013,3.061c-4.878,17.836-14.317,33.774-27.043,46.508   c-0.346,0.33-0.675,0.668-1.021,0.998C310.379,217.352,284.552,228.682,256.007,228.682z M444.545,460.082   c-10.595,0.645-29.67,2.079-53.201,5.125c-31.875,4.142-71.856,11.188-109.944,23.314c0,0,0,0-0.014,0V286.236   c0.014,0,0.014,0,0.014,0c8.164-4.899,23.157-13.168,43.492-21.4c29.834-12.066,71.18-24.042,119.654-25.415v68.921   c-20.365,7.286-34.922,26.728-34.922,49.584c0,22.856,14.557,42.291,34.922,49.584V460.082z M463.29,391.806   c-0.375,0.015-0.705,0.015-1.02,0.015c-6.498,0-12.562-1.831-17.724-5.02c-9.695-5.98-16.178-16.688-16.178-28.874   c0-12.186,6.483-22.901,16.178-28.882c5.162-3.181,11.226-5.02,17.724-5.02c0.315,0,0.646,0,1.02,0.022   c6.453,0.083,20.38,1.794,20.38,33.88C483.669,390.012,469.743,391.723,463.29,391.806z" />
                    <circle class="st1" cx="215.383" cy="161.037" r="12.502" />
                    <circle class="st1" cx="296.632" cy="161.037" r="12.502" />
                </g>
            </svg>
        </div>

        MyCourses
    </a>
    <a href="dashboard.php?#createdCourseDiv" class="nav-item createdCourse instructor-section">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#333" height="25px" width="25px" version="1.1" id="Icons" viewBox="0 0 32 32" xml:space="preserve">
                <style type="text/css">
                    .st0 {
                        fill: #FFFFFF;
                    }
                </style>
                <g>
                    <path d="M28,14H14c-1.1,0-2-0.9-2-2s0.9-2,2-2h1h13c0.6,0,1-0.4,1-1s-0.4-1-1-1H15h-1H7C5.9,8,5,7.1,5,6s0.9-2,2-2h14   c0.6,0,1-0.4,1-1s-0.4-1-1-1H7C4.8,2,3,3.8,3,6v15c0,2.2,1.8,4,4,4h3v2c0,2.2,1.8,4,4,4h14c0.6,0,1-0.4,1-1V15   C29,14.4,28.6,14,28,14z" />
                    <path d="M28,11H14c-0.6,0-1,0.4-1,1s0.4,1,1,1h14c0.6,0,1-0.4,1-1S28.6,11,28,11z" />
                    <path d="M21,5H7C6.4,5,6,5.4,6,6s0.4,1,1,1h14c0.6,0,1-0.4,1-1S21.6,5,21,5z" />
                </g>
            </svg>
        </div>
        CreatedCourses
    </a>
</div>
<style>
    #mobileNavbar {
        position: fixed;
        bottom: -100px;
        /* hidden by default */
        left: 0;
        right: 0;
        border-top: gainsboro solid 1px;
        background-color: #fff;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-around;
        padding: 10px 0;
        z-index: 2;
        transition: bottom 0.4s ease;
    }

    #mobileNavbar .nav-item {
        color: #333;
        text-align: center;
        text-decoration: none;
    }

    #mobileNavbar .nav-item:hover {
        /* background-color: rgba(0, 0, 0, 0.1); */
        background-color: rgba(25, 135, 84, 0.4);
    }
</style>


<!--------------------------------------------------------------------------------------------
                                             Navbar
    ---------------------------------------------------------------------------------------------->
<nav class="navbar navbar-expand-lg navbar-light bg-white position-fixed w-100" style="border-bottom:1px solid gainsboro;z-index:200">
    <div class="container-fluid visitor-dashboard-elements d-none">
        <a class="navbar-brand mx-3 logo" href="index.php"><img src="image/logo.png" width="40px" alt="logo"><span class="fw-semibold ms-2 text-success">TrainMastas</span></a>

        <!-------------------------------------------------------------------------------------------------
            ----------------------------------------------- Dashboard Elements --------------------------------
            -------------------------------------------------------------------------------------------------->

        <button class="navbar-toggler me-4 d-none" id="visitor-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" style="outline: none !important;box-shadow: none !important;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-------------------------------------------------------------------------------------------------
            ----------------------------------------------- End Dashboard Elements ----------------------------
            -------------------------------------------------------------------------------------------------->

        <div class="ms-auto dashboard-elements d-none">
            <div class="ms-auto d-flex d-lg-none ">
                <span class="userBalance ms-2 me-3"></span>
                <div class="profile-loader spinner mx-0" role="status" style="background-color:rgba(56, 182, 255, 0.2);padding:3vh;">
                </div>
                <div class=" dropdown">
                    <div class="profile-loader spinner rounded-circle mx-xl-3 mx-1" role="status" style="background-color:rgba(56, 182, 255, 0.2);padding:3vh;">
                    </div>
                    <a href="#" class="nav-profile d-none" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="white-space: normal !important; word-wrap: break-word;text-decoration:none;">
                        <img src="image/default-profile.png" style="width:40px;height:40px;object-fit: cover;" class="mx-xl-3 rounded-circle userImage">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 20 20">
                            <path fill="#5C5F62" d="M13.098 8H6.902c-.751 0-1.172.754-.708 1.268L9.292 12.7c.36.399 1.055.399 1.416 0l3.098-3.433C14.27 8.754 13.849 8 13.098 8Z" />
                        </svg>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end rounded-0 me-4 me-md-1 me-xxl-2 shadow border-0" style="background-color: white; width: 100%;" id="main-navbar">
                        <li><a class="dropdown-item text-black py-2" href="profile.php" style="border-top:1px solid gainsboro"><span class="ms-3">Profile</span></a></li>
                        <li><a class="dropdown-item text-black py-2 log-out" style="border-top:1px solid gainsboro;cursor:pointer"><span class="ms-3">Logout</span></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse justify-content-center navbarNav">
            <ul class="navbar-nav ms-3">
                <li class="nav-item mx-2 mx-md-1">
                    <a href="index.php" class="nav-link nav-links-hover home">
                        Home
                    </a>
                </li>
                <li class="nav-item mx-2 mx-md-1 dashboard-elements d-none">
                    <a href="dashboard.php" class="nav-link nav-links-hover dashboard">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mx-2 mx-md-1 dashboard-elements d-none">
                    <a href="dashboard.php?#registeredCourseDiv" class="nav-link nav-links-hover registeredCourse" style="width:99px">
                        MyCourses
                    </a>
                </li>
                <li class="nav-item mx-2 mx-md-1 dashboard-elements d-none  instructor-section">
                    <a href="dashboard.php?#createdCourseDiv" class="nav-link nav-links-hover createdCourse" style="width:132px">
                        CreatedCourses
                    </a>
                </li>
                <li class="nav-item mx-2 mx-md-1 ">
                    <a href="courses.php" class="nav-link nav-links-hover course">
                        Courses
                    </a>
                </li>
            </ul>
        </div>
        <div class="input-group  mx-auto mt-3 mt-lg-0 mx-lg-3">
            <input type="text" id="search_box" placeholder="Search" class="form-control rounded-0 d-block" style="width:100%">
        </div>
        <!-------------------------------------------------------------------------------------------------
            ----------------------------------------------- Dashboard Elements --------------------------------
            -------------------------------------------------------------------------------------------------->
        <div class="ms-auto dashboard-elements d-none">
            <div class="ms-auto d-none d-lg-flex ">
                <span class="userBalance ms-2 me-3"></span>
                <div class="profile-loader spinner mx-0" role="status" style="background-color:rgba(56, 182, 255, 0.2);padding:3vh;">
                </div>
                <div class=" dropdown">
                    <div class="profile-loader spinner rounded-circle mx-xl-3 mx-1" role="status" style="background-color:rgba(56, 182, 255, 0.2);padding:3vh;">
                    </div>
                    <a href="#" class="nav-profile d-flex d-none" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="white-space: normal !important; word-wrap: break-word;text-decoration:none;">
                        <img src="image/default-profile.png" style="width:40px;height:40px;object-fit: cover;" class="mx-xl-3 rounded-circle userImage">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 20 20">
                            <path fill="#5C5F62" d="M13.098 8H6.902c-.751 0-1.172.754-.708 1.268L9.292 12.7c.36.399 1.055.399 1.416 0l3.098-3.433C14.27 8.754 13.849 8 13.098 8Z" />
                        </svg>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end rounded-0 me-4 me-md-1 me-xxl-2 shadow border-0" style="background-color: white; width: 100%;" id="main-navbar">
                        <li><a class="dropdown-item text-black py-2" href="profile.php" style="border-top:1px solid gainsboro"><span class="ms-3">Profile</span></a></li>
                        <li><a class="dropdown-item text-black py-2 log-out" style="border-top:1px solid gainsboro;cursor:pointer"><span class="ms-3">Logout</span></a></li>
                    </ul>
                </div>

            </div>
        </div>
        <style>
            .dropdown-item {
                transition: background-color 0.3s ease;
            }

            /* Style for hover state */
            .dropdown-item:hover {
                background-color: rgba(40, 167, 69, 0.5);
                /* Lighter RGBA success color for hover */
                color: #fff;
                /* Optional: Change text color on hover */
            }

            /* Style for active (clicked) state */
            .dropdown-item.active,
            .dropdown-item:active {

                background-color: rgba(40, 167, 69, 0.6);
                /* RGBA success color */
                color: #fff;
                /* Change text color */
            }
        </style>
        <!-------------------------------------------------------------------------------------------------
            ----------------------------------------------- End Dashboard Elements ----------------------------
            -------------------------------------------------------------------------------------------------->

        <div class="collapse navbar-collapse justify-content-center navbarNav visitor-elements d-none">
            <ul class="navbar-nav">
                <li class="nav-item ms-4">
                    <a href="login.php" class=" btn btn-outline-success rounded-0 px-4">
                        Login
                    </a>
                </li>
                <li class="nav-item mx-4 mx-md-3 mx-xxl-2">
                    <a href="signup.php" class=" btn btn-success rounded-0 px-4">
                        Signup
                    </a>
                </li>
            </ul>
        </div>


    </div>
</nav>
<!-- Off-canvas Navbar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="visitor-dashboard-elements">
        <div class="offcanvas-header">
            <a class="navbar-brand mx-3 logo" href="index.php"><img src="image/logo.png" width="40px" alt="logo"></a>
            <button type="button" class="btn-close text-reset me-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="container-fluid">
                <div class="text-center dashboard-elements mb-3">
                    <img src="image/logo.png" style="width:100px;height: 100px;object-fit:cover" class="userImage d-none rounded-circle" alt="userName">
                    <p class="p-0 m-0 userName fw-semibold mt-1 d-none"></p>
                    <p class="p-0 m-0 userBalance fs-7 text-muted  mt-1 d-none"></p>
                    <div class="profile-loader spinner rounded-circle mx-xl-3" role="status" style="background-color:rgba(56, 182, 255, 0.2);padding:4vh;">
                    </div>
                    <p class="p-0 m-0 profile-loader spinner fw-semibold mt-1 w-100" style="background-color:rgba(56, 182, 255, 0.2);padding:4vh;"></p>

                </div>
                <ul class="navbar-nav" id="offcanvasnavcontainer">
                    <li class="nav-item mx-2">
                        <a class="nav-link text-black sm-y border-top-gainboro home " href="index.php">Home
                        </a>
                    </li>
                    <li class="nav-item mx-2 dashboard-elements ">
                        <a class="nav-link text-black sm-y border-top-gainboro dashboard " href="dashboard.php">Dashboard
                        </a>
                    </li>
                    <li class="nav-item mx-2 dashboard-elements ">
                        <a class="nav-link text-black sm-y border-top-gainboro registeredCourse " href="dashboard.php?#registeredCourseDiv">MyCourses
                        </a>
                    </li>
                    <li class="nav-item mx-2 dashboard-elements ">
                        <a class="nav-link text-black sm-y border-top-gainboro createdCourse  instructor-section" href="dashboard.php?#createdCourseDiv">CreatedCourses
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link nav-link-custom text-black sm-y border-top-gainboro course" href="courses.php">Courses
                        </a>

                    </li>
                    <li class="nav-item mx-2 dashboard-elements">
                        <a class="nav-link text-black sm-y border-top-gainboro profile" href="profile.php">Profile
                        </a>
                    </li>
                    <li class="nav-item mx-2 dashboard-elements ">
                        <a class="nav-link text-black sm-y border-top-gainboro log-out">Logout
                        </a>
                    </li>
                    <li class="nav-item mx-2 visitor-elements">
                        <a class="nav-link text-black sm-y border-top-gainboro login" href="login.php">Login
                        </a>
                    </li>
                    <li class="nav-item mx-2 visitor-elements">
                        <a class="nav-link text-black sm-y border-top-gainboro signup" href="signup.php">Signup
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<script src="js/logout.js"></script>
<script>
    /////////////////////////////////////////////////////////////////
    //                            Capitalizer
    /////////////////////////////////////////////////////////////////
    function capitalizeFirstLetter(statement) {
        // Escape quotes to prevent conflicts in HTML  
        function escapeQuotes(value) {
            return value.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        // Escape the input statement  
        const escapedStatement = escapeQuotes(statement);
        var words = escapedStatement.split(" ");
        var capitalizedWords = [];

        for (var i = 0; i < words.length; i++) {
            var word = words[i];
            if (word.length > 0) {
                // Capitalize the first letter if it's an alphabetical character  
                if (/^[a-zA-Z]/.test(word.charAt(0))) {
                    word = word.charAt(0).toUpperCase() + word.slice(1);
                }
            }
            capitalizedWords.push(word);
        }

        return capitalizedWords.join(" ");
    }
    $(document).ready(function() {
        function fetchUserProfileDetail() {
            $.ajax({
                url: "app/dashboard_process.php",
                method: "POST",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token') // Send the stored token
                },
                data: {
                    purpose: "userDetails"
                },
                dataType: "json",
                success: function(response) {
                    setTimeout(function() {
                        if (response.state === "success") {
                            $(".profile-loader").addClass("d-none");
                            $(".userName").text(capitalizeFirstLetter(response.userDetails.Name)).removeClass("d-none");
                            $(".userBalance").text("$" + response.userDetails.Balance).removeClass("d-none");
                            $(".userImage").attr("src", response.userDetails.Image ? "profile/" + response.userDetails.Image : "image/default-profile.png").attr("alt", capitalizeFirstLetter(response.userDetails.Name)).removeClass("d-none");
                            $(".nav-profile").removeClass("d-none");

                        }
                    }, 1000)
                }
            })
        }
        fetchUserProfileDetail();
    })
</script>
<!--------------------------------------------------------------------------------------------
                                           End Of Navbar
    ---------------------------------------------------------------------------------------------->