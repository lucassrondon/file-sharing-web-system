# File Sharing Web System

## Description

This app is designed for users to share a wide range of educational content, including projects, homework, research papers, exams, presentations and other kinds of content related to learning. The aim of this project is to create a centralized platform for the sharing of knowledge.

## Run Locally

### Prerequisites

Make sure you have the following installed on your machine:

- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)
- [npm](https://www.npmjs.com/) 
- [MySQL](https://www.mysql.com/)

### Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/lucassrondon/file-sharing-web-system.git
    ```

2. Navigate to the project folder:

    ```bash
    cd path/to/the/project/folder
    ```

3. Install PHP dependencies:

    ```bash
    composer install
    ```

4. Install JavaScript dependencies:

    ```bash
    npm install
    ```

5. Copy the `.env.example` file to a new file called `.env`:

6. Open the `.env` file and set the database connection details and mail details.

7. Run the database migrations:

    ```bash
    php artisan migrate
    ```

### Running the Application

1. Start the Laravel development server:

    ```bash
    php artisan serve
    ```

   The application will be accessible at: `http://localhost:8000`

2. Visit the application in your web browser.
