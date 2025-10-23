-- DEPARTEMENTS
INSERT INTO departements (nom) VALUES
('Informatique'),
('Comptabilité'),
('Ressources Humaines');


-- ANNONCES
INSERT INTO annonces (
    departement_id,
    titre,
    description,
    competences_requises,
    niveau_requis,
    date_publication,
    date_limite,
    statut
) VALUES
(2,
 'Développeur Web Full Stack',
 'Nous recherchons un développeur pour concevoir et maintenir nos applications internes Laravel/Vue.js.',
 'Maîtrise de Laravel, JavaScript, PostgreSQL, Git',
 'Licence en informatique',
 CURRENT_DATE,
 CURRENT_DATE + INTERVAL '30 days',
 'ouverte'),

(3,
 'Comptable Senior',
 'Le poste consiste à gérer la comptabilité générale, le suivi des factures et les états financiers.',
 'Bonne maîtrise d''Excel, rigueur, expérience de 3 ans minimum',
 'BAC+3 en comptabilité ou équivalent',
 CURRENT_DATE,
 CURRENT_DATE + INTERVAL '20 days',
 'ouverte'),

(4,
 'Assistant Ressources Humaines',
 'Assister le département RH dans le recrutement, la gestion des contrats et les affiliations sociales.',
 'Organisation, sens de la communication, notions de droit du travail',
 'BAC+2 en gestion ou RH',
 CURRENT_DATE,
 CURRENT_DATE + INTERVAL '15 days',
 'ouverte');
