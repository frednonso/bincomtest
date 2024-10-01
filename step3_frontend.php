<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Polling Unit Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Store Polling Unit Results</h2>

        <!-- Form to input polling unit and party results -->
        <form id="pollingUnitForm" action="./step3_backend.php" method="POST">
            <!-- Polling Unit Details -->
            <div class="mb-3">
                <label for="polling_unit_name" class="form-label">Polling Unit Name</label>
                <input type="text" class="form-control" id="polling_unit_name" name="polling_unit_name" required>
            </div>
            <div class="mb-3">
                <label for="polling_unit_id" class="form-label">Polling Unit Unique ID</label>
                <input type="number" class="form-control" id="polling_unit_id" name="polling_unit_id" required>
            </div>

            <!-- Party Results -->
            <h4>Enter Party Results</h4>
            <div id="partyResults" class="row">
                <!-- Party result inputs will be  generated here from the fetch in the javascript file -->
            </div>

            <button type="submit" class="btn btn-primary mt-4">Submit Results</button>
        </form>

    
    </div>

    <script>
        // Fetch the parties dynamically from the server
        fetch('./step3_fetch_parties.php')
        .then(response => response.json())
        .then(data => {
            const partyResultsDiv = document.getElementById('partyResults');
            data.forEach(party => {
                // Create input fields dynamically for each party
                const colDiv = document.createElement('div');
                colDiv.className = 'col-md-6';
                colDiv.innerHTML = `
                    <label for="party_${party}" class="form-label">${party}</label>
                    <input type="number" class="form-control" id="party_${party}" name="party_results[${party}]" required>
                `;
                partyResultsDiv.appendChild(colDiv);
            });
        });
    </script>
</body>
</html>
