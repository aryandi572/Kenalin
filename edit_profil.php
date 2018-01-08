<!DOCTYPE html>
<html>
    <head> <!-- tag class head  -->
        <title>Edit Profil - Kenalin</title> <!-- untuk judul  -->
        <link href="css/style.css" rel="stylesheet" type="text/css" /> <!-- import file css -->
    </head> <!-- tag penutup class head  -->

    <body>
        <?php
        session_start(); //memulai session
        include "main/connect.php"; //utuk koneksi dengan database
        require 'main/akses.inc'; //untuk xek akses session user
        $username = $_SESSION['user']; // inialisasi session user untuk $username

        $tampil = $dbh->prepare("SELECT * from akun WHERE USERNAME = :USERNAME"); //query untuk menampilkan username
        $tampil->bindValue(':USERNAME', $username); //inialisasi nilai :username untuk masukan query
        $tampil->execute(); //eksekusi query


        $dnamaErr = $bnamaErr = $emailErr = $kotaErr = $passErr = ""; //inialisasi string agar tidak undefined

        foreach ($tampil as $row) { // perulangan untuk menampilkan semua data di query
            $dnama = $row['NAMA_DEPAN'];
            $bnama = $row['NAMA_BELAKANG'];
            $email = $row['EMAIL'];
            $kota = $row['KOTA'];
            $password = $row['PASSWORD'];
        }

        function val_dnama($input) { //fungsi validasi input nama depan
            global $dnama, $dnamaErr;
            $dnama = trim($input);
            if (empty($dnama)) {
                $dnamaErr = "*Nama Depan Tidak Boleh Kosong";
                return false;
            } else if (!preg_match("/^[a-zA-Z ]*$/", $dnama)) {
                $dnamaErr = "*Hanya Huruf dan Spasi";
                return false;
            } else {
                return true;
            }
        }

        function val_bnama($input) { //fungsi validasi input nama belakang
            global $bnama, $bnamaErr;
            $bnama = trim($input);
            if (empty($bnama)) {
                $bnamaErr = "*Nama Blakang Tidak Boleh Kosong";
                return false;
            } else if (!preg_match("/^[a-zA-Z ]*$/", $bnama)) {
                $bnamaErr = "*Hanya Huruf dan Spasi";
                return false;
            } else {
                return true;
            }
        }

        function val_email($input) { //fungsi validasi input email
            global $email, $emailErr;
            $email = trim($input);
            if (empty($email)) {
                $emailErr = "*Email Tidak Boleh Kosong";
                return false;
            } else if (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $email)) {
                $emailErr = "*Email Tidak Valid";
                return false;
            } else {
                return true;
            }
        }

        function val_kota($input) { //fungsi validasi input kota
            global $kota, $kotaErr;
            $kota = trim($input);
            if (empty($kota)) {
                $kotaErr = "*Kota Tidak Boleh Kosong";
                return false;
            } else {
                return true;
            }
        }

        function val_password($passInput) {   //fungsi validasi input password
            global $password, $passErr;
            $passInput = hash('sha256', $passInput);
            if ($password == $passInput) {
                return True;
            }
            $passErr = "Password salah";
            return False;
        }

        function panggil() { // fungsi panggil untuk ememanggil semua function inputan dengan value post
            val_dnama($_POST['dnama']);
            val_bnama($_POST['bnama']);
            val_email($_POST['Email']);
            val_kota($_POST['Kota']);
            val_password($_POST['Password']);
            if (val_dnama(($_POST['dnama'])) && val_bnama($_POST['bnama']) && val_email($_POST['Email']) && val_kota($_POST['Kota']) && val_password($_POST['Password'])) {
                return True;
            }
        }

        if ((isset($_POST['button1'])) && (panggil())) { // kondisi jika button1 ditekan dan fungsi panggil true maka data akan diupdate ke database
            $update = $dbh->prepare("UPDATE akun SET NAMA_DEPAN = :NAMA_DEPAN, NAMA_BELAKANG = :NAMA_BELAKANG, EMAIL = :EMAIL, KOTA = :KOTA WHERE USERNAME = :USERNAME");  //update query untuk edit profil
            $update->bindValue(':NAMA_DEPAN', $_POST['dnama']); //inialisasi value nama depan untuk dimasukan ke query
            $update->bindValue(':NAMA_BELAKANG', $_POST['bnama']); //inialisasi value nama belakang untuk dimasukan ke query
            $update->bindValue(':EMAIL', $_POST['Email']); //inialisasi value email untuk dimasuakn ke query
            $update->bindValue(':KOTA', $_POST['Kota']); //inialisasi value kota untuk dimasuakn ke query
            $update->bindValue(':USERNAME', $username); //inialisasi value username untuk dimasuakn ke query
            $update->execute();  //eksekusi query

            header("Location: profil.php"); //akan diarahkan ke profil
        } else {
            ?>

            <?php include "inc/header.inc"; //import file header ?>
            <div class="content"> <!-- tag class content  -->
                <div class="content-edit"> <!-- tag class content-edit  -->
                    <button class="tombol-status"> Edit Profil </button> <br>

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> <!-- tag class form  -->
                        <div class="atur_profil_status"> <!-- tag class atur_profil_status  -->
                            <div>  <!-- tag label Nama,email,kota password  -->
                                Nama Depan
                                <p class="jarak"> Nama Belakang
                                <p class="jarak"> Email
                                <p class="jarak"> Kota
                                <p class="jarak"> Password
                            </div> <!-- tag penutup label  Nama,email,kota password  -->

                            <div>
                                : <input id="dnama" name="dnama" type="text" class="input-register" value="<?php echo $dnama; ?>" /> <!-- form inputan nama deapan -->
                                <span class="error"> <?php echo $dnamaErr; ?> </span> <!-- Menampilkan pesan error nama depan -->
                                <p>
                                    : <input id="bnama" name= "bnama" type="text" class="input-register" value="<?php echo $bnama; ?>" /> <!-- form inputan nama belakang -->
                                    <span class="error"> <?php echo $bnamaErr; ?> </span> <!-- Menampilkan pesan error nama belakang -->
                                <p>
                                    : <input id="Email" name= "Email" type="text" class="input-register" value="<?php echo $email; ?>" />  <!-- form inputan email -->
                                    <span class="error"> <?php echo $emailErr; ?> </span> <!-- Menampilkan pesan error email  -->
                                <p>
                                    : <input id="Kota" name="Kota" type="text" class="input-register" value="<?php echo $kota; ?>" /> <!-- form inputan kota -->
                                    <span class="error"> <?php echo $kotaErr; ?> </span> <!-- Menampilkan pesan error kota  -->
                                <p>
                                    : <input id="Password" name="Password" type="Password" class="input-register" value="" /> <!-- form inputan  password -->
                                    <span class="error"> <?php echo $passErr; ?> </span>   <!-- Menampilkan pesan error password  -->
                                <p>
                                    <input type="submit" value="Ubah" name="button1" class="button-edit" /> <!-- Button edit profil -->
                            </div>
                        </div> <!-- tag penutup class atur_profil_status  -->
                    </form> <!-- tag penutup class form  -->

                <?php }
                ?>
            </div> <!-- tag penutup class content-edit  -->
        </div> <!-- tag penutup class content  -->
        <?php include "inc/footer.inc" //import footer ?>
    </body> <!-- tag penutup body  -->
</html>
