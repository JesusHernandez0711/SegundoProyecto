<!--CREAR EMPLEADOS-->

{{-- resources/views/Empleado/Create.blade.php --}}
@extends('layouts.application')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm">
        <div class="card-header">
          <h5 class="mb-0">Crear Nuevo Empleado</h5>
        </div>

        <div class="card-body">
          {{-- Mensaje de validación general --}}
          @if ($errors->any())
            <div class="alert alert-danger">
              <strong>Revisa los campos:</strong>
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('Empleado.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            
            @include('CRUD-Empleado.Form')


          </form>
        </div> {{-- card-body --}}
      </div>
    </div>
  </div>
</div>
@endsection
