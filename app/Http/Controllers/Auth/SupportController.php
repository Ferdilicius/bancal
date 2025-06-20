<?
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        return view('bancal.contacto');
    }
}

public function enviar(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email',
        'tipo' => 'required',
        'prioridad' => 'required|in:low,medium,high',
        'mensaje' => 'required|min:20',
    ]);

    // Aquí podrías guardar en base de datos, enviar un correo, etc.

    return redirect()->back()->with('success', 'Tu consulta fue enviada correctamente.');
}
