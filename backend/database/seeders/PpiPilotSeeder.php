<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\JenisKegiatan;
use App\Models\UnitRuangan;

class PpiPilotSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data 13 Jenis Kegiatan Standar IPCN (Komite PPI)
        $kegiatanPpi = [
            'Manajemen Surveilans HAIs',
            'Upaya Peningkatan Kepatuhan Kewaspadaan Standar',
            'Pendidikan Kesehatan Pada Individu Pasien',
            'Pendidikan Kesehatan Pada Kelompok',
            'Memfasilitasi Suasana Lingkungan yang Tenang dan Aman Serta Bebas Resiko Penularan Infeksi',
            'Menyusun Rencana Program Tahunan Unit',
            'Melaksanakan Manajemen ICRA Sebagai Upaya Pengawasan Resiko Infeksi',
            'Menyelenggarakan / Mengikuti Rapat',
            'Rekomendasi / Usulan PPI Kepada Direktur',
            'Koordinasi Dengan Unit Terkait',
            'Mengikuti Seminar / Workshop dll',
            'Penyusunan Laporan Bulanan/Triwulan/Tahunan',
            'Tanda Terima Surat',
        ];

        // 2. Data 22 Unit / Ruangan Rumah Sakit Standar Supervisi
        $unitRuanganList = [
            'IBS (Instalasi Bedah Sentral)',
            'IGD (Instalasi Gawat Darurat)',
            'PONEK',
            'VK (Kamar Bersalin)',
            'Ranap A',
            'Ranap B',
            'HD (Hemodialisa)',
            'Perina (Perinatologi)',
            'ICU / HCU',
            'Nifas',
            'Rawat Jalan / Poliklinik',
            'Rehab Medik',
            'Laboratorium',
            'Farmasi',
            'Gizi',
            'Radiologi',
            'UTDRS (Unit Transfusi Darah RS)',
            'Kamar Jenazah',
            'CSSD',
            'Laundry',
            'Ambulance',
            'Poliklinik',
        ];

        // 3. Buat atau Perbarui User IPCN Pilot (Muhammad Biki, S.Kep., Ners)
        $ipcnUser = User::updateOrCreate(
            ['email' => 'ipcn@ekinerja.com'],
            [
                'name' => 'Muhammad Biki, S.Kep., Ners',
                'password' => Hash::make('password12'),
                'role' => 'user',
                'phone' => '082117296313',
                'nip' => '199304192019031001',
                'golongan' => 'III/a',
                'instansi' => 'RSUD CILILIN',
                'ruangan' => 'Komite PPI / IPCN',
            ]
        );

        // Update juga user test existing 'user@ekinerja.com' agar punya data PPI yang lengkap
        $testUser = User::where('email', 'user@ekinerja.com')->first();
        if ($testUser) {
            $testUser->update([
                'name' => 'Muhammad Biki, S.Kep., Ners',
                'nip' => '123456',
                'golongan' => 'III/a',
                'instansi' => 'RSUD CILILIN',
                'ruangan' => 'Komite PPI / IPCN',
                'phone' => '082117296313',
            ]);
        }

        // Kumpulkan NIP sasaran untuk memasukkan kegiatan
        $targetNips = array_filter([
            $ipcnUser->nip,
            $testUser ? $testUser->nip : null,
            '1234589',
            '89898989'
        ]);

        // 4. Masukkan Jenis Kegiatan untuk setiap NIP
        foreach ($targetNips as $nip) {
            foreach ($kegiatanPpi as $kegiatan) {
                JenisKegiatan::firstOrCreate([
                    'nip' => $nip,
                    'jenis_kegiatan' => $kegiatan,
                ], [
                    'golongan' => 'III/a',
                ]);
            }
        }

        // 5. Masukkan Unit / Ruangan untuk setiap NIP dan sebagai master
        foreach ($targetNips as $nip) {
            $user = User::where('nip', $nip)->first();
            $namaPegawai = $user ? $user->name : 'Pegawai IPCN';

            foreach ($unitRuanganList as $ruangan) {
                UnitRuangan::firstOrCreate([
                    'nip' => $nip,
                    'nama_ruangan' => $ruangan,
                ], [
                    'nama_pegawai' => $namaPegawai,
                    'tanggal_dibuat' => now(),
                ]);
            }
        }

        echo "Seeder PPI Pilot Berhasil dijalankan!\n";
        echo "- 13 Jenis Kegiatan IPCN telah dimasukkan.\n";
        echo "- 22 Unit / Ruangan RS telah dimasukkan.\n";
        echo "- User IPCN: ipcn@ekinerja.com / password12 (NIP: 199304192019031001)\n";
        echo "- User Default: user@ekinerja.com / password12 (NIP: 123456)\n";
    }
}

