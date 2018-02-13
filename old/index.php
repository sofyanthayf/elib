<?php
error_reporting(E_ALL);

if( isset( $_GET['i'] ) ){
    session_id( $_GET['i'] );
}
session_start();

include "class.MySQLDB.php";
include "class.buku.php";
include "class.skripsi.php";
include "class.paper.php";
include "class.jurnal.php";
include "inc.function.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KHARISMA Library</title>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">
    <link href="mystyle.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>


    <!-- Navigation -->
    <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
    <nav id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
            <li class="sidebar-brand">
                <a href='#top' onclick = $("#menu-close").click(); >KHARISMA E-Library</a>
            </li>
            <li>
                <a href="#top" onclick = $("#menu-close").click(); >
                <span class="fa fa-home"></span> Home</a>
            </li>

            <?php
                if( !isset( $_SESSION['uid']) ){
            ?>
                    <li>
                        <a href="#login" onclick = $("#menu-close").click(); >
                        <span class="fa fa-user"></span> Sign-in</a>
                    </li>
            <?php
                } else {
            ?>
                    <li>
                        <a href="signout.php" onclick = $("#menu-close").click(); >
                        <span class="fa fa-sign-out"></span> Sign-out</a>
                    </li>
            <?php
                } 
            ?>

            <li>
                <a href="#pencarian" onclick = $("#menu-close").click(); >
                <span class="fa fa-search"></span> Pencarian</a>
            </li>

            <?php

                if( isset($_SESSION['uid']) && $_SESSION['libroom'] == 'admin' ) {

            ?>  
                    <li>
                        <a href="#services" onclick = $("#menu-close").click(); >
                        <span class="fa fa-check-square-o"></span> Administrasi</a>
                    </li>
            <?php
                }  
            ?>

            <li>
                <a href="#statistik" onclick = $("#menu-close").click(); >
                <span class="fa fa-line-chart"></span> Statistik</a>
            </li>
            <li>
                <a href="#about" onclick = $("#menu-close").click(); >
                <span class="fa fa-book"></span> Tentang KHARISMA E-Library</a>
            </li>
            <li>
                <a href="#contact" onclick = $("#menu-close").click(); >
                <span class="fa fa-envelope"></span> Kontak</a>
            </li>
        </ul>
    </nav>

    <!-- Header -->
    <header id="top" class="header">

<?php
    if( isset( $_SESSION['uid']) ){
        echo "<h3 class='loggedin'>
              <a href='signout.php' title='Klik nama Anda untuk sign-out'>".
              $_SESSION['nama']."</a></h3>";

        if( !isset($_SESSION['saved']) ){
            loggedIn();
        }
    }
?>

        <div class="text-vertical-center">
            <h1 class="kharismalibrary">KHARISMA E-Library</h1>
            <h3>Layanan Perpustakaan Elektronik STMIK KHARISMA Makassar</h3>
            <br>

<?php
    include "inc.search.php";

    if( !isset( $_SESSION['uid']) ){
?>

    <div class="row">
        <div class="col-lg-12 text-center">
            </br>
            <h4>Hasil pencarian akan lebih lengkap jika Anda <a href="#login">login terlebih dahulu</a>.</h4>
            <h5>Dengan Sign-in terlebih dahulu, anda telah membantu meningkatkan pelayanan 
                <span class="kharismalibrary">KHARISMA E-Library</span>.</h5>
        </div>
    </div>

<?php
    }
?>

</div>

        </div>
    </header>

    <!-- *********************************************** LOGIN ********************************************** -->
    <?php
    if( !isset($_SESSION['uid']) ) {
    ?>
    <section id="login">
        <br>
        <div class="container fullheight">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3>Gunakan akun SISKA Anda untuk Sign-in.</h3>
                </div>
            </div>
            <br>
            <div class="row">

            <form class="form-signin" action="http://siskanew.local/otentikasilibrary.php" method="POST">

            <?php

            if(isset( $_GET['code'] ) ) {
                switch( $_GET['code'] ) {
                    case 1: 
                            $psn = "Maaf, nomor ID keliru atau tidak terdaftar";
                            break;
                    case 2:
                            $psn = "Maaf, Password keliru"; 
                            break;
                }

                echo "<div class='alert alert-danger' role='alert'>".$psn."</div>";
            }
            
            ?>

                <label for="inputid" class="sr-only">NIM / NIDN / NIK</label>
                <input type="text" id="inputid" name="user" class="form-control" placeholder="NIM / NIDN / NIK" required>
                <br>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

            </form>


        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="lead">Dengan Sign-in terlebih dahulu, anda telah membantu meningkatkan pelayanan 
                        <span class="kharismalibrary">KHARISMA E-Library</span>.</p>
                </div>
            </div>

        </div>
    </section>
<?php
    }
?>

    <!-- *********************************************** PENCARIAN ********************************************** -->
    <section id="pencarian">
        <div class="container fullheight">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Pencarian Pustaka</h2>
                </div>
            </div>

            <?php
                /* pencarian standar */
                include "inc.search.php";
            ?>

            <hr>
            <div class="col-xs-12 col-sm-8">
            <?php

                if( isset( $_POST['keyword'] ) && !empty( $_POST['keyword'] ) ) {
                    echo "<h4><strong>Hasil Pencarian </strong><i>'".$_POST['keyword']."'</i></h4>";
                    include "inc.searching.php";

                } elseif ( isset( $_POST['detail'] ) && $_POST['detail']=='true'  ) {
                    echo "<h4><strong>Hasil Pencarian </strong></h4>";
                    include "inc.detailsearching.php";

                }

            ?>
            </div>

            <div class="col-xs-6 col-sm-4 sidebar-offcanvas">

            <?php
                /* pencarian detail */
                if( isset( $_SESSION['uid'] ) ) {
                    include "inc.detailsearch.php";
                }

            ?>


            </div>

        </div>


<!-- pop up -->

        <div class="modal fade" id="detailPustaka" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="detailPustakaLabel">
                    <span class="fa fa-book"></span> Detail Pustaka </h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="labeltipe"></div>
                            <h4 class="judul"></h4>
                            <div class="authors"></div>
                            <div class="publisher"></div>
                            <div class="tahun"></div>
                            <div class="nisbn"></div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="kode"></div>
                            <h4><div class="klas"></div><div class="adklas"></div></h4>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                
    <?php
        if( isset($_SESSION['uid']) ) {
    ?>
                    <button type="button" class="btn btn-default" title="Maaf, belum berfungsi">
                    <span class="fa fa-envelope"></span> Kirim ke E-Mail </button>

    <?php
            if( $_SESSION['libroom'] == 'admin' ) {
    ?>
                    <button type="button" class="btn btn-default" title="Maaf, belum berfungsi">
                    <span class="fa fa-edit"></span> Edit </button>

    <?php
            }

        }
    ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                    <span class="fa fa-close"></span> Tutup </button>
              
                </div>

            </div>
          </div>
        </div>


<!-- pop up -->




    </section>

<?php

if( isset($_SESSION['uid']) && $_SESSION['libroom'] == 'admin' ) {

?>
    <!-- *********************************************** PELAYANAN ********************************************** -->
    <section id="services" class="services bg-primary">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-10 col-lg-offset-1">
                    <h2>Administrasi Perpustakaan</h2>
                    <hr class="small">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-book fa-stack-1x text-primary"></i>
                            </span>
                                <h4>
                                    <strong>Koleksi</strong>
                                </h4>
                                <p>Pemeliharaan Data Koleksi</p>
                                <a href="#" class="btn btn-light">Learn More</a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-exchange fa-stack-1x text-primary"></i>
                            </span>
                                <h4>
                                    <strong>Sirkulasi</strong>
                                </h4>
                                <p>Peminjaman dan Pengembalian</p>
                                <a href="#" class="btn btn-light">Learn More</a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-users fa-stack-1x text-primary"></i>
                            </span>
                                <h4>
                                    <strong>Anggota</strong>
                                </h4>
                                <p>Data dan Infromasi Anggota</p>
                                <a href="#" class="btn btn-light">Learn More</a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-envelope fa-stack-1x text-primary"></i>
                            </span>
                                <h4>
                                    <strong>Pesan</strong>
                                </h4>
                                <p>Komunikasi Pesan</p>
                                <a href="#" class="btn btn-light">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.col-lg-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

<?php
}
?>
    <!-- *********************************************** STATISTIK ********************************************** -->

    <section id="statistik" class="portfolio">

    </section>

    <!-- ************************************************* ABOUT ************************************************ -->

    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">

        <h2><span class="kharismalibrary">KHARISMA E-Library</span></h2>

        <ul>
        <li><span class="kharismalibrary">KHARISMA E-Library</span> adalah layanan katalog on-line untuk membantu
            pencarian sumber pustaka dalam koleksi perpustakaan STMIK KHARISMA Makassar</li>
        <li><span class="kharismalibrary">KHARISMA E-Library</span> dapat diakses secara on-line melalui jaringan internet</li>
        <li>Koleksi perpustakaan STMIK KHARISMA Makassar yang dapat dicari melalui <span class="kharismalibrary">
            KHARISMA E-Library</span> meliputi buku cetak, paper di dalam jurnal/prosiding edisi cetak, dan buku
            elektronik (e-book)</li>
        <li>Pencarian koleksi yang meliputi paper dalam jurnal/prosiding dan e-book hanya tersedia bagi civitas 
            STMIK KHARISMA atau anggota yang terdaftar dengan harus melakukan <strong>Sign-in</strong>. Jika tidak 
            melakukan Sign-in, hasil pencarian hanya terbatas pada koleksi buku cetak</li> 
        <li>Konten buku on-line dapat langsung diakses melalui <span class="kharismalibrary">KHARISMA E-Library</span>
            tetapi terbatas dalam lingkungan jaringan intranet Kampus STMIK KHARISMA </li>
        <li>Untuk melakukan Sign-in pada <span class="kharismalibrary">KHARISMA E-Library</span>, civitas akademika 
            STMIK KHARISMA cukup menggunakan account SISKA (NIM/NIDN/NIK dan password yang digunakan pada SISKA). Silahkan menghubungi pengelola Program Studi (bagi mahasiswa) dan administrator SISKA (bagi dosen dan staf) jika account SISKA Anda bermasalah atau belum terdaftar</li>
        <li>Dengan melakukan Sign-in bagi civitas akademika STMIK KHARISMA saat memanfaatkan <span class="kharismalibrary">
            KHARISMA E-Library</span></li> akan membantu pencatatan aktivitas dan statistik penggunaan <span class="kharismalibrary">KHARISMA E-Library</span>, yang nantinya akan menjadi masukan untuk pengembangan Perpustakaan STMIK KHARISMA (khususnya koleksi dan pelayanan), serta pengembangan fasilitas dan pelayanan <span class="kharismalibrary">KHARISMA E-Library</span> ini. Untuk itu, pengelola Perpustakaan STMIK KHARISMA berterima kasih atas kerjasama Anda.
        </ul>

                </div>
            </div>
        </div>
    </section>

    <!-- *********************************************** KONTAK ********************************************** -->

    <section id="contact">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <h4 class="kharismalibrary">KHARISMA E-Library</h4>
                    <p>Perpustakaan STMIK KHARISMA Makassar<br>Jl. Baji Ateka 20 - Makassar 90134</p>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-phone fa-fw"></i> (0411) 871555 ext.402</li>
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
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

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
