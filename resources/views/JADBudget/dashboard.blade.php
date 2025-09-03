@extends('JADBudget.components.master')

@section('style')
<link rel="stylesheet" href="{{ mix('css/JADBudget/index.css') }}">
<link rel="stylesheet" href="{{ mix('css/JADBudget/dashboard.css') }}">
@endsection

@section('script')
<script src="{{ mix('js/JADBudget/dashboard.js') }}" defer></script>
@endsection

@section('content')
<div id="dashboard"></div>
@endsection