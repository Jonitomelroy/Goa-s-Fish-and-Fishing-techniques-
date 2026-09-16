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

$success_msg = $error_msg = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, phone, email, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $phone, $email, $subject, $message);
        if ($stmt->execute()) {
            $success_msg = "Your message has been sent successfully!";
        } else {
            $error_msg = "Failed to send message. Please try again.";
        }
    } else {
        $error_msg = "Please fill in all required fields.";
    }
}

// Fetch Contact Metadata
$info = $conn->query("SELECT * FROM contact_info LIMIT 1")->fetch_assoc();

$current_page = 'contact';
include __DIR__ . '/../src/views/partials/header.php';
?>

<!-- MAIN PAGE CONTAINER (INCLUDES BOTTOM PADDING FOR MOBILE NAV) -->
<div class="w-full min-h-screen bg-slate-50 pb-28 lg:pb-0">
    <div class="flex flex-col lg:flex-row w-full min-h-screen">

        <!-- MIDDLE COLUMN: Contact Info Card & Mascot Banner -->
        <div class="w-full lg:w-80 xl:w-96 bg-white/40 border-b lg:border-b-0 lg:border-r border-sky-100/60 p-6 flex flex-col justify-between shrink-0">
            <div>
                <!-- Contact Mascot Banner Box -->
                <div class="relative overflow-hidden p-4 rounded-2xl bg-gradient-to-br from-sky-500 to-sky-700 text-white shadow-md mb-6 group">
                    <div class="relative z-10 pr-14">
                        <span class="text-[10px] uppercase font-bold tracking-widest opacity-80 block mb-1">Community Support</span>
                        <h3 class="text-base font-serif font-bold leading-tight">Reach Out</h3>
                        <p class="text-xs text-sky-100 mt-1">We'd love to hear from you</p>
                    </div>
                    <!-- Contact Mascot Image Asset (FIXED PATH) -->
                    <img src="/Assets/contact.png" alt="Contact Mascot" class="absolute -right-2 -bottom-2 w-20 h-20 object-contain drop-shadow-md group-hover:scale-105 transition-transform duration-300 pointer-events-none">
                </div>

                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4">Get in Touch</h2>
                <div class="space-y-4 text-xs">
                    <div class="bg-white/60 p-4 rounded-xl border border-white shadow-sm">
                        <span class="block text-[10px] uppercase font-bold text-slate-400 mb-1">Email Address</span>
                        <span class="text-slate-800 font-semibold"><?php echo htmlspecialchars($info['email'] ?? 'jk@gmail.com'); ?></span>
                    </div>
                    <div class="bg-white/60 p-4 rounded-xl border border-white shadow-sm">
                        <span class="block text-[10px] uppercase font-bold text-slate-400 mb-1">Phone Number</span>
                        <span class="text-slate-800 font-semibold"><?php echo htmlspecialchars($info['phone'] ?? '+91 1234876757'); ?></span>
                    </div>
                    <div class="bg-white/60 p-4 rounded-xl border border-white shadow-sm">
                        <span class="block text-[10px] uppercase font-bold text-slate-400 mb-1">Location</span>
                        <span class="text-slate-800 font-semibold"><?php echo htmlspecialchars($info['address'] ?? 'Goa, India'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT MAIN CONTENT PANEL -->
        <main class="flex-1 bg-white/70 p-5 sm:p-8 lg:p-10 flex flex-col justify-between overflow-y-auto no-scrollbar">
            <div>
                <!-- Header with Title & Desktop Mascot Badge -->
                <div class="mb-6 flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-5xl font-serif font-bold text-slate-900 tracking-tight uppercase leading-none mb-3">
                            Contact Us
                        </h1>
                        <p class="text-xs text-sky-700 font-semibold tracking-wider uppercase">Project Feedback & Inquiries</p>
                    </div>
                    <!-- Header Mascot Badge (FIXED PATH) -->
                    <img src="/Assets/contact.png" alt="Contact Mascot" class="hidden sm:block w-16 h-16 object-contain shrink-0 drop-shadow-md">
                </div>

                <?php if ($success_msg): ?>
                    <div class="p-4 mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                        <?php echo htmlspecialchars($success_msg); ?>
                    </div>
                <?php endif; ?>

                <?php if ($error_msg): ?>
                    <div class="p-4 mb-6 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
                        <?php echo htmlspecialchars($error_msg); ?>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="/public/contact.php" method="POST" class="space-y-4 max-w-xl">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Name *</label>
                            <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sky-500 focus:outline-none bg-white/80">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Phone</label>
                            <input type="text" name="phone" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sky-500 focus:outline-none bg-white/80">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Email *</label>
                        <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sky-500 focus:outline-none bg-white/80">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Subject</label>
                        <input type="text" name="subject" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sky-500 focus:outline-none bg-white/80">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider mb-1">Message *</label>
                        <textarea name="message" rows="5" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-sky-500 focus:outline-none bg-white/80"></textarea>
                    </div>
                    <button type="submit" class="px-6 py-3 rounded-full bg-sky-600 text-white font-bold text-xs uppercase tracking-wider hover:bg-sky-700 transition-all shadow-md shadow-sky-600/30">
                        Send Message
                    </button>
                </form>
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