<?php
$dbs = ['mvc_programa', 'mvc_db', 'mvccc'];
foreach ($dbs as $dbn) {
    echo "Trying $dbn...\n";
    try {
        $db = new PDO("mysql:host=localhost;dbname=$dbn", 'root', '');
        echo "Connected to $dbn!\n";
        $stmt = $db->query("DESCRIBE instructor");
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        echo $e->getMessage() . "\n";
    }
}
