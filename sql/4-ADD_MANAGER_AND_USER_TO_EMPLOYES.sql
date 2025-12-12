-- ====================================================
-- Ajout des colonnes manager_id et user_id à la table employes
-- Pour la validation hiérarchique des congés
-- ====================================================

-- Ajouter la colonne manager_id (référence à un autre employé)
ALTER TABLE employes
ADD COLUMN manager_id BIGINT NULL,
ADD CONSTRAINT fk_employes_manager 
    FOREIGN KEY (manager_id) REFERENCES employes(id) ON DELETE SET NULL;

-- Ajouter la colonne user_id (référence à la table users)
ALTER TABLE employes
ADD COLUMN user_id BIGINT NULL,
ADD CONSTRAINT fk_employes_user 
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;

-- Créer un index sur manager_id pour les performances
CREATE INDEX idx_employes_manager_id ON employes(manager_id);

-- Créer un index sur user_id pour les performances
CREATE INDEX idx_employes_user_id ON employes(user_id);

-- ====================================================
-- Vérification (optionnel)
-- ====================================================
-- SELECT * FROM employes LIMIT 5;
-- \d employes  -- Pour voir la structure de la table
