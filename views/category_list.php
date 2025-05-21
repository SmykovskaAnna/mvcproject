<?php include __DIR__ . '/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">📂 Your categories</h2>
    <div>
        <a href="index.php?action=add_category" class="btn btn-primary btn-sm">+ Add category</a>
        <a href="index.php?action=add_task" class="btn btn-outline-primary btn-sm">+ Add task</a>
        <a href="index.php?action=tasks" class="btn btn-outline-secondary btn-sm">Tasks</a>
        <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm">Go out</a>
    </div>
</div>

<?php if (empty($categories)): ?>
    <div class="alert alert-info">There are no categories yet. Add the first one!</div>
<?php else: ?>
    <ul class="list-group">
<?php foreach ($categories as $cat): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <?= htmlspecialchars($cat['name']) ?>
            <span class="badge bg-primary rounded-pill"><?= $cat['task_count'] ?></span>
        </div>
        <div>
            <a href="index.php?action=category_edit&id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-warning me-1">✏️ Edit</a>
            <a href="index.php?action=category_delete&id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this category?');">🗑️ Delete</a>
        </div>
    </li>
<?php endforeach; ?>
</ul>


<?php endif; ?>

<?php include __DIR__ . '/layout/footer.php'; ?>