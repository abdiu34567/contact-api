# Junior Developer Test Task: Contact Management API

This is a simple contact management API built with Laravel 12 as part of a junior developer test task. The API allows for basic CRUD operations on contacts and includes a search functionality.

## Features

-   Create, Retrieve, Update, and Delete contacts.
-   List all contacts with pagination.
-   Search for contacts by first name, last name, email, or company.
-   Request validation for all input.
-   Standardized JSON responses using API Resources.
-   A full feature test suite using PHPUnit.

## Technical Stack

-   Laravel 12
-   PHP 8.4+
-   MySQL (can be swapped for PostgreSQL)
-   SQLite for automated testing

---

## Setup Instructions

Follow these steps to get the project up and running locally.

### 1. Clone the Repository

```bash
git clone https://github.com/abdiu34567/contact-api.git
cd contact-api
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the example environment file and generate the application key.

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup

Create a MySQL database for the application (e.g., `contact_api`). Then, open the `.env` file and update the database connection details:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=contact_api
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

### 5. Run Migrations

Run the database migrations to create the necessary tables.

```bash
php artisan migrate
```

### 6. Run the Development Server

```bash
php artisan serve
```

The API will be available at `http://127.0.0.1:8000`.

### 7. Run Tests (Optional)

To run the full feature test suite, make sure you have the `pdo_sqlite` PHP extension enabled. Then run:

```bash
php artisan test
```

---

## API Endpoint Documentation

**Base URL:** `http://127.0.0.1:8000/api`

Headers for all requests:

-   `Accept: application/json`
-   `Content-Type: application/json` (for POST/PUT)

---

### 1. List All Contacts

-   **Endpoint:** `GET /contacts`
-   **Description:** Retrieves a paginated list of all contacts.
-   **Success Response (200 OK):**
    ```json
    {
        "data": [
            {
                "id": 1,
                "first_name": "John",
                "last_name": "Doe",
                "email": "john@example.com",
                "phone": "+1234567890",
                "company": "Tech Corp",
                "birthday": "1990-01-01",
                "created_at": "2025-09-20T14:30:00Z",
                "updated_at": "2025-09-20T14:30:00Z"
            }
        ],
        "links": { ... },
        "meta": { ... }
    }
    ```

---

### 2. Create a New Contact

-   **Endpoint:** `POST /contacts`
-   **Description:** Creates a new contact.
-   **Request Body:**
    ```json
    {
        "first_name": "Jane",
        "last_name": "Smith",
        "email": "jane@example.com",
        "phone": "+1987654321",
        "company": "Web Solutions",
        "birthday": "1992-05-15"
    }
    ```
-   **Success Response (201 Created):**
    ```json
    {
        "data": {
            "id": 2,
            "first_name": "Jane",
            "last_name": "Smith",
            ...
        }
    }
    ```

---

### 3. Get a Single Contact

-   **Endpoint:** `GET /contacts/{id}`
-   **Description:** Retrieves the details of a specific contact.
-   **Success Response (200 OK):** (Same structure as create success response)

---

### 4. Update a Contact

-   **Endpoint:** `PUT /contacts/{id}`
-   **Description:** Updates an existing contact's details.
-   **Request Body:** (Include all required fields)
    ```json
    {
        "first_name": "Jane",
        "last_name": "Smith-Jones",
        "email": "jane.sj@example.com",
        "phone": "+1987654321"
    }
    ```
-   **Success Response (200 OK):** (Same structure as create success response, with updated data)

---

### 5. Delete a Contact

-   **Endpoint:** `DELETE /contacts/{id}`
-   **Description:** Deletes a specific contact.
-   **Success Response (204 No Content):** (Empty response body)

---

### 6. Search Contacts

-   **Endpoint:** `GET /contacts/search`
-   **Description:** Searches for contacts by name, email, or company.
-   **Query Parameter:** `query`
-   **Example URL:** `/contacts/search?query=jane`
-   **Success Response (200 OK):** (Same structure as list all contacts response)
