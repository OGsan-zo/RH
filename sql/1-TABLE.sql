-- ====================================================
-- 1. CRÉATION DE LA BASE DE DONNÉES
-- ====================================================
CREATE DATABASE rh
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'fr_FR.UTF-8'
    LC_CTYPE = 'fr_FR.UTF-8'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

\c rh; -- se connecter à la base rh

-- ====================================================
-- 2. EXTENSION REQUISE (UUID)
-- ====================================================
CREATE EXTENSION IF NOT EXISTS "pgcrypto";

-- ====================================================
-- 3. TABLES DE BASE
-- ====================================================

-- UTILISATEURS
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) CHECK (role IN ('admin','rh','candidat')) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- DEPARTEMENTS
CREATE TABLE departements (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(150) NOT NULL
);

-- ANNONCES
CREATE TABLE annonces (
    id SERIAL PRIMARY KEY,
    departement_id INT REFERENCES departements(id) ON DELETE CASCADE,
    titre VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    competences_requises TEXT,
    niveau_requis VARCHAR(100),
    date_publication DATE DEFAULT CURRENT_DATE,
    date_limite DATE,
    statut VARCHAR(50) DEFAULT 'ouverte'
);

-- TESTS
CREATE TABLE tests (
    id SERIAL PRIMARY KEY,
    annonce_id INT REFERENCES annonces(id) ON DELETE CASCADE,
    titre VARCHAR(150),
    description TEXT,
    duree INT CHECK (duree > 0)
);

-- QUESTIONS
CREATE TABLE questions (
    id SERIAL PRIMARY KEY,
    test_id INT REFERENCES tests(id) ON DELETE CASCADE,
    intitule TEXT NOT NULL,
    points INT DEFAULT 1
);

-- REPONSES
CREATE TABLE reponses (
    id SERIAL PRIMARY KEY,
    question_id INT REFERENCES questions(id) ON DELETE CASCADE,
    texte TEXT NOT NULL,
    est_correcte BOOLEAN DEFAULT FALSE
);

-- CANDIDATS
CREATE TABLE candidats (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    date_naissance DATE,
    email VARCHAR(150),
    cv_path TEXT,
    competences TEXT,
    statut VARCHAR(50) DEFAULT 'en_attente'
);

-- CANDIDATURES
CREATE TABLE candidatures (
    id SERIAL PRIMARY KEY,
    candidat_id INT REFERENCES candidats(id) ON DELETE CASCADE,
    annonce_id INT REFERENCES annonces(id) ON DELETE CASCADE,
    date_candidature DATE DEFAULT CURRENT_DATE,
    statut VARCHAR(50) DEFAULT 'en_attente',
    score_global DECIMAL(5,2)
);

-- RESULTATS TESTS
CREATE TABLE resultats_tests (
    id SERIAL PRIMARY KEY,
    candidature_id INT REFERENCES candidatures(id) ON DELETE CASCADE,
    test_id INT REFERENCES tests(id) ON DELETE CASCADE,
    score DECIMAL(5,2),
    date_passage DATE DEFAULT CURRENT_DATE
);

-- REPONSES DU CANDIDAT
CREATE TABLE candidat_reponses (
    id SERIAL PRIMARY KEY,
    resultat_test_id INT REFERENCES resultats_tests(id) ON DELETE CASCADE,
    question_id INT REFERENCES questions(id) ON DELETE CASCADE,
    reponse_id INT REFERENCES reponses(id),
    est_correcte BOOLEAN
);

-- ENTRETIENS
CREATE TABLE entretiens (
    id SERIAL PRIMARY KEY,
    candidature_id INT REFERENCES candidatures(id) ON DELETE CASCADE,
    date_entretien TIMESTAMP NOT NULL,
    duree INT DEFAULT 60,
    lieu VARCHAR(150),
    rh_id INT REFERENCES users(id),
    statut VARCHAR(50) DEFAULT 'planifie'
);

-- EVALUATIONS ENTRETIENS
CREATE TABLE evaluations_entretiens (
    id SERIAL PRIMARY KEY,
    entretien_id INT REFERENCES entretiens(id) ON DELETE CASCADE,
    note DECIMAL(4,2),
    remarques TEXT
);

-- CONTRATS
CREATE TABLE contrats (
    id SERIAL PRIMARY KEY,
    candidature_id INT REFERENCES candidatures(id) ON DELETE CASCADE,
    type_contrat VARCHAR(20) CHECK (type_contrat IN ('essai','CDD','CDI')),
    date_debut DATE NOT NULL,
    date_fin DATE,
    salaire DECIMAL(10,2),
    renouvellement INT DEFAULT 0 CHECK (renouvellement <= 1),
    statut VARCHAR(50) DEFAULT 'actif'
);

-- AFFILIATIONS SOCIALES
CREATE TABLE affiliations_sociales (
    id SERIAL PRIMARY KEY,
    contrat_id INT REFERENCES contrats(id) ON DELETE CASCADE,
    organisme VARCHAR(50) CHECK (organisme IN ('CNAPS','OSTIE','AMIT')),
    numero_affiliation VARCHAR(100),
    taux_cotisation DECIMAL(5,2) DEFAULT 1.00,
    date_affiliation DATE DEFAULT CURRENT_DATE
);

-- NOTIFICATIONS
CREATE TABLE notifications (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    notifiable_type VARCHAR(100),
    notifiable_id INT,
    type VARCHAR(150),
    data JSONB,
    read_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- EMPLOYES
CREATE TABLE employes (
    id SERIAL PRIMARY KEY,
    candidat_id INT REFERENCES candidats(id) ON DELETE CASCADE,
    contrat_id INT REFERENCES contrats(id) ON DELETE CASCADE,
    matricule VARCHAR(50) UNIQUE,
    date_embauche DATE DEFAULT CURRENT_DATE,
    statut VARCHAR(50) DEFAULT 'actif'
);
