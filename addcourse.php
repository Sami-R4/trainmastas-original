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
           if (!isLoggedIn) {
                window.location.href = 'login.php';
            }else{
                $("#main-body").css("display",'gird')
            }
        });
    </script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="css/header.css" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.css">
    <link href="css/select2.css" rel="stylesheet" />

    <script src="js/bootstrap.js"></script>
    <title>New Course - TrainMastas</title>
    <style>
        /* Updated CSS for select element */
        .select2-selection--multiple {
            background-color: #fff !important;
            border: 1px solid #ced4da !important;
            /* Bootstrap's form-control border color */
            border-radius: 0 !important;
            margin-top: 3px !important;
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
            border-radius: 0 !important;
            margin-top: 3px !important;
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

        input[type="radio"]:checked {
            accent-color: #198754;
        }

        .addVidModule {
            cursor: pointer;
        }

        .disabled-select {
            pointer-events: none;
            /* Prevents any mouse events */
            background-color: #f0f0f0;
            /* Light gray background */
            color: #999;
            /* Gray text color */
            cursor: not-allowed;
            /* Change cursor to indicate it's not clickable */
        }

        .non-clickable {
            pointer-events: none;
            /* Prevents the user from clicking */
            opacity: 0.6;
            /* Makes the button look disabled */
            cursor: not-allowed;
            /* Shows a "disabled" cursor */
        }
    </style>
</head>

<body style="overflow:hidden;display:none;" id='main-body'>
    <div id="fullScreenLoader" style="height:100%; align-items:center;justify-content:center;">
        <div class="spinner-circle-1 spinner-grow-customized rounded-circle" role="status" style="background-color:rgba(40, 167, 69,0.5);padding:0.5vh">
        </div>
        <div class="spinner-circle-2 spinner-grow-customized rounded-circle mx-2" role="status" style="background-color:rgba(40, 167, 69,0.5);padding:0.5vh">
        </div>
        <div class="spinner-circle-3 spinner-grow-customized rounded-circle" role="status" style="background-color:rgba(40, 167, 69,0.5);padding:0.5vh">
        </div>
    </div>
    <!-- Rejection Notification Modal -->
    <div class="modal fade" id="rejectionModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Course Rejected</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div id="rejection-message" class="d-none text-danger fs-8"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto col-12 col-md-10 col-lg-9 mt-2 " id="main">
        <!-- Delete section -->
        <div class="text-end  d-none" id="deleteContainer">
            <span id="deleteContainerSpan">
                <a id="delete" class="btn btn-danger fw-semibold rounded-0 disabled" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</a>
            </span>
            <p class="text-danger fs-8 my-0 fw-semibold d-none p-0" id="delete-span">This course has students. You cannot delete it.</p>
        </div>


        <!-- The Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this course?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger px-4 rounded-0 d-none my-0" type="button" disabled id="btn-loader-delete">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                        <button id="confirmDelete" class="btn btn-danger rounded-0">Delete</button>
                        <button type="button" id="cancelDelete" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------------------------------------------------------
        --------------------------------------------------------------------------------------
                                                Course Details 
        -------------------------------------------------------------------------------------
        ------------------------------------------------------------------------------------>
        <div class="border rounded-0 mt-3" style="padding:30px 30px;max-height:95vh;overflow:auto" id="details">
            <h4 class="text-center mb-4">Course Details</h4>

            <div class="mt-3 mx-auto">

                <div id="alert-account" class="text-danger mx-auto text-center" style="font-size: 13px;width:400px"></div>
                <div class="form-outline mt-3" style="width: 100%">
                    <input type="text" id="title" value="" placeholder="Course title" class="form-control" />
                    <span class="text-danger fs-8 my-0 fw-semibold" id="title-span" style="display:none">Title is required.</span>
                </div>
                <div class="form-outline mt-3" style="width: 100%">
                    <textarea class="form-control" style="resize: none;height: 110px;" placeholder="Course Description" id="description"></textarea>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="description-span" style="display:none">Description is required.</span>
                </div>
                <div class="form-outline mt-3 mb-3" style="width: 100%">
                    <input type="file" accept="image/*" class="form-control" id="cover" placeholder="Cover image">
                    <span class="text-danger fs-8 my-0 fw-semibold" id="cover-span" style="display:none">Cover is required.</span>
                    <img id="cover-image" class="d-none" src="" alt="Cover Image" style="max-width: 100%; height: 200px;">
                </div>
                <div class="mb-3">
                    <select id="category" class="select2">
                        <option></option>
                        <option value="Technology & IT">Technology & IT</option>
                        <option value="Business & Management">Business & Management</option>
                        <option value="Health & Wellness">Health & Wellness</option>
                        <option value="Creative Art & Design">Creative Art & Design</option>
                        <option value="Personal Development">Personal Development</option>
                        <option value="Languages & Literature">Languages & Literature</option>
                        <option value="Science & Engineering">Science & Engineering </option>
                        <option value="Religion">Religion</option>
                        <option value="Others">Others</option>
                    </select>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="category-span" style="display:none">category is required.</span>
                </div>
                <div class="mb-3">
                    <select id="keys" multiple class="select2">
                        <?php
                        include "skills.php";
                        ?>
                    </select>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="keys-span" style="display:none">At least one skill is required.</span>
                </div>
                <div class="mb-3">
                    <select id="type" class="select2">
                        <option></option>
                        <option value="free">Free</option>
                        <option value="premium">Premium</option>
                    </select>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="type-span" style="display:none">Type is required.</span>
                </div>
                <div class="form-outline mt-3 mb-3 d-none" style="width: 100%" id="price-div">
                    <input class="form-control" id="price" placeholder="Price in dollars.">
                    <span class="text-danger fs-8 my-0 fw-semibold" id="price-span" style="display:none">Price is required.</span>
                </div>
                <div class="mb-3" id="moduleNumContainer">
                    <select id="modulesNum" class="select2">
                        <option></option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="modulesNum-span" style="display:none">The total number of modules is required.</span>
                </div>
                <div id="testQuestionContainer">
                    <span>Is there a test at the end of the course?</span>
                    <div>
                        <label>
                            <input type="radio" name="testQuestion" class="selectType" value="yes"> Yes
                        </label>
                        <label>
                            <input type="radio" class="text-success" class="selectType" name="testQuestion" value="no"> No
                        </label>
                    </div>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="testQuestion-span" style="display:none">This field is required.</span>
                </div>
                <div class="mb-3 mt-2" id="testNumContainer" style="display:none">
                    <select id="testNum" class="select2">
                        <option></option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                    </select>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="testNum-span" style="display:none">The total number of test questions is required.</span>
                </div>
                <!-- Submit button -->
                <div class="d-flex justify-content-between">
                    <div class="an_error_exist text-danger fs-7"></div>
                    <div class="text-end">
                        <a id="next" class="btn btn-success fw-semibold rounded-0" style="font-size:14px;">Next</a>
                        <button class="btn btn-success px-4 rounded-0 d-none my-0" type="button" disabled id="btn-loader-details">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!------------------------------------------------------------------------------------
        --------------------------------------------------------------------------------------
                                                Modules Details 
        -------------------------------------------------------------------------------------
        ------------------------------------------------------------------------------------>
        <div class="border rounded-0 d-none mt-3" style="padding:30px 30px;max-height:95vh;overflow:auto" id="modules">
            <h4 class=" text-center mb-4" id="module-header">Modules</h4>
            <div class="mt-3 mx-auto">
                <div class="module-warning text-danger d-none mb-2">
                    Please fill out all required fields.
                </div>
                <div id="module-div">

                </div>
                <div class="module-warning text-danger d-none mb-2">
                    Please fill out all required fields.
                </div>


                <!-- Submit button -->
                <div class="d-flex justify-content-between mt-3">
                    <a id="previous" class="btn btn-light fw-semibold rounded-0 btn-toDisabled" style="font-size:14px;">Previous</a>
                    <div class="text-end">
                        <button class="btn btn-success px-5 d-none rounded-0 me-3" type="button" disabled id="btn-loader-saveAndExitModule">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                        <a id="saveAndExitModule" class="btn btn-outline-success fw-semibold rounded-0 me-3 d-none btn-toDisabled btn-reload" style="font-size:14px;">Save And Exit</a>
                        <button class="btn btn-success px-5 d-none rounded-0" type="button" disabled id="btn-loader-module">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                        <a id="nextSaveModule" class="btn btn-success fw-semibold rounded-0  d-none btn-toDisabled" style="font-size:14px;">Next</a>
                        <a id="nextModule" class="btn btn-success fw-semibold rounded-0 btn-toDisabled" style="font-size:14px;">Next Module</a>
                        <button class="btn btn-success px-4  rounded-0 d-none" type="button" disabled id="btn-loader-nextSaveModule">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!------------------------------------------------------------------------------------
        --------------------------------------------------------------------------------------
                                                Test Details 
        -------------------------------------------------------------------------------------
        ------------------------------------------------------------------------------------>
        <div class="border rounded-0 d-none mt-3" style="padding:30px 30px;max-height:95vh;overflow:auto" id="test-details">

            <h4 class="text-center mb-4">Test</h4>

            <div class="test-warning alert text-danger d-none my-0">
                Please fill out all required fields.
            </div>
            <div class="mt-3">
                <div id="test-div">

                </div>
                <div class="test-warning alert text-danger d-none my-0">
                    Please fill out all required fields.
                </div>
            </div>


            <!-- Submit button -->
            <div class="d-flex justify-content-between mt-3">
                <a id="test-previous" class="btn btn-light fw-semibold rounded-0 btn-toDisabled" style="font-size:14px;">Previous</a>
                <div class="text-end">
                    <a id="submitTestExit" class="btn btn-outline-success fw-semibold rounded-0 d-none me-3 btn-reload btn-toDisabled" style="font-size:14px;">Save And Exit</a>
                    <button class="btn btn-success px-5 d-none rounded-0 me-3" type="button" disabled id="btn-loader-submitTestExit">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                    <a id="submit" class="btn btn-success fw-semibold rounded-0 d-none btn-toDisabled" style="font-size:14px;">Submit</a>
                    <button class="btn btn-success px-4 d-none rounded-0" type="button" disabled id="btn-loader-test">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                    <a id="test-next" class="btn btn-success fw-semibold rounded-0" style="font-size:14px;">Next Questions</a>
                </div>
            </div>
        </div>

        <div class="border rounded-0 mt-5 d-none" style="padding:40px 40px;" id="success-div">

            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="100px" height="100px" viewBox="0 0 12 12">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6 12A6 6 0 106 0a6 6 0 000 12zm2.576-7.02a.75.75 0 00-1.152-.96L5.45 6.389l-.92-.92A.75.75 0 003.47 6.53l1.5 1.5a.75.75 0 001.106-.05l2.5-3z" fill="#198754" />
                </svg>
            </div>
            <div class="mt-3 text-center mt-3 mb-3" id="success-message">
                Congratulations! Your course has been submitted for review. Our team will carefully evaluate your course within the next 2-3 business days. You will receive a notification once the review is complete.
            </div>
            <div class="my-3 text-center">
                <a href="dashboard.php" class="btn btn-outline-success rounded-0 btn-reload">Return to Dashboard</a>
            </div>
        </div>

    </div>

    <script src="js/select2.js"></script>
    <script>
        $(document).ready(function() {

            var $select = $('#keys').select2({
                placeholder: "Select up to 10 areas covered", // Placeholder text
                tags: true,
                maximumSelectionLength: 10,
                allowClear: true, // Allows clearing the selection, which brings back the placeholder
                width: '100%',
                createTag: function(params) {
                    var term = params.term.trim();
                    if (term.length > 0 && term.length <= 50) {
                        return {
                            id: term,
                            text: term,
                            newTag: true
                        };
                    } else {
                        $("#keys-warning").text("The skill should not be more than 50 characters.");
                        $("#keys-warning").show();
                    }
                    return null;
                },
                closeOnSelect: false, // Keep the dropdown open after selection
            });
            // Function to sort selected options alphabetically and reorder DOM
            function sortSelectedOptions(selectElement) {
                var selectedOptions = selectElement.find('option:selected').sort(function(a, b) {
                    return a.text.localeCompare(b.text);
                });

                selectedOptions.each(function() {
                    var $option = $(this).detach();
                    selectElement.append($option);
                });

                selectElement.trigger('change'); // Refresh select2 display
            }

            // Attach event listeners to sort options after selection or removal
            $select.on('select2:select select2:unselect', function() {
                sortSelectedOptions($select);
            });

            // Expose $select for other scripts
            window.$select = $select;


            $("#modulesNum").select2({
                placeholder: "Select the number of modules",
                width: '100%',
                minimumResultsForSearch: Infinity // Hides the search box
            });

            $("#type").select2({
                placeholder: "Select course type",
                width: '100%',
                minimumResultsForSearch: Infinity // Hides the search box
            });
            $("#category").select2({
                placeholder: "Select course category",
                width: '100%',
                minimumResultsForSearch: Infinity // Hides the search box
            });
            $("#testNum").select2({
                placeholder: "Select number of question for the test",
                width: '100%',
                minimumResultsForSearch: Infinity // Hides the search box
            });

            $("input[name='testQuestion']").change(function() {
                if ($(this).val() === "yes") {
                    // Show the testNum select element
                    $("#testNumContainer").show();
                } else {
                    // Hide the testNum select element
                    $("#testNumContainer").hide();
                    $("#testNum").val("");
                }
            });
            $(".addVidModule").mouseenter(function() {
                $(".addVidModule path").css("fill", "#198754"); // Success green color on hover
            });

            $(".addVidModule").mouseleave(function() {
                $(".addVidModule path").css("fill", "#0F0F0F"); // Original color on mouseout
            });

            $(document).ready(function() {
                /////////////////////////////////////////////////////////////////////////////////////// 
                //////////////////////////////// Extract Link From Iframe ///////////////////////////// 
                /////////////////////////////////////////////////////////////////////////////////////// 
                function getIframeSrc(iframeHtml) {
                    // Create a temporary DOM element to parse the iframe HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = iframeHtml;

                    // Get the iframe element from the temporary div
                    const iframe = tempDiv.querySelector('iframe');

                    // Return the src attribute value if iframe is found, otherwise return false
                    return iframe ? iframe.src : false;
                }


            })
        })
    </script>
    <script src="js/addcourse.js"></script>
</body>


</html>