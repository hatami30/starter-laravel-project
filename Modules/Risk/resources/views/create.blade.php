@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Risiko Baru</h3>
                        <p class="text-subtitle text-muted">Buat entri risiko baru.</p>
                    </div>
                </div>
            </div>
        </div>

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{{ route('risks.store') }}" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Reporter Details -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="reporters_name">Nama Pelapor</label>
                                        <input type="text"
                                            class="form-control @error('reporters_name') is-invalid @enderror"
                                            id="reporters_name" name="reporters_name" placeholder="Masukkan nama pelapor"
                                            value="{{ old('reporters_name') }}">
                                        @error('reporters_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="reporters_position">Jabatan Pelapor</label>
                                        <input type="text"
                                            class="form-control @error('reporters_position') is-invalid @enderror"
                                            id="reporters_position" name="reporters_position"
                                            placeholder="Masukkan jabatan pelapor" value="{{ old('reporters_position') }}">
                                        @error('reporters_position')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="contact_no">Nomor Kontak</label>
                                        <input type="text" class="form-control @error('contact_no') is-invalid @enderror"
                                            id="contact_no" name="contact_no" placeholder="Masukkan nomor kontak"
                                            value="{{ old('contact_no') }}">
                                        @error('contact_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Risk Details -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="risk_name">Nama Risiko</label>
                                        <input type="text" class="form-control @error('risk_name') is-invalid @enderror"
                                            id="risk_name" name="risk_name" placeholder="Masukkan nama risiko"
                                            value="{{ old('risk_name') }}">
                                        @error('risk_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="risk_description">Deskripsi Risiko</label>
                                        <textarea class="form-control @error('risk_description') is-invalid @enderror" id="risk_description"
                                            name="risk_description" placeholder="Masukkan deskripsi risiko">{{ old('risk_description') }}</textarea>
                                        @error('risk_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Status Fields -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="risk_status">Status Risiko</label>
                                        <select class="form-select @error('risk_status') is-invalid @enderror"
                                            id="risk_status" name="risk_status">
                                            <option value="" selected disabled>Pilih status risiko...</option>
                                            <option value="Provisional"
                                                {{ old('risk_status') == 'Provisional' ? 'selected' : '' }}>
                                                Sementara</option>
                                            <option value="Open" {{ old('risk_status') == 'Open' ? 'selected' : '' }}>
                                                Terbuka</option>
                                            <option value="Closed" {{ old('risk_status') == 'Closed' ? 'selected' : '' }}>
                                                Tertutup</option>
                                            <option value="Re-Opened"
                                                {{ old('risk_status') == 'Re-Opened' ? 'selected' : '' }}>
                                                Dibuka Kembali</option>
                                        </select>
                                        @error('risk_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="date_opened">Tanggal Dibuka</label>
                                        <input type="date"
                                            class="form-control @error('date_opened') is-invalid @enderror" id="date_opened"
                                            name="date_opened" value="{{ old('date_opened') }}">
                                        @error('date_opened')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="next_review_date">Tanggal Peninjauan
                                            Berikutnya</label>
                                        <input type="date"
                                            class="form-control @error('next_review_date') is-invalid @enderror"
                                            id="next_review_date" name="next_review_date"
                                            value="{{ old('next_review_date') }}">
                                        @error('next_review_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Reminder Period -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="reminder_period">Periode Pengingat</label>
                                        <select class="form-select @error('reminder_period') is-invalid @enderror"
                                            id="reminder_period" name="reminder_period">
                                            <option value="" selected disabled>Pilih periode pengingat...</option>
                                            <option value="Do Not Send Reminder"
                                                {{ old('reminder_period') == 'Do Not Send Reminder' ? 'selected' : '' }}>
                                                Jangan Kirim Pengingat</option>
                                            <option value="On The Due Date"
                                                {{ old('reminder_period') == 'On The Due Date' ? 'selected' : '' }}>
                                                Pada Tanggal Jatuh Tempo</option>
                                            <option value="1 day before the Due Date"
                                                {{ old('reminder_period') == '1 day before the Due Date' ? 'selected' : '' }}>
                                                1 hari sebelum Jatuh Tempo</option>
                                            <option value="2 days before the Due Date"
                                                {{ old('reminder_period') == '2 days before the Due Date' ? 'selected' : '' }}>
                                                2 hari sebelum Jatuh Tempo</option>
                                            <option value="3 days before the Due Date"
                                                {{ old('reminder_period') == '3 days before the Due Date' ? 'selected' : '' }}>
                                                3 hari sebelum Jatuh Tempo</option>
                                            <option value="4 days before the Due Date"
                                                {{ old('reminder_period') == '4 days before the Due Date' ? 'selected' : '' }}>
                                                4 hari sebelum Jatuh Tempo</option>
                                            <option value="5 days before the Due Date"
                                                {{ old('reminder_period') == '5 days before the Due Date' ? 'selected' : '' }}>
                                                5 hari sebelum Jatuh Tempo</option>
                                            <option value="6 days before the Due Date"
                                                {{ old('reminder_period') == '6 days before the Due Date' ? 'selected' : '' }}>
                                                6 hari sebelum Jatuh Tempo</option>
                                            <option value="1 week before the Due Date"
                                                {{ old('reminder_period') == '1 week before the Due Date' ? 'selected' : '' }}>
                                                1 minggu sebelum Jatuh Tempo</option>
                                            <option value="2 weeks before the Due Date"
                                                {{ old('reminder_period') == '2 weeks before the Due Date' ? 'selected' : '' }}>
                                                2 minggu sebelum Jatuh Tempo</option>
                                            <option value="1 Month (30 Days) before the Due Date"
                                                {{ old('reminder_period') == '1 Month (30 Days) before the Due Date' ? 'selected' : '' }}>
                                                1 Bulan (30 Hari) sebelum Jatuh Tempo</option>
                                            <option value="2 Months (60 Days) before the Due Date"
                                                {{ old('reminder_period') == '2 Months (60 Days) before the Due Date' ? 'selected' : '' }}>
                                                2 Bulan (60 Hari) sebelum Jatuh Tempo</option>
                                            <option value="3 Months (90 Days) before the Due Date"
                                                {{ old('reminder_period') == '3 Months (90 Days) before the Due Date' ? 'selected' : '' }}>
                                                3 Bulan (90 Hari) sebelum Jatuh Tempo</option>
                                            <option value="6 Months (180 Days) before the Due Date"
                                                {{ old('reminder_period') == '6 Months (180 Days) before the Due Date' ? 'selected' : '' }}>
                                                6 Bulan (180 Hari) sebelum Jatuh Tempo</option>
                                            <option value="1 Year (365 Days) before the Due Date"
                                                {{ old('reminder_period') == '1 Year (365 Days) before the Due Date' ? 'selected' : '' }}>
                                                1 Tahun (365 Hari) sebelum Jatuh Tempo</option>
                                        </select>
                                        @error('reminder_period')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Reminder Date -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="reminder_date">Tanggal Pengingat</label>
                                        <input type="date"
                                            class="form-control @error('reminder_date') is-invalid @enderror"
                                            id="reminder_date" name="reminder_date" value="{{ old('reminder_date') }}">
                                        @error('reminder_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="type_of_risk">Jenis Risiko</label>
                                        <select class="form-select @error('type_of_risk') is-invalid @enderror"
                                            id="type_of_risk" name="type_of_risk">
                                            <option value="" selected disabled>Pilih jenis risiko...</option>
                                            <option value="Corporate Risk"
                                                {{ old('type_of_risk') == 'Corporate Risk' ? 'selected' : '' }}>
                                                Risiko Korporat</option>
                                            <option value="Hospital Risk"
                                                {{ old('type_of_risk') == 'Hospital Risk' ? 'selected' : '' }}>
                                                Risiko Rumah Sakit</option>
                                            <option value="Project Risk"
                                                {{ old('type_of_risk') == 'Project Risk' ? 'selected' : '' }}>
                                                Risiko Proyek</option>
                                            <option value="Emerging Risk"
                                                {{ old('type_of_risk') == 'Emerging Risk' ? 'selected' : '' }}>
                                                Risiko yang Muncul</option>
                                        </select>
                                        @error('type_of_risk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="category">Kategori</label>
                                        <select class="form-select @error('category') is-invalid @enderror"
                                            id="category" name="category">
                                            <option value="" selected disabled>Pilih kategori...</option>
                                            <option value="Business Process and System"
                                                {{ old('category') == 'Business Process and System' ? 'selected' : '' }}>
                                                Proses Bisnis dan Sistem</option>
                                            <option value="Consumer Quality and Safety and Environment"
                                                {{ old('category') == 'Consumer Quality and Safety and Environment' ? 'selected' : '' }}>
                                                Kualitas Konsumen dan Keselamatan dan Lingkungan</option>
                                            <option value="Health and Safety"
                                                {{ old('category') == 'Health and Safety' ? 'selected' : '' }}>
                                                Kesehatan dan Keselamatan</option>
                                            <option value="Reputation and Mission"
                                                {{ old('category') == 'Reputation and Mission' ? 'selected' : '' }}>
                                                Reputasi dan Misi</option>
                                            <option value="Service Delivery"
                                                {{ old('category') == 'Service Delivery' ? 'selected' : '' }}>
                                                Pelayanan</option>
                                        </select>
                                        @error('category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="location">Lokasi</label>
                                        <input type="text"
                                            class="form-control @error('location') is-invalid @enderror" id="location"
                                            name="location" placeholder="Masukkan lokasi" value="{{ old('location') }}">
                                        @error('location')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="unit">Unit</label>
                                        <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                            id="unit" name="unit" placeholder="Masukkan unit"
                                            value="{{ old('unit') }}">
                                        @error('unit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="relevant_committee">Komite Terkait</label>
                                        <select class="form-select @error('relevant_committee') is-invalid @enderror"
                                            id="relevant_committee" name="relevant_committee">
                                            <option value="" selected disabled>Pilih komite terkait...</option>
                                            <option value="Antimicroba Resistency Control"
                                                {{ old('relevant_committee') == 'Antimicroba Resistency Control' ? 'selected' : '' }}>
                                                Kontrol Resistensi Antimikroba</option>
                                            <option value="Ethics"
                                                {{ old('relevant_committee') == 'Ethics' ? 'selected' : '' }}>Etika
                                            </option>
                                            <option value="Health Promotion"
                                                {{ old('relevant_committee') == 'Health Promotion' ? 'selected' : '' }}>
                                                Promosi Kesehatan</option>
                                            <option value="Infection Control"
                                                {{ old('relevant_committee') == 'Infection Control' ? 'selected' : '' }}>
                                                Kontrol Infeksi</option>
                                            <option value="MDGs"
                                                {{ old('relevant_committee') == 'MDGs' ? 'selected' : '' }}>MDGs</option>
                                            <option value="Medical"
                                                {{ old('relevant_committee') == 'Medical' ? 'selected' : '' }}>Medis
                                            </option>
                                            <option value="Medical Record"
                                                {{ old('relevant_committee') == 'Medical Record' ? 'selected' : '' }}>
                                                Rekam Medis</option>
                                            <option value="Medical Record Extermination"
                                                {{ old('relevant_committee') == 'Medical Record Extermination' ? 'selected' : '' }}>
                                                Pemusnahan Rekam Medis</option>
                                            <option value="Medical - Ethico Legal"
                                                {{ old('relevant_committee') == 'Medical - Ethico Legal' ? 'selected' : '' }}>
                                                Medis - Etika Legal</option>
                                            <option value="Nursing"
                                                {{ old('relevant_committee') == 'Nursing' ? 'selected' : '' }}>Keperawatan
                                            </option>
                                            <option value="Occupational Health and Safety"
                                                {{ old('relevant_committee') == 'Occupational Health and Safety' ? 'selected' : '' }}>
                                                Kesehatan dan Keselamatan Kerja</option>
                                            <option value="Pain Management"
                                                {{ old('relevant_committee') == 'Pain Management' ? 'selected' : '' }}>
                                                Manajemen Nyeri
                                            </option>
                                            <option value="Patient Safety"
                                                {{ old('relevant_committee') == 'Patient Safety' ? 'selected' : '' }}>
                                                Keselamatan Pasien</option>
                                            <option value="Pharmacy and Therapatical"
                                                {{ old('relevant_committee') == 'Pharmacy and Therapatical' ? 'selected' : '' }}>
                                                Farmasi dan Terapi</option>
                                            <option value="PONEK"
                                                {{ old('relevant_committee') == 'PONEK' ? 'selected' : '' }}>PONEK</option>
                                            <option value="Quality"
                                                {{ old('relevant_committee') == 'Quality' ? 'selected' : '' }}>Mutu
                                            </option>
                                            <option value="Quality and Patient Safety"
                                                {{ old('relevant_committee') == 'Quality and Patient Safety' ? 'selected' : '' }}>
                                                Mutu dan Keselamatan Pasien</option>
                                            <option value="TB Dots"
                                                {{ old('relevant_committee') == 'TB Dots' ? 'selected' : '' }}>TB Dots
                                            </option>
                                            <option value="Nil"
                                                {{ old('relevant_committee') == 'Nil' ? 'selected' : '' }}>Tidak Ada
                                            </option>
                                        </select>
                                        @error('relevant_committee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="accountable_manager">Manajer Penanggung
                                            Jawab</label>
                                        <input type="text"
                                            class="form-control @error('accountable_manager') is-invalid @enderror"
                                            id="accountable_manager" name="accountable_manager"
                                            placeholder="Masukkan manajer penanggung jawab"
                                            value="{{ old('accountable_manager') }}">
                                        @error('accountable_manager')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="responsible_supervisor">Supervisor
                                            Penanggung Jawab</label>
                                        <input type="text"
                                            class="form-control @error('responsible_supervisor') is-invalid @enderror"
                                            id="responsible_supervisor" name="responsible_supervisor"
                                            placeholder="Masukkan supervisor penanggung jawab"
                                            value="{{ old('responsible_supervisor') }}">
                                        @error('responsible_supervisor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="notify_of_associated_incidents">Beritahukan Insiden
                                            Terkait</label>
                                        <select
                                            class="form-select @error('notify_of_associated_incidents') is-invalid @enderror"
                                            id="notify_of_associated_incidents" name="notify_of_associated_incidents">
                                            <option value="" selected disabled>Pilih insiden terkait...</option>
                                            <option value="Yes"
                                                {{ old('notify_of_associated_incidents') == 'Yes' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="No"
                                                {{ old('notify_of_associated_incidents') == 'No' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                        @error('notify_of_associated_incidents')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="causes">Penyebab</label>
                                        <textarea class="form-control @error('causes') is-invalid @enderror" id="causes" name="causes"
                                            placeholder="Masukkan penyebab risiko">{{ old('causes') }}</textarea>
                                        @error('causes')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="consequences">Konsekuensi</label>
                                        <textarea class="form-control @error('consequences') is-invalid @enderror" id="consequences" name="consequences"
                                            placeholder="Masukkan konsekuensi risiko">{{ old('consequences') }}</textarea>
                                        @error('consequences')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="controls">Kontrol</label>
                                        <textarea class="form-control @error('controls') is-invalid @enderror" id="controls" name="controls"
                                            placeholder="Masukkan kontrol risiko">{{ old('controls') }}</textarea>
                                        @error('controls')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="control">Tingkat Kontrol</label>
                                        <select class="form-select @error('control') is-invalid @enderror" id="control"
                                            name="control">
                                            <option value="" selected disabled>Pilih tingkat kontrol...</option>
                                            <option value="Minimal" {{ old('control') == 'Minimal' ? 'selected' : '' }}>
                                                Minimal</option>
                                            <option value="Minor" {{ old('control') == 'Minor' ? 'selected' : '' }}>Minor
                                            </option>
                                            <option value="Moderate" {{ old('control') == 'Moderate' ? 'selected' : '' }}>
                                                Moderat</option>
                                            <option value="Major" {{ old('control') == 'Major' ? 'selected' : '' }}>Mayor
                                            </option>
                                            <option value="Serious" {{ old('control') == 'Serious' ? 'selected' : '' }}>
                                                Serius</option>
                                        </select>
                                        @error('control')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="control_hierarchy">Hierarki Kontrol</label>
                                        <select class="form-select @error('control_hierarchy') is-invalid @enderror"
                                            id="control_hierarchy" name="control_hierarchy">
                                            <option value="" selected disabled>Pilih hierarki kontrol...</option>
                                            <option value="Risk Avoidance"
                                                {{ old('control_hierarchy') == 'Risk Avoidance' ? 'selected' : '' }}>
                                                Penghindaran Risiko</option>
                                            <option value="Risk Acceptance"
                                                {{ old('control_hierarchy') == 'Risk Acceptance' ? 'selected' : '' }}>
                                                Penerimaan Risiko</option>
                                            <option value="Reduction of Likelihood of Occurrence"
                                                {{ old('control_hierarchy') == 'Reduction of Likelihood of Occurrence' ? 'selected' : '' }}>
                                                Pengurangan Kemungkinan Kejadian</option>
                                            <option value="Reduction of Consequence"
                                                {{ old('control_hierarchy') == 'Reduction of Consequence' ? 'selected' : '' }}>
                                                Pengurangan Konsekuensi</option>
                                            <option value="Transference of Risks"
                                                {{ old('control_hierarchy') == 'Transference of Risks' ? 'selected' : '' }}>
                                                Pengalihan Risiko</option>
                                            <option value="Elimination"
                                                {{ old('control_hierarchy') == 'Elimination' ? 'selected' : '' }}>
                                                Eliminasi</option>
                                            <option value="Substitution"
                                                {{ old('control_hierarchy') == 'Substitution' ? 'selected' : '' }}>
                                                Substitusi</option>
                                            <option value="Isolation"
                                                {{ old('control_hierarchy') == 'Isolation' ? 'selected' : '' }}>
                                                Isolasi</option>
                                            <option value="Engineering"
                                                {{ old('control_hierarchy') == 'Engineering' ? 'selected' : '' }}>
                                                Rekayasa</option>
                                            <option value="Administrative"
                                                {{ old('control_hierarchy') == 'Administrative' ? 'selected' : '' }}>
                                                Administratif</option>
                                            <option value="Personal Protective Equipment"
                                                {{ old('control_hierarchy') == 'Personal Protective Equipment' ? 'selected' : '' }}>
                                                Alat Pelindung Diri</option>
                                        </select>
                                        @error('control_hierarchy')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>



                                    <div class="form-group mb-3">
                                        <label class="form-label" for="control_cost">Biaya Kontrol</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text"
                                                class="form-control @error('control_cost') is-invalid @enderror"
                                                id="control_cost" name="control_cost" value="{{ old('control_cost') }}"
                                                placeholder="0">
                                            @error('control_cost')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="effective_date">Tanggal Efektif</label>
                                        <input type="date"
                                            class="form-control @error('effective_date') is-invalid @enderror"
                                            id="effective_date" name="effective_date"
                                            value="{{ old('effective_date') }}">
                                        @error('effective_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="last_reviewed_by">Terakhir Ditinjau Oleh</label>
                                        <input type="text"
                                            class="form-control @error('last_reviewed_by') is-invalid @enderror"
                                            id="last_reviewed_by" name="last_reviewed_by"
                                            placeholder="Masukkan nama peninjau terakhir"
                                            value="{{ old('last_reviewed_by') }}">
                                        @error('last_reviewed_by')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="last_reviewed_on">Terakhir Ditinjau Pada</label>
                                        <input type="date"
                                            class="form-control @error('last_reviewed_on') is-invalid @enderror"
                                            id="last_reviewed_on" name="last_reviewed_on"
                                            value="{{ old('last_reviewed_on') }}">
                                        @error('last_reviewed_on')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="assessment">Penilaian</label>
                                        <select class="form-select @error('assessment') is-invalid @enderror"
                                            id="assessment" name="assessment">
                                            <option value="" selected>Pilih penilaian...</option>
                                            <option value="Review Pending"
                                                {{ old('assessment') == 'Review Pending' ? 'selected' : '' }}>
                                                Menunggu Peninjauan</option>
                                            <option value="Review Underway"
                                                {{ old('assessment') == 'Review Underway' ? 'selected' : '' }}>
                                                Peninjauan Sedang Berlangsung</option>
                                            <option value="Ineffective"
                                                {{ old('assessment') == 'Ineffective' ? 'selected' : '' }}>Tidak Efektif
                                            </option>
                                            <option value="Partial Effectiveness Only"
                                                {{ old('assessment') == 'Partial Effectiveness Only' ? 'selected' : '' }}>
                                                Hanya Efektif Sebagian</option>
                                            <option value="Effective but should be improved"
                                                {{ old('assessment') == 'Effective but should be improved' ? 'selected' : '' }}>
                                                Efektif tetapi perlu ditingkatkan</option>
                                            <option value="Effective - No Change Required"
                                                {{ old('assessment') == 'Effective - No Change Required' ? 'selected' : '' }}>
                                                Efektif - Tidak Perlu Perubahan</option>
                                        </select>
                                        @error('assessment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="overall_control_assessment">Penilaian Kontrol
                                            Keseluruhan</label>
                                        <select
                                            class="form-select @error('overall_control_assessment') is-invalid @enderror"
                                            id="overall_control_assessment" name="overall_control_assessment">
                                            <option value="" selected>Pilih penilaian kontrol keseluruhan...</option>
                                            <option value="Excellent"
                                                {{ old('overall_control_assessment') == 'Excellent' ? 'selected' : '' }}>
                                                Sangat Baik</option>
                                            <option value="Good"
                                                {{ old('overall_control_assessment') == 'Good' ? 'selected' : '' }}>Baik
                                            </option>
                                            <option value="Moderate"
                                                {{ old('overall_control_assessment') == 'Moderate' ? 'selected' : '' }}>
                                                Sedang</option>
                                            <option value="Poor"
                                                {{ old('overall_control_assessment') == 'Poor' ? 'selected' : '' }}>Buruk
                                            </option>
                                        </select>
                                        @error('overall_control_assessment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="residual_consequences">Konsekuensi Residual</label>
                                        <input type="text"
                                            class="form-control @error('residual_consequences') is-invalid @enderror"
                                            id="residual_consequences" name="residual_consequences"
                                            placeholder="Masukkan konsekuensi residual"
                                            value="{{ old('residual_consequences') }}">
                                        @error('residual_consequences')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="residual_likelihood">Kemungkinan Residual</label>
                                        <select class="form-select @error('residual_likelihood') is-invalid @enderror"
                                            id="residual_likelihood" name="residual_likelihood">
                                            <option value="" selected>Pilih kemungkinan residual...</option>
                                            <option value="Frequent"
                                                {{ old('residual_likelihood') == 'Frequent' ? 'selected' : '' }}>Sering
                                            </option>
                                            <option value="Likely"
                                                {{ old('residual_likelihood') == 'Likely' ? 'selected' : '' }}>Mungkin
                                            </option>
                                            <option value="Possible"
                                                {{ old('residual_likelihood') == 'Possible' ? 'selected' : '' }}>Mungkin
                                                Terjadi
                                            </option>
                                            <option value="Unlikely"
                                                {{ old('residual_likelihood') == 'Unlikely' ? 'selected' : '' }}>Tidak
                                                Mungkin
                                            </option>
                                            <option value="Rare"
                                                {{ old('residual_likelihood') == 'Rare' ? 'selected' : '' }}>Jarang
                                            </option>
                                        </select>
                                        @error('residual_likelihood')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="residual_score">Skor Residual</label>
                                        <div class="d-flex align-items-center">
                                            <input type="range" class="form-range flex-grow-1 me-2"
                                                id="residual_score_slider" min="0" max="100" step="1"
                                                value="{{ old('residual_score', 0) }}"
                                                oninput="updateScoreValue(this.value)">
                                            <input type="number"
                                                class="form-control @error('residual_score') is-invalid @enderror"
                                                id="residual_score" name="residual_score" style="max-width: 80px"
                                                value="{{ old('residual_score', 0) }}"
                                                oninput="updateSliderValue(this.value)">
                                        </div>
                                        @error('residual_score')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="residual_risk">Risiko Residual</label>
                                        <textarea class="form-control @error('residual_risk') is-invalid @enderror" id="residual_risk" name="residual_risk"
                                            placeholder="Masukkan risiko residual">{{ old('residual_risk') }}</textarea>
                                        @error('residual_risk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="source_of_assurance">Sumber Jaminan</label>
                                        <textarea class="form-control @error('source_of_assurance') is-invalid @enderror" id="source_of_assurance"
                                            name="source_of_assurance" placeholder="Masukkan sumber jaminan">{{ old('source_of_assurance') }}</textarea>
                                        @error('source_of_assurance')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="assurance_category">Kategori Jaminan</label>
                                        <select class="form-select @error('assurance_category') is-invalid @enderror"
                                            id="assurance_category" name="assurance_category">
                                            <option value="" selected>Pilih kategori jaminan...</option>
                                            <option value="Activity Throughout"
                                                {{ old('assurance_category') == 'Activity Throughout' ? 'selected' : '' }}>
                                                Aktivitas Menyeluruh</option>
                                            <option value="Audit and Finance Committee"
                                                {{ old('assurance_category') == 'Audit and Finance Committee' ? 'selected' : '' }}>
                                                Komite Audit dan Keuangan</option>
                                            <option value="Audit Processes"
                                                {{ old('assurance_category') == 'Audit Processes' ? 'selected' : '' }}>
                                                Proses Audit</option>
                                            <option value="Audit Reports"
                                                {{ old('assurance_category') == 'Audit Reports' ? 'selected' : '' }}>
                                                Laporan
                                                Audit</option>
                                            <option value="Claims"
                                                {{ old('assurance_category') == 'Claims' ? 'selected' : '' }}>Klaim
                                            </option>
                                            <option value="Complaints"
                                                {{ old('assurance_category') == 'Complaints' ? 'selected' : '' }}>
                                                Keluhan</option>
                                            <option value="Credentialling"
                                                {{ old('assurance_category') == 'Credentialling' ? 'selected' : '' }}>
                                                Kredensial</option>
                                            <option value="Education and Training Records"
                                                {{ old('assurance_category') == 'Education and Training Records' ? 'selected' : '' }}>
                                                Catatan Pendidikan dan Pelatihan</option>
                                            <option value="Employee Engagement"
                                                {{ old('assurance_category') == 'Employee Engagement' ? 'selected' : '' }}>
                                                Keterlibatan Karyawan</option>
                                            <option value="External Audit"
                                                {{ old('assurance_category') == 'External Audit' ? 'selected' : '' }}>
                                                Audit Eksternal</option>
                                            <option value="Finance Report"
                                                {{ old('assurance_category') == 'Finance Report' ? 'selected' : '' }}>
                                                Laporan Keuangan</option>
                                            <option value="H&S Committee"
                                                {{ old('assurance_category') == 'H&S Committee' ? 'selected' : '' }}>
                                                Komite
                                                K3</option>
                                            <option value="Incidents"
                                                {{ old('assurance_category') == 'Incidents' ? 'selected' : '' }}>Insiden
                                            </option>
                                            <option value="Inspection Reports"
                                                {{ old('assurance_category') == 'Inspection Reports' ? 'selected' : '' }}>
                                                Laporan Inspeksi</option>
                                            <option value="Internal Audit"
                                                {{ old('assurance_category') == 'Internal Audit' ? 'selected' : '' }}>
                                                Audit Internal</option>
                                            <option value="Key Performance Indicator"
                                                {{ old('assurance_category') == 'Key Performance Indicator' ? 'selected' : '' }}>
                                                Indikator Kinerja Utama</option>
                                            <option value="Legislative and Regulatory"
                                                {{ old('assurance_category') == 'Legislative and Regulatory' ? 'selected' : '' }}>
                                                Legislatif dan Regulasi</option>
                                            <option value="Milestone Reached"
                                                {{ old('assurance_category') == 'Milestone Reached' ? 'selected' : '' }}>
                                                Pencapaian Milestone</option>
                                            <option value="Monitoring"
                                                {{ old('assurance_category') == 'Monitoring' ? 'selected' : '' }}>
                                                Pemantauan</option>
                                            <option value="OHS Reports"
                                                {{ old('assurance_category') == 'OHS Reports' ? 'selected' : '' }}>Laporan
                                                K3</option>
                                            <option value="Project Control"
                                                {{ old('assurance_category') == 'Project Control' ? 'selected' : '' }}>
                                                Kontrol Proyek</option>
                                            <option value="Quality Committee"
                                                {{ old('assurance_category') == 'Quality Committee' ? 'selected' : '' }}>
                                                Komite Mutu</option>
                                            <option value="Recruitment, Retention and Sick Leave Rates"
                                                {{ old('assurance_category') == 'Recruitment, Retention and Sick Leave Rates' ? 'selected' : '' }}>
                                                Tingkat Rekrutmen, Retensi dan Cuti Sakit</option>
                                        </select>
                                        @error('assurance_category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="actions">Tindakan</label>
                                        <textarea class="form-control @error('actions') is-invalid @enderror" id="actions" name="actions"
                                            placeholder="Masukkan tindakan yang diperlukan">{{ old('actions') }}</textarea>
                                        @error('actions')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="action_assigned_date">Tanggal Penugasan
                                            Tindakan</label>
                                        <input type="date"
                                            class="form-control @error('action_assigned_date') is-invalid @enderror"
                                            id="action_assigned_date" name="action_assigned_date"
                                            value="{{ old('action_assigned_date') }}">
                                        @error('action_assigned_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="action_by_date">Tanggal Tenggat Tindakan</label>
                                        <input type="date"
                                            class="form-control @error('action_by_date') is-invalid @enderror"
                                            id="action_by_date" name="action_by_date"
                                            value="{{ old('action_by_date') }}">
                                        @error('action_by_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="action_description">Deskripsi Tindakan</label>
                                        <textarea class="form-control @error('action_description') is-invalid @enderror" id="action_description"
                                            placeholder="Masukkan deskripsi tindakan" name="action_description">{{ old('action_description') }}</textarea>
                                        @error('action_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="allocated_to">Dialokasikan Kepada</label>
                                        <input type="text"
                                            class="form-control @error('allocated_to') is-invalid @enderror"
                                            id="allocated_to" placeholder="Masukkan nama orang yang ditugaskan"
                                            name="allocated_to" value="{{ old('allocated_to') }}">
                                        @error('allocated_to')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="completed_on">Diselesaikan Pada</label>
                                        <input type="date"
                                            class="form-control @error('completed_on') is-invalid @enderror"
                                            id="completed_on" name="completed_on" value="{{ old('completed_on') }}">
                                        @error('completed_on')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="action_response">Respons Tindakan</label>
                                        <textarea class="form-control @error('action_response') is-invalid @enderror" id="action_response"
                                            placeholder="Masukkan respons terhadap tindakan" name="action_response">{{ old('action_response') }}</textarea>
                                        @error('action_response')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="progress_note">Catatan Kemajuan</label>
                                        <textarea class="form-control @error('progress_note') is-invalid @enderror" id="progress_note"
                                            placeholder="Masukkan catatan kemajuan" name="progress_note">{{ old('progress_note') }}</textarea>
                                        @error('progress_note')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="journal_type">Jenis Jurnal</label>
                                        <textarea class="form-control @error('journal_type') is-invalid @enderror" id="journal_type"
                                            placeholder="Masukkan jenis jurnal" name="journal_type">{{ old('journal_type') }}</textarea>
                                        @error('journal_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="journal_description">Deskripsi Jurnal</label>
                                        <textarea class="form-control @error('journal_description') is-invalid @enderror" id="journal_description"
                                            placeholder="Masukkan deskripsi jurnal" name="journal_description">{{ old('journal_description') }}</textarea>
                                        @error('journal_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="date_stamp">Stempel Tanggal</label>
                                        <input type="datetime-local"
                                            class="form-control @error('date_stamp') is-invalid @enderror"
                                            id="date_stamp" name="date_stamp" value="{{ old('date_stamp') }}">
                                        @error('date_stamp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label" for="document">Dokumen Pendukung</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="form-control @error('document') is-invalid @enderror"
                                                id="document" name="document" onchange="showFileInfo(this)">
                                            <p class="text-muted mt-1 small" id="fileInfo">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Belum ada dokumen. Upload file JPG, PNG, XLSX, CSV, PDF, DOC, atau XLS
                                                (maks. 10MB)
                                            </p>
                                            @error('document')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Nama Penginput -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="user_name">Nama Penginput</label>
                                        <input type="text" class="form-control"
                                            value="{{ Auth::user()->name ?? 'Nama tidak tersedia' }}" readonly>
                                        <!-- Hidden field to pass the actual user_id -->
                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                        @error('user_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Divisi -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="division">Divisi</label>
                                        <input type="text" class="form-control"
                                            value="{{ Auth::user()->division ? Auth::user()->division->name : 'Divisi tidak tersedia' }}"
                                            readonly>
                                        <!-- Hidden field to pass the actual division_id -->
                                        <input type="hidden" name="division_id"
                                            value="{{ Auth::user()->division_id ?? '' }}">
                                        @error('division_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Submit and Reset buttons -->
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="reset"
                                                class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Kirim</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<script>
    // When document is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the score display based on current value
        const initialValue = document.getElementById('residual_score').value;
        updateScoreValue(initialValue);
        updateSliderValue(initialValue);
        updateScoreColor(initialValue);

        // Add event listeners for real-time updates
        document.getElementById('residual_score_slider').addEventListener('input', function() {
            updateScoreValue(this.value);
            updateScoreColor(this.value);
        });

        document.getElementById('residual_score').addEventListener('input', function() {
            // Enforce min/max boundaries
            let val = parseInt(this.value);
            if (isNaN(val)) val = 0;
            if (val < 0) val = 0;
            if (val > 100) val = 100;

            this.value = val;
            updateSliderValue(val);
            updateScoreColor(val);
        });
    });

    function updateScoreValue(val) {
        document.getElementById('residual_score').value = val;
    }

    function updateSliderValue(val) {
        document.getElementById('residual_score_slider').value = val;
    }

    function updateScoreColor(val) {
        const scoreInput = document.getElementById('residual_score');

        // Remove any existing color classes
        scoreInput.classList.remove('bg-danger', 'bg-warning', 'bg-success', 'text-white');

        // Add appropriate color based on value
        if (val >= 0 && val <= 30) {
            scoreInput.classList.add('bg-success', 'text-white');
        } else if (val > 30 && val <= 70) {
            scoreInput.classList.add('bg-warning');
        } else if (val > 70) {
            101
            scoreInput.classList.add('bg-danger', 'text-white');
        }
    }
</script>
<script>
    function showFileInfo(input) {
        const fileInfo = document.getElementById('fileInfo');
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileSize = (file.size / 1024).toFixed(2);
            const fileSizeText = fileSize < 1024 ?
                `${fileSize} KB` :
                `${(fileSize/1024).toFixed(2)} MB`;

            fileInfo.innerHTML = `
                                                    <i class="bi bi-file-earmark me-1"></i>
                                                    ${file.name} (${fileSizeText})
                                                `;
        } else {
            fileInfo.innerHTML = `
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Belum ada dokumen. Upload file PDF, DOC, atau XLS (maks. 5MB)
                                                `;
        }
    }
</script>
