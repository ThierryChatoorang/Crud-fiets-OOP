<?php
// Autoloading via Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Of zonder Composer (handmatige includes):
// require_once __DIR__ . '/classes/DatabaseManager.php';
// require_once __DIR__ . '/classes/Fiets.php';

$db = new CrudFietsOOP\DatabaseManager();

// Check of id is meegegeven
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Verwijder fiets
    if ($db->deleteRecord($id)) {
        echo '<script>alert("Fietscode: ' . $id . ' is verwijderd"); window.location.href="index.php";</script>';
    } else {
        echo '<script>alert("Fiets is NIET verwijderd"); window.location.href="index.php";</script>';
    }
} else {
    echo '<script>alert("Geen id opgegeven"); window.location.href="index.php";</script>';
}
?>

