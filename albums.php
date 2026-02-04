<?php
// --- 1. VERBINDING ---
$conn = new mysqli("localhost", "seppelambrechts", "Brugge281108", "muziek_database");

// --- 2. VERWERKING NA KLIK OP OPSLAAN ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // real_escape_string voorkomt SQL-injectie (hacks) en zorgt dat namen met een ' (zoals O'neill) geen foutmelding geven
    $artiest_naam = $conn->real_escape_string($_POST['artiest']);
    $album_titel = $conn->real_escape_string($_POST['titel']);
    $drager = $_POST['type'];
    $liedjes_tekst = $conn->real_escape_string($_POST['liedjes']);

    // --- STAP A: DE ARTIEST CHECKEN ---
    // We kijken of de getypte artiest al in de database staat
    $check_artiest = $conn->query("SELECT artiest_id FROM artiesten WHERE naam_artiest = '$artiest_naam'");
    
    if ($check_artiest->num_rows > 0) {
        // De artiest bestaat al: we halen het bestaande ID op
        $artiest_id = $check_artiest->fetch_assoc()['artiest_id'];
    } else {
        // De artiest is nieuw: we voegen hem toe en vragen het nieuwe ID op met insert_id
        $conn->query("INSERT INTO artiesten (naam_artiest) VALUES ('$artiest_naam')");
        $artiest_id = $conn->insert_id;
    }

    // --- STAP B: HET ALBUM OPSLAAN ---
    // We koppelen het album aan het artiest_id dat we hierboven hebben gevonden/gemaakt
    $conn->query("INSERT INTO albums (titel_album, artiest_id, type_album) VALUES ('$album_titel', '$artiest_id', '$drager')");
    $album_id = $conn->insert_id; // Dit ID hebben we nodig om de liedjes aan het juiste album te koppelen

    // --- STAP C: DE LIEDJES VERWERKEN ---
    if (!empty($liedjes_tekst)) {
        // explode knipt de grote lap tekst in stukjes, telkens als je op 'Enter' hebt gedrukt (\n)
        $liedjes_array = explode("\n", str_replace("\r", "", $liedjes_tekst));
        
        foreach ($liedjes_array as $lied) {
            $lied = trim($lied); // trim haalt onzichtbare spaties aan het begin/einde weg
            if (!empty($lied)) {
                // Elk liedje wordt los in de tabel 'liedjes' gezet met het ID van het zojuist gemaakte album
                $conn->query("INSERT INTO liedjes (album_id, titel_lied) VALUES ('$album_id', '$lied')");
            }
        }
    }
    echo "<p style='color:green;'>Alles succesvol opgeslagen!</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="CSS/style_form.css?v=<?php echo time(); ?>">
    <title>Toevoegen</title>
</head>
<body>
    <div class="container">
        <h1>Toevoegen</h1>
        <form method="POST">
            <input type="text" name="artiest" class="search-box" placeholder="Naam artiest..." required>
            <input type="text" name="titel" class="search-box" placeholder="Titel album..." required>
            
            <select name="type" class="search-box">
                <option value="CD">CD</option>
                <option value="Vinyl">Vinyl</option>
                <option value="Cassette">Cassette</option>
            </select>

            <label>Liedjes (één per regel, optioneel):</label>
            <textarea name="liedjes" class="search-box" style="height: 100px; font-family: sans-serif;"></textarea>

            <button type="submit" class="btn-add" style="width: 100%; border: none; cursor: pointer;">Opslaan</button>
        </form>
        <a href="home.php" style="display:block; text-align:center; margin-top:10px;">Terug naar Home</a>
    </div>
</body>
</html>