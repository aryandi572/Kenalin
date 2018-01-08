<!DOCTYPE HTML>
<html>
    <head>  <!-- tag class head  -->
        <title>Daftar Kenalin</title> <!-- untuk judul  -->
        <link rel="stylesheet" href="css/daftar.css" /> <!-- import file css -->
    </head>  <!-- tag penutup class head  -->

    <body> <!-- tag pembuka body  -->
        <?php
        include "main/connect.php"; //untuk konek ke database
        include 'inc/script.inc';
        $dnamaErr = $bnamaErr = $emailErr = $passErr = $confirmpassErr = $kotaErr = $tglErr = $JKErr = $unamaErr = " "; //inialisasi string kosong agar tidak undefined
        $dnama = $bnama = $email = $pass = $confirmpass = $tgl = $kota = $unama = $cekJK = $inputbln = $inputtgl = $inputthn = "";  //inialisasi string kosong
        $hasiljk = false; //inialisasi deafult boolean false 
        
    

        function val_dnama($input) { //fungsi validasi nama depan
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

        function val_bnama($input) { //fungsi validasi nama belakang
            global $bnama, $bnamaErr;
            $bnama = trim($input);
            if (empty($bnama)) {
                $bnamaErr = "*Nama Belakang Tidak Boleh Kosong";
                return false;
            } else if (!preg_match("/^[a-zA-Z ]*$/", $bnama)) {
                $bnamaErr = "*Hanya Huruf dan Spasi";
                return false;
            } else {
                return true;
            }
        }

        function val_email($input) { //fungsi validasi email
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

        function val_tgl($inputthn, $inputbln, $inputtgl) { //fungsi validasi nama depan tanggal lahor
            global $tgl, $bulan, $tahun, $tglErr;
            $tgl = trim($inputtgl);
            $bulan = trim($inputbln);
            $tahun = trim($inputthn);
            //$lahir = $tahun.$bulan.$tgl;
            //print $lahir;
            if (empty($tgl) || empty($bulan) || empty($tgl)) {
                $tglErr = "*Tanggal Tidak Boleh Kosong";
                //return false;
            } else {
                return true;
            }
        }

        $JKErr = ""; // iniaslisasi string
        $cekJK = ""; // iniaslisasi string
        if (isset($_POST['button1'])) { // kondisi untuk radio button l & p harus diplih
            if (empty($_POST['Pilihan'])) {
                $JKErr = "*Pilih Salah Satu";
            } else {
                $cekJK = $_POST['Pilihan'];
                $hasiljk = true;
            }
        }

        function val_kota($input) { //fungsi validasi inputan kota
            global $kota, $kotaErr;
            $kota = trim($input);
            if (empty($kota)) {
                $kotaErr = "*Kota Tidak Boleh Kosong";
                return false;
            } else {
                return true;
            }
        }

         function val_UNama($input) { //fungsi validasi username
				global $unama, $unamaErr;
				$unama = trim($input);
				if (empty($unama)) {
					$unamaErr = "*Nama User Tidak Boleh Kosong";
						return false;
				} else if(cekuser($unama)){
					$unamaErr = "*Nama User sudah terdaftar";
				}else{
						return true;
				}
		}

        function val_password($input) { //fungsi validasi password batas min 7 inputan
            global $pass, $passErr;
            $pass = trim($input);
            if (empty($pass)) {
                $passErr = "*Sandi Tidak Boleh Kosong";
                return false;
            } else if (strlen($pass) < 7) {
                $passErr = "*Minimal password 7 digits";
                return false;
            } else {
                return true;
            }
        }

        function val_confirmPassword($input, $pass) { //fungsi validasi konfirmasi password
            global $confirmpass, $confirmpassErr;
            $confirmpass = trim($input);
            if (empty($confirmpass)) {
                $confirmpassErr = "*Konfirm Sandi Tidak Boleh Kosong";
                return false;
            } else if ($confirmpass != $pass) {
                $confirmpassErr = "*Sandi Tidak Sama";
                return false;
            } else {
                return true;
            }
        }

        function panggil() { //fungsi panggil untuk ememanggil semua function inputan dengan value post jika benar akan ada value true(benar)
            global $hasiljk;
            val_dnama($_POST['dnama']);
            val_bnama($_POST['bnama']);
            val_email($_POST['Email']);
            val_tgl($_POST['Tahun'], $_POST['Bulan'], $_POST['Tgl']);
            val_kota($_POST['Kota']);
            val_UNama($_POST['unama']);
            val_password(($_POST['passw']));
            val_confirmPassword(($_POST['passwa']), ($_POST['passw']));
            if (val_dnama(($_POST['dnama']))) {
                if (val_bnama($_POST['bnama'])) {
                    if (val_email($_POST['Email'])) {
                        if (val_tgl($_POST['Tahun'], $_POST['Bulan'], $_POST['Tgl'])) {
                            if ($hasiljk) {
                                if (val_kota($_POST['Kota'])) {
                                    if (val_UNama($_POST['unama'])) {
                                        if (val_password($_POST['passw'])) {
                                            if (val_confirmPassword($_POST['passwa'], $_POST['passw'])) {
                                                return true;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ((isset($_POST['button1'])) && (panggil())) { // kondisi jika button1 ditekan dan fungsi panggil true maka data akan diupdate ke database
            $namadp = $_POST['dnama'];
            $namabl = $_POST['bnama'];
            $mail = $_POST['Email'];
            $jk = $_POST['Pilihan'];
            $kota = $_POST['Kota'];
            $usere = $_POST['unama'];
            $passe = $_POST['passw'];
            $lahire = $tgl . '-' . $bulan . '-' . $tahun;

            $insert = $dbh->prepare("INSERT INTO akun (NAMA_DEPAN, NAMA_BELAKANG, EMAIL, JENKEL, TGL_LAHIR, KOTA, USERNAME, PASSWORD) VALUES (:NAMA_DEPAN, :NAMA_BELAKANG, :EMAIL, :JENKEL, :TGL_LAHIR, :KOTA, :USERNAME, SHA2(:PASSWORD,0))"); //query untuk memasukan value daftar ke tabel databse akun 
            $insert->bindValue(':NAMA_DEPAN', $namadp);
            $insert->bindValue(':NAMA_BELAKANG', $namabl);
            $insert->bindValue(':EMAIL', $mail);
            $insert->bindValue(':JENKEL', $jk);
            $insert->bindValue(':TGL_LAHIR', $lahire);
            $insert->bindValue(':KOTA', $kota);
            $insert->bindValue(':USERNAME', $usere);
            $insert->bindValue(':PASSWORD', $passe);
            $insert->execute(); //eksekusi query

             header('Refresh: 5; URL=login.php'); // diarahkan ke login dengan delay 5 detik
            echo "<h3>Pendaftaran Berhasil, Tunggu beberapa saat akan mengarah ke halaman <a href='login.php'> Masuk <a></h3>"; //notif pesan berhasil daftar
        } else {
            ?>
            <div class="container">  <!-- tag conatainer  -->
                <div class="main"> <!-- tag main  -->
                    <a href="index.php"> <img alt="logo" src="gambar/logo-regis2.png" class="logo-register"> </a>  <!-- untuk logo profil -->

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data"> <!-- tag class form dengn self submission -->
                        <input class="input" type="text" name="dnama" placeholder="Name Depan" value="<?php echo $dnama; ?>">  <!-- form inputan nama depan -->
                        <div class="error"> <?php echo $dnamaErr; ?></div> <!-- untuk meanmpilkan pesan nama depan error -->

                        <input class="input" type="text" name="bnama" placeholder="Name Belakang" value="<?php echo $bnama; ?>"> <!-- form inputan nama bealakang -->
                        <div class="error"><?php echo $bnamaErr; ?></div>  <!-- untuk meanmpilkan pesan nama brlakang error -->

                        <input class="input" type="text" name="Email" placeholder="Email" value="<?php echo $email; ?>"> <!-- form inputan email -->
                        <div class="error"><?php echo $emailErr; ?></div>  <!-- untuk meanmpilkan pesan email error -->

                        <div id="jarak">
                            <label>Jenis Kelamin :</label>
                            <input name="Pilihan" value="L" type="radio" <?php if ($cekJK == "L") { 
            echo "checked";
        } ?>>L <!-- form inputan pilihan jenis kelamin -->
                            <input name="Pilihan" value="P" type="radio" <?php if ($cekJK == "P") {
            echo "checked";
        } ?>>P <!-- form inputan pilihan jenis kelamin -->
                        </div>
                        <div class="error"><?php echo $JKErr; ?></div> <!-- untuk meanmpilkan pesan pilihan jenis kelamin error -->

                        <div id="jarak2">
                            <label>Tanggal Lahir :</label>  <!-- form select tanggal lahir -->
                            <select name="Tahun">
                                <option value="" selected> Tahun </option>  <!-- form select tanggal lahir untuk tahunya  -->
    <?php for ($tahun = 2017; $tahun >= 1900; $tahun--) { ?>
                                    <option value="<?php echo $tahun; ?>">
        <?php echo $tahun; ?>
                                    </option> <?php } ?>
                            </select>

                            <select name="Bulan">   <!-- form select tanggal lahir untuk bulannya  -->
                                <option value="" selected> Bulan </option>
                                    <?php
                                    $nmbulan = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agus", "Sep", "Okt", "Nov", "Des");
                                    ?>
    <?php for ($bulan = 1; $bulan <= 12; $bulan++) { ?>
                                    <option value="<?php echo $bulan; ?>">
        <?php echo $nmbulan[$bulan - 1]; ?>
                                    </option> <?php } ?>
                            </select>

                            <select name="Tgl">  <!-- form select tanggal lahir untuk tanggalnya  -->
                                <option selected> Tgl </option>
    <?php for ($hari = 1; $hari <= 31; $hari++) { ?>
                                    <option value="<?php echo $hari; ?>">
        <?php echo $hari; ?>
                                    </option> <?php } ?>
                            </select>
                        </div>
                        <div class="error"><?php echo $tglErr; ?></div> <!-- untuk meanmpilkan pesan tanggal lahir error -->

                        <input class="input" type="text" name="Kota" placeholder="Kota Asal" value="<?php echo $kota; ?>">  <!-- form inputan kota -->
                        <div class="error"> <?php echo $kotaErr; ?> </div> <!-- untuk meanmpilkan pesan kota error -->

                        <input class="input" type="text" name="unama" placeholder="Name User" value="<?php echo $unama; ?>"> <!-- form inputan username -->
                        <div class="error"><?php echo $unamaErr; ?></div> <!-- untuk meanmpilkan pesan username error -->

                        <input class="input" type="password" name="passw" placeholder="Sandi" value="<?php echo $pass; ?>"> <!-- form inputan password -->
                        <div class="error"> <?php echo $passErr; ?></div> <!-- untuk meanmpilkan pesan password error -->


                        <input class="input" type="password" name="passwa" placeholder="Konfirmasi Sandi" value="<?php echo $confirmpass; ?>"> <!-- form inputan konfirmasi password -->
                        <div class="error"><?php echo $confirmpassErr ?></div> <!-- untuk meanmpilkan pesan konfirmasi password error -->

                        <input class="submit" type="submit" name="button1" value="Daftar"> <!-- tombol btton untuk mengirim inputan -->
                    </form><!-- tag penutup form -->
                </div> <!-- tag penutup main  -->
            </div> <!-- tag penutup conatainer  -->
<?php } ?>
    </body> <!-- tag penutup body  -->
</html>
