
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
