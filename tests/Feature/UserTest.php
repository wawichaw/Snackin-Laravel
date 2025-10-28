<?php

namespace Tests\Feature;

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
     * Test d'authentification : Un utilisateur peut se connecter
     */
    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }

    /**
     * Test d'authentification : Un utilisateur avec mauvais mot de passe ne peut pas se connecter
     */
    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /**
     * Test des routes publiques : Page d'accueil accessible
     */
    public function test_home_page_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test des routes publiques : Page "About" accessible
     */
    public function test_about_page_is_accessible(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }

    /**
     * Test des biscuits : Liste des biscuits accessible
     */
    public function test_biscuits_index_is_accessible(): void
    {
        $response = $this->get('/biscuits');

        $response->assertStatus(200);
    }

    /**
     * Test de recherche : Recherche de biscuits fonctionne
     */
    public function test_biscuit_search_works(): void
    {
        $saveur = Saveur::factory()->create(['nom_saveur' => 'Chocolat']);
        $biscuit = Biscuit::factory()->create([
            'nom_biscuit' => 'Biscuit Test',
            'saveur_id' => $saveur->id
        ]);

        $response = $this->get('/biscuits?search=Biscuit');

        $response->assertStatus(200);
        $response->assertSee('Biscuit Test');
    }

    /**
     * Test des commandes : Un utilisateur connecté peut accéder au formulaire de commande
     */
    public function test_authenticated_user_can_access_order_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/commandes');

        $response->assertStatus(200);
    }

    /**
     * Test des commandes : Un utilisateur non connecté ne peut pas accéder au formulaire de commande
     */
    public function test_unauthenticated_user_cannot_access_order_form(): void
    {
        $response = $this->get('/commandes');

        $response->assertRedirect('/login');
    }

    /**
     * Test d'accès admin : Un admin peut accéder à la liste des commandes
     */
    public function test_admin_can_access_orders_list(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'role' => 'ADMIN'
        ]);

        $response = $this->actingAs($admin)->get('/admin/commandes');

        $response->assertStatus(200);
    }

    /**
     * Test d'accès admin : Un utilisateur non-admin ne peut pas accéder à la liste des commandes
     */
    public function test_non_admin_cannot_access_orders_list(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin/commandes');

        $response->assertStatus(403);
    }
}
