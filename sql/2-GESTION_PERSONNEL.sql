-- ====================================================
-- 2. GESTION DU PERSONNEL - TABLES ÉTENDUES
-- ====================================================
-- Ce fichier contient les tables pour :
-- 1. Fiche employé complète
-- 2. Suivi du contrat de travail
-- 3. Historique des postes, promotions, mobilités
-- 4. Gestion des documents RH

-- ====================================================
-- A. ENRICHISSEMENT DE LA FICHE EMPLOYÉ
-- ====================================================

-- POSTES (Référence des postes disponibles)
CREATE TABLE postes (
    id SERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    titre VARCHAR(150) NOT NULL,
    description TEXT,
    departement_id INT REFERENCES departements(id) ON DELETE SET NULL,
    niveau_hierarchique INT,
    salaire_min DECIMAL(10,2),
    salaire_max DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- FICHES EMPLOYÉS (Extension de la table employes)
CREATE TABLE fiches_employes (
    id SERIAL PRIMARY KEY,
    employe_id INT UNIQUE REFERENCES employes(id) ON DELETE CASCADE,
    
    -- Identité
    cin VARCHAR(50) UNIQUE,
    lieu_naissance VARCHAR(150),
    nationalite VARCHAR(100),
    situation_matrimoniale_id INT REFERENCES enum_situations_matrimoniales(id),
    nombre_enfants INT DEFAULT 0,
    
    -- Contact
    telephone VARCHAR(20),
    telephone_secondaire VARCHAR(20),
    adresse_personnelle TEXT,
    ville VARCHAR(100),
    code_postal VARCHAR(10),
    
    -- Professionnel
    poste_id INT REFERENCES postes(id) ON DELETE SET NULL,
    photo_path TEXT,
    
    -- Bancaire
    iban VARCHAR(34),
    bic VARCHAR(11),
    titulaire_compte VARCHAR(150),
    
    -- Dates importantes
    date_naissance DATE,
    date_embauche DATE NOT NULL,
    date_fin_prevue DATE,
    
    -- Métadonnées
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ====================================================
-- B. SUIVI DU CONTRAT DE TRAVAIL
-- ====================================================

-- TYPES DE CONTRATS (Référence)
CREATE TABLE types_contrats (
    id SERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    libelle VARCHAR(100) NOT NULL,
    duree_defaut INT,
    description TEXT
);

-- CONTRATS DÉTAILLÉS (Extension/Remplacement)
CREATE TABLE contrats_detailles (
    id SERIAL PRIMARY KEY,
    employe_id INT REFERENCES employes(id) ON DELETE CASCADE,
    type_contrat_id INT REFERENCES types_contrats(id),
    
    -- Dates
    date_debut DATE NOT NULL,
    date_fin DATE,
    date_signature DATE,
    
    -- Période d'essai
    duree_essai_jours INT,
    date_fin_essai DATE,
    essai_valide BOOLEAN DEFAULT FALSE,
    
    -- Conditions
    salaire_base DECIMAL(10,2) NOT NULL,
    devise VARCHAR(3) DEFAULT 'EUR',
    duree_hebdomadaire_heures DECIMAL(4,2) DEFAULT 35,
    
    -- Renouvellement
    nombre_renouvellements INT DEFAULT 0,
    renouvellement_possible BOOLEAN DEFAULT TRUE,
    
    -- Statut
    statut_id INT REFERENCES enum_statuts_contrats(id),
    motif_fin VARCHAR(150),
    
    -- Métadonnées
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ====================================================
-- C. HISTORIQUE DES POSTES, PROMOTIONS, MOBILITÉS
-- ====================================================

-- HISTORIQUE DES POSTES
CREATE TABLE historique_postes (
    id SERIAL PRIMARY KEY,
    employe_id INT NOT NULL REFERENCES employes(id) ON DELETE CASCADE,
    poste_id INT REFERENCES postes(id) ON DELETE SET NULL,
    
    -- Dates
    date_debut DATE NOT NULL,
    date_fin DATE,
    
    -- Détails
    titre_poste VARCHAR(150),
    departement_id INT REFERENCES departements(id) ON DELETE SET NULL,
    salaire DECIMAL(10,2),
    
    -- Type de mouvement
    type_mouvement_id INT NOT NULL REFERENCES enum_types_mouvements(id),
    
    -- Métadonnées
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- PROMOTIONS
CREATE TABLE promotions (
    id SERIAL PRIMARY KEY,
    employe_id INT NOT NULL REFERENCES employes(id) ON DELETE CASCADE,
    
    -- Postes
    ancien_poste_id INT REFERENCES postes(id) ON DELETE SET NULL,
    nouveau_poste_id INT REFERENCES postes(id) ON DELETE SET NULL,
    
    -- Salaires
    ancien_salaire DECIMAL(10,2),
    nouveau_salaire DECIMAL(10,2),
    
    -- Dates
    date_promotion DATE NOT NULL,
    date_effet DATE NOT NULL,
    
    -- Justification
    motif TEXT,
    decision_numero VARCHAR(100),
    
    -- Métadonnées
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- MOBILITÉS INTERNES
CREATE TABLE mobilites (
    id SERIAL PRIMARY KEY,
    employe_id INT NOT NULL REFERENCES employes(id) ON DELETE CASCADE,
    
    -- Localisation
    ancien_departement_id INT REFERENCES departements(id) ON DELETE SET NULL,
    nouveau_departement_id INT REFERENCES departements(id) ON DELETE SET NULL,
    ancien_poste_id INT REFERENCES postes(id) ON DELETE SET NULL,
    nouveau_poste_id INT REFERENCES postes(id) ON DELETE SET NULL,
    
    -- Dates
    date_demande DATE NOT NULL,
    date_approbation DATE,
    date_effet DATE NOT NULL,
    
    -- Détails
    type_mobilite_id INT NOT NULL REFERENCES enum_types_mobilites(id),
    motif TEXT,
    statut_id INT REFERENCES enum_statuts_mobilites(id),
    
    -- Métadonnées
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ====================================================
-- D. GESTION DES DOCUMENTS RH
-- ====================================================

-- TYPES DE DOCUMENTS
CREATE TABLE types_documents (
    id SERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    libelle VARCHAR(150) NOT NULL,
    obligatoire BOOLEAN DEFAULT FALSE,
    description TEXT
);

-- DOCUMENTS RH
CREATE TABLE documents_rh (
    id SERIAL PRIMARY KEY,
    employe_id INT NOT NULL REFERENCES employes(id) ON DELETE CASCADE,
    type_document_id INT NOT NULL REFERENCES types_documents(id),
    
    -- Fichier
    nom_fichier VARCHAR(255) NOT NULL,
    chemin_fichier TEXT NOT NULL,
    type_mime VARCHAR(100),
    taille_bytes INT,
    
    -- Dates
    date_emission DATE,
    date_expiration DATE,
    date_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Validation
    valide BOOLEAN DEFAULT TRUE,
    remarques TEXT,
    
    -- Métadonnées
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ====================================================
-- E. TABLES DE RÉFÉRENCE (ÉNUMÉRATIONS)
-- ====================================================

-- ÉNUMÉRATION : Situation Matrimoniale
CREATE TABLE enum_situations_matrimoniales (
    id SERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    libelle VARCHAR(100) NOT NULL
);

INSERT INTO enum_situations_matrimoniales (code, libelle) VALUES
(1, 'celibataire'),
(2, 'marie'),
(3, 'divorce'),
(4, 'veuf');

-- ÉNUMÉRATION : Type de Mouvement
CREATE TABLE enum_types_mouvements (
    id SERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    libelle VARCHAR(100) NOT NULL
);

INSERT INTO enum_types_mouvements (code, libelle) VALUES
(1, 'embauche'),
(2, 'promotion'),
(3, 'mobilite_interne'),
(4, 'mutation'),
(5, 'demotion');

-- ÉNUMÉRATION : Statut Contrat
CREATE TABLE enum_statuts_contrats (
    id SERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    libelle VARCHAR(100) NOT NULL
);

INSERT INTO enum_statuts_contrats (code, libelle) VALUES
(1, 'actif'),
(2, 'suspendu'),
(3, 'termine'),
(4, 'resilie');

-- ÉNUMÉRATION : Type Mobilité
CREATE TABLE enum_types_mobilites (
    id SERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    libelle VARCHAR(100) NOT NULL
);

INSERT INTO enum_types_mobilites (code, libelle) VALUES
(1, 'departement'),
(2, 'poste'),
(3, 'lieu'),
(4, 'fonction');

-- ÉNUMÉRATION : Statut Mobilité
CREATE TABLE enum_statuts_mobilites (
    id SERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    libelle VARCHAR(100) NOT NULL
);

INSERT INTO enum_statuts_mobilites (code, libelle) VALUES
(1, 'en_attente'),
(2, 'approuvee'),
(3, 'rejetee');

-- Insertion des types de documents courants
INSERT INTO types_documents (code, libelle, obligatoire, description) VALUES
('CIN', 'Carte d''Identité Nationale', TRUE, 'Document d''identité officiel'),
('PASSPORT', 'Passeport', FALSE, 'Document de voyage'),
('DIPLOME', 'Diplôme', TRUE, 'Diplôme académique ou professionnel'),
('ATTESTATION_TRAVAIL', 'Attestation de Travail', FALSE, 'Attestation d''emploi antérieur'),
('CERTIFICAT_MEDICAL', 'Certificat Médical', FALSE, 'Certificat médical d''aptitude'),
('CONTRAT_SIGNE', 'Contrat Signé', TRUE, 'Contrat de travail signé'),
('FICHE_PAIE', 'Fiche de Paie', FALSE, 'Bulletin de salaire'),
('ATTESTATION_AFFILIATION', 'Attestation d''Affiliation', FALSE, 'Attestation de cotisation sociale'),
('LETTRE_ENGAGEMENT', 'Lettre d''Engagement', FALSE, 'Lettre d''engagement de l''employeur'),
('DECLARATION_IMPOT', 'Déclaration d''Impôt', FALSE, 'Déclaration fiscale');

-- Insertion des types de contrats courants
INSERT INTO types_contrats (code, libelle, duree_defaut, description) VALUES
('CDI', 'Contrat à Durée Indéterminée', NULL, 'Contrat permanent'),
('CDD', 'Contrat à Durée Déterminée', 12, 'Contrat temporaire'),
('ESSAI', 'Période d''Essai', 3, 'Période d''essai avant CDI'),
('STAGE', 'Stage', 6, 'Stage de formation'),
('APPRENTISSAGE', 'Contrat d''Apprentissage', 24, 'Contrat d''apprentissage');

-- ====================================================
-- F. INDEX POUR OPTIMISATION
-- ====================================================

CREATE INDEX idx_fiches_employes_employe_id ON fiches_employes(employe_id);
CREATE INDEX idx_fiches_employes_cin ON fiches_employes(cin);
CREATE INDEX idx_contrats_detailles_employe_id ON contrats_detailles(employe_id);
CREATE INDEX idx_contrats_detailles_statut ON contrats_detailles(statut);
CREATE INDEX idx_historique_postes_employe_id ON historique_postes(employe_id);
CREATE INDEX idx_historique_postes_date ON historique_postes(date_debut, date_fin);
CREATE INDEX idx_promotions_employe_id ON promotions(employe_id);
CREATE INDEX idx_mobilites_employe_id ON mobilites(employe_id);
CREATE INDEX idx_documents_rh_employe_id ON documents_rh(employe_id);
CREATE INDEX idx_documents_rh_type ON documents_rh(type_document_id);
CREATE INDEX idx_postes_departement_id ON postes(departement_id);
