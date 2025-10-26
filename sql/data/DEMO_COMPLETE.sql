-- ============================================
-- SCRIPT DE DONNÉES DE DÉMONSTRATION COMPLÈTE
-- Système de Gestion RH - PostgreSQL
-- ============================================
-- Ce script illustre TOUS les cas de figure de l'application
-- ============================================

\c rh;

-- ============================================
-- 1. RESET COMPLET (Utilise le script existant)
-- ============================================
TRUNCATE TABLE 
    affiliations_sociales,
    employes,
    evaluations_entretiens,
    entretiens,
    candidat_reponses,
    resultats_tests,
    candidatures,
    contrats,
    reponses,
    questions,
    tests,
    annonces,
    departements,
    candidats,
    notifications,
    users
RESTART IDENTITY CASCADE;

-- ============================================
-- 2. UTILISATEURS (Admin + RH + Candidats)
-- ============================================

-- Admin
INSERT INTO users (name, email, password, role) VALUES
('Administrateur Système', 'admin@rh.local', crypt('admin123', gen_salt('bf')), 'admin');

UPDATE users 
SET password = '$2y$12$1J.R7OKRVS9xwZocLkGsLODPlD23yihE23i0hRCqaj8Fdg0LveDaS'
WHERE email = 'admin@rh.local';

-- RH
INSERT INTO users (name, email, password, role) VALUES
('Marie RAKOTO', 'rh@rh.local', crypt('rh123', gen_salt('bf')), 'rh');

UPDATE users 
SET password = '$2y$12$7dLqqlzxnOa5N8/UUddQaukIRh3zpEdh3TRuit0da8kGOidkZdl.C'
WHERE email = 'rh@rh.local';

-- Candidats (8 profils différents)
INSERT INTO users (name, email, password, role) VALUES
('Jean RASOLOFO', 'jean.rasolofo@email.com', crypt('rh123', gen_salt('bf')), 'candidat'),
('Sophie ANDRIA', 'sophie.andria@email.com', crypt('rh123', gen_salt('bf')), 'candidat'),
('Paul RAZAFY', 'paul.razafy@email.com', crypt('rh123', gen_salt('bf')), 'candidat'),
('Marie RABE', 'marie.rabe@email.com', crypt('rh123', gen_salt('bf')), 'candidat'),
('David RANDRIANA', 'david.randriana@email.com', crypt('rh123', gen_salt('bf')), 'candidat'),
('Alice RAHARISON', 'alice.raharison@email.com', crypt('rh123', gen_salt('bf')), 'candidat'),
('Michel RANDRIA', 'michel.randria@email.com', crypt('rh123', gen_salt('bf')), 'candidat'),
('Emma RAKOTOMALALA', 'emma.rakoto@email.com', crypt('rh123', gen_salt('bf')), 'candidat');

-- Mise à jour des mots de passe avec les hash Laravel (tous les candidats ont le mot de passe 'rh123')
UPDATE users 
SET password = '$2y$12$7dLqqlzxnOa5N8/UUddQaukIRh3zpEdh3TRuit0da8kGOidkZdl.C'
WHERE role = 'candidat';

-- ============================================
-- 3. DÉPARTEMENTS
-- ============================================
INSERT INTO departements (nom) VALUES
('Informatique'),
('Marketing'),
('Ressources Humaines'),
('Finance'),
('Commercial');

-- ============================================
-- 4. ANNONCES (Différents statuts)
-- ============================================
INSERT INTO annonces (departement_id, titre, description, competences_requises, niveau_requis, date_publication, date_limite, statut) VALUES
-- Annonce 1: Ouverte avec beaucoup de candidats
(1, 'Développeur Full Stack Senior', 
 'Nous recherchons un développeur expérimenté pour concevoir et maintenir nos applications web. Vous travaillerez avec Laravel, React et PostgreSQL.',
 'PHP, Laravel, React, PostgreSQL, Git, API REST',
 'Licence en informatique + 5 ans d''expérience',
 CURRENT_DATE - INTERVAL '40 days',
 CURRENT_DATE + INTERVAL '20 days',
 'ouverte'),

-- Annonce 2: Ouverte récente
(2, 'Chef de Projet Marketing Digital',
 'Pilotage de projets marketing digital, gestion d''équipe et stratégie de communication.',
 'Marketing digital, SEO, Google Ads, Management, Analytics',
 'BAC+5 Marketing + 3 ans d''expérience',
 CURRENT_DATE - INTERVAL '15 days',
 CURRENT_DATE + INTERVAL '30 days',
 'ouverte'),

-- Annonce 3: Fermée (recrutement terminé)
(3, 'Chargé de Recrutement',
 'Gestion du processus de recrutement de A à Z, entretiens et suivi des candidatures.',
 'Recrutement, Entretiens, ATS, Communication, Droit du travail',
 'BAC+3 RH + 2 ans d''expérience',
 CURRENT_DATE - INTERVAL '60 days',
 CURRENT_DATE - INTERVAL '10 days',
 'fermee'),

-- Annonce 4: Ouverte avec date limite proche
(5, 'Commercial B2B',
 'Développement du portefeuille clients entreprises et prospection commerciale.',
 'Vente B2B, Négociation, CRM, Prospection, Closing',
 'BAC+2 Commercial + 3 ans d''expérience',
 CURRENT_DATE - INTERVAL '10 days',
 CURRENT_DATE + INTERVAL '5 days',
 'ouverte'),

-- Annonce 5: Ouverte sans candidat
(4, 'Contrôleur de Gestion',
 'Analyse financière, reporting et pilotage de la performance.',
 'Excel avancé, Power BI, Comptabilité analytique, Analyse financière',
 'BAC+5 Finance + 5 ans d''expérience',
 CURRENT_DATE - INTERVAL '5 days',
 CURRENT_DATE + INTERVAL '25 days',
 'ouverte');

-- ============================================
-- 5. CANDIDATS (Profils détaillés)
-- ============================================
INSERT INTO candidats (user_id, nom, prenom, date_naissance, email, cv_path, competences, statut) VALUES
-- Candidat 1: Employé (parcours complet)
(3, 'RASOLOFO', 'Jean', '1990-03-15', 'jean.rasolofo@email.com', 'cv/jean_rasolofo.pdf', 
 'PHP, Laravel, React, PostgreSQL, Git, Docker, API REST, TDD', 'employe'),

-- Candidat 2: Retenu (excellent profil)
(4, 'ANDRIA', 'Sophie', '1992-07-22', 'sophie.andria@email.com', 'cv/sophie_andria.pdf',
 'PHP, Laravel, Vue.js, MySQL, Git, Agile, CI/CD', 'retenu'),

-- Candidat 3: En entretien
(5, 'RAZAFY', 'Paul', '1988-11-08', 'paul.razafy@email.com', 'cv/paul_razafy.pdf',
 'PHP, Symfony, JavaScript, PostgreSQL, Git', 'en_entretien'),

-- Candidat 4: Test en cours
(6, 'RABE', 'Marie', '1995-05-30', 'marie.rabe@email.com', 'cv/marie_rabe.pdf',
 'HTML, CSS, JavaScript, React, Node.js, MongoDB', 'test_en_cours'),

-- Candidat 5: En attente (vient de postuler)
(7, 'RANDRIANA', 'David', '1993-09-12', 'david.randriana@email.com', 'cv/david_randriana.pdf',
 'Python, Django, Flask, PostgreSQL, Docker', 'en_attente'),

-- Candidat 6: Refusé (test échoué)
(8, 'RAHARISON', 'Alice', '1994-02-18', 'alice.raharison@email.com', 'cv/alice_raharison.pdf',
 'Java, Spring Boot, MySQL, Git', 'refuse'),

-- Candidat 7: Refusé (après entretien)
(9, 'RANDRIA', 'Michel', '1991-12-05', 'michel.randria@email.com', 'cv/michel_randria.pdf',
 'Marketing digital, SEO, Google Ads, Facebook Ads', 'refuse'),

-- Candidat 8: Nouvelle candidature
(10, 'RAKOTOMALALA', 'Emma', '1996-04-25', 'emma.rakoto@email.com', 'cv/emma_rakoto.pdf',
 'Commercial, Négociation, CRM Salesforce, Prospection', 'en_attente');

-- ============================================
-- 6. CANDIDATURES (Tous les statuts + historique)
-- ============================================
INSERT INTO candidatures (candidat_id, annonce_id, date_candidature, statut, score_global) VALUES
-- Candidat 1: Employé (parcours complet)
(1, 3, CURRENT_DATE - INTERVAL '60 days', 'employe', 95.50),

-- Candidat 2: Retenu
(2, 1, CURRENT_DATE - INTERVAL '35 days', 'retenu', 88.75),

-- Candidat 3: En entretien
(3, 1, CURRENT_DATE - INTERVAL '25 days', 'en_entretien', 85.00),

-- Candidat 4: Test en cours
(4, 1, CURRENT_DATE - INTERVAL '18 days', 'test_en_cours', 82.50),

-- Candidat 5: En attente (nouvelle)
(5, 1, CURRENT_DATE - INTERVAL '3 days', 'en_attente', 78.00),

-- Candidat 6: Refusé (test échoué)
(6, 1, CURRENT_DATE - INTERVAL '30 days', 'refuse', 45.00),

-- Candidat 7: Refusé (après entretien)
(7, 2, CURRENT_DATE - INTERVAL '20 days', 'refuse', 72.00),

-- Candidat 8: En attente (autre poste)
(8, 4, CURRENT_DATE - INTERVAL '2 days', 'en_attente', 76.50),

-- Candidatures historiques pour le graphique d'évolution (mois précédents)
-- Il y a 6 mois
(1, 1, CURRENT_DATE - INTERVAL '180 days', 'refuse', 65.00),
(2, 2, CURRENT_DATE - INTERVAL '175 days', 'refuse', 58.00),

-- Il y a 5 mois
(3, 1, CURRENT_DATE - INTERVAL '150 days', 'refuse', 72.00),
(4, 2, CURRENT_DATE - INTERVAL '145 days', 'employe', 85.00),
(5, 3, CURRENT_DATE - INTERVAL '140 days', 'refuse', 55.00),

-- Il y a 4 mois
(6, 1, CURRENT_DATE - INTERVAL '120 days', 'employe', 88.00),
(7, 2, CURRENT_DATE - INTERVAL '115 days', 'refuse', 62.00),
(8, 3, CURRENT_DATE - INTERVAL '110 days', 'employe', 90.00),
(1, 4, CURRENT_DATE - INTERVAL '105 days', 'refuse', 68.00),

-- Il y a 3 mois
(2, 1, CURRENT_DATE - INTERVAL '90 days', 'employe', 92.00),
(3, 2, CURRENT_DATE - INTERVAL '85 days', 'refuse', 60.00),
(4, 3, CURRENT_DATE - INTERVAL '80 days', 'employe', 87.00),

-- Il y a 2 mois
(5, 1, CURRENT_DATE - INTERVAL '60 days', 'employe', 89.00),
(6, 2, CURRENT_DATE - INTERVAL '55 days', 'refuse', 54.00),

-- Il y a 1 mois
(7, 1, CURRENT_DATE - INTERVAL '30 days', 'refuse', 66.00),
(8, 3, CURRENT_DATE - INTERVAL '28 days', 'employe', 91.00);

-- ============================================
-- 7. TESTS QCM
-- ============================================
INSERT INTO tests (annonce_id, titre, description, duree) VALUES
(1, 'Test Technique Développeur Full Stack', 
 'Évaluation des compétences en PHP, Laravel, React et bases de données',
 45),
(2, 'Test Marketing Digital',
 'Évaluation des connaissances en marketing digital, SEO et analytics',
 30),
(4, 'Test Commercial B2B',
 'Évaluation des compétences commerciales et techniques de vente',
 30);

-- Questions pour Test 1 (Développeur)
INSERT INTO questions (test_id, intitule, points) VALUES
(1, 'Quel est le design pattern principal utilisé par Laravel pour structurer les applications ?', 2),
(1, 'En React, quelle méthode (hook) permet de gérer l''état local d''un composant fonctionnel ?', 2),
(1, 'Quelle commande Git permet de fusionner une branche dans la branche courante ?', 1),
(1, 'En SQL, quelle clause permet de filtrer les résultats APRÈS un GROUP BY ?', 2),
(1, 'Quel code de statut HTTP indique qu''une ressource a été créée avec succès ?', 1);

-- Réponses pour Question 1
INSERT INTO reponses (question_id, texte, est_correcte) VALUES
(1, 'MVC (Model-View-Controller)', TRUE),
(1, 'Singleton', FALSE),
(1, 'Factory', FALSE),
(1, 'Observer', FALSE);

-- Réponses pour Question 2
INSERT INTO reponses (question_id, texte, est_correcte) VALUES
(2, 'useState()', TRUE),
(2, 'setState()', FALSE),
(2, 'componentDidMount()', FALSE),
(2, 'render()', FALSE);

-- Réponses pour Question 3
INSERT INTO reponses (question_id, texte, est_correcte) VALUES
(3, 'git merge', TRUE),
(3, 'git commit', FALSE),
(3, 'git push', FALSE),
(3, 'git pull', FALSE);

-- Réponses pour Question 4
INSERT INTO reponses (question_id, texte, est_correcte) VALUES
(4, 'HAVING', TRUE),
(4, 'WHERE', FALSE),
(4, 'ORDER BY', FALSE),
(4, 'LIMIT', FALSE);

-- Réponses pour Question 5
INSERT INTO reponses (question_id, texte, est_correcte) VALUES
(5, '201 Created', TRUE),
(5, '200 OK', FALSE),
(5, '204 No Content', FALSE),
(5, '202 Accepted', FALSE);

-- Questions pour Test 2 (Marketing)
INSERT INTO questions (test_id, intitule, points) VALUES
(2, 'Que signifie SEO ?', 1),
(2, 'Quel est le principal objectif du marketing de contenu ?', 2),
(2, 'Quelle métrique mesure le taux de conversion sur un site web ?', 2);

-- Réponses pour Test Marketing
INSERT INTO reponses (question_id, texte, est_correcte) VALUES
(6, 'Search Engine Optimization', TRUE),
(6, 'Social Engine Optimization', FALSE),
(6, 'Search Email Optimization', FALSE),
(7, 'Attirer et engager une audience cible avec du contenu pertinent', TRUE),
(7, 'Vendre directement des produits', FALSE),
(7, 'Envoyer des emails promotionnels', FALSE),
(8, 'Nombre de conversions / Nombre de visiteurs × 100', TRUE),
(8, 'Nombre de clics / Nombre d''impressions', FALSE),
(8, 'Temps passé sur le site', FALSE);

-- ============================================
-- 8. RÉSULTATS DES TESTS
-- ============================================
INSERT INTO resultats_tests (candidature_id, test_id, score, date_passage) VALUES
-- Candidat 1 (employé): Score parfait
(1, 1, 100.00, CURRENT_DATE - INTERVAL '55 days'),

-- Candidat 2 (retenu): Très bon score
(2, 1, 87.50, CURRENT_DATE - INTERVAL '33 days'),

-- Candidat 3 (en entretien): Bon score
(3, 1, 87.50, CURRENT_DATE - INTERVAL '23 days'),

-- Candidat 6 (refusé): Score insuffisant
(6, 1, 37.50, CURRENT_DATE - INTERVAL '28 days');

-- Réponses détaillées du candidat 1 (pour illustration)
INSERT INTO candidat_reponses (resultat_test_id, question_id, reponse_id, est_correcte) VALUES
(1, 1, 1, TRUE),
(1, 2, 5, TRUE),
(1, 3, 9, TRUE),
(1, 4, 13, TRUE),
(1, 5, 17, TRUE);

-- ============================================
-- 9. ENTRETIENS
-- ============================================
INSERT INTO entretiens (candidature_id, date_entretien, duree, lieu, rh_id, statut) VALUES
-- Entretien passé (candidat employé)
(1, CURRENT_DATE - INTERVAL '50 days' + TIME '14:00:00', 60, 'Salle de réunion A - Siège social', 2, 'termine'),

-- Entretien passé (candidat retenu)
(2, CURRENT_DATE - INTERVAL '30 days' + TIME '10:00:00', 60, 'Salle de réunion B - Siège social', 2, 'termine'),

-- Entretien confirmé (à venir)
(3, CURRENT_DATE + INTERVAL '3 days' + TIME '15:00:00', 60, 'Salle de réunion A - Siège social', 2, 'confirme'),

-- Entretien planifié (en attente confirmation)
(7, CURRENT_DATE + INTERVAL '7 days' + TIME '09:00:00', 45, 'Visioconférence - Zoom', 2, 'planifie'),

-- Entretien passé (candidat refusé)
(7, CURRENT_DATE - INTERVAL '18 days' + TIME '11:00:00', 45, 'Salle de réunion C - Siège social', 2, 'termine');

-- ============================================
-- 10. ÉVALUATIONS D'ENTRETIENS
-- ============================================
INSERT INTO evaluations_entretiens (entretien_id, note, remarques) VALUES
-- Évaluation excellente (candidat employé)
(1, 19.50, 'Candidat exceptionnel. Excellente maîtrise technique, très motivé, excellente communication. Forte recommandation pour l''embauche immédiate.'),

-- Évaluation très bonne (candidat retenu)
(2, 17.00, 'Très bon profil technique. Motivation claire et projet professionnel cohérent. Bonne capacité de communication. À retenir pour le poste.'),

-- Évaluation moyenne (candidat refusé)
(5, 11.50, 'Compétences techniques correctes mais manque d''expérience pratique. Motivation peu convaincante. Profil ne correspond pas aux attentes du poste.');

-- ============================================
-- 11. CONTRATS
-- ============================================
INSERT INTO contrats (candidature_id, type_contrat, date_debut, date_fin, salaire, renouvellement, statut) VALUES
-- Contrat CDI actif (candidat employé)
(1, 'CDI', CURRENT_DATE - INTERVAL '45 days', NULL, 2500000.00, 0, 'actif'),

-- Contrat d'essai actif (candidat retenu)
(2, 'essai', CURRENT_DATE - INTERVAL '5 days', CURRENT_DATE + INTERVAL '85 days', 2200000.00, 0, 'actif');

-- ============================================
-- 12. AFFILIATIONS SOCIALES
-- ============================================
INSERT INTO affiliations_sociales (contrat_id, organisme, numero_affiliation, taux_cotisation, date_affiliation) VALUES
-- Affiliations pour employé CDI
(1, 'CNAPS', 'CNAPS-2024-001234', 1.00, CURRENT_DATE - INTERVAL '40 days'),
(1, 'OSTIE', 'OSTIE-2024-005678', 1.00, CURRENT_DATE - INTERVAL '40 days'),

-- Affiliation pour employé en essai
(2, 'CNAPS', 'CNAPS-2024-009876', 1.00, CURRENT_DATE - INTERVAL '3 days');

-- ============================================
-- 13. EMPLOYÉS
-- ============================================
INSERT INTO employes (candidat_id, contrat_id, matricule, date_embauche, statut) VALUES
-- Employé CDI
(1, 1, 'EMP-2024-001', CURRENT_DATE - INTERVAL '45 days', 'actif'),

-- Employé en essai
(2, 2, 'EMP-2024-002', CURRENT_DATE - INTERVAL '5 days', 'actif');

-- ============================================
-- 14. NOTIFICATIONS
-- ============================================
INSERT INTO notifications (notifiable_type, notifiable_id, type, data, read_at) VALUES
-- Notifications RH
('App\\Models\\User', 2, 'App\\Notifications\\NouvelleCandidature', 
 '{"message": "Emma RAKOTOMALALA a postulé pour le poste de Commercial B2B", "candidature_id": 8}',
 NULL),

('App\\Models\\User', 2, 'App\\Notifications\\EntretienAVenir',
 '{"message": "Entretien avec Paul RAZAFY prévu dans 3 jours", "entretien_id": 3}',
 NULL),

('App\\Models\\User', 2, 'App\\Notifications\\TestComplete',
 '{"message": "Sophie ANDRIA a terminé le test avec un score de 87.5%", "resultat_id": 2}',
 CURRENT_DATE - INTERVAL '33 days'),

-- Notifications Candidats
('App\\Models\\User', 4, 'App\\Notifications\\CandidatureRetenue',
 '{"message": "Félicitations ! Votre candidature a été retenue. Un contrat vous sera proposé prochainement."}',
 CURRENT_DATE - INTERVAL '28 days'),

('App\\Models\\User', 5, 'App\\Notifications\\EntretienPlanifie',
 '{"message": "Votre entretien est prévu dans 3 jours", "entretien_id": 3}',
 NULL),

('App\\Models\\User', 6, 'App\\Notifications\\TestDisponible',
 '{"message": "Un test QCM est disponible pour votre candidature au poste de Développeur Full Stack Senior"}',
 CURRENT_DATE - INTERVAL '18 days'),

('App\\Models\\User', 8, 'App\\Notifications\\CandidatureRefusee',
 '{"message": "Malheureusement, votre candidature n''a pas été retenue pour ce poste. Nous vous encourageons à postuler à d''autres offres."}',
 CURRENT_DATE - INTERVAL '28 days');

-- ============================================
-- VÉRIFICATION DES DONNÉES
-- ============================================
SELECT '========================================' as "";
SELECT 'RÉSUMÉ DES DONNÉES INSÉRÉES' as "";
SELECT '========================================' as "";
SELECT COUNT(*) as "Utilisateurs" FROM users;
SELECT COUNT(*) as "Départements" FROM departements;
SELECT COUNT(*) as "Annonces" FROM annonces;
SELECT COUNT(*) as "Candidats" FROM candidats;
SELECT COUNT(*) as "Candidatures" FROM candidatures;
SELECT COUNT(*) as "Tests" FROM tests;
SELECT COUNT(*) as "Questions" FROM questions;
SELECT COUNT(*) as "Réponses" FROM reponses;
SELECT COUNT(*) as "Résultats Tests" FROM resultats_tests;
SELECT COUNT(*) as "Entretiens" FROM entretiens;
SELECT COUNT(*) as "Évaluations" FROM evaluations_entretiens;
SELECT COUNT(*) as "Contrats" FROM contrats;
SELECT COUNT(*) as "Affiliations" FROM affiliations_sociales;
SELECT COUNT(*) as "Employés" FROM employes;
SELECT COUNT(*) as "Notifications" FROM notifications;

-- Statistiques par statut
SELECT '========================================' as "";
SELECT 'STATISTIQUES PAR STATUT' as "";
SELECT '========================================' as "";
SELECT statut, COUNT(*) as nombre
FROM candidatures
GROUP BY statut
ORDER BY nombre DESC;
