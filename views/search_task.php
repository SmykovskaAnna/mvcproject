<?php include __DIR__ . '/layout/header.php'; ?>

<h2 class="mb-4">Task search</h2>

<form method="post" class="card p-4 shadow-sm bg-white mb-4">
    <div class="row g-3">
        <div class="col-md-4">
            <input type="text" name="term" placeholder="Keyword" value="<?= htmlspecialchars($term) ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-select">
                <option value="">All categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $categoryId == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="priority" class="form-select">
                <option value="">Any priority</option>
                <option value="low" <?= $priority === 'low' ? 'selected' : '' ?>>Low</option>
                <option value="medium" <?= $priority === 'medium' ? 'selected' : '' ?>>Medium</option>
                <option value="high" <?= $priority === 'high' ? 'selected' : '' ?>>High</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Any status</option>
                <option value="todo" <?= $status === 'todo' ? 'selected' : '' ?>>Todo</option>
                <option value="in_progress" <?= $status === 'in_progress' ? 'selected' : '' ?>>In progress</option>
                <option value="done" <?= $status === 'done' ? 'selected' : '' ?>>Done</option>
            </select>
        </div>
        <div class="col-md-1 d-grid">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>

<?php if (!empty($results)): ?>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Deadline</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['title']) ?></td>
                    <td><?= htmlspecialchars($task['category_name']) ?></td>
                    <td><?= htmlspecialchars($task['priority']) ?></td>
                    <td><?= htmlspecialchars($task['status']) ?></td>
                    <td><?= htmlspecialchars($task['due_date']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <div class="alert alert-info">Nothing found for these criteria.</div>
<?php endif; ?>

<?php include __DIR__ . '/layout/footer.php'; ?>