<!DOCTYPE html>
<html>
    <head> <!-- tag class head  -->
        <?php include "inc/script.inc"; //import function dalam scricp ?> 
        <title>Profil - Kenalin</title> <!-- tag judul -->
        <link href="css/style.css" rel="stylesheet" type="text/css" /> <!-- import css -->
    </head> <!-- tag penutup class head  -->
    <body>  <!-- tag body-->
        <?php
        include "inc/header.inc"; //import header
        require 'main/akses.inc'; //import file akses seesion user
        if (isset($_GET["profil"])) { //kondisi cek nilai profil
            $akunSekarang = $_GET["profil"]; // jika true maka $akunSekarang value profil
        } else {
            $akunSekarang = $_SESSION['user']; //jika false value user
        }
        ?>
        <div class="content"> <!-- tag class content -->
            <div class="content-profil-foto"> <!-- tag class content-profil-foto -->
                <a href="profil.php"> <img alt="logo" src="gambar/muslimah.jpg" class="foto-profil"> </a> <!-- tag class foto -->
                <?php
                ambilDetail($akunSekarang); //function detail dari akun 
                if (!(cekPertemanan($akunSekarang))) { // sebuah kondisi untuk pengecakan perteamanan 
                    echo "<form method='POST' action='profil.php' class='tengah'> 
                    <input type='hidden' name='kenalan' value=" . $akunSekarang . ">
                    <input class='tombolTambahTeman' type='submit' value='Kenalin'>
                </form>"; //button keanlin jika belum berteman
                }
                ?>

            </div> <!-- tag class penutup content-profil-foto -->
            <hr class="batas">

            <div class="content-profil"> <!-- tag class content-profil-->


                <?php 
                if (cekPertemanan($akunSekarang)) { //kondisi cek teman dengan akun yang login
                    echo '<form method="GET" action="profil.php"> 
                            <input type="hidden" name="profil" value="' . $akunSekarang . '">
                            <input type="hidden" name="mod" value="status">
                            <input class="tombol-profil" type="submit" value="Status">
                         </form>'; //tampilan form status
                }
                echo '<form method="GET" action="profil.php"> 
                        <input type="hidden" name="profil" value="' . $akunSekarang . '">
                        <input type="hidden" name="mod" value="detail">
                        <input class="tombol-profil" type="submit" value="Detail">
                    </form>'; //tampilan form detail
                if (cekPertemanan($akunSekarang)) { //kondisi cek teman dengan akun yang login
                    echo '<form method="GET" action="profil.php">
                            <input type="hidden" name="profil" value="' . $akunSekarang . '">
                            <input type="hidden" name="mod" value="teman">
                            <input class="tombol-profil" type="submit" value="Teman">
                        </form>'; //tampilan form teman
                }
                ?>

                <div class="posisi_nama_profil">  <!-- tag class posisi_nama_profil-->
                    <?php
                    if (cekPertemanan($akunSekarang)) { // cek pertemanan dengan akun yang login
                        if (isset($_GET["mod"])) { //jika value mod
                            if ($_GET["mod"] === "teman") { //jika value teman maka tampilkan daftar teman 
                                profilTeman($akunSekarang);
                            }if ($_GET["mod"] === "detail") { //jika value detail maka tampilkan daftar deatil
                                profilDetail($akunSekarang);
                            }if ($_GET["mod"] === "status") { //jika value teman maka teampilkan daftar status
                                profilStatus($akunSekarang);
                            }
                        } else {
                            profilStatus($akunSekarang); //tampilkan profil status akun sekarang
                        }
                    } else {
                        profilDetail($akunSekarang);  //tampilkan profil deatil akun sekarang
                    }
                    ?> 
                </div>   <!-- tag penutup class posisi_nama_profil-->
            </div><!-- tag penutup class content-profil-->
        </div> <!-- tag penutup class content -->
        <?php include "inc/footer.inc"; //import footer ?>
    </body>  <!-- tag pentup body-->
</html>

