<?php
require "./db.php";
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // form data
    $polling_unit_name = $_POST['polling_unit_name'];
    $polling_unit_id = $_POST['polling_unit_id'];
    $party_results = $_POST['party_results'];  //an associative array for party results

    // Insert the new polling unit (if not already present)
    $sql_insert_pu = "INSERT INTO polling_unit (uniqueid, polling_unit_name) VALUES (?, ?)";
    $stmt_pu = $conn->prepare($sql_insert_pu);
    $stmt_pu->bind_param("is", $polling_unit_id, $polling_unit_name);

    if ($stmt_pu->execute()) {
        // Insert the party results into `announced_pu_results`
        $sql_insert_results = "INSERT INTO announced_pu_results (polling_unit_uniqueid, party_abbreviation, party_score) VALUES (?, ?, ?)";
        $stmt_results = $conn->prepare($sql_insert_results);

        foreach ($party_results as $party => $score) {
            $stmt_results->bind_param("isi", $polling_unit_id, $party, $score);
            $stmt_results->execute();
        }

        echo "Results successfully stored for polling unit '$polling_unit_name'....click <a href='./step3_frontend.php'>here to go back</a>";
    } else {
        echo "Error storing polling unit: " . $conn->error;
    }

    $stmt_pu->close();
    $stmt_results->close();
}

$conn->close();

