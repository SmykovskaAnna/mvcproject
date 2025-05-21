<?php include __DIR__ . '/layout/header.php'; ?>

<h2 class="mb-4">✏️ Edit category</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" class="card p-4 shadow-sm bg-white">
    <div class="mb-3">
        <label for="name" class="form-label">Category name</label>
        <input type="text" name="name" id="name" class="form-control" required
               value="<?= htmlspecialchars($category['name']) ?>">
    </div>

    <button type="submit" class="btn btn-primary">💾 Save changes</button><br>
    <a href="index.php?action=category_list" class="btn btn-outline-secondary ms-2">← Back to list</a>
</form>

<?php include __DIR__ . '/layout/footer.php'; ?>
