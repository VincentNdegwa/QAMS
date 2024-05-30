<!-- resources/views/testReport.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Report</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <header class=" position-fixed top-0">
            <button>Get Pdf</button>
        </header>
        <h1>Test Report</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Module Name</th>
                    <th>Title</th>
                    <th>Status Description</th>
                    <th>Step</th>
                    <th>Expected Result</th>
                    <th>Found Result</th>
                    <th>Pass</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($testReport as $testCase)
                    @php
                        $testStepsCount = $testCase->testSteps->count();
                    @endphp
                    @if ($testStepsCount > 0)
                        @foreach ($testCase->testSteps as $index => $testStep)
                            <tr>
                                @if ($index === 0)
                                    <td rowspan="{{ $testStepsCount }}">{{ $testCase->id }}</td>
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
                            <td>{{ $testCase->id }}</td>
                            <td>{{ $testCase->module_name }}</td>
                            <td>{{ $testCase->title }}</td>
                            <td>{{ $testCase->description ?? 'N/A' }}</td>
                            <td colspan="6" class="text-center">No Test Steps</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
