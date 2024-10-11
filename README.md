# COVID-19 Vaccine Registration System

## Table of Contents
- [Introduction](#introduction)
- [Docker Services](#docker-services)
- [Prerequisites](#prerequisites)
- [Optional: Stop & Remove All Containers](#optional-stop--remove-all-containers)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [App and Web Setup](#app-and-web-setup)
- [Accessing the Application](#accessing-the-application)
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
- **redis**: Caching service for performance optimization.
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

3. **Set proper permissions for storage:**
   ```bash
   sudo chmod 777 -R app/storage/logs
   sudo chmod 777 -R app/storage/framework
   ```

4. **Build and run the Docker containers:**
   ```bash
   docker-compose up -d --build
   docker-compose ps
   ```

5. **Install dependencies for the app:**
   ```bash
   docker-compose exec app sh
   composer install
   php artisan migrate --seed
   ```

## Accessing the Application
After the setup is complete, you can access the application by navigating to:

```
http://localhost:8000
```

## Stopping Services
To stop all running Docker services, use the following command:

```bash
docker-compose down
```

This will gracefully shut down the containers and free up system resources.