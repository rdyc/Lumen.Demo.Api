[<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*factory(App\Models\Artist::class, 20)->create();
        factory(App\Models\Album::class, 60)->create();
        factory(App\Models\Song::class, 200)->create();*/

        $user = 'system';
        $date = \Carbon\Carbon::now()->toDateTimeString();

        // General Table
        $generals = [
            /*['ABC', 'ABC Description', 'Description Long ABC', 1, null, '#FFF', null, true],
            ['CDE', 'CDE Description', 'Description Long CDE', 2, null, '#FFF', null, true],
            ['EFG', 'EFG Description', 'Description Long EFG', 3, null, '#FFF', null, true],
            ['HIJ', 'HIJ Description', 'Description Long HIJ', 4, null, '#FFF', null, true],
            ['KLM', 'KLM Description', 'Description Long KLM', 5, null, '#FFF', null, true],
            ['NOP', 'OPQ Description', 'Description Long NOP', 6, null, '#FFF', null, true],*/

            ['BG_ICON_COM_1', 'BG_ICON_COM_1', 'icon perusahaan ke 1', 1, NULL, NULL, TRUE],
            ['BG_ICON_COM_2', 'BG_ICON_COM_2', 'icon perusahaan ke 2', 2, NULL, NULL, TRUE],
            ['BG_ICON_COM_3', 'BG_ICON_COM_3', 'icon perusahaan ke 3', 3, NULL, NULL, TRUE],
            ['BG_IMG_LOGIN', 'BG_IMG_LOGIN', NULL, 0, NULL, NULL, TRUE],
            ['EXTEND_PEMASOK', 'KATEGORI', '-', 2, NULL, NULL, TRUE],
            ['EXTEND_PEMASOK', 'KODE_AREA', 'Kode Area', 1, NULL, NULL, TRUE],
            ['ICON_COMPANY', 'ICON_1', NULL, 0, NULL, NULL, TRUE],
            ['ICON_COMPANY', 'ICON_3', NULL, 0, NULL, NULL, TRUE],
            ['ICON_COMPANY', 'ICON_2', NULL, 0, NULL, NULL, TRUE],
            ['KATEGORI_AGENDA', 'EVENT_KEGIATAN', 'EVENT/KEGIATAN', 2, NULL, NULL, TRUE],
            ['KATEGORI_AGENDA', 'KUNJUNGAN_HARIAN', 'KUNJUNGAN HARIAN', 1, NULL, NULL, TRUE],
            ['KATEGORI_PEMASOK', 'PENGEPUL_PERUSAHAAN', 'Pengepul Perusahaan', 2, 'PP', '#e62525', TRUE],
            ['KATEGORI_PEMASOK', 'PENGEPUL_KOPERASI', 'Pengepul Koperasi', 3, 'KO', NULL, TRUE],
            ['KATEGORI_PEMASOK', 'PERUSAHAAN', 'Perusahaan', 4, 'PE', NULL, TRUE],
            ['KATEGORI_PEMASOK', 'PETANI_KECIL', 'Petani Kecil', 2, 'PK', NULL, TRUE],
            ['MDN', 'MDN_CODE', 'Medan Ini BUng', 1, 'MDNRG', '#662525', TRUE],
            ['PWK', 'PWK_CODE', 'TEST', 1, 'asd', '#991a1a', TRUE],
            ['SESSION', 'JOB_CODE', 'Session untuk job user', 5, NULL, NULL, TRUE],
            ['SESSION', 'REGION_COMMTRACE', 'Session untuk Region user COMMTRACE', 10, NULL, NULL, TRUE],
            ['SESSION', 'COMPANY_COMMTRACE', 'Session company user COMMTRACE', 8, NULL, NULL, TRUE],
            ['SESSION', 'AREA_COMMTRACE', 'Session untuk area user COMM TRACE', 8, NULL, NULL, TRUE],
            ['SESSION', 'USER_ID', 'Session untuk user id', 2, NULL, NULL, TRUE],
            ['SESSION', 'NIK', 'Session untuk nik user', 6, NULL, NULL, TRUE],
            ['SESSION', 'EMAIL', 'Session untuk email user', 7, NULL, NULL, TRUE],
            ['SESSION', 'NAMA', 'Session untuk nama user', 4, NULL, NULL, TRUE],
            ['SESSION', 'AREA_CODE', 'Session untuk kode area', 1, NULL, NULL, TRUE],
            ['SESSION', 'USER_NAME', 'Session untuk user name', 3, NULL, NULL, TRUE],
            ['STATUS_AGENDA', 'SA004', 'REGISTER', 4, NULL, NULL, TRUE],
            ['STATUS_AGENDA', 'SA002', 'REALISASI', 2, NULL, NULL, TRUE],
            ['STATUS_AGENDA', 'SA001', 'DRAFT', 1, NULL, NULL, TRUE],
            ['STATUS_AGENDA', 'SA003', 'BATAL', 3, NULL, NULL, TRUE],
            ['THRESHOLD', 'CUKUP_END', '84', 1, NULL, '#0bafe2', TRUE],
            ['THRESHOLD', 'BAIK_END', '100', 1, NULL, '#29e20a', TRUE],
            ['THRESHOLD', 'CUKUP_START', '67', 2, NULL, '#0bafe2', TRUE],
            ['THRESHOLD', 'BAIK_START', '85', 1, NULL, '#29e20a', TRUE],
            ['THRESHOLD', 'KURANG_START', '0', 3, NULL, '#e315a6', TRUE],
            ['TITLE', 'FIRST_TITLE', 'COMM', 1, NULL, '#F3791F', TRUE],
            ['TITLE', 'SECOND_TITLE', 'TRACE', 1, NULL, '#666666', TRUE]
        ];

        foreach ($generals as $item) {
            $general = [
                'general_code' => $item[0],
                'description_code' => $item[1],
                'description' => $item[2],
                'sorting' => $item[3],
                'initial_code' => $item[4],
                'color' => $item[5],
                'fl_status' => $item[6],
                'created_by' => $user,
                'updated_by' => $user,
                'deleted_by' => null,
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => null,
            ];

            DB::table('tm_general_data')->insert($general);
        }

    }
}
