-- ====================================================
-- Table pour stocker les alertes de congés
-- ====================================================

CREATE TABLE IF NOT EXISTS alertes_conges (
    id SERIAL PRIMARY KEY,
    employe_id BIGINT NOT NULL REFERENCES employes(id) ON DELETE CASCADE,
    type_alerte VARCHAR(100) NOT NULL CHECK (type_alerte IN (
        'conges_non_valides',
        'absences_repetees',
        'soldes_faibles',
        'expiration_conges'
    )),
    message TEXT NOT NULL,
    est_resolue BOOLEAN DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_resolution TIMESTAMP NULL
);

-- Index pour les performances
CREATE INDEX idx_alertes_employe_id ON alertes_conges(employe_id);
CREATE INDEX idx_alertes_type ON alertes_conges(type_alerte);
CREATE INDEX idx_alertes_est_resolue ON alertes_conges(est_resolue);
CREATE INDEX idx_alertes_date_creation ON alertes_conges(date_creation);

-- ====================================================
-- Types d'alertes disponibles
-- ====================================================
-- 'conges_non_valides' : Demande de congé en attente depuis 7+ jours
-- 'absences_repetees' : Plus de 3 absences dans le mois
-- 'soldes_faibles' : Moins de 5 jours de congés restants
-- 'expiration_conges' : Congés non utilisés avant expiration
