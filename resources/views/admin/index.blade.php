@extends("theme.$theme.layout")
@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-uppercase">Bienvenido, {{session()->get('usuario') ?? 'Invitado'}}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h4 class="font-weight-bold">Personas</h4>
                                    <br>
                                    <br>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                              {{--   <a href="{{route('persona')}}" class="small-box-footer">
                                    Mas información <i class="fas fa-arrow-circle-right"></i>
                                </a> --}}
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h4 class="font-weight-bold">Productos</h4>
                                    <br>
                                    <br>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-gift"></i>
                                </div>
                                {{-- <a href="{{route('producto')}}" class="small-box-footer">
                                    Más información<i class="fas fa-arrow-circle-right"></i>
                                </a> --}}
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h4 class="font-weight-bold">Habitaciones</h4>
                                    <br>
                                    <br>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-hotel"></i>
                                </div>
                                {{-- <a href="{{route('habitacion')}}" class="small-box-footer">
                                    Más información<i class="fas fa-arrow-circle-right"></i>
                                </a> --}}
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h4 class="font-weight-bold">Servicios</h4>
                                    <br>
                                    <br>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-server"></i>
                                </div>
                                {{-- <a href="{{route('servicios')}}" class="small-box-footer">
                                    Más información<i class="fas fa-arrow-circle-right"></i>
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection