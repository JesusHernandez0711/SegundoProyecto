<!--INDEX DE EMPLEADOS-->

@extends('layouts.application')

@section('content')
<div class="container py-4">

  {{-- Encabezado + acción rápida --}}
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Empleados</h3>
    <a href="{{ route('Empleado.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg"></i> Nuevo
    </a>
  </div>

  {{-- Alert de estado (opcional) --}}
  @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width:80px">#</th>
            <th style="width:140px">Fotografía</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th style="width:220px" class="text-end">Acciones</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($Empleados as $e)
            <tr>
              <td class="text-muted">{{ $e->id }}</td>
              <td style="width:140px">
                @if ($e->tiene_foto)
                  <img src="{{ $e->foto_url }}" class="img-thumbnail"
                      style="width:100px;height:100px;object-fit:cover;" alt="Foto">
                @else
                  <span class="badge text-bg-secondary">Sin foto</span>
                @endif
              </td>
              {{--<td style="width:140px">                
                @php
                  $rel = $e->Fotografia ?? null;          // ej: "uploads/archivo.jpg"
                  $ok  = $rel && \Storage::disk('public')->exists($rel);
                  $url = $ok ? asset('storage/'.$rel) : null;
                @endphp

                @if ($url)
                  <img src="{{ asset('storage/'.$e->Fotografia) }}" alt="Foto actual"
                      class="img-thumbnail"
                      style="width:100px;height:100px;object-fit:cover;">
                @else
                  <span class="badge text-bg-secondary">Sin foto</span>
                @endif
              </td>--}}
              
              <td>
                <div class="fw-semibold">
                  {{ $e->Nombre }} {{ $e->ApellidoPaterno }} {{ $e->ApellidoMaterno }}
                </div>
                <div class="small text-muted">Alta: {{ optional($e->created_at)->format('d/m/Y') }}</div>
              </td>
              <td>
                @if(!empty($e->CorreoElectronico))
                  <a href="mailto:{{ $e->CorreoElectronico }}">{{ $e->CorreoElectronico }}</a>
                @else
                  <span class="text-muted small">—</span>
                @endif
              </td>
              <td class="text-end">
                <div class="btn-group">
                  <!--<a class="btn btn-sm btn-outline-secondary" href="{{ route('Empleado.show', $e) }}">Ver</a>-->
                  <a class="btn btn-sm btn-outline-primary" href="{{ route('Empleado.edit', $e) }}">Editar</a>
                  <form action="{{ route('Empleado.destroy', $e) }}" method="POST" class="ms-1" onsubmit="return confirm('¿Eliminar empleado?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" type="submit">Eliminar</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-5">
                <div class="text-muted">No hay empleados registrados.</div>
                <a href="{{ route('Empleado.create') }}" class="btn btn-primary mt-2">Crear empleado</a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      
    </div>

    {{-- Paginación --}}
    <div class="card-footer d-flex justify-content-between align-items-center">
      <div class="small text-muted">
        @if($Empleados->total())
          Mostrando {{ $Empleados->firstItem() }}–{{ $Empleados->lastItem() }} de {{ $Empleados->total() }}
        @endif
      </div>
      <div>
        {{ $Empleados->onEachSide(1)->links() }}
      </div>
    </div>
  </div>
</div>
@endsection