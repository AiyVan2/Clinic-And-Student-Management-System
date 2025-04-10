<?php
require_once '../Config/db.php';
$result = $conn->query("SELECT record_id, student_id, first_name, last_name FROM student_health_records");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Health Records</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        a.button {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            background-color: #2e8b57;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0; top: 0;
            width: 100%; height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            width: 60%;
            border-radius: 10px;
        }

        .close {
            color: red;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Student Health Records</h2>

<a class="button" href="add_student_health_record.html">+ Add New Record</a>

<table>
    <tr>
        <th>Student ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['student_id']) ?></td>
        <td><?= htmlspecialchars($row['first_name']) ?></td>
        <td><?= htmlspecialchars($row['last_name']) ?></td>
        <td>
            <button onclick="viewRecord(<?= $row['record_id'] ?>)">View</button>
            |
            <a href="update_health_record_form.php?id=<?= $row['record_id'] ?>">Update</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- Modal -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('viewModal').style.display='none'">&times;</span>
        <div id="modalDetails">
            <!-- Record details go here -->
        </div>
    </div>
</div>

<script>
function viewRecord(recordId) {
    fetch('../Controllers/fetch_health_record.php?id=' + recordId)
        .then(response => response.text())
        .then(data => {
            document.getElementById('modalDetails').innerHTML = data;
            document.getElementById('viewModal').style.display = 'block';
        });
}

// Close modal on outside click
window.onclick = function(event) {
    const modal = document.getElementById('viewModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
