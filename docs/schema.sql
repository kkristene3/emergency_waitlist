CREATE SCHEMA emergency_waitlist;
SET search_path to emergency_waitlist;

-- DROP TABLE QUERIES
drop table queue;
drop table staff;
drop table patient;

-- TABLE CREATIONS
CREATE TABLE Staff
    (
        name VARCHAR(255),
        username VARCHAR(255),
        loginCode VARCHAR(3)
    );

CREATE TABLE Patient
    (
        patientID SERIAL PRIMARY KEY,
        name VARCHAR(255),
        username VARCHAR(255),
        loginCode VARCHAR(3),
        arrivalTime TIME
    );

CREATE TABLE Queue
    (
        patient_id INT REFERENCES Patient(patientID),
        waitTime TIME
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
