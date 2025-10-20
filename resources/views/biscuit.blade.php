{{-- 
    ============================================================================
    PAGE D'AFFICHAGE DU MENU DES BISCUITS
    ============================================================================
    
    Cette page affiche la liste complète des biscuits disponibles avec leurs informations.
    
    FONCTIONNALITÉS :
    - Affichage de tous les biscuits avec nom, prix et saveur
    - Boutons pour voir/ajouter des commentaires
    - Actions d'administration pour les admins (modifier, supprimer)
    - Section corbeille pour restaurer les biscuits supprimés
    - Design responsive et moderne
    
    VARIABLES PASSÉES PAR LE CONTRÔLEUR :
    - $biscuits : Collection de tous les biscuits actifs avec leurs saveurs
    - $supprimes : Collection des biscuits supprimés (uniquement pour les admins)
    - $error : Message d'erreur en cas de problème (debug)
    
    ROUTES UTILISÉES :
    - GET /biscuits : Affichage principal (BiscuitController@index)
    - GET /biscuits/{id}/commentaires : Voir les commentaires
    - GET /biscuits/{id}/ajouter-commentaire : Ajouter un commentaire
    - GET /admin-biscuits/{action}/{id} : Actions d'administration
    
    PERMISSIONS :
    - Utilisateurs non connectés : Peuvent voir les biscuits et ajouter des commentaires
    - Utilisateurs connectés : Même accès + pas de bouton "ajouter commentaire"
    - Administrateurs (is_admin=true) : Accès complet + actions admin + corbeille
    
    CONVERSION DEPUIS PHP VERS BLADE :
    - $b->getNomBiscuit() → $biscuit->nom_biscuit
    - $b->getPrix() → $biscuit->prix
    - $b->getId() → $biscuit->id
    - Saveur::getNomById() → $biscuit->saveur->nom_saveur
    - current_user_id() → auth()->check()
    - is_admin() → auth()->user()->is_admin
--}}

<div class="biscuits-container">
    <h1>Notre Menu de Biscuits</h1>
    
    @if (isset($error))
        <div class="alert alert-danger">
            <strong>Erreur :</strong> {{ $error }}
        </div>
    @endif
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <p>Nombre de biscuits : {{ $biscuits->count() }}</p>
    
    <ul class="biscuits-list">
        @forelse ($biscuits as $biscuit)
            <li class="biscuit-item">
                <span class="biscuit-info">
                    <strong>{{ $biscuit->nom_biscuit }}</strong> - 
                    <span class="price">{{ $biscuit->prix }}$</span>
                    @if($biscuit->saveur)
                        - <span class="saveur">{{ $biscuit->saveur->nom_saveur }}</span>
                    @endif
                </span>
            </li>
        @empty
            <li>Aucun biscuit trouvé.</li>
        @endforelse
    </ul>
</div>

