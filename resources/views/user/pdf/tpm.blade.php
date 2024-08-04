<!DOCTYPE html>
<html lang="en">
    <style>
        @import url("https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700");

        *,
        *:before,
        *:after {
            box-sizing: border-box;
        }

        body {
            font-family: "Source Sans Pro", sans-serif;
            font-size: 12px;
            margin: 0;
        }
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>

    <body>
        <div style="padding: 1rem">
            <h1
                style="
                    text-transform: uppercase;
                    text-align: center;
                    margin-bottom: 1px;
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
                        <td style="border: none">Mesin: {{$workorder->machine?->name}}</td>
                        <td style="border: none">Grade: {{$workorder->bb_grade}}</td>
                    </tr>
                    <tr>
                        <td style="border: none">Job Order: {{$workorder->wo_number}}</td>
                        <td style="border: none">Panjang: {{$workorder->fg_size_2}} MM</td>
                    </tr>
                    <tr>
                        <td style="border: none">Diameter: {{$workorder->fg_size_1}} MM</td>
                        <td style="border: none">
                            Tanggal: {{$workorder->process_start}}
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
                        <td>{{$workorderHasTpm->kode_dies_awal}}</td>
                        <td>{{$workorderHasTpm->diameter_dies_awal}}</td>
                        <td>
                            <span>Lihat tabel No:</span><br>
                            <span>STD.PP.25-MTD-001</span>
                        </td>
                        <td>{{$workorderHasTpm->diameter_aktual_setelah_dies_awal}}</td>
                        <td>{{$workorderHasTpm->diameter_aktual_setelah_polishing_awal}}</td>
                    </tr>
                    <tr>
                        <td>Akhir</td>
                        <td>{{$workorderHasTpm->kode_dies_akhir}}</td>
                        <td>{{$workorderHasTpm->diameter_dies_akhir}}</td>
                        <td>
                            <span>Lihat tabel No:</span><br>
                            <span>STD.PP.25-MTD-001</span>
                        </td>
                        <td>{{$workorderHasTpm->diameter_aktual_setelah_dies_akhir}}</td>
                        <td>{{$workorderHasTpm->diameter_aktual_setelah_polishing_akhir}}</td>
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
                        <td>
                            @if ($workorderHasTpm->visual_barang_awal == 'ok')
                                OK
                            @else
                                NG
                            @endif
                        </td>
                        <td>
                            @if ($workorderHasTpm->kelurusan_awal == 'ok')
                                OK
                            @else
                                NG
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Akhir</td>
                        <td>
                            @if ($workorderHasTpm->visual_barang_akhir == 'ok')
                                OK
                            @else
                                NG
                            @endif
                        </td>
                        <td>
                            @if ($workorderHasTpm->kelurusan_akhir == 'ok')
                                OK
                            @else
                                NG
                            @endif
                        </td>
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
                            @if ($workorderHasTpm->pre_straightening_putaran_roller_berputar == 'ok')
                                OK
                            @else
                                NG
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Kondisi Produk</td>
                        <td colspan="2">Tidak Keluar Jalur</td>
                        <td>
                            @if ($workorderHasTpm->pre_straightening_kondisi_produk_tidak_keluar_jalur == 'ok')
                                OK
                            @else
                                NG
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="4">Shot Blasting</td>
                        <td>Ampere Impeller 1</td>
                        <td colspan="2">30 - 40 A</td>
                        <td>{{$workorderHasTpm->ampere_impeller_1}}</td>
                    </tr>
                    <tr>
                        <td>Ampere Impeller 2</td>
                        <td colspan="2">30 - 40 A</td>
                        <td>{{$workorderHasTpm->ampere_impeller_2}}</td>
                    </tr>
                    <tr>
                        <td>Ampere Impeller 3</td>
                        <td colspan="2">30 - 40 A</td>
                        <td>{{$workorderHasTpm->ampere_impeller_3}}</td>
                    </tr>
                    <tr>
                        <td>Ampere Impeller 4</td>
                        <td colspan="2">30 - 40 A</td>
                        <td>{{$workorderHasTpm->ampere_impeller_4}}</td>
                    </tr>
                    <tr>
                        <td rowspan="3">Drawing</td>
                        <td>Speed Motor</td>
                        <td colspan="2">Mesin {{$workorder->machine?->name}}: 
                            @if ($workorder->machine->name == 'OB')
                                20-80 mpm
                            @elseif($workorder->machine->name == 'IB5')
                                20-80 mpm
                            @elseif($workorder->machine->name == 'S2B')
                                20-50 mpm
                            @elseif($workorder->machine->name == 'IB8')
                                20-50 mpm
                            @else
                                20-80 mpm
                            @endif
                        </td>
                        <td>{{$workorderHasTpm->speed_motor}}</td>
                    </tr>
                    <tr>
                        <td>Ukuran Slide</td>
                        <td colspan="2">
                            Mesin {{$workorder->machine?->name}}: <u>></u> 2mm dari diamter F/G
                        </td>
                        <td>{{$workorderHasTpm->ukuran_slide}}</td>
                    </tr>
                    <tr>
                        <td>Kondisi Pelumas</td>
                        <td colspan="2">Lancar</td>
                        <td>
                            @if ($workorderHasTpm->kondisi_pelumas == 'ok')
                                OK
                            @else
                                NG
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">Straightening</td>
                        <td>Putaran Roller</td>
                        <td colspan="2">Berputar</td>
                        <td>
                            @if ($workorderHasTpm->straightening_putaran_roller_berputar == 'ok')
                                OK
                            @else
                                NG
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Kondisi Produk</td>
                        <td colspan="2">Tidak Keluar Jalur</td>
                        <td>
                            @if ($workorderHasTpm->straightening_kondisi_produk_tidak_keluar_jalur == 'ok')
                                OK
                            @else
                                NG
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="{{$workorder->machine->name == 'IB8' ? '7' : '3'}}">Cutting</td>
                        <td>Panjang</td>
                        <td colspan="2">-0, +30mm</td>
                        <td>{{$workorderHasTpm->cutting_panjang}}</td>
                    </tr>
                    <tr>
                        <td>Ukuran Dies Cutting IN (OB,IB5,S2B,IB8)</td>
                        <td colspan="2">
                            Diameter Lubang Dies > 0.2mm - 1mm dari FG
                        </td>
                        <td>{{$workorderHasTpm->ukuran_dies_cutting_in}}</td>
                    </tr>
                    @if ($workorder->machine?->name != 'IB8')
                        <tr>
                            <td>Ukuran Dies Cutting OUT (OB, IB5, S2B)</td>
                            <td colspan="2">
                                Diameter lubang dies > 1mm - 2mm dari FG
                            </td>
                            <td>{{$workorderHasTpm->ukuran_dies_cutting_out}}</td>
                        </tr>
                    @else
                        <tr>
                            <td rowspan="5">Ukuran Dies Cutting OUT IB8</td>
                            <td>Size</td>
                            <td>No Cutter</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Dia. 10mm - Dia. 11mm</td>
                            <td>5</td>
                            <td>{{$workorderHasTpm->ukuran_dies_cutting_out_cutter_5}}</td>
                        </tr>
                        <tr>
                            <td>Dia. 11,1mm - Dia. 12mm</td>
                            <td>6</td>
                            <td>{{$workorderHasTpm->ukuran_dies_cutting_out_cutter_6}}</td>
                        </tr>
                        <tr>
                            <td>Dia. 12,1mm - Dia. 14mm</td>
                            <td>7</td>
                            <td>{{$workorderHasTpm->ukuran_dies_cutting_out_cutter_7}}</td>
                        </tr>
                        <tr>
                            <td>Dia. 14,1mm - Dia. 17mm</td>
                            <td>9</td>
                            <td>{{$workorderHasTpm->ukuran_dies_cutting_out_cutter_9}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td rowspan="6">Polishing</td>
                        <td>Ring pelurus, Plat cetakan, Roll penekanan</td>
                        <td colspan="2">Tidak cacat / Kotor</td>
                        <td>
                            @if ($workorderHasTpm->polishing_tidak_cacat == 'ok')
                                OK
                            @else
                                NG
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Plat kuningan / Nylon</td>
                        <td colspan="2">
                            Lebih kecil 2 - 4 mm dari Diameter produk
                        </td>
                        <td>{{$workorderHasTpm->polishing_ukuran_plat_kuningan}}</td>
                    </tr>
                    @if ($workorder->machine?->name == 'IB8')
                        <tr>
                            <td>Ampere Motor</td>
                            <td colspan="2">OB/ IB5/ IB8 <u><</u> 50A</td>
                            <td>{{$workorderHasTpm->polishing_ampere_motor}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Ampere Motor</td>
                            <td colspan="2">S2B <u><</u> 20A</td>
                            <td>{{$workorderHasTpm->polishing_ampere_motor_s2b}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td rowspan="2">Kondisi Pelumas</td>
                        <td colspan="2">Lancar</td>
                        <td>
                            @if ($workorderHasTpm->polishing_kondisi_pelumas_lancar == 'ok')
                                OK
                            @else
                                NG
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Penutup Oli Tertutup</td>
                        <td>
                            @if ($workorderHasTpm->polishing_penutup_oli_tertutup == 'ok')
                                OK
                            @else
                                NG
                            @endif
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
                        <td style="border: none; font-weight: bold; text-align: left; width: 40%;">
                            Hasil Setting:
                        </td>
                        <td style="border: none; text-align: left;">
                            @if ($workorderHasTpm->hasil_setting == 'ok')
                                <u>OK</u>
                            @else
                                <u>NG</u>
                            @endif
                        </td>
                    </tr>
                </thead>
            </table>
            <div style="display: flex; justify-content: space-between">
                <div style="width: 50%; border: 1px solid #000; height: 5rem">
                    <p style="margin: 0.1rem">Catatan:</p>
                    <p style="margin: 0.5rem">
                        {{$workorderHasTpm->catatan}}
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
