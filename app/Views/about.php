<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About POS System</title>
    <style>
        * { box-sizing: border-box; font-family: system-ui, -apple-system, sans-serif; }
        body { background:#f4f6f9; padding:20px; color:#333; }
        .navbar { background:#2c3e50; border-radius:6px; padding:12px 20px; margin-bottom:25px; display:flex; gap:20px; }
        .navbar a { color:#fff; text-decoration:none; font-weight:bold; }
        .card { max-width:800px; margin:auto; background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:30px; }
        h1 { color:#1a202c; margin-bottom:15px; }
        p { line-height:1.7; color:#4a5568; }
    </style>
</head>
<body>
    <nav class="navbar">
    <a href="<?= site_url('/') ?>">Home</a>
    <a href="<?= site_url('about') ?>">About</a>
    <a href="<?= site_url('customers') ?>">Customer Accounts</a>
    <a href="<?= site_url('users') ?>">User Accounts</a>
</nav>
    <div class="card">
        <h1>About the POS System</h1>
        <p>This CodeIgniter 4 POS prototype demonstrates customer and user account management, form validation, editing workflows, and profile avatar uploads.</p>
        <p>This hosted classroom demonstration stores its sample records in a temporary file-based store so the pages can be demonstrated without an online MySQL database.</p>
    </div>
</body>
</html>
