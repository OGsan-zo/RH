-- =====================================================
-- NETTOYAGE DES COMPÉTENCES CORROMPUES
-- =====================================================

-- Mettre à NULL les compétences corrompues
UPDATE candidats 
SET competences = NULL 
WHERE competences IS NOT NULL 
  AND (
    competences LIKE '%Erreur extraction Gemini%'
    OR competences LIKE '%json_encode error%'
    OR competences LIKE '%Malformed UTF-8%'
  );

-- Vider toutes les compétences pour forcer la régénération
UPDATE candidats SET competences = NULL;

-- Mettre à NULL les note_cv existantes pour les recalculer
UPDATE candidatures SET note_cv = NULL;
