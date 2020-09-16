@extends('layouts.app')

@section('content')
    <panel-gestor :userlogeado="'{!! ( auth()->user()->emp_nom ?? '' ) !!}'" :idlogeado="'{!! ( auth()->user()->emp_id ?? '' ) !!}'"/>
@endsection
