-- PATIENT TABLE INSERTION
INSERT INTO Patient
    (name, username, login_code, severity, arrival_time)
VALUES
    ('John Smith', 'jhsmith', '123', 0,  localtime);

-- QUEUE TABLE INSERTION
INSERT INTO Queue
    (username, wait_time)
VALUES
    ('jhsmith', 20);