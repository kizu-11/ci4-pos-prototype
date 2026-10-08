<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Accounts Directory</title>
    <style>
        * { box-sizing: border-box; font-family: system-ui, -apple-system, sans-serif; margin: 0; padding: 0; }
        body { background-color: #f4f6f9; padding: 20px; color: #333; }
        .navbar { background-color: #2c3e50; border-radius: 6px; padding: 12px 20px; margin-bottom: 25px; display: flex; gap: 20px; }
        .navbar a { color: #ffffff; text-decoration: none; font-weight: bold; font-size: 15px; }
        .navbar a:hover { text-decoration: underline; }
        .card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        h1 { font-size: 26px; font-weight: 700; margin-bottom: 10px; color: #1a202c; }
        .subtitle { color: #4a5568; font-size: 14px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; border: 1px solid #e2e8f0; }
        th { background-color: #34495e; color: #ffffff; text-align: left; padding: 12px 15px; font-size: 14px; }
        td { padding: 12px 15px; border-top: 1px solid #e2e8f0; font-size: 14px; color: #2d3748; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .footer { text-align: center; margin-top: 30px; color: #a0aec0; font-size: 13px; }
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
        <h1>Customer Accounts Directory</h1>
        <p class="subtitle">Listing of registered store customers (Data Source: MySQL Database via CustomerModel):</p>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?= esc($customer['id']) ?></td>
                            <td><?= esc($customer['full_name']) ?></td>
                            <td><?= esc($customer['email']) ?></td>
                            <td><?= esc($customer['phone']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">No customer records found.</td>
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