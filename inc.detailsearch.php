<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Pencarian Detail</h3>
  </div>
  <div class="panel-body">

<form action="<?php echo $_SERVER['PHP_SELF'].'#pencarian'; ?>" method="POST">
  <input type="hidden" name="detail" value="true">
  <div class="form-group">
    <label for="author">Penulis</label>
    <input type="text" class="form-control" id="penulis" name="author" placeholder="Penulis/pengarang">
  </div>
  <div class="form-group">
    <label for="judul">Judul</label>
    <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul">
  </div>
  <div class="form-group">
    <label for="dkeyword">Kata kunci</label>
    <input type="text" class="form-control" id="dkeyword" name="dkeyword" placeholder="keyword">
  </div>
  <div class="form-group row">
    <div class="col-xs-4">
      <div class="checkbox">
        <label>
        <input type="checkbox" name="chkbuku" checked>Buku
        </label>
      </div>
      <div class="checkbox">
        <label>
        <input type="checkbox" name="chkebook" checked>E-book
        </label>
      </div>
    </div>
    <div class="col-xs-4">
      <div class="checkbox">
        <label>
        <input type="checkbox" name="chkpaper">Paper
        </label>
      </div>
    </div>
    <div class="col-xs-4">
      <div class="checkbox">
        <label>
        <input type="checkbox" name="chkskripsi">Skripsi
        </label>
      </div>
      <div class="checkbox">
        <label>
        <input type="checkbox" name="chklaporan">Laporan
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="tahun">Tahun</label>
        <div class="input-group">
                <div class="input-group-btn year-select">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                      <span id="search_year">=</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#eq"><b> = &nbsp;&nbsp;</b></a></li>
                      <li><a href="#gt"><b> &gt;= &nbsp;&nbsp;</b></a></li>
                      <li><a href="#lt"><b> &lt;= &nbsp;&nbsp;</b></a></li>
                    </ul>
                </div>
            <input type="hidden" name="year_param" value="=" id="year_param">
            <input type="text" class="form-control" id="tahun" name="tahun" placeholder="Tahun (YYYY)">
        </div>
  </div>
  <button type="submit" class="btn btn-default"><span class="fa fa-search">Cari</span></button>
</form>


  </div><!-- panel body -->
</div><!-- panel -->
