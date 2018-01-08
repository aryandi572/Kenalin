<!DOCTYPE html>
<html>
    <head>  <!-- tag class head  -->
        <title>Cari Teman - Kenalin</title> <!-- untuk judul  -->
        <link href="css/style.css" rel="stylesheet" type="text/css" /> <!-- import file css -->
    </head> <!-- tag penutup class head  -->

    <body> <!-- tag class body  -->
        <?php 
        include "inc/script.inc"; //import function didalm script
        include "inc/header.inc"; //import header
        require 'main/akses.inc'; //import cek akses session user
        ?>
        <div class="content"> <!-- tag class content  -->
            <div class="content-status"> <!-- tag class content-status  -->
                <button class="tombol-status"> Cari Teman </button> <br> <!-- button class Cari  -->

                <?php
                $cari = $_GET['cari']; //get nilai value cari
                cari($cari); //memanggil fuction cari dari nilai $cari
                ?>
            </div> <!-- tag penutup class content-status  -->
        </div>  <!-- tag penutup class content  -->
        <?php include "inc/footer.inc"; //import header
        ?>
    </body>  <!-- tag penutup class body  -->
</html>
