<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LGA Total Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Summed Total Results by LGA</h2>

        <!-- LGA Selection Form -->
        <form id="lgaForm" class="mb-5">
            <div class="mb-3">
                <label for="lga_select" class="form-label">Select Local Government Area (LGA):</label>
                <select id="lga_select" class="form-select" required>
                    <option value="">-- Select LGA --</option>
                    <?php
                    // Database connection
                    $conn = new mysqli('localhost', 'root', '', 'bincom_test');
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch all LGAs from Delta State (state_id = 25)
                    $sql = "SELECT lga_id, lga_name FROM lga WHERE state_id = 25";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output each LGA as an option
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['lga_id'] . "'>" . $row['lga_name'] . "</option>";
                        }
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Get Summed Results</button>
        </form>

        <!-- Results Display -->
        <div id="results"></div>
    </div>

    <script>
        // JavaScript to handle form submission and fetch results
        document.getElementById('lgaForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const lgaId = document.getElementById('lga_select').value;

            if (lgaId) {
                fetch(`./step2.backend.php?lga_id=${lgaId}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('results').innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error fetching results:', error);
                    });
            } else {
                alert("Please select an LGA.");
            }
        });
    </script>
</body>
</html>
