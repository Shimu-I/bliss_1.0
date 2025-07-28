<?php
session_start();

require_once 'config.php';

// Get the logged-in user's ID

// Calculate age function
function calculate_age($date_of_birth)
{
    $dob = new DateTime($date_of_birth);
    $today = new DateTime();
    $age = $today->diff($dob)->y; // Get the difference in years
    return $age;
}


$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php"); // Adjust the path to your login page
    exit();
}


try {
    // Fetch parent details
    $query = "SELECT name, email, contact_info, profile_image FROM users WHERE user_id = :user_id AND role = 'Parent'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $parent = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$parent) {
        echo "<script>alert('Parent not found!'); window.location.href = 'index.php';</script>";
        exit();
    }

    // Fetch children details linked to the parent
    $query_children = "
        SELECT child.child_id, child.name, child.date_of_birth, caregivers.name AS caregiver_name
        FROM child
        LEFT JOIN child_caregiver ON child.child_id = child_caregiver.child_id
        LEFT JOIN caregivers ON child_caregiver.caregiver_id = caregivers.caregiver_id
        WHERE child.user_id = :user_id";
    $stmt = $conn->prepare($query_children);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $children = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch billing information
    $query_bills = "SELECT * FROM bill_payment WHERE user_id = :user_id";
    $stmt = $conn->prepare($query_bills);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $bills = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch notifications
    $query_notifications = "SELECT * FROM notification WHERE user_id = :user_id AND status = 'Unread'";
    $stmt = $conn->prepare($query_notifications);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Profile</title>
    <link rel="stylesheet" href="assets/css/parent_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Modal Styles */
        #notification-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            border-radius: 10px;
            z-index: 1000;
        }

        #notification-modal .close {
            float: right;
            font-size: 1.5rem;
            cursor: pointer;
        }

        #notification-modal ul {
            list-style: none;
            padding: 0;
        }

        #notification-modal ul li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        #notification-modal ul li:last-child {
            border-bottom: none;
        }

        #notification-modal h3 {
            margin-top: 0;
        }

        /* Modal Overlay */
        #modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="parent-profile">
        <h1 class="heading">Welcome, <span style="color:#e9768f"> <?= htmlspecialchars($parent['name']); ?>! </span> </h1>

        <!-- Parent Information -->
        <div class="profile-details">
            <div class="parent-info" style="text-align: center;">
                <img src="<?= !empty($parent['profile_image']) ? 'uploaded_files/' . htmlspecialchars($parent['profile_image']) : 'assets/images/default-avatar.jpg'; ?>"
                    alt="<?= htmlspecialchars($parent['name']); ?>" />
                <h2><?= htmlspecialchars($parent['name']); ?></h2>
                <p><strong>Email:</strong> <?= htmlspecialchars($parent['email']); ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($parent['contact_info'] ?: 'N/A'); ?></p>
            </div>
        </div>

        <!-- Notification Modal -->
        <div id="modal-overlay"></div>
        <div id="notification-modal">
            <span class="close">&times;</span>
            <h3>Unread Notifications</h3>
            <?php if (!empty($notifications)) { ?>
                <ul>
                    <?php foreach ($notifications as $notification) { ?>
                        <li><?= htmlspecialchars($notification['message']); ?></li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>No new notifications.</p>
            <?php } ?>
        </div>

        <!-- Children Information -->
        <div class="children-info">
            <h2>Your Children</h2>




            <?php if (!empty($children)) { ?>
                <div class="children-list">
                    <?php foreach ($children as $child) { ?>
                        <div class="child-card">
                            <h3><?= htmlspecialchars($child['name']); ?></h3>
                            <p><strong>Child ID:</strong> <?= htmlspecialchars($child['child_id']); ?></p>
                            <p><strong>Age:</strong> <?= calculate_age($child['date_of_birth']); ?> years old</p> <!-- Display age here -->

                            <p><strong>Date of Birth:</strong> <?= htmlspecialchars($child['date_of_birth']); ?></p>
                            <p><strong>Assigned Caregiver:</strong> <?= htmlspecialchars($child['caregiver_name'] ?: 'Not Assigned'); ?></p>
                            <a href="child_profile.php?child_id=<?= htmlspecialchars($child['child_id']); ?>" class="btn">View Full Profile</a>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p>No children registered under your account.</p>

            <?php } ?>

            <div class="button-container">
                <a href="child_registration.php" class="register-child-btn">Register Your Child</a>

                <!-- 
                                <a href="delete_child.php?child_id=<?= htmlspecialchars($child['child_id']); ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this child?')">Delete</a>
                                <a href="update_child.php?child_id=<?= htmlspecialchars($child['child_id']); ?>" class="update-btn">Update</a>

            -->

            </div>


        </div>

        <!-- Billing Information -->
        <div class="billing-info">
            <h2>Billing Information</h2>
            <?php if (!empty($bills)) { ?>
                <div class="billing-list">
                    <?php foreach ($bills as $bill) { ?>
                        <div class="bill-card">
                            <h3>Billing Record</h3>
                            <p><strong>Section Type:</strong> <?= htmlspecialchars($bill['section_type']); ?></p>
                            <p><strong>Section Description:</strong> <?= htmlspecialchars($bill['section_description']); ?></p>
                            <p><strong>Total Amount:</strong> $<?= htmlspecialchars($bill['total_amount']); ?></p>
                            <p><strong>Due Date:</strong> <?= htmlspecialchars($bill['payment_date']); ?></p>
                            <p><strong>Status:</strong> <?= htmlspecialchars($bill['payment_status']); ?></p>
                            <a href="pay.php?child_id=<?= isset($child['child_id']) ? htmlspecialchars($child['child_id']) : ''; ?>" class="btn">Pay Now</a>

                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p>No billing records found.</p>
            <?php } ?>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('notification-modal');
            const overlay = document.getElementById('modal-overlay');
            const closeModal = modal.querySelector('.close');

            // Open modal on notification icon click
            document.addEventListener('click', function(e) {
                if (e.target.id === 'notification-icon') {
                    modal.style.display = 'block';
                    overlay.style.display = 'block';
                }
            });

            // Close modal on close button click or clicking outside
            closeModal.addEventListener('click', function() {
                modal.style.display = 'none';
                overlay.style.display = 'none';
            });
            overlay.addEventListener('click', function() {
                modal.style.display = 'none';
                overlay.style.display = 'none';
            });
        });
    </script>



</body>

</html>