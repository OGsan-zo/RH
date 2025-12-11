-- ====================================================
-- 3. GESTION DES CONGÉS ET ABSENCES
-- ====================================================
-- Ce fichier contient les tables pour :
-- 1. Types de congés (payés, maladie, maternité, etc.)
-- 2. Suivi des soldes de congés par employé
-- 3. Demandes de congés avec workflow de validation
-- 4. Historique des congés pris
-- 5. Alertes automatiques

-- ====================================================
-- A. TYPES DE CONGÉS (Référence)
-- ====================================================

CREATE TABLE types_conges (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    jours_annuels DECIMAL(5,2) DEFAULT 0,
    est_remunere BOOLEAN DEFAULT TRUE,
    necessite_certificat_medical BOOLEAN DEFAULT FALSE,
    est_actif BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertion des types de congés courants
INSERT INTO types_conges (nom, description, jours_annuels, est_remunere, necessite_certificat_medical, est_actif) VALUES
('Congé Payé', 'Congé payé annuel - 2,5 jours/mois cumulable 3 ans', 30, TRUE, FALSE, TRUE),
('Congé Maladie', 'Absence pour raison médicale', 0, TRUE, TRUE, TRUE),
('Congé Maternité', 'Congé de maternité pour naissance', 112, TRUE, FALSE, TRUE),
('Congé Paternité', 'Congé de paternité pour naissance', 14, TRUE, FALSE, TRUE),
('Congé Adoption', 'Congé pour adoption d''enfant', 30, TRUE, FALSE, TRUE),
('Congé Exceptionnel', 'Congé pour événement spécial (mariage, décès)', 3, TRUE, FALSE, TRUE),
('Congé Sans Solde', 'Absence non rémunérée', 0, FALSE, FALSE, TRUE),
('Congé Sabbatique', 'Congé prolongé pour projet personnel', 0, FALSE, FALSE, TRUE),
('Congé Formation', 'Congé pour formation professionnelle', 0, TRUE, FALSE, TRUE);

-- ====================================================
-- B. SOLDES DE CONGÉS (Suivi par employé)
-- ====================================================

CREATE TABLE soldes_conges (
    id SERIAL PRIMARY KEY,
    employe_id INT NOT NULL REFERENCES employes(id) ON DELETE CASCADE,
    type_conge_id INT NOT NULL REFERENCES types_conges(id) ON DELETE CASCADE,
    
    -- Soldes
    jours_acquis DECIMAL(5,2) DEFAULT 0,
    jours_utilises DECIMAL(5,2) DEFAULT 0,
    jours_restants DECIMAL(5,2) DEFAULT 0,
    jours_reportes DECIMAL(5,2) DEFAULT 0,
    
    -- Périodes
    date_debut_periode DATE NOT NULL,
    date_fin_periode DATE NOT NULL,
    
    -- Métadonnées
    derniere_mise_a_jour TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE(employe_id, type_conge_id, date_debut_periode)
);

-- ====================================================
-- C. ÉNUMÉRATION : Statut Demande Congé
-- ====================================================

CREATE TABLE enum_statuts_demandes_conges (
    id SERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    libelle VARCHAR(100) NOT NULL
);

INSERT INTO enum_statuts_demandes_conges (code, libelle) VALUES
(1, 'en_attente'),
(2, 'approuvee'),
(3, 'rejetee'),
(4, 'annulee');

-- ====================================================
-- D. DEMANDES DE CONGÉS (Workflow de validation)
-- ====================================================

CREATE TABLE demandes_conges (
    id SERIAL PRIMARY KEY,
    employe_id INT NOT NULL REFERENCES employes(id) ON DELETE CASCADE,
    type_conge_id INT NOT NULL REFERENCES types_conges(id) ON DELETE CASCADE,
    
    -- Dates
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    nombre_jours DECIMAL(5,2) NOT NULL,
    
    -- Détails
    motif TEXT,
    certificat_medical_path TEXT,
    
    -- Workflow
    statut_id INT DEFAULT 1 REFERENCES enum_statuts_demandes_conges(id),
    validateur_id INT REFERENCES users(id) ON DELETE SET NULL,
    date_validation TIMESTAMP,
    commentaire_validation TEXT,
    
    -- Métadonnées
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ====================================================
-- E. HISTORIQUE DES CONGÉS PRIS
-- ====================================================

CREATE TABLE historique_conges (
    id SERIAL PRIMARY KEY,
    employe_id INT NOT NULL REFERENCES employes(id) ON DELETE CASCADE,
    demande_conge_id INT NOT NULL REFERENCES demandes_conges(id) ON DELETE CASCADE,
    type_conge_id INT NOT NULL REFERENCES types_conges(id) ON DELETE CASCADE,
    
    -- Dates
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    nombre_jours_pris DECIMAL(5,2) NOT NULL,
    
    -- Détails
    motif TEXT,
    validateur_id INT REFERENCES users(id) ON DELETE SET NULL,
    
    -- Métadonnées
    date_enregistrement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ====================================================
-- F. ALERTES AUTOMATIQUES
-- ====================================================

CREATE TABLE alertes_conges (
    id SERIAL PRIMARY KEY,
    employe_id INT NOT NULL REFERENCES employes(id) ON DELETE CASCADE,
    type_alerte VARCHAR(100) NOT NULL,
    
    -- Types : conges_non_valides, absences_repetees, solde_faible, expiration_conges
    
    message TEXT NOT NULL,
    est_lue BOOLEAN DEFAULT FALSE,
    date_alerte TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_lecture TIMESTAMP,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ====================================================
-- G. CALENDRIER DES ABSENCES (Planning)
-- ====================================================

CREATE TABLE calendrier_absences (
    id SERIAL PRIMARY KEY,
    employe_id INT NOT NULL REFERENCES employes(id) ON DELETE CASCADE,
    demande_conge_id INT REFERENCES demandes_conges(id) ON DELETE SET NULL,
    
    -- Dates
    date_absence DATE NOT NULL,
    type_absence VARCHAR(50) NOT NULL,
    
    -- Détails
    est_confirmee BOOLEAN DEFAULT FALSE,
    notes TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE(employe_id, date_absence)
);

-- ====================================================
-- H. INDEX POUR OPTIMISATION
-- ====================================================

CREATE INDEX idx_soldes_conges_employe_id ON soldes_conges(employe_id);
CREATE INDEX idx_soldes_conges_type_conge_id ON soldes_conges(type_conge_id);
CREATE INDEX idx_soldes_conges_periode ON soldes_conges(date_debut_periode, date_fin_periode);

CREATE INDEX idx_demandes_conges_employe_id ON demandes_conges(employe_id);
CREATE INDEX idx_demandes_conges_statut ON demandes_conges(statut_id);
CREATE INDEX idx_demandes_conges_dates ON demandes_conges(date_debut, date_fin);
CREATE INDEX idx_demandes_conges_validateur ON demandes_conges(validateur_id);

CREATE INDEX idx_historique_conges_employe_id ON historique_conges(employe_id);
CREATE INDEX idx_historique_conges_dates ON historique_conges(date_debut, date_fin);

CREATE INDEX idx_alertes_conges_employe_id ON alertes_conges(employe_id);
CREATE INDEX idx_alertes_conges_type ON alertes_conges(type_alerte);
CREATE INDEX idx_alertes_conges_lue ON alertes_conges(est_lue);

CREATE INDEX idx_calendrier_absences_employe_id ON calendrier_absences(employe_id);
CREATE INDEX idx_calendrier_absences_date ON calendrier_absences(date_absence);
