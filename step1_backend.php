<?php

require "./db.php";
// Check if a polling unit ID was passed
if (isset($_GET['polling_unit_id'])) {
    $polling_unit_id = intval($_GET['polling_unit_id']); // Sanitize the input

    // Fetch results for the selected polling unit
    $sql = "SELECT pu.polling_unit_name, pr.party_abbreviation, pr.party_score
            FROM announced_pu_results pr
            JOIN polling_unit pu ON pu.uniqueid = pr.polling_unit_uniqueid
            WHERE pu.uniqueid = ? AND pu.lga_id IN (SELECT lga_id FROM lga WHERE state_id = 25)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $polling_unit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display results in a table
    if ($result->num_rows > 0) {
        echo "<h3>Results for Polling Unit: </h3>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Party</th><th>Score</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['party_abbreviation'] . "</td><td>" . $row['party_score'] . "</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "No results found for this polling unit.";
    }
} else {
    echo "No polling unit selected.";
}

$conn->close();


