<?php
$host = "localhost";
$user = "seppelambrechts";
$pass = "Brugge281108"; 
$db   = "muziek_database";

$conn = new mysqli($host, $user, $pass, $db);

$album_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($album_id > 0) {
    // 1. Eerst de liedjes verwijderen (foreign key constraint voorkomen)
    $sql_tracks = "DELETE FROM liedjes WHERE album_id = $album_id";
    $conn->query($sql_tracks);

    // 2. Dan het album zelf verwijderen
    $sql_album = "DELETE FROM albums WHERE album_id = $album_id";
    
    if ($conn->query($sql_album)) {
        // Succes! Terug naar het overzicht
        header("Location: index.php?message=deleted");
    } else {
        echo "Fout bij verwijderen: " . $conn->error;
    }
} else {
    echo "Geen geldig ID gevonden.";
}

$conn->close();
?>