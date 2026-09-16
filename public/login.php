<?php
session_start();
require_once __DIR__ . '/../src/config/config.php';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Database Connection failed: " . $conn->connect_error); }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, user_uid, full_name, password, role FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_uid'] = $user['user_uid'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];

        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl w-full max-w-md border border-slate-200">
        
        <!-- Header with Title & Single Mascot Image -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Welcome Back</h2>
                <p class="text-xs text-slate-500 mt-0.5">Sign in to your account</p>
            </div>
            <!-- Single Mascot Badge -->
            <img src="/Assets/login.png" alt="Login Mascot" class="w-16 h-16 object-contain shrink-0 drop-shadow-md">
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 text-red-700 text-xs p-3 rounded-xl border border-red-200 mb-4 font-semibold">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Email Address</label>
                <input type="email" name="email" required class="w-full px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none bg-slate-50/50">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none bg-slate-50/50">
            </div>

            <button type="submit" class="w-full py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md shadow-sky-600/20">
                Sign In
            </button>
        </form>

        <p class="text-xs text-center text-slate-500 mt-6">
            Need an account? <a href="signup.php" class="text-sky-600 font-semibold hover:underline">Sign up</a>
        </p>
    </div>

</body>
</html>