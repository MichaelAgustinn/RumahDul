<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WebContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Muhammad Irwan',
            'nidn' => '0026097807',
            'password' => Hash::make('0026097807'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Indrawati',
            'nidn' => '0030067903',
            'password' => Hash::make('0030067903'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Junaedi Yunding',
            'nidn' => '0905128604',
            'password' => Hash::make('0905128604'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Hernin Husaeni',
            'nidn' => '0924068702',
            'password' => Hash::make('0924068702'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Eva Yuliani',
            'nidn' => '0931128601',
            'password' => Hash::make('0931128601'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Irfan',
            'nidn' => '0903079001',
            'password' => Hash::make('0903079001'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Ika Muzdalia',
            'nidn' => '0031038901',
            'password' => Hash::make('0031038901'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Masyita Haerianti',
            'nidn' => '0021078904',
            'password' => Hash::make('0021078904'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Sastriani',
            'nidn' => '0911038902',
            'password' => Hash::make('0911038902'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Kurnia Harli',
            'nidn' => '0021099201',
            'password' => Hash::make('0021099201'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Aco Mursid',
            'nidn' => '0002079002',
            'password' => Hash::make('0002079002'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Sahriana',
            'nidn' => '0808019201',
            'password' => Hash::make('0808019201'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Achmad Indra Awaluddin',
            'nidn' => '0901019001',
            'password' => Hash::make('0901019001'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Irna Megawaty',
            'nidn' => '0007069101',
            'password' => Hash::make('0007069101'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Risna Damayanti',
            'nidn' => '0930108602',
            'password' => Hash::make('0930108602'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Weny Anggraini Adhisty',
            'nidn' => '0914048704',
            'password' => Hash::make('0914048704'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Boby Nurmagandi',
            'nidn' => '0018069305',
            'password' => Hash::make('0018069305'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Irfan Wabula',
            'nidn' => '0006089405',
            'password' => Hash::make('0006089405'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Erviana',
            'nidn' => '0015119206',
            'password' => Hash::make('0015119206'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Evidamayanti',
            'nidn' => '0027128902',
            'password' => Hash::make('0027128902'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Sri Marnianti Irnawan',
            'nidn' => '1612068901',
            'password' => Hash::make('1612068901'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Sahariah',
            'nidn' => '0917059402',
            'password' => Hash::make('0917059402'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Muhammad Amin R',
            'nidn' => '0023039001',
            'password' => Hash::make('0023039001'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Helmi Juwita',
            'nidn' => '0904069302',
            'password' => Hash::make('0904069302'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Nur Asmah',
            'nidn' => '0919089501',
            'password' => Hash::make('0919089501'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Indah Indreani Sari',
            'nidn' => '1024079501',
            'password' => Hash::make('1024079501'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Nurwahita',
            'nidn' => '0024059702',
            'password' => Hash::make('0024059702'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Resti Aulia Fitri',
            'nidn' => '9990603172',
            'password' => Hash::make('9990603172'),
            'role' => 'admin',
        ]);

        WebContent::create([
            'site_title' => 'Rumahdul - Fakultas Kesehatan',
            'footer_address' => 'Jl. Prof. Dr. Baharuddin Lopa, Majene',
            'footer_phone' => '0812-3456-7890',
            'footer_email' => 'kesehatan@unsulbar.ac.id',
        ]);
    }
}
