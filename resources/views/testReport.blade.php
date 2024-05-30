@extends('layout.reportHeader')
@section('title', 'Test Report')
@section('content')
<x-testReportComponent :testReport=$testReport/>
@endsection