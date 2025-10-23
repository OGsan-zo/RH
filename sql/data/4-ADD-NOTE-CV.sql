-- =====================================================
-- AJOUT DE LA COLONNE note_cv POUR L'ANALYSE IA DU CV
-- =====================================================

-- Ajout de la colonne note_cv dans la table candidatures
-- Cette note sera générée par l'IA lors de la postulation
-- Elle représente l'adéquation du CV avec les exigences du poste (0-100)
ALTER TABLE candidatures ADD COLUMN note_cv DECIMAL(5,2) DEFAULT NULL;

-- Mise à jour des candidatures existantes (optionnel)
-- Mettre 0 pour les anciennes candidatures sans analyse CV
UPDATE candidatures SET note_cv = 0 WHERE note_cv IS NULL;
