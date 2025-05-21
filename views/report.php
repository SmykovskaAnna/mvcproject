<?php include __DIR__ . '/layout/header.php'; ?>

<h2 class="mb-4">📊 Task report</h2>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Number of tasks by status</div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Todo (todo)</span>
                        <span class="badge bg-secondary"><?= $statusCounts['todo'] ?? 0 ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>In progress (in_progress)</span>
                        <span class="badge bg-warning text-dark"><?= $statusCounts['in_progress'] ?? 0 ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Done (done)</span>
                        <span class="badge bg-success"><?= $statusCounts['done'] ?? 0 ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">Overdue tasks</div>
            <div class="card-body">
                <p class="h5"><?= $overdueCount ?> task(s)</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white">Statistics by category</div>
    <div class="card-body">
        <?php if (!empty($categorySummary)): ?>
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Category</th>
                        <th>Total tasks</th>
                        <th>Done</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorySummary as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= $row['total'] ?></td>
                            <td><?= $row['done'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>There are no categories yet.</p>
        <?php endif; ?>
    </div>
</div>

<a href="index.php?action=tasks" class="btn btn-outline-primary">← Back to tasks</a>

<?php include __DIR__ . '/layout/footer.php'; ?>