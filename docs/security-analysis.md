# Secure Web Login — Security Analysis

## Project Objective

The objective of this project was to analyze an insecure web authentication workflow, identify security weaknesses, and develop recommendations and code-level improvements to strengthen the authentication process.

The analysis focused on credential protection, SQL injection prevention, password security, session management, browser security controls, and defense-in-depth practices.

---

## 1. Authentication Using HTTP GET

### Vulnerability

The original login form submitted the user ID and password using the HTTP GET method.

GET places submitted parameters in the request URL. Sensitive authentication information should not be transmitted through URL query strings because URLs may be stored or exposed through browser history, server logs, monitoring systems, or other locations.

### Remediation

The hardened login form uses:

```html
<form method="post" action="user_credential_check.php">
