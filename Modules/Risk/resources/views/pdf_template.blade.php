<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1f1f1f;
            color: #e0e0e0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 14px;
            margin: 2px 0;
            font-weight: bold;
        }

        .table-container {
            margin-top: 30px;
            border-top: 2px solid #fff;
            padding-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #fff;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3c3c3c;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
        <p>Nama Penginput: {{ Auth::user()->name }}</p>
        <p>Divisi: {{ Auth::user()->division->name }}</p>
        <p>Risk Number: {{ $risks->first()->id }} (Unique)</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Risk ID</th>
                    <th>Reporters Name</th>
                    <th>Position</th>
                    <th>Contact No</th>
                    <th>Risk Name</th>
                    <th>Risk Description</th>
                    <th>Risk Status</th>
                    <th>Date Opened</th>
                    <th>Next Review Date</th>
                    <th>Reminder Period</th>
                    <th>Reminder Date</th>
                    <th>Type of Risk</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Unit</th>
                    <th>Relevant Committee</th>
                    <th>Accountable Manager</th>
                    <th>Responsible Supervisor</th>
                    <th>Notify of Associated Incidents</th>
                    <th>Causes</th>
                    <th>Consequences</th>
                    <th>Controls</th>
                    <th>Control</th>
                    <th>Control Hierarchy</th>
                    <th>Control Cost</th>
                    <th>Effective Date</th>
                    <th>Last Reviewed By</th>
                    <th>Last Reviewed On</th>
                    <th>Assessment</th>
                    <th>Overall Control Assessment</th>
                    <th>Residual Consequences</th>
                    <th>Residual Likelihood</th>
                    <th>Residual Score</th>
                    <th>Residual Risk</th>
                    <th>Source of Assurance</th>
                    <th>Assurance Category</th>
                    <th>Actions</th>
                    <th>Action Assigned Date</th>
                    <th>Action By Date</th>
                    <th>Action Description</th>
                    <th>Allocated To</th>
                    <th>Completed On</th>
                    <th>Action Response</th>
                    <th>Progress Note</th>
                    <th>Journal Type</th>
                    <th>Journal Description</th>
                    <th>Date Stamp</th>
                    <th>Document</th>
                    <th>User Name</th>
                    <th>Division Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Deleted At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($risks as $risk)
                    <tr>
                        <td>{{ $risk->id }}</td>
                        <td>{{ $risk->reporters_name }}</td>
                        <td>{{ $risk->reporters_position }}</td>
                        <td>{{ $risk->contact_no }}</td>
                        <td>{{ $risk->risk_name }}</td>
                        <td>{{ $risk->risk_description }}</td>
                        <td>{{ $risk->risk_status }}</td>
                        <td>{{ $risk->date_opened }}</td>
                        <td>{{ $risk->next_review_date }}</td>
                        <td>{{ $risk->reminder_period }}</td>
                        <td>{{ $risk->reminder_date }}</td>
                        <td>{{ $risk->type_of_risk }}</td>
                        <td>{{ $risk->category }}</td>
                        <td>{{ $risk->location }}</td>
                        <td>{{ $risk->unit }}</td>
                        <td>{{ $risk->relevant_committee }}</td>
                        <td>{{ $risk->accountable_manager }}</td>
                        <td>{{ $risk->responsible_supervisor }}</td>
                        <td>{{ $risk->notify_of_associated_incidents }}</td>
                        <td>{{ $risk->causes }}</td>
                        <td>{{ $risk->consequences }}</td>
                        <td>{{ $risk->controls }}</td>
                        <td>{{ $risk->control }}</td>
                        <td>{{ $risk->control_hierarchy }}</td>
                        <td>{{ $risk->control_cost }}</td>
                        <td>{{ $risk->effective_date }}</td>
                        <td>{{ $risk->last_reviewed_by }}</td>
                        <td>{{ $risk->last_reviewed_on }}</td>
                        <td>{{ $risk->assessment }}</td>
                        <td>{{ $risk->overall_control_assessment }}</td>
                        <td>{{ $risk->residual_consequences }}</td>
                        <td>{{ $risk->residual_likelihood }}</td>
                        <td>{{ $risk->residual_score }}</td>
                        <td>{{ $risk->residual_risk }}</td>
                        <td>{{ $risk->source_of_assurance }}</td>
                        <td>{{ $risk->assurance_category }}</td>
                        <td>{{ $risk->actions }}</td>
                        <td>{{ $risk->action_assigned_date }}</td>
                        <td>{{ $risk->action_by_date }}</td>
                        <td>{{ $risk->action_description }}</td>
                        <td>{{ $risk->allocated_to }}</td>
                        <td>{{ $risk->completed_on }}</td>
                        <td>{{ $risk->action_response }}</td>
                        <td>{{ $risk->progress_note }}</td>
                        <td>{{ $risk->journal_type }}</td>
                        <td>{{ $risk->journal_description }}</td>
                        <td>{{ $risk->date_stamp }}</td>
                        <td>{{ $risk->document }}</td>
                        <td>{{ $risk->user_name }}</td>
                        <td>{{ $risk->division_name }}</td>
                        <td>{{ $risk->created_at }}</td>
                        <td>{{ $risk->updated_at }}</td>
                        <td>{{ $risk->deleted_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>End of Report</p>
    </div>
</body>

</html>
