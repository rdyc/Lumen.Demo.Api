<?php

use Carbon\Carbon;
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
        $user = 'system';
        $date = Carbon::now()->toDateTimeString();

        echo "\n";
        echo "Starting data import...\n";

        $this->seedGeneral($user, $date);
        $this->seedElementForm($user, $date);

        echo "\n";
        echo "Import data complete";
    }

    private function seedGeneral($user, $date)
    {
        echo "\n";
        echo "-----------------------\n";
        echo "General Data in progress\n";

        $array = [
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

        foreach ($array as $item) {
            echo "importing: ". $item[1]."\n";

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

        echo "-----------------------\n";
        echo "General Data completed\n";
    }

    private function seedElementForm($user, $date)
    {
        echo "\n";
        echo "-----------------------\n";
        echo "Elements in progress\n";

        $array = [
            [1, NULL, 'Data Pemasok', NULL, NULL, 'H', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE,
                'child' => [
                    [2, 1, 'Biodata', NULL, NULL, 'H', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE,
                        'child' => [
                            [3, 2, 'Nama Pemasok', 'Text', NULL, 'T', 10, 3, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PEMSOK_GG', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PETANI_KECIL'],
                                'validation' => [NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE]
                            ],
                            [4, 2, 'Nomor KTP/SIM', 'Text', NULL, 'S', 10, 4, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PEMSOK_GG', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PETANI_KECIL'],
                                'validation' => [16, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE]
                            ],
                            [5, 2, 'Nomor Telepon', 'Text', NULL, 'T', 10, 5, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_KOPERASI', 'PETANI_KECIL', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN']
                            ],
                            [6, 2, 'Alamat', 'Textarea', NULL, 'T', 10, 7, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN', 'PETANI_KECIL']
                            ],
                            [9, 2, 'Koordinat', 'Text', NULL, 'T', 10, 8, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, TRUE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN', 'PETANI_KECIL']
                            ],
                            [10, 2, 'Tonase', 'Text', NULL, 'T', 10, 9, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN', 'PETANI_KECIL']
                            ],
                            [87, 2, 'Kode Pemasok', 'Text', NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PEMASOK_BARU', 'PEMSOK_GG', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PETANI_KECIL'],
                                'validation' => [NULL, NULL, NULL, NULL, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE]
                            ],
                            [88, 2, 'Status', 'Select', NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PETANI_KECIL', 'PENGEPUL_KOPERASI', 'PERUSAHAAN'],
                                'item' => [
                                    ['Aktif', 0],
                                    ['Tidak Aktif', 0]
                                ]
                            ],
                            [89, 2, 'Kategori Pemasok', 'Text', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PETANI_KECIL', 'PEMASOK_BARU'],
                                'validation' => [NULL, NULL, NULL, NULL, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE]
                            ],
                            [90, 2, 'Ref Kode Pemasok', 'Text', NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PETANI_KECIL', 'PEMASOK_BARU', 'PEMSOK_GG'],
                                'validation' => [NULL, NULL, NULL, NULL, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE]
                            ],
                            [91, 2, 'Email', 'Checkbox', NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PETANI_KECIL', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI']
                            ],
                            [92, 2, 'dsfsdf', 'Text', NULL, NULL, NULL, 13, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['Pemasok Baru']
                            ],
                            [93, 2, 'JK', 'Radio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['Pemasok Baru'],
                                'item' => [
                                    ['Laki-laki', 0],
                                    ['Perempuan', 0]
                                ]
                            ],
                            [94, 2, 'Jenis Kelamin', 'Radio', NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PEMASOK_BARU', 'PETANI_KECIL'],
                                'item' => [
                                    ['Laki-laki', 0],
                                    ['Perempuan', 0]
                                ]
                            ],
                            [95, 2, 'Contoh aja', 'Text', NULL, NULL, NULL, 13, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PEMASOK_BARU'],
                                'validation' => [NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE]
                            ],
                            [96, 2, 'Jenis Kelamin', 'Radio', NULL, NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PEMASOK_BARU'],
                                'item' => [
                                    ['Laki-laki', 0],
                                    ['Perempuan', 0]
                                ]
                            ],
                            [97, 2, 'WNI', 'Radio', NULL, NULL, NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_KOPERASI', 'PENGEPUL_PERUSAHAAN'],
                                'item' => [
                                    ['Ya', 0],
                                    ['Tidak', 0]
                                ]
                            ],
                            [98, 2, 'Jenis Revi', 'Radio', NULL, NULL, NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_KOPERASI'],
                                'validation' => [NULL, NULL, NULL, NULL, TRUE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE]
                            ],
                            [99, 2, 'Jenis', 'Radio', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PEMASOK_BARU']
                            ],
                            [100, 2, 'Test Validasi', 'Text', NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PEMASOK_BARU'],
                                'validation' => [NULL, 2, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE]
                            ],
                            [142, 2, 'Kode Parent Company', 'Text', NULL, NULL, 10, 13, NULL, NULL, NULL, NULL, '/ffb/popup/parentCompany', NULL, TRUE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN']
                            ],
                            [143, 2, 'Nama Company', 'Text', NULL, NULL, 10, 14, NULL, 142, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PEMASOK_BARU']
                            ],
                        ],
                        'matrix' => ['PEMSOK_GG', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PETANI_KECIL', 'PEMASOK_BARU']
                    ],
                    [17, 1, 'Mapping SAP', NULL, NULL, 'H', NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE,
                        'child' => [
                            [7, 17, 'No Rekening', 'Text', NULL, 'T', 10, 1, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_KOPERASI', 'PETANI_KECIL', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PEMSOK_GG'],
                                'validation' => [8, 10, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE]
                            ],
                            [8, 17, 'Bank', 'Text', NULL, 'T', 10, 2, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PETANI_KECIL']
                            ],
                            [11, 17, 'Kode SAP', 'Text', NULL, 'T', NULL, 3, NULL, NULL, NULL, NULL, '/ffb/popup/sap', NULL, TRUE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN', 'PETANI_KECIL']
                            ],
                            [12, 17, 'Nama SAP', 'Text', NULL, 'T', 10, 4, NULL, 11, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN', 'PETANI_KECIL']
                            ],
                        ],
                        'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN', 'PETANI_KECIL', 'PEMSOK GG']
                    ],
                    [18, 1, 'Tahun Tanam A', NULL, NULL, 'H', NULL, 3, 3, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE,
                        'child' => [
                            [13, 18, 'Tahun Tanam', 'Text', NULL, 'T', 10, 1, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN', 'PETANI_KECIL']
                            ],
                            [14, 18, 'HA', 'Text', NULL, 'T', 10, 2, NULL, 18, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN', 'PETANI_KECIL']
                            ],
                            [15, 18, 'Bibit', 'Text', NULL, 'T', 10, 3, NULL, 18, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN', 'PETANI_KECIL']
                            ],
                            [16, 18, 'Koordinat', 'Text', NULL, 'T', 10, 4, NULL, 18, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, TRUE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN', 'PETANI_KECIL']
                            ],
                        ],
                        'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN', 'PETANI_KECIL']
                    ],
                    [62, 1, 'Marketing Profile', NULL, NULL, 'H', NULL, 5, 5, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE,
                        'child' => [
                            [82, 62, 'Region', 'Select', NULL, 'T', NULL, 1, NULL, NULL, NULL, 'REGION_COMMTRACE', NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_KOPERASI', 'PETANI_KECIL', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN']
                            ],
                            [83, 62, 'Company', 'Select', NULL, 'T', NULL, 2, NULL, NULL, NULL, 'COMPANY_COMMTRACE', NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PETANI_KECIL', 'PENGEPUL_KOPERASI', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN']
                            ],
                            [84, 62, 'Area', 'Select', NULL, 'T', NULL, 3, NULL, NULL, NULL, 'AREA_COMMTRACE', NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_KOPERASI', 'PETANI_KECIL', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN']
                            ],
                            [85, 62, 'NIK', 'Text', NULL, 'T', NULL, 4, NULL, NULL, NULL, 'NIK', NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PETANI_KECIL'],
                                'validation' => [NULL, NULL, NULL, NULL, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE]
                            ],
                            [86, 62, 'Nama Marketing', 'Text', NULL, 'T', NULL, 5, NULL, NULL, NULL, 'NAMA', NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PETANI_KECIL'],
                                'validation' => [NULL, NULL, NULL, NULL, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE]
                            ],
                        ],
                        'matrix' => ['PETANI_KECIL', 'PENGEPUL_KOPERASI', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN']
                    ],
                    [125, 1, 'Anggota', NULL, NULL, 'H', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE,
                        'child' => [
                            [102, 125, 'Nama Anggota', 'Text', NULL, NULL, NULL, 12, NULL, NULL, NULL, NULL, '/ffb/popup/anggota', NULL, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN']
                            ],
                            [124, 125, 'Kode Anggota', 'Text', NULL, NULL, NULL, 11, NULL, NULL, NULL, NULL, '/ffb/popup/anggota', NULL, TRUE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PERUSAHAAN']
                            ],
                        ],
                        'matrix' => ['PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI']
                    ],
                ],
                'matrix' => ['PEMSOK_GG', 'PENGEPUL_PERUSAHAAN', 'PENGEPUL_KOPERASI', 'PETANI_KECIL', 'PERUSAHAAN', 'PEMASOK_BARU']
            ],
            [19, NULL, 'Additional Data', NULL, NULL, 'H', NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE,
                'child' => [
                    [20, 19, 'Legal Status', NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE,
                        'child' => [
                            [21, 20, 'Sertifikasi Tanah', 'Radio', NULL, 'S', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PETANI_KECIL'],
                                'item' => [
                                    ['Ya', 10],
                                    ['Tidak', 0]
                                ]
                            ],
                            [22, 20, 'Ijin Lokasi', 'Radio', NULL, 'S', NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PENGEPUL_KOPERASI', 'PETANI_KECIL', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN'],
                                'item' => [
                                    ['Ya', 10],
                                    ['Tidak', 0]
                                ]
                            ],
                            [23, 20, 'STDB', 'Radio', NULL, 'S', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PETANI_KECIL'],
                                'item' => [
                                    ['Ya', 10],
                                    ['Tidak', 0]
                                ]
                            ],
                        ],
                        'matrix' => ['PETANI_KECIL']
                    ],
                    [24, 19, 'Certification Status', NULL, NULL, 'H', NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                        'child' => [
                            [42, 24, 'RSP', 'Radio', NULL, 'S', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PETANI_KECIL', 'PENGEPUL_KOPERASI', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN'],
                                'item' => [
                                    ['Ya', 10],
                                    ['Tidak', 0]
                                ]
                            ],
                            [162, 24, 'Lookup data 1', 'Checkbox', NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                                'child' => null,
                                'matrix' => ['PETANI_KECIL']
                            ],
                        ],
                        'matrix' => ['PENGEPUL_KOPERASI', 'PETANI_KECIL', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN']
                    ],
                    [25, 19, 'Tracebility Status', NULL, NULL, 'H', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE,
                        'child' => null,
                        'matrix' => ['PENGEPUL_KOPERASI', 'PETANI_KECIL', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN']
                    ]
                ],
                'matrix' => ['PETANI_KECIL', 'PENGEPUL_PERUSAHAAN', 'PERUSAHAAN', 'PENGEPUL_KOPERASI']
            ],
        ];

        foreach ($array as $item) {
            $this->readElementForm($item, $user, $date);
        }

        echo "-----------------------\n";
        echo "Elements completed\n";
    }

    private function readElementForm($array, $user, $date)
    {
        $elements = $this->parseElementForm($array, $user, $date);

        $attributes = $elements;
        unset($attributes['child']); //print_r($elements['matrix']);exit;
        unset($attributes['matrix']); //print_r($elements['matrix']);exit;
        unset($attributes['validation']); //print_r($elements['matrix']);exit;
        unset($attributes['item']); //print_r($elements['matrix']);exit;

        $id = $this->insertElementForm($attributes);

        echo "importing: ". $elements['field_name'] ."\n";

        // matrix
        foreach ($elements['matrix'] as $matrix) {
            $matrix = $this->parseMatrixElement($matrix, $user, $date);
            $matrix['element_id'] = $id;
            $this->insertElementMatrix($matrix);
        }

        // items
        if (is_array($elements['item'])) {
            foreach ($elements['item'] as $item) {
                $items = $this->parseElementItem($item, $user, $date);
                $items['element_id'] = $id;
                $this->insertElementItem($items);
            }
        }

        // validations
        if (is_array($elements['validation'])) {
            //foreach ($elements['validation'] as $item) {
                $item = $this->parseElementValidation($elements['validation'], $user, $date);
                $item['element_id'] = $id;
                $this->insertElementValidation($item);
            //}
        }

        // childs
        if (is_array($elements['child'])) {
            foreach ($elements['child'] as $element) {
                $element[1] = $id;
                $this->readElementForm($element, $user, $date);
            }
        }
    }

    private function parseElementForm($array, $user, $date)
    {
        return [
            'parent_element' => $array[1],
            'field_name' => $array[2],
            'field_type' => $array[3],
            'special_form' => $array[4],
            'kriteria' => $array[5],
            'score' => $array[6],
            'sorting' => $array[7],
            'sort_parent' => $array[8],
            'group_element' => $array[9],
            'target_element' => $array[10],
            'session_data' => $array[11],
            'url_lookup' => $array[12],
            'url_data_api' => $array[13],
            'fl_lookup' => $array[14],
            'fl_lookup_data' => $array[15],
            'fl_target' => $array[16],
            'fl_multiple' => $array[17],
            'fl_group' => $array[18],
            'fl_end_group' => $array[19],
            'fl_lampiran' => $array[20],
            'fl_keterangan' => $array[21],
            'fl_additional_data' => $array[22],
            'fl_reference' => $array[23],
            'fl_end_level' => $array[24],
            'fl_status' => $array[25],
            'fl_max_score' => $array[26],
            'fl_koordinat' => $array[27],
            'fl_data_auth' => $array[28],
            'fl_data_api' => $array[29],
            'child' => $array['child'],
            'matrix' => $array['matrix'],
            'validation' => array_key_exists('validation', $array) ? $array['validation'] : null,
            'item' => array_key_exists('item', $array) ? $array['item'] : null,
            'created_by' => $user,
            'updated_by' => $user,
            'deleted_by' => null,
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => null,
        ];
    }

    private function insertElementForm($attributes)
    {
        return DB::table('tm_element_form')->insertGetId($attributes, 'element_id');
    }

    private function parseElementItem($array, $user, $date)
    {
        return [
            'element_id' => null,
            'item' => $array[0],
            'score' => $array[1],
            'fl_status' => true,
            'created_by' => $user,
            'updated_by' => $user,
            'deleted_by' => null,
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => null,
        ];
    }

    private function insertElementItem($attributes)
    {
        return DB::table('tm_element_item')->insertGetId($attributes, 'element_item_id');
    }

    private function parseElementValidation($array, $user, $date)
    {
        return [
            'element_id' => null,
            'min_length' => $array[0],
            'max_length' => $array[1],
            'script_server' => $array[2],
            'script_client' => $array[3],
            'fl_readonly' => $array[4],
            'fl_display_month' => $array[5],
            'fl_display_year' => $array[6],
            'fl_related_validasi' => $array[7],
            'fl_reusable' => $array[8],
            'fl_require' => $array[9],
            'fl_status' => true,
            'created_by' => $user,
            'updated_by' => $user,
            'deleted_by' => null,
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => null,
        ];
    }

    private function insertElementValidation($attributes)
    {
        return DB::table('tr_rules_validasi')->insertGetId($attributes, 'rules_validasi_id');
    }

    private function parseMatrixElement($array, $user, $date)
    {
        return [
            'element_id' => null,
            'kategori' => $array,
            'fl_status' => true,
            'created_by' => $user,
            'updated_by' => $user,
            'deleted_by' => null,
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => null,
        ];
    }

    private function insertElementMatrix($attributes)
    {
        return DB::table('tr_matrix_element')->insertGetId($attributes, 'matrix_element_id');
    }
}
