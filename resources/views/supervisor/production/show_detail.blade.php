@extends('templates.default')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                    {{-- Production Report Dashboard --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Performance Report</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="text-center">
                                                <strong>Speed Performance</strong>
                                            </p>
                                            <form method="POST" id="search-form" role="form">
                                                <div class="form-row" style="margin-left:20px;">
                                                    <div class="form-group" style="width:50%">
                                                        <div class="input-group">
                                                            <label style="padding-right: 10px;">Show :</label>
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="far fa-clock"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control float-right"
                                                                id="reservationtime" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button
                                                            style="margin-left: 10px; padding-left: 10px; padding-right: 10px"
                                                            type="submit" class="btn btn-primary">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="chart">
                                                <canvas id="speedChart" height="180"style="height: 180px;"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="text-center">
                                                <strong>Performance Indicator</strong>
                                            </p>
                                            <div class="progress-group">
                                                Performance
                                                <span class="float-right"
                                                    id="performance_id">{{ $indicator['performance'] }} %</span>
                                                <div class="progress progress-sm" id="performance_bar">
                                                    <div class="progress-bar bg-primary"
                                                        style="width: {{ $indicator['performance'] }}%"></div>
                                                </div>
                                            </div>
                                            <div class="progress-group">
                                                Availability
                                                <span class="float-right"
                                                    id="availability_id">{{ $indicator['availability'] }} %</span>
                                                <div class="progress progress-sm" id="availability_bar">
                                                    <div class="progress-bar bg-danger"
                                                        style="width: {{ $indicator['availability'] }}%"></div>
                                                </div>
                                            </div>
                                            <div class="progress-group">
                                                Quality
                                                <span class="float-right" id="quality_id">{{ $indicator['quality'] }}
                                                    %</span>
                                                <div class="progress progress-sm" id="quality_bar">
                                                    <div class="progress-bar bg-success"
                                                        style="width: {{ $indicator['quality'] }}%"></div>
                                                </div>
                                            </div>
                                            <div class="progress-group">
                                                Overall Equipment Effectiveness
                                                <span class="float-right" id="oee_id">{{ $indicator['oee'] }} %</span>
                                                <div class="progress progress-sm" id="oee_bar">
                                                    <div class="progress-bar bg-warning"
                                                        style="width: {{ $indicator['oee'] }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="text-center">
                                                <strong>Waste Downtime</strong>
                                            </p>
                                            <div class="chart">
                                                <canvas id="wasteDtChart"
                                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="text-center">
                                                <strong>Management Downtime</strong>
                                            </p>
                                            <div class="chart">
                                                <canvas id="managementDtChart"
                                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-9">
                                                    <input oninput="updateWasteDtMax(this)" type="range"
                                                        id="wasteDt-slider" min="" max="999000" value="5000"
                                                        style="width:100%">
                                                    <label for="">scale</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input onchange="updateWasteDtMax(this)" type="number"
                                                            id="wasteDt-input" class="form-control" value="5000">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-9">
                                                    <input oninput="updateManagementDtMax(this)" type="range"
                                                        id="managementDt-slider" min="" max="999000"
                                                        value="5000" style="width:100%">
                                                    <label for="">scale</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input onchange="updateManagementDtMax(this)" type="number"
                                                        id="managementDt-input" class="form-control" value="5000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class=" col-sm-4 col-4">
                                            <div class="description-block border-right">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <span class="description-text float-left">Workorder:
                                                            {{ $workorder->wo_number }}</span><br>
                                                        <span class="description-text float-left">Machine:
                                                            {{ $workorder->machine->name }}</span><br>
                                                        <span class="description-text float-left">Processed By:
                                                            {{ $user_involved['processed_by'] }}</span><br>
                                                        <span class="description-text float-left">Start:
                                                            {{ $workorder->process_start }}</span><br>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="description-text float-left">Status:
                                                            {{ $workorder->status_wo }}</span><br>
                                                        <span class="description-text float-left">Chamfer:
                                                            {{ $workorder->chamfer }}</span><br>
                                                        <span class="description-text float-left">Color:
                                                            {{ $color }}</span><br>
                                                        <span class="description-text float-left">End:
                                                            {{ $workorder->process_end }}</span><br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="description-text float-left">Remarks:
                                                            {{ $workorder->remarks }}</span><br>
                                                    </div>
                                                </div>
                                                <a href="#" id="workorder-details" class="descriprion-text">Detail
                                                    Workorder Data</a> |
                                                <a href="#" data-toggle="modal" data-target="#exampleModalCenter"
                                                    class="descriprion-text">Workorder
                                                    Change History</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-4">
                                            <div class="description-block border-right">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <span class="description-text text-sm">AVERAGE SPEED</span>
                                                        <h5 class="description-header">
                                                            {{ round($reports['average_speed'], 2) }} M/Min
                                                        </h5>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="description-text">TOTAL PRODUCTION</span>
                                                        <h5 class="description-header">{{ $reports['production_count'] }}
                                                        </h5>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="description-text">PLANNED PRODUCTION</span>
                                                        <h5 class="description-header">{{ $reports['production_plan'] }}
                                                            Pcs</h5>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <span class="description-text text-success">GOOD PRODUCT</span>
                                                        <h5 class="description-header">
                                                            {{ $reports['total_good_product'] }}</h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="description-text text-danger">BAD PRODUCT</span>
                                                        <h5 class="description-header">{{ $reports['total_bad_product'] }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-4">
                                            <div class="description-block">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <span class="description-text">PROCESS DURATION</span>
                                                        <h5 class="description-header">{{ $reports['planned_time'] }}</h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="description-text">TOTAL DOWNTIME</span>
                                                        <h5 class="description-header">{{ $reports['total_downtime'] }}
                                                        </h5>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <span class="description-text text-success">MANAGEMENT</span>
                                                        <h5 class="description-header">
                                                            {{ $reports['management_downtime'] }}</h5>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <span class="description-text text-danger">WASTE</span>
                                                        <h5 class="description-header">{{ $reports['waste_downtime'] }}
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <span class="description-text text-black">OFF</span>
                                                        <h5 class="description-header">
                                                            {{ $reports['off_production_time'] }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TPM REPORT --}}
                    <div class="col-12">
                        <div class="card card-primary card-outline {{$isTPMCompleted ? 'collapsed-card' : ''}}">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <span class="mr-2">TPM Form</span>
                                    @if ($isTPMCompleted)
                                        <span class="badge badge-success">Done</span>
                                        <a href="{{route('workorderHasTpm.printToPdf', $workorder)}}" style="text-decoration: none; margin-left: 1rem;">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    @endif
                                </h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-{{$isTPMCompleted ? 'plus' : 'minus'}}"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('workorderHasTpm.store', $workorder)}}" method="post" id="tpmForm">
                                    @csrf
                                    {{-- show error form --}}
                                    @if ($errors->any())
                                        <div class="col-12">
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <p class="mb-1">Mesin: {{ $workorder->machine->name }}</p>
                                            <p class="mb-1">Job order: {{ $workorder->wo_number }}</p>
                                            <p class="mb-1">Diameter: {{ $workorder->fg_size_1 }} MM</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-1">Grade: {{ $workorder->bb_grade }}</p>
                                            <p class="mb-1">Panjang: {{ $workorder->fg_size_2 }} MM</p>
                                            <p class="mb-1">Tanggal: {{ $workorder->process_start }}</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <span><strong>Note:</strong> Use "." as a comma character</span>
                                        </div>
                                    </div>
                                    <div class="row table-responsive">
                                        <div class="col-12">
                                            <table class="table table-hover table-sm table-bordered table-sm">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th rowspan="2" class="text-center align-middle">Proses</th>
                                                        <th rowspan="2" class="text-center align-middle">Kode dies</th>
                                                        <th rowspan="2" class="text-center align-middle">Diameter dies</th>
                                                        <th rowspan="2" class="text-center align-middle">Toleransi</th>
                                                        <th colspan="2" class="text-center">Diameter Aktual</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">Setelah Dies</th>
                                                        <th class="text-center">Setelah Polishing</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center align-middle">Awal</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="kode_dies_awal" value="{{old('kode_dies_awal') ?? $workorder->workorderHasTpm?->kode_dies_awal}}">
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="diameter_dies_awal" value="{{old('diameter_dies_awal') ?? $workorder->workorderHasTpm?->diameter_dies_awal}}">
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <span>Lihat tabel No:</span><br>
                                                            <span>STD.PP.25-MTD-001</span>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="diameter_aktual_setelah_dies_awal" value="{{old('diameter_aktual_setelah_dies_awal')??$workorder->workorderHasTpm?->diameter_aktual_setelah_dies_awal}}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="diameter_aktual_setelah_polishing_awal" value="{{old('diameter_aktual_setelah_polishing_awal')??$workorder->workorderHasTpm?->diameter_aktual_setelah_polishing_awal}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Akhir</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="kode_dies_akhir" value="{{old('kode_dies_akhir')??$workorder->workorderHasTpm?->kode_dies_akhir}}">
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="diameter_dies_akhir" value="{{old('diameter_dies_akhir')??$workorder->workorderHasTpm?->diameter_dies_akhir}}">
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <span>Lihat tabel No:</span><br>
                                                            <span>STD.PP.25-MTD-001</span>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="diameter_aktual_setelah_dies_akhir" value="{{old('diameter_aktual_setelah_dies_akhir')??$workorder->workorderHasTpm?->diameter_aktual_setelah_dies_akhir}}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="diameter_aktual_setelah_polishing_akhir" value="{{old('diameter_aktual_setelah_polishing_akhir')??$workorder->workorderHasTpm?->diameter_aktual_setelah_polishing_akhir}}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row table-responsive">
                                        <div class="col-6">
                                            <table class="table table-hover table-sm table-bordered table-sm">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th rowspan="2" class="text-center align-middle">Proses</th>
                                                        <th rowspan="2" class="text-center align-middle">Visual barang</th>
                                                        <th rowspan="2" class="text-center align-middle">Kelurusan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center align-middle">Awal</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="visual_barang_awal" value="{{old('visual_barang_awal') ?? $workorder->workorderHasTpm?->visual_barang_awal}}" placeholder="OK/NG">
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="kelurusan_awal" value="{{old('kelurusan_awal') ?? $workorder->workorderHasTpm?->kelurusan_awal}}" placeholder="OK/NG">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Akhir</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="visual_barang_akhir" value="{{old('visual_barang_akhir') ?? $workorder->workorderHasTpm?->visual_barang_akhir}}" placeholder="OK/NG">
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="kelurusan_akhir" value="{{old('kelurusan_akhir') ?? $workorder->workorderHasTpm?->kelurusan_akhir}}" placeholder="OK/NG">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row table-responsive">
                                        <div class="col-12">
                                            <table class="table table-hover table-sm table-bordered table-sm">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th rowspan="2" class="text-center align-middle">Unit</th>
                                                        <th rowspan="2" class="text-center align-middle">Parameter</th>
                                                        <th rowspan="2" colspan="2" class="text-center align-middle">Standar</th>
                                                        <th rowspan="2" class="text-center align-middle">Aktual</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center align-middle" rowspan="2">Pre Straightening</td>
                                                        <td class="text-center align-middle">Putaran Roller</td>
                                                        <td class="text-center align-middle" colspan="2">Berputar</td>
                                                        <td class="text-center align-middle">
                                                            <select name="pre_straightening_putaran_roller_berputar" id="" class="form-control">
                                                                <option value="">-- Select one --</option>
                                                                <option value="ok" @if (old('pre_straightening_putaran_roller_berputar') == 'ok' || $workorder->workorderHasTpm?->pre_straightening_putaran_roller_berputar == 'ok') selected @endif>OK</option>
                                                                <option value="ng" @if (old('pre_straightening_putaran_roller_berputar') == 'ng' || $workorder->workorderHasTpm?->pre_straightening_putaran_roller_berputar == 'ng') selected @endif>NG</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Kondisi Produk</td>
                                                        <td class="text-center align-middle" colspan="2">Tidak Keluar Jalur</td>
                                                        <td class="text-center align-middle">
                                                            <select name="pre_straightening_kondisi_produk_tidak_keluar_jalur" id="" class="form-control">
                                                                <option value="">-- Select one --</option>
                                                                <option value="ok" @if (old('pre_straightening_kondisi_produk_tidak_keluar_jalur') == 'ok' || $workorder->workorderHasTpm?->pre_straightening_kondisi_produk_tidak_keluar_jalur == 'ok') selected @endif>OK</option>
                                                                <option value="ng" @if (old('pre_straightening_kondisi_produk_tidak_keluar_jalur') == 'ng' || $workorder->workorderHasTpm?->pre_straightening_kondisi_produk_tidak_keluar_jalur == 'ng') selected @endif>NG</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle" rowspan="4">Shot Blasting</td>
                                                        <td class="text-center align-middle">Ampere Impeller 1</td>
                                                        <td class="text-center align-middle" colspan="2">30 - 40 A</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="ampere_impeller_1" value="{{old('ampere_impeller_1') ?? $workorder->workorderHasTpm?->ampere_impeller_1}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Ampere Impeller 2</td>
                                                        <td class="text-center align-middle" colspan="2">30 - 40 A</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="ampere_impeller_2"  value="{{old('ampere_impeller_2')??$workorder->workorderHasTpm?->ampere_impeller_2}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Ampere Impeller 3</td>
                                                        <td class="text-center align-middle" colspan="2">30 - 40 A</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="ampere_impeller_3"  value="{{old('ampere_impeller_3') ?? $workorder->workorderHasTpm?->ampere_impeller_3}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Ampere Impeller 4</td>
                                                        <td class="text-center align-middle" colspan="2">30 - 40 A</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="ampere_impeller_4"  value="{{old('ampere_impeller_4') ?? $workorder->workorderHasTpm?->ampere_impeller_4}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle" rowspan="3">Drawing</td>
                                                        <td class="text-center align-middle">Speed Motor</td>
                                                        <td class="text-center align-middle" colspan="2">{{ $workorder->machine->name }} : 
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
                                                            @endif</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="speed_motor" value="{{old('speed_motor') ?? $workorder->workorderHasTpm?->speed_motor}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Ukuran Slide</td>
                                                        <td class="text-center align-middle" colspan="2">{{ $workorder->machine->name }} : <u>></u> 2mm dari diameter F/G</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="ukuran_slide" value="{{old('ukuran_slide') ?? $workorder->workorderHasTpm?->ukuran_slide}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Kondisi Pelumas</td>
                                                        <td class="text-center align-middle" colspan="2">Lancar</td>
                                                        <td class="text-center align-middle">
                                                            <select name="kondisi_pelumas" id="" class="form-control">
                                                                <option value="">-- Select one --</option>
                                                                <option value="ok" @if (old('kondisi_pelumas') == 'ok' || $workorder->workorderHasTpm?->kondisi_pelumas == 'ok') selected @endif>OK</option>
                                                                <option value="ng" @if (old('kondisi_pelumas') == 'ng' || $workorder->workorderHasTpm?->kondisi_pelumas == 'ng') selected @endif>NG</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle" rowspan="2">Straightening</td>
                                                        <td class="text-center align-middle">Putaran Roller</td>
                                                        <td class="text-center align-middle" colspan="2">Berputar</td>
                                                        <td class="text-center align-middle">
                                                            <select name="straightening_putaran_roller_berputar" id="" class="form-control">
                                                                <option value="">-- Select one --</option>
                                                                <option value="ok" @if (old('straightening_putaran_roller_berputar') == 'ok' || $workorder->workorderHasTpm?->straightening_putaran_roller_berputar == 'ok') selected @endif>OK</option>
                                                                <option value="ng" @if (old('straightening_putaran_roller_berputar') == 'ng' || $workorder->workorderHasTpm?->straightening_putaran_roller_berputar == 'ng') selected @endif>NG</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Kondisi Produk</td>
                                                        <td class="text-center align-middle" colspan="2">Tidak Keluar Jalur</td>
                                                        <td class="text-center align-middle">
                                                            <select name="straightening_kondisi_produk_tidak_keluar_jalur" id="" class="form-control">
                                                                <option value="">-- Select one --</option>
                                                                <option value="ok" @if (old('straightening_kondisi_produk_tidak_keluar_jalur') == 'ok' || $workorder->workorderHasTpm?->straightening_kondisi_produk_tidak_keluar_jalur == 'ok') selected @endif>OK</option>
                                                                <option value="ng" @if (old('straightening_kondisi_produk_tidak_keluar_jalur') == 'ng' || $workorder->workorderHasTpm?->straightening_kondisi_produk_tidak_keluar_jalur == 'ng') selected @endif>NG</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle" rowspan="8">Cutting</td>
                                                        <td class="text-center align-middle">Panjang</td>
                                                        <td class="text-center align-middle" colspan="2">-0, +30mm</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="cutting_panjang" value="{{old('cutting_panjang') ?? $workorder->workorderHasTpm?->cutting_panjang}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Ukuran Dies Cutting IN (OB, IB5, S2B, IB8)</td>
                                                        <td class="text-center align-middle" colspan="2">Diameter lubang dies > 0.2mm - 1mm dari FG</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="ukuran_dies_cutting_in" value="{{old('ukuran_dies_cutting_in') ?? $workorder->workorderHasTpm?->ukuran_dies_cutting_in}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Ukuran Dies Cutting OUT (OB, IB5, S2B)</td>
                                                        <td class="text-center align-middle" colspan="2">Diameter lubang dies > 1mm - 2mm dari FG</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="ukuran_dies_cutting_out" value="{{old('ukuran_dies_cutting_out') ?? $workorder->workorderHasTpm?->ukuran_dies_cutting_out}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle" rowspan="5">Ukuran Dies Cutting OUT IB8</td>
                                                        <td class="text-center align-middle">Size</td>
                                                        <td class="text-center align-middle">NO Cutter</td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Dia. 10mm - Dia. 11mm</td>
                                                        <td class="text-center align-middle">5</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="ukuran_dies_cutting_out_cutter_5" value="{{old('ukuran_dies_cutting_out_cutter_5') ?? $workorder->workorderHasTpm?->ukuran_dies_cutting_out_cutter_5}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Dia. 11,1mm - Dia. 12mm</td>
                                                        <td class="text-center align-middle">6</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="ukuran_dies_cutting_out_cutter_6" value="{{old('ukuran_dies_cutting_out_cutter_6') ?? $workorder->workorderHasTpm?->ukuran_dies_cutting_out_cutter_6}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Dia. 12,1mm - Dia. 14mm</td>
                                                        <td class="text-center align-middle">7</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="ukuran_dies_cutting_out_cutter_7" value="{{old('ukuran_dies_cutting_out_cutter_7') ?? $workorder->workorderHasTpm?->ukuran_dies_cutting_out_cutter_7}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Dia. 14,1mm - Dia. 17mm</td>
                                                        <td class="text-center align-middle">9</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="ukuran_dies_cutting_out_cutter_9" value="{{old('ukuran_dies_cutting_out_cutter_9') ?? $workorder->workorderHasTpm?->ukuran_dies_cutting_out_cutter_9}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle" rowspan="6">Polishing</td>
                                                        <td class="text-center align-middle">Ring pelurus, Plakat cetakan, Roll penekan</td>
                                                        <td class="text-center align-middle" colspan="2">Tidak Cacat/Kotor</td>
                                                        <td class="text-center align-middle">
                                                            <select name="polishing_tidak_cacat" id="" class="form-control">
                                                                <option value="">-- Select one --</option>
                                                                <option value="ok" @if (old('polishing_tidak_cacat') == 'ok' || $workorder->workorderHasTpm?->polishing_tidak_cacat == 'ok') selected @endif>OK</option>
                                                                <option value="ng" @if (old('polishing_tidak_cacat') == 'ng' || $workorder->workorderHasTpm?->polishing_tidak_cacat == 'ng') selected @endif>NG</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle">Plat Kuningan/Nylon</td>
                                                        <td class="text-center align-middle" colspan="2">Lebih kecil 2 - 4 mm dari Diameter Produk</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="polishing_ukuran_plat_kuningan" value="{{old('polishing_ukuran_plat_kuningan') ?? $workorder->workorderHasTpm?->polishing_ukuran_plat_kuningan}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle" rowspan="1">Ampere Motor</td>
                                                        <td class="text-center align-middle" colspan="2">OB/ IB5/ IB8 <u><</u> 50A</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="polishing_ampere_motor" value="{{old('polishing_ampere_motor') ?? $workorder->workorderHasTpm?->polishing_ampere_motor}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle" rowspan="1">Ampere Motor</td>
                                                        <td class="text-center align-middle" colspan="2">S2B <u><</u> 20A</td>
                                                        <td class="text-center align-middle">
                                                            <input type="text" class="form-control" name="polishing_ampere_motor_s2b" value="{{old('polishing_ampere_motor_s2b') ?? $workorder->workorderHasTpm?->polishing_ampere_motor_s2b}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle" rowspan="2">Kondisi Pelumas</td>
                                                        <td class="text-center align-middle" colspan="2">Lancar</td>
                                                        <td class="text-center align-middle">
                                                            <select name="polishing_kondisi_pelumas_lancar" id="" class="form-control">
                                                                <option value="">-- Select one --</option>
                                                                <option value="ok" @if (old('polishing_kondisi_pelumas_lancar') == 'ok' || $workorder->workorderHasTpm?->polishing_kondisi_pelumas_lancar == 'ok') selected @endif>OK</option>
                                                                <option value="ng" @if (old('polishing_kondisi_pelumas_lancar') == 'ng' || $workorder->workorderHasTpm?->polishing_kondisi_pelumas_lancar == 'ng') selected @endif>NG</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center align-middle" colspan="2">Penutup oli tertutup</td>
                                                        <td class="text-center align-middle">
                                                            <select name="polishing_penutup_oli_tertutup" id="" class="form-control">
                                                                <option value="">-- Select one --</option>
                                                                <option value="ok" @if (old('polishing_penutup_oli_tertutup') == 'ok' || $workorder->workorderHasTpm?->polishing_penutup_oli_tertutup == 'ok') selected @endif>OK</option>
                                                                <option value="ng" @if (old('polishing_penutup_oli_tertutup') == 'ng' || $workorder->workorderHasTpm?->polishing_penutup_oli_tertutup == 'ng') selected @endif>NG</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-1">
                                            <p class="mb-1">Hasil Setting:</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" value="ok" type="radio" name="hasil_setting" id="hasilSettingOK" @if (old('hasil_setting') == 'ok' || $workorder->workorderHasTpm?->hasil_setting == 'ok') checked @endif>
                                                <label class="form-check-label" for="hasilSettingOK">
                                                    OK
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="ng" type="radio" name="hasil_setting" id="hasilSettingNG" @if (old('hasil_setting') == 'ng' || $workorder->workorderHasTpm?->hasil_setting == 'ng') checked @endif>
                                                <label class="form-check-label" for="hasilSettingNG">
                                                    NG
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <p class="ml-2 mb-1 my-auto">Quality Control PIC:</p>
                                        <div class="col-3">
                                            <input type="text" name="quality_control" class="form-control" value="{{old('quality_control') ?? $workorder->workorderHasTpm?->quality_control}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="mb-1">Catatan:</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <textarea name="catatan" id="" cols="50" rows="5" class="form-control">{{old('catatan') ?? $workorder->workorderHasTpm?->catatan}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-6"></div>
                                        <div class="col-6 row">
                                            <div class="col-3"></div>
                                            <div class="col-6">
                                                <p class="ml-2 mb-1 my-auto">Checked by:</p>
                                                <input type="text" name="checked_by" class="form-control" value="{{old('checked_by') ?? $workorder->workorderHasTpm?->checked_by}}">
                                            </div>
                                            <div class="col-3">
                                                <p class="ml-2 mb-1 my-auto">Created by:</p>
                                                {{ $workorder->workorderHasTpm?->createdBy->name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-8"></div>
                                        <div class="col-4">
                                            <button class="form-control btn btn-primary" id="tpm-form-button">Update Form</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Production Report Column --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Production Report
                                        @if ($workorder->bb_qty_bundle - count($productions) == 0)
                                            (<i class="fas fa-check text-success"></i>)
                                        @endif
                                    </h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                @if ($workorder->bb_qty_bundle - count($productions) == 0)
                                    <div class="card-body box-profile">
                                        <label for="">Report per Bundle</label>
                                        <ul class="nav nav-pills">
                                            @for ($i = 1; $i < $workorder->bb_qty_bundle + 1; $i++)
                                                <li class="nav-item">
                                                    <a class="btn btn-transparent smelting-number 
                                                        @foreach ($productions as $prod)
                                                            @if ($i != $prod->bundle_num)
                                                                @continue
                                                            @endif
                                                            @if ($prod->pcs_per_bundle == 0)
                                                                bg-secondary
                                                                @continue
                                                            @endif
                                                            @if ($prod->bundle_judgement === 'notgood')
                                                                bg-danger
                                                                @continue
                                                            @elseif($prod->bundle_judgement === 'waste' && $prod->pcs_per_bundle != 0)
                                                                bg-warning
                                                                @continue
                                                            @endif
                                                            bg-primary @endforeach
                                                        "
                                                        href="#" style="margin:1px;" id="{{ $i }}"
                                                        data-toggle="tab">{{ $i }}
                                                    </a>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                @else
                                    <div class="card-body box-profile">
                                        <label for="">Report per Bundle</label>
                                        <ul class="nav nav-pills">
                                            @for ($i = 1; $i < $workorder->bb_qty_bundle + 1; $i++)
                                                <li class="nav-item">
                                                    <a class="btn btn-transparent smelting-number 
                                                        @foreach ($productions as $prod)
                                                            @if ($i != $prod->bundle_num)
                                                                @continue
                                                            @endif
                                                            @if ($prod->pcs_per_bundle == 0)
                                                                bg-secondary
                                                                @continue
                                                            @endif
                                                            @if ($prod->bundle_judgement === 'notgood')
                                                                bg-danger
                                                                @continue
                                                            @elseif($prod->bundle_judgement === 'waste' && $prod->pcs_per_bundle != 0)
                                                                bg-warning
                                                                @continue
                                                            @endif
                                                            bg-primary @endforeach
                                                        "
                                                        href="#" style="margin:1px;" id="{{ $i }}"
                                                        data-toggle="tab">{{ $i }}
                                                    </a>
                                                </li>
                                            @endfor
                                        </ul>
                                        <div class="dropdown-divider"></div>
                                        <form id="production-report" action="" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Coil Number</label>
                                                <select name="coil-num"
                                                    class="form-control @error('coil-num') is-invalid @enderror">
                                                    <option value="">-- Select Coil Number --</option>
                                                    @foreach ($smeltings as $smelt)
                                                        <option value="{{ $smelt->id }}">Coil Num :
                                                            {{ $smelt->coil_num }} - No. Leburan :
                                                            {{ $smelt->smelting_num }} - Berat : {{ $smelt->weight }} Kg
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Bundle Number</label>
                                                <?php $skip = false; ?>
                                                <select name="bundle-num"
                                                    class="form-control @error('bundle-num') is-invalid @enderror">
                                                    @for ($i = 1; $i < $workorder->bb_qty_bundle + 1; $i++)
                                                        @foreach ($productions as $prod)
                                                            @if ($prod->bundle_num == $i)
                                                                <?php $skip = true; ?>
                                                                {{ $prod->bundle_num }}
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    @if ($skip == false)
                                                        <option value="{{ $i }}">{{ $i }}
                                                        </option>
                                                    @break
                                                @endif
                                                <?php $skip = false; ?>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="row">
                                        <input hidden name="workorder_id" type="text"
                                            class="form-control @error('workorder_id') is-invalid @enderror"
                                            placeholder="No. Leburan"
                                            value="{{ $workorder->id ?? old('workorder_id') }}">
                                        <div class="col-6">

                                            <div class="form-group">
                                                <label for="">Dies Number</label>
                                                <input type="text" name="dies-number"
                                                    class="form-control @error('dies-number') is-invalid @enderror"
                                                    placeholder="Dies Number" value="{{ old('dies-number') }}">
                                                @error('dies-number')
                                                    <span class="text-danger help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Diameter Ujung</label>
                                                <input type="text" name="diameter-ujung"
                                                    class="form-control @error('diameter-ujung') is-invalid @enderror"
                                                    placeholder="Diameter Ujung"
                                                    value="{{ old('diameter-ujung') }}">
                                                @error('diameter-ujung')
                                                    <span class="text-danger help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Diameter Tengah</label>
                                                <input type="text" name="diameter-tengah"
                                                    class="form-control @error('diameter-tengah') is-invalid @enderror"
                                                    placeholder="Diameter Tengah"
                                                    value="{{ old('diameter-tengah') }}">
                                                @error('diameter-tengah')
                                                    <span class="text-danger help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Diameter Ekor</label>
                                                <input type="text" name="diameter-ekor"
                                                    class="form-control @error('diameter-ekor') is-invalid @enderror"
                                                    placeholder="Diameter Ekor"
                                                    value="{{ old('diameter-ekor') }}">
                                                @error('diameter-ekor')
                                                    <span class="text-danger help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Kelurusan Aktual</label>
                                                <input type="text" name="kelurusan-aktual"
                                                    class="form-control @error('kelurusan-aktual') is-invalid @enderror"
                                                    placeholder="Kelurusan Aktual"
                                                    value="{{ old('kelurusan-aktual') }}">
                                                @error('kelurusan-aktual')
                                                    <span class="text-danger help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">Panjang Aktual</label>
                                                <input type="text" name="panjang-aktual"
                                                    class="form-control @error('panjang-aktual') is-invalid @enderror"
                                                    placeholder="Panjang Aktual"
                                                    value="{{ old('panjang-aktual') }}">
                                                @error('panjang-aktual')
                                                    <span class="text-danger help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Berat Finish Good</label>
                                                <input type="text" name="berat-fg"
                                                    class="form-control @error('berat-fg') is-invalid @enderror"
                                                    placeholder="Berat Finish Good"
                                                    value="{{ old('berat-fg') }}">
                                                @error('berat-fg')
                                                    <span class="text-danger help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Pcs per Bundle</label>
                                                <input type="text" name="pcs-per-bundle"
                                                    class="form-control @error('pcs-per-bundle') is-invalid @enderror"
                                                    placeholder="Pcs Per Bundle"
                                                    value="{{ old('pcs-per-bundle') }}">
                                                @error('pcs-per-bundle')
                                                    <span class="text-danger help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Bundle Judgement</label>
                                                <select name="bundle-judgement" id="judgement-select"
                                                    class="form-control @error('bundle-judgement') is-invalid @enderror">
                                                    <option value="">-- Select Judgement --</option>
                                                    <option value="good">Good</option>
                                                    <option value="notgood">Not Good</option>
                                                    <option value="waste">Waste</option>
                                                </select>
                                                @error('bundle-judgement')
                                                    <span class="text-danger help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Visual</label>
                                                <select name="visual" id="visual-options"
                                                    class="form-control @error('visual') is-invalid @enderror">
                                                    <option value="">-- Select Judgement --</option>
                                                </select>
                                                @error('visual')
                                                    <span class="text-danger help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <div class="row">
                                                    <button class="form-control btn btn-primary"
                                                        style="margin-left:200px;">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Downtime Report --}}
            <div class="row">
                <div class="col-12">
                    <div class="card direct-chat card-primary card-outline direct-chat-primary">
                        <div class="card-header">
                            <h3 class="card-title">Downtime Report
                                <?php $remarkEmpty = true; ?>
                                @foreach ($downtimes as $downtime)
                                    @if ($downtime->is_remark_filled == false)
                                        <?php $remarkEmpty = true; ?>
                                    @break;
                                @endif
                                <?php $remarkEmpty = false; ?>
                            @endforeach
                            @if (count($downtimes) == 0)
                                <?php $remarkEmpty = false; ?>
                            @endif
                            @if ($remarkEmpty == false)
                                (<i class="fas fa-check text-success"></i>)
                            @endif
                            <?php $remarkEmpty = true; ?>

                        </h3>
                        <div class="card-tools">
                            <span id="downtime-list-count" class="badge badge-danger"></span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="direct-chat-messages" style="height: 500px;">
                            <div class="direct-chat-msg">
                                <div class="col-12" id="downtime-list">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Approval Button --}}
        <?php $allProductionDataComplete = false; ?>
        <?php $allDowntimeDataComplete = false; ?>
        @if ($workorder->bb_qty_bundle - count($productions) == 0)
            <?php $allProductionDataComplete = true; ?>
        @endif
        <?php $checkRemarkEmpty = true; ?>
        @foreach ($downtimes as $downtime)
            @if ($downtime->is_remark_filled == false && $downtime->is_downtime_stopped == true)
                <?php $checkRemarkEmpty = true; ?>
            @break;
        @endif
        <?php $checkRemarkEmpty = false; ?>
    @endforeach
    @if (count($downtimes) == 0)
        <?php $allDowntimeDataComplete = true; ?>
    @endif
    @if ($checkRemarkEmpty == false)
        <?php $allDowntimeDataComplete = true; ?>
    @endif
    <?php $checkRemarkEmpty = true; ?>

    <?php $downtimeDataPending = false; ?>
    @foreach ($downtimes as $downtime)
        @if ($downtime->is_remark_filled == false && $downtime->is_downtime_stopped == false)
            <?php $downtimeDataPending = true; ?>
        @break;
    @endif
    <?php $downtimeDataPending = false; ?>
@endforeach

<form action="" method="POST" id="finishForm">
    <div class="row">
        <div class="col-4">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    Remarks
                </div>
                <div class="card-body">
                    <textarea name="production_remarks" id="production-remarks" cols="30" rows="10" class="form-control"
                        placeholder="Put any notes here">{{ $workorder->production_remarks }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-outline card-primary">
                <div class="card-header" id="div_str_finish">
                    Finish Workorder Button
                </div>
                <div class="card-body">
                    <div class="text-center">
                        @csrf
                        <input type="submit" value="Process" style="display:none">
                        @if ($allProductionDataComplete == false || $allDowntimeDataComplete == false)
                            <p class="text-danger">Please Finish All Report First</p>
                        @else
                            <a href="{{ url('/supervisor/production/' . $workorder->id . '/finish') }}"
                                class="btn btn-success finish-button">Close Workorder</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</div>

</div>
</div><!-- /.container-fluid -->

{{-- Change History Modal --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-hover table-responsive">
        <thead>
            <tr>
                <th scope="col">Change Data</th>
                <th scope="col">Changed By</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($changeRequests as $changeReq)
                <tr>
                    <td>{{ $changeReq->change_data }}</td>
                    <td>{{ $changeReq->changedBy->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</section>

<!-- /.content -->
@endsection

@push('scripts')
<script>
    // INITIALIZATION
    $(document).ready(function() {
        $('#reservationtime').daterangepicker({
            timePicker: true,
            defaultValue: null,
            timePickerIncrement: 30,
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            }
        })
        $('#reservationtime').val('')
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            updateSpeedChart();
        });

        updateDowntimeList();
        updateSpeedChart();
        updateDowntimeChart();
    });

    // FINISH CHECK BUTTON
    $('a.finish-button').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure want to finish this workorder?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, finish it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('finishForm').action = href;
                document.getElementById('finishForm').submit();
                // delete localStorage remark
                localStorage.removeItem('production-remarks');
            }
        })
    });

    // CHARTS
    var wasteChart = new Chart($('#wasteDtChart').get(0).getContext('2d'), {});
    var managementChart = new Chart($('#managementDtChart').get(0).getContext('2d'), {});

    function updateWasteDtMax(range) {
        $('#wasteDt-input').val(range.value);
        $('#wasteDt-slider').val(range.value);
        const num = range.value
        wasteChart.config.options.scales.yAxes[0].ticks.max = parseInt(num);
        wasteChart.update();
    }

    function updateManagementDtMax(range) {
        $('#managementDt-input').val(range.value);
        $('#managementDt-slider').val(range.value);
        const num = range.value
        managementChart.config.options.scales.yAxes[0].ticks.max = parseInt(num);
        managementChart.update();
    }

    function updateDowntimeChart() {
        //Waste Downtime
        $.ajax({
            url: '{{ route('downtime.getDowntimeWasteChart') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                workorder_id: '{{ $workorder->id }}',
                downtime_category: 'waste',
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                var labelList = [];
                response.data.forEach(element => {
                    if (!element.reason) {
                        return;
                    }
                    labelList.push(element.reason);
                });
                var uniqueLabelList = [];
                for (i = 0; i < labelList.length; i++) {
                    if (uniqueLabelList.indexOf(labelList[i]) === -1) {
                        uniqueLabelList.push(labelList[i]);
                    }
                }
                var dataList = [];
                response.data.forEach(element => {
                    if (!element.total_duration) {
                        return;
                    }
                    dataList.push(element.total_duration);
                });
                var uniqueDataList = [];
                for (i = 0; i < dataList.length; i++) {
                    if (uniqueDataList.indexOf(dataList[i]) === -1) {
                        uniqueDataList.push(dataList[i]);
                    }
                }

                // Bar chart Instance
                var areaChartData = {
                    labels: uniqueLabelList,
                    datasets: [{
                        label: 'Waste Downtime',
                        barThickness: 75,
                        backgroundColor: 'rgb(230, 0, 0)',
                        borderColor: 'rgb(230, 0, 0)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: uniqueDataList
                    }, ]
                }
                var areaChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                            },
                            ticks: {
                                beginAtZero: true, // minimum value will be 0.
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Minutes'
                            },
                            ticks: {
                                max: 5000,
                                min: 0,
                                stepSize: 0,
                                beginAtZero: true, // minimum value will be 0.
                            }
                        }]
                    }
                }
                var barChartCanvas = $('#wasteDtChart').get(0).getContext('2d');
                const config = {
                    type: 'bar',
                    data: $.extend(true, {}, areaChartData),
                    options: areaChartOptions
                }
                wasteChart = new Chart(barChartCanvas, config);
            },
        });

        //Management Downtime
        $.ajax({
            url: '{{ route('downtime.getDowntimeManagementChart') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                workorder_id: '{{ $workorder->id }}',
                downtime_category: 'management',
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                var labelList = [];
                response.data.forEach(element => {
                    if (!element.reason) {
                        return;
                    }
                    labelList.push(element.reason);
                });
                var uniqueLabelList = [];
                for (i = 0; i < labelList.length; i++) {
                    if (uniqueLabelList.indexOf(labelList[i]) === -1) {
                        uniqueLabelList.push(labelList[i]);
                    }
                }
                var dataList = [];
                response.data.forEach(element => {
                    if (!element.total_duration) {
                        return;
                    }
                    dataList.push(element.total_duration);
                });
                var uniqueDataList = [];
                for (i = 0; i < dataList.length; i++) {
                    if (uniqueDataList.indexOf(dataList[i]) === -1) {
                        uniqueDataList.push(dataList[i]);
                    }
                }
                var areaChartData = {
                    labels: uniqueLabelList,
                    datasets: [{
                        label: 'Management Downtime',
                        barThickness: 75,
                        backgroundColor: 'rgb(51, 153, 0)',
                        borderColor: 'rgb(51, 153, 0)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: uniqueDataList
                    }, ]
                }
                var areaChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                            },
                            ticks: {
                                beginAtZero: true, // minimum value will be 0.
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,
                            },
                            ticks: {
                                max: 5000,
                                min: 0,
                                stepSize: 0,
                                beginAtZero: true, // minimum value will be 0.
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Minutes'
                            },
                        }]
                    }
                }
                var barChartCanvas = $('#managementDtChart').get(0).getContext('2d')
                const config = {
                    type: 'bar',
                    data: $.extend(true, {}, areaChartData),
                    options: areaChartOptions
                }
                managementChart = new Chart(barChartCanvas, config)
            },
        });
    }

    function updateSpeedChart() {
        $.ajax({
            method: "POST",
            url: '{{ route('realtime.searchSpeedProduction') }}',
            data: {
                timeRange: $('#reservationtime').val(),
                workorder: '{{ $workorder->id }}',
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                var speedHistoryCanvas = $('#speedChart').get(0).getContext('2d');

                var speedHistoryData = {
                    labels: response['created_at'],
                    datasets: [{
                        label: 'Production Speed',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: response['speed']
                    }, ]
                }

                var speedHistoryOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false,
                            }
                        }]
                    }
                }

                // This will get the first returned node in the jQuery collection.
                new Chart(speedHistoryCanvas, {
                    type: 'line',
                    data: speedHistoryData,
                    options: speedHistoryOptions
                })
            },
        })

    }

    // DOWNTIME LOG FUNCTIONS
    function updateDowntimeList() {
        $.ajax({
            url: '{{ route('downtime.updateDowntime') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                workorder_id: '{{ $workorder->id }}',
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                $('#downtime-list-count').html(response.data.length);

                var data = response.data;
                var downtimeList = '';
                for (let index = 0; index < data.length; index++) {
                    var downtimeCategory = data[index].downtime_category;
                    var downtimeReason = data[index].downtime_reason;
                    var textColor = '';

                    if (downtimeCategory == 'waste') {
                        downtimeCategory = 'Waste Downtime';
                        textColor = 'text-danger';
                    } else if (downtimeCategory == 'management') {
                        downtimeCategory = 'Management Downtime';
                        textColor = 'text-white';
                    } else {
                        downtimeCategory = 'Off Production';
                        textColor = 'text-dark';
                    }

                    var downtimeNumber = data[index].downtime_number;
                    var logCard = `<div class="card card-warning collapsed-card">
                                            <div class="card-header">
                                                <h3 class="card-title">${data[index].start_time} - ${data[index].end_time}</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"data-card-widget="collapse">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">Downtime Category</label>
                                                        <select onchange="updateReason(${downtimeNumber})" name="dt-category-${downtimeNumber}" class="form-control">
                                                            <option value="" disabled>-- Select Downtime Category --</option>
                                                            <option value="management">Management Downtime</option>
                                                            <option value="waste">Waste Downtime</option>
                                                            <option value="off">Off Production</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Downtime Reason</label>
                                                        <select name="dt-reason-${downtimeNumber}" class="form-control">
                                                            <option value="" disabled>-- Select Reason --</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Remarks</label>
                                                        <textarea name="dt-remarks-${downtimeNumber}" class="form-control"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-1">
                                                                <button class="btn btn-primary" onclick="storeDowntimeReason(${downtimeNumber})">Apply</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;

                    if (data[index].end_time == null) {
                        logCard = `<div class="card card-danger collapsed-card">
                                        <div class="card-header">
                                            <h3 class="card-title">' + data[index].start_time + ' - Now</h3>
                                        </div>
                                    </div>`;
                    }
                    if (data[index].is_remark_filled == true) {
                        logCard = `<div class="card card-success collapsed-card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                            <b class="${textColor}">${downtimeCategory}</b> | ${data[index].start_time} - ${data[index].end_time} | ${data[index].duration} | ${data[index].downtime_reason} | ${data[index].remarks}</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool"data-card-widget="collapse">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="downtime-reason-${downtimeNumber}" reason="${downtimeReason}" downtimeCategory="${data[index].downtimeCategory}"></div>
                                        <div class="card-body">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="">Downtime Category</label>
                                                    <select onchange="updateReason(${downtimeNumber})" name="dt-category-${downtimeNumber}" class="form-control">
                                                        <option value="" disabled>-- Select Downtime Category --</option>
                                                        <option value="management" ${data[index].downtime_category === 'management' ? 'selected' : ''}>Management Downtime</option>
                                                        <option value="waste" ${data[index].downtime_category === 'waste' ? 'selected' : ''}>Waste Downtime</option>
                                                        <option value="off" ${data[index].downtime_category === 'off' ? 'selected' : ''}>Off Production</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Downtime Reason</label>
                                                    <select name="dt-reason-${downtimeNumber}" class="form-control">
                                                        <option value="" disabled selected>-- Select Reason --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Remarks</label>
                                                    <textarea name="dt-remarks-${downtimeNumber}" class="form-control">${data[index].remarks}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <button class="btn btn-primary" onclick="storeDowntimeReason(${downtimeNumber})">Apply</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                    }

                    downtimeList += logCard
                }
                $('#downtime-list').html(downtimeList);

                for (let index = 0; index < data.length; index++) {
                    var downtimeNumber = data[index].downtime_number;
                    updateReason(downtimeNumber);
                }
            },
        });
    }

    function storeDowntimeReason(downtime_number) {
        var downtimeCategory = $('select[name="dt-category-' + downtime_number + '"]').val();
        var downtimeReason = $('select[name="dt-reason-' + downtime_number + '"]').val();
        var downtimeRemarks = $('textarea[name="dt-remarks-' + downtime_number + '"]').val();
        $.ajax({
            url: '{{ route('downtimeRemark.submit') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                downtimeNumber: downtime_number,
                downtimeCategory: downtimeCategory,
                downtimeReason: downtimeReason,
                downtimeRemarks: downtimeRemarks,
            },
            success: function(response) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Success',
                    text: 'Data Updated Successfully',
                    showConfirmButton: false,
                    timer: 3000
                });
                location.reload();
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Data Uncomplete',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        })
    }

    function updateReason(downtime_number) {
        var downtimeCategory = $('[name="dt-category-' + downtime_number + '"]').val();
        let options = '';
        $.ajax({
            method: 'GET',
            url: '{{ route('downtimeReason.getReason') }}',
            data: {
                category: downtimeCategory,
            },
            error: function(xhr) {
                console.log(xhr);
            }
        }).done(function(response) {
            response.data.forEach(element => {
                options +=
                    `<option value="${element.name}" ${checkReason(element.name, downtime_number)}>${element.name}</option>`;
            });
            $("[name='dt-reason-" + downtime_number + "']").html(options);
        })
    }

    function checkReason(reason, downtimeNumber) {
        if (reason == $('#downtime-reason-' + downtimeNumber).attr('reason')) {
            return 'selected';
        }
        return '';
    }

    // PRODUCTION REPORT
    function storeData(data) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{{ route('production.store') }}',
            data: {
                workorder_id: data.workorder_id,
                coil_num: data.coil_num,
                bundle_num: data.bundle_num,
                dies_num: data.dies_num,
                diameter_ujung: data.diameter_ujung,
                diameter_tengah: data.diameter_tengah,
                diameter_ekor: data.diameter_ekor,
                kelurusan_aktual: data.kelurusan_aktual,
                panjang_aktual: data.panjang_aktual,
                berat_fg: data.berat_fg,
                pcs_per_bundle: data.pcs_per_bundle,
                bundle_judgement: data.bundle_judgement,
                visual: data.visual,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Production report data has been submitted',
                    showConfirmButton: false,
                    timer: 2000
                });
                location.reload();
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Something Went Wrong',
                    html: '<b class="text-danger">' + JSON.parse(response.responseText)
                        .message + '</b> <br><br> <B>detail</b>: ' + response
                        .responseText,
                    showConfirmButton: false,
                    timer: 10000
                });
            }
        });
    };
    $("[name='bundle-num']").on('change', function(event) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{{ route('production.getSmeltingNum') }}',
            data: {
                workorder_id: '{{ $workorder->id }}',
                bundle_num: $("[name='bundle-num']").val(),
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $("#smelting-num").html('No. Leburan: ' + response);
            }
        })
    });
    $('#production-report').on('submit', function(event) {
        event.preventDefault();
        var bundle_num = $("[name='bundle-num']").val();
        var coil_num = $("[name='coil-num']").val();
        var workorder_id = $("[name='workorder_id']").val();
        var dies_number = $("[name='dies-number']").val();
        var diameter_ujung = $("[name='diameter-ujung']").val();
        var diameter_tengah = $("[name='diameter-tengah']").val();
        var diameter_ekor = $("[name='diameter-ekor']").val();
        var kelurusan_aktual = $("[name='kelurusan-aktual']").val();
        var panjang_aktual = $("[name='panjang-aktual']").val();
        var berat_fg = $("[name='berat-fg']").val();
        var pcs_per_bundle = $("[name='pcs-per-bundle']").val();
        var bundle_judgement = $("[name='bundle-judgement']").val();
        var visual = $("[name='visual']").val();
        var data = {
            bundle_num: bundle_num,
            coil_num: coil_num,
            workorder_id: workorder_id,
            dies_num: dies_number,
            diameter_ujung: diameter_ujung,
            diameter_tengah: diameter_tengah,
            diameter_ekor: diameter_ekor,
            kelurusan_aktual: kelurusan_aktual,
            panjang_aktual: panjang_aktual,
            berat_fg: berat_fg,
            pcs_per_bundle: pcs_per_bundle,
            bundle_judgement: bundle_judgement,
            visual: visual
        };
        storeData(data);
    });
    $('a.smelting-number').on('click', function(event) {
        $.ajax({
            url: '{{ route('production.getProductionInfo') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                bundle_num: event.currentTarget.id,
                workorder_id: '{{ $workorder->id }}',
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                var bundle_judgement = 'Not Good';
                if (response['bundle_judgement'] == 'good') {
                    bundle_judgement = 'Good'
                } else if (response['bundle_judgement'] == 'waste') {
                    bundle_judgement = 'Waste'
                }
                var visual = 'Not Good';
                Swal.fire({
                    title: '<strong>Bundle No . ' + response['bundle_num'] + '</strong>',
                    html: '<div class="row">' +
                        '<div class="col-1">' +
                        '</div>' +
                        '<div class="col-5">' +
                        '<div class="description-block border-right">' +
                        '<span class="description-text float-left">Dies No. : ' + response[
                            'dies_num'] + '</span><br>' +
                        '<hr>' +
                        '<span class="description-text float-left">Coil No. : ' + response[
                            'coil_num'] + '</span><br>' +
                        '<span class="description-text float-left">Weight   : ' + response[
                            'coil_weight'] + ' Kg</span><br>' +
                        '<span class="description-text float-left">No. Leburan   : ' +
                        response['coil_smelting_num'] + '</span><br>' +
                        '<span class="description-text float-left">Area  : ' + response[
                            'coil_area'] + '</span><br>' +
                        '<hr>' +
                        '<span class="description-text float-left">Diameter Ujung: ' +
                        response['diameter_ujung'] + ' mm</span><br>' +
                        '<span class="description-text float-left">Diameter Tengah: ' +
                        response['diameter_tengah'] + ' mm</span><br>' +
                        '<span class="description-text float-left">Diameter Ekor: ' +
                        response['diameter_ekor'] + ' mm</span><br>' +
                        '<span class="description-text float-left">Kelurusan Aktual: ' +
                        response['kelurusan_aktual'] + '</span><br>' +
                        '<span class="description-text float-left">Panjang Aktual: ' +
                        response['panjang_aktual'] + ' mm</span><br>' +
                        '<hr>' +
                        '<span class="description-text float-left">Berat FG: ' + response[
                            'berat_fg'] + ' Kg</span><br>' +
                        '<span class="description-text float-left">QTY (Pcs): ' + response[
                            'pcs_per_bundle'] + ' Pcs</span><br>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-5">' +
                        '<div class="description-block">' +
                        '<span class="description-text float-left">Judgement: ' +
                        bundle_judgement + '</span><br>' +
                        '<span class="description-text float-left">Visual: ' + (response[
                            'visual'] ? response['visual'] : '-') + '</span><br>' +
                        '<hr>' +
                        '<span class="description-text float-left">Created By: ' + response[
                            'created_by'] + '</span><br>' +
                        '<span class="description-text float-left">Created At: ' + response[
                            'created_at'] + '</span><br>' +
                        '<span class="description-text float-left">Edited By: ' + response[
                            'edited_by'] + '</span><br>' +
                        '<span class="description-text float-left">Updated At: ' + response[
                            'updated_at'] + '</span><br>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-1">' +
                        '</div>' +
                        '</div>' +
                        '<div class="row" >' +
                        '<div class="col-sm-6">' +
                        '</div>' +
                        '<div class="col-sm-1">' +
                        '<a href="' + window.location.origin + '/supervisor/production/' +
                        response['id'] + '/edit" class="btn btn-primary">Edit</a>' +
                        '</div>' +
                        '<div class="col-sm-1">' +
                        '<form action="' + window.location.origin +
                        '/supervisor/production/' + response['id'] +
                        '/delete"  method="POST"> @csrf @method('DELETE') <input type="submit" class="btn btn-danger" value="Delete"></form>' +
                        '</div>' +
                        '<div class="col-sm-3">' +
                        '<a href="' + window.location.origin + '/report/' + response['id'] +
                        '/printToPdf" class="btn btn-success" target"_blank">Print</a>' +
                        '</div>' +
                        '<div class="col-sm-1">' +
                        '</div>' +
                        '</div>',
                    padding: '10px',
                    width: '1000px',
                    showCloseButton: false,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: 'OK',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                });
            },
        });
    });
    $('#judgement-select').on('change', function(event) {
        if ($('#judgement-select').val() == 'notgood') {
            // console.log('bad selected');
            $('#visual-options').html(
                `<option disabled selected value="">-- Select Judgement --</option>
                <option value="PO">PO</option>
                <option value="OT">OT</option>
                <option value="IL">IL</option>
                <option value="OS">OS</option>
                <option value="LS">LS</option>
                <option value="OVAL">OVAL</option>
                <option value="TS">TS</option>
                <option value="BM">BM</option>
                <option value="CM">CM</option>
                <option value="SP">SP</option>
                <option value="MH">MH</option>
                <option value="RUSTY">RUSTY</option>
                <option value="PIN HOLE">PIN HOLE</option>
                <option value="LS Material">LS Material</option>`
            );
        }

        if ($('#judgement-select').val() == 'good') {
            // console.log('Good selected');
            $('#visual-options').html(
                `<option disabled selected value="">-- Select Judgement --</option>
                <option value="OK">OK</option>
                <option value="SP/OK">SP/OK</option>
                <option value="BM/OK">BM/OK</option>
                <option value="OT (Besar)/OK">OT (Besar)/OK</option>
                <option value="OT (Kecil)/OK">OT (Kecil)/OK</option>
                <option value="IL/OK">IL/OK</option>
                <option value="TS/OK">TS/OK</option>
                <option value="LS/OK">LS/OK</option>
                <option value="OVAL/OK">OVAL/OK</option>
                <option value="LS Material/OK">LS Material/OK</option>`
            );
        }
        if ($('#judgement-select').val() == 'waste') {
            // console.log('Good selected');
            $('#visual-options').html(
                '<option disabled selected value="">-- Select Judgement --</option>'
            );
        }
    })

    // WORKORDER DETAILS
    $('#workorder-details').on('click', function() {
        Swal.fire({
            title: '<strong>Machine {{ $workorder->machine->name }} - {{ $workorder->wo_number }} ({{ $workorder->status_wo }})</strong>',
            html: '<div class="row">' +
                '<div class="col-1">' +
                '</div>' +
                '<div class="col-5">' +
                '<div class="description-block border-right">' +
                '<span class="description-text float-left">Created By: {{ $user_involved['created_by'] }}</span><br>' +
                '<span class="description-text float-left">Created at: {{ $workorder->created_at }}</span><br>' +
                '<span class="description-text float-left">Edited By: {{ $user_involved['edited_by'] }}</span><br>' +
                '<span class="description-text float-left">Updated at: @if ($user_involved['edited_by'] == '') {{ '' }} @else {{ $workorder->updated_at }} @endif</span><br>' +
                '<hr>' +
                '<span class="description-text float-left">Processed By: {{ $user_involved['processed_by'] }}</span><br>' +
                '<span class="description-text float-left">Start: {{ $workorder->process_start }}</span><br>' +
                '<span class="description-text float-left">End: {{ $workorder->process_end }}</span><br>' +
                '<hr>' +
                '<span class="description-text float-left">Supplier: {{ $workorder->bb_supplier }}</span><br>' +
                '<span class="description-text float-left">Grade: {{ $workorder->bb_grade }}</span><br>' +
                '<span class="description-text float-left">Diameter: {{ $workorder->bb_diameter }} mm</span><br>' +
                '<span class="description-text float-left">Qty (Kg): {{ $workorder->bb_qty_pcs }} Kg</span><br>' +
                '<span class="description-text float-left">Qty (Coil): {{ $workorder->bb_qty_coil }} Coil</span><br>' +
                '<span class="description-text float-left">Qty (Bundle): {{ $workorder->bb_qty_bundle }} Bundle</span><br>' +
                '</div>' +
                '</div>' +
                '<div class="col-5">' +
                '<div class="description-block">' +
                '<span class="description-text float-left">Customer: {{ $workorder->fg_customer }}</span><br>' +
                '<span class="description-text float-left">Straightness Standard: {{ $workorder->straightness_standard }}</span><br>' +
                '<span class="description-text float-left">Size: {{ $workorder->fg_size_1 }} mm x {{ $workorder->fg_size_2 }} mm</span><br>' +
                '<span class="description-text float-left">Tolerance: {{ (substr($workorder->tolerance_plus, 0, 1) !== '-' ? '+' : '') . $workorder->tolerance_plus }} mm, {{ $workorder->tolerance_minus }} mm</span><br>' +
                '<span class="description-text float-left">Reduction rate: {{ $workorder->fg_reduction_rate }} %</span><br>' +
                '<span class="description-text float-left">Shape: {{ $workorder->fg_shape }}</span><br>' +
                '<span class="description-text float-left">QTY per Bundle (Kg): {{ $workorder->fg_qty_kg }} Kg</span><br>' +
                '<span class="description-text float-left">QTY per Bundle (Pcs): {{ $workorder->fg_qty_pcs }} Pcs</span><br>' +
                '<span class="description-text float-left">Chamfer: {{ $workorder->chamfer }}</span><br>' +
                '<span class="description-text float-left">Color: {{ $color }}</span><br>' +
                '<hr>' +
                '<span class="description-text float-left">Remarks: {{ $workorder->remarks }}</span><br>' +
                '</div>' +
                '</div>' +
                '<div class="col-1">' +
                '</div>' +
                '</div>' +
                '<div class="row" >' +
                '<div class="col-sm-8">' +
                '</div>' +
                '<div class="col-sm-3">' +
                '<a href="' + window.location.origin +
                '/workorder/{{ $workorder->id }}/export" class="btn btn-success" target"_blank">Export to Excel</a>' +
                '</div>' +
                '<div class="col-sm-1">' +
                '</div>' +
                '</div>',
            width: '1200px',
            showCloseButton: false,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonText: 'Close',
            confirmButtonAriaLabel: 'Thumbs up, great!',
        });
    });
    $('#print-label').on('click', function() {
        event.preventDefault();
        window.open("{{ url('/report/' . $workorder->id . '/printToPdf') }}");
    });

    //PRODUCTION REMARKS
    $('#production-remarks').on('change', function() {
        //save to application storage
        localStorage.setItem('production-remarks', $(this).val());
        console.log(localStorage.getItem('production-remarks'));
    })
</script>
@endpush
