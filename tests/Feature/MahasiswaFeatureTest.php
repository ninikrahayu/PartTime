<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Lamaran;
use App\Models\Lowongan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    /**
     * Test bahwa halaman lowongan publik dapat diakses dengan sukses.
     */
    public function test_public_job_listings_page_is_accessible(): void
    {
        $response = $this->get('/lowongan');

        $response->assertStatus(200);
        $response->assertSee('Cari Lowongan');
    }

    /**
     * Test bahwa halaman dashboard mahasiswa tidak bisa diakses tanpa login.
     * Harus redirect ke halaman login.
     */
    public function test_guest_is_redirected_to_login_when_accessing_dashboard(): void
    {
        $response = $this->get('/mahasiswa/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Test bahwa mahasiswa yang terautentikasi dapat mengakses dashboard dan fitur terkait.
     */
    public function test_authenticated_mahasiswa_can_access_dashboard_and_features(): void
    {
        // Buat user mahasiswa
        $mahasiswa = User::factory()->create([
            'username' => 'mahasiswa_test',
            'role' => 'mahasiswa',
            'status' => 'verified',
        ]);

        // Akses dashboard dengan actingAs
        $response = $this->actingAs($mahasiswa)
                         ->get('/mahasiswa/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    /**
     * Test bahwa mahasiswa dapat mengakses halaman daftar lowongan favorit/wishlist.
     */
    public function test_authenticated_mahasiswa_can_access_favorites_page(): void
    {
        $mahasiswa = User::factory()->create([
            'username' => 'mahasiswa_test',
            'role' => 'mahasiswa',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($mahasiswa)
                         ->get('/mahasiswa/favorites');

        $response->assertStatus(200);
    }

    /**
     * Test bahwa mahasiswa dapat melihat daftar ulasan/review.
     */
    public function test_authenticated_mahasiswa_can_access_reviews_page(): void
    {
        $mahasiswa = User::factory()->create([
            'username' => 'mahasiswa_test',
            'role' => 'mahasiswa',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($mahasiswa)
                         ->get('/mahasiswa/reviews');

        $response->assertStatus(200);
    }

    /**
     * Test bahwa user tidak bisa melihat chat lamaran yang bukan miliknya.
     * Harus mengembalikan status 403 Forbidden.
     */
    public function test_user_cannot_access_unauthorized_chat_thread(): void
    {
        // Buat 2 user mahasiswa berbeda
        $mahasiswa1 = User::factory()->create(['username' => 'mhs1', 'role' => 'mahasiswa', 'status' => 'verified']);
        $mahasiswa2 = User::factory()->create(['username' => 'mhs2', 'role' => 'mahasiswa', 'status' => 'verified']);
        
        $penyedia = User::factory()->create(['username' => 'penyedia_test', 'role' => 'penyedia', 'status' => 'verified']);

        // Buat lowongan pekerjaan
        $lowongan = Lowongan::create([
            'penyedia_id' => $penyedia->id,
            'judul' => 'Barista Part Time',
            'deskripsi' => 'Dibutuhkan barista shift sore.',
            'gaji' => 1500000,
            'status' => 'aktif',
            'shift' => 'Sore',
            'lokasi' => 'Purwokerto',
        ]);

        // Lamaran dibuat oleh mahasiswa1
        $lamaran = Lamaran::create([
            'pelamar_id' => $mahasiswa1->id,
            'lowongan_id' => $lowongan->id,
            'status' => 'pending',
        ]);

        // Mahasiswa2 mencoba mengakses chat room dari lamaran tersebut
        $response = $this->actingAs($mahasiswa2)
                         ->get('/chat/' . $lamaran->id);

        // Harus 403 Forbidden
        $response->assertStatus(403);
    }
}
