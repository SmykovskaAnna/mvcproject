<?php include __DIR__ . '/layout/header.php'; ?>

<div class="row">
    <div class="col-md-3">
        <form method="post" action="index.php?action=search" class="mb-4">
            <div class="input-group">
                <input type="text" name="term" class="form-control" placeholder="🔍 Task search">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <h5 class="fw-bold">Categories</h5>
        <div class="list-group mb-4">
            <a href="index.php?action=tasks" class="list-group-item list-group-item-action <?= empty($_GET['category_id']) ? 'active' : '' ?>">All</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="index.php?action=tasks&category_id=<?= $cat['id'] ?>"
                    class="list-group-item list-group-item-action <?= (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'active' : '' ?>">
                        <?= htmlspecialchars($cat['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold">Task progress</h6>

                <small>Completed</small>
                <div class="progress mb-2">
                    <div class="progress-bar bg-primary" style="width: <?= $donePercent ?>%"></div>
                </div>

                <small>In progress</small>
                <div class="progress mb-2">
                    <div class="progress-bar bg-warning" style="width: <?= $inProgressPercent ?>%"></div>
                </div>

                <small>Progress</small>
                <div class="progress">
                    <div class="progress-bar bg-secondary" style="width: <?= $todoPercent ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Your tasks</h4>
            <div>
                <a href="index.php?action=add_task" class="btn btn-primary btn-sm">+ Add</a>
                <a href="index.php?action=report" class="btn btn-outline-secondary btn-sm">Report</a>
                <a href="index.php?action=export_csv" class="btn btn-outline-success btn-sm">Export CSV</a>
                <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>

        <?php if (empty($tasks)): ?>
            <div class="alert alert-info">No tasks yet</div>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($tasks as $task): ?>
                    <li class="list-group-item">
                        <div>
                            <div class="fw-bold"><?= htmlspecialchars($task['title']) ?></div>
                            <div class="text-muted small mb-2">
                                    <?= htmlspecialchars($task['description']) ?><br>
                                    Category: <?= htmlspecialchars($task['category_name'] ?? '—') ?> |
                                    Priority: <?= htmlspecialchars($task['priority']) ?> |
                                    Status: <?= htmlspecialchars($task['status']) ?> |
                                    Date: <?= htmlspecialchars($task['due_date'] ?: '—') ?>
                            </div>
                            <div class="d-flex flex-wrap gap-1">
                                <a href="index.php?action=edit_task&id=<?= $task['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <?php if ($task['status'] != 'todo'): ?>
                                    <a href="index.php?action=setStatus&id=<?= $task['id'] ?>&status=todo" class="btn btn-sm btn-outline-secondary">Todo</a>
                                <?php endif; ?>
                                <?php if ($task['status'] != 'in_progress'): ?>
                                    <a href="index.php?action=setStatus&id=<?= $task['id'] ?>&status=in_progress" class="btn btn-sm btn-outline-info">In progress</a>
                                <?php endif; ?>
                                <?php if ($task['status'] != 'done'): ?>
                                    <a href="index.php?action=setStatus&id=<?= $task['id'] ?>&status=done" class="btn btn-sm btn-outline-success">Done</a>
                                <?php endif; ?>
                                <a href="index.php?action=task_delete&id=<?= $task['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete task?')">Delete</a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>