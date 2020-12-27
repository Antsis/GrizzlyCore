@extends('common.layout')

@section('maintext')

    @include('common._reglogin')

@endsection

@section('js')
 {{-- <script src="{{asset('static/js/reglogin.js') }}"></script> --}} 
    <script src="{{ mix('/js/user.js') }}"></script>

@endsection