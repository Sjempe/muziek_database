<?php
// --- 1. CONFIGURATIE EN VERBINDING ---
$host = "localhost";        // De server waar de database op draait (meestal je eigen Raspberry Pi)
$user = "seppelambrechts";  // Je gebruikersnaam voor de database
$pass = "Brugge281108";     // Het wachtwoord van je database-gebruiker
$db   = "muziek_database";  // De naam van de database die we willen gebruiken

// Maak verbinding met de MariaDB/MySQL server
$conn = new mysqli($host, $user, $pass);

// --- 2. DATABASE INITIALISATIE ---
// Maak de database aan als deze nog niet bestaat (voorkomt foutmeldingen bij de tweede keer draaien)
$conn->query("CREATE DATABASE IF NOT EXISTS $db");

// Selecteer de database zodat alle volgende opdrachten in de juiste 'map' terechtkomen
$conn->select_db($db);

// --- 3. TABEL ONTWERPEN (DE BLAUWDRUKKEN) ---
// We zetten alle SQL-opdrachten in een 'array' (een lijstje) om ze straks makkelijk te verwerken
$queries = [
    // Tabel voor artiesten: bevat een uniek ID, de naam en extra tekst
    "CREATE TABLE IF NOT EXISTS artiesten (
        artiest_ID INT AUTO_INCREMENT PRIMARY KEY,
        naam_artiest VARCHAR(255) NOT NULL,
        extra_info_artiest TEXT
    )",
    
    // Tabel voor albums: gekoppeld aan een artiest via artiest_ID
    "CREATE TABLE IF NOT EXISTS albums (
        album_ID INT AUTO_INCREMENT PRIMARY KEY,
        titel_album VARCHAR(255) NOT NULL,
        artiest_ID INT,
        drager_album VARCHAR(50),      -- Bijv: Vinyl, CD, Cassette
        type_album VARCHAR(50),        -- Bijv: Studio album, EP, Single
        cover_album VARCHAR(255),      -- Pad naar een afbeelding/link
        extra_info_album TEXT,
        FOREIGN KEY (artiest_ID) REFERENCES artiesten(artiest_ID) -- Maakt de relatie met de artiestentabel
    )",
    
    // Tabel voor merchandise: ook gekoppeld aan een artiest
    "CREATE TABLE IF NOT EXISTS merch (
        merch_ID INT AUTO_INCREMENT PRIMARY KEY,
        artiest_ID INT,
        naam_merch VARCHAR(255) NOT NULL,
        extra_info_merch TEXT,
        FOREIGN KEY (artiest_ID) REFERENCES artiesten(artiest_ID) -- Maakt de relatie met de artiestentabel
    )"
];

// --- 4. UITVOEREN VAN DE OPDRACHTEN ---
// We lopen door het lijstje met queries heen (de 'loop')
foreach ($queries as $sql) {
    // Voer de SQL-opdracht uit op de server
    if ($conn->query($sql) === TRUE) {
        // Als het lukt, geef een bevestiging
        echo "Tabel succesvol gecontroleerd/aangemaakt!<br>";
    } else {
        // Als er iets misgaat (bijv. een typfout in SQL), laat dan zien wat er fout is
        echo "Fout bij tabel: " . $conn->error . "<br>";
    }
}

// --- 5. AFSLUITING ---
// Sluit de verbinding met de server netjes af om resources te sparen
$conn->close();

// Controlebericht om te zien of het script het einde heeft bereikt
echo "TEST";
?>