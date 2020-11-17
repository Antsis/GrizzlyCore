@extends('common.layout')

@section('maintext')
@include('common.reglogin')

@endsection

@section('js')
<script src="{{asset('static/js/reglogin.js') }}"></script>
@endsection