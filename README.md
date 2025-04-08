# Scandiweb Backend Test Task

This is the backend test task for Fullstack (React + PHP) at Scandiweb.

## Getting Started

1. Clone the repository and navigate to the project directory.

2. Install dependencies:

```bash
composer install
```

3. To run the project using PHP's built-in server, execute the following command:

```bash
php -S localhost:8000 -t public
```

5. If you want to seed the database for the first time, switch to the `dev` branch to ensure you are working in the correct environment:

```bash
git switch dev
```

6. To seed the database, run the following commands:

```bash
mysql -u [USER] -p [DB_NAME] < data/schema.sql
```

Replace `[USER]` with your MySQL username and `[DB_NAME]` with the name of your database.

```bash
php data/seed.php
```

## Database Schema

You can check the database schema from `data/schema.sql` or view it visually [here](https://drawsql.app/teams/youssef-team-5/diagrams/sw-zeke-store).

## Future Plans and Enhancements

I am always open to suggestions for improvement. If you have any ideas or feedback, feel free to share them. Continuous improvement is a journey, and every contribution helps make this project better.
