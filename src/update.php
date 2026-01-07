<?php
// Autoloading via Composer
require_once __DIR__ . '/../vendor/autoload.php';


$db = new CrudFietsOOP\DatabaseManager();
$message = '';
$fiets = null;

// Check of er op wijzig-knop is gedrukt
if (isset($_POST['btn_wzg'])) {
    try {
        $fiets = new CrudFietsOOP\Fiets([
            'id' => (int)$_POST['id'],
            'merk' => $_POST['merk'],
            'type' => $_POST['type'],
            'prijs' => (float)$_POST['prijs'],
            'foto' => $_POST['foto'] ?? ''
        ]);

        if ($db->updateRecord($fiets)) {
            $message = '<script>alert("Fiets is gewijzigd"); window.location.href="index.php";</script>';
        } else {
            $message = '<script>alert("Fiets is NIET gewijzigd");</script>';
        }
    } catch (Exception $e) {
        $message = '<script>alert("Fout: ' . $e->getMessage() . '");</script>';
    }
}

// Check of id is meegegeven in URL
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $fietsData = $db->getRecord($id);
    
    if ($fietsData) {
        $fiets = new CrudFietsOOP\Fiets($fietsData);
    } else {
        $message = '<script>alert("Fiets niet gevonden"); window.location.href="index.php";</script>';
    }
} else {
    $message = '<script>alert("Geen id opgegeven"); window.location.href="index.php";</script>';
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijzig Fiets</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?= $message ?>
    
    <h2>Wijzig Fiets</h2>
    
    <?php if ($fiets): ?>
    <form method="post">
        <input type="hidden" name="id" value="<?= $fiets->getId() ?>">
        
        <label for="merk">Merk:</label>
        <input type="text" id="merk" name="merk" required value="<?= htmlspecialchars($fiets->getMerk()) ?>"><br>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required value="<?= htmlspecialchars($fiets->getType()) ?>"><br>

        <label for="prijs">Prijs:</label>
        <input type="number" step="0.01" id="prijs" name="prijs" required value="<?= $fiets->getPrijs() ?>"><br>

        <label for="foto">Foto:</label>
        <input type="text" id="foto" name="foto" value="<?= htmlspecialchars($fiets->getFoto()) ?>"><br>

        <button type="submit" name="btn_wzg">Wijzig</button>
    </form>
    <?php endif; ?>
    
    <br><br>
    <a href='index.php'>Home</a>
</body>
</html>

