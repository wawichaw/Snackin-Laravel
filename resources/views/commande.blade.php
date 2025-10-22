{{-- 
    ============================================================================
    PAGE DE COMMANDE DE BOÎTES DE BISCUITS
    ============================================================================
    
    Cette page permet aux clients de commander des boîtes de biscuits personnalisées.
    
    FONCTIONNALITÉS :
    - Sélection de la taille de boîte (4, 6, ou 12 biscuits)
    - Choix des saveurs et quantités pour chaque biscuit
    - Validation JavaScript en temps réel
    - Formulaire avec informations client
    - Protection CSRF Laravel
    
    VARIABLES PASSÉES PAR LE CONTRÔLEUR :
    - $biscuits : Collection de tous les biscuits disponibles
    - $message_succes : Message de succès après commande (via session)
    - $errors : Erreurs de validation (via session)
    
    ROUTES UTILISÉES :
    - POST /commandes : Soumission du formulaire (CommandeController@store)
    
    CONVERSION DEPUIS PHP VERS BLADE :
    - htmlspecialchars() → {{ }} (automatique)
    - <?php echo ?> → {{ }}
    - <?php if ?> → @if
    - <?php foreach ?> → @foreach
    - Protection CSRF ajoutée avec @csrf
    - old() pour conserver les valeurs en cas d'erreur
--}}
@extends('layouts.base')

@section('title', 'Commander des boîtes')

@section('content')
<div class="commande-container">
    <h1>Commander des boîtes de biscuits</h1>
    
    @if (session('message_succes'))
        <div class="alert alert-success">
            {{ session('message_succes') }}
        </div>
    @endif
    
    @if (!empty($errors))
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="commande-form">
        <form method="post" action="{{ route('commandes.add') }}">
            @csrf
            <div class="form-section">
                <h2>Choisissez la taille de votre boîte</h2>
                <div class="boite-options">
                    <label class="boite-option">
                        <input type="radio" name="taille_boite" value="4" required>
                        <div class="boite-card">
                            <div class="boite-icon">Boîte</div>
                            <h3>Boîte de 4</h3>
                            <p>Parfait pour une dégustation</p>
                            <span class="prix">15$</span>
                        </div>
                    </label>
                    
                    <label class="boite-option">
                        <input type="radio" name="taille_boite" value="6" required>
                        <div class="boite-card">
                            <div class="boite-icon">Boîte</div>
                            <h3>Boîte de 6</h3>
                            <p>Idéal pour partager</p>
                            <span class="prix">20$</span>
                        </div>
                    </label>
                    
                    <label class="boite-option">
                        <input type="radio" name="taille_boite" value="12" required>
                        <div class="boite-card">
                            <div class="boite-icon">Boîte</div>
                            <h3>Boîte de 12</h3>
                            <p>Pour les gourmands</p>
                            <span class="prix">35$</span>
                        </div>
                    </label>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Choisissez vos saveurs et quantités</h2>
                <p class="info-text">Sélectionnez les saveurs et indiquez la quantité pour chaque biscuit (total doit correspondre à la taille de boîte choisie)</p>
                <div class="saveurs-grid">
                    @foreach ($biscuits as $biscuit)
                        <div class="saveur-item">
                            <div class="saveur-card">
                                <h4>{{ $biscuit->nom_biscuit }}</h4>
                                <p class="prix-biscuit">{{ $biscuit->prix }}$</p>
                                <div class="quantite-control">
                                    <label>Quantité :</label>
                                    <input type="number" name="quantites[{{ $biscuit->id }}]" 
                                           min="0" max="12" value="0" 
                                           class="quantite-input" 
                                           data-biscuit-id="{{ $biscuit->id }}"
                                           data-biscuit-nom="{{ $biscuit->nom_biscuit }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="total-info">
                    <p>Total sélectionné : <span id="total-selectionne">0</span> / <span id="taille-max">0</span> biscuits</p>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Vos informations</h2>
                <div class="form-row">
                    <label>
                        Nom complet :
                        <input type="text" name="nom_client" required 
                               value="{{ old('nom_client') }}">
                    </label>
                    
                    <label>
                        Email :
                        <input type="email" name="email_client" required 
                               value="{{ old('email_client') }}">
                    </label>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-success btn-large">
                    Passer la commande
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tailleInputs = document.querySelectorAll('input[name="taille_boite"]');
    const quantiteInputs = document.querySelectorAll('.quantite-input');
    const totalSpan = document.getElementById('total-selectionne');
    const tailleMaxSpan = document.getElementById('taille-max');
    
    // Fonction pour mettre à jour le total
    function updateTotal() {
        let total = 0;
        quantiteInputs.forEach(input => {
            total += parseInt(input.value) || 0;
        });
        totalSpan.textContent = total;
        
        // Vérifier si le total correspond à la taille de boîte
        const tailleBoite = document.querySelector('input[name="taille_boite"]:checked');
        if (tailleBoite) {
            const tailleMax = parseInt(tailleBoite.value);
            tailleMaxSpan.textContent = tailleMax;
            
            if (total === tailleMax) {
                totalSpan.style.color = 'var(--success-color)';
            } else if (total > tailleMax) {
                totalSpan.style.color = 'var(--danger-color)';
            } else {
                totalSpan.style.color = 'var(--warning-color)';
            }
        }
    }
    
    // Écouter les changements de taille de boîte
    tailleInputs.forEach(input => {
        input.addEventListener('change', function() {
            const tailleMax = parseInt(this.value);
            tailleMaxSpan.textContent = tailleMax;
            
            // Réinitialiser les quantités
            quantiteInputs.forEach(quantiteInput => {
                quantiteInput.value = 0;
                quantiteInput.max = tailleMax;
            });
            
            updateTotal();
        });
    });
    
    // Écouter les changements de quantité
    quantiteInputs.forEach(input => {
        input.addEventListener('input', function() {
            const tailleBoite = document.querySelector('input[name="taille_boite"]:checked');
            if (tailleBoite) {
                const tailleMax = parseInt(tailleBoite.value);
                const currentTotal = Array.from(quantiteInputs).reduce((sum, inp) => sum + (parseInt(inp.value) || 0), 0);
                
                // Limiter la quantité si le total dépasse la taille de boîte
                if (currentTotal > tailleMax) {
                    const difference = currentTotal - tailleMax;
                    this.value = Math.max(0, parseInt(this.value) - difference);
                }
            }
            updateTotal();
        });
    });
});
</script>
