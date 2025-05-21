<?php include __DIR__ . '/layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-3">👤 Profile</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Welcome, <strong><?= htmlspecialchars($username) ?></strong>!</h5>
            <p class="card-text">Here is a quick summary of your tasks:</p>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between">
                    <span>✅ Completed tasks:</span> <span><?= $done ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>🕗 In progress:</span> <span><?= $inProgress ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>📋 To do:</span> <span><?= $todo ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Total tasks:</strong> <strong><?= $total ?></strong>
                </li>
            </ul>
        </div>
    </div>

    <a href="index.php?action=tasks" class="btn btn-outline-primary">← Back to tasks</a>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>