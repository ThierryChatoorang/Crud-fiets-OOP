<?php
// Autoloading via Composer
require_once __DIR__ . '/../vendor/autoload.php';


$db = new CrudFietsOOP\DatabaseManager();
$message = '';

// Check of er op insert-knop is gedrukt
if (isset($_POST['btn_ins'])) {
    try {
        // Maak nieuwe fiets
        $fiets = new CrudFietsOOP\Fiets([
            'merk' => $_POST['merk'],
            'type' => $_POST['type'],
            'prijs' => (float)$_POST['prijs'],
            'foto' => $_POST['foto'] ?? ''
        ]);

        // Voeg toe aan database
        if ($db->insertRecord($fiets)) {
            $message = '<script>alert("Fiets is toegevoegd"); window.location.href="index.php";</script>';
        } else {
            $message = '<script>alert("Fiets is NIET toegevoegd");</script>';
        }
    } catch (Exception $e) {
        $message = '<script>alert("Fout: ' . $e->getMessage() . '");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiets Toevoegen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?= $message ?>
    
    <h1>Insert Fiets</h1>
    
    <form method="post">
        <label for="merk">Merk:</label>
        <input type="text" id="merk" name="merk" required><br>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required><br>

        <label for="prijs">Prijs:</label>
        <input type="number" step="0.01" id="prijs" name="prijs" required><br>

        <label for="foto">Foto:</label>
        <input type="text" id="foto" name="foto"><br>

        <button type="submit" name="btn_ins">Insert</button>
    </form>
    
    <br><br>
    <a href='index.php'>Home</a>
</body>
</html>
