<?php
session_start();

// Desktop Check
$user_agent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
$mobile_keywords = ['mobile', 'android', 'iphone', 'ipad', 'ipod', 'blackberry', 'windows phone', 'tablet'];
foreach ($mobile_keywords as $keyword) {
    if (strpos($user_agent, $keyword) !== false) {
        exit("Desktop access required.");
    }
}

require_once __DIR__ . '/../../src/config/config.php';
require_once __DIR__ . '/../../src/helpers/audit.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: ../dashboard.php');
    exit;
}

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { 
    die("Database Connection failed: " . $conn->connect_error); 
}

$msg = '';
$error = '';
$user_uid = $_SESSION['user_uid'];

// -------------------------------------------------------------
// APPROVAL WORKFLOW HANDLER
// -------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approval_action'])) {
    $request_id = intval($_POST['request_id']);
    $decision = $_POST['approval_action']; // 'approve' or 'reject'

    $stmt = $conn->prepare("SELECT * FROM pending_edits WHERE id = ? AND status = 'pending'");
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $pending_item = $stmt->get_result()->fetch_assoc();

    if ($pending_item) {
        if ($decision === 'approve') {
            $data = json_decode($pending_item['payload'], true);
            $action = $pending_item['action_type'];
            $target_id = $pending_item['target_id'];
            $submitter = $pending_item['user_uid'];

            if ($action === 'ADD') {
                $inst = $conn->prepare("INSERT INTO fish_species (common_name, scientific_name, local_konkani_name, image_url, habitat, catch_method, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $inst->bind_param("sssssss", $data['common_name'], $data['scientific_name'], $data['local_konkani_name'], $data['image_url'], $data['habitat'], $data['catch_method'], $data['description']);
                $inst->execute();
                $new_id = $conn->insert_id;
                log_audit_action($conn, $user_uid, 'APPROVE_ADD', 'fish_species', $new_id, "Approved addition submitted by {$submitter}");
            } 
            elseif ($action === 'EDIT') {
                $upd = $conn->prepare("UPDATE fish_species SET common_name=?, scientific_name=?, local_konkani_name=?, image_url=?, habitat=?, catch_method=?, description=? WHERE id=?");
                $upd->bind_param("sssssssi", $data['common_name'], $data['scientific_name'], $data['local_konkani_name'], $data['image_url'], $data['habitat'], $data['catch_method'], $data['description'], $target_id);
                $upd->execute();
                log_audit_action($conn, $user_uid, 'APPROVE_EDIT', 'fish_species', $target_id, "Approved edit submitted by {$submitter}");
            } 
            elseif ($action === 'DELETE') {
                $del = $conn->prepare("DELETE FROM fish_species WHERE id = ?");
                $del->bind_param("i", $target_id);
                $del->execute();
                log_audit_action($conn, $user_uid, 'APPROVE_DELETE', 'fish_species', $target_id, "Approved deletion submitted by {$submitter}");
            }

            $update_status = $conn->prepare("UPDATE pending_edits SET status = 'approved' WHERE id = ?");
            $update_status->bind_param("i", $request_id);
            $update_status->execute();
            $msg = "Change request #{$request_id} has been approved and applied to the database.";

        } elseif ($decision === 'reject') {
            $update_status = $conn->prepare("UPDATE pending_edits SET status = 'rejected' WHERE id = ?");
            $update_status->bind_param("i", $request_id);
            $update_status->execute();
            log_audit_action($conn, $user_uid, 'REJECT_CHANGE', 'pending_edits', $request_id, "Rejected edit request from {$pending_item['user_uid']}");
            $msg = "Change request #{$request_id} rejected.";
        }
    }
}

// Direct Admin Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_type']) && $_POST['action_type'] === 'update_key_code') {
    $new_code = trim($_POST['new_signup_code']);
    $stmt = $conn->prepare("UPDATE app_settings SET setting_value = ?, updated_by = ? WHERE setting_key = 'team_signup_code'");
    $stmt->bind_param("ss", $new_code, $user_uid);
    if ($stmt->execute()) {
        log_audit_action($conn, $user_uid, 'UPDATE_KEY_CODE', 'app_settings', null, "Changed signup code to {$new_code}");
        $msg = "Team Sign-Up Code updated successfully.";
    }
}

// Fetch Pending Approvals Queue
$pending_queue = $conn->query("SELECT * FROM pending_edits WHERE status = 'pending' ORDER BY created_at ASC");

// Fetch Live Data
$code_query = $conn->query("SELECT setting_value, updated_by, updated_at FROM app_settings WHERE setting_key = 'team_signup_code'");
$code_info = $code_query ? $code_query->fetch_assoc() : [];
$fish_list = $conn->query("SELECT * FROM fish_species ORDER BY id DESC");
$audit_logs = $conn->query("SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT 25")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approval Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'], mono: ['JetBrains Mono', 'monospace'] } } } }
    </script>
</head>
<body class="min-h-full font-sans text-slate-200 bg-slate-900 selection:bg-cyan-500 selection:text-slate-950 pb-12">
    
    <div class="h-1 bg-gradient-to-r from-sky-500 via-indigo-500 to-emerald-500"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 space-y-8">

        <!-- Header -->
        <header class="bg-slate-800/80 backdrop-blur-md p-6 rounded-2xl border border-slate-700/60 shadow-xl flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-gradient-to-tr from-sky-500 to-indigo-600 rounded-xl shadow-lg shadow-sky-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white tracking-tight">Admin Review & Control Center</h1>
                    <p class="text-xs text-slate-400">Review team submissions and manage platform configurations.</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <span class="px-3 py-1.5 bg-indigo-500/10 border border-indigo-500/30 text-indigo-300 text-xs font-bold rounded-lg uppercase">ADMIN</span>
                <a href="../logout.php" class="px-3.5 py-1.5 bg-rose-500/10 border border-rose-500/20 text-rose-400 font-semibold text-xs rounded-lg hover:bg-rose-500/20 transition-all">Sign Out</a>
            </div>
        </header>

        <!-- Feedback Messages -->
        <?php if ($msg): ?>
            <div class="flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs p-4 rounded-xl shadow-lg">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><?php echo $msg; ?></span>
            </div>
        <?php endif; ?>

        <!-- Pending Change Requests Desk -->
        <section class="bg-slate-800/80 border border-sky-500/30 rounded-2xl p-6 shadow-xl space-y-4 relative overflow-hidden">
            <div class="flex items-center justify-between pb-3 border-b border-slate-700/60">
                <div class="flex items-center space-x-2 text-sky-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <h2 class="text-base font-bold text-white tracking-tight">Team Submissions Queue</h2>
                </div>
                <span class="px-3 py-1 bg-sky-500/10 text-sky-400 font-mono text-xs rounded-lg border border-sky-500/20">
                    Pending Review: <?php echo $pending_queue ? $pending_queue->num_rows : 0; ?>
                </span>
            </div>

            <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                <?php if ($pending_queue && $pending_queue->num_rows > 0): ?>
                    <?php while ($request = $pending_queue->fetch_assoc()): 
                        $payload = json_decode($request['payload'], true);
                    ?>
                        <div class="p-4 bg-slate-900/90 border border-slate-700/80 rounded-xl flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
                            <div class="space-y-1.5 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase
                                        <?php echo $request['action_type'] === 'ADD' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : ($request['action_type'] === 'DELETE' ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : 'bg-sky-500/10 text-sky-400 border border-sky-500/20'); ?>">
                                        <?php echo $request['action_type']; ?> REQUEST
                                    </span>
                                    <span class="text-xs text-slate-400 font-mono">By: <strong class="text-slate-200"><?php echo htmlspecialchars($request['user_name']); ?></strong> (<?php echo htmlspecialchars($request['user_uid']); ?>)</span>
                                </div>

                                <div class="text-xs text-slate-300 space-y-1 pt-1">
                                    <p><strong class="text-white">Proposed Data:</strong> Common Name: <span class="text-amber-300"><?php echo htmlspecialchars($payload['common_name'] ?: 'N/A'); ?></span> | Konkani: <span class="text-amber-300"><?php echo htmlspecialchars($payload['local_konkani_name'] ?: 'N/A'); ?></span></p>
                                    <?php if (!empty($payload['description'])): ?>
                                        <p class="text-slate-400 italic">"<?php echo htmlspecialchars($payload['description']); ?>"</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <form method="POST" class="flex items-center space-x-2 shrink-0">
                                <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                <button type="submit" name="approval_action" value="approve" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs rounded-lg transition-all shadow-lg shadow-emerald-500/20">
                                    Approve & Apply
                                </button>
                                <button type="submit" name="approval_action" value="reject" class="px-4 py-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-rose-400 font-bold text-xs rounded-lg transition-all">
                                    Reject
                                </button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="p-6 text-center text-xs text-slate-500 bg-slate-900/40 rounded-xl border border-slate-800">
                        No pending edits requiring approval.
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Registration Passcode Settings -->
        <section class="bg-amber-500/5 border border-amber-500/20 rounded-2xl p-6 relative overflow-hidden">
            <div class="flex items-center space-x-2 text-amber-400 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"></path></svg>
                <h3 class="text-sm font-bold uppercase tracking-wider">Team Registration Passcode</h3>
            </div>
            <p class="text-xs text-slate-400 mb-4">Master passcode required during team onboarding.</p>
            
            <form method="POST" class="flex flex-wrap items-center gap-3">
                <input type="hidden" name="action_type" value="update_key_code">
                <input type="text" name="new_signup_code" value="<?php echo htmlspecialchars($code_info['setting_value'] ?? ''); ?>" required class="px-4 py-2 bg-slate-900 border border-slate-700 text-amber-300 font-mono text-sm rounded-xl focus:border-amber-500 outline-none w-64">
                <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs rounded-xl transition-all shadow-lg shadow-amber-500/10">
                    Update Passcode
                </button>
            </form>
        </section>

        <!-- Audit Log Viewer Table -->
        <section class="bg-slate-800/60 border border-slate-700/60 rounded-2xl p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-white tracking-tight">Audit Log Viewer</h2>
                    <p class="text-xs text-slate-400">Logs ordered by User UIDs.</p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-700/60">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-900/90 text-slate-400 uppercase text-[10px] tracking-wider font-mono border-b border-slate-700/60">
                        <tr>
                            <th class="p-3.5">Timestamp</th>
                            <th class="p-3.5">User UID</th>
                            <th class="p-3.5">Action</th>
                            <th class="p-3.5">Target Table</th>
                            <th class="p-3.5">Log Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/40 bg-slate-900/30">
                        <?php foreach ($audit_logs as $log): ?>
                            <tr class="hover:bg-slate-800/50 transition-colors">
                                <td class="p-3.5 font-mono text-[11px] text-slate-400 whitespace-nowrap"><?php echo $log['created_at']; ?></td>
                                <td class="p-3.5 font-mono font-bold text-sky-400 whitespace-nowrap"><?php echo htmlspecialchars($log['user_uid']); ?></td>
                                <td class="p-3.5 font-semibold text-slate-200">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase
                                        <?php echo str_contains($log['action'], 'APPROVE') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : (str_contains($log['action'], 'REJECT') ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : 'bg-sky-500/10 text-sky-400 border border-sky-500/20'); ?>">
                                        <?php echo htmlspecialchars($log['action']); ?>
                                    </span>
                                </td>
                                <td class="p-3.5"><span class="px-2 py-0.5 bg-slate-800 border border-slate-700 rounded text-[10px] font-mono text-slate-400"><?php echo htmlspecialchars($log['target_table']); ?></span></td>
                                <td class="p-3.5 text-slate-300 max-w-md truncate"><?php echo htmlspecialchars($log['details']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</body>
</html>