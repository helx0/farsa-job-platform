# Farsa — Job & Opportunity Platform 🇾🇪

Farsa (فرصة) is a full-stack employment platform project designed to connect job seekers with employers through role-based experiences for candidates, employers, and administrators.

> **Status:** Active development / portfolio project. Feature descriptions below summarize the project's intended scope; verify individual components in the source before production use.

## Overview

- **Job seekers:** profiles, skills, job discovery, saved jobs, applications, and application tracking.
- **Employers:** company profiles, job listings, applicant review, and recruitment workflows.
- **Administrators:** platform management and oversight.

The repository contains a PHP/MySQL application alongside frontend and backend workspaces. Not every planned capability is necessarily production-ready.

## Technology

| Area | Technologies |
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
└── README.md
```

## Getting started

### Prerequisites

- PHP and a compatible web server (such as Apache through XAMPP)
- MySQL
- Node.js and npm (for the React frontend)
- Python 3 (for the FastAPI service, if used)

### 1. Clone

```bash
git clone https://github.com/helx0/farsa-job-platform.git
cd farsa-job-platform
```

### 2. Database

1. Start MySQL and create a local development database.
2. Review `database.sql` before importing it.
3. Configure the application's database connection for your local environment.

Never commit passwords, API keys, signing secrets, or real user data.

### 3. PHP application

Place the project in your local web-server document root (for example, `C:\\xampp\\htdocs\\farsa-job-platform`), start Apache and MySQL, and open the matching local URL. Review PHP configuration first; paths and database settings may need adjustment.

### 4. Frontend (if working on it)

```bash
cd frontend
npm install
```

Use the development script defined in `frontend/package.json`.

### 5. Python service (if working on it)

```bash
cd backend
python -m venv .venv
```

Activate the environment, install dependencies from the backend requirements file, and follow the service entry point/configuration in the source.

## Security and deployment

This is a development and portfolio project. Before public deployment:

- Move credentials and secrets into environment variables or secure server-side configuration.
- Rotate any secret that may have been committed previously.
- Review authentication, authorization, session handling, and password hashing.
- Validate and safely store uploaded files.
- Disable debug output and development/diagnostic endpoints.
- Configure HTTPS, secure cookies, and restrictive CORS rules.
- Review database queries and input validation.
- Use a separate production database; do not deploy demo accounts or sample data.
- Run security and functional tests against the deployed configuration.

## Roadmap

- [ ] Verify and document the current setup end-to-end
- [ ] Add screenshots of the working application
- [ ] Document database schema and relationships
- [ ] Document API endpoints with examples
- [ ] Add repeatable automated tests
- [ ] Add continuous integration checks
- [ ] Review production security and deployment configuration

## Author

**Ehab Tawfik Ahmed**  
Information Technology Student | Software Development  
GitHub: [@helx0](https://github.com/helx0)

## License

No license has been selected yet. Until one is added, the repository is all rights reserved by default.

---

Farsa is an evolving project. Feature descriptions should be treated as project scope or implementation areas unless verified in the current code.
