<?php include __DIR__ . '/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-4 text-center">➕ Add category</h2>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category name</label>
                        <input type="text" name="name" id="name" class="form-control" required
                               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Add</button>
                </form>

                <div class="text-center mt-3">
                    <a href="index.php?action=category_list" class="btn btn-outline-secondary btn-sm">← Back to list</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>