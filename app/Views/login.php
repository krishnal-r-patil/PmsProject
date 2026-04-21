<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Panchayat Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.1), transparent 50%),
                        radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.1), transparent 50%);
        }

        .login-container {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 450px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            color: #1e293b;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #64748b;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #334155;
            font-weight: 500;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #2563eb;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            transform: translateY(-2px);
        }

        .error-msg {
            color: #ef4444;
            text-align: center;
            margin-bottom: 1rem;
            background: #fef2f2;
            padding: 0.5rem;
            border-radius: 5px;
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #64748b;
            text-decoration: none;
        }
        
        .back-link:hover {
            color: #2563eb;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h2>E-Panchayat</h2>
            <p>Sign in to access your dashboard</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="error-msg">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/process') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="email">Email / ID</label>
                <input type="email" id="email" name="email" required placeholder="Enter admin@panchayat.com or user@panchayat.com">
            </div>

            <div class="form-group" style="position: relative;">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="admin123 or user123">
                <div style="margin-top: 8px; display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #64748b;">
                    <input type="checkbox" id="showPassword" style="width: auto;">
                    <label for="showPassword" style="display: inline; margin-bottom: 0; cursor: pointer;">Show Password</label>
                </div>
            </div>

            <button type="submit" class="btn-submit">Login</button>
        </form>

        <script>
            // SweetAlert for Success
            <?php if(session()->getFlashdata('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Congratulations!',
                    text: '<?= session()->getFlashdata('success') ?>',
                    confirmButtonColor: '#2563eb'
                });
            <?php endif; ?>

            // SweetAlert for Errors
            <?php if(session()->getFlashdata('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Error',
                    text: '<?= session()->getFlashdata('error') ?>',
                    confirmButtonColor: '#2563eb'
                });
            <?php endif; ?>

            document.getElementById('showPassword').addEventListener('change', function() {
                const passwordField = document.getElementById('password');
                if (this.checked) {
                    passwordField.type = 'text';
                } else {
                    passwordField.type = 'password';
                }
            });
        </script>
        
        <a href="<?= base_url('register') ?>" class="back-link">New Citizen? Create account</a>
        <a href="<?= base_url() ?>" class="back-link">← Back to Home</a>
    </div>

</body>
</html>
