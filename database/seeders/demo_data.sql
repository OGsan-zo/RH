-- ============================================
-- SCRIPT DE DONNÉES DE DÉMONSTRATION
-- Système de Gestion RH
-- ============================================

-- 1. RESET COMPLET DES DONNÉES
-- ============================================
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE reponses;
TRUNCATE TABLE questions;
TRUNCATE TABLE tests;
TRUNCATE TABLE resultats_tests;
TRUNCATE TABLE evaluations;
TRUNCATE TABLE entretiens;
TRUNCATE TABLE affiliations;
TRUNCATE TABLE contrats;
TRUNCATE TABLE candidatures;
TRUNCATE TABLE annonces;
TRUNCATE TABLE departements;
TRUNCATE TABLE users;
TRUNCATE TABLE notifications;

SET FOREIGN_KEY_CHECKS = 1;

-- 2. UTILISATEURS (RH + CANDIDATS)
-- ============================================

-- Compte RH Admin
INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES
(1, 'Marie Dupont', 'rh@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'rh', NOW(), NOW());
-- Mot de passe: password

-- Candidats avec différents profils
INSERT INTO users (id, nom, prenom, date_naissance, email, password, cv, role, created_at, updated_at) VALUES
-- Candidat 1: Profil excellent (sera retenu)
(2, 'Rakoto', 'Jean', '1995-03-15', 'jean.rakoto@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cv_jean_rakoto.pdf', 'candidat', NOW(), NOW()),

-- Candidat 2: Profil moyen (en cours de processus)
(3, 'Razafy', 'Sophie', '1998-07-22', 'sophie.razafy@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cv_sophie_razafy.pdf', 'candidat', NOW(), NOW()),

-- Candidat 3: Refusé au test
(4, 'Andria', 'Paul', '1992-11-08', 'paul.andria@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cv_paul_andria.pdf', 'candidat', NOW(), NOW()),

-- Candidat 4: En attente de test
(5, 'Rabe', 'Marie', '1996-05-30', 'marie.rabe@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cv_marie_rabe.pdf', 'candidat', NOW(), NOW()),

-- Candidat 5: Employé (contrat actif)
(6, 'Rasolofo', 'David', '1994-09-12', 'david.rasolofo@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cv_david_rasolofo.pdf', 'candidat', NOW(), NOW()),

-- Candidat 6: Refusé après entretien
(7, 'Randriana', 'Alice', '1997-02-18', 'alice.randriana@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cv_alice_randriana.pdf', 'candidat', NOW(), NOW()),

-- Candidat 7: En entretien (confirmé)
(8, 'Raharison', 'Michel', '1993-12-05', 'michel.raharison@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cv_michel_raharison.pdf', 'candidat', NOW(), NOW()),

-- Candidat 8: Nouvelle candidature (juste postulé)
(9, 'Randria', 'Emma', '1999-04-25', 'emma.randria@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cv_emma_randria.pdf', 'candidat', NOW(), NOW());

-- 3. DÉPARTEMENTS
-- ============================================
INSERT INTO departements (id, nom, description, created_at, updated_at) VALUES
(1, 'Informatique', 'Développement logiciel et infrastructure IT', NOW(), NOW()),
(2, 'Marketing', 'Communication et stratégie marketing', NOW(), NOW()),
(3, 'Ressources Humaines', 'Gestion du personnel et recrutement', NOW(), NOW()),
(4, 'Finance', 'Comptabilité et gestion financière', NOW(), NOW()),
(5, 'Commercial', 'Ventes et relation client', NOW(), NOW());

-- 4. ANNONCES (Différents statuts)
-- ============================================
INSERT INTO annonces (id, departement_id, titre, description, competences_requises, niveau_requis, date_limite, statut, created_at, updated_at) VALUES
-- Annonce 1: Ouverte avec beaucoup de candidats
(1, 1, 'Développeur Full Stack Senior', 'Nous recherchons un développeur expérimenté en PHP/Laravel et React', 'PHP, Laravel, React, MySQL, Git', 'Senior (5+ ans)', '2025-12-31', 'ouverte', NOW(), NOW()),

-- Annonce 2: Ouverte récente
(2, 2, 'Chef de Projet Marketing Digital', 'Pilotage de projets marketing digital et gestion d\'équipe', 'Marketing digital, SEO, Google Ads, Management', 'Confirmé (3-5 ans)', '2025-11-30', 'ouverte', NOW(), NOW()),

-- Annonce 3: Fermée (recrutement terminé)
(3, 3, 'Chargé de Recrutement', 'Gestion du processus de recrutement de A à Z', 'Recrutement, Entretiens, ATS, Communication', 'Junior (1-3 ans)', '2025-10-15', 'fermee', NOW() - INTERVAL 10 DAY, NOW()),

-- Annonce 4: Ouverte avec date limite proche
(4, 5, 'Commercial B2B', 'Développement du portefeuille clients entreprises', 'Vente B2B, Négociation, CRM, Prospection', 'Confirmé (3-5 ans)', DATE_ADD(NOW(), INTERVAL 5 DAY), 'ouverte', NOW(), NOW()),

-- Annonce 5: Ouverte sans candidat
(5, 4, 'Contrôleur de Gestion', 'Analyse financière et reporting', 'Excel, Power BI, Comptabilité, Analyse', 'Senior (5+ ans)', '2025-12-15', 'ouverte', NOW(), NOW());

-- 5. CANDIDATURES (Tous les statuts possibles)
-- ============================================
INSERT INTO candidatures (id, candidat_id, annonce_id, date_candidature, statut, note_cv, created_at, updated_at) VALUES
-- Candidat 1: Parcours complet jusqu'à employé
(1, 6, 3, NOW() - INTERVAL 60 DAY, 'employe', 95, NOW() - INTERVAL 60 DAY, NOW()),

-- Candidat 2: Retenu (en attente de contrat)
(2, 2, 1, NOW() - INTERVAL 30 DAY, 'retenu', 88, NOW() - INTERVAL 30 DAY, NOW()),

-- Candidat 3: En entretien
(3, 8, 1, NOW() - INTERVAL 20 DAY, 'en_entretien', 85, NOW() - INTERVAL 20 DAY, NOW()),

-- Candidat 4: Test en cours
(4, 5, 1, NOW() - INTERVAL 15 DAY, 'test_en_cours', 82, NOW() - INTERVAL 15 DAY, NOW()),

-- Candidat 5: En attente (vient de postuler)
(5, 9, 1, NOW() - INTERVAL 2 DAY, 'en_attente', 78, NOW() - INTERVAL 2 DAY, NOW()),

-- Candidat 6: Refusé après test
(6, 4, 1, NOW() - INTERVAL 25 DAY, 'refuse', 75, NOW() - INTERVAL 25 DAY, NOW()),

-- Candidat 7: Refusé après entretien
(7, 7, 2, NOW() - INTERVAL 18 DAY, 'refuse', 80, NOW() - INTERVAL 18 DAY, NOW()),

-- Candidat 8: Test en cours (autre poste)
(8, 3, 2, NOW() - INTERVAL 12 DAY, 'test_en_cours', 83, NOW() - INTERVAL 12 DAY, NOW()),

-- Candidat 9: En attente (autre poste)
(9, 9, 4, NOW() - INTERVAL 1 DAY, 'en_attente', 76, NOW() - INTERVAL 1 DAY, NOW());

-- 6. TESTS QCM
-- ============================================
INSERT INTO tests (id, annonce_id, titre, created_at, updated_at) VALUES
(1, 1, 'Test Technique Développeur Full Stack', NOW() - INTERVAL 40 DAY, NOW()),
(2, 2, 'Test Marketing Digital', NOW() - INTERVAL 20 DAY, NOW()),
(3, 4, 'Test Commercial B2B', NOW() - INTERVAL 10 DAY, NOW());

-- Questions pour Test 1 (Développeur)
INSERT INTO questions (id, test_id, intitule, created_at, updated_at) VALUES
(1, 1, 'Quel est le design pattern utilisé par Laravel pour la gestion des requêtes HTTP ?', NOW(), NOW()),
(2, 1, 'En React, quelle méthode permet de gérer l\'état local d\'un composant fonctionnel ?', NOW(), NOW()),
(3, 1, 'Quelle commande Git permet de fusionner une branche dans la branche courante ?', NOW(), NOW()),
(4, 1, 'En SQL, quelle clause permet de filtrer les résultats après un GROUP BY ?', NOW(), NOW()),
(5, 1, 'Quel protocole HTTP est utilisé pour les API RESTful ?', NOW(), NOW());

-- Réponses pour Question 1
INSERT INTO reponses (id, question_id, texte, est_correcte, created_at, updated_at) VALUES
(1, 1, 'MVC (Model-View-Controller)', 1, NOW(), NOW()),
(2, 1, 'Singleton', 0, NOW(), NOW()),
(3, 1, 'Factory', 0, NOW(), NOW()),
(4, 1, 'Observer', 0, NOW(), NOW());

-- Réponses pour Question 2
INSERT INTO reponses (id, question_id, texte, est_correcte, created_at, updated_at) VALUES
(5, 2, 'useState()', 1, NOW(), NOW()),
(6, 2, 'setState()', 0, NOW(), NOW()),
(7, 2, 'componentDidMount()', 0, NOW(), NOW()),
(8, 2, 'render()', 0, NOW(), NOW());

-- Réponses pour Question 3
INSERT INTO reponses (id, question_id, texte, est_correcte, created_at, updated_at) VALUES
(9, 3, 'git merge', 1, NOW(), NOW()),
(10, 3, 'git commit', 0, NOW(), NOW()),
(11, 3, 'git push', 0, NOW(), NOW()),
(12, 3, 'git pull', 0, NOW(), NOW());

-- Réponses pour Question 4
INSERT INTO reponses (id, question_id, texte, est_correcte, created_at, updated_at) VALUES
(13, 4, 'HAVING', 1, NOW(), NOW()),
(14, 4, 'WHERE', 0, NOW(), NOW()),
(15, 4, 'ORDER BY', 0, NOW(), NOW()),
(16, 4, 'LIMIT', 0, NOW(), NOW());

-- Réponses pour Question 5
INSERT INTO reponses (id, question_id, texte, est_correcte, created_at, updated_at) VALUES
(17, 5, 'HTTP/HTTPS', 1, NOW(), NOW()),
(18, 5, 'FTP', 0, NOW(), NOW()),
(19, 5, 'SMTP', 0, NOW(), NOW()),
(20, 5, 'SSH', 0, NOW(), NOW());

-- Questions pour Test 2 (Marketing)
INSERT INTO questions (id, test_id, intitule, created_at, updated_at) VALUES
(6, 2, 'Que signifie SEO ?', NOW(), NOW()),
(7, 2, 'Quel est le principal objectif du marketing de contenu ?', NOW(), NOW()),
(8, 2, 'Quelle métrique mesure le taux de conversion ?', NOW(), NOW());

-- Réponses pour Test Marketing
INSERT INTO reponses (id, question_id, texte, est_correcte, created_at, updated_at) VALUES
(21, 6, 'Search Engine Optimization', 1, NOW(), NOW()),
(22, 6, 'Social Engine Optimization', 0, NOW(), NOW()),
(23, 6, 'Search Email Optimization', 0, NOW(), NOW()),
(24, 7, 'Attirer et engager une audience cible', 1, NOW(), NOW()),
(25, 7, 'Vendre directement des produits', 0, NOW(), NOW()),
(26, 8, 'Nombre de conversions / Nombre de visiteurs', 1, NOW(), NOW()),
(27, 8, 'Nombre de clics / Nombre d\'impressions', 0, NOW(), NOW());

-- 7. RÉSULTATS DES TESTS
-- ============================================
INSERT INTO resultats_tests (id, candidature_id, test_id, score, pourcentage, date_passage, created_at, updated_at) VALUES
-- Candidat 6 (employé): Excellent score
(1, 1, 1, 5, 100, NOW() - INTERVAL 55 DAY, NOW(), NOW()),

-- Candidat 2 (retenu): Très bon score
(2, 2, 1, 4, 80, NOW() - INTERVAL 28 DAY, NOW(), NOW()),

-- Candidat 8 (en entretien): Bon score
(3, 3, 1, 4, 80, NOW() - INTERVAL 18 DAY, NOW(), NOW()),

-- Candidat 4 (refusé): Score insuffisant
(4, 6, 1, 2, 40, NOW() - INTERVAL 24 DAY, NOW(), NOW()),

-- Candidat 3 (test en cours Marketing): Bon score
(5, 8, 2, 3, 100, NOW() - INTERVAL 10 DAY, NOW(), NOW());

-- 8. ENTRETIENS
-- ============================================
INSERT INTO entretiens (id, candidature_id, date_entretien, lieu, statut, created_at, updated_at) VALUES
-- Entretien passé et évalué (candidat employé)
(1, 1, NOW() - INTERVAL 50 DAY, 'Salle de réunion A - Siège social', 'termine', NOW() - INTERVAL 50 DAY, NOW()),

-- Entretien passé et évalué (candidat retenu)
(2, 2, NOW() - INTERVAL 25 DAY, 'Salle de réunion B - Siège social', 'termine', NOW() - INTERVAL 25 DAY, NOW()),

-- Entretien confirmé (à venir)
(3, 3, NOW() + INTERVAL 3 DAY, 'Salle de réunion A - Siège social', 'confirme', NOW() - INTERVAL 5 DAY, NOW()),

-- Entretien planifié (en attente de confirmation)
(4, 8, NOW() + INTERVAL 7 DAY, 'Visioconférence - Zoom', 'planifie', NOW() - INTERVAL 2 DAY, NOW()),

-- Entretien refusé par candidat
(5, 7, NOW() - INTERVAL 15 DAY, 'Salle de réunion C - Siège social', 'refuse', NOW() - INTERVAL 16 DAY, NOW());

-- 9. ÉVALUATIONS D'ENTRETIENS
-- ============================================
INSERT INTO evaluations (id, entretien_id, note_technique, note_motivation, note_communication, commentaire, created_at, updated_at) VALUES
-- Évaluation excellente (candidat employé)
(1, 1, 18, 19, 20, 'Candidat exceptionnel, très motivé et compétent. Excellente communication. Recommandation forte pour l\'embauche.', NOW() - INTERVAL 49 DAY, NOW()),

-- Évaluation très bonne (candidat retenu)
(2, 2, 16, 17, 18, 'Très bon profil technique, motivation claire, bonne présentation. À retenir pour le poste.', NOW() - INTERVAL 24 DAY, NOW());

-- 10. CONTRATS
-- ============================================
INSERT INTO contrats (id, candidature_id, type_contrat, date_debut, date_fin, salaire, statut, created_at, updated_at) VALUES
-- Contrat CDI actif (candidat employé)
(1, 1, 'cdi', NOW() - INTERVAL 45 DAY, NULL, 2500000, 'actif', NOW() - INTERVAL 45 DAY, NOW()),

-- Contrat d'essai actif (candidat retenu - vient de commencer)
(2, 2, 'essai', NOW() - INTERVAL 5 DAY, NOW() + INTERVAL 85 DAY, 2200000, 'actif', NOW() - INTERVAL 5 DAY, NOW());

-- 11. AFFILIATIONS SOCIALES
-- ============================================
INSERT INTO affiliations (id, contrat_id, organisme, numero_affiliation, date_affiliation, created_at, updated_at) VALUES
-- Affiliation pour employé CDI
(1, 1, 'CNAPS', 'CNAPS-2024-001234', NOW() - INTERVAL 40 DAY, NOW()),
(2, 1, 'OSTIE', 'OSTIE-2024-005678', NOW() - INTERVAL 40 DAY, NOW()),

-- Affiliation pour employé en essai
(3, 2, 'CNAPS', 'CNAPS-2024-009876', NOW() - INTERVAL 3 DAY, NOW());

-- 12. NOTIFICATIONS
-- ============================================
INSERT INTO notifications (id, user_id, titre, message, type, lu, created_at, updated_at) VALUES
-- Notifications RH
(1, 1, 'Nouvelle candidature', 'Emma Randria a postulé pour le poste de Développeur Full Stack Senior', 'info', 0, NOW() - INTERVAL 2 DAY, NOW()),
(2, 1, 'Entretien à venir', 'Entretien avec Michel Raharison prévu dans 3 jours', 'warning', 0, NOW() - INTERVAL 1 DAY, NOW()),
(3, 1, 'Test complété', 'Sophie Razafy a terminé le test Marketing Digital avec un score de 100%', 'success', 1, NOW() - INTERVAL 10 DAY, NOW()),

-- Notifications Candidats
(4, 2, 'Félicitations !', 'Votre candidature a été retenue. Un contrat vous sera proposé prochainement.', 'success', 1, NOW() - INTERVAL 23 DAY, NOW()),
(5, 8, 'Entretien planifié', 'Votre entretien est prévu le ' || DATE_FORMAT(NOW() + INTERVAL 3 DAY, '%d/%m/%Y à %H:%i'), 'info', 0, NOW() - INTERVAL 5 DAY, NOW()),
(6, 3, 'Test disponible', 'Un test QCM est disponible pour votre candidature', 'warning', 1, NOW() - INTERVAL 12 DAY, NOW()),
(7, 4, 'Candidature refusée', 'Malheureusement, votre candidature n\'a pas été retenue pour ce poste.', 'danger', 1, NOW() - INTERVAL 24 DAY, NOW());

-- ============================================
-- FIN DU SCRIPT
-- ============================================

-- Vérification des données insérées
SELECT 'RÉSUMÉ DES DONNÉES INSÉRÉES' as '';
SELECT COUNT(*) as 'Utilisateurs' FROM users;
SELECT COUNT(*) as 'Départements' FROM departements;
SELECT COUNT(*) as 'Annonces' FROM annonces;
SELECT COUNT(*) as 'Candidatures' FROM candidatures;
SELECT COUNT(*) as 'Tests' FROM tests;
SELECT COUNT(*) as 'Questions' FROM questions;
SELECT COUNT(*) as 'Réponses' FROM reponses;
SELECT COUNT(*) as 'Résultats Tests' FROM resultats_tests;
SELECT COUNT(*) as 'Entretiens' FROM entretiens;
SELECT COUNT(*) as 'Évaluations' FROM evaluations;
SELECT COUNT(*) as 'Contrats' FROM contrats;
SELECT COUNT(*) as 'Affiliations' FROM affiliations;
SELECT COUNT(*) as 'Notifications' FROM notifications;
