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
