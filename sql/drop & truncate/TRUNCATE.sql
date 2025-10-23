-- =====================================================
-- VIDER TOUTES LES DONNÉES DE LA BASE "rh"
-- =====================================================
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
