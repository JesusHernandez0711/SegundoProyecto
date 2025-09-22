<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- agrega esta línea


class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Datos['Empleados']=Empleado::paginate(5);
        return view('CRUD-Empleado.Index', $Datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('CRUD-Empleado.Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida (ajusta reglas si gustas)
        $reglas = [
            'Nombre'            => ['required','string','max:100'],
            'ApellidoPaterno'   => ['required','string','max:100'],
            'ApellidoMaterno'   => ['required','string','max:100'],
            'CorreoElectronico' => ['required','email','max:150'],
            'Fotografia'        => ['required','image','max:4096'],
        ];

        $mensaje = [
            'required'=>'El :attribute es requerido',
            'Fotografia.required'=>'La fotografia es requerida'
        ];

        // 1) Valida: si falta la foto o algún campo, regresa a la vista con errores
        $data = $request->validate($reglas, $mensaje);

        // 2) Guarda el archivo físico y pon la ruta en $data['Fotografia']
        $data['Fotografia'] = $request->file('Fotografia')->store('uploads', 'public');

        // 3) Inserta usando fillable (guarda TODOS los campos + ruta de la foto)
        Empleado::create($data);

        return redirect()
            ->route('Empleado.index')
            ->with('status', 'Empleado guardado correctamente.');

        /*@$this->valide($request,$reglas,$mensaje);

        //$DatosEmpleados = $request->all();
        $DatosEmpleados = $request->except('_token');

        if($request->hasfile('Fotografia')){
            $DatosEmpleados['Fotografia']=$request->file('Fotografia')->store('uploads','public');
        }

        Empleado::insert($DatosEmpleados);
                // 4) Redirigir al index con flash message
                return redirect()
                    ->route('Empleado.index')
                    ->with('status', 'Empleado guardado correctamente.');
            //return response()->json($DatosEmpleados);*/
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        // Busca el empleado
        $empleado = Empleado::findOrFail($id);
        return view('CRUD-Empleado.Edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        /*$DatosEmpleados = $request->except(['_token', '_method']);
        Empleado::where('id','=',$id)->update($DatosEmpleados);

        $empleado=Empleado::findOrFail($id);
        return view('CRUD-Empleado.Edit', compact('empleado'));*/
            $empleado = Empleado::findOrFail($id);

        // Valida (ajusta reglas si gustas)
        $data = $request->validate([
            'Nombre'            => ['required','string','max:100'],
            'ApellidoPaterno'   => ['required','string','max:100'],
            'ApellidoMaterno'   => ['required','string','max:100'],
            'CorreoElectronico' => ['required','email','max:150'],
            'Fotografia'        => ['nullable','image','max:4096'],
        ]);

        // Si subieron una nueva foto, borra la anterior y guarda la nueva
        if ($request->hasFile('Fotografia')) {
            if (!empty($empleado->Fotografia)) {
                Storage::disk('public')->delete($empleado->Fotografia);
            }
            $data['Fotografia'] = $request->file('Fotografia')->store('uploads', 'public'); // guarda ruta relativa
        }

        $empleado->update($data);

        return redirect()
            ->route('Empleado.index')
            ->with('status', 'Empleado actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        // Busca el empleado
        $empleado = Empleado::findOrFail($id);

        /*if (! $empleado) {
            return redirect()
                ->route('Empleado.index')
                ->with('status', 'El empleado ya no existe.');
        }*/

        // Si hay fotografía guardada en storage/app/public, elimínala
        if (!empty($empleado->Fotografia)) {
            Storage::disk('public')->delete($empleado->Fotografia);
        }

        Empleado::destroy($id);
        return redirect()->route('Empleado.index')
        ->with('status', 'Empleado eliminado correctamente.');
    }
}
