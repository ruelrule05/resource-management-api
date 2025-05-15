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

8.  **Configure CORS (Cross-Origin Resource Sharing):**
    The backend is configured to allow requests from `http://localhost:5173` by default. If your frontend is served on a different origin, you will need to update the CORS settings.

    * **Edit `config/cors.php`:**
        * Locate the `'allowed_origins'` array.
        * Add the origin(s) of your frontend application to this array. For example, if your frontend runs on `https://your-frontend-domain.com`, the array should look like:
            ```php
            'allowed_origins' => ['http://localhost:5173', '[https://your-frontend-domain.com](https://your-frontend-domain.com)'],
            ```

## Backend Address
The backend API will now be accessible at `http://localhost` (or the port Sail assigns).

## API Endpoints

| Method    | URI                        | Route Name                      | Controller@Method           | Description                                                    |
|-----------|----------------------------|---------------------------------|-----------------------------|----------------------------------------------------------------|
| POST      | `api/auth/me`              |                                 | `AuthController@me`           | Fetch authenticated user details                               |
| POST      | `api/auth/refresh`         |                                 | `AuthController@refresh`      | Refresh the JWT token                                          |
| POST      | `api/contact-us`           |                                 | `ContactController@store`     | Submit a contact form inquiry                                  |
| GET/HEAD  | `api/dashboard/metrics`    |                                 | `DashboardController@index`   | Get key metrics for the dashboard                              |
| GET/HEAD  | `api/dashboard/projects-by-month` |                                 | `DashboardController@projectsByMonth` | Get project counts by month for analytics                      |
| GET/HEAD  | `api/inventory-items`      | `inventory-items.index`         | `InventoryItemController@index` | List all inventory items (with filtering, sorting, pagination) |
| POST      | `api/inventory-items`      | `inventory-items.store`         | `InventoryItemController@store` | Create a new inventory item                                    |
| GET/HEAD  | `api/inventory-items/{inventory_item}` | `inventory-items.show`          | `InventoryItemController@show`  | Display a specific inventory item                              |
| PUT/PATCH | `api/inventory-items/{inventory_item}` | `inventory-items.update`        | `InventoryItemController@update` | Update a specific inventory item                               |
| DELETE    | `api/inventory-items/{inventory_item}` | `inventory-items.destroy`       | `InventoryItemController@destroy` | Delete a specific inventory item                               |
| POST      | `api/login`                |                                 | `AuthController@login`         | User login and JWT token generation                            |
| POST      | `api/logout`               |                                 | `AuthController@logout`        | User logout (invalidate JWT token)                             |
| GET/HEAD  | `api/projects`             | `projects.index`              | `ProjectController@index`     | List all projects (with filtering, sorting, pagination)        |
| POST      | `api/projects`             | `projects.store`              | `ProjectController@store`     | Create a new project                                           |
| GET/HEAD  | `api/projects/{project}`   | `projects.show`               | `ProjectController@show`      | Display a specific project                                     |
| PUT/PATCH | `api/projects/{project}`   | `projects.update`             | `ProjectController@update`    | Update a specific project                                      |
| DELETE    | `api/projects/{project}`   | `projects.destroy`            | `ProjectController@destroy`   | Delete a specific project                                      |
| POST      | `api/register`             |                                 | `AuthController@register`      | User registration                                              |
| GET/HEAD  | `api/tasks`                | `tasks.index`                 | `TaskController@index`        | List all tasks (with filtering, sorting, pagination)           |
| POST      | `api/tasks`                | `tasks.store`                 | `TaskController@store`        | Create a new task                                              |
| GET/HEAD  | `api/tasks/{task}`         | `tasks.show`                  | `TaskController@show`         | Display a specific task                                        |
| PUT/PATCH | `api/tasks/{task}`         | `tasks.update`                | `TaskController@update`       | Update a specific task                                         |
| DELETE    | `api/tasks/{task}`         | `tasks.destroy`               | `TaskController@destroy`      | Delete a specific task                                         |

## Authentication

* Uses JWT (JSON Web Tokens) for secure authentication.
* User registration and login endpoints are available at `/api/register` and `/api/login`.
* Protected routes require a valid JWT token in the `Authorization` header (Bearer token).
* bcrypt is used for secure password hashing.

## Authorization

* Role-Based Access Control (RBAC) with "administrator" and "regular user" roles.
* Authorization is enforced at the route (middleware), request and controller levels.