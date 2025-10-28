<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Biscuit;
use App\Models\Saveur;
use App\Models\Commande;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test du modèle User : Création d'un utilisateur
     */
    public function test_can_create_user(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }

    /**
     * Test du modèle User : Vérification que is_admin est un boolean
     */
    public function test_user_is_admin_attribute_is_boolean(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $this->assertTrue($user->is_admin);
    }

    /**
     * Test du modèle User : Constantes de rôle
     */
    public function test_user_has_role_constants(): void
    {
        $this->assertEquals('USER', User::USER_ROLE);
        $this->assertEquals('ADMIN', User::ADMIN_ROLE);
    }

    /**
     * Test du modèle Biscuit : Création d'un biscuit
     */
    public function test_can_create_biscuit(): void
    {
        $saveur = Saveur::factory()->create(['nom_saveur' => 'Chocolat']);
        
        $biscuit = Biscuit::factory()->create([
            'nom_biscuit' => 'Biscuit Délicieux',
            'prix' => 5.99,
            'saveur_id' => $saveur->id,
        ]);

        $this->assertDatabaseHas('biscuits', [
            'nom_biscuit' => 'Biscuit Délicieux',
            'prix' => 5.99,
            'saveur_id' => $saveur->id,
        ]);
    }

    /**
     * Test du modèle Biscuit : Relation avec Saveur
     */
    public function test_biscuit_belongs_to_saveur(): void
    {
        $saveur = Saveur::factory()->create(['nom_saveur' => 'Vanille']);
        $biscuit = Biscuit::factory()->create(['saveur_id' => $saveur->id]);

        $this->assertInstanceOf(Saveur::class, $biscuit->saveur);
        $this->assertEquals('Vanille', $biscuit->saveur->nom_saveur);
    }

    /**
     * Test du modèle Saveur : Création d'une saveur
     */
    public function test_can_create_saveur(): void
    {
        $saveur = Saveur::factory()->create([
            'nom_saveur' => 'Caramel',
            'description' => 'Saveur sucrée de caramel',
            'emoji' => '🍮'
        ]);

        $this->assertDatabaseHas('saveurs', [
            'nom_saveur' => 'Caramel',
            'emoji' => '🍮'
        ]);
    }

    /**
     * Test du modèle Saveur : Accesseur pour nom
     */
    public function test_saveur_nom_accessor(): void
    {
        $saveur = Saveur::factory()->create(['nom_saveur' => 'Chocolat']);

        $this->assertEquals('Chocolat', $saveur->nom);
    }

    /**
     * Test du modèle Commande : Création d'une commande
     */
    public function test_can_create_commande(): void
    {
        $user = User::factory()->create();
        
        $commande = Commande::factory()->create([
            'utilisateur_id' => $user->id,
            'client_nom' => 'Marie Dupont',
            'client_email' => 'marie@example.com',
            'total_prix' => 35.00,
            'status' => 'en_attente',
        ]);

        $this->assertDatabaseHas('commandes', [
            'utilisateur_id' => $user->id,
            'client_nom' => 'Marie Dupont',
            'client_email' => 'marie@example.com',
            'total_prix' => 35.00,
            'status' => 'en_attente',
        ]);
    }
}
