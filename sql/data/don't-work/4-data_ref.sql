-- ===================================================================
-- DÉPARTEMENTS
-- ===================================================================
INSERT INTO departements (nom) VALUES
('Informatique'),
('Comptabilité'),
('Ressources Humaines');

-- ===================================================================
-- ANNONCES
-- ===================================================================
INSERT INTO annonces (departement_id, titre, description, competences_requises, niveau_requis, date_publication, date_limite, statut)
VALUES
(1, 'Développeur Web', 'Développement d’applications Laravel/Vue.js', 'Laravel, Vue.js, PostgreSQL', 'Licence Informatique', CURRENT_DATE, CURRENT_DATE + INTERVAL '15 days', 'ouverte'),
(2, 'Comptable Junior', 'Gestion quotidienne des comptes et bilans', 'Excel, Sage, rigueur', 'BAC+3 Comptabilité', CURRENT_DATE, CURRENT_DATE + INTERVAL '15 days', 'ouverte'),
(3, 'Assistant RH', 'Participation au processus de recrutement et suivi du personnel', 'Organisation, communication', 'BAC+2 RH', CURRENT_DATE, CURRENT_DATE + INTERVAL '10 days', 'ouverte');

-- ===================================================================
-- USERS (liés à tes rôles existants)
-- ===================================================================
-- RH
INSERT INTO users (name, email, password, role)
VALUES ('Randria RH', 'rh@example.com', '$2y$12$OZhJkQOr5tpbV8JxgDNUHuKc2x6c3mNfBPqfyX/1AawEQAZMZokya', 'rh');

-- CANDIDATS
INSERT INTO users (name, email, password, role)
VALUES 
('Rakoto Candidat', 'rakoto@example.com', '$2y$12$OZhJkQOr5tpbV8JxgDNUHuKc2x6c3mNfBPqfyX/1AawEQAZMZokya', 'candidat'),
('Rasoa Candidate', 'rasoa@example.com', '$2y$12$OZhJkQOr5tpbV8JxgDNUHuKc2x6c3mNfBPqfyX/1AawEQAZMZokya', 'candidat');

-- ===================================================================
-- CANDIDATS
-- ===================================================================
INSERT INTO candidats (user_id, nom, prenom, date_naissance, email, cv_path, competences, statut)
VALUES
(2, 'Rakoto', 'Jean', '1995-03-12', 'rakoto@example.com', 'uploads/cv_rakoto.pdf', 'Laravel, PostgreSQL', 'en_attente'),
(3, 'Rasoa', 'Lalao', '1997-06-01', 'rasoa@example.com', 'uploads/cv_rasoa.pdf', 'Comptabilité, Excel', 'en_attente');

-- ===================================================================
-- CANDIDATURES
-- ===================================================================
INSERT INTO candidatures (candidat_id, annonce_id, statut)
VALUES 
(1, 1, 'en_attente'),
(2, 2, 'en_attente');

-- ===================================================================
-- TESTS / QUESTIONS / RÉPONSES
-- ===================================================================
INSERT INTO tests (annonce_id, titre, description, duree)
VALUES (1, 'Test Développement Web', 'QCM sur Laravel et Vue.js', 20);

INSERT INTO questions (test_id, intitule, points)
VALUES 
(1, 'Quel framework PHP est utilisé ?', 1),
(1, 'Quel SGBD est utilisé ?', 1);

INSERT INTO reponses (question_id, texte, est_correcte)
VALUES
(1, 'Laravel', TRUE),
(1, 'Symfony', FALSE),
(2, 'PostgreSQL', TRUE),
(2, 'MySQL', FALSE);

-- ===================================================================
-- RÉSULTATS TESTS
-- ===================================================================
INSERT INTO resultats_tests (candidature_id, test_id, score)
VALUES (1, 1, 85.0);

-- ===================================================================
-- ENTRETIENS
-- ===================================================================
INSERT INTO entretiens (candidature_id, date_entretien, duree, lieu, rh_id, statut)
VALUES (1, CURRENT_TIMESTAMP + INTERVAL '2 days', 60, 'Salle RH', 1, 'planifie');

-- ===================================================================
-- ÉVALUATION ENTRETIEN
-- ===================================================================
INSERT INTO evaluations_entretiens (entretien_id, note, remarques)
VALUES (1, 17.5, 'Très bon niveau technique.');

-- ===================================================================
-- CONTRAT
-- ===================================================================
INSERT INTO contrats (candidature_id, type_contrat, date_debut, date_fin, salaire, statut)
VALUES (1, 'essai', CURRENT_DATE, CURRENT_DATE + INTERVAL '3 months', 2500000.00, 'actif');

-- ===================================================================
-- AFFILIATION SOCIALE
-- ===================================================================
INSERT INTO affiliations_sociales (contrat_id, organisme, numero_affiliation)
VALUES (1, 'CNAPS', 'CNAPS-2025-001');

-- ===================================================================
-- EMPLOYÉ
-- ===================================================================
INSERT INTO employes (candidat_id, contrat_id, matricule, statut)
VALUES (1, 1, 'EMP-0001', 'actif');
