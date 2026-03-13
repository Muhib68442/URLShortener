# Assignment : 04

### Name : Md. Muhibbur Rahman

### Email: muhib2929@gmail.com

---

<br>

# URL Shortener API

A fully functional **URL Shortener** built with **Laravel** and **Sanctum API authentication**, designed to safely create, manage, and track short URLs. The project is secure, stable, and IDOR-safe with proper policies applied.

---

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Setup & Installation](#setup--installation)
- [API Endpoints](#api-endpoints)
- [IDOR & Security](#idor--security)
- [Validation & Error Handling](#validation--error-handling)
- [Stability](#stability)
- [License](#license)

---

## Features

- **User Authentication**
    - Register, Login, Logout
    - Sanctum API token authentication
- **User Management**
    - View profile
    - Update name & email
    - Delete account
- **URL Management**
    - Create, List, View, Update, Delete URLs
    - Auto-generated 6-character short codes
    - Default 7-day expiry with optional custom expiry
    - Click tracking for each URL
- **Public Redirection**
    - Redirect using `/{short_code}`
    - Increment click count
    - Handles expired URLs (410) and non-existing URLs (404)
- **Security**
    - IDOR prevention using Laravel Policies
    - Validation on all requests (URL format, email uniqueness, password confirmation)
- **Relationships**
    - Each URL belongs to a user
    - Users can have multiple URLs

---

## Technologies Used

- **Backend:** Laravel 12, PHP 8+
- **Authentication:** Laravel Sanctum
- **Database:** MySQL
- **API Testing:** Postman / Any REST client

---

## Setup & Installation

1. Clone the repository

```bash
git clone -b main https://github.com/Muhib68442/URLShortener.git
cd URLShortener
```

2.  Install dependencies

```bash
composer install
cp .env.example .env
php artisan key:generate
```

3. Configure `.env`

```bash
APP_NAME=URLShortener
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=
```

4. Run Migration

```bash
php artisan migrate
```

5. Start

```bash
php artisan serve
```

## API Endpoints

### User Authentication

| Method | Endpoint  | Description       |
| ------ | --------- | ----------------- |
| POST   | /register | Register new user |
| POST   | /login    | Login user        |
| GET    | /logout   | Logout user       |
| GET    | /check    | Check auth status |

### User Management

| Method | Endpoint | Description       |
| ------ | -------- | ----------------- |
| GET    | /user    | View profile      |
| PATCH  | /user    | Update name/email |
| DELETE | /user    | Delete account    |

### URL Management

| Method | Endpoint           | Description                         |
| ------ | ------------------ | ----------------------------------- |
| POST   | /urls              | Create new URL                      |
| GET    | /urls              | List all URLs of logged-in user     |
| GET    | /urls/{short_code} | View single URL details (IDOR-safe) |
| PATCH  | /urls/{short_code} | Update URL or expiry (IDOR-safe)    |
| DELETE | /urls/{short_code} | Delete URL (IDOR-safe)              |

### Public Redirection

| Method | Endpoint      | Description                                       |
| ------ | ------------- | ------------------------------------------------- |
| GET    | /{short_code} | Redirect to original URL (increments click count) |

#### Redirection Rules:

- Exists → 302 redirect
- Expired → 410 Gone
- Not found → 404 Not Found

> Note: Please find a Postman Collection in the project root directory in JSON format that might help you test the API.

#### IDOR & Security

- Laravel Policies prevent users from accessing or modifying URLs they do not own.
- Applied policy: UrlPolicy@manage on view, update, delete operations.
- Public redirect does not require authentication but handles expiration and non-existent URLs safely.

#### Validation & Error Handling

- Email: Must be unique during registration
- Password: Minimum 8 characters & confirmed
- URL: Must be valid format
- Expiry: Must be valid date (YYYY-MM-DD HH:MM:SS)
- Responses: Proper HTTP status codes (200, 201, 204, 401, 404, 410, 422)

#### Stability

- Fully tested CRUD operations on URLs
- Safe redirection with click tracking
- Policies ensure no IDOR attacks
- Handles all edge cases (non-existent, expired URLs, invalid inputs)
- Uses proper Laravel relationships (User -> Url)
- Secure token-based authentication with Laravel Sanctum

#### License

- This project is open-source and free to use for learning and personal projects.

> Note: All operations requiring authentication use Sanctum tokens. Public access is limited to redirection only.
