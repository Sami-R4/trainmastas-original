<link rel="stylesheet" href="css/header.css">
<script>
    if (window.location.pathname === '/trainmastas/admin/navbar.php') {
        var newURLT;
        newURLT = '/trainmastas/admin/login.php';
        history.pushState({}, '', newURLT);
        window.location.href = newURLT
    }
</script>
<header class="header d-flex justify-content-between" id="header">
    <div class="header_toggle"><svg id="header-toggle" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
            <path d="M4 6H20M4 12H20M4 18H20" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg></div>
    <div class="profile-loader" style="display: flex; align-items: center; justify-content: center; height: 100px;">
        <div class="spinner me-2" style="width: 130px; height: 20px; background-color: rgba(255, 255, 255, 0.9) !important;"></div>
        <div class="spinner rounded-circle mx-xl-3" role="status" style="background-color: rgba(255, 255, 255) !important; padding: 2.8vh;"></div>
    </div>

    <div class="text-white d-none nav-profile"><span class="userName"></span> <img id="userImage" src="../image/logo.png" alt="" style="width:40px; object-fit:cover"> </div>
</header>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav_logo"><img src="../image/logo.png" alt="Tainmastas Logo" style="width:25px; object-fit:cover"><span class="nav_logo-name">Trainmastas</span> </a>
            <div class="nav_list">
                <a href="index.php" class="nav_link " id="dashboard-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" width="24px" height="24px" viewBox="0 0 24 24">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                    </svg> <span class="nav_name">Dashboard</span>
                </a>
                <a href="students.php" class="nav_link" id="student-link">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" version="1.1" id="Capa_1" width="24px" height="24px" viewBox="0 0 420.609 420.609" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M350.035,275.014c-3.38-8.072-11.508-13.254-19.263-16.434l-25.851-11.898c-0.028-18.977-0.207-113.495-0.101-123.436    c0.153-15.465-1.69-29.278-5.754-41.227l32.188-11.63l0.074,29.738l-2.188-0.001c-1.521-0.134-2.865,0.96-3.04,2.478    l-2.833,24.559c-0.088,0.747,0.135,1.493,0.609,2.081c0.473,0.585,1.166,0.963,1.914,1.026l22.482-0.008    c0.756-0.085,1.445-0.446,1.912-1.034c0.48-0.586,0.693-1.344,0.609-2.094c-0.567-4.823-1.132-9.639-1.693-14.462l-1.174-10.095    c-0.179-1.505-1.526-2.601-3.044-2.466l-2.188,0.003l0.047-33.883l1.144-0.415l3.806-1.375c3.227-1.164,5.372-4.225,5.372-7.65    c0-3.427-2.146-6.488-5.372-7.653L213.071,0.488c-1.789-0.65-3.744-0.65-5.531,0L72.915,49.139    c-3.227,1.165-5.374,4.227-5.374,7.653s2.147,6.486,5.374,7.65l48.819,17.644c-4.263,12.257-6.203,26.431-6.044,42.259    l0.002,122.333L89.837,258.58c-7.757,3.18-15.383,8.016-19.263,16.434c0,0-56.998,145.596-26.081,145.596h331.62    C407.034,420.607,350.035,275.014,350.035,275.014z M262.119,262.51c0,0-43.391,14.377-51.748,64.875    c-0.022,0.133-0.106,0.133-0.129,0c-8.359-50.498-51.748-64.875-51.748-64.875l28.439-28.242    c-40.093-17.982-50.755-79.127-50.755-79.127c-2.266-8.839-2.539-14.885-2.539-14.885c20.073-1.367,90.128-7.401,94.917-30.111    c6.603,12.2,41.561,42.857,55.705,45.185c0,0-13.729,60.463-51.229,78.895L262.119,262.51z" />
                            </g>
                        </g>
                    </svg><span class="nav_name">Students</span>
                </a>
                <a href="teachers.php" class="nav_link" id="teacher-link">

                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" height="24px" width="24px" version="1.1" id="Capa_1" viewBox="0 0 489.38 489.38" xml:space="preserve">
                        <g id="XMLID_129_">
                            <path id="XMLID_134_" d="M473.725,5.656H213.576c-8.655,0-15.655,7.022-15.655,15.664v110.484l11.319-13.234   c5.375-6.292,12.461-10.172,19.992-11.793V36.978h228.836v204.531H229.233v-34.238l-7.05,8.244   c-6.161,7.189-14.858,11.65-24.262,12.529v29.124c0,8.642,7,15.655,15.655,15.655h84.489L255.141,467.7   c-1.923,8.739,3.6,17.382,12.346,19.31c8.667,1.904,17.382-3.601,19.287-12.331l44.457-201.855h25.844l44.457,201.855   c1.666,7.557,8.369,12.714,15.803,12.705c1.154,0,2.334-0.117,3.502-0.374c8.746-1.928,14.268-10.57,12.328-19.31l-42.92-194.877   h83.481c8.647,0,15.655-7.013,15.655-15.655V21.32C489.38,12.678,482.372,5.656,473.725,5.656z" />
                            <path id="XMLID_132_" d="M349.368,97.116c-1.234-3.11-4.732-4.637-7.84-3.406l-92.234,32.555   c-8.465-6.554-20.678-5.383-27.737,2.827l-29.267,34.178l-25.951-22.245c0.171,1.837,0.56,3.622,0.56,5.507v48.291l14.438,12.371   c8.568,7.338,21.385,6.204,28.549-2.198l34.842-40.743l28.1-16.439l73.951-43.267C349.336,103.073,350.469,99.923,349.368,97.116z" />
                            <path id="XMLID_131_" d="M109.928,105.776H92.547c-13.308,0-25.01,6.468-32.448,16.327l-53.352,49.12   c-8.313,7.405-9.067,20.232-1.581,28.595l43.528,48.585c7.421,8.309,20.267,9.044,28.579,1.576   c8.334-7.469,9.038-20.262,1.57-28.586l-30.003-33.504l42.616-38.134l-24.82,33.721l24.279,27.107   c13.416,14.992,12.151,38.027-2.834,51.453c-10.231,9.172-24.193,11.324-36.297,7.094c0,0,0.188,93.659,0.188,193.962   c0,13.416,10.874,24.291,24.291,24.291c13.403,0,24.291-10.875,24.291-24.291c0-100.272,0-43.051,0-144.771h16.203   c0,101.646,0,44.468,0,144.771c0,7.004-1.953,13.49-5.067,19.231c4.076,3.135,9.148,5.06,14.676,5.06   c13.424,0,24.298-10.875,24.298-24.291c0-100.272,0.031-58.237,0.031-316.561C150.697,124.022,132.45,105.776,109.928,105.776z" />
                            <path id="XMLID_130_" d="M79.592,91.198c6.495,3.376,13.787,5.471,21.62,5.471c7.853,0,15.145-2.095,21.659-5.477   c15.204-7.877,25.684-23.559,25.684-41.862c0-26.146-21.196-47.335-47.344-47.335c-26.144,0-47.335,21.189-47.335,47.335   C53.877,67.643,64.368,83.331,79.592,91.198z" />
                        </g>
                    </svg> <span class="nav_name">Teachers</span>
                </a>
                <a href="courses.php" class="nav_link" id="course-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23px" height="24px" viewBox="0 0 18 18">
                        <path fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M1 2h16v11H1z" />
                        <path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M4 5.5v5s3-1 5 0v-5s-2-2-5 0zM9 5.5v5s3-1 5 0v-5s-2-2-5 0z" />
                        <path fill="#fff" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="M8.5 14l-3 3h7l-3-3z" />
                    </svg> <span class="nav_name">Courses</span>
                </a>
                <a href="transactions.php" class="nav_link" id="transaction-link">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="_x32_" width="24px" height="24px" viewBox="0 0 512 512" xml:space="preserve">
                        <style type="text/css">
                            .st0 {
                                fill:
                                    #fff;
                            }
                        </style>
                        <g>
                            <path class="st0" d="M335.859,68.875c0,0,4.656-12.469,29.734-28.297c24.063-15.172,5.594-36.141-29.734-28.422   C311.469,17.469,319.75,0,285.547,0s-25.922,17.469-50.313,12.156c-35.328-7.719-53.797,13.25-29.734,28.422   c25.078,15.828,29.734,28.297,29.734,28.297H335.859z" />
                            <path class="st0" d="M432.063,224.453c0-7.141-4.234-13.281-10.328-16.109c6.094-2.844,10.344-8.969,10.344-16.109   c0-7.156-4.25-13.297-10.344-16.125c6.078-2.828,10.328-8.953,10.328-16.125c0-9.828-7.969-17.797-17.813-17.797h-59.375   c-9.828,0-17.813,7.969-17.813,17.797c0,7.172,4.25,13.297,10.344,16.125c-6.094,2.828-10.344,8.969-10.344,16.125   c0,7.141,4.25,13.266,10.344,16.109c-6.094,2.828-10.344,8.969-10.344,16.109c0,7.156,4.25,13.297,10.344,16.109   c-6.094,2.844-10.344,8.969-10.344,16.125c0,9.844,7.984,17.813,17.813,17.813h59.375c9.828,0,17.813-7.969,17.813-17.813   c0-7.156-4.25-13.281-10.328-16.109C427.813,237.75,432.063,231.609,432.063,224.453z" />
                            <path class="st0" d="M346.203,89.641c-20,0-113.25,0-113.25,0c-48.969,0-62.656,38.328-100.578,38.328v121.641l16.578-0.766   c126.688-9.813,115.625-119.188,115.625-119.188s31.063,0,71.094,0C375.688,129.656,377.797,89.641,346.203,89.641z" />
                            <rect x="64.703" y="113.75" class="st0" width="50.563" height="164.281" />
                            <path class="st0" d="M309.906,368.781c3.984-2.813,5.984-7.266,5.984-13.391c0-6.344-1.797-10.859-5.391-13.563   c-3.594-2.688-9.219-4.047-16.859-4.047H277.75V373h14.641C300.078,373,305.922,371.594,309.906,368.781z" />
                            <path class="st0" d="M314.938,393.266c-1.797-1.484-4.094-2.641-6.906-3.422s-6.203-1.172-10.188-1.172H277.75v35.719h20.172   c4.219,0,7.734-0.516,10.578-1.516c2.828-1.016,5.109-2.359,6.813-4.047c1.719-1.688,2.953-3.641,3.703-5.891   c0.766-2.25,1.141-4.641,1.141-7.172c0-2.641-0.422-5.016-1.266-7.109C318.063,396.547,316.734,394.75,314.938,393.266z" />
                            <path class="st0" d="M432.891,288.344c-5.469,3.219-11.828,5.125-18.641,5.125h-59.375c-20.266,0-36.766-16.5-36.766-36.781   c0-5.672,1.328-11.172,3.766-16.109c-2.438-4.938-3.766-10.438-3.766-16.125c0-5.672,1.328-11.172,3.766-16.109   c-2.438-4.938-3.766-10.438-3.766-16.109c0-5.688,1.328-11.188,3.766-16.125c-2.422-4.938-3.766-10.438-3.766-16.125   c0-3.969,0.641-7.781,1.813-11.359h-36.75c-1.703,18.797-7.984,47.141-28.594,71.813c-22.453,26.844-55.891,42.531-99.313,46.813   c-14.125,27.375-24.203,56.891-24.203,86.625c0,87.328,70.797,158.125,158.109,158.125c87.328,0,158.125-70.797,158.125-158.125   C447.297,331.625,441.625,309.531,432.891,288.344z M342.453,420.594c-1.969,4.391-4.828,8.156-8.594,11.344   c-3.75,3.172-8.391,5.656-13.906,7.453c-5.484,1.797-11.781,2.688-18.859,2.688h-2.484v12.328h-19.25v-12.328h-24.266h-7.953   v-9.891c0-2.922-0.188-4.672,2.609-5.281c0.25-0.047,0.609-0.094,1.063-0.188c0.469-0.094,1.297-0.234,2.516-0.453   c1.203-0.219-0.344-0.516,1.766-0.891v-88.422c-2.109-0.359-0.563-0.656-1.766-0.875c-1.219-0.234-2.047-0.359-2.516-0.453   c-0.453-0.078-0.813-0.156-1.063-0.188c-2.797-0.594-2.609-2.359-2.609-5.281v-9.891h7.953h24.266v-13.172h19.25v13.281   c5.875,0.25,11.031,0.969,15.453,2.156c5.656,1.516,10.297,3.688,13.906,6.5c3.625,2.797,6.281,6.188,7.953,10.188   c1.703,3.984,2.531,8.469,2.531,13.469c0,2.875-0.406,5.609-1.25,8.219c-0.859,2.609-2.156,5.063-3.922,7.344   c-1.781,2.266-4.016,4.328-6.75,6.188c-2.719,1.844-6.234,4.719-6.234,4.719c16.734,3.75,25.109,12.797,25.109,27.125   C345.406,411.438,344.422,416.219,342.453,420.594z" />
                        </g>
                    </svg><span class="nav_name">Transactions</span>
                </a>
                <a href="admins.php" class="nav_link" id="admin-link">
                    <svg xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" width="24px" height="24px" viewBox="0 0 30 30" version="1.1" id="svg822" inkscape:version="0.92.4 (f8dce91, 2019-08-02)" sodipodi:docname="admin.svg">
                        <defs id="defs816" />
                        <g inkscape:label="Layer 1" inkscape:groupmode="layer" id="layer1" transform="translate(0,-289.0625)">
                            <path style="fill:#fff;fill-opacity:1;stroke:none;stroke-width:0.5;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" d="M 11.916016 6.28125 A 4 4 0 0 0 7.9160156 10.28125 A 4 4 0 0 0 11.916016 14.28125 A 4 4 0 0 0 15.916016 10.28125 A 4 4 0 0 0 11.916016 6.28125 z M 8.4628906 15.115234 C 5.2252742 16.489124 3.0845987 19.623082 2.9824219 23.138672 C 5.1722039 25.642012 8.3828992 27.230469 11.972656 27.230469 C 13.939081 27.230469 15.782366 26.738864 17.416016 25.896484 C 16.972529 25.303803 16.599939 24.654546 16.285156 23.957031 C 15.297133 21.767701 14.789426 19.133132 14.728516 16.570312 L 14.722656 16.318359 L 12.001953 20.574219 L 8.4628906 15.115234 z M 22.037109 15.308594 C 20.292352 15.308594 17.177734 17.251953 17.177734 17.251953 C 17.287817 21.883593 19.126557 27.009156 22.037109 26.972656 C 22.040309 26.972626 22.043675 26.972696 22.046875 26.972656 C 22.864919 26.962256 23.588979 26.535536 24.179688 25.916016 C 24.770398 25.296496 25.255835 24.472265 25.654297 23.546875 C 26.45122 21.696085 26.896484 19.437792 26.896484 17.576172 L 26.896484 17.308594 L 26.671875 17.166016 C 26.671875 17.166016 25.951124 16.70805 25.029297 16.25 C 24.107471 15.79195 23.009546 15.308594 22.041016 15.308594 L 22.037109 15.308594 z M 22.037109 16.279297 L 22.041016 16.279297 C 22.641611 16.279297 23.726421 16.688174 24.597656 17.121094 C 25.326193 17.483104 25.720925 17.73488 25.896484 17.84375 C 25.857384 19.50574 25.45849 21.539389 24.759766 23.162109 C 24.392753 24.014469 23.950753 24.748774 23.476562 25.246094 C 23.003258 25.742454 22.526857 25.9928 22.037109 26 L 22.037109 16.279297 z " transform="translate(0,289.0625)" id="path852" />
                        </g>
                    </svg> <span class="nav_name">Admin</span>
                </a>
                <a href="#" class="nav_link" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" width="24px" height="24px" viewBox="0 0 512 512">
                        <g id="Password">
                            <path d="M391,233.9478H121a45.1323,45.1323,0,0,0-45,45v162a45.1323,45.1323,0,0,0,45,45H391a45.1323,45.1323,0,0,0,45-45v-162A45.1323,45.1323,0,0,0,391,233.9478ZM184.123,369.3794a9.8954,9.8954,0,1,1-9.8964,17.1387l-16.33-9.4287v18.8593a9.8965,9.8965,0,0,1-19.793,0V377.0894l-16.33,9.4287a9.8954,9.8954,0,0,1-9.8964-17.1387l16.3344-9.4307-16.3344-9.4306a9.8954,9.8954,0,0,1,9.8964-17.1387l16.33,9.4282V323.9487a9.8965,9.8965,0,0,1,19.793,0v18.8589l16.33-9.4282a9.8954,9.8954,0,0,1,9.8964,17.1387l-16.3344,9.4306Zm108,0a9.8954,9.8954,0,1,1-9.8964,17.1387l-16.33-9.4287v18.8593a9.8965,9.8965,0,0,1-19.793,0V377.0894l-16.33,9.4287a9.8954,9.8954,0,0,1-9.8964-17.1387l16.3344-9.4307-16.3344-9.4306a9.8954,9.8954,0,0,1,9.8964-17.1387l16.33,9.4282V323.9487a9.8965,9.8965,0,0,1,19.793,0v18.8589l16.33-9.4282a9.8954,9.8954,0,0,1,9.8964,17.1387l-16.3344,9.4306Zm108,0a9.8954,9.8954,0,1,1-9.8964,17.1387l-16.33-9.4287v18.8593a9.8965,9.8965,0,0,1-19.793,0V377.0894l-16.33,9.4287a9.8954,9.8954,0,0,1-9.8964-17.1387l16.3344-9.4307-16.3344-9.4306a9.8954,9.8954,0,0,1,9.8964-17.1387l16.33,9.4282V323.9487a9.8965,9.8965,0,0,1,19.793,0v18.8589l16.33-9.4282a9.8954,9.8954,0,0,1,9.8964,17.1387l-16.3344,9.4306Z" />
                            <path d="M157.8965,143.9487a98.1035,98.1035,0,1,1,196.207,0V214.147h19.793V143.9487a117.8965,117.8965,0,0,0-235.793,0V214.147h19.793Z" />
                        </g>
                    </svg><span class="nav_name">Change Password</span>
                </a>
            </div>
            <a href="#" class="nav_link log-out">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" width="24px" height="24px" viewBox="0 0 24 24">
                    <path d="M7.707,8.707,5.414,11H17a1,1,0,0,1,0,2H5.414l2.293,2.293a1,1,0,1,1-1.414,1.414l-4-4a1,1,0,0,1,0-1.414l4-4A1,1,0,1,1,7.707,8.707ZM21,1H13a1,1,0,0,0,0,2h7V21H13a1,1,0,0,0,0,2h8a1,1,0,0,0,1-1V2A1,1,0,0,0,21,1Z" />
                </svg><span class="nav_name">Logout</span>
            </a>
        </div>
    </nav>
</div>
<!--------------------------------------------------------------------------------------------
                                           End Of Navbar
    ---------------------------------------------------------------------------------------------->
<script>
    document.addEventListener("DOMContentLoaded", function(event) {

        const showNavbar = (toggleId, navId, bodyId, headerId) => {
            const toggle = document.getElementById(toggleId),
                nav = document.getElementById(navId),
                bodypd = document.getElementById(bodyId),
                headerpd = document.getElementById(headerId)

            if (toggle && nav && bodypd && headerpd) {
                toggle.addEventListener('click', () => {
                    nav.classList.toggle('show-nav')
                    nav.classList.toggle('show')
                    toggle.classList.toggle('bx-x')
                    bodypd.classList.toggle('body-pd')
                    headerpd.classList.toggle('body-pd')
                })
            }
        }

        showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header')

        const linkColor = document.querySelectorAll('.nav_link')

        function colorLink() {
            if (linkColor) {
                linkColor.forEach(l => l.classList.remove('active'))
                this.classList.add('active')
            }
        }
        linkColor.forEach(l => l.addEventListener('click', colorLink))
    });
</script>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

    :root {
        --header-height: 3rem;
        --nav-width: 68px;
        --first-color-light: rgb(255, 255, 255);
        --white-color: #F7F6FB;
        --body-font: 'Nunito', sans-serif;
        --normal-font-size: 1rem;
        --z-fixed: 100
    }

    *,
    ::before,
    ::after {
        box-sizing: border-box
    }

    body {
        position: relative;
        margin: var(--header-height) 0 0 0;
        padding: 0 1rem;
        font-family: var(--body-font);
        font-size: var(--normal-font-size);
        transition: .5s
    }

    a {
        text-decoration: none
    }

    .header {
        width: 100%;
        height: var(--header-height);
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1rem;
        background-color: #198754;
        z-index: var(--z-fixed);
        transition: .5s
    }

    .header_toggle {
        color: #000000;
        font-size: 1.5rem;
        cursor: pointer
    }

    .header_img {
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        border-radius: 50%;
        overflow: hidden
    }

    .header_img img {
        width: 40px
    }

    .l-navbar {
        position: fixed;
        left: -30%;
        width: var(--nav-width);
        height: 100vh;
        background-color: #198754;
        padding: .5rem 1rem 0 0;
        transition: .5s;
        z-index: var(--z-fixed)
    }

    .nav {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden
    }

    .nav_logo,
    .nav_link {
        display: grid;
        grid-template-columns: max-content max-content;
        align-items: center;
        column-gap: 1rem;
        padding: .5rem 0 .5rem 1.5rem
    }

    .nav_logo {
        margin-bottom: 2rem
    }

    .nav_logo-icon {
        font-size: 1.25rem;
        color: var(--white-color)
    }

    .nav_logo-name {
        color: var(--white-color);
        font-weight: 700
    }

    .nav_link {
        position: relative;
        color: var(--first-color-light);
        margin-bottom: 1rem;
        transition: .3s
    }

    .nav_link:hover {
        color: var(--white-color)
    }

    .nav_icon {
        font-size: 1.25rem
    }

    .show-nav {
        left: 0
    }

    .body-pd {
        padding-left: calc(var(--nav-width) + 1rem)
    }

    .active {
        color: var(--white-color)
    }

    .active::before {
        content: '';
        position: absolute;
        left: 0;
        width: 2px;
        height: 32px;
        background-color: var(--white-color)
    }

    .height-100 {
        height: 100vh
    }

    @media screen and (min-width: 768px) {
        body {
            margin: calc(var(--header-height) + 1rem) 0 0 0;
            padding-left: calc(var(--nav-width) + 2rem)
        }

        .header {
            height: calc(var(--header-height) + 1rem)
        }

        .header_img {
            width: 40px;
            height: 40px
        }

        .header_img img {
            width: 45px
        }

        .l-navbar {
            left: 0;
            padding: 1rem 1rem 0 0
        }

        .show-nav {
            width: calc(var(--nav-width) + 156px)
        }

        .body-pd {
            padding-left: calc(var(--nav-width) + 188px)
        }
    }

    .dropdown-toggle::after {
        margin-left: 0
    }
</style>
<div class="modal fade " id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Password Div -->
                <div id="passwordDiv-container">
                    <div id="alertPassword" class="text-danger fs-7 mt-0 mb-1"></div>
                    <div class="mb-0 position-relative">
                        <input type="password" placeholder="Enter New Password" class="form-control" id="newPassword">
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
                        <input type="password" placeholder="Confirm Password" class="form-control" id="confirmPassword">
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
                    <button type="button" class="btn btn-success rounded-0 mt-3" id="submitPasswordBtn">Submit</button>
                </div>

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
                    <button type="button" class="btn btn-success rounded-0" id="verifyCodeBtn">Verify</button>
                    <div class="text-center mt-2"><button class="btn btn-light rounded-0" id="attemptNumBtn">Resend</button></div>
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


    .border-danger {
        border-color: #dc3545;
        /* Bootstrap's border-danger color */
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        /* Red shadow */
        outline: none;
        /* Remove the default outline */
    }
</style>
<script>
    $(document).ready(function() {
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

        $.ajax({
            url: "app/index_process.php",
            method: "POST",
            data: {
                purpose: "userDetails"
            },
            dataType: "json",
            success: function(response) {
                setTimeout(function() {
                    if (response.state === "success") {
                        $(".userName").text(capitalizeFirstLetter(response.userDetails.Name));
                        if (response.userDetails.Image == "") {
                            $(".userImage").attr("src", ("image/default-profile.png"));
                        } else {
                            $(".userImage").attr("src", ("profile/" + response.userDetails.Image));
                        }
                        $(".userImage").attr("alt", capitalizeFirstLetter(response.userDetails.Name));
                        $(".profile-loader").addClass("d-none");
                        $(".userImage").removeClass("d-none");
                        $(".userImage").removeClass("d-none");
                        $(".nav-profile").removeClass("d-none");
                        $(".userName").removeClass("d-none");
                    }
                }, 1000)
            }
        })
    })
</script>
<script src="js/changePassword.js"></script>
<script src="js/logout.js"></script>