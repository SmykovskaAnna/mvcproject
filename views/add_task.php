<?php include __DIR__ . '/layout/header.php'; ?>

<h2 class="mb-4">Add task</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" class="card p-4 shadow-sm bg-white">
    <div class="mb-3">
        <label for="title" class="form-label">Name</label>
        <input type="text" name="title" id="title" class="form-control" required value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" id="category_id" class="form-select">
            <option value="">-- Uncategorized --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="priority" class="form-label">Priority</label>
        <select name="priority" id="priority" class="form-select">
            <option value="low">Low</option>
            <option value="medium" selected>Medium</option>
            <option value="high">High</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="due_date" class="form-label">Deadline</label>
        <input type="datetime-local" name="due_date" id="due_date" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>

<?php include __DIR__ . '/layout/footer.php'; ?>