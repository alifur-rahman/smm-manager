# 🚀 SMM Manager for Nextpost
### Optimized for Socialfyy, RapidGrowth, and HelpSocial

[![Nextpost Compatible](https://img.shields.io/badge/Nextpost-Verified-blue.svg?style=for-the-badge&logo=instagram)](https://nextpost.app/)
[![License](https://img.shields.io/badge/License-Private-red.svg?style=for-the-badge)](LICENSE)
[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg?style=for-the-badge)](https://github.com/alifurcoder)
[![Developer](https://img.shields.io/badge/Developer-Alifur%20Rahman-orange.svg?style=for-the-badge)](mailto:alifurcoder@gmail.com)

---

## 🌟 Overview

The **SMM Manager** is a premium extension for the **Nextpost Instagram Automation** system, engineered to provide a seamless bridge between social automation and SMM (Social Media Marketing) panels. Whether you are running a personal growth campaign or managing an international agency like **Socialfyy**, **RapidGrowth**, or **HelpSocial**, this plugin provides the tools necessary to scale your social proof with surgical precision.

By integrating directly with high-performance APIs like **Crescitaly**, this module eliminates the need for manual order management, allowing you to focus on strategy while the system handles the heavy lifting of delivery and tracking.

---

## 🌍 The Nextpost Ecosystem & SMM

**Nextpost** is the industry standard for Instagram automation, offering features like post scheduling, automated direct messaging, and advanced growth interactions (auto-like, auto-follow). 

In the modern Instagram landscape, automation alone is often complemented by **SMM services** to provide initial social proof—likes for "explore page" pushing, followers for brand credibility, and views for video virality. The **SMM Manager** plugin makes this orchestration effortless by embedding a full SMM checkout and monitoring system directly into the Nextpost dashboard.

---

## 🔥 Exclusive Features

### ⚡ AJAX-Driven Service Browser
Browse thousands of services without a single page reload. Our optimized catalog allows you to filter by category, search by service ID, and view detailed descriptions instantly.

### 🤖 Intelligent Auto-Order System
A unique feature designed for rapid account scaling. When configured, the plugin can automatically trigger an SMM order (e.g., a "starter pack" of 100 followers) as soon as a user adds a new Instagram account to the panel. This ensures that every account has immediate social proof from day one.

### ♻️ Automated Lifecycle Management
- **One-Click Refills**: If a service drops, the integrated refill button sends a request to the API provider instantly, ensuring you get exactly what you paid for.
- **Cancelation Support**: Stuck orders? Cancel them directly from the dashboard to reclaim your balance or try a different service.
- **Live Status Sync**: Track your orders from 'Pending' to 'Completed' with real-time API status checks.

### 💰 Centralized Balance Monitoring
Administrators can monitor their API provider's account balance in real-time, preventing service interruptions due to insufficient funds.

### 🏗️ MVC-Compliant Architecture
Built using a strict Model-View-Controller pattern, ensuring that the plugin is stable, secure, and easy for developers to extend or customize for specific agency needs.

---

## 🛠 Installation & Setup

### Requirements
- **Nextpost Instagram Panel** (Latest version recommended)
- **PHP 7.4+**
- **cURL Extension** enabled
- **MySQL 5.7+**

### Step-by-Step Installation
1. **Upload**: Extract and upload the `smm-manager/` folder into your `/plugins/` directory.
2. **Permissions**: Ensure the plugin directory has proper write permissions (`755` or `775`).
3. **Activation**:
    - Log in as Admin.
    - Go to **Settings -> Plugins**.
    - Find **SMM Manager** and click **Activate**.
4. **Database Verification**: The plugin will automatically run the following schema updates:

```sql
-- Schema for Plugin Settings
CREATE TABLE IF NOT EXISTS `np_smm_settings` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `api_url` TEXT NOT NULL,
    `api_key` TEXT NOT NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 1,
    `default_service` TEXT DEFAULT NULL,
    `default_quantity` INT DEFAULT NULL,
    `auto_order` TINYINT(1) NOT NULL DEFAULT 0,
    `expairy_day_before` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## ⚙️ Configuration Guide

### 1. API Synchronization
Navigate to **SMM Manager -> Settings**. Enter your API provider's Endpoint URL and Secret API Key. 
> [!TIP]
> This plugin is pre-optimized for **Crescitaly**, but supports any panel following the standard SMM API v2 specification.

### 2. Auto-Order Setup
Set a "Default Service" and "Default Quantity". Once enabled, the system will use these parameters whenever an automatic order is triggered via the system hooks.

### 3. Package Management
Don't forget to enable the **SMM Manager** module in your **User Packages**. This allows your clients to access the SMM features based on their subscription level.

---

## 📂 Architecture Breakdown

The plugin is structured for maximum performance:
- `/assets`: Contains `minified` CSS and Javascript (AJAX handlers).
- `/controllers`: Logic for order processing, search, and settings management.
- `/core/providers`: Contains the `CrescitalyApi.php` implementation of the `SmmApiInterface`.
- `/models`: Secure database queries using PDO.
- `/views`: Clean, responsive UI fragments based on Nextpost's design system.

---

## ❓ Troubleshooting & FAQ

**Q: Orders are stuck in 'Pending'.**
*A: Check your API Balance in the Settings tab. If your balance is zero, orders will be rejected by the provider.*

**Q: The Refill button is disabled.**
*A: Not all services support refills. The button will only appear for orders where the provider API reports refill availability.*

**Q: Can I use multiple SMM providers?**
*A: Currently, the plugin supports one primary provider at a time. To change providers, simply update the API URL and Key in the settings.*

---

## 👨‍💻 Developer & Credits

**Developed with ❤️ by Alifur Rahman.**

The SMM Manager is a collaborative effort to empower agencies with cutting-edge social automation tools.

### 🛡 Trusted and Used By:
- **RapidGrowth Pro**: [rapidgrowthpro.com](https://rapidgrowthpro.com)
- **Socialfyy**: [socialfyy.com](https://socialfyy.com)
- **HelpSocial**: [helpsocial.ai](https://helpsocial.ai)

---

- **Developer**: [Alifur Rahman](https://github.com/alifurcoder)
- **Support Email**: [alifurcoder@gmail.com](mailto:alifurcoder@gmail.com)

---
*For professional support or custom development inquiries, please reach out via the email listed above.*
