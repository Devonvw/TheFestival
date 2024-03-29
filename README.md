# The Festival
A project for period 2.3 of the Informatics course at the Inholland University of Applied Sciences in Haarlem

It contains:
* NGINX webserver
* PHP FastCGI Process Manager with PDO MySQL support
* MariaDB (GPL MySQL fork)
* PHPMyAdmin

## Production
https://the-festival-haarlem.000webhostapp.com/

## Login
* username: admin@gmail.com, password: wachtwoord
* username: test@gmail.com, password: wachtwoord


## Installation

1. Install Docker Desktop on Windows or Mac, or Docker Engine on Linux.
1. Clone the project

## Usage

In a terminal, run:
```bash
docker-compose up
```

NGINX will now serve files in the app/public folder. Visit localhost in your browser to check.
PHPMyAdmin is accessible on localhost:8080

If you want to stop the containers, press Ctrl+C. 
Or run:
```bash
docker-compose down
```
