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
        username VARCHAR(255) UNIQUE,
        login_code VARCHAR(3),
        PRIMARY KEY (staff_id)
    );

CREATE TABLE Patient
    (
        patient_id SERIAL,
        name VARCHAR(255),
        username VARCHAR(255) UNIQUE,
        login_code VARCHAR(3),
        arrival_time TIME,
        PRIMARY KEY (patient_id)
    );

CREATE TABLE Queue
    (
        patient_id INT,
        wait_time TIME,
        FOREIGN KEY (patient_id) REFERENCES Patient
    );

-- STAFF TABLE INSERTIONS
INSERT INTO Staff
    (name, username, login_code)
VALUES
    ('Kralexah Saleris', 'kxsaleris', 'ASK'),
    ('Jimin Park', 'jmpark', 'BTS'),
    ('Amber Alert', 'abalert', 'WLO'),
    ('Jinyoung Park', 'jypark', 'JYP'),
    ('Mark Lee', 'mklee', 'NCT');

-- SAMPLE PATIENT TABLE INSERTION
INSERT INTO Patient
    (name, username, login_code, arrival_time)
VALUES
    ('John Smith', 'jhsmith', '123',  localtime);

-- SELECTION STATEMENTS
SELECT
    arrival_time AT TIME ZONE 'UTC' AT TIME ZONE 'America/New_York' AS est_time
FROM
    Patient;

SELECT name FROM emergency_waitlist.Staff