<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Registration - E-Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            background-color: var(--gray-100);
            padding: 2rem 0;
            background: radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.05) 0%, transparent 40%),
                        radial-gradient(circle at 90% 80%, rgba(16, 185, 129, 0.05) 0%, transparent 40%);
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .form-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .form-header h1 { color: var(--text-dark); font-size: 2rem; }
        .form-header p { color: var(--text-muted); margin-top: 0.5rem; }

        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
            margin: 2rem 0 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-dark); font-size: 0.9rem; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-submit {
            grid-column: span 2;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 2rem;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .grid { grid-template-columns: 1fr; }
            .btn-submit { grid-column: span 1; }
        }

        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }
        .alert-error { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
    </style>
</head>
<body>

    <div class="container">
        <div class="form-header">
            <h1>Citizen Enrollment Form</h1>
            <p>Please provide accurate details for Gram Panchayat digital records.</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register/save') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="form-section-title"><i class="fas fa-user-circle"></i> Personal Information</div>
            <div class="grid">
                <div class="form-group">
                    <label>Full Name (as per Aadhar)</label>
                    <input type="text" name="name" required placeholder="Enter full name">
                </div>
                <div class="form-group">
                    <label>Father/Husband Name</label>
                    <input type="text" name="father_name" required placeholder="Enter relative name">
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" required>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-section-title"><i class="fas fa-id-card"></i> Identity & Contact</div>
            <div class="grid">
                <div class="form-group">
                    <label>Aadhar Number (12 Digit)</label>
                    <input type="text" name="aadhar_no" maxlength="12" pattern="\d{12}" required placeholder="0000 0000 0000">
                </div>
                <div class="form-group">
                    <label>Voter ID Card No.</label>
                    <input type="text" name="voter_id" placeholder="XYZ1234567">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" required placeholder="+91">
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="example@mail.com">
                </div>
            </div>

            <div class="form-section-title"><i class="fas fa-home"></i> Address & Category</div>
            <div class="grid">
                <div class="form-group">
                    <label>Ward Number</label>
                    <input type="text" name="ward_no" required placeholder="01">
                </div>
                <div class="form-group">
                    <label>House Number</label>
                    <input type="text" name="house_no" placeholder="H-45">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="General">General</option>
                        <option value="OBC">OBC</option>
                        <option value="SC">SC</option>
                        <option value="ST">ST</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Family ID / Samagra ID</label>
                    <input type="text" name="family_id" placeholder="8 digit ID">
                </div>
                <div class="form-group">
                    <label>Occupation</label>
                    <input type="text" name="occupation" placeholder="e.g. Farmer, Teacher">
                </div>
                <div class="form-group">
                    <label>Gram Panchayat (Village)</label>
                    <input type="text" name="village" placeholder="Enter Village Name" required>
                </div>
            </div>

            <div class="form-section-title"><i class="fas fa-lock"></i> Account Security</div>
            <div class="grid">
                <div class="form-group">
                    <label>Create Password</label>
                    <input type="password" id="regPassword" name="password" required placeholder="Min 6 characters">
                    <div style="margin-top: 8px; display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #64748b;">
                        <input type="checkbox" id="showRegPassword" style="width: auto;">
                        <label for="showRegPassword" style="display: inline; margin-bottom: 0; cursor: pointer;">Show Password</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">Complete Registration</button>
        </form>

        <script>
            // SweetAlert for Errors
            <?php if(session()->getFlashdata('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    text: '<?= session()->getFlashdata('error') ?>',
                    confirmButtonColor: '#2563eb'
                });
            <?php endif; ?>

            document.getElementById('showRegPassword').addEventListener('change', function() {
                const passwordField = document.getElementById('regPassword');
                passwordField.type = this.checked ? 'text' : 'password';
            });
        </script>

        <a href="<?= base_url('login') ?>" class="back-link">Already have an account? Login here</a>
    </div>

</body>
</html>
