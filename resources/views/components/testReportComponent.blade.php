<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Report</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            vertical-align: top;
            font-size: 14px;
        }

        .table th {
            background-color: #f1f1f1;
        }

        .text-center {
            text-align: center;
        }

        .mt-5 {
            margin-top: 3rem;
        }

        .d-flex {
            display: flex;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .container {
            width: 100%;
            margin: auto;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rasterizehtml/1.2.4/rasterizeHTML.allinone.min.js"></script>
</head>

<body>
    <div class="container mt-5 bg-light">
        <h1 class="text-center">Test Report</h1>
        <div class="d-flex gap-2">
            <div>Project:</div>
            <div>{{ $testReport['project']->name }}</div>
        </div>

        <!-- Test Cases Section -->
        <h2 class="mt-5">Test Cases</h2>
        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Title</th>
                    <th>Status Description</th>
                    <th>Step</th>
                    <th>Expected Result</th>
                    <th>Found Result</th>
                    <th>Pass</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($testReport['report'] as $testCase)
                    @php
                        $testStepsCount = $testCase->testSteps->count();
                    @endphp
                    @if ($testStepsCount > 0)
                        @foreach ($testCase->testSteps as $index => $testStep)
                            <tr>
                                @if ($index === 0)
                                    <td rowspan="{{ $testStepsCount }}">{{ $testCase->module_name }}</td>
                                    <td rowspan="{{ $testStepsCount }}">{{ $testCase->title }}</td>
                                    <td rowspan="{{ $testStepsCount }}">{{ $testCase->description ?? 'N/A' }}</td>
                                @endif
                                <td>{{ $testStep->step_description }}</td>
                                <td>{{ $testStep->expectedResult->result_description ?? 'N/A' }}</td>
                                <td>{{ $testStep->expectedResult->found_description ?? 'N/A' }}</td>
                                <td>
                                    @if (is_null($testStep->expectedResult->pass))
                                        N/A
                                    @elseif($testStep->expectedResult->pass === 'true')
                                        <span style="color: green;">Passed</span>
                                    @else
                                        <span style="color: red;">Failed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>{{ $testCase->module_name }}</td>
                            <td>{{ $testCase->title }}</td>
                            <td>{{ $testCase->description ?? 'N/A' }}</td>
                            <td colspan="4" class="text-center">No Test Steps</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Issues Section -->
        <h2 class="mt-5">Issues</h2>
        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th>Issue ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Stage</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($testReport['issues'] as $issue)
                    <tr>
                        <td>{{ $issue->id }}</td>
                        <td>{{ $issue->title }}</td>
                        <td>{{ $issue->description }}</td>
                        <td>{{ $issue->stage }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        
    </div>
</body>

</html>
