# SEG — نظام إدارة (PHP + MySQL)

نظام PHP + MySQL (لوحة تحكم `control_panel/`) — بدون مكتبات خارجية.

## المتطلبات
- PHP 8.x + MySQL/MariaDB (XAMPP) — لا يحتاج Composer

## التشغيل
1. انسخ المشروع إلى `htdocs/SEG`
2. أنشئ قاعدة بيانات `se` (حسب `control_panel/conect.php`):
   ```sql
   CREATE DATABASE se CHARACTER SET utf8mb4;
   ```
   ثم استورد ملف `se.sql`:
   - phpMyAdmin ← استيراد ← `se.sql`
3. إعداد الاتصال في `control_panel/conect.php` (الوضع الافتراضي: `root` بدون كلمة سر)
4. افتح: `http://localhost/SEG/main.php`
