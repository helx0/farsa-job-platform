# Farsa — Job & Opportunity Platform 🇾🇪

Farsa (فرصة) is a full-stack employment platform project designed to connect job seekers with employers, with role-based experiences for candidates, employers, and administrators.

> **Project status:** Active development / portfolio project. Features and setup instructions should be validated against the current code before production use.

## Overview

Farsa aims to provide a single place to discover opportunities and manage the recruitment process.

- **Job seekers:** profiles, skills, job discovery, saved jobs, applications, and application tracking.
- **Employers:** company profiles, job listings, applicant review, and recruitment workflows.
- **Administrators:** platform-level management and oversight.

The repository contains a PHP/MySQL application alongside frontend and backend components. The codebase is evolving, so not every planned capability should be assumed to be production-ready.

## Technology

| Area | Technologies present in the repository |
|---|---|
| Core application | PHP, MySQL |
| Web interface | HTML, CSS, JavaScript |
| Frontend workspace | React |
| Backend workspace | Python, FastAPI |
| Development | Git, GitHub, XAMPP, Node.js |

## Repository structure

```text
farsa-job-platform/
├── backend/       # Python / FastAPI service
├── frontend/      # React application
├── css/           # Stylesheets
├── js/            # Browser-side JavaScript
├── includes/      # Shared PHP components
├── pages/         # Application pages and dashboards
├── php/           # PHP APIs and supporting logic
├── tests/         # Test and diagnostic resources
├── database.sql   # Database schema / seed material
├── README.md
└── .gitignore
```

Some directories and features may still be under development. Check the source and configuration files before relying on a component.

## Getting started

### Prerequisites

- PHP and a compatible web server (for example, Apache through XAMPP)
- MySQL
- Node.js and npm (for the React frontend)
- Python 3 (for the FastAPI service, if you intend to run it)

### 1. Clone the repository

```bash
git clone https://github.com/helx0/farsa-job-platform.git
cd farsa-job-platform
```

### 2. Set up the database

1. Start MySQL.
2. Create a local development database.
3. Review `database.sql` before importing it.
4. Configure the application's database connection using local settings.

Do not use production credentials in source files. Never commit passwords, API keys, signing secrets, or real user data.

### 3. Run the PHP application

Place the project in your local web-server document root (for example, `C:\\xampp\\htdocs\\farsa-job-platform`), start Apache and MySQL, and open the matching local URL.

Review the project's PHP configuration first; paths and database settings may need to be adjusted for your environment.

### 4. Run the frontend (if working on it)

```bash
cd frontend
npm install
```

Then use the start or development script defined in `frontend/package.json`.

### 5. Run the Python service (if working on it)

```bash
cd backend
python -m venv .venv
```

Activate the virtual environment, install the dependencies listed in the backend requirements file, and follow the service entry point/configuration in the source.

## Security and deployment

This repository is a development and portfolio project. Before any public deployment:

- Move all credentials and secrets into environment variables or secure server-side configuration.
- Rotate any secret that may have been committed previously.
- Review authentication, authorization, session handling, and password hashing.
- Validate and safely store uploaded files.
- Disable debug output and development/diagnostic endpoints.
- Configure HTTPS, secure cookies, and restrictive CORS rules.
- Review database queries and input validation.
- Use a separate production database; do not deploy demo accounts or sample data.
- Run security and functional tests against the deployed configuration.

## Roadmap

- [ ] Verify and document the current local setup end-to-end
- [ ] Add screenshots of the working application
- [ ] Document the database schema and relationships
- [ ] Document API endpoints and request/response examples
- [ ] Add repeatable automated tests
- [ ] Add continuous integration checks
- [ ] Review production security and deployment configuration
- [ ] Document the matching approach and its evaluation

## About the author

**Ehab Tawfik Ahmed**  
Information Technology Student | Software Development

- GitHub: [@helx0](https://github.com/helx0)

## Notes

Farsa is an evolving project. Please treat feature descriptions as project goals or implementation areas unless they have been verified in the current version of the code. No license has been added yet; all rights are reserved by default.
