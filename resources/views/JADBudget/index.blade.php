@extends('JADBudget.components.master')

@section('style')
<link rel="stylesheet" href="{{ mix('css/JADBudget/index.css') }}">
@endsection

@section('script')
<script src="{{ mix('js/JADBudget/index.js') }}" defer></script>
@endsection

@section('content')
<div id="loginContainer"></div>
@endsection