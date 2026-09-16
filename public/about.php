<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/config/config.php';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Fetch About Page Content
$pageStmt = $conn->prepare("SELECT * FROM pages WHERE slug = 'about' LIMIT 1");
$pageStmt->execute();
$about_page = $pageStmt->get_result()->fetch_assoc();

// Fetch Fishing Surnames / Communities
$community_result = $conn->query("SELECT * FROM fishing_communities ORDER BY id ASC");
$communities = $community_result ? $community_result->fetch_all(MYSQLI_ASSOC) : [];

$current_page = 'about';
include __DIR__ . '/../src/views/partials/header.php';
?>

<!-- MAIN PAGE CONTAINER (INCLUDES BOTTOM PADDING FOR MOBILE NAV) -->
<div class="w-full min-h-screen bg-slate-50 pb-28 lg:pb-0">
    <div class="flex flex-col lg:flex-row w-full min-h-screen">

        <!-- MIDDLE COLUMN: Community Surnames & Metadata -->
        <div class="w-full lg:w-80 xl:w-96 bg-white/40 border-b lg:border-b-0 lg:border-r border-sky-100/60 p-6 flex flex-col justify-between shrink-0">
            <div>
                <!-- Mascot Banner Box -->
                <div class="relative overflow-hidden p-4 rounded-2xl bg-gradient-to-br from-sky-500 to-sky-700 text-white shadow-md mb-6 group">
                    <div class="relative z-10 pr-14">
                        <span class="text-[10px] uppercase font-bold tracking-widest opacity-80 block mb-1">Academic Project</span>
                        <h3 class="text-base font-serif font-bold leading-tight">Marine Heritage Portal</h3>
                        <p class="text-xs text-sky-100 mt-1">Preserving Goan Knowledge</p>
                    </div>
                    <!-- Mascot Image Asset -->
                    <img src="/Assets/about.png" alt="Project Mascot" class="absolute -right-2 -bottom-2 w-20 h-20 object-contain drop-shadow-md group-hover:scale-105 transition-transform duration-300 pointer-events-none">
                </div>

                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-2">Traditional Communities</h2>
                <p class="text-xs text-slate-500 mb-4">Surnames historically associated with Goan fishing heritage:</p>
                
                <div class="flex flex-wrap gap-2 max-h-[45vh] overflow-y-auto no-scrollbar pr-1">
                    <?php foreach ($communities as $community): ?>
                        <span class="px-3 py-1.5 rounded-xl bg-white/80 border border-sky-100 text-xs font-semibold text-slate-700 shadow-sm">
                            <?php echo htmlspecialchars($community['surname']); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT MAIN CONTENT PANEL -->
        <main class="flex-1 bg-white/70 p-5 sm:p-8 lg:p-10 flex flex-col justify-between overflow-y-auto no-scrollbar">
            <div>
                <div class="mb-8 flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-5xl font-serif font-bold text-slate-900 tracking-tight uppercase leading-none mb-3">
                            <?php echo htmlspecialchars($about_page['title'] ?? 'About The Project'); ?>
                        </h1>
                        <p class="text-xs text-sky-700 font-semibold tracking-wider uppercase">Web Technology Academic Assignment</p>
                    </div>
                    <!-- Mascot Header Badge -->
                    <img src="/Assets/about.png" alt="Mascot" class="hidden sm:block w-16 h-16 object-contain shrink-0 drop-shadow-md">
                </div>

                <!-- Content -->
                <div class="space-y-4 text-slate-600 text-sm leading-relaxed mb-8">
                    <p class="first-letter:text-4xl first-letter:font-serif first-letter:font-bold first-letter:text-sky-600 first-letter:mr-2 first-letter:float-left">
                        <?php echo nl2br(htmlspecialchars($about_page['content'] ?? 'Project details loading...')); ?>
                    </p>
                </div>
            </div>

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