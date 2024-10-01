<?php
require "./db.php";
$sql = "SELECT DISTINCT partyname FROM party";
$result = $conn->query($sql);

$parties = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $parties[] = $row['partyname'];
    }
}

echo json_encode($parties);

$conn->close();
