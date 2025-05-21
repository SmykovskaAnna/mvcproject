<?php include __DIR__ . '/layout/header.php'; ?>

<h2 class="mb-4 text-danger">🗑️ Delete category</h2>

<div class="card p-4 shadow-sm bg-white">
    <p>Are you sure you want to delete the category <strong><?= htmlspecialchars($category['name']) ?></strong>?</p>

    <div class="alert alert-warning">
        All tasks in this category will become uncategorized.
    </div>

    <form method="post">
        <button type="submit" class="btn btn-danger">Yes, delete</button>
        <a href="index.php?action=category_list" class="btn btn-outline-secondary ms-2">Cancel</a>
    </form>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>
