# Resource Management API - Backend

## Overview

This is the backend API for the Resource Management Dashboard, built using Laravel 12. It provides a RESTful interface for managing resources (Projects), handling user authentication and authorization, and serving data for reporting and analytics.

## Public Repository

[Resource Management API: https://github.com/ruelrule05/resource-management-api](https://github.com/ruelrule05/resource-management-api)

## Setup Instructions (Using Laravel Sail - Recommended)

Ensure you have Docker Desktop installed and running.

1.  **Clone the Backend Repository:**
    ```bash
    git clone [https://github.com/ruelrule05/resource-management-api.git](https://github.com/ruelrule05/resource-management-api.git)
    cd resource-management-api
    ```

2.  **Copy Environment File:**
    ```bash
    cp .env.example .env
    ```

3.  **Configure Environment Variables:**
    Update the following database settings in your `.env` file:
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=resource_management_api
    DB_USERNAME=sail
    DB_PASSWORD=password
    ```

4.  **Start Laravel Sail:**
    ```bash
    ./vendor/bin/sail up -d
    ```
    This will start the Docker containers for your Laravel application, including the MySQL database.

5.  **Run Migrations and Seed Database:**
    ```bash
    sail artisan migrate --seed
    ```

6.  **Generate JWT Secret Key:**
    ```bash
    sail artisan jwt:secret
    ```

7.  **Generate Application Key:**
    ```bash
    sail artisan key:generate
    ```

The backend API will now be accessible at `http://localhost` (or the port Sail assigns).

## API Endpoints

[Include a section detailing your API endpoints as described in the previous comprehensive README, focusing on authentication, registration, projects CRUD, dashboard metrics, and contact form.]

## Authentication

* Uses JWT (JSON Web Tokens) for secure authentication.
* User registration and login endpoints are available at `/api/register` and `/api/login`.
* Protected routes require a valid JWT token in the `Authorization` header (Bearer token).
* bcrypt is used for secure password hashing.

## Authorization

* Role-Based Access Control (RBAC) with "administrator" and "regular user" roles.
* Authorization is enforced at the route (middleware), request and controller levels.