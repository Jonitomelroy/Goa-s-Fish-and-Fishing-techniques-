# 🌊 Marine Heritage Portal & Species Directory

A web application designed to showcase Goa's rich marine biodiversity, traditional fishing techniques, and coastal heritage. Built with PHP, MySQL, and Tailwind CSS, this platform features a public-facing portal and a role-based CMS with an **Admin Draft & Approval Workflow**.

> 🚧 **Status: In active development.** Core features are functional — see [Roadmap](#-roadmap--status) below for what's still in progress.

🔗 **Live Demo:** [goa.free.nf/public/home.php](https://goa.free.nf/public/home.php)
📦 **Repository:** [github.com/Jonitomelroy/Goa-s-Fish-and-Fishing-techniques-](https://github.com/Jonitomelroy/Goa-s-Fish-and-Fishing-techniques-)

---

## ✨ Features

### 🌐 Public Portal
* **State Heritage Showcase:** Highlights Goa's official state fish (*Striped Grey Mullet / Shevtto*) and local marine culture.
* **Species Directory:** Interactive listing of local fish species, scientific names, habitats, catch methods, and Konkani local names.
* **Cultural & Community Insights:** FAQ section detailing traditional fishing communities, surnames, and environmental significance.
* **Custom Assets & UI:** Styled using Tailwind CSS with dedicated mascot branding integration.

### 🛡️ Contributor Workspace & Admin Approval Workflow
* **Role-Based Access Control:** Separate interfaces for **Team Members** (contributors) and **Admins**.
* **Draft & Staging Queue (`pending_edits`):** Team members can propose new species entries, edit existing content, or request removals. Changes do not go live immediately.
* **Admin Review Desk:** Admins review, approve, or reject pending team submissions from a centralized dashboard. Approved edits automatically update the live database.
* **Audit Logging System:** Tracks all key actions (`SUBMIT_DRAFT`, `APPROVE_ADD`, `APPROVE_EDIT`, `REJECT_CHANGE`, `UPDATE_KEY_CODE`) tagged by User UIDs for full accountability.
* **Passcode Onboarding:** Admins can dynamically change the team registration passcode from the dashboard.

---

## 🗺️ Roadmap / Status

- [ ] **Mascot UI rollout** — add the mascot branding consistently across all pages (currently only on some) to make the site more welcoming and user-friendly.
- [ ] Additional UI/UX polish pass once mascot integration is complete.

Contributions and suggestions are welcome — feel free to open an issue if you spot something missing.

---

## 📁 Project Structure

```text
├── index.php                   # Root entry point — redirects to public/home.php
├── goa_fishing.sql             # Full database schema + seed data
├── Assets/
│   └── mascot.png              # Website mascot asset
├── public/
│   ├── home.php                # Homepage / Main Portal
│   ├── about.php               # About & Traditional Communities page
│   ├── dashboard.php           # Team Contributor Workspace (Submit Drafts)
│   ├── login.php               # Authentication entry point
│   ├── logout.php              # Session cleanup
│   └── admin/
│       └── dashboard.php       # Admin Control Center & Approval Desk
├── src/
│   ├── config/
│   │   └── config.php          # Database credentials & setup
│   ├── helpers/
│   │   └── audit.php           # Audit logging helper functions
│   └── views/
│       └── partials/
│           ├── header.php      # Global header navigation
│           └── footer.php      # Global footer
└── README.md
```

> `index.php` at the project root simply redirects to `public/home.php`, so the app can be launched from the domain root (e.g. `goa.free.nf/`) without needing `/public/home.php` in the URL.

---

## 🛠️ Database Setup

Import `goa_fishing.sql` (included in the repo root) into your MySQL database via phpMyAdmin or the MySQL CLI — it contains the full schema and seed data shown below.

<details>
<summary>View schema (click to expand)</summary>

```sql
-- Core Pages Table
CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Fish Species Table
CREATE TABLE IF NOT EXISTS fish_species (
    id INT AUTO_INCREMENT PRIMARY KEY,
    common_name VARCHAR(100) NOT NULL,
    scientific_name VARCHAR(100),
    local_konkani_name VARCHAR(100) NOT NULL,
    image_url TEXT NOT NULL,
    habitat VARCHAR(100),
    catch_method VARCHAR(100),
    description TEXT,
    is_state_fish TINYINT(1) DEFAULT 0
);

-- Staging Queue Table for Approvals
CREATE TABLE IF NOT EXISTS pending_edits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_uid VARCHAR(50) NOT NULL,
    user_name VARCHAR(100) NOT NULL,
    target_table VARCHAR(50) NOT NULL,
    target_id INT NULL,
    action_type ENUM('ADD', 'EDIT', 'DELETE') NOT NULL,
    payload JSON NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Audit Logs Table
CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_uid VARCHAR(50) NOT NULL,
    action VARCHAR(50) NOT NULL,
    target_table VARCHAR(50) NOT NULL,
    target_id INT NULL,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- App Settings Table
CREATE TABLE IF NOT EXISTS app_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL,
    updated_by VARCHAR(50),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Default Settings Seed
INSERT INTO app_settings (setting_key, setting_value)
VALUES ('team_signup_code', 'GOA2026')
ON DUPLICATE KEY UPDATE setting_key=setting_key;
```

</details>

---

## 🚀 Installation & Local Development

1. **Clone/Move Repository:** Place project files in your web server root directory (e.g., `htdocs` for XAMPP or `/var/www/html/` for Apache/Nginx). `index.php` at the root will redirect visitors to `public/home.php`.
2. **Configure Database Connection:** Update database credentials in `src/config/config.php`:
   ```php
   $host = 'localhost';
   $user = 'root';
   $pass = '';
   $db   = 'goa_marine_db';
   ```
3. **Verify Asset Paths:** Ensure `mascot.png` is placed in the `Assets/` directory at the project root.
4. **Launch Application:** Open your browser and navigate to `http://localhost/public/index.php`.

---

## 🔑 Default Roles & Workflow

* **Team Members** (`role = 'member'`): Access `public/dashboard.php`. Submissions (new fish, updates, or deletion requests) are stored in `pending_edits`.
* **Admins** (`role = 'admin'`): Access `public/admin/dashboard.php`. Can review pending edits, click Approve (to apply updates to live tables and record audit trails) or Reject.
