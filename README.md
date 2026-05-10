https://web-project-production-71c0.up.railway.app/index.php
#  LifeStream - Blood Donation Management System

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000f?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Leaflet](https://img.shields.io/badge/Leaflet-199903?style=for-the-badge&logo=Leaflet&logoColor=white)
![Status](https://img.shields.io/badge/Status-Production--Ready-success?style=for-the-badge)

**LifeStream** is a modern, high-precision web application designed to bridge the gap between blood donors and patients in emergency situations. Developed specifically for the Aswan Governorate, it ensures that every blood request is accurately mapped to verified medical facilities.

---

##  Key Features

-  **Verified Hospital Mapping:** Uses a pre-verified dataset of hospitals with exact coordinates.
-  **Interactive Leaflet Map:** Real-time visualization of emergency requests.
-  **Urgency System:** Categorizes requests based on blood type and urgency level.
-  **Role-Based Access Control (RBAC):** Distinct dashboards for **Admins** and **Users**.
-  **Secure Authentication:** Built with **PHP PDO** and **Prepared Statements** to prevent SQL Injection.
-  **Fully Responsive UI:** Modern "Glassmorphism" design that works on all devices.
-  **RTL Support:** Full native support for Arabic language and right-to-left layouts.
-  **Admin Insights:** Real-time statistics on requests, donor availability, and hospital load.

---

##  Tech Stack

- **Backend:** PHP 8.x
- **Database:** MySQL (Relational)
- **Database Layer:** PDO (PHP Data Objects)
- **Frontend:** HTML5, CSS3 (Modern UI), Vanilla JavaScript
- **Maps API:** Leaflet.js & OpenStreetMap
- **Deployment:** Railway / InfinityFree

---

##  Smart Map Logic (Technical Overview)

Unlike traditional systems that rely on inaccurate user GPS data, **LifeStream** implements a **Source of Truth** architecture:

1.  **Verified Dataset:** A curated list of hospitals (`hospitals` table) stores precise Latitude/Longitude coordinates verified via Google Places.
2.  **The Join Logic:** When a request is created, it is linked via `hospital_id`. The mapping engine performs an `INNER JOIN` to fetch the verified coordinates, ensuring the marker is pinned exactly on the hospital building.
3.  **Privacy Protection:** User locations are never stored or exposed; only the destination hospital is mapped to protect patient privacy.

---

##  Folder Structure

```text
blood-app/
├── admin/              # Admin-only pages (Dashboard, Requests, Users)
├── assets/             # CSS, Images, and Client-side JS
├── includes/           # Core components (Header, Footer, DB Config)
├── config.php          # Database connection using Environment Variables
├── map-view.php        # The Interactive Map interface
├── request-blood.php   # Blood request submission form
├── final-sync.php      # Database migration & verification script
└── index.php           # Landing page
```

---

##  Installation & Setup

### 1. Clone the repository
```bash
git clone https://github.com/supermohamed55555-hash/web-project.git
cd web-project
```

### 2. Database Setup
1. Create a database named `lifestream_db` in your MySQL server.
2. Import the `lifestream_db.sql` file provided in the repository.
3. Run the synchronization script to verify data:
   `http://localhost/blood-app/final-sync.php`

### 3. Configuration
Edit `config.php` or set the following Environment Variables:
- `MYSQLHOST`: Your DB Host
- `MYSQLUSER`: Your DB Username
- `MYSQLPASSWORD`: Your DB Password
- `MYSQLDATABASE`: lifestream_db

---

##  Why Leaflet instead of Google Maps?

We intentionally chose **Leaflet.js** for this project because:
-  **Open Source:** No expensive API keys or usage quotas.
-  **Performance:** Extremely lightweight and fast on mobile devices.
-  **Privacy:** No tracking or data collection by third-party giants.
-  **Customization:** Full control over map tiles and pulse-effect markers.

---

##  Security Features

- **SQL Injection Prevention:** 100% of queries use PDO Prepared Statements.
- **XSS Protection:** Output sanitization for all user-generated content.
- **Session Security:** Role-based session validation on every administrative page.
- **Password Hashing:** Uses `password_hash()` (bcrypt) for secure credential storage.

---

##  Future Improvements

- [ ] SMS/WhatsApp Notifications for nearby donors.
- [ ] Integration with Ministry of Health official APIs.
- [ ] Donor "Reward Points" system to encourage participation.
- [ ] Mobile App version using React Native.

---

##  Contributors
- **Mohamed Hamdy** - Lead Developer

---

## 📄 License
This project is licensed under the MIT License - see the LICENSE file for details.
