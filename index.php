<!DOCTYPE html>
<?php
include "inc/script.inc"; //import file script (terdapat beberapa function)
include "main/connect.php"; //untuk konek ke database
require 'main/akses.inc'; //validasi akses session user
?>
<html>
    <head> 
        <title>Beranda - Kenalin</title> <!-- untuk judul  -->
        <link href="css/style.css" rel="stylesheet" type="text/css" /> <!-- import file css -->
    </head>

    <body>
        <?php
        include "inc/header.inc"; // import file header
        ?>
        <div class="content"> <!-- tag class content  -->
            <div class="content-status"> <!-- tag class content status -->
                <button class="tombol-status"> Buat Status </button> <br>  
                <div class="atur_profil_status">
                    <a href="profil.php"> <img alt="logo" src="gambar/muslimah.jpg" class="profil2"> </a> <!-- untuk logo profil -->
                    <form method="post" action="#">  <!-- tag class form status  -->
                        <textarea rows="4" cols="50" name="status" placeholder="Apa yang Anda Pikirkan ???"></textarea> <!-- tag class texarea untuk isi status  -->
                        <input type="submit" name="submit" value="kirim" class="tombol"> <!-- tag class button kirim status  -->
                    </form> <!-- tag penutup class from status  -->
                </div>
                <?php echo $messageError; ?>
            </div> <!-- tag penutup class content status -->
            <hr>
            <?php
            statusBeranda($_SESSION['user'])
            ?>
        </div> <!-- tag penutup class content  -->
        <?php include "inc/footer.inc"  //import file footer
        ?> 
    </body>
</html>
