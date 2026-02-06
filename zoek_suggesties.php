<?php
$conn = new mysqli("localhost", "seppelambrechts", "Brugge281108", "muziek_database");

if (isset($_GET['q'])) {
    $zoekterm = $conn->real_escape_string($_GET['q']) . '%';
    // We zoeken op albumtitel
    $sql = "SELECT album_id, titel_album FROM albums WHERE titel_album LIKE '$zoekterm' LIMIT 5";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // We maken een klikbare link voor elke suggestie
            echo "<div class='suggestie-item' onclick='selecteerAlbum(\"" . $row['titel_album'] . "\", " . $row['album_id'] . ")'>";
            echo $row['titel_album'];
            echo "</div>";
        }
    }
}
?>