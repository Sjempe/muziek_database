<?php
// --- 1. VERBINDING EN VOORBEREIDING ---
// Maak verbinding met de database (localhost = je Raspberry Pi)
$conn = new mysqli("localhost", "seppelambrechts", "Brugge281108", "muziek_database");

// Kijk of er een zoekterm in de URL staat (bijv. home.php?search=Queen)
// Als er niets is ingevuld, maken we de variabele leeg ("")
$zoekterm = isset($_GET['search']) ? $_GET['search'] : "";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Muziek Database - Home</title>
    <link rel="stylesheet" type="text/css" href="CSS/style_main.css?v=<?php echo time(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body>
    <div class="container">
    <h1>HOME</h1>

    <form method="GET" action="home.php">
        <input type="text" name="search" class="search-box" placeholder="Zoeken..." value="<?php echo htmlspecialchars($zoekterm); ?>">
    </form>

    <div class="recent-box">
        <?php if ($zoekterm == ""): ?>
            <h3>Laatst toegevoegd</h3>
            <?php
            $sql_recent = "SELECT artiesten.naam_artiest, albums.titel_album, albums.album_id 
                           FROM albums 
                           JOIN artiesten ON albums.artiest_id = artiesten.artiest_id 
                           ORDER BY albums.album_id DESC LIMIT 5";
            $res_recent = $conn->query($sql_recent);
            while($row = $res_recent->fetch_assoc()): ?>
                <div class="recent-item">
                <span class="drone-icon">[o]</span> 
                <a href="album_details.php?id=<?php echo $row['album_id']; ?>">
                    <?php echo $row['naam_artiest'] . " - " . $row['titel_album']; ?>
                </a>
</div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <h3>Zoekresultaten</h3>
            <?php endif; ?>
    </div>
        <a href="albums.php" class="btn-add">album toevoegen</a>
    </div>  
</body>
</html>