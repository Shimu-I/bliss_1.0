<?php
// Include the database connection
include 'config.php';

if (isset($_POST['query'])) {
    $search_query = htmlspecialchars($_POST['query']);

    try {
        // Prepare the query
        if (!empty($search_query)) {
            $stmt = $conn->prepare("
                SELECT * 
                FROM `caregiver` 
                WHERE `name` LIKE :query
            ");
            $stmt->execute([':query' => $search_query . '%']);
        } else {
            $stmt = $conn->prepare("SELECT * FROM `caregiver`");
            $stmt->execute();
        }

        // Generate HTML for the results
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box">
                    <h3><?= htmlspecialchars($row['name']); ?></h3>
                    <p>Qualification: <?= htmlspecialchars($row['qualification']); ?></p>
                    <p>Experience: <?= htmlspecialchars($row['experience']); ?> years</p>
                    <p>Special Training: <?= htmlspecialchars($row['special_training']); ?></p>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">No caregivers found!</p>';
        }
    } catch (Exception $e) {
        echo '<p class="error">Error fetching caregivers: ' . $e->getMessage() . '</p>';
    }
}
?>
