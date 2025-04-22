# 🎓 Education ERP System (Laravel)

A powerful and modular **Education ERP System** built using Laravel. This project simplifies the management of school data including students, employees, attendance, marks, salaries, and more—integrated with role-based access for Admin, Teacher, Accounts, Student users.

---

## 🚀 Features

- 🔐 **Authentication**
  - Login via email
  - View Dashboard data according to role and permission
  - Session-based secure access

- 👤 **User Management**
  - Add/Edit/Delete users
  - Assign roles & permissions dynamically

- 🎓 **Student Management**
  - Manage student profiles
  - Record attendance
  - Add/view marks
  - Fee management

- 🧑‍🏫 **Employee Management**
  - Add/edit employee details
  - Assign roles
  - Manage salary records

- 🧾 **Accounts Module**
  - Fee and salary management
  - Razorpay integration for payments
  - WhatsApp API for attendence notifications
  - Monthly reports

- 📅 **Attendance & Timetable**
  - View and manage daily attendance
  - Daily timetable view (students/teachers)

- 📊 **Reports and Analytics**
  - Student fee reports
  - Employee salary status
  - Graphs for earnings and statistics

---

## 🛠️ Tech Stack

- **Backend:** Laravel (MVC)
- **Frontend:** Blade Templates, HTML5, CSS3, JavaScript
- **Database:** MySQL
- **Payment Gateway:** Razorpay API
- **Messaging:** WhatsApp API (send daily attendence to there parents Notifications)
- **Authentication:** with E-mail and Password

---

## 📦 Installation & Setup

### ✅ Requirements

- PHP >= 8.1
- Composer
- MySQL
- XAMPP/WAMP/Laragon
- Node.js & npm (optional for frontend assets)

### ⚙️ Steps to Run Locally

```bash
# Clone the repository
git clone https://github.com/TusharU2004/Education_ERP.git
cd Education_ERP

# Install dependencies
composer install

# Copy environment file and set up keys
cp .env.example .env
php artisan key:generate

# Configure your .env file (DB, Mail, Razorpay keys, etc.)

# Run database migrations
php artisan migrate

# (Optional) Seed roles and permissions
php artisan db:seed

# Run the server
php artisan serve
```
Visit http://127.0.0.1:8000 in your browser.

### 🔒 Default Roles

 - Admin: All modules including user, student, employee
 - Teacher: Timetable, Marks, Student Management
 - Accounts: Fee & Salary, Transactions, Reports

### 📸 Screenshots
 - Login Page
   ![image](https://github.com/user-attachments/assets/64d430be-a9f9-4712-98bf-5ad4d2d836d8)
 - Admin Dashboard
   ![image](https://github.com/user-attachments/assets/56939363-fec6-4487-9f78-5aebcf7b23b5)
 - Student Dashboard
   ![image](https://github.com/user-attachments/assets/416263c3-dc52-48d8-ac1c-6dc0e0958cdd)

 ### 📄 Documentation Includes
 - ✅ Software Requirements Specification (SRS)
 - ✅ DFD Level 1 and Level 2 (PlantUML included)
 - ✅ Flowcharts & Algorithm
 - ✅ Test Cases & Results
 - ✅ User Manual
 - ✅ Installation Guide

 ### 👨‍💼 Internship Experience
 - Built as part of academic project during internship at Nectar Infoway, this system demonstrates hands-on experience in Laravel, backend logic, MySQL, and real-world application integration such as payment APIs and role-based access control.

 ### 🙋 Author
 - Umretiya Tushar
 - Intern at Nectar Infoway
 - 📧 tusharumretiya11@gmail.com
 
