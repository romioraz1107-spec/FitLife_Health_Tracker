
FitLife Health Tracker (PHP + MySQL) — ready for MAMP
=====================================================
What this is
------------
A minimal health-tracking starter you can run on MAMP. It includes:
- User Register/Login (password hashing, prepared statements)
- Profile (gender, age, height, weight)
- BMI & BMR calculator (based on your profile)
- Daily log (water, steps, calories)
- Simple, dark UI
How to run on MAMP (macOS)
--------------------------
1) Start MAMP. Ensure MySQL runs on port 8889 (MAMP default). Default credentials: user=root, password=root.
2) Open phpMyAdmin from MAMP, and import the SQL file: sql/schema.sql (creates database `fitlife_db`).
3) Copy the entire folder 'FitLife_Health_Tracker_MAMP_PHP' into your MAMP document root (e.g., /Applications/MAMP/htdocs/).
4) Visit: http://localhost:8888/FitLife_Health_Tracker_MAMP_PHP  (adjust if your Apache port differs).
5) Change DB settings in config.php if your ports/creds differ.
