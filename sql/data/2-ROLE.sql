-- ADMIN
INSERT INTO users (name, email, password, role)
VALUES (
    'Administrateur Système',
    'admin@rh.local',
    crypt('admin123', gen_salt('bf')),
    'admin'
);


UPDATE users 
SET password = '$2y$12$1J.R7OKRVS9xwZocLkGsLODPlD23yihE23i0hRCqaj8Fdg0LveDaS'
WHERE email = 'admin@rh.local';

-- RH
INSERT INTO users (name, email, password, role)
VALUES (
    'Responsable RH',
    'rh@rh.local',
    crypt('rh1234', gen_salt('bf')),
    'rh'
);

UPDATE users 
SET password = '$2y$12$7dLqqlzxnOa5N8/UUddQaukIRh3zpEdh3TRuit0da8kGOidkZdl.C'
WHERE email = 'rh@rh.local';
