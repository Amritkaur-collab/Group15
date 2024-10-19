
SET @@AUTOCOMMIT = 1;

DROP DATABASE IF EXISTS Websolution;
CREATE DATABASE Websolution;

USE Websolution;

CREATE TABLE Machines
(
    machine_name        CHAR(45) NOT NULL,
    machine_location    CHAR(100),      -- New column, allows NULL
    date_acquired       DATE,           -- New column, allows NULL
    serial_number       CHAR(30),       -- New column, allows NULL
    PRIMARY KEY (machine_name)
);

CREATE TABLE MachineLogs
(
    timestamp           TIMESTAMP NOT NULL,
    machine_name        CHAR(45) NOT NULL,
    temperature         DECIMAL(5,2),
    pressure            DECIMAL(5,2),
    vibration           DECIMAL(5,2),
    humidity            DECIMAL(5,2),
    power_consumption   DECIMAL(5,2),
    operational_status  CHAR(20),
    error_code          CHAR(4),
    production_count    INTEGER,
    maintenance_log     VARCHAR(200),
    speed               DECIMAL(5,2),
    PRIMARY KEY (timestamp, machine_name),
    FOREIGN KEY (machine_name) REFERENCES Machines (machine_name) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE jobs (
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    job_name VARCHAR(255) NOT NULL,
    job_duration INT NOT NULL,  -- Duration in minutes
    machine_name VARCHAR(255),
    FOREIGN KEY (machine_name) REFERENCES Machines(machine_name)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Users
(
    user_id  CHAR(20),
    password_hash  CHAR(60), 
    first_name  CHAR(30),
    last_name  CHAR(30),
    user_type  CHAR(30),
    PRIMARY KEY (user_id)
);

CREATE TABLE jobs_assign
(
    job_id CHAR(20),
    user_id CHAR(20),
    machine CHAR(30),
    job_desc CHAR(250),
    PRIMARY KEY (job_id)
);

CREATE user IF NOT EXISTS dbadmin@localhost;
GRANT all privileges ON Websolution.machines TO dbadmin@localhost;
GRANT all privileges ON Websolution.machineLogs TO dbadmin@localhost;
GRANT all privileges ON Websolution.users TO dbadmin@localhost;
GRANT all privileges ON Websolution.jobs TO dbadmin@localhost;
GRANT all privileges ON Websolution.jobs_assign TO dbadmin@localhost;

