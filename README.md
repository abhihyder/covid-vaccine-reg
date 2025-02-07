# COVID-19 Vaccine Registration System

## Table of Contents
- [COVID-19 Vaccine Registration System](#covid-19-vaccine-registration-system)
  - [Table of Contents](#table-of-contents)
  - [Introduction](#introduction)
  - [Docker Services](#docker-services)
  - [Prerequisites](#prerequisites)
  - [Optional: Stop \& Remove All Containers](#optional-stop--remove-all-containers)
  - [Installation](#installation)
  - [Project Structure](#project-structure)
  - [App and Web Setup](#app-and-web-setup)
  - [Running Test Cases](#running-test-cases)
  - [Accessing the Application](#accessing-the-application)
  - [Test Data](#test-data)
  - [Monitoring Services](#monitoring-services)
    - [Mail Service](#mail-service)
    - [Queue Monitoring with Horizon](#queue-monitoring-with-horizon)
    - [Application Debugging with Telescope](#application-debugging-with-telescope)
  - [Stopping Services](#stopping-services)

## Introduction
The COVID-19 Vaccine Registration System is a Docker-based project that simplifies the setup and deployment of the app and web services for vaccine registration. The system provides a complete environment for managing vaccine registrations, including app, web, and database services.

## Docker Services
The system consists of the following Docker services:
- **nginx**: Handles HTTP requests.
- **app**: Backend service for business logic.
- **web**: Frontend service.
- **worker**: Handles background tasks like queue processing.
- **database**: Manages persistent data storage.
- **redis**: Queue and Caching service for performance optimization.
- **certbot**: Manages SSL certificates for HTTPS.
- **mailhog**: Email testing tool.

## Prerequisites
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Optional: Stop & Remove All Containers
To stop and remove all Docker containers (if needed), run the following commands:

```bash
docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)
```

## Installation
Follow these steps to install and set up the project:

**Clone the repository:**

   Using HTTPS:
   ```bash
   git clone https://github.com/abhihyder/covid-vaccine-reg.git 
   cd covid-vaccine-reg
   ```

## Project Structure
The project structure is organized as follows:

```bash
covid-vaccine-reg
├── .docker              # Docker-specific configurations
├── app/                 # Backend application files
│   └── ...
├── web/                 # Frontend application files
│   └── ...
├── .dockerignore        # Docker ignore rules
├── .gitignore           # Git ignore rules
├── .env                 # Environment variables
├── docker-compose.yml.example  # Docker Compose example file
├── README.md            # Project documentation
```

## App and Web Setup
To set up the application and web services, follow these steps:

1. **Set up Docker Compose:**
   ```bash
   cp docker-compose.yml.example docker-compose.yml
   ```

2. **Configure environment variables:**
   
   All the required values for environment variables are already defined in the `.env.example` files for both the `app` and `web` directories, making it easy for you to get started with testing. Simply copy these example files to `.env`:
   
   ```bash
   cp app/.env.example app/.env
   cp web/.env.example web/.env
   ```
3. **Env symlink:** Set up a symlink between the root `.env` file and the `app/.env` for easier configuration management:
   ```bash
   ln -sf app/.env .env
   ```
   This command creates a symbolic link between `.env` in the root directory and `app/.env` so that they share the same environment variables.
4. **Set proper permissions for storage:**
   ```bash
   sudo chmod 777 -R app/storage/logs
   sudo chmod 777 -R app/storage/framework
   ```

5. **Build and run the Docker containers:**
      
   Before running the application, ensure that the following ports are free and available on your machine:
   
   - **8000**: Used for the web application (Laravel framework)
   - **5432**: Used for PostgreSQL database connection
   - **6379**: Used for Redis
   - **1025**: Used for MailHog SMTP server
   - **8025**: Used for MailHog web interface
   
   Make sure that no other services are running on these ports to avoid conflicts when starting the application.

   To build and run the Docker containers, use the following commands:
   ```bash
   docker-compose up -d --build
   docker-compose ps
   ```

6. **Install dependencies for the app:**
   ```bash
   docker-compose exec app sh
   composer install
   php artisan migrate --seed
   ```

## Running Test Cases
To verify that all functionalities work as expected, follow these steps to run the test cases:

1. **Run Specific Test File**:

   Use PHPUnit to execute the test cases in `VaccineCenterServiceTest.php`. Run the following commands in your terminal:

   ```bash
   docker-compose exec app sh
   ./vendor/bin/phpunit tests/Feature/VaccineCenterServiceTest.php
   ```

   This will run only the tests defined in `VaccineCenterServiceTest.php`, allowing you to focus on testing that specific service. 

## Accessing the Application
After the setup is complete, you can access the application by navigating to:

```
http://127.0.0.1:8000
```

## Test Data
During seeding, several test users are created with specific NID numbers. You can use the following NID numbers to search for user vaccination status:

- **John Doe** - NID: `1234567890`
- **Jane Smith** - NID: `1234567891`
- **Alice Johnson** - NID: `1234567892`
- **John Cena** - NID: `1234567893`

These users have been registered in the system and can be used for testing the vaccine registration functionalities.

## Monitoring Services

### Mail Service
You can monitor the mail service using Mailhog, which captures outgoing emails. Visit the Mailhog web interface at:

```
http://127.0.0.1:8025
```

### Queue Monitoring with Horizon
Laravel Horizon provides a dashboard to monitor and manage your Redis-based queues. To view Horizon:

1. Ensure Horizon is running, typically via a Docker container if defined.
2. Visit the Horizon dashboard:

```
http://127.0.0.1:8000/monitoring/horizon
```

From the Horizon dashboard, you can view job statuses, manage queue priorities, and monitor overall queue health.

### Application Debugging with Telescope
Laravel Telescope provides real-time application debugging and insights. To access Telescope:

1. Ensure Telescope is configured and running.
2. Visit the Telescope dashboard:

```
http://127.0.0.1:8000/monitoring/telescope
```

From the Telescope dashboard, you can monitor request logs, exceptions, database queries, scheduled tasks, and more, helping you diagnose issues and optimize the application.

**Note**: In the local environment, Horizon and Telescope dashboards are publicly accessible without authentication, as the app does not currently implement an authentication process.

## Stopping Services
To stop all running Docker services, use the following command:

```bash
docker-compose down
```

This will gracefully shut down the containers and free up system resources.
