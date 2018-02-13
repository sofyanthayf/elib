<?php
    $this->load->view('layout/nav');
 ?>

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
                $this->load->view('home_include/search');
            ?>

            <hr>
            <div class="col-xs-12 col-sm-8">
            <?php

                if( isset( $_POST['keyword'] ) && !empty( $_POST['keyword'] ) ) {
                    echo "<h4><strong>Hasil Pencarian </strong><i>'".$_POST['keyword']."'</i></h4>";
                    $this->load->view('home_include/searching.php');

                } elseif ( isset( $_POST['detail'] ) && $_POST['detail']=='true'  ) {
                    echo "<h4><strong>Hasil Pencarian </strong></h4>";
                    $this->load->view('home_include/detailsearching.php');

                }

            ?>
            </div>

            <div class="col-xs-6 col-sm-4 sidebar-offcanvas">
            <?php
                /* pencarian detail */
                if( isset( $_SESSION['uid'] ) ) {
                    $this->load->view('home_include/detailsearch');
                }

            ?>
            </div>
        </div>

        <?php
          $this->load->view('home_include/detail_modal');
         ?>
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
