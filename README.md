# Codelingo

Learning platform for beginner programmers

## Project Structure
```
my_project/
├── frontend/  - frontend project using Vue
└── backend/   - backend project using Laravel
```

## Requirements
- Node.js (recommended version 14.x or higher)
- npm (usually comes with Node.js)
- Composer
- PHP (recommended version 7.4 or higher)
- MySQL

## Installation and Running the Project

### Step 1: Clone the Repository
First, clone the repository to your local machine:
```bash
git clone https://github.com/21DP3FRegz/CodeLingo
cd CodeLingo
```

### Step 2: Setup and Run the Frontend

1. Navigate to the `frontend` folder:
    ```bash
    cd frontend
    ```

2. Install the dependencies:
    ```bash
    npm install
    ```

3. Start the development server:
    ```bash
    npm run dev
    ```

### Step 3: Setup and Run the Backend

1. Navigate to the `backend` folder:
    ```bash
    cd ../backend
    ```

2. Install the dependencies:
    ```bash
    composer install
    ```

3. Create a `.env` file from the `.env.example` file:
    ```bash
    cp .env.example .env
    ```

4. Generate a new application key:
    ```bash
    php artisan key:generate
    ```

5. Configure the database settings in the `.env` file.

6. Run the database migrations:
    ```bash
    php artisan migrate --seed
    ```

7. Start the local server:
    ```bash
    php artisan serve
    ```

## Contact
If you have any questions or suggestions, you can contact me via email: [felikss.regzdins@gmail.com].