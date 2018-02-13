
// Closes the sidebar menu
$("#menu-close").click(function(e) {
    e.preventDefault();
    $("#sidebar-wrapper").toggleClass("active");
});

// Opens the sidebar menu
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#sidebar-wrapper").toggleClass("active");
});

// Scrolls to the selected menu item on the page
$(function() {
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 300);
                return false;
            }
        }
    });
});
</script>

<!-- searching -->
<script type="text/javascript">
$(document).ready(function(e){
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#","");
        var concept = $(this).text();
        $('.search-panel span#search_concept').text(concept);
        $('.input-group #search_param').val(param);
    });
    $('.year-select .dropdown-menu').find('a').click(function(e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#","");
        var concept = $(this).text();
        $('.year-select span#search_year').text(concept);
        $('.input-group #year_param').val(param);
    });
});
</script>

<!-- result tab -->
<script type="text/javascript">
    $('#resulttab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>

<!--
<script type="text/javascript">
$(document).ready(function(e){
    $('.year-select .dropdown-menu').find('a').click(function(e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#","");
        var concept = $(this).text();
        $('.year-select span#search_year').text(concept);
        $('.input-group #year_param').val(param);
    });
});
</script>
-->


<!-- otomatis sign out setelah satu menit -->
<script type="text/javascript">
var clickedDate = new Date();

<?php
if( isset($_SESSION['uid']) && $_SESSION['libroom'] == 'admin' ) {
echo "var idleTime = 10;";
} else {
echo "var idleTime = 10;";
}
?>

function timerIncrement() {

    var nowDate = new Date();
    var diffMs = (nowDate - clickedDate); 
    var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); //Convert ms to minutes

    if (diffMins >= idleTime) {
        //Redirect user to home page etc...
        window.location.assign("signout.php");
    }
}

$(document).ready(function () {

    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

    $(this).click(function (e) {
        clickedDate = new Date();
    });

    $('body').mousemove(function (e) {
        clickedDate = new Date();
    });

    $('body').keypress(function (e) {
        clickedDate = new Date();
    });

});
</script> 
