-- STAFF TABLE INSERTIONS
INSERT INTO Staff
    (name, username, login_code)
VALUES
    ('Kralexah Saleris', 'kxsaleris', 'ASK'),
    ('Jimin Park', 'jmpark', 'BTS'),
    ('Amber Alert', 'abalert', 'WLO'),
    ('Jinyoung Park', 'jypark', 'JYP'),
    ('Mark Lee', 'mklee', 'NCT');

-- PATIENT TABLE INSERTION
INSERT INTO Patient
    (name, username, login_code, severity, arrival_time)
VALUES
    ('John Smith', 'jhsmith', '123', 1,  localtime);

-- QUEUE TABLE INSERTION
INSERT INTO Queue
    (username, wait_time)
VALUES
    ('jhsmith', 0);
