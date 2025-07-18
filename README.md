# Bliss - Daycare Management System

Bliss is a comprehensive web application designed to streamline operations and enhance communication between daycare centers, parents, caregivers, and administrators. This platform ensures efficiency, transparency, and high-quality care through a range of features tailored to daycare management needs.

## Overview

The Bliss project is built using PHP, MySQL, HTML, CSS, and JavaScript, with a structured folder architecture named `bliss`. It provides role-based access for parents, caregivers, and admins, managing profiles, attendance, billing, meal planning, special care, and more. The system is designed to be scalable and user-friendly, with real-time notifications and detailed reporting capabilities.

## Prerequisites

### Tools
- **Git** (for version control)
- **Web Server** (e.g., Apache or Nginx, manually configured)
- **MySQL Workbench** (for database management)

### Languages
- **PHP** (manually installed, version 7.4 or higher)
- **HTML**
- **CSS**
- **JavaScript**

### Database
- **MySQL** (version 8.0 or higher, managed via MySQL Workbench)

## Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/bliss.git
   cd bliss
   ```

2. **Set Up the Database**
   - Open MySQL Workbench and create a new database named `dcm`.
   - Import the provided MySQL dump file (`dcm.sql`) into the `dcm` database:
     ```sql
     USE dcm;
     SOURCE path/to/dcm.sql;
     ```
   - Update the database connection details in `includes/db_connect.php` with your MySQL credentials (e.g., host, username, password).

3. **Configure the Environment**
   - Copy `config/config.php.example` to `config/config.php` and adjust settings as needed (e.g., base URL, timezone).

4. **Run the Application**
   - Start your manually configured web server and access the application via `http://localhost/bliss`.

## Features

### 1. Profile Creation
- Secure, role-based profiles for parents, caregivers, and admins.
- Attributes include name, contact info, role, and linked children.
- Caregiver profiles track qualifications, work history, and availability.
- Admin profiles allow role and permission management.
- Role-based access control (RBAC) ensures security and privacy.
- Notifications for profile updates.

### 2. Caregiver Hiring Process
- Application process with qualification and work history uploads.
- Qualification verification for certifications and experience.
- Caregiver matching based on children's specific needs.
- Admin approval system for new caregivers.
- Searchable database of caregivers by skills, availability, and experience.
- Parent notification and approval for caregivers.

### 3. Pick-Up & Drop-Off Management
- Check-in/check-out system for attendance tracking.
- Real-time notifications for pick-up and drop-off times.
- Automated absentee alerts if a child is not checked in.
- Attendance history exportable for analysis and billing.
- Dashboard for guardians to view attendance details.

### 4. Special Child Care Support
- Custom care plans for medical, developmental, or physical needs.
- Caregiver matching for children requiring special care.
- Detailed recording of special needs in child profiles.
- Parent interface for inputting specific care requirements.

### 5. Meal Planning
- Scheduled meal plans with dietary preferences and allergies.
- Management of dietary restrictions (e.g., gluten-free, vegetarian).
- Parent feedback collection on meal preferences.
- Meal history logging with feedback.

### 6. Day Care Diary
- Logging of daily activities (meals, play, study, etc.).
- Real-time notifications for parents via SMS or email.
- Timeline view of a child’s day with timestamps.
- Activity history for past reviews and milestones.

### 7. Learning Journey
- Tracking of developmental milestones and educational progress.
- Parent portal for milestone and skill progress viewing.
- Customizable learning plans adjustable by parents and caregivers.

### 8. Bill & Payment
- Automated invoice generation for stays, meals, and special services.
- Payment tracking with status updates.
- Parent portal for viewing invoices, payment history, and balances.
- Multiple payment methods (credit card, PayPal, bank transfer).
- Admin reports for financial summaries and exports.

## Folder Structure

- **assets/**
  - **css/**: Stylesheets for the Bliss platform.
  - **images/**: Static images used in the UI.
  - **js/**: JavaScript files (e.g., `javascript.js` for client-side logic).
- **config/**: Configuration files (e.g., `config.php`).
- **controllers/**: PHP controllers handling business logic (e.g., `AttendanceController.php`, `PaymentController.php`, `ProfileController.php`).
- **includes/**: Shared PHP files (e.g., `db_connect.php`, `footer.php`, `header.php`).
- **logs/**: Log files for auditing and debugging.
- **models/**: PHP models representing database tables (e.g., `caregivers.php`, `child.php`, `invoice.php`, `user.php`).
- **uploads/**: Directory for uploaded files.
- **views/**: View templates for the UI (e.g., `attendance.php`, `attendance_view.php`, `dashboard_view.php`, `profile_view.php`, etc.).

## Usage

- **Parents/Guardians**: Log in to view attendance, activities, invoices, and manage child profiles.
- **Caregivers**: Log activities, check-in/check-out children, and update care plans.
- **Admins**: Manage users, approve caregivers, and generate financial reports.

## Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit your changes (`git commit -m "Add new feature"`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a pull request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## UI Screenshots

- **Profile Creation Screen**
  [Placeholder for screenshot]

- **Caregiver Hiring Process Screen**
  [Placeholder for screenshot]

- **Pick-Up & Drop-Off Management Screen**
  [Placeholder for screenshot]

- **Special Child Care Support Screen**
  [Placeholder for screenshot]

- **Meal Planning Screen**
  [Placeholder for screenshot]

- **Day Care Diary Screen**
  [Placeholder for screenshot]

- **Learning Journey Screen**
  [Placeholder for screenshot]

- **Bill & Payment Screen**
  [Placeholder for screenshot]