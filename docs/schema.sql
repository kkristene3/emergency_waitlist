-- CREATE SCHEMA AND SET PATH
CREATE SCHEMA emergency_waitlist;
SET search_path to emergency_waitlist;

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
        severity INT,
        arrival_time TIME,
        PRIMARY KEY (patient_id)
    );

CREATE TABLE Queue
    (
        patient_id INT,
        wait_time TIME,
        FOREIGN KEY (patient_id) REFERENCES Patient
    );

