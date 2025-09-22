<!--FORMULARIO DE EMPLEADOS-->

            <div class="row g-3">
              {{-- Nombre --}}
              <div class="col-md-6">
                <label for="Nombre" class="form-label">Nombre</label>
                <input
                  type="text"
                  class="form-control @error('Nombre') is-invalid @enderror"
                  id="Nombre"
                  name="Nombre"
                  value="{{ old('Nombre', $empleado->Nombre ?? '') }}"
                  required
                >
                @error('Nombre')
                  <div class="invalid-feedback">{{ $message }}</div>
                @else
                  <div class="form-text">Escribe el nombre(s).</div>
                @enderror
              </div>

              {{-- Apellido Paterno --}}
              <div class="col-md-6">
                <label for="ApellidoPaterno" class="form-label">Apellido Paterno</label>
                <input
                  type="text"
                  class="form-control @error('ApellidoPaterno') is-invalid @enderror"
                  id="ApellidoPaterno"
                  name="ApellidoPaterno"
                  value="{{ old('ApellidoPaterno', $empleado->ApellidoPaterno ?? '') }}"
                  required
                >
                @error('ApellidoPaterno')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Apellido Materno --}}
              <div class="col-md-6">
                <label for="ApellidoMaterno" class="form-label">Apellido Materno</label>
                <input
                  type="text"
                  class="form-control @error('ApellidoMaterno') is-invalid @enderror"
                  id="ApellidoMaterno"
                  name="ApellidoMaterno"
                  value="{{ old('ApellidoMaterno', $empleado->ApellidoMaterno ?? '') }}"
                >
                @error('ApellidoMaterno')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Correo Electrónico --}}
              <div class="col-md-6">
                <label for="CorreoElectronico" class="form-label">Correo electrónico</label>
                <input
                  type="email"
                  class="form-control @error('CorreoElectronico') is-invalid @enderror"
                  id="CorreoElectronico"
                  name="CorreoElectronico"
                  value="{{ old('CorreoElectronico', $empleado->CorreoElectronico ?? '') }}"

                  required
                >
                @error('CorreoElectronico')
                  <div class="invalid-feedback">{{ $message }}</div>
                @else
                  <div class="form-text">Ejemplo: nombre@dominio.com</div>
                @enderror
              </div>

                {{-- Fotografía (actual + cambiar) --}}
                <div class="col-md-12">
                <label for="Fotografia" class="form-label">Fotografía</label>
                    <br>


                @if (isset($empleado) && $empleado->tiene_foto)
                    <img src="{{ $empleado->foto_url }}" class="img-thumbnail mb-2"
                    style="width:160px;height:160px;object-fit:cover;" alt="Foto actual">
                @else
                    <span class="badge text-bg-secondary mb-2">Sin foto</span>
                @endif

                {{--@php
                    $rel = $empleado->Fotografia ?? null;
                    $rel = $rel ? str_replace('\\','/',$rel) : null;
                    $ok  = $rel && \Storage::disk('public')->exists($rel);
                    $url = $ok ? \Storage::url($rel) : null;
                @endphp

                @if ($url)
                    <img src="{{ asset('storage/'.$empleado->Fotografia) }}" alt="Foto actual"
                        class="img-thumbnail mb-2"
                        style="width:160px;height:160px;object-fit:cover;">
                @else
                    <span class="badge text-bg-secondary mb-2">Sin foto</span>
                @endif--}}

                <input
                    type="file"
                    class="form-control @error('Fotografia') is-invalid @enderror"
                    id="Fotografia"
                    name="Fotografia"
                    accept="image/*"
                >
                @error('Fotografia')
                    <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <div class="form-text">
                    @if (isset($empleado) && $empleado->tiene_foto)
                        Si no seleccionas archivo, se conserva la foto actual.
                    @else
                        Formatos recomendados: JPG/PNG, &lt; 4 MB.
                    @endif
                    </div>
                @enderror
                </div>

            <div class="d-flex gap-2 mt-4">
              <button type="submit" class="btn btn-primary">
                Guardar
              </button>
              <a href="{{ route('Empleado.index') }}" class="btn btn-outline-secondary">
                Cancelar
              </a>
            </div>