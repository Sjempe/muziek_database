<?php
// 1. Foutmeldingen aanzetten voor debugging
ini_set('display_errors', 1);
ini_set('startup_errors', 1);
error_reporting(E_ALL);

// 2. Verbinding maken met de database
$host = "localhost";
$user = "seppelambrechts";
$pass = "Brugge281108"; // Pas aan als je wachtwoord anders is
$db   = "muziek_database";

$conn = new mysqli($host, $user, $pass, $db);

// Check verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// 3. Album ID ophalen uit de URL
$album_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($album_id === 0) {
    die("Geen geldig album geselecteerd.");
}

// 4. Query om album- én artiestgegevens op te halen via een JOIN
$sql_album = "SELECT a.titel_album, a.type_album, a.artiest_id, art.naam_artiest 
              FROM albums AS a 
              JOIN artiesten AS art ON a.artiest_id = art.artiest_id 
              WHERE a.album_id = $album_id";
$res_album = $conn->query($sql_album);

if (!$res_album) {
    die("SQL Fout in album query: " . $conn->error);
}

$row = $res_album->fetch_assoc();

if (!$row) {
    die("Album niet gevonden in de database.");
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Details - <?php echo htmlspecialchars($row['titel_album']); ?></title>
    <link rel="stylesheet" type="text/css" href="CSS/style_details.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="container">
    <h1><?php echo htmlspecialchars($row['titel_album']); ?></h1>
    
    <p><strong class="text-info">Artiest:</strong> <?php echo htmlspecialchars($row['naam_artiest'] ?? 'Onbekend'); ?></p>
    <p><strong class="text-info">Drager:</strong> <?php echo htmlspecialchars($row['type_album'] ?? 'Niet in database'); ?></p>

    <div class="recent-box">
        <h3>Tracklist</h3>
        <div class="tracklist-container">
            <?php
            // 5. Liedjes ophalen die bij dit album horen
            $sql_liedjes = "SELECT titel_lied FROM liedjes WHERE album_id = $album_id";
            $res_liedjes = $conn->query($sql_liedjes);

            if ($res_liedjes && $res_liedjes->num_rows > 0) {
                while($lied = $res_liedjes->fetch_assoc()) {
                    echo "<div class='track-row'>";
                    echo "<span class='drone-arrow'> > </span>"; 
                    echo htmlspecialchars($lied['titel_lied']);
                    echo "</div>";
                }
            } else {
                echo "<p>Geen liedjes gevonden voor dit album.</p>";
            }
            ?>
        </div>
    </div>

    <div class="actions">
        <a href="delete_album.php?id=<?php echo $album_id; ?>" class="delete-btn" onclick="return confirm('WARNING: Delete album?')">Verwijder Album</a>
        
        <div class="back-container">
            <a href="index.php" class="back-link">Terug naar overzicht</a>
        </div>
    </div>
</div>

</body>
</html>