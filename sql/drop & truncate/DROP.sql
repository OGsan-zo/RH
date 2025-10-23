-- =====================================================
-- SUPPRIMER TOUTES LES TABLES DE LA BASE "rh"
-- =====================================================

DROP TABLE IF EXISTS 
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
CASCADE;
