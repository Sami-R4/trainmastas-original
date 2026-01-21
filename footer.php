<script>
    if (window.location.pathname === '/trainmastas/footer.php') {
        var newURLT;
        newURLT = '/trainmastas/login.php';
        history.pushState({}, '', newURLT);
        window.location.href = newURLT
    }
</script>
<!--------------------------------------------------------------------------------------------
                                              Footer
    ---------------------------------------------------------------------------------------------->
<footer class="text-center text-lg-start text-white " style="background-color: rgb(64, 99, 61)">
    <!-- Section: Social media -->

    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <div class="row mt-3 py-5">
                <div class="col-md-6 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold">TrainMastas</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: green; height: 2px" />
                </div>

                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4" style="font-size:15px !important">
                    <p>
                        <a href="index.php" class="text-white footer-link">Home</a>
                    </p>
                    <p>
                        <a href="courses.php" class="text-white footer-link">Courses</a>
                    </p>
                </div>

                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4" style="font-size:15px !important">
                    <p>
                        <a href="privacy-policy.php" class=" text-white footer-link">Privacy Policy</a>
                    </p>
                    <p>
                        <a href="term-and-condition.php" class=" text-white footer-link">Terms & Conditions</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <style>
        .footer-link:hover {
            border-bottom: 1px solid green;
            text-decoration: underline;
            color: green;
        }

        .footer-link {
            text-decoration: none;
        }
    </style>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.3)">
        © 2025 Copyright:
        <a class="text-success footer-link" href="index.php" style="text-decoration:none">TrainMastas.com</a>
    </div>
    <!-- Copyright -->
</footer>
<!--------------------------------------------------------------------------------------------
                                           End Of Footer
    ---------------------------------------------------------------------------------------------->