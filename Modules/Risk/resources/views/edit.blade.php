@extends('admin.layouts.app')

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Edit Risk</h3>
                        <p class="text-subtitle text-muted">Update the details of the risk.</p>
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
                                <form method="POST" action="{{ route('risks.update', $risk->id) }}">
                                    @csrf
                                    @method('PUT') <!-- Use PUT for updating -->

                                    <!-- Reporter Details -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="reporters_name">Reporter’s Name</label>
                                        <input type="text"
                                            class="form-control @error('reporters_name') is-invalid @enderror"
                                            id="reporters_name" name="reporters_name"
                                            value="{{ old('reporters_name', $risk->reporters_name) }}">
                                        @error('reporters_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="reporters_position">Reporter’s Position</label>
                                        <input type="text"
                                            class="form-control @error('reporters_position') is-invalid @enderror"
                                            id="reporters_position" name="reporters_position"
                                            value="{{ old('reporters_position', $risk->reporters_position) }}">
                                        @error('reporters_position')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="contact_no">Contact No</label>
                                        <input type="text" class="form-control @error('contact_no') is-invalid @enderror"
                                            id="contact_no" name="contact_no"
                                            value="{{ old('contact_no', $risk->contact_no) }}">
                                        @error('contact_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Risk Details -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="risk_name">Risk Name</label>
                                        <input type="text" class="form-control @error('risk_name') is-invalid @enderror"
                                            id="risk_name" name="risk_name"
                                            value="{{ old('risk_name', $risk->risk_name) }}">
                                        @error('risk_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="risk_description">Risk Description</label>
                                        <textarea class="form-control @error('risk_description') is-invalid @enderror" id="risk_description"
                                            name="risk_description">{{ old('risk_description', $risk->risk_description) }}</textarea>
                                        @error('risk_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Status Fields -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="risk_status">Risk Status</label>
                                        <select class="form-control @error('risk_status') is-invalid @enderror"
                                            id="risk_status" name="risk_status">
                                            <option value="Provisional"
                                                {{ old('risk_status', $risk->risk_status) == 'Provisional' ? 'selected' : '' }}>
                                                Provisional</option>
                                            <option value="Open"
                                                {{ old('risk_status', $risk->risk_status) == 'Open' ? 'selected' : '' }}>
                                                Open</option>
                                            <option value="Closed"
                                                {{ old('risk_status', $risk->risk_status) == 'Closed' ? 'selected' : '' }}>
                                                Closed</option>
                                            <option value="Re-Opened"
                                                {{ old('risk_status', $risk->risk_status) == 'Re-Opened' ? 'selected' : '' }}>
                                                Re-Opened</option>
                                        </select>
                                        @error('risk_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="date_opened">Date Opened</label>
                                        <input type="date"
                                            class="form-control @error('date_opened') is-invalid @enderror" id="date_opened"
                                            name="date_opened" value="{{ old('date_opened', $risk->date_opened) }}">
                                        @error('date_opened')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="next_review_date">Next Review Date</label>
                                        <input type="date"
                                            class="form-control @error('next_review_date') is-invalid @enderror"
                                            id="next_review_date" name="next_review_date"
                                            value="{{ old('next_review_date', $risk->next_review_date) }}">
                                        @error('next_review_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Reminder Period -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="reminder_period">Reminder Period</label>
                                        <select class="form-control @error('reminder_period') is-invalid @enderror"
                                            id="reminder_period" name="reminder_period">
                                            <option value="Do Not Send Reminder"
                                                {{ old('reminder_period', $risk->reminder_period) == 'Do Not Send Reminder' ? 'selected' : '' }}>
                                                Do Not Send Reminder</option>
                                            <option value="On The Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == 'On The Due Date' ? 'selected' : '' }}>
                                                On The Due Date</option>
                                            <option value="1 day before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '1 day before the Due Date' ? 'selected' : '' }}>
                                                1 day before the Due Date</option>
                                            <option value="2 days before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '2 days before the Due Date' ? 'selected' : '' }}>
                                                2 days before the Due Date</option>
                                            <option value="3 days before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '3 days before the Due Date' ? 'selected' : '' }}>
                                                3 days before the Due Date</option>
                                            <option value="4 days before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '4 days before the Due Date' ? 'selected' : '' }}>
                                                4 days before the Due Date</option>
                                            <option value="5 days before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '5 days before the Due Date' ? 'selected' : '' }}>
                                                5 days before the Due Date</option>
                                            <option value="6 days before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '6 days before the Due Date' ? 'selected' : '' }}>
                                                6 days before the Due Date</option>
                                            <option value="1 week before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '1 week before the Due Date' ? 'selected' : '' }}>
                                                1 week before the Due Date</option>
                                            <option value="2 weeks before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '2 weeks before the Due Date' ? 'selected' : '' }}>
                                                2 weeks before the Due Date</option>
                                            <option value="1 Month (30 Days) before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '1 Month (30 Days) before the Due Date' ? 'selected' : '' }}>
                                                1 Month (30 Days) before the Due Date</option>
                                            <option value="2 Months (60 Days) before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '2 Months (60 Days) before the Due Date' ? 'selected' : '' }}>
                                                2 Months (60 Days) before the Due Date</option>
                                            <option value="3 Months (90 Days) before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '3 Months (90 Days) before the Due Date' ? 'selected' : '' }}>
                                                3 Months (90 Days) before the Due Date</option>
                                            <option value="6 Months (180 Days) before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '6 Months (180 Days) before the Due Date' ? 'selected' : '' }}>
                                                6 Months (180 Days) before the Due Date</option>
                                            <option value="1 Year (365 Days) before the Due Date"
                                                {{ old('reminder_period', $risk->reminder_period) == '1 Year (365 Days) before the Due Date' ? 'selected' : '' }}>
                                                1 Year (365 Days) before the Due Date</option>
                                        </select>
                                        @error('reminder_period')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Reminder Date -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="reminder_date">Reminder Date</label>
                                        <input type="date"
                                            class="form-control @error('reminder_date') is-invalid @enderror"
                                            id="reminder_date" name="reminder_date"
                                            value="{{ old('reminder_date', $risk->reminder_date) }}">
                                        @error('reminder_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Risk Type -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="type_of_risk">Risk Type</label>
                                        <select class="form-control @error('type_of_risk') is-invalid @enderror"
                                            id="type_of_risk" name="type_of_risk">
                                            <option value="Corporate Risk"
                                                {{ old('type_of_risk', $risk->type_of_risk) == 'Corporate Risk' ? 'selected' : '' }}>
                                                Corporate Risk</option>
                                            <option value="Hospital Risk"
                                                {{ old('type_of_risk', $risk->type_of_risk) == 'Hospital Risk' ? 'selected' : '' }}>
                                                Hospital Risk</option>
                                            <option value="Project Risk"
                                                {{ old('type_of_risk', $risk->type_of_risk) == 'Project Risk' ? 'selected' : '' }}>
                                                Project Risk</option>
                                            <option value="Emerging Risk"
                                                {{ old('type_of_risk', $risk->type_of_risk) == 'Emerging Risk' ? 'selected' : '' }}>
                                                Emerging Risk</option>
                                        </select>
                                        @error('type_of_risk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Category -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="category">Category</label>
                                        <select class="form-control @error('category') is-invalid @enderror"
                                            id="category" name="category">
                                            <option value="Business Process and System"
                                                {{ old('category', $risk->category) == 'Business Process and System' ? 'selected' : '' }}>
                                                Business Process and System</option>
                                            <option value="Consumer Quality and Safety and Environment"
                                                {{ old('category', $risk->category) == 'Consumer Quality and Safety and Environment' ? 'selected' : '' }}>
                                                Consumer Quality and Safety and Environment</option>
                                            <option value="Health and Safety"
                                                {{ old('category', $risk->category) == 'Health and Safety' ? 'selected' : '' }}>
                                                Health and Safety</option>
                                            <option value="Reputation and Mission"
                                                {{ old('category', $risk->category) == 'Reputation and Mission' ? 'selected' : '' }}>
                                                Reputation and Mission</option>
                                            <option value="Service Delivery"
                                                {{ old('category', $risk->category) == 'Service Delivery' ? 'selected' : '' }}>
                                                Service Delivery</option>
                                        </select>
                                        @error('category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Location -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="location">Location</label>
                                        <input type="text"
                                            class="form-control @error('location') is-invalid @enderror" id="location"
                                            name="location" value="{{ old('location', $risk->location) }}">
                                        @error('location')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Unit -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="unit">Unit</label>
                                        <input type="text" class="form-control @error('unit') is-invalid @enderror"
                                            id="unit" name="unit" value="{{ old('unit', $risk->unit) }}">
                                        @error('unit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Relevant Committee -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="relevant_committee">Relevant Committee</label>
                                        <select class="form-control @error('relevant_committee') is-invalid @enderror"
                                            id="relevant_committee" name="relevant_committee">
                                            <option value="Antimicroba Resistency Control"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Antimicroba Resistency Control' ? 'selected' : '' }}>
                                                Antimicroba Resistency Control</option>
                                            <option value="Ethics"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Ethics' ? 'selected' : '' }}>
                                                Ethics
                                            </option>
                                            <option value="Health Promotion"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Health Promotion' ? 'selected' : '' }}>
                                                Health Promotion</option>
                                            <option value="Infection Control"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Infection Control' ? 'selected' : '' }}>
                                                Infection Control</option>
                                            <option value="MDGs"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'MDGs' ? 'selected' : '' }}>
                                                MDGs</option>
                                            <option value="Medical"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Medical' ? 'selected' : '' }}>
                                                Medical
                                            </option>
                                            <option value="Medical Record"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Medical Record' ? 'selected' : '' }}>
                                                Medical Record</option>
                                            <option value="Medical Record Extermination"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Medical Record Extermination' ? 'selected' : '' }}>
                                                Medical Record Extermination</option>
                                            <option value="Medical - Ethico Legal"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Medical - Ethico Legal' ? 'selected' : '' }}>
                                                Medical - Ethico Legal</option>
                                            <option value="Nursing"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Nursing' ? 'selected' : '' }}>
                                                Nursing
                                            </option>
                                            <option value="Occupational Health and Safety"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Occupational Health and Safety' ? 'selected' : '' }}>
                                                Occupational Health and Safety</option>
                                            <option value="Pain Management"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Pain Management' ? 'selected' : '' }}>
                                                Pain
                                                Management</option>
                                            <option value="Patient Safety"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Patient Safety' ? 'selected' : '' }}>
                                                Patient Safety</option>
                                            <option value="Pharmacy and Therapatical"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Pharmacy and Therapatical' ? 'selected' : '' }}>
                                                Pharmacy and Therapatical</option>
                                            <option value="PONEK"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'PONEK' ? 'selected' : '' }}>
                                                PONEK</option>
                                            <option value="Quality"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Quality' ? 'selected' : '' }}>
                                                Quality
                                            </option>
                                            <option value="Quality and Patient Safety"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Quality and Patient Safety' ? 'selected' : '' }}>
                                                Quality and Patient Safety</option>
                                            <option value="TB Dots"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'TB Dots' ? 'selected' : '' }}>
                                                TB Dots
                                            </option>
                                            <option value="Nil"
                                                {{ old('relevant_committee', $risk->relevant_committee) == 'Nil' ? 'selected' : '' }}>
                                                Nil</option>
                                        </select>
                                        @error('relevant_committee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Accountable Manager -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="accountable_manager">Accountable Manager</label>
                                        <input type="text"
                                            class="form-control @error('accountable_manager') is-invalid @enderror"
                                            id="accountable_manager" name="accountable_manager"
                                            value="{{ old('accountable_manager', $risk->accountable_manager) }}">
                                        @error('accountable_manager')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Responsible Supervisor -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="responsible_supervisor">Responsible
                                            Supervisor</label>
                                        <input type="text"
                                            class="form-control @error('responsible_supervisor') is-invalid @enderror"
                                            id="responsible_supervisor" name="responsible_supervisor"
                                            value="{{ old('responsible_supervisor', $risk->responsible_supervisor) }}">
                                        @error('responsible_supervisor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Notify of Associated Incidents -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="notify_of_associated_incidents">Notify of
                                            Associated Incidents</label>
                                        <select
                                            class="form-control @error('notify_of_associated_incidents') is-invalid @enderror"
                                            id="notify_of_associated_incidents" name="notify_of_associated_incidents">
                                            <option value="Yes"
                                                {{ old('notify_of_associated_incidents', $risk->notify_of_associated_incidents) == 'Yes' ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="No"
                                                {{ old('notify_of_associated_incidents', $risk->notify_of_associated_incidents) == 'No' ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                        @error('notify_of_associated_incidents')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Causes -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="causes">Causes</label>
                                        <textarea class="form-control @error('causes') is-invalid @enderror" id="causes" name="causes">{{ old('causes', $risk->causes) }}</textarea>
                                        @error('causes')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Consequences -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="consequences">Consequences</label>
                                        <textarea class="form-control @error('consequences') is-invalid @enderror" id="consequences" name="consequences">{{ old('consequences', $risk->consequences) }}</textarea>
                                        @error('consequences')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Controls -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="controls">Controls</label>
                                        <textarea class="form-control @error('controls') is-invalid @enderror" id="controls" name="controls">{{ old('controls', $risk->controls) }}</textarea>
                                        @error('controls')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Control Level -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="control">Control Level</label>
                                        <select class="form-control @error('control') is-invalid @enderror"
                                            id="control" name="control">
                                            <option value="Minimal"
                                                {{ old('control', $risk->control) == 'Minimal' ? 'selected' : '' }}>Minimal
                                            </option>
                                            <option value="Minor"
                                                {{ old('control', $risk->control) == 'Minor' ? 'selected' : '' }}>Minor
                                            </option>
                                            <option value="Moderate"
                                                {{ old('control', $risk->control) == 'Moderate' ? 'selected' : '' }}>
                                                Moderate</option>
                                            <option value="Major"
                                                {{ old('control', $risk->control) == 'Major' ? 'selected' : '' }}>Major
                                            </option>
                                            <option value="Serious"
                                                {{ old('control', $risk->control) == 'Serious' ? 'selected' : '' }}>Serious
                                            </option>
                                        </select>
                                        @error('control')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Control Hierarchy -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="control_hierarchy">Control Hierarchy</label>
                                        <select class="form-control @error('control_hierarchy') is-invalid @enderror"
                                            id="control_hierarchy" name="control_hierarchy">
                                            <option value="Risk Avoidance"
                                                {{ old('control_hierarchy', $risk->control_hierarchy) == 'Risk Avoidance' ? 'selected' : '' }}>
                                                Risk Avoidance</option>
                                            <option value="Risk Acceptance"
                                                {{ old('control_hierarchy', $risk->control_hierarchy) == 'Risk Acceptance' ? 'selected' : '' }}>
                                                Risk Acceptance</option>
                                            <option value="Reduction of Likelihood of Occurrence"
                                                {{ old('control_hierarchy', $risk->control_hierarchy) == 'Reduction of Likelihood of Occurrence' ? 'selected' : '' }}>
                                                Reduction of Likelihood of Occurrence</option>
                                            <option value="Reduction of Consequence"
                                                {{ old('control_hierarchy', $risk->control_hierarchy) == 'Reduction of Consequence' ? 'selected' : '' }}>
                                                Reduction of Consequence</option>
                                            <option value="Transference of Risks"
                                                {{ old('control_hierarchy', $risk->control_hierarchy) == 'Transference of Risks' ? 'selected' : '' }}>
                                                Transference of Risks</option>
                                            <option value="Elimination"
                                                {{ old('control_hierarchy', $risk->control_hierarchy) == 'Elimination' ? 'selected' : '' }}>
                                                Elimination</option>
                                            <option value="Substitution"
                                                {{ old('control_hierarchy', $risk->control_hierarchy) == 'Substitution' ? 'selected' : '' }}>
                                                Substitution</option>
                                            <option value="Isolation"
                                                {{ old('control_hierarchy', $risk->control_hierarchy) == 'Isolation' ? 'selected' : '' }}>
                                                Isolation</option>
                                            <option value="Engineering"
                                                {{ old('control_hierarchy', $risk->control_hierarchy) == 'Engineering' ? 'selected' : '' }}>
                                                Engineering</option>
                                            <option value="Administrative"
                                                {{ old('control_hierarchy', $risk->control_hierarchy) == 'Administrative' ? 'selected' : '' }}>
                                                Administrative</option>
                                            <option value="Personal Protective Equipment"
                                                {{ old('control_hierarchy', $risk->control_hierarchy) == 'Personal Protective Equipment' ? 'selected' : '' }}>
                                                Personal Protective Equipment</option>
                                        </select>
                                        @error('control_hierarchy')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Control Cost -->
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="control_cost">Control Cost</label>
                                        <input type="text"
                                            class="form-control @error('control_cost') is-invalid @enderror"
                                            id="control_cost" name="control_cost"
                                            value="{{ old('control_cost', $risk->control_cost) }}">
                                        @error('control_cost')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Effective Date -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="effective_date">Effective Date</label>
                                        <input type="date"
                                            class="form-control @error('effective_date') is-invalid @enderror"
                                            id="effective_date" name="effective_date"
                                            value="{{ old('effective_date', $risk->effective_date) }}">
                                        @error('effective_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Last Reviewed By -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="last_reviewed_by">Last Reviewed By</label>
                                        <input type="text"
                                            class="form-control @error('last_reviewed_by') is-invalid @enderror"
                                            id="last_reviewed_by" name="last_reviewed_by"
                                            value="{{ old('last_reviewed_by', $risk->last_reviewed_by) }}">
                                        @error('last_reviewed_by')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Last Reviewed On -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="last_reviewed_on">Last Reviewed On</label>
                                        <input type="date"
                                            class="form-control @error('last_reviewed_on') is-invalid @enderror"
                                            id="last_reviewed_on" name="last_reviewed_on"
                                            value="{{ old('last_reviewed_on', $risk->last_reviewed_on) }}">
                                        @error('last_reviewed_on')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Assessment -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="assessment">Assessment</label>
                                        <select class="form-control @error('assessment') is-invalid @enderror"
                                            id="assessment" name="assessment">
                                            <option value="Review Pending"
                                                {{ old('assessment', $risk->assessment) == 'Review Pending' ? 'selected' : '' }}>
                                                Review Pending</option>
                                            <option value="Review Underway"
                                                {{ old('assessment', $risk->assessment) == 'Review Underway' ? 'selected' : '' }}>
                                                Review Underway</option>
                                            <option value="Ineffective"
                                                {{ old('assessment', $risk->assessment) == 'Ineffective' ? 'selected' : '' }}>
                                                Ineffective</option>
                                            <option value="Partial Effectiveness Only"
                                                {{ old('assessment', $risk->assessment) == 'Partial Effectiveness Only' ? 'selected' : '' }}>
                                                Partial Effectiveness Only</option>
                                            <option value="Effective but should be improved"
                                                {{ old('assessment', $risk->assessment) == 'Effective but should be improved' ? 'selected' : '' }}>
                                                Effective but should be improved</option>
                                            <option value="Effective - No Change Required"
                                                {{ old('assessment', $risk->assessment) == 'Effective - No Change Required' ? 'selected' : '' }}>
                                                Effective - No Change Required</option>
                                        </select>
                                        @error('assessment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Overall Control Assessment -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="overall_control_assessment">Overall Control
                                            Assessment</label>
                                        <select
                                            class="form-control @error('overall_control_assessment') is-invalid @enderror"
                                            id="overall_control_assessment" name="overall_control_assessment">
                                            <option value="Excellent"
                                                {{ old('overall_control_assessment', $risk->overall_control_assessment) == 'Excellent' ? 'selected' : '' }}>
                                                Excellent</option>
                                            <option value="Good"
                                                {{ old('overall_control_assessment', $risk->overall_control_assessment) == 'Good' ? 'selected' : '' }}>
                                                Good</option>
                                            <option value="Moderate"
                                                {{ old('overall_control_assessment', $risk->overall_control_assessment) == 'Moderate' ? 'selected' : '' }}>
                                                Moderate</option>
                                            <option value="Poor"
                                                {{ old('overall_control_assessment', $risk->overall_control_assessment) == 'Poor' ? 'selected' : '' }}>
                                                Poor</option>
                                        </select>
                                        @error('overall_control_assessment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Residual Consequences -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="residual_consequences">Residual
                                            Consequences</label>
                                        <input type="text"
                                            class="form-control @error('residual_consequences') is-invalid @enderror"
                                            id="residual_consequences" name="residual_consequences"
                                            value="{{ old('residual_consequences', $risk->residual_consequences) }}">
                                        @error('residual_consequences')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Residual Likelihood -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="residual_likelihood">Residual Likelihood</label>
                                        <select class="form-control @error('residual_likelihood') is-invalid @enderror"
                                            id="residual_likelihood" name="residual_likelihood">
                                            <option value="Frequent"
                                                {{ old('residual_likelihood', $risk->residual_likelihood) == 'Frequent' ? 'selected' : '' }}>
                                                Frequent</option>
                                            <option value="Likely"
                                                {{ old('residual_likelihood', $risk->residual_likelihood) == 'Likely' ? 'selected' : '' }}>
                                                Likely</option>
                                            <option value="Possible"
                                                {{ old('residual_likelihood', $risk->residual_likelihood) == 'Possible' ? 'selected' : '' }}>
                                                Possible</option>
                                            <option value="Unlikely"
                                                {{ old('residual_likelihood', $risk->residual_likelihood) == 'Unlikely' ? 'selected' : '' }}>
                                                Unlikely</option>
                                            <option value="Rare"
                                                {{ old('residual_likelihood', $risk->residual_likelihood) == 'Rare' ? 'selected' : '' }}>
                                                Rare</option>
                                        </select>
                                        @error('residual_likelihood')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Residual Score -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="residual_score">Residual Score</label>
                                        <input type="text"
                                            class="form-control @error('residual_score') is-invalid @enderror"
                                            id="residual_score" name="residual_score"
                                            value="{{ old('residual_score', $risk->residual_score) }}">
                                        @error('residual_score')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Residual Risk -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="residual_risk">Residual Risk</label>
                                        <textarea class="form-control @error('residual_risk') is-invalid @enderror" id="residual_risk" name="residual_risk">{{ old('residual_risk', $risk->residual_risk) }}</textarea>
                                        @error('residual_risk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Source of Assurance -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="source_of_assurance">Source of Assurance</label>
                                        <textarea class="form-control @error('source_of_assurance') is-invalid @enderror" id="source_of_assurance"
                                            name="source_of_assurance">{{ old('source_of_assurance', $risk->source_of_assurance) }}</textarea>
                                        @error('source_of_assurance')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Assurance Category -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="assurance_category">Assurance Category</label>
                                        <select class="form-control @error('assurance_category') is-invalid @enderror"
                                            id="assurance_category" name="assurance_category">
                                            <option value="Activity Throughout"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Activity Throughout' ? 'selected' : '' }}>
                                                Activity Throughout</option>
                                            <option value="Audit and Finance Committee"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Audit and Finance Committee' ? 'selected' : '' }}>
                                                Audit and Finance Committee</option>
                                            <option value="Audit Processes"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Audit Processes' ? 'selected' : '' }}>
                                                Audit Processes</option>
                                            <option value="Audit Reports"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Audit Reports' ? 'selected' : '' }}>
                                                Audit Reports</option>
                                            <option value="Claims"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Claims' ? 'selected' : '' }}>
                                                Claims</option>
                                            <option value="Complaints"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Complaints' ? 'selected' : '' }}>
                                                Complaints</option>
                                            <option value="Credentialling"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Credentialling' ? 'selected' : '' }}>
                                                Credentialling</option>
                                            <option value="Education and Training Records"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Education and Training Records' ? 'selected' : '' }}>
                                                Education and Training Records</option>
                                            <option value="Employee Engagement"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Employee Engagement' ? 'selected' : '' }}>
                                                Employee Engagement</option>
                                            <option value="External Audit"
                                                {{ old('assurance_category', $risk->assurance_category) == 'External Audit' ? 'selected' : '' }}>
                                                External Audit</option>
                                            <option value="Finance Report"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Finance Report' ? 'selected' : '' }}>
                                                Finance Report</option>
                                            <option value="H&S Committee"
                                                {{ old('assurance_category', $risk->assurance_category) == 'H&S Committee' ? 'selected' : '' }}>
                                                H&S Committee</option>
                                            <option value="Incidents"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Incidents' ? 'selected' : '' }}>
                                                Incidents</option>
                                            <option value="Inspection Reports"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Inspection Reports' ? 'selected' : '' }}>
                                                Inspection Reports</option>
                                            <option value="Internal Audit"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Internal Audit' ? 'selected' : '' }}>
                                                Internal Audit</option>
                                            <option value="Key Performance Indicator"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Key Performance Indicator' ? 'selected' : '' }}>
                                                Key Performance Indicator</option>
                                            <option value="Legislative and Regulatory"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Legislative and Regulatory' ? 'selected' : '' }}>
                                                Legislative and Regulatory</option>
                                            <option value="Milestone Reached"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Milestone Reached' ? 'selected' : '' }}>
                                                Milestone Reached</option>
                                            <option value="Monitoring"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Monitoring' ? 'selected' : '' }}>
                                                Monitoring</option>
                                            <option value="OHS Reports"
                                                {{ old('assurance_category', $risk->assurance_category) == 'OHS Reports' ? 'selected' : '' }}>
                                                OHS Reports</option>
                                            <option value="Project Control"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Project Control' ? 'selected' : '' }}>
                                                Project Control</option>
                                            <option value="Quality Committee"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Quality Committee' ? 'selected' : '' }}>
                                                Quality Committee</option>
                                            <option value="Recruitment, Retention and Sick Leave Rates"
                                                {{ old('assurance_category', $risk->assurance_category) == 'Recruitment, Retention and Sick Leave Rates' ? 'selected' : '' }}>
                                                Recruitment, Retention and Sick Leave Rates</option>
                                        </select>
                                        @error('assurance_category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Actions -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="actions">Actions</label>
                                        <textarea class="form-control @error('actions') is-invalid @enderror" id="actions" name="actions">{{ old('actions', $risk->actions) }}</textarea>
                                        @error('actions')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Action Assigned Date -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="action_assigned_date">Action Assigned Date</label>
                                        <input type="date"
                                            class="form-control @error('action_assigned_date') is-invalid @enderror"
                                            id="action_assigned_date" name="action_assigned_date"
                                            value="{{ old('action_assigned_date', $risk->action_assigned_date) }}">
                                        @error('action_assigned_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Action By Date -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="action_by_date">Action By Date</label>
                                        <input type="date"
                                            class="form-control @error('action_by_date') is-invalid @enderror"
                                            id="action_by_date" name="action_by_date"
                                            value="{{ old('action_by_date', $risk->action_by_date) }}">
                                        @error('action_by_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Action Description -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="action_description">Action Description</label>
                                        <textarea class="form-control @error('action_description') is-invalid @enderror" id="action_description"
                                            name="action_description">{{ old('action_description', $risk->action_description) }}</textarea>
                                        @error('action_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Allocated To -->
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="allocated_to">Allocated To</label>
                                        <input type="text"
                                            class="form-control @error('allocated_to') is-invalid @enderror"
                                            id="allocated_to" name="allocated_to"
                                            value="{{ old('allocated_to', $risk->allocated_to) }}">
                                        @error('allocated_to')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Completed On -->
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="completed_on">Completed On</label>
                                        <input type="date"
                                            class="form-control @error('completed_on') is-invalid @enderror"
                                            id="completed_on" name="completed_on"
                                            value="{{ old('completed_on', $risk->completed_on) }}">
                                        @error('completed_on')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Action Response -->
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="action_response">Action Response</label>
                                        <textarea class="form-control @error('action_response') is-invalid @enderror" id="action_response"
                                            name="action_response">{{ old('action_response', $risk->action_response) }}</textarea>
                                        @error('action_response')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Progress Note -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="progress_note">Progress Note</label>
                                        <textarea class="form-control @error('progress_note') is-invalid @enderror" id="progress_note" name="progress_note">{{ old('progress_note', $risk->progress_note) }}</textarea>
                                        @error('progress_note')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Journal Type -->
                                    <div class="form-group mandatory mb-3">
                                        <label class="form-label" for="journal_type">Journal Type</label>
                                        <textarea class="form-control @error('journal_type') is-invalid @enderror" id="journal_type" name="journal_type">{{ old('journal_type', $risk->journal_type) }}</textarea>
                                        @error('journal_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Journal Description -->
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="journal_description">Journal Description</label>
                                        <textarea class="form-control @error('journal_description') is-invalid @enderror" id="journal_description"
                                            name="journal_description">{{ old('journal_description', $risk->journal_description) }}</textarea>
                                        @error('journal_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Date Stamp -->
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="date_stamp">Date Stamp</label>
                                        <input type="datetime-local"
                                            class="form-control @error('date_stamp') is-invalid @enderror"
                                            id="date_stamp" name="date_stamp"
                                            value="{{ old('date_stamp', $risk->date_stamp) }}">
                                        @error('date_stamp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Document -->
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="document">Document</label>
                                        <input type="file"
                                            class="form-control @error('document') is-invalid @enderror" id="document"
                                            name="document" value="{{ old('document', $risk->document) }}">
                                        @error('document')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-primary">Update Risk</button>
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
