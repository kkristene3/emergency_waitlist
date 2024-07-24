CREATE SCHEMA emergency_waitlist;
SET search_path to emergency_waitlist;

-- DROP TABLE QUERIES
drop table queue;
drop table staff;
drop table patient;

-- TABLE CREATIONS
CREATE TABLE Staff
    (
        staff_id SERIAL,
        name VARCHAR(255),
        username VARCHAR(255),
        loginCode VARCHAR(3),
        PRIMARY KEY (staff_id)
    );

CREATE TABLE Patient
    (
        patient_id SERIAL,
        name VARCHAR(255),
        username VARCHAR(255),
        loginCode VARCHAR(3),
        arrivalTime TIME,
        PRIMARY KEY (patient_id)
    );

CREATE TABLE Queue
    (
        patient_id INT,
        waitTime TIME,
        FOREIGN KEY (patient_id) REFERENCES Patient
    );

-- STAFF TABLE INSERTIONS
INSERT INTO Staff
    (name, username, loginCode)
VALUES
    ('Kralexah Saleris', 'kxsaleris', 'ASK'),
    ('Jimin Park', 'jmpark', 'BTS'),
    ('Amber Alert', 'abalert', 'WLO'),
    ('Jinyoung Park', 'jypark', 'JYP'),
    ('Mark Lee', 'mklee', 'NCT');

-- SAMPLE PATIENT TABLE INSERTION
INSERT INTO Patient
    (name, username, loginCode, arrivalTime)
VALUES
    ('John Smith', 'jhsmith', '123',  localtime);

-- SELECTION STATEMENTS
SELECT
    arrivalTime AT TIME ZONE 'UTC' AT TIME ZONE 'America/New_York' AS est_time
FROM
    Patient;