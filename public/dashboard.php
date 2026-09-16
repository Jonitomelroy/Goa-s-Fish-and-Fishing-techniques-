<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (($_SESSION['role'] ?? '') === 'admin') {
    header('Location: admin/dashboard.php');
    exit;
}

require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/helpers/audit.php';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { 
    die("Database Connection failed: " . $conn->connect_error); 
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Team Member';
$user_uid = $_SESSION['user_uid'] ?? 'N/A';
$user_role = $_SESSION['role'] ?? 'member';

$msg = '';
$error = '';

// Handle Team Edit Submissions (Queues changes into pending_edits)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action_type = $_POST['action_type'] ?? '';

    if (in_array($action_type, ['add_fish', 'edit_fish', 'delete_fish'])) {
        $target_id = isset($_POST['fish_id']) ? intval($_POST['fish_id']) : null;
        $db_action = $action_type === 'add_fish' ? 'ADD' : ($action_type === 'edit_fish' ? 'EDIT' : 'DELETE');
        
        $payload = json_encode([
            'common_name'       => trim($_POST['common_name'] ?? ''),
            'scientific_name'   => trim($_POST['scientific_name'] ?? ''),
            'local_konkani_name' => trim($_POST['local_konkani_name'] ?? ''),
            'image_url'         => trim($_POST['image_url'] ?? ''),
            'habitat'           => trim($_POST['habitat'] ?? ''),
            'catch_method'      => trim($_POST['catch_method'] ?? ''),
            'description'       => trim($_POST['description'] ?? '')
        ]);

        $stmt = $conn->prepare("INSERT INTO pending_edits (user_uid, user_name, target_table, target_id, action_type, payload) VALUES (?, ?, 'fish_species', ?, ?, ?)");
        $stmt->bind_param("ssiss", $user_uid, $user_name, $target_id, $db_action, $payload);
        
        if ($stmt->execute()) {
            log_audit_action($conn, $user_uid, 'SUBMIT_DRAFT', 'pending_edits', $conn->insert_id, "Submitted {$db_action} request for review");
            $msg = "Your changes have been submitted for Admin approval.";
        } else {
            $error = "Failed to submit draft for approval.";
        }
    }
}

// Fetch Active Live Species Records
$fish_list = $conn->query("SELECT * FROM fish_species ORDER BY common_name ASC");

// Fetch User's Pending Submissions
$stmt = $conn->prepare("SELECT * FROM pending_edits WHERE user_uid = ? AND status = 'pending' ORDER BY created_at DESC");
$stmt->bind_param("s", $user_uid);
$stmt->execute();
$pending_submissions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Workspace | Species Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'], mono: ['JetBrains Mono', 'monospace'] } } } }
    </script>
</head>
<body class="min-h-full font-sans text-slate-200 bg-slate-900 selection:bg-sky-500 selection:text-slate-950 pb-12">
    
    <div class="h-1 bg-gradient-to-r from-sky-500 via-teal-500 to-indigo-500"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 space-y-8">

        <!-- Navigation Header -->
        <header class="bg-slate-800/80 backdrop-blur-md p-6 rounded-2xl border border-slate-700/60 shadow-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-gradient-to-tr from-sky-500 to-teal-500 rounded-xl shadow-lg shadow-sky-500/20">
                    <svg class="w-6 h-6 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight">Team Workspace & Content Editor</h1>
                    <p class="text-xs text-slate-400">Contributor: <span class="font-semibold text-slate-200"><?php echo htmlspecialchars($user_name); ?></span></p>
                </div>
            </div>

            <div class="flex items-center flex-wrap gap-2.5">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-900/80 border border-slate-700 text-sky-400 text-xs font-mono font-medium rounded-lg">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    UID: <?php echo htmlspecialchars($user_uid); ?>
                </span>
                <a href="logout.php" class="px-3.5 py-1.5 bg-rose-500/10 border border-rose-500/20 text-rose-400 font-semibold text-xs rounded-lg hover:bg-rose-500/20 transition-all">
                    Sign Out
                </a>
            </div>
        </header>

        <!-- Status Alerts -->
        <?php if ($msg): ?>
            <div class="flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs p-4 rounded-xl shadow-lg">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><?php echo $msg; ?></span>
            </div>
        <?php endif; ?>

        <!-- Pending Approval Queue -->
        <?php if (!empty($pending_submissions)): ?>
            <section class="bg-amber-500/5 border border-amber-500/20 rounded-2xl p-6 shadow-xl space-y-3">
                <div class="flex items-center space-x-2 text-amber-400">
                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-xs font-bold uppercase tracking-wider">Your Pending Change Requests</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <?php foreach ($pending_submissions as $draft): 
                        $data = json_decode($draft['payload'], true);
                    ?>
                        <div class="p-3.5 bg-slate-900/80 border border-slate-700/60 rounded-xl flex items-center justify-between text-xs">
                            <div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    <?php echo $draft['action_type']; ?> REQUEST
                                </span>
                                <p class="text-white font-semibold mt-1"><?php echo htmlspecialchars($data['common_name'] ?: 'Species Record #' . $draft['target_id']); ?></p>
                                <p class="text-[10px] text-slate-400 font-mono">Submitted at: <?php echo $draft['created_at']; ?></p>
                            </div>
                            <span class="px-2.5 py-1 bg-amber-500/10 text-amber-300 font-mono text-[10px] rounded-lg border border-amber-500/20">Awaiting Admin Approval</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- Add New Record Form -->
        <section class="bg-slate-800/60 border border-slate-700/60 rounded-2xl p-6 shadow-xl space-y-4">
            <div class="flex justify-between items-center pb-2 border-b border-slate-700/60">
                <div>
                    <h2 class="text-lg font-bold text-white tracking-tight">Propose New Marine Species Entry</h2>
                    <p class="text-xs text-slate-400">Submissions will be pushed live upon admin confirmation.</p>
                </div>
            </div>

            <form method="POST" class="space-y-4">
                <input type="hidden" name="action_type" value="add_fish">
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <input type="text" name="common_name" placeholder="Common Name" required class="px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 text-xs text-white rounded-lg focus:border-sky-500 outline-none">
                    <input type="text" name="scientific_name" placeholder="Scientific Name" class="px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 text-xs text-white rounded-lg focus:border-sky-500 outline-none">
                    <input type="text" name="local_konkani_name" placeholder="Konkani Name" required class="px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 text-xs text-white rounded-lg focus:border-sky-500 outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <input type="url" name="image_url" placeholder="Direct Image URL" required class="px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 text-xs text-white rounded-lg focus:border-sky-500 outline-none">
                    <input type="text" name="habitat" placeholder="Habitat" class="px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 text-xs text-white rounded-lg focus:border-sky-500 outline-none">
                    <input type="text" name="catch_method" placeholder="Catch Method" class="px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 text-xs text-white rounded-lg focus:border-sky-500 outline-none">
                </div>

                <textarea name="description" placeholder="Description..." rows="2" class="w-full px-3.5 py-2.5 bg-slate-900/90 border border-slate-700 text-xs text-white rounded-lg focus:border-sky-500 outline-none"></textarea>

                <button type="submit" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-400 text-slate-950 font-bold text-xs rounded-lg transition-all shadow-lg shadow-sky-500/20">
                    Submit Entry for Review
                </button>
            </form>
        </section>

        <!-- Existing Record Editing Grid -->
        <section class="space-y-4">
            <h2 class="text-lg font-bold text-white tracking-tight">Edit Existing Records</h2>
            <div class="space-y-3 max-h-[600px] overflow-y-auto pr-2">
                <?php while ($fish = $fish_list->fetch_assoc()): ?>
                    <div class="p-4 bg-slate-800/60 border border-slate-700/60 rounded-xl flex flex-col md:flex-row gap-4 items-start md:items-center hover:border-slate-600 transition-all">
                        <form method="POST" class="flex flex-col md:flex-row gap-4 items-start md:items-center flex-1 w-full">
                            <input type="hidden" name="action_type" value="edit_fish">
                            <input type="hidden" name="fish_id" value="<?php echo $fish['id']; ?>">

                            <img src="<?php echo htmlspecialchars($fish['image_url']); ?>" alt="<?php echo htmlspecialchars($fish['common_name']); ?>" class="w-16 h-16 object-cover rounded-lg border border-slate-700 bg-slate-900 shrink-0">

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 flex-1 w-full">
                                <div>
                                    <label class="block text-[10px] text-slate-400 mb-0.5">Common Name</label>
                                    <input type="text" name="common_name" value="<?php echo htmlspecialchars($fish['common_name']); ?>" class="w-full px-2.5 py-1.5 bg-slate-900 border border-slate-700 text-xs text-slate-200 rounded focus:border-sky-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] text-slate-400 mb-0.5">Konkani Name</label>
                                    <input type="text" name="local_konkani_name" value="<?php echo htmlspecialchars($fish['local_konkani_name']); ?>" class="w-full px-2.5 py-1.5 bg-slate-900 border border-slate-700 text-xs text-slate-200 rounded focus:border-sky-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] text-slate-400 mb-0.5">Scientific Name</label>
                                    <input type="text" name="scientific_name" value="<?php echo htmlspecialchars($fish['scientific_name'] ?? ''); ?>" class="w-full px-2.5 py-1.5 bg-slate-900 border border-slate-700 text-xs text-slate-200 rounded focus:border-sky-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] text-slate-400 mb-0.5">Image URL</label>
                                    <input type="url" name="image_url" value="<?php echo htmlspecialchars($fish['image_url']); ?>" class="w-full px-2.5 py-1.5 bg-slate-900 border border-slate-700 text-xs text-slate-200 rounded focus:border-sky-500 outline-none font-mono">
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 shrink-0 self-end md:self-center">
                                <button type="submit" class="px-3.5 py-1.5 bg-sky-500/20 border border-sky-500/30 hover:bg-sky-500/30 text-sky-300 text-xs font-bold rounded-lg transition-all">
                                    Propose Edit
                                </button>
                        </form>
                        
                        <form method="POST">
                            <input type="hidden" name="action_type" value="delete_fish">
                            <input type="hidden" name="fish_id" value="<?php echo $fish['id']; ?>">
                            <button type="submit" class="px-3.5 py-1.5 bg-rose-500/10 border border-rose-500/20 hover:bg-rose-500/20 text-rose-400 text-xs font-bold rounded-lg transition-all">
                                Request Removal
                            </button>
                        </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>

    </div>
</body>
</html>