<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polling Unit Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Polling Unit Results</h2>

        <!-- Polling Unit Selection Form -->
        <form id="pollingUnitForm" class="mb-5">
            <div class="mb-3">
                <label for="polling_unit" class="form-label">Select Polling Unit:</label>
                <select id="polling_unit" class="form-select" required>
                    <option value="">-- Select Polling Unit --</option>
                    <?php
                    require "./db.php";

                    // Fetch polling units from Delta State (state_id = 25)
                    $sql = "SELECT uniqueid, polling_unit_name FROM polling_unit WHERE lga_id IN (SELECT lga_id FROM lga WHERE state_id = 25)";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output each polling unit as an option
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['uniqueid'] . "'>" . $row['polling_unit_name'] . "</option>";
                        }
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Get Results</button>
        </form>

        <!-- Results Display -->
        <div id="results"></div>
    </div>

    <script>
        // JavaScript to handle form submission and fetch results
        document.getElementById('pollingUnitForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const pollingUnitId = document.getElementById('polling_unit').value;

            if (pollingUnitId) {
                fetch(`./step1_backend.php?polling_unit_id=${pollingUnitId}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('results').innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error fetching results:', error);
                    });
            } else {
                alert("Please select a polling unit.");
            }
        });
    </script>
</body>
</html>
