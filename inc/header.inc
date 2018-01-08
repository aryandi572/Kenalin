<?php
    global $dbh;  //variabe global connect ke database
    $query = $dbh->prepare("SELECT * FROM akun WHERE USERNAME = :USER"); //query menmpilkan username dalam tabel akun
    $query->bindValue(':USER', $_SESSION['user']);  //inialisasi user untuk masukan ke query
    $query->execute(); //eksekusi query sql
    foreach ($query as $row) { //untuk menampilkan semua data dari query
        $NamaAkun = $row['NAMA_DEPAN'] . " " . $row['NAMA_BELAKANG']; //get nilai nama depan dan belakang
    }
?>
<div class="header">  <!-- tag class header  -->
    <div class="jarak_logo">
        <a href="index.php"> <img alt="logo" src="gambar/logo.png" class="logo"> </a> <!-- untuk logo  -->
    </div>

    <div class="header_letak"> <!-- untuk form kotak pencarian  -->
        <form action="cari_teman.php" method="get">
            <input id="cari" name= "cari" type="text" placeholder="Temukan Teman" class="cari" />

        </form>
    </div>  <!-- untuk kotak pencarian  -->

    <div class="atur_pesan">  <!-- untuk button link edit profil & keluar -->
        <div class="dropdown">
            <button class="dropbtn"> &#9776; </button>
            <div class="dropdown-content">
                <a href="edit_profil.php"> Edit Profil </a>
                <a href="main/keluar.php"> Keluar </a>
            </div>
        </div>
    </div> <!-- untuk button link edit profil & keluar -->


    <div class="atur_profil"> 
        <hr class="garis"/> <!-- untuk garis -->
    </div>

    <div class="atur_profil"> 
        <form action="index.php"> <button class="pesan"> Beranda </button> </form>  <!-- untuk button beranda -->
    </div> 

    <div class="atur_profil"> 
        <hr class="garis"/> <!-- untuk garis -->
    </div>

    <div class="atur_profil">
        <form action="profil.php?profil=<?php echo $_SESSION['user']; ?>"> <button class="nama_profil"> <?php echo $NamaAkun ?> </button> </form>  <!-- untuk nama user -->
    </div>

    <div class="atur_profil">
        <a href="profil.php?profil=<?php echo $_SESSION['user']; ?>"> <img alt="logo" src="gambar/muslimah.jpg" class="profil"> </a>  <!-- untuk foto user -->
    </div>

</div>
