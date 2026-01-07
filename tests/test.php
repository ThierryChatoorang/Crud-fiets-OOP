# Maak een test bestand: test.php
<?php
require_once __DIR__ . '/vendor/autoload.php';

$fiets = new CrudFietsOOP\Fiets(['merk' => 'Test']);
echo $fiets->getMerk(); // Zou "Test" moeten printen