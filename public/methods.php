<?php
// Enable error reporting for local development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/config/config.php';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// 1. Fetch fishing methods list
$methods_result = $conn->query("SELECT * FROM fishing_methods ORDER BY id ASC");
$methods_list = $methods_result ? $methods_result->fetch_all(MYSQLI_ASSOC) : [];

// 2. Fetch selected method via URL parameter ?id=... (or default to first entry)
$selected_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($selected_id) {
    $stmt = $conn->prepare("SELECT * FROM fishing_methods WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $selected_id);
    $stmt->execute();
    $active_method = $stmt->get_result()->fetch_assoc();
} else {
    $active_method = $methods_list[0] ?? null;
}

$current_page = 'methods';
include __DIR__ . '/../src/views/partials/header.php';
?>

<!-- MAIN PAGE CONTAINER (INCLUDES BOTTOM PADDING FOR MOBILE NAV) -->
<div class="w-full min-h-screen bg-slate-50 pb-28 lg:pb-0">
    <div class="flex flex-col lg:flex-row w-full min-h-screen">

        <!-- LEFT COLUMN: Clickable Fishing Methods Directory -->
        <div class="w-full lg:w-80 xl:w-96 bg-white/40 border-b lg:border-b-0 lg:border-r border-sky-100/60 p-4 sm:p-6 flex flex-col justify-between shrink-0">
            <div>
                <!-- Fishing Methods Mascot Banner Box -->
                <div class="relative overflow-hidden p-4 rounded-2xl bg-gradient-to-br from-sky-500 to-sky-700 text-white shadow-md mb-6 group">
                    <div class="relative z-10 pr-14">
                        <span class="text-[10px] uppercase font-bold tracking-widest opacity-80 block mb-1">Goan Heritage</span>
                        <h3 class="text-base font-serif font-bold leading-tight">Fishing Methods</h3>
                        <p class="text-xs text-sky-100 mt-1">Explore traditional gear & techniques</p>
                    </div>
                    <!-- Mascot Image Asset -->
                    <img src="/../Assets/methods.png" alt="Fishing Methods Mascot" class="absolute -right-2 -bottom-2 w-20 h-20 object-contain drop-shadow-md group-hover:scale-105 transition-transform duration-300 pointer-events-none">
                </div>

                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Traditional Methods</h2>
                    <span class="text-[10px] font-semibold bg-sky-100 text-sky-800 px-2 py-0.5 rounded-full">
                        <?php echo count($methods_list); ?> Cataloged
                    </span>
                </div>

                <div class="space-y-2 max-h-[50vh] lg:max-h-[60vh] overflow-y-auto no-scrollbar pr-1">
                    <?php foreach ($methods_list as $method): 
                        $isSelected = ($active_method && $active_method['id'] == $method['id']);
                    ?>
                        <a href="/public/methods.php?id=<?php echo $method['id']; ?>" 
                           class="flex items-center justify-between p-3 rounded-xl border transition-all duration-200 block <?php echo $isSelected ? 'bg-sky-500 text-white border-sky-500 shadow-md' : 'bg-white/70 border-white text-slate-700 hover:bg-white hover:border-sky-200'; ?>">
                            <div class="truncate pr-2">
                                <span class="font-semibold text-xs block truncate">
                                    <?php echo htmlspecialchars($method['title'] ?? ''); ?>
                                </span>
                                <span class="text-[10px] italic <?php echo $isSelected ? 'text-sky-100' : 'text-slate-400'; ?> block truncate">
                                    <?php echo htmlspecialchars($method['water_body'] ?? ''); ?>
                                </span>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-1 rounded-md shrink-0 <?php echo $isSelected ? 'bg-white/20 text-white' : 'bg-sky-50 text-sky-700 border border-sky-100'; ?>">
                                <?php echo htmlspecialchars($method['local_konkani_name'] ?? ''); ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: Dynamic Method Details & Image Display -->
        <main class="flex-1 bg-white/70 p-5 sm:p-8 lg:p-10 flex flex-col justify-between overflow-y-auto no-scrollbar">
            <?php if ($active_method): ?>
                <div>
                    <!-- Category Badge & Header Mascot -->
                    <div class="flex items-start justify-between gap-4 mb-2">
                        <div>
                            <div class="text-xs text-sky-700 font-semibold tracking-wider uppercase mb-1">
                                <span>Traditional Goan Fishing Knowledge</span>
                            </div>
                            <!-- Title & Konkani Name -->
                            <h1 class="text-3xl sm:text-4xl font-serif font-bold text-slate-900 tracking-tight leading-none mb-2">
                                <?php echo htmlspecialchars($active_method['title'] ?? ''); ?>
                            </h1>
                            <p class="text-lg font-serif italic text-sky-700">
                                Konkani Term: <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($active_method['local_konkani_name'] ?? 'N/A'); ?></span>
                            </p>
                        </div>
                        <!-- Header Mascot Badge for Large Screens -->
                        <img src="/../Assets/methods.png" alt="Fishing Methods Mascot" class="hidden sm:block w-16 h-16 object-contain shrink-0 drop-shadow-md">
                    </div>

                    <!-- Dynamic Image Display -->
                    <div class="my-6 rounded-2xl overflow-hidden shadow-md border border-white bg-slate-100 h-64 sm:h-80 w-full">
                        <?php 
                        $image_url = !empty($active_method['image_url']) 
                            ? htmlspecialchars($active_method['image_url']) 
                            : 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80';
                        ?>
                        <img src="<?php echo $image_url; ?>" 
                             alt="<?php echo htmlspecialchars($active_method['title'] ?? 'Fishing Method'); ?>" 
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="p-4 rounded-xl bg-white/80 border border-sky-100 shadow-sm">
                            <span class="block text-slate-400 text-[10px] uppercase font-bold mb-1">Water Body / Ecosystem</span>
                            <p class="text-xs font-semibold text-slate-700">
                                <?php echo htmlspecialchars($active_method['water_body'] ?? 'Estuaries & Khazan Lands'); ?>
                            </p>
                        </div>
                        <div class="p-4 rounded-xl bg-white/80 border border-sky-100 shadow-sm">
                            <span class="block text-slate-400 text-[10px] uppercase font-bold mb-1">Primary Target Catch</span>
                            <p class="text-xs font-semibold text-slate-700">
                                <?php echo htmlspecialchars($active_method['target_species'] ?? 'Mixed Species'); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-lg font-serif font-bold text-slate-900 mb-3 pb-2 border-b border-sky-100">
                            Technique & Heritage Context
                        </h2>
                        <div class="text-slate-600 text-sm leading-relaxed space-y-4">
                            <p>
                                <?php echo nl2br(htmlspecialchars($active_method['description'] ?? '')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="p-12 text-center text-slate-500">
                    <p class="text-lg font-semibold">No fishing method entries found in the database.</p>
                </div>
            <?php endif; ?>

            <?php include __DIR__ . '/../src/views/partials/footer.php'; ?>
        </main>
    </div>
</div>

<!-- CLOSE LAYOUT CONTAINERS FROM HEADER.PHP -->
</div>
</div>

<!-- INJECT FLOATING MOBILE NAV DIRECTLY BEFORE BODY CLOSING TAG -->
<?php include __DIR__ . '/../src/views/partials/mobile.php'; ?>

</body>
</html>