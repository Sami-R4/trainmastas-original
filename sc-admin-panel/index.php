<?php
include "app/session_checker.php";

if (!$isLoggedIn) {
    // User is not logged in, redirect to login page  
    header("Location: login.php");
    exit(); // Make sure to exit after the redirect to stop further script execution  
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href=".././image/logo.png">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="css/select2.css" rel="stylesheet" />

    <script src="js/jquery.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>Dashboard - TrainMastas</title>
</head>

<body id="body-pd">

    <?php include "navbar.php" ?>
    <!--Container Main start-->
    <div class="height-100 pt-3">
        <!-- Loader -->
        <div id="loader" class="mx-0 p-0">
            <div class="spinner mb-3" style="width: 130px; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
            <div class="row mb-3">
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
            </div>
            <div class="spinner mb-3 mt-4" style="width: 130px; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
            <div class="row mb-3">
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
            </div>
            <div class="spinner mb-3 mt-4" style="width: 130px; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
            <div class="row mb-3">
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
            </div>
            <div class="spinner mb-3 mt-4" style="width: 130px; height: 20px; background-color: rgba(56, 182, 255, 0.1);"></div>
            <div class="row mb-3">
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 col-xxl-2 mb-3">
                    <div class="spinner" style="width: 100%; height: 20px; background-color: rgba(56, 182, 255, 0.1);height:120px;"></div>
                </div>
            </div>
        </div>
        <!-- End Loader -->

        <!-- Main Part -->
        <main id="main" class="mx-0 p-0 d-none">
            <h5 class="fw-bold">Courses</h5>
            <div id="course-div" class="row mb-3">

            </div>
            <h5 class="fw-bold">Certificates</h5>
            <div id="certificate-div" class="row mb-3">

            </div>
            <h5 class="fw-bold">Users</h5>
            <div id="user-div" class="row mb-3">

            </div>
            <h5 class="fw-bold">Transactions</h5>
            <div id="payment-div" class="row mb-3">

            </div>
        </main>

    </div>


</body>
<script src="js/index.js"></script>
<script>
    $(document).ready(function() {
        $("#dashboard-link").addClass("active");
    })
</script>

</html>