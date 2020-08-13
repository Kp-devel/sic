@extends('layouts.app')

@section('content')
    <div class="contenedor-general">
        <div class="content-menu text-white">
            menu
        </div>
        <div class="content-body">
            <div class="contenedor-body pl-1">
                <nav class="navbar navbar-expand-lg navbar-transparent py-3 bg-white">
                    <div class="container-fluid">
                        <div class="navbar-wrapper d-flex">
                            <a href="#" class="icono-bars waves-effect" onclick="menu()"><i class="fa fa-bars fa-lg"></i></a>
                        </div>
                        <!--justify-content-end-->
                        <div class="justify-content-end" id="navigation">
                            <ul class="navbar-nav">
                                <li class="nav-item pt-1">
                                    <img src="{{asset('img/center.jpeg')}}" alt="" width="35px" height="35px" class=" rounded-circle border">
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- End Navbar -->
                @yield('panel-contenido')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function menu(){
            $('.content-menu').toggleClass('abrir');            
            $('.content-body').toggleClass('p-left');            
        }
    </script>
@endsection