@extends('layouts.app')

@section('content')
    <panel-gestor :userlogeado="'{!! ( auth()->user()->emp_nom ?? '' ) !!}'"/>
@endsection
