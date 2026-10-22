<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <style>
        * { box-sizing:border-box; font-family:system-ui, -apple-system, sans-serif; }
        body { background:#f4f6f9; padding:20px; color:#333; }
        .navbar { background:#2c3e50; border-radius:6px; padding:12px 20px; margin-bottom:25px; display:flex; gap:20px; }
        .navbar a { color:#fff; text-decoration:none; font-weight:bold; font-size:15px; }
        .card { max-width:650px; margin:auto; background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:30px; box-shadow:0 1px 3px rgba(0,0,0,.05); }
        h1 { color:#1a202c; margin-bottom:20px; }
        label { display:block; font-weight:600; margin-top:15px; margin-bottom:6px; }
        input { width:100%; padding:10px; border:1px solid #cbd5e0; border-radius:5px; font-size:15px; }
        .help { color:#64748b; font-size:13px; margin-top:5px; } .error { color:#b91c1c; font-size:13px; margin-top:5px; }
        button, .cancel { display:inline-block; margin-top:22px; padding:10px 16px; border:0; border-radius:5px; text-decoration:none; font-size:15px; cursor:pointer; }
        button { background:#2c3e50; color:#fff; } .cancel { background:#e2e8f0; color:#333; margin-left:8px; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="<?= site_url('/') ?>">Home</a>
        <a href="<?= site_url('customers') ?>">Customer Accounts</a>
        <a href="<?= site_url('users') ?>">User Accounts</a>
    </nav>
    <div class="card">
        <h1><?= esc($title) ?></h1>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="error"><?= esc(implode(' ', session()->getFlashdata('errors'))) ?></div>
        <?php endif; ?>
        <form action="<?= esc($action) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <label for="username">Username</label>
            <input id="username" name="username" value="<?= esc($user['username'] ?? old('username')) ?>" required>
            <?php if (validation_show_error('username')): ?><div class="error"><?= esc(validation_show_error('username')) ?></div><?php endif; ?>

            <label for="full_name">Full Name</label>
            <input id="full_name" name="full_name" value="<?= esc($user['full_name'] ?? old('full_name')) ?>" required>
            <?php if (validation_show_error('full_name')): ?><div class="error"><?= esc(validation_show_error('full_name')) ?></div><?php endif; ?>

            <label for="avatar">Profile Picture</label>
            <input id="avatar" type="file" name="avatar" accept="image/jpeg,image/png">
            <div class="help">Optional. JPG or PNG only, maximum 2 MB. A square thumbnail will be prepared automatically.</div>
            <?php if (validation_show_error('avatar')): ?><div class="error"><?= esc(validation_show_error('avatar')) ?></div><?php endif; ?>

            <button type="submit">Save User</button>
            <a class="cancel" href="<?= site_url('users') ?>">Cancel</a>
        </form>
    </div>
</body>
</html>
