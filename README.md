# Farsa — Intelligent Job Matching Platform 🇾🇪

> A full-stack employment platform designed to connect job seekers and employers, with intelligent job matching, applications, communication, courses, certificates, and role-based dashboards.

[![Status](https://img.shields.io/badge/status-in%20development-orange)](https://github.com/helx0/farsa-job-platform)
[![PHP](https://img.shields.io/badge/PHP-8%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![React](https://img.shields.io/badge/React-19-61DAFB?logo=react&logoColor=black)](https://react.dev/)
[![Python](https://img.shields.io/badge/Python-3.x-3776AB?logo=python&logoColor=white)](https://www.python.org/)
[![FastAPI](https://img.shields.io/badge/FastAPI-API-009688?logo=fastapi&logoColor=white)](https://fastapi.tiangolo.com/)

---

## 📌 Overview

**Farsa (فرصة)** is a multi-role job platform concept focused on the Yemeni employment market.

The project provides separate experiences for:

- 👤 **Job Seekers** — create profiles, manage skills and experience, search for jobs, save jobs, apply, communicate, and track applications.
- 🏢 **Employers** — manage company profiles, publish jobs, review applications, communicate with candidates, and manage hiring-related data.
- 🛡️ **Administrators** — manage users, companies, jobs, platform statistics, logs, and administrative operations.

The platform also includes supporting features such as courses, certificates, notifications, reviews, referrals, subscriptions, and certificate verification.

---

## ✨ Key Features

### 👤 Job Seeker
- Registration and authentication
- Profile management
- Skills, education, and work experience
- CV/resume information
- Job search and filtering
- Job details
- Saved jobs
- Job applications
- Application status tracking
- Messages and notifications
- Courses and enrollment
- Certificates and verification
- Profile completeness and CV-related scoring

### 🏢 Employer
- Employer/company profile
- Company verification workflow
- Job posting and management
- Applicant management
- Candidate matching information
- Messaging
- Company statistics
- Subscription plans

### 🛡️ Administration
- User management
- Employer/company management
- Job management
- Platform statistics
- Administrative logs
- Moderation and verification workflows

### 🧠 Matching System

Farsa includes a weighted matching model that considers:

| Factor | Weight |
|---|---:|
| Skills | 40% |
| Experience | 25% |
| Education | 15% |
| Location | 10% |
| Salary | 10% |

These weights are currently represented in the application configuration and can be refined as the matching system evolves.

### 🔐 Security-Oriented Features
- Password hashing
- CSRF token support
- Input validation
- Session management
- Role-based access concepts
- Email verification support
- Two-factor authentication support
- JWT-based authentication components
- Error logging

### ⛓️ Certificate Verification

The project contains a certificate verification component with blockchain-style records and hashes intended to provide an additional verification layer for credentials.

> This is an application-level implementation for the project and should not be interpreted as a production public blockchain network.

---

## 🏗️ Architecture

The repository currently contains multiple application layers:

```text
┌───────────────────────────────────────────────────────────┐
│                       Farsa Platform                      │
├───────────────────────────────────────────────────────────┤
│ Presentation Layer                                        │
│ PHP Pages + HTML/CSS/JS + React Frontend                 │
├───────────────────────────────────────────────────────────┤
│ Application / API Layer                                   │
│ PHP APIs + Python/FastAPI Backend                         │
├───────────────────────────────────────────────────────────┤
│ Business Logic                                            │
│ Authentication • Jobs • Applications • Matching          │
│ Messaging • Courses • Certificates • Administration       │
├───────────────────────────────────────────────────────────┤
│ Data Layer                                                │
│ MySQL Database                                            │
├───────────────────────────────────────────────────────────┤
│ Supporting Components                                     │
│ Blockchain-style Verification • Notifications • Logging  │
└───────────────────────────────────────────────────────────┘
```

Detailed architecture documentation will be added under `docs/`.

---

## 🧰 Technology Stack

### Backend
- PHP
- MySQL / MySQLi
- REST-style PHP APIs
- Python
- FastAPI
- JWT-related authentication components

### Frontend
- HTML5
- CSS3
- JavaScript
- React
- React Router
- Tailwind CSS
- Lucide React
- Axios

### Development
- XAMPP
- Git
- GitHub
- Node.js / npm or Yarn
- Python virtual environments

---

## 📁 Project Structure

```text
farsa-job-platform/
│
├── backend/                 # Python/FastAPI backend
│
├── frontend/                # React frontend
│   ├── public/
│   └── src/
│
├── css/                     # Main application styles
├── js/                      # Main JavaScript modules
│
├── includes/                # Shared PHP layout components
├── pages/                   # Application pages
│   ├── auth/
│   └── dashboard/
│       ├── admin/
│       ├── employer/
│       └── job-seeker/
│
├── php/
│   ├── api/                 # PHP API endpoints
│   ├── blockchain/          # Certificate verification logic
│   ├── includes/            # Shared PHP business logic
│   └── migrations/          # Database migrations
│
├── database.sql             # Main database schema/demo data
├── import_db.sql            # Database import helper
├── manifest.json             # PWA metadata
├── .gitignore
└── README.md
```

---

## 🗄️ Database

The main schema is available in:

```text
database.sql
```

The database is designed around entities including:

- Users
- Job seekers
- Employers
- Jobs
- Job categories
- Skills
- Applications
- Saved jobs
- Education
- Experience
- Certificates
- Blockchain records
- Courses
- Course enrollments
- Notifications
- Messages
- Referrals
- Reviews
- Admin logs
- Platform statistics
- Subscriptions
- Exchange rates

Database documentation and an ER diagram are planned under `docs/`.

---

## 🚀 Local Development

### Requirements

Install:

- XAMPP
- PHP 8+
- MySQL
- Node.js
- Python 3.x
- Git

### 1. Clone the repository

```bash
git clone https://github.com/helx0/farsa-job-platform.git
cd farsa-job-platform
```

### 2. Configure MySQL

Create the database and import:

```text
database.sql
```

The default development configuration expects:

```text
Host: localhost
Port: 3306
Database: helxdb
User: root
Password: empty
```

> These are development defaults only. Production credentials should never be committed to the repository.

### 3. Run PHP with XAMPP

Place the project inside the XAMPP web root, for example:

```text
C:\xampp\htdocs\farsa-job-platform
```

Start:

- Apache
- MySQL

Then open the local application using the configured local URL.

### 4. Run the React frontend

```bash
cd frontend
npm install
npm start
```

Or use Yarn if preferred:

```bash
yarn install
yarn start
```

### 5. Run the Python backend

Create a virtual environment:

```bash
cd backend
python -m venv venv
```

Activate it on Windows:

```powershell
.\venv\Scripts\Activate.ps1
```

Install dependencies:

```bash
pip install -r requirements.txt
```

Start the FastAPI application according to the entry points defined in `server.py`.

---

## 🔑 Demo Data

The database schema currently contains demonstration records intended for local development and testing.

**Do not use the bundled demo credentials or sample secrets in production.**

---

## 🔒 Security Notes

This repository is a development/portfolio project.

Before production deployment, the following should be completed:

- Move secrets and environment-specific configuration outside source control.
- Rotate any credentials or signing secrets that have ever been committed.
- Use environment variables for database, JWT, SMTP, and external-service credentials.
- Review CORS configuration.
- Review authentication and authorization boundaries.
- Disable development/debug endpoints in production.
- Protect uploaded files and validate file types/content.
- Add rate limiting to authentication and sensitive APIs.
- Add automated security tests.
- Review SQL queries and prepared-statement usage across all endpoints.
- Configure HTTPS and secure session cookies.
- Separate demo/test data from production data.

---

## 🧪 Testing

The repository contains test and diagnostic material used during development.

As the project matures, automated tests will be organized under:

```text
tests/
```

and integrated into a GitHub Actions CI workflow.

---

## 🗺️ Roadmap

- [x] Multi-role authentication foundation
- [x] Job management foundation
- [x] Job applications
- [x] Employer and job seeker dashboards
- [x] Messaging and notifications foundation
- [x] Course and certificate entities
- [x] Matching model foundation
- [ ] Production-ready environment configuration
- [ ] Automated backend tests
- [ ] Frontend test suite
- [ ] CI/CD pipeline
- [ ] API documentation
- [ ] Database ER diagram
- [ ] Portfolio screenshots
- [ ] Deployment configuration
- [ ] Advanced AI-based job recommendation
- [ ] Production-grade certificate verification

---

## 📚 Documentation

Planned documentation:

- `docs/architecture.md` — system architecture
- `docs/database.md` — database design
- `docs/api.md` — API reference
- `docs/security.md` — security considerations
- `docs/development.md` — development workflow

---

## 🎓 Project Purpose

Farsa is designed as a practical full-stack software engineering project demonstrating:

- Requirements analysis
- Database design
- Backend development
- REST API development
- Frontend development
- Authentication and authorization
- Role-based systems
- Search and matching logic
- File handling
- Notifications and messaging
- Security concepts
- Git/GitHub workflow
- Multi-stack application architecture

---

## 👨‍💻 Author

**Ehab Tawfik Ahmed**

IT Student & Software Developer

GitHub: [@helx0](https://github.com/helx0)

---

## 📄 License

A license has not yet been selected for this project.

Until a license is added, the repository should be treated as **all rights reserved** for reuse purposes.

---

## ⭐ Project Note

Farsa is an evolving educational and portfolio project. The repository is being actively organized to make the architecture, implementation decisions, development process, and future improvements easier to understand and review.
