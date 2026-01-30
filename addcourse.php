<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="./image/logo.png">
    <link rel="stylesheet" href="./css/premium.css">

    <script src="js/jquery.js"></script>
    <script src="js/session_checker.js"></script>
    <script>
        // Redirecting script
        window.addEventListener('sessionChecked', function() {
            if (!window.isLoggedIn) {
                window.location.href = 'login.php';
            }
        });
    </script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="css/header.css" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.css">
    <link href="css/select2.css" rel="stylesheet" />

    <script src="js/bootstrap.js"></script>
    <title>Create New Course - TrainMastas</title>
    <style>
        :root {
            --primary-color: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
            --secondary-color: #6366f1;
            --background-light: #f8fafc;
            --background-white: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #4b5563;
            --text-light: #9ca3af;
            --border-color: #e5e7eb;
            --border-radius: 8px;
            --border-radius-lg: 12px;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.07);
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--text-primary);
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
        }

        /* Main Container */
        #main {
            max-width: 100%;
            width: 100%;
            margin: 0 auto;
        }

        /* Breadcrumbs - Clean & Minimal */
        .breadcrumb-nav {
            background: transparent;
            padding: 20px 0 30px 0;
            border-bottom: none;
            position: relative;
        }

        .breadcrumb-brand {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .breadcrumb-links {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .breadcrumb-nav a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 4px;
            transition: var(--transition);
        }

        .breadcrumb-nav a:hover {
            color: var(--primary-color);
            background: var(--primary-light);
        }

        .breadcrumb-separator {
            color: var(--text-light);
            font-weight: 300;
        }

        .breadcrumb-nav .current {
            color: var(--text-primary);
            font-weight: 600;
            background: transparent;
        }

        /* Loader */
        #fullScreenLoader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .spinner-circle-1,
        .spinner-circle-2,
        .spinner-circle-3 {
            width: 12px;
            height: 12px;
            background: var(--primary-color);
            border-radius: 50%;
            display: inline-block;
            margin: 0 4px;
            animation: bounce 1.4s ease-in-out infinite both;
        }

        .spinner-circle-2 {
            animation-delay: 0.16s;
        }

        .spinner-circle-3 {
            animation-delay: 0.32s;
        }

        @keyframes bounce {
            0%, 80%, 100% {
                transform: scale(0);
                opacity: 0.5;
            }
            40% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Main Content Sections */
        #details,
        #modules,
        #test-details,
        #success-div {
            background: var(--background-white);
            border-radius: var(--border-radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            padding: 40px !important;
            margin-bottom: 24px;
            max-width: 100%;
            width: 100%;
            box-sizing: border-box;
        }

        /* Section Headers */
        h4 {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 24px;
            margin-bottom: 32px !important;
            text-align: center;
            position: relative;
            padding-bottom: 16px;
        }

        h4:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        /* Form Controls - Clean & Consistent */
        .form-control {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 12px 16px;
            font-size: 15px;
            line-height: 1.5;
            transition: var(--transition);
            background: var(--background-white);
            width: 100%;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--text-light);
            opacity: 0.7;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
            line-height: 1.6;
        }

        /* File Upload */
        input[type="file"].form-control {
            padding: 10px;
            cursor: pointer;
            background: var(--background-light);
            border: 2px dashed var(--border-color);
        }

        input[type="file"].form-control:hover {
            border-color: var(--primary-color);
            background: var(--primary-light);
        }

        #cover-image {
            margin-top: 16px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            padding: 20px;
            background: var(--background-light);
            display: block;
            max-width: 100%;
            height: auto;
        }

        /* Enhanced Select2 - Clean & Consistent */
        .select2-container {
            width: 100% !important;
            margin-bottom: 4px;
        }

        .select2-container .select2-selection {
            border: 1px solid var(--border-color) !important;
            border-radius: var(--border-radius) !important;
            padding: 10px 12px !important;
            min-height: 48px !important;
            background: var(--background-white) !important;
            transition: var(--transition) !important;
        }

        .select2-container--focus .select2-selection {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }

        .select2-selection__choice {
            background: linear-gradient(135deg, var(--primary-light), #e0f2fe) !important;
            border: none !important;
            border-radius: 16px !important;
            padding: 6px 12px !important;
            color: var(--primary-dark) !important;
            font-weight: 500 !important;
            font-size: 13px !important;
            margin-top: 2px !important;
            margin-bottom: 2px !important;
        }

        .select2-selection__choice__remove {
            color: var(--primary-color) !important;
            margin-right: 6px !important;
            font-weight: 600 !important;
        }

        .select2-dropdown {
            border: 1px solid var(--border-color) !important;
            border-radius: var(--border-radius) !important;
            box-shadow: var(--shadow-lg) !important;
            background: var(--background-white) !important;
        }

        .select2-results__option {
            padding: 10px 12px !important;
            font-size: 14px !important;
        }

        .select2-results__option--highlighted {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            color: white !important;
        }

        /* Radio Buttons */
        input[type="radio"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            vertical-align: middle;
            cursor: pointer;
        }

        input[type="radio"]:checked {
            accent-color: var(--primary-color);
        }

        label {
            display: inline-flex;
            align-items: center;
            margin-right: 20px;
            color: var(--text-primary);
            font-weight: 500;
            cursor: pointer;
            font-size: 15px;
        }

        label:hover {
            color: var(--primary-color);
        }

        /* Buttons - Clean & Professional */
        .btn {
            padding: 10px 24px;
            border-radius: var(--border-radius);
            font-weight: 500;
            font-size: 14px;
            transition: var(--transition);
            border: 1px solid transparent;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-success {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-success:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white;
        }

        .btn-outline-success {
            background: transparent;
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-success:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-light {
            background: var(--background-light);
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        .btn-light:hover {
            background: #e5e7eb;
            color: var(--text-primary);
            border-color: #d1d5db;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }

        .btn-danger:hover {
            background: #dc2626;
            border-color: #dc2626;
        }

        .btn:disabled,
        .btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        /* Error Messages */
        .text-danger.fs-8 {
            font-size: 13px;
            font-weight: 500;
            margin-top: 6px;
            display: block;
            padding: 8px 12px;
            background: #fee2e2;
            border-radius: var(--border-radius);
            border-left: 3px solid #ef4444;
        }

        /* Warning Alerts */
        .module-warning,
        .test-warning {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 12px 16px;
            border-radius: var(--border-radius);
            margin: 20px 0;
            font-size: 14px;
            color: #92400e;
        }

        /* Success Section */
        #success-div {
            text-align: center;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1px solid var(--primary-color);
            padding: 60px 40px !important;
        }

        #success-message {
            color: var(--text-primary);
            font-size: 16px;
            line-height: 1.6;
            margin: 24px auto;
            max-width: 600px;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: var(--border-radius-lg);
            border: none;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 20px 24px;
        }

        .modal-title {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 18px;
        }

        .modal-body {
            padding: 24px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 20px 24px;
        }

        /* Delete Section */
        #deleteContainer {
            background: #fee2e2;
            padding: 16px 20px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            border-left: 4px solid #ef4444;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
        }

        /* Spacing Utilities */
        .mb-3, .mb-4 {
            margin-bottom: 20px !important;
        }

        .mt-3, .mt-4 {
            margin-top: 20px !important;
        }

        .mx-auto {
            margin-left: auto !important;
            margin-right: auto !important;
        }

        /* Action Buttons Container */
        .d-flex.justify-content-between {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 16px;
            }
            
            #details,
            #modules,
            #test-details,
            #success-div {
                padding: 24px !important;
            }
            
            h4 {
                font-size: 20px;
                margin-bottom: 24px !important;
            }
            
            .btn {
                padding: 8px 20px;
                font-size: 13px;
            }
            
            .breadcrumb-nav {
                padding: 16px 0 24px 0;
            }
            
            .breadcrumb-brand {
                font-size: 24px;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 12px;
            }
            
            .d-flex.justify-content-between > * {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 12px;
            }
            
            #details,
            #modules,
            #test-details,
            #success-div {
                padding: 20px !important;
            }
            
            .form-control {
                padding: 10px 14px;
                font-size: 14px;
            }
            
            .select2-container .select2-selection {
                padding: 8px 10px !important;
                min-height: 44px !important;
            }
        }

        /* Smooth Transitions */
        #details,
        #modules,
        #test-details,
        #success-div {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Focus States */
        *:focus {
            outline: none;
        }

        *:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Keep existing selectors that must not change */
        .select2-selection--multiple,
        .select2-selection--single,
        .select2-container--open,
        .select2-results__option[aria-selected="true"],
        .select2-results__option--highlighted,
        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-selection--single,
        .icon-profile,
        .addVidModule,
        .disabled-select,
        .non-clickable,
        #cv-link,
        .border-md-right,
        #price-div,
        #moduleNumContainer,
        #testQuestionContainer,
        #testNumContainer,
        #deleteContainerSpan,
        #delete-span,
        #btn-loader-delete,
        #confirmDelete,
        #cancelDelete,
        #alert-account,
        #title-span,
        #description-span,
        #cover-span,
        #category-span,
        #keys-span,
        #type-span,
        #price-span,
        #modulesNum-span,
        #testQuestion-span,
        #testNum-span,
        #module-header,
        #module-div,
        #btn-loader-saveAndExitModule,
        #saveAndExitModule,
        #btn-loader-module,
        #nextSaveModule,
        #nextModule,
        #btn-loader-nextSaveModule,
        #test-div,
        #btn-loader-submitTestExit,
        #submitTestExit,
        #submit,
        #btn-loader-test,
        #success-message {
            /* Preserve original functionality */
        }

        /* Ensure original functional styles are preserved */
        .disabled-select {
            pointer-events: none;
            background-color: #f9fafb;
            color: #9ca3af;
            cursor: not-allowed;
            border-color: #e5e7eb;
        }

        .non-clickable {
            pointer-events: none;
            opacity: 0.6;
            cursor: not-allowed;
        }

        #cv-link:hover {
            text-decoration: underline !important;
        }

        @media (min-width:768px) {
            .border-md-right {
                border-right: 1px solid var(--border-color);
            }
        }

        /* Additional CSS to ensure the select2 dropdown appears above the modal */
        .select2-container--open {
            z-index: 1060 !important;
        }
    </style>
</head>

<body>

    <!-- Breadcrumbs Header -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-brand">TrainMastas</div>
        <div class="breadcrumb-links">
            <a href="dashboard.php">Dashboard</a>
            <span class="breadcrumb-separator">/</span>
            <span class="current">Create Course</span>
        </div>
    </nav>

    <div id="fullScreenLoader" style="display: none;">
        <div style="display: flex; gap: 8px;">
            <div class="spinner-circle-1"></div>
            <div class="spinner-circle-2"></div>
            <div class="spinner-circle-3"></div>
        </div>
        <div style="margin-top: 16px; color: var(--text-secondary); font-size: 14px;">Loading...</div>
    </div>
    
    <!-- Rejection Notification Modal -->
    <div class="modal fade" id="rejectionModal" tabindex="-1" role="dialog" aria-labelledby="rejectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Course Rejected</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="rejection-message" class="d-none text-danger fs-8"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mx-auto col-12" id="main">
        <!-- Delete section -->
        <div class="text-end d-none" id="deleteContainer">
            <span id="deleteContainerSpan">
                <a id="delete" class="btn btn-danger fw-semibold disabled" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Course</a>
            </span>
            <p class="text-danger fs-8 my-0 fw-semibold d-none p-0" id="delete-span">This course has students. You cannot delete it.</p>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this course? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger px-4 d-none my-0" type="button" disabled id="btn-loader-delete">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                        <button id="confirmDelete" class="btn btn-danger">Delete</button>
                        <button type="button" id="cancelDelete" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Details Section -->
        <div class="border mt-3" id="details">
            <h4 class="text-center mb-4">Course Details</h4>

            <div class="mt-3">
                <div id="alert-account" class="text-danger mx-auto text-center" style="font-size: 14px;"></div>
                
                <div class="mb-4">
                    <input type="text" id="title" value="" placeholder="Course title" class="form-control" />
                    <span class="text-danger fs-8 my-0 fw-semibold" id="title-span" style="display:none">Title is required.</span>
                </div>
                
                <div class="mb-4">
                    <textarea class="form-control" placeholder="Course Description" id="description"></textarea>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="description-span" style="display:none">Description is required.</span>
                </div>
                
                <div class="mb-4">
                    <input type="file" accept="image/*" class="form-control" id="cover" placeholder="Cover image">
                    <span class="text-danger fs-8 my-0 fw-semibold" id="cover-span" style="display:none">Cover is required.</span>
                    <img id="cover-image" class="d-none mt-3" src="" alt="Cover Image">
                </div>
                
                <div class="mb-4">
                    <select id="category" class="select2">
                        <option></option>
                        <option value="Technology & IT">Technology & IT</option>
                        <option value="Business & Management">Business & Management</option>
                        <option value="Health & Wellness">Health & Wellness</option>
                        <option value="Creative Art & Design">Creative Art & Design</option>
                        <option value="Personal Development">Personal Development</option>
                        <option value="Languages & Literature">Languages & Literature</option>
                        <option value="Science & Engineering">Science & Engineering</option>
                        <option value="Religion">Religion</option>
                        <option value="Others">Others</option>
                    </select>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="category-span" style="display:none">Category is required.</span>
                </div>
                
                <div class="mb-4">
                    <select id="keys" multiple class="select2">
                        <?php include "skills.php"; ?>
                    </select>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="keys-span" style="display:none">At least one skill is required.</span>
                </div>
                
                <div class="mb-4">
                    <select id="type" class="select2">
                        <option></option>
                        <option value="free">Free</option>
                        <option value="premium">Premium</option>
                    </select>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="type-span" style="display:none">Type is required.</span>
                </div>
                
                <div class="mb-4 d-none" id="price-div">
                    <input class="form-control" id="price" placeholder="Price in dollars ($)">
                    <span class="text-danger fs-8 my-0 fw-semibold" id="price-span" style="display:none">Price is required.</span>
                </div>
                
                <div class="mb-4" id="moduleNumContainer">
                    <select id="modulesNum" class="select2">
                        <option></option>
                        <option value="7">7 Modules</option>
                        <option value="8">8 Modules</option>
                        <option value="9">9 Modules</option>
                        <option value="10">10 Modules</option>
                    </select>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="modulesNum-span" style="display:none">The total number of modules is required.</span>
                </div>
                
                <div class="mb-4" id="testQuestionContainer">
                    <div class="fw-medium mb-2">Is there a test at the end of the course?</div>
                    <div>
                        <label class="me-4">
                            <input type="radio" name="testQuestion" class="selectType" value="yes"> Yes
                        </label>
                        <label>
                            <input type="radio" name="testQuestion" value="no"> No
                        </label>
                    </div>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="testQuestion-span" style="display:none">This field is required.</span>
                </div>
                
                <div class="mb-4" id="testNumContainer" style="display:none">
                    <select id="testNum" class="select2">
                        <option></option>
                        <option value="10">10 Questions</option>
                        <option value="20">20 Questions</option>
                        <option value="30">30 Questions</option>
                        <option value="40">40 Questions</option>
                    </select>
                    <span class="text-danger fs-8 my-0 fw-semibold" id="testNum-span" style="display:none">The total number of test questions is required.</span>
                </div>
                
                <!-- Submit button -->
                <div class="d-flex justify-content-between">
                    <div class="an_error_exist text-danger fs-7"></div>
                    <div class="text-end">
                        <a id="next" class="btn btn-success fw-semibold">Next →</a>
                        <button class="btn btn-success px-4 d-none my-0" type="button" disabled id="btn-loader-details">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modules Section -->
        <div class="border d-none mt-3" id="modules">
            <h4 class="text-center mb-4" id="module-header">Modules</h4>
            <div class="mt-3">
                <div class="module-warning text-danger d-none mb-3">
                    Please fill out all required fields.
                </div>
                <div id="module-div"></div>
                <div class="module-warning text-danger d-none mb-3">
                    Please fill out all required fields.
                </div>

                <!-- Submit button -->
                <div class="d-flex justify-content-between">
                    <a id="previous" class="btn btn-light fw-semibold btn-toDisabled">← Previous</a>
                    <div class="text-end">
                        <button class="btn btn-success px-5 d-none me-3" type="button" disabled id="btn-loader-saveAndExitModule">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                        <a id="saveAndExitModule" class="btn btn-outline-success fw-semibold me-3 d-none btn-toDisabled btn-reload">Save & Exit</a>
                        <button class="btn btn-success px-5 d-none" type="button" disabled id="btn-loader-module">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                        <a id="nextSaveModule" class="btn btn-success fw-semibold d-none btn-toDisabled">Next →</a>
                        <a id="nextModule" class="btn btn-success fw-semibold btn-toDisabled">Next Module →</a>
                        <button class="btn btn-success px-4 d-none" type="button" disabled id="btn-loader-nextSaveModule">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test Section -->
        <div class="border d-none mt-3" id="test-details">
            <h4 class="text-center mb-4">Test</h4>

            <div class="test-warning alert text-danger d-none my-0">
                Please fill out all required fields.
            </div>
            <div class="mt-3">
                <div id="test-div"></div>
                <div class="test-warning alert text-danger d-none my-0">
                    Please fill out all required fields.
                </div>
            </div>

            <!-- Submit button -->
            <div class="d-flex justify-content-between">
                <a id="test-previous" class="btn btn-light fw-semibold btn-toDisabled">← Previous</a>
                <div class="text-end">
                    <a id="submitTestExit" class="btn btn-outline-success fw-semibold d-none me-3 btn-reload btn-toDisabled">Save & Exit</a>
                    <button class="btn btn-success px-5 d-none me-3" type="button" disabled id="btn-loader-submitTestExit">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                    <a id="submit" class="btn btn-success fw-semibold d-none btn-toDisabled">Submit Course</a>
                    <button class="btn btn-success px-4 d-none" type="button" disabled id="btn-loader-test">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                    <a id="test-next" class="btn btn-success fw-semibold">Next Questions →</a>
                </div>
            </div>
        </div>

        <!-- Success Section -->
        <div class="border d-none mt-3" id="success-div">
            <div class="text-center">
                <div class="mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z" fill="#10b981"/>
                    </svg>
                </div>
                <h3 class="mb-3" style="color: #10b981;">Course Submitted Successfully!</h3>
                <div class="mt-3 mb-4" id="success-message">
                    Congratulations! Your course has been submitted for review. Our team will carefully evaluate your course within the next 2-3 business days. You will receive a notification once the review is complete.
                </div>
                <div class="my-3">
                    <a href="dashboard.php" class="btn btn-outline-success btn-reload">Return to Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <script src="js/select2.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for multiple selection
            var $select = $('#keys').select2({
                placeholder: "Select skills or enter custom ones",
                tags: true,
                maximumSelectionLength: 10,
                allowClear: true,
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
                closeOnSelect: false,
            });

            // Sort selected options alphabetically
            function sortSelectedOptions(selectElement) {
                var selectedOptions = selectElement.find('option:selected').sort(function(a, b) {
                    return a.text.localeCompare(b.text);
                });

                selectedOptions.each(function() {
                    var $option = $(this).detach();
                    selectElement.append($option);
                });

                selectElement.trigger('change');
            }

            $select.on('select2:select select2:unselect', function() {
                sortSelectedOptions($select);
            });

            window.$select = $select;

            // Initialize other select elements
            $("#modulesNum").select2({
                placeholder: "Select number of modules",
                width: '100%',
                minimumResultsForSearch: Infinity
            });

            $("#type").select2({
                placeholder: "Select course type",
                width: '100%',
                minimumResultsForSearch: Infinity
            });
            
            $("#category").select2({
                placeholder: "Select course category",
                width: '100%',
                minimumResultsForSearch: Infinity
            });
            
            $("#testNum").select2({
                placeholder: "Select number of test questions",
                width: '100%',
                minimumResultsForSearch: Infinity
            });

            // Toggle test question container
            $("input[name='testQuestion']").change(function() {
                if ($(this).val() === "yes") {
                    $("#testNumContainer").slideDown(200);
                } else {
                    $("#testNumContainer").slideUp(200);
                    $("#testNum").val("");
                }
            });

            // Toggle price field based on course type
            $("#type").on('change', function() {
                if ($(this).val() === 'premium') {
                    $("#price-div").slideDown(200);
                } else {
                    $("#price-div").slideUp(200);
                    $("#price").val("");
                }
            });

            // Add hover effect for video module add button
            $(".addVidModule").mouseenter(function() {
                $(this).find("path").css("fill", "#10b981");
            });

            $(".addVidModule").mouseleave(function() {
                $(this).find("path").css("fill", "#0F0F0F");
            });

            // Show/hide full screen loader
            $(document).on('ajaxStart', function() {
                $('#fullScreenLoader').show();
            }).on('ajaxStop', function() {
                $('#fullScreenLoader').hide();
            });
        });
    </script>
    <script src="js/addcourse.js"></script>
</body>
</html>