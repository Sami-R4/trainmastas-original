$(document).ready(function () {
    $("#search_box").keypress(function (e) {
        if (e.which == 13) {
            // 13 is the keycode for Enter key
            e.preventDefault();
            if (!window.location.pathname.includes("/dreamp/courses.php")) {
                localStorage.setItem('search',$(this).val());
                window.location.href = "courses.php";
            }

        }
    });
});