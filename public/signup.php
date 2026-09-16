<?php
session_start();
require_once __DIR__ . '/../src/config/config.php';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Database Connection failed: " . $conn->connect_error); }

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'team'; // 'admin' or 'team'
    $signup_code = trim($_POST['signup_code'] ?? '');

    // 1. Verify Team Signup Code
    if ($role === 'team') {
        $stmt = $conn->prepare("SELECT setting_value FROM app_settings WHERE setting_key = 'team_signup_code' LIMIT 1");
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $current_code = $res['setting_value'] ?? '';

        if ($signup_code !== $current_code) {
            $error = "Invalid Team Sign-Up Key Code. Please contact an Administrator.";
        }
    }

    if (empty($error)) {
        // 2. Check if email exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = "This email address is already registered.";
        } else {
            // 3. Generate Unique Identifier UID (e.g., ADM-A1B2 or TEM-C3D4)
            $prefix = ($role === 'admin') ? 'ADM-' : 'TEM-';
            $user_uid = $prefix . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

            // 4. Hash Password & Insert User
            $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (user_uid, full_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $user_uid, $full_name, $email, $hashed_pass, $role);

            if ($stmt->execute()) {
                $success = "Account created! Your Unique ID is <strong>{$user_uid}</strong>. <a href='login.php' class='underline font-bold'>Login here</a>";
            } else {
                $error = "Failed to create account. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl w-full max-w-md border border-slate-200">
        
        <!-- Header with Title & Single Mascot Image (Same as Login Page) -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Create Account</h2>
                <p class="text-xs text-slate-500 mt-0.5">Register to access your portal</p>
            </div>
            <!-- Mascot Badge -->
            <img src="/Assets/login.png" alt="Portal Mascot" class="w-16 h-16 object-contain shrink-0 drop-shadow-md">
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 text-red-700 text-xs p-3 rounded-xl border border-red-200 mb-4 font-semibold">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-emerald-50 text-emerald-700 text-xs p-3 rounded-xl border border-emerald-200 mb-4 font-semibold">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <!-- Sign Up Form -->
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Full Name</label>
                <input type="text" name="full_name" required class="w-full px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none bg-slate-50/50">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Email Address</label>
                <input type="email" name="email" required class="w-full px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none bg-slate-50/50">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none bg-slate-50/50">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Account Role</label>
                <select name="role" id="roleSelect" onchange="toggleCodeField()" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none bg-slate-50/50">
                    <option value="team">Team Member</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <div id="codeContainer">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Team Registration Code</label>
                <input type="password" name="signup_code" placeholder="Enter key code" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none bg-slate-50/50">
            </div>

            <button type="submit" class="w-full py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md shadow-sky-600/20">
                Sign Up
            </button>
        </form>

        <p class="text-xs text-center text-slate-500 mt-6">
            Already registered? <a href="login.php" class="text-sky-600 font-semibold hover:underline">Log in</a>
        </p>
    </div>

    <script>
        function toggleCodeField() {
            const role = document.getElementById('roleSelect').value;
            const container = document.getElementById('codeContainer');
            container.style.display = (role === 'team') ? 'block' : 'none';
        }
    </script>
</body>
</html>