<!DOCTYPE html>
<html lang="en">
    <style>
        @import  url("https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700");

        *,
        *:before,
        *:after {
            box-sizing: border-box;
        }

        body {
            font-family: "Source Sans Pro", sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        @page  {
            margin-top: 20px;
            margin-bottom: 20px;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>

    <body>
        <div style="padding: 1rem; padding-top: 0.1rem; padding-bottom: 0.1rem">
            <h1
                style="
                    text-transform: uppercase;
                    text-align: center;
                    margin-bottom: 1px;
                    margin-top: 0px;
                "
            >
                PT Camellia Metal Indonesia
            </h1>
            <h2
                style="
                    font-weight: 400;
                    text-transform: uppercase;
                    text-align: center;
                    margin-top: 1px;
                "
            >
                Pemeriksaan Hasil Setting Mesin Drawing
            </h2>
            <table style="width: 100%; margin-bottom: 0.5rem; border: none">
                <thead>
                    <tr>
                        <td style="border: none">
                            Mesin: <?php echo e($workorder->machine?->name); ?>

                        </td>
                        <td style="border: none">
                            Grade: <?php echo e($workorder->bb_grade); ?>

                        </td>
                    </tr>
                    <tr>
                        <td style="border: none">
                            Job Order: <?php echo e($workorder->wo_number); ?>

                        </td>
                        <td style="border: none">
                            Panjang: <?php echo e($workorder->fg_size_2); ?> MM
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none">
                            Diameter: <?php echo e($workorder->fg_size_1); ?> MM
                        </td>
                        <td style="border: none">
                            Tanggal: <?php echo e($workorder->process_start); ?>

                        </td>
                    </tr>
                </thead>
            </table>
            <table
                style="
                    width: 100%;
                    margin-bottom: 0.5rem;
                    text-align: center;
                    border: 1px solid #000;
                "
            >
                <thead style="background-color: #ddd">
                    <tr style="padding-top: 5px; padding-bottom: 5px">
                        <th rowspan="2">Proses</th>
                        <th rowspan="2">Kode dies</th>
                        <th rowspan="2">Diameter dies</th>
                        <th rowspan="2">Toleransi</th>
                        <th colspan="2">Diameter aktual</th>
                    </tr>
                    <tr style="padding-top: 5px; padding-bottom: 5px">
                        <th>Setelah Dies</th>
                        <th>Setelah Polishing</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Awal</td>
                        <td><?php echo e($workorderHasTpm->kode_dies_awal); ?></td>
                        <td><?php echo e($workorderHasTpm->diameter_dies_awal); ?></td>
                        <td>
                            <span>Lihat tabel No:</span><br />
                            <span>STD.PP.25-MTD-001</span>
                        </td>
                        <td>
                            <?php echo e($workorderHasTpm->diameter_aktual_setelah_dies_awal); ?>

                        </td>
                        <td>
                            <?php echo e($workorderHasTpm->diameter_aktual_setelah_polishing_awal); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>Akhir</td>
                        <td><?php echo e($workorderHasTpm->kode_dies_akhir); ?></td>
                        <td><?php echo e($workorderHasTpm->diameter_dies_akhir); ?></td>
                        <td>
                            <span>Lihat tabel No:</span><br />
                            <span>STD.PP.25-MTD-001</span>
                        </td>
                        <td>
                            <?php echo e($workorderHasTpm->diameter_aktual_setelah_dies_akhir); ?>

                        </td>
                        <td>
                            <?php echo e($workorderHasTpm->diameter_aktual_setelah_polishing_akhir); ?>

                        </td>
                    </tr>
                </tbody>
            </table>
            <table
                class="table"
                style="width: 50%; text-align: center; margin-bottom: 0.5rem"
            >
                <thead style="background-color: #ddd">
                    <tr>
                        <th>Proses</th>
                        <th>Visual barang</th>
                        <th>Kelurusan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Awal</td>
                        <td><?php echo e($workorderHasTpm->visual_barang_awal); ?></td>
                        <td><?php echo e($workorderHasTpm->kelurusan_awal); ?></td>
                    </tr>
                    <tr>
                        <td>Akhir</td>
                        <td><?php echo e($workorderHasTpm->visual_barang_akhir); ?></td>
                        <td><?php echo e($workorderHasTpm->kelurusan_akhir); ?></td>
                    </tr>
                </tbody>
            </table>
            <table
                class="table"
                style="width: 100%; text-align: center; margin-bottom: 0.5rem"
            >
                <thead style="background-color: #ddd">
                    <tr>
                        <th>Unit</th>
                        <th>Parameter</th>
                        <th colspan="2">Standar</th>
                        <th>Actual</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="2">Pre Straightening</td>
                        <td>Putaran Roller</td>
                        <td colspan="2">Berputar</td>
                        <td>
                            <?php if($workorderHasTpm->pre_straightening_putaran_roller_berputar == 'ok'): ?> 
                                OK 
                            <?php else: ?> 
                                NG 
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Kondisi Produk</td>
                        <td colspan="2">Tidak Keluar Jalur</td>
                        <td>
                            <?php if($workorderHasTpm->pre_straightening_kondisi_produk_tidak_keluar_jalur == 'ok'): ?> 
                                OK 
                            <?php else: ?> 
                                NG 
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="4">Shot Blasting</td>
                        <td>Ampere Impeller 1</td>
                        <td colspan="2">30 - 40 A</td>
                        <td><?php echo e($workorderHasTpm->ampere_impeller_1); ?></td>
                    </tr>
                    <tr>
                        <td>Ampere Impeller 2</td>
                        <td colspan="2">30 - 40 A</td>
                        <td><?php echo e($workorderHasTpm->ampere_impeller_2); ?></td>
                    </tr>
                    <tr>
                        <td>Ampere Impeller 3</td>
                        <td colspan="2">30 - 40 A</td>
                        <td><?php echo e($workorderHasTpm->ampere_impeller_3); ?></td>
                    </tr>
                    <tr>
                        <td>Ampere Impeller 4</td>
                        <td colspan="2">30 - 40 A</td>
                        <td><?php echo e($workorderHasTpm->ampere_impeller_4); ?></td>
                    </tr>
                    <tr>
                        <td rowspan="9">Drawing</td>
                        <td rowspan="4">Speed Motor</td>
                        <td colspan="2">Mesin OB: 20 - 80 mpm</td>
                        <td>
                            <?php echo e($workorder->machine?->name === 'OB' ?
                            $workorderHasTpm->speed_motor : '-'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Mesin IB5: 20 - 80 mpm</td>
                        <td>
                            <?php echo e($workorder->machine?->name === 'IB5' ?
                            $workorderHasTpm->speed_motor : '-'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Mesin S2B: 20 - 80 mpm</td>
                        <td>
                            <?php echo e($workorder->machine?->name === 'S2B' ?
                            $workorderHasTpm->speed_motor : '-'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Mesin IB8: 20 - 80 mpm</td>
                        <td>
                            <?php echo e($workorder->machine?->name === 'IB8' ?
                            $workorderHasTpm->speed_motor : '-'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td rowspan="4">Ukuran Slide</td>
                        <td colspan="2">
                            Mesin OB: <u>></u> 2mm dari diamter F/G
                        </td>
                        <td>
                            <?php echo e($workorder->machine?->name == 'OB' ?
                            $workorderHasTpm->ukuran_slide : '-'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Mesin IB5: <u>></u> 2mm dari diamter F/G
                        </td>
                        <td>
                            <?php echo e($workorder->machine?->name == 'IB5' ?
                            $workorderHasTpm->ukuran_slide : '-'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Mesin S2B: <u>></u> 2mm dari diamter F/G
                        </td>
                        <td>
                            <?php echo e($workorder->machine?->name == 'S2B' ?
                            $workorderHasTpm->ukuran_slide : '-'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Mesin IB8: <u>></u> 2mm dari diamter F/G
                        </td>
                        <td>
                            <?php echo e($workorder->machine?->name == 'IB8' ?
                            $workorderHasTpm->ukuran_slide : '-'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>Kondisi Pelumas</td>
                        <td colspan="2">Lancar</td>
                        <td>
                            <?php if($workorderHasTpm->kondisi_pelumas == 'ok'): ?> OK
                            <?php else: ?> NG <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">Straightening</td>
                        <td>Putaran Roller</td>
                        <td colspan="2">Berputar</td>
                        <td>
                            <?php if($workorderHasTpm->straightening_putaran_roller_berputar == 'ok'): ?> 
                                OK 
                            <?php else: ?> 
                                NG 
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Kondisi Produk</td>
                        <td colspan="2">Tidak Keluar Jalur</td>
                        <td>
                            <?php if($workorderHasTpm->straightening_kondisi_produk_tidak_keluar_jalur == 'ok'): ?> 
                                OK 
                            <?php else: ?> 
                                NG 
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="8">Cutting</td>
                        <td>Panjang</td>
                        <td colspan="2">-0, +30mm</td>
                        <td><?php echo e($workorderHasTpm->cutting_panjang); ?></td>
                    </tr>
                    <tr>
                        <td>Ukuran Dies Cutting IN (OB,IB5,S2B,IB8)</td>
                        <td colspan="2">
                            Diameter Lubang Dies > 0.2mm - 1mm dari FG
                        </td>
                        <td><?php echo e($workorderHasTpm->ukuran_dies_cutting_in); ?></td>
                    </tr>
                    <tr>
                        <td>Ukuran Dies Cutting OUT (OB, IB5, S2B)</td>
                        <td colspan="2">
                            Diameter lubang dies > 1mm - 2mm dari FG
                        </td>
                        <td><?php echo e($workorderHasTpm->ukuran_dies_cutting_out); ?></td>
                    </tr>
                    <tr>
                        <td rowspan="5">Ukuran Dies Cutting OUT IB8</td>
                        <td>Size</td>
                        <td>No Cutter</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Dia. 10mm - Dia. 11mm</td>
                        <td>5</td>
                        <td>
                            <?php echo e($workorderHasTpm->ukuran_dies_cutting_out_cutter_5); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>Dia. 11,1mm - Dia. 12mm</td>
                        <td>6</td>
                        <td>
                            <?php echo e($workorderHasTpm->ukuran_dies_cutting_out_cutter_6); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>Dia. 12,1mm - Dia. 14mm</td>
                        <td>7</td>
                        <td>
                            <?php echo e($workorderHasTpm->ukuran_dies_cutting_out_cutter_7); ?>

                        </td>
                    </tr>
                    <tr>
                        <td>Dia. 14,1mm - Dia. 17mm</td>
                        <td>9</td>
                        <td>
                            <?php echo e($workorderHasTpm->ukuran_dies_cutting_out_cutter_9); ?>

                        </td>
                    </tr>
                    <tr>
                        <td rowspan="6">Polishing</td>
                        <td>Ring pelurus, Plat cetakan, Roll penekanan</td>
                        <td colspan="2">Tidak cacat / Kotor</td>
                        <td>
                            <?php if($workorderHasTpm->polishing_tidak_cacat ==
                            'ok'): ?> OK <?php else: ?> NG <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Plat kuningan / Nylon</td>
                        <td colspan="2">
                            Lebih kecil 2 - 4 mm dari Diameter produk
                        </td>
                        <td>
                            <?php echo e($workorderHasTpm->polishing_ukuran_plat_kuningan); ?>

                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">Ampere Motor</td>
                        <td colspan="2">OB/ IB5/ IB8 <u><</u> 50A</td>
                        <td>
                            <?php echo e($workorder->machine?->name == 'OB' ||
                            $workorder->machine?->name == 'IB5' ||
                            $workorder->machine?->name == 'IB8' ?
                            $workorderHasTpm->polishing_ampere_motor : '-'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">S2B <u><</u> 20A</td>
                        <td>
                            <?php echo e($workorder->machine?->name == 'S2B' ?
                            $workorderHasTpm->polishing_ampere_motor_s2b : '-'); ?>

                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">Kondisi Pelumas</td>
                        <td colspan="2">Lancar</td>
                        <td>
                            <?php if($workorderHasTpm->polishing_kondisi_pelumas_lancar == 'ok'): ?> 
                                OK 
                            <?php else: ?> 
                                NG 
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Penutup Oli Tertutup</td>
                        <td>
                            <?php if($workorderHasTpm->polishing_penutup_oli_tertutup == 'ok'): ?> 
                                OK 
                            <?php else: ?> 
                                NG 
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table
                style="
                    width: 40%;
                    margin-top: 1rem;
                    margin-bottom: 1rem;
                    border: none;
                "
            >
                <thead>
                    <tr>
                        <td
                            style="
                                border: none;
                                font-weight: bold;
                                text-align: left;
                                width: 40%;
                            "
                        >
                            Hasil Setting:
                        </td>
                        <td style="border: none; text-align: left">
                            <?php if($workorderHasTpm->hasil_setting == 'ok'): ?>
                                <img src="<?php echo e(asset('img/icons/checked.png')); ?>" alt="OK" width="16" height="16"/>&nbsp;OK
                            <?php else: ?>
                                NG
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="
                                border: none;
                                font-weight: bold;
                                text-align: left;
                                width: 40%;
                            "
                        >
                            Quality control:
                        </td>
                        <td style="border: none; text-align: left">
                            <?php echo e($workorderHasTpm->quality_control); ?>

                        </td>
                    </tr>
                </thead>
            </table>
            <table style="width: 100%; border:none;">
                <tr style="border: none;">
                    <td style="border: none; vertical-align: top;">
                        <div style="border: 1px solid #000; width: 90%; height: 7rem;">
                            <p style="margin: 0.1rem">Catatan:</p>
                            <p style="margin: 0.5rem"><?php echo e($workorderHasTpm->catatan); ?></p>
                        </div>
                    </td>
                    <td style="border: none; margin-bottom: 8px; text-alight: right; vertical-align: top;">
                        <table style="width: 80%; float: right;">
                            <tbody>
                                <tr>
                                    <td style="padding: 2px">Diperiksa:</td>
                                    <td style="padding: 2px">Dibuat oleh:</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.5rem; height: 3rem">
                                        <?php echo e($workorderHasTpm->checked_by); ?>

                                    </td>
                                    <td style="padding: 0.5rem; height: 3rem">
                                        <?php echo e($workorderHasTpm->createdBy->name); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 2px">Subleader</td>
                                    <td style="padding: 2px">Operator</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="border: none;"></td>
                    <td style="border: none; text-align: center">
                        <div style="width: 80%; border: 1px solid #000; float: right;">
                            <p style="margin: 0.1rem">F.PP.11-PRD-012-REV.03</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
<?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\user\pdf\tpm.blade.php ENDPATH**/ ?>