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
CREATE TABLE MachineNotes
(
    timestamp           TIMESTAMP NOT NULL,
    machine_name        CHAR(45) NOT NULL,
    operational_status  ENUM('active','inactive','maintenance','idle'),
    user_id             CHAR(20),
    user_name           CHAR(45) NOT NULL,
    content             varchar(255) NOT NULL,
    PRIMARY KEY (timestamp, machine_name, user_id)
);

CREATE TABLE JobNotes (
    timestamp           TIMESTAMP NOT NULL,
    job_description VARCHAR(255) NOT NULL,
    operational_status    ENUM('In Progress', 'Waiting for Parts', 'Completed', 'On Hold') NOT NULL,
    employee_id             INT NOT NULL,
    employee_name            VARCHAR(100) NOT NULL,
    additional_details       TEXT
);
CREATE TABLE TaskNotes (
    timestamp           TIMESTAMP NOT NULL,
    machine_name        CHAR(45) NOT NULL,
    task_note           TEXT NOT NULL,
    employee_id         INT NOT NULL,
    employee_name       VARCHAR(100) NOT NULL
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
INSERT INTO Users VALUES('benn8654', '$2a$12$wM1dSKScyLcqh6YXWcpvKOJoHvtBJVjx1ZEZLt.y4pS2RZhiyOtIW', 'Penelope', 'Bennett', 'Administrator');
INSERT INTO Users VALUES('moor5043', '$2a$12$I8l1K/bS8CRldL9q6ZFZZeqUUdUC3cJSBYVtqSFI6g5AW0YVhve7O', 'John', 'Moore', 'Factory Manager');
INSERT INTO Users VALUES('john2376', '$2a$12$/WCUUGSk4lO.fStHh6S2euiuR4jEUMl70OmyvtvpJDS2zdmchHAI6', 'David', 'Johnson', 'Production Operator');
INSERT INTO Users VALUES('lawr0842', '$2a$12$cm.nRRSZUvelALg0vBg16OYqsn.CMVNmMsJRyPS5dWMVj.zbdmQAK', 'Kaitlyn', 'Lawrence', 'Auditor');

INSERT INTO MachineNotes (timestamp, machine_name, operational_status, user_id, user_name, content) VALUES
('2024-10-01 10:00:00', '3D Printer', 'active', '101', 'Alice Smith', 'Routine maintenance performed.'),
('2024-10-02 11:30:00', 'CNC Machine', 'inactive', '102', 'Bob Johnson', 'Calibration complete.'),
('2024-10-03 09:15:00', 'Industrial Robot','active', '103', 'Charlie Brown', 'Fault detected.'),
('2024-10-04 14:45:00', 'Automated Guided Vehicle (AGV)', 'inactive', '104', 'David Wilson', 'Battery replaced.'),
('2024-10-05 16:20:00', 'Smart Conveyor System', 'active', '105', 'Eve Davis', 'Maintenance scheduled.');

INSERT INTO JobNotes (timestamp, job_description, operational_status, employee_id, employee_name, additional_details) VALUES
('2024-10-01 10:30:00', 'Replace conveyor belt', 'In Progress', 101, 'Alice Johnson', 'Need new parts from supplier.'),
('2024-10-02 14:15:00', 'Service CNC Machine', 'Waiting for Parts', 102, 'Bob Smith', 'Awaiting arrival of cutting tools.'),
('2024-10-03 09:00:00', 'Install new software on 3D Printer', 'Completed', 103, 'Charlie Brown', 'Software update successful.'),
('2024-10-04 11:45:00', 'Calibrate Industrial Robot', 'On Hold', 104, 'David Wilson', 'Waiting for technician availability.'),
('2024-10-05 16:30:00', 'Inspect Automated Guided Vehicle', 'In Progress', 105, 'Eve Davis', 'Performing routine checks.');

INSERT INTO TaskNotes (timestamp, machine_name, task_note, employee_id, employee_name) VALUES
('2024-10-01 10:00:00', 'CNC Machine', 'Completed a routine maintenance check.', 101, 'Alice Johnson'),
('2024-10-02 12:30:00', '3D Printer', 'Adjusted filament feed to resolve jams.', 102, 'Bob Smith'),
('2024-10-03 15:00:00', 'Industrial Robot', 'Replaced worn-out joints.', 103, 'Charlie Brown'),
('2024-10-04 13:15:00', 'Automated Guided Vehicle', 'Updated navigation software.', 104, 'David Wilson'),
('2024-10-05 08:30:00', 'Smart Conveyor System', 'Cleared blockage in the feed area.', 105, 'Eve Davis');





CREATE user IF NOT EXISTS dbadmin@localhost;
GRANT all privileges ON Websolution.Machines TO dbadmin@localhost;
GRANT all privileges ON Websolution.MachineLogs TO dbadmin@localhost;
GRANT all privileges ON Websolution.MachineNotes To dbadmin@localhost;
GRANT all privileges ON Websolution.Users To dbadmin@localhost;
GRANT all privileges ON Websolution.JobNotes TO dbadmin@localhost;
GRANT all privileges ON Websolution.TaskNotes TO dbadmin@localhost;




