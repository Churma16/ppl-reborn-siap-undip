# Academic Information System (SIAP UNDIP Remake)

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![Chart.js](https://img.shields.io/badge/chart.js-F5788D.svg?style=for-the-badge&logo=chart.js&logoColor=white)

A simplified, web-based Academic Information System inspired by **SIAP UNDIP**. This project focuses on digitizing the academic administration workflow, managing interactions between **Students, Lecturers, Departments, and Administrators**.

> **Note:** This is a portfolio project designed to simulate core academic processes and demonstrate complex database relationships and role-based access control.

<!--![System Dashboard](path/to/screenshot.png) -->

## 🚀 Key Features by Role

This system implements **Multi-User Authentication** with four distinct roles:

### 👨‍🎓 1. Student (Mahasiswa)
* **Academic Submission:** Input and manage academic records including:
    * **IRS:** Study Plan entry for the active semester.
    * **KHS:** Submission of Study Results (Grades).
    * **PKL:** Internship (Praktik Kerja Lapangan) progress reporting.
    * **Skripsi:** Thesis progress and final submission.
* **Profile Management:** Update personal data and academic status.

### 👨‍🏫 2. Lecturer / Academic Advisor (Dosen Wali)
* **Verification Workflow:** Review and approve data submitted by students.
    * Verify/Reject IRS (Study Plans).
    * Validate KHS (Grades).
    * Approve PKL and Skripsi entries.
* **Advisory Dashboard:** View list of students under supervision.

### 🏢 3. Department (Departemen)
* **Progress Monitoring:** Visual dashboard to track student milestones.
* **Data Visualization:** Interactive **Charts** displaying:
    * Percentage of students who have completed PKL.
    * Percentage of students who have completed Thesis (Skripsi).
    * Student distribution by status.

### 🛠 4. Administrator (Operator)
* **Master Data Management:** Full CRUD capabilities for **Student Data**.
* **System Configuration:** Manage **Semester Data** (Set active semester, toggle academic periods).
* **User Management:** Create and manage accounts for Lecturers and Department staff.

## ⚙️ Technical Highlights

* **Role-Based Access Control (RBAC):** Middleware implementation to secure routes based on user roles (Admin, Dosen, Mahasiswa, Departemen).
* **Data Visualization:** Integration with Chart.js for Department analytics.
* **Complex Relationships:** Handling One-to-Many and Many-to-Many relationships between Students, Courses, and Semesters.

## 🛠️ Built With

* **Backend:** [Laravel](https://laravel.com/) (PHP)
* **Database:** MySQL
* **Frontend:** Bootstrap  (Blade Templates)
* **Charts:** Chart.js 

## 💻 Installation

1.  **Clone the repository**
    ```bash
    git clone https://github.com/Churma16/ppl-reborn-siap-undip/
    cd ppl-reborn-siap-undip
    ```

2.  **Install dependencies**
    ```bash
    composer install
    ```

3.  **Setup Environment**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Configure Database**
    Set your database credentials in the `.env` file:
    ```env
    DB_DATABASE=db_siap_remake
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Run Migrations & Seeders**
    *(Includes dummy data for Students, Dosen, and Admin)*
    ```bash
    php artisan migrate --seed
    ```

6.  **Run the Server**
    ```bash
    php artisan serve
    ```

## 👤 Author

**Fathan Muhammad Faqih**
* [LinkedIn](https://linkedin.com/in/YOUR-LINKEDIN)
* [GitHub](https://github.com/YOUR-GITHUB)
