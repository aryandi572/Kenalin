<?php
include "main/connect.php"; //koneksi ke database
session_start(); // memulai session
$messageError = ""; //inialisasi string kosong

//penanganan kondisi status masih kosong
if (isset($_POST['submit'])) {
    $status = $_POST['status'];
    if (empty($status)) {
        $messageError = "Status masih kosong !!!";
    } else {
        $status = htmlspecialchars($status);
        $userSekarang = $_SESSION['user'];
        $query = $dbh->prepare("INSERT INTO status (ID_STATUS, USER_STATUS, ISI_STATUS, WAKTU_STATUS) VALUES (null,:user,:status,CURRENT_TIMESTAMP)"); //query memasukan data ka tabel status dari user dan isi status
        $query->bindValue(":user", $userSekarang);
        $query->bindValue(":status", $status);
        $query->execute();
        header('Location: index.php');
    }
}
//menangkap kondisi tombol tambah teman di klik
if (isset($_POST["kenalan"])) {
    tambahTeman($_POST["kenalan"]);
}

//fungsi menampilkan status dari teman dan diri sendiri 
//digunakan di beranda
function statusBeranda($userSekarang) {
    global $dbh;
    $query = $dbh->prepare("SELECT * 
                            from status LEFT JOIN akun ON status.USER_STATUS = akun.USERNAME 
                            where USER_STATUS=:user 
                            or USER_STATUS in (SELECT akun_teman.TEMAN FROM akun_teman WHERE akun_teman.USERNAME = :user) 
                            or USER_STATUS in (SELECT akun_teman.USERNAME FROM akun_teman WHERE akun_teman.TEMAN=:user) 
                            ORDER by status.WAKTU_STATUS DESC ");
    $query->bindValue(':user', $userSekarang);
    $query->execute();
    foreach ($query as $row) {
        echo '<div class="content-komentar">
					<div>
						<div class="kiri">
						<a href="profil.php"> <img alt="logo" src="gambar/muslimah.jpg" class="profil2"> </a>
						</div>

						<div class="profilstatus">
						<a href="profil.php?profil=' . $row['USER_STATUS'] . '"> ' . $row['NAMA_DEPAN'] . " " . $row['NAMA_BELAKANG'] . '</a> <br>
						</div>
						<div>
							<div>' . $row['WAKTU_STATUS'] . '</div>
						</div>
					</div>

					<div class="status">
						<p>' . $row['ISI_STATUS'] . '</p>
					</div>
				</div>';
    }
}

//==============FUNGSI YANG DIGUNAKAN DI PROFIL======================
//menampilkan status dari user tertentu sebagai parameter
function profilStatus($akunSekarang) {
    global $dbh;
    $query = $dbh->prepare("SELECT * FROM status LEFT JOIN akun ON status.USER_STATUS = akun.USERNAME 
                            where user_status = :user ORDER BY ID_STATUS DESC");
    $query->bindValue(':user', $akunSekarang);
    $query->execute();

    foreach ($query as $row) {
        echo '<div class="posisi_nama_profil2">
                <div>
                    <div class="kiri">
                        <a href="profil.php"> <img alt="logo" src="gambar/muslimah.jpg" class="profil2"> </a>
                    </div>

                    <div class="profilstatus">
                        <a href="profil.php?profil=' . $row['USER_STATUS'] . '"> ' . $row['NAMA_DEPAN'] . " " . $row['NAMA_BELAKANG'] . ' </a> <br>
                    </div>
                    <div>
                        <div> ' . $row['WAKTU_STATUS'] . ' </div>
                    </div>
                </div>

                <div class="status">
                    <p>' . $row['ISI_STATUS'] . '</p>
                </div>
              </div>
            ';
    }
}

//menampilkan detail dari user tertentu sebagai parameter
function profilDetail($akunSekarang) {
    global $dbh;
    $query = $dbh->prepare("SELECT * FROM akun WHERE USERNAME = :USER");
    $query->bindValue(':USER', $akunSekarang);
    $query->execute();
    foreach ($query as $row) {
        echo '<div class="posisi_nama_profil2">
                <div class="kiri">
                    Nama Depan
                    <p> Nama Belakang
                    <p> Email
                    <p> Jenis Kelamin
                    <p> Tanggal Lahir
                    <p> Kota
		</div>
				
		<div class="kiri">
                    : ' . $row['NAMA_DEPAN'] . '
                    <p>
                    : ' . $row['NAMA_BELAKANG'] . '
                    <p>
                    : ' . $row['EMAIL'] . '
                    <p>
                    : ' . $row['JENKEL'] . '
                    <p>
                    : ' . $row['TGL_LAHIR'] . '
                    <p>
                    : ' . $row['KOTA'] . '
                    </div>
            </div>';
    }
}

//menampilkan daftar teman dari user tertentu sebagai parameter
function profilTeman($akunSekarang) {
    global $dbh;
    $query = $dbh->prepare("SELECT akun_teman.TEMAN , KOTA , akun.NAMA_DEPAN ,akun.NAMA_BELAKANG 
                            FROM akun_teman LEFT JOIN akun ON akun_teman.TEMAN = akun.USERNAME 
                            WHERE akun_teman.USERNAME = :user 
                            UNION 
                            SELECT akun_teman.USERNAME , KOTA ,akun.NAMA_DEPAN ,akun.NAMA_BELAKANG
                            FROM akun_teman LEFT JOIN akun ON akun_teman.USERNAME = akun.USERNAME 
                            WHERE akun_teman.TEMAN = :user ");
    $query->bindValue(':user', $akunSekarang);
    $query->execute();
    foreach ($query as $row) {
        echo '<div class="posisi_nama_profil2">
                <div class="kiri">
                    <a href="profil.php"> <img alt="logo" src="gambar/muslimah.jpg" class="profil2"> </a>
                </div>
                <div class="profilstatus">
                    <a href="profil.php?profil=' . $row['TEMAN'] . '"> ' . $row['NAMA_DEPAN'] . " " . $row['NAMA_BELAKANG'] . ' </a> <br>
                </div>
                <div>
                     <div> ' . $row['KOTA'] . ' 
                    </div>
                </div>
            </div>';
    }
}

//mengambil data untuk ditampilkan di bawah foto profil
function ambilDetail($akunYangDiCek) {
    global $dbh;
    $query = $dbh->prepare("SELECT * FROM akun WHERE USERNAME = :USER");
    $query->bindValue(':USER', $akunYangDiCek);
    $query->execute();
    foreach ($query as $row) {
        echo "\n<p class='tengah'>" . $row['NAMA_DEPAN'] . " " . $row['NAMA_BELAKANG'] . "</p>"
        . "\n<p class='tengah'>" . $row['KOTA'] . "</p>"
        . "\n";
    }
}

//===================================================================
//melakukan pengecekan akun tertentu sebagai parameter apakah berteman denggan user yang aktif di season
function cekPertemanan($akunYangDiCek) {
    global $dbh;
//    $akunSekarang = $_SESSION['user'];
    $query = $dbh->prepare("SELECT *
                            FROM akun_teman
                            WHERE akun_teman.USERNAME = :cek AND akun_teman.TEMAN = :user
                            UNION
                            SELECT *
                            FROM akun_teman
                            WHERE akun_teman.TEMAN = :cek AND akun_teman.USERNAME = :user");
    $query->bindValue(":cek", $akunYangDiCek);
    $query->bindValue(":user", $_SESSION['user']);
    $query->execute();
    $cek = $query->rowCount() == 0;
    if ($akunYangDiCek === $_SESSION['user']) {
        return true;
    }
    if ($cek) { // mengecek jika $cek == true maka tidak berteman
        return false;
    } else {
        return true;
    }
}

// melakukan query insert ke tabel akun_teman 
function tambahTeman($teman) {
    global $dbh;
    $query = $dbh->prepare("INSERT INTO akun_teman (USERNAME, TEMAN) VALUES (:user, :teman);");
    $query->bindValue(':user', $_SESSION['user']);
    $query->bindValue(':teman', $teman);
    $query->execute();
}

// menampilkan daftar nama depan , nama belakakng , username yang mengandung substring parameter
function cari($cari) {
    global $dbh;
    $query = $dbh->prepare("SELECT * FROM akun WHERE NAMA_DEPAN LIKE :cari OR NAMA_BELAKANG LIKE :cari OR USERNAME LIKE :cari ");
    $query->bindValue(':cari', '%' . $cari . '%');
    $query->execute();
    foreach ($query as $row) {
        echo "<div class='posisi_nama_profil2'>
		<div class='kiri'>
                     <a href='profil.php'> <img alt='logo' src='gambar/muslimah.jpg' class='profil2'> </a>
		</div>";
        if (!(cekPertemanan($row['USERNAME']))) {
        
            echo"<div style='float: right; padding-right: 50%; padding-top:3%;'>
                   <form method='POST' action='profil.php' class='tengah'> 
                      <input type='hidden' name='kenalan' value=" . $row['USERNAME'] . ">
                      <input class='tombolTambahTeman' type='submit' value='Kenalin'>
                   </form>
		</div>";
        }
        echo " <div class='profilstatus'>
                    <a href='profil.php?profil=" . $row['USERNAME'] . "'>" . $row['NAMA_DEPAN'] . " " . $row['NAMA_BELAKANG'] . " </a> <br>
		</div>
		<div>
                    <div> " . $row['KOTA'] . " </div>
		</div>
              </div>";
    }
}

//untuk pengecekan user sudah terdaftar apa belum
function cekuser($akun){
    global $dbh;
    $query = $dbh->prepare("SELECT * FROM akun where USERNAME = :cek ");
    $query->bindValue(':cek', $akun);
    $query->execute();
    $ada = $query->rowCount()>0;
    return $ada;
}