#!/bin/bash

# ============================================
# SCRIPT D'INSTALLATION AUTOMATIQUE
# Système RH - Données de Démonstration
# ============================================

# Couleurs pour l'affichage
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
DB_USER="postgres"
DB_NAME="rh"
SQL_DIR="$(dirname "$0")"

# ============================================
# Fonctions utilitaires
# ============================================

print_header() {
    echo -e "${BLUE}========================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}========================================${NC}"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ $1${NC}"
}

# ============================================
# Vérifications préalables
# ============================================

check_prerequisites() {
    print_header "VÉRIFICATION DES PRÉREQUIS"
    
    # Vérifier PostgreSQL
    if ! command -v psql &> /dev/null; then
        print_error "PostgreSQL n'est pas installé"
        exit 1
    fi
    print_success "PostgreSQL est installé"
    
    # Vérifier la connexion
    if ! psql -U $DB_USER -c "SELECT 1" &> /dev/null; then
        print_error "Impossible de se connecter à PostgreSQL"
        print_info "Vérifiez que PostgreSQL est démarré et que l'utilisateur $DB_USER existe"
        exit 1
    fi
    print_success "Connexion à PostgreSQL OK"
    
    echo ""
}

# ============================================
# Menu principal
# ============================================

show_menu() {
    print_header "MENU PRINCIPAL"
    echo "1) Installation complète (première fois)"
    echo "2) Reset et rechargement des données"
    echo "3) Vérification des données"
    echo "4) Supprimer toutes les données (TRUNCATE)"
    echo "5) Supprimer la base complète (DROP)"
    echo "6) Quitter"
    echo ""
    read -p "Votre choix [1-6]: " choice
}

# ============================================
# Option 1: Installation complète
# ============================================

full_install() {
    print_header "INSTALLATION COMPLÈTE"
    
    # Vérifier si la base existe
    if psql -U $DB_USER -lqt | cut -d \| -f 1 | grep -qw $DB_NAME; then
        print_warning "La base de données '$DB_NAME' existe déjà"
        read -p "Voulez-vous la supprimer et la recréer ? (o/N): " confirm
        if [[ $confirm =~ ^[Oo]$ ]]; then
            print_info "Suppression de la base existante..."
            psql -U $DB_USER -c "DROP DATABASE IF EXISTS $DB_NAME;" &> /dev/null
            print_success "Base supprimée"
        else
            print_error "Installation annulée"
            return
        fi
    fi
    
    # Créer la structure
    print_info "Création de la base et des tables..."
    if psql -U $DB_USER -f "$SQL_DIR/1-TABLE.sql" &> /dev/null; then
        print_success "Structure créée"
    else
        print_error "Erreur lors de la création de la structure"
        return
    fi
    
    # Charger les données
    print_info "Chargement des données de démonstration..."
    if psql -U $DB_USER -d $DB_NAME -f "$SQL_DIR/data/DEMO_COMPLETE.sql" &> /dev/null; then
        print_success "Données chargées"
    else
        print_error "Erreur lors du chargement des données"
        return
    fi
    
    # Vérification
    print_info "Vérification des données..."
    psql -U $DB_USER -d $DB_NAME -f "$SQL_DIR/data/VERIFICATION.sql"
    
    echo ""
    print_success "INSTALLATION TERMINÉE !"
    print_info "Comptes disponibles:"
    echo "  - Admin: admin@rh.local / admin123"
    echo "  - RH: rh@rh.local / rh123"
    echo "  - Candidat: sophie.andria@email.com / rh123"
    echo ""
}

# ============================================
# Option 2: Reset et rechargement
# ============================================

reset_and_reload() {
    print_header "RESET ET RECHARGEMENT"
    
    print_warning "Cette action va supprimer TOUTES les données !"
    read -p "Êtes-vous sûr ? (o/N): " confirm
    if [[ ! $confirm =~ ^[Oo]$ ]]; then
        print_info "Opération annulée"
        return
    fi
    
    # Vider les données
    print_info "Suppression des données..."
    if psql -U $DB_USER -d $DB_NAME -f "$SQL_DIR/drop & truncate/TRUNCATE.sql" &> /dev/null; then
        print_success "Données supprimées"
    else
        print_error "Erreur lors de la suppression"
        return
    fi
    
    # Recharger
    print_info "Rechargement des données..."
    if psql -U $DB_USER -d $DB_NAME -f "$SQL_DIR/data/DEMO_COMPLETE.sql" &> /dev/null; then
        print_success "Données rechargées"
    else
        print_error "Erreur lors du rechargement"
        return
    fi
    
    # Vérification
    print_info "Vérification..."
    psql -U $DB_USER -d $DB_NAME -f "$SQL_DIR/data/VERIFICATION.sql"
    
    echo ""
    print_success "RESET TERMINÉ !"
    echo ""
}

# ============================================
# Option 3: Vérification
# ============================================

verify_data() {
    print_header "VÉRIFICATION DES DONNÉES"
    
    if ! psql -U $DB_USER -lqt | cut -d \| -f 1 | grep -qw $DB_NAME; then
        print_error "La base de données '$DB_NAME' n'existe pas"
        print_info "Utilisez l'option 1 pour l'installer"
        return
    fi
    
    psql -U $DB_USER -d $DB_NAME -f "$SQL_DIR/data/VERIFICATION.sql"
    echo ""
}

# ============================================
# Option 4: TRUNCATE
# ============================================

truncate_data() {
    print_header "SUPPRESSION DES DONNÉES (TRUNCATE)"
    
    print_warning "Cette action va supprimer TOUTES les données (mais garder les tables) !"
    read -p "Êtes-vous sûr ? (o/N): " confirm
    if [[ ! $confirm =~ ^[Oo]$ ]]; then
        print_info "Opération annulée"
        return
    fi
    
    print_info "Suppression en cours..."
    if psql -U $DB_USER -d $DB_NAME -f "$SQL_DIR/drop & truncate/TRUNCATE.sql" &> /dev/null; then
        print_success "Données supprimées"
        print_info "Les tables sont toujours présentes"
        print_info "Utilisez l'option 2 pour recharger les données"
    else
        print_error "Erreur lors de la suppression"
    fi
    echo ""
}

# ============================================
# Option 5: DROP
# ============================================

drop_database() {
    print_header "SUPPRESSION COMPLÈTE (DROP)"
    
    print_error "ATTENTION: Cette action va supprimer TOUTE la base de données !"
    print_warning "Vous perdrez TOUTES les données ET la structure !"
    read -p "Êtes-vous VRAIMENT sûr ? Tapez 'SUPPRIMER' pour confirmer: " confirm
    if [[ $confirm != "SUPPRIMER" ]]; then
        print_info "Opération annulée"
        return
    fi
    
    print_info "Suppression de la base..."
    if psql -U $DB_USER -c "DROP DATABASE IF EXISTS $DB_NAME;" &> /dev/null; then
        print_success "Base de données supprimée"
        print_info "Utilisez l'option 1 pour réinstaller"
    else
        print_error "Erreur lors de la suppression"
    fi
    echo ""
}

# ============================================
# Boucle principale
# ============================================

main() {
    clear
    print_header "SYSTÈME RH - GESTION DES DONNÉES"
    echo ""
    
    check_prerequisites
    
    while true; do
        show_menu
        
        case $choice in
            1)
                full_install
                ;;
            2)
                reset_and_reload
                ;;
            3)
                verify_data
                ;;
            4)
                truncate_data
                ;;
            5)
                drop_database
                ;;
            6)
                print_info "Au revoir !"
                exit 0
                ;;
            *)
                print_error "Choix invalide"
                ;;
        esac
        
        echo ""
        read -p "Appuyez sur Entrée pour continuer..."
        clear
    done
}

# ============================================
# Lancement du script
# ============================================

main
