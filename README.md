# Secure Web Login Hardening

## Overview

This project analyzes security weaknesses in a web-based authentication workflow and demonstrates how the application can be hardened using safer front-end and back-end security practices.

The project was developed from academic work completed in a University of Maryland Global Campus Network Security course and reorganized as a cybersecurity portfolio project.

The primary focus is protecting user credentials, preventing SQL injection, improving password handling, strengthening session security, and applying browser-side security controls.

## Vulnerabilities Identified

The original authentication design contained several security weaknesses:

- Login credentials submitted using HTTP GET
- Password displayed using a plain-text input field
- User-controlled input directly concatenated into SQL
- Exposure to SQL injection
- Insecure password handling
- Authentication responses capable of revealing unnecessary information
- Missing Content Security Policy (CSP)

## Security Improvements

The hardened design implements or recommends:

- POST instead of GET for authentication requests
- HTTPS/TLS for protecting credentials in transit
- Password-masked input
- Required fields and reasonable input-length restrictions
- Server-side request validation
- PDO prepared statements
- Parameterized SQL queries
- Password hashing and verification
- Secure session initialization
- Session ID regeneration after successful authentication
- Generic authentication failure messages
- Content Security Policy (CSP)
- Rate limiting or account lockout controls
- Secure session cookies
- Security logging and monitoring
- Environment-based secret management

## Technologies

- HTML
- PHP
- SQL
- PDO
- HTTP/HTTPS
- TLS
- Content Security Policy

## Security Concepts Demonstrated

- SQL injection prevention
- Secure authentication
- Password security
- Session management
- Input validation
- Secure error handling
- Least privilege
- Defense in depth
- Browser security controls
- Secure coding concepts

## Repository Structure

```text
secure-web-login-hardening/
├── README.md
├── .gitignore
├── .env.example
├── src/
│   ├── login.html
│   └── user_credential_check.php
└── docs/
    └── security-analysis.md
