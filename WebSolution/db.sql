SET @@AUTOCOMMIT = 1;

DROP DATABASE IF EXISTS Websolution;
CREATE DATABASE Websolution;

USE Websolution;

CREATE TABLE Machines
(
    machine_name        CHAR(45) NOT NULL,
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
    maintenance_log     varchar(200),
    speed               DECIMAL(5,2),
    PRIMARY KEY (timestamp, machine_name),
    FOREIGN KEY (machine_name) REFERENCES Machines (machine_name) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE user IF NOT EXISTS dbadmin@localhost;
GRANT all privileges ON Websolution.Machines TO dbadmin@localhost;
GRANT all privileges ON Websolution.MachineLogs TO dbadmin@localhost;



