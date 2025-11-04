<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Projects;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'weillsunfoo1@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

         DB::table('projects')->insert([
            ['project_name' => 'Project Alpha', 'description' => 'Sistem manajemen inventaris untuk gudang pusat.'],
            ['project_name' => 'Project Beta', 'description' => 'Aplikasi mobile untuk pemesanan makanan online.'],
            ['project_name' => 'Project Gamma', 'description' => 'Website profil perusahaan dengan CMS sederhana.'],
            ['project_name' => 'Project Delta', 'description' => 'Platform e-learning untuk siswa sekolah menengah.'],
            ['project_name' => 'Project Epsilon', 'description' => 'Sistem kasir berbasis web untuk toko retail.'],
            ['project_name' => 'Project Zeta', 'description' => 'Aplikasi booking tiket konser dengan QR Code.'],
            ['project_name' => 'Project Eta', 'description' => 'Dashboard analitik penjualan berbasis Laravel.'],
            ['project_name' => 'Project Theta', 'description' => 'Aplikasi absensi karyawan dengan face recognition.'],
            ['project_name' => 'Project Iota', 'description' => 'Website marketplace untuk produk lokal.'],
            ['project_name' => 'Project Kappa', 'description' => 'Sistem antrian online untuk rumah sakit.'],
            ['project_name' => 'Project Lambda', 'description' => 'Aplikasi monitoring IoT untuk smart home.'],
            ['project_name' => 'Project Mu', 'description' => 'Sistem pencatatan keuangan sederhana untuk UMKM.'],
            ['project_name' => 'Project Nu', 'description' => 'Portal berita sekolah dengan fitur admin.'],
            ['project_name' => 'Project Xi', 'description' => 'Aplikasi tracking pengiriman paket.'],
            ['project_name' => 'Project Omicron', 'description' => 'Sistem voting online untuk organisasi mahasiswa.'],
            ['project_name' => 'Project Pi', 'description' => 'Aplikasi manajemen proyek berbasis kanban.'],
            ['project_name' => 'Project Rho', 'description' => 'Website katalog produk elektronik.'],
            ['project_name' => 'Project Sigma', 'description' => 'Aplikasi catatan harian dengan login user.'],
            ['project_name' => 'Project Tau', 'description' => 'Sistem reservasi hotel berbasis Laravel.'],
            ['project_name' => 'Project Upsilon', 'description' => 'Platform donasi online dengan integrasi payment gateway.'],
            ['project_name' => 'Project Phi', 'description' => 'Sistem laporan keuangan berbasis web.'],
            ['project_name' => 'Project Chi', 'description' => 'Aplikasi belajar bahasa dengan gamifikasi.'],
            ['project_name' => 'Project Psi', 'description' => 'Sistem pengingat jadwal obat untuk pasien.'],
            ['project_name' => 'Project Omega', 'description' => 'Aplikasi catatan belanja dengan kategori.'],
            ['project_name' => 'Project Orion', 'description' => 'Platform streaming musik lokal.'],
            ['project_name' => 'Project Pegasus', 'description' => 'Aplikasi booking lapangan olahraga.'],
            ['project_name' => 'Project Phoenix', 'description' => 'Sistem manajemen perpustakaan digital.'],
            ['project_name' => 'Project Titan', 'description' => 'Aplikasi prediksi cuaca dengan API.'],
            ['project_name' => 'Project Atlas', 'description' => 'Portal lowongan kerja online.'],
            ['project_name' => 'Project Apollo', 'description' => 'Aplikasi reminder tugas harian.'],
            ['project_name' => 'Project Athena', 'description' => 'Sistem informasi akademik sekolah.'],
            ['project_name' => 'Project Hera', 'description' => 'Aplikasi penjadwalan meeting.'],
            ['project_name' => 'Project Zeus', 'description' => 'Dashboard monitoring server.'],
            ['project_name' => 'Project Hades', 'description' => 'Aplikasi kontrol keuangan pribadi.'],
            ['project_name' => 'Project Poseidon', 'description' => 'Sistem pemesanan tiket transportasi laut.'],
            ['project_name' => 'Project Ares', 'description' => 'Platform forum diskusi komunitas.'],
            ['project_name' => 'Project Hermes', 'description' => 'Aplikasi pengiriman pesan instan.'],
            ['project_name' => 'Project Demeter', 'description' => 'Website e-commerce sayuran segar.'],
            ['project_name' => 'Project Artemis', 'description' => 'Aplikasi pencatatan kegiatan olahraga.'],
            ['project_name' => 'Project Hephaestus', 'description' => 'Sistem otomatisasi laporan produksi.'],
        ]);
    }
}
