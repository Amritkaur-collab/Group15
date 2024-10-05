DROP TABLE Machines;
DROP TABLE MachineNotes;
DROP TABLE MachineLogs;
DROP TABLE MachineAlertRules;
DROP TABLE MachineAlerts;
DROP TABLE Users;
DROP TABLE Messages;

CREATE TABLE Machines
(
    machine_name        CHAR NOT NULL,
    PRIMARY KEY (machine_name)
);

/* Production operators need to be able to assign different statuses to machines (eg. "Under maintenance, awaiting parts"). I believe the best way to do this is to have a note system where the most recent note on a machine is shown (note history can also be viewed) */
CREATE TABLE MachineNotes
(
    timestamp           CHAR NOT NULL,
    machine_name        CHAR NOT NULL,
    user_id             CHAR NOT NULL,
    content             varchar NOT NULL,
    PRIMARY KEY (timestamp, machine_name, user_id),
    FOREIGN KEY (machine_name) REFERENCES Machine (machine_name) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users (user_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE MachineLogs
(
    timestamp           CHAR NOT NULL,
    machine_name        CHAR NOT NULL,
    temperature         DECIMAL,
    pressure            DECIMAL,
    vibration           DECIMAL,
    humidity            DECIMAL,
    power_consumption   DECIMAL,
    operational_status  CHAR,
    error_code          CHAR,
    production_count    INTEGER,
    maintenance_log     varchar,
    speed               DECIMAL,
    PRIMARY KEY (timestamp, machine_name),
    FOREIGN KEY (machine_name) REFERENCES Machine (machine_name) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE MachineAlertRules
(
    rule_id             CHAR NOT NULL,
    machine_name        CHAR NOT NULL,
    rule                CHAR NOT NULL, /* Would be something like: (temperature > 70) or (status is idle) */
    priority            CHAR NOT NULL, /* Would determine how 'annoying' the alert is. A factory manager may choose to set a low priority to a machine's status being idle (which may only be a notification in the alert tab), and a critical priority to a machine overheating (which may be a full pop-up with a loud noise). */
    PRIMARY KEY (rule_id),
    FOREIGN KEY (machine_name) REFERENCES Machine (machine_name) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE MachineAlerts
(
    timestamp           CHAR NOT NULL,
    machine_name        CHAR NOT NULL,
    rule_id             CHAR NOT NULL,
    PRIMARY KEY (timestamp, machine_name, rule_id),
    FOREIGN KEY (timestamp) REFERENCES Machine (machine_name) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (machine_name) REFERENCES Machine (machine_name) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (rule_id) REFERENCES MachineAlertRules (rule_id) ON UPDATE CASCADE ON DELETE CASCADE
);

/* 
I am assuming that onsite dashboards (eg. dashboard terminals used 
by production operators in the factory) would only require authentication 
using the user_id, which would be filled in by scanning an id card.                     
*/ 
CREATE TABLE Users
(
    user_id             CHAR NOT NULL,
    password_hash       CHAR NOT NULL,
    first_name          CHAR NOT NULL,
    last_name           CHAR NOT NULL,
    user_type           CHAR NOT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE Messages
(
    message_id          CHAR NOT NULL,
    sender              CHAR NOT NULL,
    recipient           CHAR NOT NULL,
    timestamp           CHAR NOT NULL,
    content             varchar NOT NULL,
    PRIMARY KEY (message_id),
    FOREIGN KEY (sender) REFERENCES Users (user_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (recipient) REFERENCES Users (user_id) ON UPDATE CASCADE ON DELETE CASCADE
);



