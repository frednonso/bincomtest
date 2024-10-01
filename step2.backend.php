<?php
require "./db.php";
// Check if an LGA ID was passed
if (isset($_GET['lga_id'])) {
    $lga_id = intval($_GET['lga_id']); // Sanitize input

    // Fetch the summed total of results for all polling units under the selected LGA
    $sql = "
        SELECT pr.party_abbreviation, SUM(pr.party_score) AS total_score
        FROM announced_pu_results pr
        JOIN polling_unit pu ON pr.polling_unit_uniqueid = pu.uniqueid
        WHERE pu.lga_id = ?
        GROUP BY pr.party_abbreviation";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lga_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display results in a table
    if ($result->num_rows > 0) {
        echo "<h3>Summed Total Results for LGA</h3>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Party</th><th>Total Score</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['party_abbreviation'] . "</td><td>" . $row['total_score'] . "</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "No results found for this LGA.";
    }
} else {
    echo "No LGA selected.";
}

$conn->close();
