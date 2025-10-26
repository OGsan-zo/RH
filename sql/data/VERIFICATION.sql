-- ============================================
-- SCRIPT DE VÉRIFICATION DES DONNÉES
-- ============================================
-- Utiliser ce script pour vérifier que toutes
-- les données de démo sont bien chargées
-- ============================================

\c rh;

-- ============================================
-- 1. COMPTAGE DES ENREGISTREMENTS
-- ============================================
\echo '========================================='
\echo 'VÉRIFICATION DES DONNÉES'
\echo '========================================='

SELECT 'Users' as table_name, COUNT(*) as count FROM users
UNION ALL
SELECT 'Départements', COUNT(*) FROM departements
UNION ALL
SELECT 'Annonces', COUNT(*) FROM annonces
UNION ALL
SELECT 'Candidats', COUNT(*) FROM candidats
UNION ALL
SELECT 'Candidatures', COUNT(*) FROM candidatures
UNION ALL
SELECT 'Tests', COUNT(*) FROM tests
UNION ALL
SELECT 'Questions', COUNT(*) FROM questions
UNION ALL
SELECT 'Réponses', COUNT(*) FROM reponses
UNION ALL
SELECT 'Résultats Tests', COUNT(*) FROM resultats_tests
UNION ALL
SELECT 'Entretiens', COUNT(*) FROM entretiens
UNION ALL
SELECT 'Évaluations', COUNT(*) FROM evaluations_entretiens
UNION ALL
SELECT 'Contrats', COUNT(*) FROM contrats
UNION ALL
SELECT 'Affiliations', COUNT(*) FROM affiliations_sociales
UNION ALL
SELECT 'Employés', COUNT(*) FROM employes
UNION ALL
SELECT 'Notifications', COUNT(*) FROM notifications
ORDER BY table_name;

-- ============================================
-- 2. VÉRIFICATION DES COMPTES
-- ============================================
\echo ''
\echo '========================================='
\echo 'COMPTES UTILISATEURS'
\echo '========================================='

SELECT 
    id,
    name,
    email,
    role
FROM users
ORDER BY role, id;

-- ============================================
-- 3. STATUT DES CANDIDATURES
-- ============================================
\echo ''
\echo '========================================='
\echo 'RÉPARTITION DES CANDIDATURES PAR STATUT'
\echo '========================================='

SELECT 
    statut,
    COUNT(*) as nombre,
    ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM candidatures), 2) as pourcentage
FROM candidatures
GROUP BY statut
ORDER BY nombre DESC;

-- ============================================
-- 4. ANNONCES OUVERTES
-- ============================================
\echo ''
\echo '========================================='
\echo 'ANNONCES OUVERTES'
\echo '========================================='

SELECT 
    a.id,
    a.titre,
    d.nom as departement,
    a.date_limite,
    CASE 
        WHEN a.date_limite < CURRENT_DATE THEN 'EXPIRÉE'
        WHEN a.date_limite <= CURRENT_DATE + INTERVAL '5 days' THEN 'URGENT'
        ELSE 'OK'
    END as urgence,
    COUNT(c.id) as nb_candidatures
FROM annonces a
LEFT JOIN departements d ON a.departement_id = d.id
LEFT JOIN candidatures c ON a.id = c.annonce_id
WHERE a.statut = 'ouverte'
GROUP BY a.id, a.titre, d.nom, a.date_limite
ORDER BY a.date_limite;

-- ============================================
-- 5. ENTRETIENS À VENIR
-- ============================================
\echo ''
\echo '========================================='
\echo 'ENTRETIENS À VENIR'
\echo '========================================='

SELECT 
    e.id,
    cand.nom || ' ' || cand.prenom as candidat,
    a.titre as poste,
    TO_CHAR(e.date_entretien, 'DD/MM/YYYY HH24:MI') as date_heure,
    e.lieu,
    e.statut
FROM entretiens e
JOIN candidatures c ON e.candidature_id = c.id
JOIN candidats cand ON c.candidat_id = cand.id
JOIN annonces a ON c.annonce_id = a.id
WHERE e.date_entretien >= CURRENT_DATE
ORDER BY e.date_entretien;

-- ============================================
-- 6. RÉSULTATS DES TESTS
-- ============================================
\echo ''
\echo '========================================='
\echo 'RÉSULTATS DES TESTS QCM'
\echo '========================================='

SELECT 
    cand.nom || ' ' || cand.prenom as candidat,
    t.titre as test,
    rt.score as score,
    CASE 
        WHEN rt.score >= 70 THEN '✓ RÉUSSI'
        ELSE '✗ ÉCHOUÉ'
    END as resultat,
    TO_CHAR(rt.date_passage, 'DD/MM/YYYY') as date_passage
FROM resultats_tests rt
JOIN candidatures c ON rt.candidature_id = c.id
JOIN candidats cand ON c.candidat_id = cand.id
JOIN tests t ON rt.test_id = t.id
ORDER BY rt.score DESC;

-- ============================================
-- 7. CONTRATS ACTIFS
-- ============================================
\echo ''
\echo '========================================='
\echo 'CONTRATS ACTIFS'
\echo '========================================='

SELECT 
    e.matricule,
    cand.nom || ' ' || cand.prenom as employe,
    cont.type_contrat,
    TO_CHAR(cont.date_debut, 'DD/MM/YYYY') as debut,
    CASE 
        WHEN cont.date_fin IS NULL THEN 'Indéterminée'
        ELSE TO_CHAR(cont.date_fin, 'DD/MM/YYYY')
    END as fin,
    cont.salaire,
    cont.statut
FROM employes e
JOIN candidats cand ON e.candidat_id = cand.id
JOIN contrats cont ON e.contrat_id = cont.id
WHERE cont.statut = 'actif'
ORDER BY cont.date_debut DESC;

-- ============================================
-- 8. AFFILIATIONS SOCIALES
-- ============================================
\echo ''
\echo '========================================='
\echo 'AFFILIATIONS SOCIALES'
\echo '========================================='

SELECT 
    cand.nom || ' ' || cand.prenom as employe,
    aff.organisme,
    aff.numero_affiliation,
    TO_CHAR(aff.date_affiliation, 'DD/MM/YYYY') as date_affiliation
FROM affiliations_sociales aff
JOIN contrats cont ON aff.contrat_id = cont.id
JOIN candidatures c ON cont.candidature_id = c.id
JOIN candidats cand ON c.candidat_id = cand.id
ORDER BY cand.nom, aff.organisme;

-- ============================================
-- 9. NOTIFICATIONS NON LUES
-- ============================================
\echo ''
\echo '========================================='
\echo 'NOTIFICATIONS NON LUES'
\echo '========================================='

SELECT 
    u.name as destinataire,
    u.role,
    n.type,
    n.data->>'message' as message,
    TO_CHAR(n.created_at, 'DD/MM/YYYY HH24:MI') as date_creation
FROM notifications n
JOIN users u ON n.notifiable_id = u.id
WHERE n.read_at IS NULL
ORDER BY n.created_at DESC;

-- ============================================
-- 10. STATISTIQUES GLOBALES
-- ============================================
\echo ''
\echo '========================================='
\echo 'STATISTIQUES GLOBALES'
\echo '========================================='

SELECT 
    'Taux de réussite aux tests' as metrique,
    ROUND(
        COUNT(CASE WHEN score >= 70 THEN 1 END) * 100.0 / COUNT(*), 
        2
    ) || '%' as valeur
FROM resultats_tests
UNION ALL
SELECT 
    'Candidatures en cours',
    COUNT(*)::text
FROM candidatures
WHERE statut IN ('en_attente', 'test_en_cours', 'en_entretien')
UNION ALL
SELECT 
    'Taux de rétention',
    ROUND(
        COUNT(CASE WHEN statut = 'retenu' OR statut = 'employe' THEN 1 END) * 100.0 / COUNT(*),
        2
    ) || '%'
FROM candidatures
UNION ALL
SELECT 
    'Délai moyen de recrutement (jours)',
    ROUND(AVG(CURRENT_DATE - date_candidature))::text
FROM candidatures
WHERE statut IN ('retenu', 'employe');

\echo ''
\echo '========================================='
\echo 'VÉRIFICATION TERMINÉE ✓'
\echo '========================================='
