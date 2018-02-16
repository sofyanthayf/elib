<!-- *********************************************** KONTAK ********************************************** -->

<section id="contact">
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <h4 class="kharismalibrary">KHARISMA E-Library</h4>
                <p>Perpustakaan STMIK KHARISMA Makassar<br>
                   Kampus STMIK KHARISMA Makassar  Jl. Baji Ateka 20 (lt.2)<br>
                   Makassar - INDONESIA 90134</p>
                <ul class="list-unstyled">
                    <li><i class="fa fa-phone fa-fw"></i> (0411) 871555 ext.208</li>
                    </li>
                </ul>
                <hr class="small">
                <p class="text-muted">Copyright &copy; STMIK KHARISMA Makassar 2016</p>
            </div>
        </div>
    </div>
</footer>

</section>




<!-- *********************************************** SCRIPTS ********************************************** -->

<!-- jQuery -->
<script src="/assets/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/assets/js/bootstrap.min.js"></script>

<!-- Custom Theme JavaScript -->
<script>
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
if( isset( $_COOKIE['catalog'] ) && $_COOKIE['catalog'] == '1' ) {
echo "var idleTime = 1;";
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

<!-- pop-up modal -->
<script type="text/javascript">
    $('#detailPustaka').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var tipe = button.data('tipe')
        var judul = button.data('judul')
        var auth = button.data('auth')
        var klas = button.data('klas')
        var adklas = button.data('addklas')
        var publ = button.data('publ')
        var tahun = button.data('tahun')
        var isbn = button.data('isbn')

// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

        // output:
        var modal = $(this)
        var atipe = { B:"Buku", E:"E-Book", J:"Jurnal", C:"Prosiding", S:"Skripsi", L:"Laporan",}
        var aauth = auth.split(';');
        var sauth = ''
        $.each( aauth, function( index, value ){
            sauth += '<strong>'+value+'</strong><br>'
        });

        modal.find('.labeltipe').text(atipe[tipe]+':')
        modal.find('.judul').text(judul)
        modal.find('.tahun').text('Tahun: '+tahun)
        modal.find('.authors').html(sauth)
        modal.find('.publisher').html('Publisher: '+publ)
        modal.find('.nisbn').text(isbn)

        modal.find('.kode').text(tipe+id)
        modal.find('.klas').text(klas)
        modal.find('.adklas').text(adklas)
    })
</script>

</body>

</html>
