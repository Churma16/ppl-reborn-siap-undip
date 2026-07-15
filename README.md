# Academic Information System (SIAP UNDIP Remake)

[![PHP Version](https://img.shields.io/badge/PHP-%5E8.0-777BB4?logo=php&logoColor=white)](https://php.net) [![Laravel Version](https://img.shields.io/badge/Laravel-%5E9.0-FF2D20?logo=laravel&logoColor=white)](https://laravel.com) [![MySQL](https://img.shields.io/badge/MySQL-%2300f.svg?style=flat&logo=mysql&logoColor=white)](https://mysql.com) [![Docker Support](https://img.shields.io/badge/Docker-Support-2496ED?logo=docker&logoColor=white)](https://www.docker.com/) [![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

A simplified, web-based Academic Information System inspired by SIAP UNDIP. This project focuses on digitizing the academic administration workflow, managing interactions between Students, Lecturers, Departments, and Administrators. This is a portfolio project designed to simulate core academic processes and demonstrate complex database relationships and role-based access control.

---

## Key Features

### Student (Mahasiswa)
*   **Academic Submission**: Input and manage academic records including:
    *   **IRS**: Study Plan entry for the active semester.
    *   **KHS**: Submission of Study Results (Grades).
    *   **PKL**: Internship progress reporting.
    *   **Skripsi**: Thesis progress and final submission.
*   **Profile Management**: Update personal data and academic status.

### Lecturer / Academic Advisor (Dosen Wali)
*   **Verification Workflow**: Review and approve data submitted by students.
    *   Verify or reject IRS (Study Plans).
    *   Validate KHS (Grades).
    *   Approve PKL and Skripsi entries.
*   **Advisory Dashboard**: View list of students under supervision.

### Department (Departemen)
*   **Progress Monitoring**: Visual dashboard to track student milestones.
*   **Data Visualization**: Interactive charts displaying:
    *   Percentage of students who have completed PKL.
    *   Percentage of students who have completed Thesis (Skripsi).
    *   Student distribution by status.
*   **Export Data**: Generate and export reports in PDF and Excel formats.

### Administrator (Operator)
*   **Master Data Management**: Full CRUD capabilities for Student Data.
*   **System Configuration**: Manage Semester Data (Set active semester, toggle academic periods).
*   **User Management**: Create and manage accounts for Lecturers and Department staff.

---

## Tech Stack & Libraries

*   **Backend**: Laravel 9.x (PHP)
*   **Database**: MySQL
*   **Frontend**: Bootstrap (Blade Templates)
*   **Data Visualization**: Chart.js
*   **Document Generation**: barryvdh/laravel-dompdf (PDF), maatwebsite/excel (Excel)
*   **Authentication**: Multi-User Authentication with Laravel Sanctum

---

## Installation & Setup

### Method 1: Using Docker (Recommended)

#### Prerequisites
*   Docker and Docker Compose installed on your system.

#### Steps
1.  **Clone and Navigate**:
    ```bash
    git clone https://github.com/Churma16/ppl-reborn-siap-undip.git
    cd ppl-reborn-siap-undip
    ```
2.  **Start Services**:
    Run the following command to build the image, start the database, run migrations, and serve the application automatically:
    ```bash
    docker-compose up -d --build
    ```
3.  **Access the Application**:
    The Laravel app will be available at `http://127.0.0.1:8001`.

*(To seed the database with dummy users, run `docker-compose exec app php artisan db:seed` after the app is up).*

### Method 2: Manual Local Setup

#### Prerequisites
*   PHP >= 8.0.2
*   Composer
*   MySQL Database instance running locally

#### Steps
1.  **Clone and Navigate**:
    ```bash
    git clone https://github.com/Churma16/ppl-reborn-siap-undip.git
    cd ppl-reborn-siap-undip
    ```
2.  **Install Dependencies**:
    ```bash
    composer install
    ```
3.  **Environment Configuration**:
    Create `.env` based on `.env.example`:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  **Configure Database**:
    Set your database credentials in the `.env` file:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_siap_remake
    DB_USERNAME=root
    DB_PASSWORD=
    ```
5.  **Run Migrations and Seeders**:
    This will create the necessary tables and populate them with dummy data for Students, Lecturers, and Admin.
    ```bash
    php artisan migrate --seed
    ```
6.  **Run Development Server**:
    ```bash
    php artisan serve
    ```

---

## Acknowledgements

This repository is a complete rebuild of a legacy procedural PHP coursework project into a structured Laravel MVC architecture to benchmark personal engineering growth. The codebase was modernized by replacing raw SQL with Eloquent ORM, implementing database migrations and seeders, and securing the academic workflow (IRS, KHS, PKL, Skripsi) via middleware-enforced RBAC across 4 roles.

Special thanks and appreciation to:
*   **Original Project**: [PPL_C_2022_3](https://github.com/renyaw/PPL_C_2022_3) for the initial legacy codebase.
*   **Universitas Diponegoro (UNDIP)**: For the inspiration behind the SIAP system workflow.

---

## Author

**Fathan Muhammad Faqih**
*   LinkedIn: [Fathan Muhammad Faqih](https://linkedin.com/in/YOUR-LINKEDIN)
*   GitHub: [Churma16](https://github.com/Churma16)

---

## License

This project is licensed under the [MIT License](LICENSE).
