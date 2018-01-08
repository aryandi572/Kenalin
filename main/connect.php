<?php
try {
    $dbh = new PDO('mysql:host=localhost;dbname=social','root',''); //connect kan dengan host, nama databae, user dan password.
//    echo "succes";
} catch (PDOException $e) { //menangkap pesan error jika terjadi
    print "Error!: " . $e->getMessage() . "<br/>"; //menampilkan pesan error
    die();
}
?>
