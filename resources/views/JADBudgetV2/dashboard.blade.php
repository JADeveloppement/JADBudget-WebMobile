@extends('JADBudgetV2.components.master')

@section('style')
<link rel="stylesheet" href="{{ mix('css/JADBudgetV2/index.css') }}">
<link rel="stylesheet" href="{{ mix('css/JADBudgetV2/dashboard.css') }}">
@endsection

@section('script')
<script src="{{ mix('js/JADBudgetV2/dashboard.js') }}" defer></script>
@endsection

@section('content')
<div id="dashboard"></div>
@endsection