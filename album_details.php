<?php
// 1. Foutmeldingen aanzetten voor debugging
ini_set('display_errors', 1);
ini_set('startup_errors', 1);
error_reporting(E_ALL);

// 2. Verbinding maken met de database
$host = "localhost";
$user = "seppelambrechts";
$pass = "Brugge281108"; 
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

// 5. Query om de liedjes op te halen
$sql_liedjes = "SELECT titel_lied FROM liedjes WHERE album_id = $album_id ORDER BY lied_id ASC";
$res_liedjes = $conn->query($sql_liedjes);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Details - <?php echo htmlspecialchars($row['titel_album']); ?></title>
    <link rel="stylesheet" type="text/css" href="CSS/style_details.css?v=<?php echo time(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body>

<div class="container">
    <header>
        <h1><?php echo htmlspecialchars($row['titel_album']); ?></h1>
        <div class="meta-info">
            <p><strong class="text-info">ARTIEST:</strong> <?php echo htmlspecialchars($row['naam_artiest'] ?? 'Onbekend'); ?></p>
            <p><strong class="text-info">TYPE:</strong> <?php echo htmlspecialchars($row['type_album'] ?? 'Niet in database'); ?></p>
        </div>
    </header>

    <div class="recent-box">
        <h3>TRACKLIST</h3>
        <div class="tracklist-container">
            <?php if ($res_liedjes && $res_liedjes->num_rows > 0): ?>
                <table class="track-table">
                    <thead>
                        <tr>
                            <th style="width: 15%;">#</th>
                            <th style="width: 85%;">TITEL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        // De lus loopt door alle liedjes en maakt voor elk liedje een NIEUWE <tr> (rij)
                        while($lied = $res_liedjes->fetch_assoc()): ?>
                            <tr class="track-row">
                                <td class="drone-arrow"><?php echo $i++; ?>.</td>
                                <td class="track-name">
                                    <?php echo htmlspecialchars($lied['titel_lied']); ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-data">Geen liedjes gevonden voor dit album.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="actions">
        <a href="delete_album.php?id=<?php echo $album_id; ?>" class="delete-btn" onclick="return confirm('WARNING: Permanent deletion of subject data. Proceed?')">DELETE ALBUM</a>
        
        <div class="back-container">
            <a href="index.php" class="back-link"> [ BACK TO OVERVIEW ] </a>
        </div>
    </div>
</div>

</body>
</html>