<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fietsenmaker CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    // Autoloading via Composer
    require_once __DIR__ . '/../vendor/autoload.php';

    // Of zonder Composer (handmatige includes):
    // require_once __DIR__ . '/classes/DatabaseManager.php';
    // require_once __DIR__ . '/classes/Fiets.php';

    // Gebruik de classes met volledige namespace
    $db = new CrudFietsOOP\DatabaseManager();

    // Haal alle fietsen op
    $fietsenData = $db->getData();
    ?>

    <h1>Crud Fietsen</h1>
    <nav>
        <a href='insert.php'>Toevoegen nieuwe fiets</a>
    </nav><br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Merk</th>
                <th>Type</th>
                <th>Prijs</th>
                <th>Foto</th>
                <th colspan="2">Actie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fietsenData as $fietsData): 
                $fiets = new CrudFietsOOP\Fiets($fietsData);
            ?>
            <tr>
                <td><?= htmlspecialchars($fiets->getId()) ?></td>
                <td><?= htmlspecialchars($fiets->getMerk()) ?></td>
                <td><?= htmlspecialchars($fiets->getType()) ?></td>
                <td>€ <?= number_format($fiets->getPrijs(), 2, ',', '.') ?></td>
                <td><?= htmlspecialchars($fiets->getFoto()) ?></td>
                <td>
                    <form method="post" action="update.php?id=<?= $fiets->getId() ?>">
                        <button type="submit">Wzg</button>
                    </form>
                </td>
                <td>
                    <form method="post" action="delete.php?id=<?= $fiets->getId() ?>" 
                          onsubmit="return confirm('Weet je zeker dat je deze fiets wilt verwijderen?');">
                        <button type="submit">Verwijder</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>



