<div class="container">
    <div class="row">    
        <div class="col-xs-8 col-xs-offset-2">
          <form action="<?php echo $_SERVER['PHP_SELF'].'#pencarian'; ?>" method="POST"> 
            <div class="input-group">

        <?php
          if( isset($_SESSION['uid']) ) {
        ?>
                <div class="input-group-btn search-panel">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                      <span id="search_concept">Filter by</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#buku">Buku (Edisi Cetak)</a></li>
                      <li><a href="#ebook">E-Book</a></li>
                      <li><a href="#paper">Paper</a></li>
                      <li><a href="#skripsi">Skripsi</a></li>
                      <li><a href="#laporan">Laporan</a></li>
                      <li class="divider"></li>
                      <li><a href="#all">Semuanya</a></li>
                    </ul>
                </div>
        <?php
          }
        ?>
                <input type="hidden" name="search_param" value="all" id="search_param">         
                <input type="text" class="form-control" name="keyword" placeholder="Pencarian pustaka...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
            <div>
              <p class="text-warning text-center"><small>
                operator pencarian: <b>+</b> = AND; <b>spasi</b> (tanpa tanda) = OR; <b>~</b> (<i>tilde</i>) = NOT;
                gunakan tanda <i><b>quote</b></i> (<b>"</b>...<b>"</b> atau <b>'</b>...<b>'</b> ) untuk pencarian frase utuh<br>
                <b>contoh: algoritma + pemrograman ~pascal</b> untuk semua judul yang mengandung kata 'algoritma' dan 'pemrograman' tidak termasuk yang mengandung kata 'pascal'  
              </small></p>
            </div>
          </form>
        </div>
	</div>
</div>

