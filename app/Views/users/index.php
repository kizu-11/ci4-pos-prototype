<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System User & Staff Accounts</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f4f6f9;
            padding: 20px;
            color: #333;
        }

        .navbar {
            background-color: #2c3e50;
            border-radius: 6px;
            padding: 12px 20px;
            margin-bottom: 25px;
            display: flex;
            gap: 20px;
        }

        .navbar a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            font-size: 15px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1a202c;
        }

        .subtitle {
            color: #4a5568;
            font-size: 14px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e2e8f0;
        }

        th {
            background-color: #34495e;
            color: #ffffff;
            text-align: left;
            padding: 12px 15px;
            font-size: 14px;
        }

        td {
            padding: 12px 15px;
            border-top: 1px solid #e2e8f0;
            font-size: 14px;
            color: #2d3748;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #a0aec0;
            font-size: 13px;
        }

        .avatar {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 50%;
            vertical-align: middle;
        }
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
        <h1>System User & Staff Accounts</h1>

        <p class="subtitle">
            Listing of authorized system operators
            (Data Source: MySQL Database):
        </p>

        <?php if (session()->getFlashdata('success')): ?>
            <p style="background:#dcfce7;color:#166534;padding:10px;margin-bottom:15px;border-radius:5px;">
                <?= esc(session()->getFlashdata('success')) ?>
            </p>
        <?php endif; ?>

        <p style="margin-bottom:15px;">
            <a href="<?= site_url('users/new') ?>">+ Add New User</a>
        </p>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Avatar</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($users)): ?>

                    <?php foreach ($users as $user): ?>

                        <?php
                        $avatarFile = !empty($user['avatar'])
                            ? basename($user['avatar'])
                            : 'placeholder.svg';

                        $avatarPath = FCPATH . 'uploads/avatars/' . $avatarFile;

                        $avatarUrl = is_file($avatarPath)
                            ? base_url('uploads/avatars/' . $avatarFile)
                            : base_url('uploads/avatars/placeholder.svg');
                        ?>

                        <tr>
                            <td><?= esc($user['id']) ?></td>

                            <td><?= esc($user['username']) ?></td>

                            <td><?= esc($user['full_name']) ?></td>

                            <td>
                                <img
                                    class="avatar"
                                    src="<?= esc($avatarUrl) ?>"
                                    alt="Avatar for <?= esc($user['full_name']) ?>"
                                >
                            </td>

                            <td>
                                <a href="<?= site_url('users/edit/' . $user['id']) ?>">
                                    Edit
                                </a>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="5" style="text-align: center;">
                            No user records found.
                        </td>
                    </tr>

                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        &copy; 2026 POS System Prototype. Built with CodeIgniter 4.
    </div>

</body>
</html>