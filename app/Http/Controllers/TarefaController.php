<?php

namespace App\Http\Controllers;

use App\Exports\TarefasExport;
use App\Models\Tarefa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TarefaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $tarefas = Tarefa::where('user_id', auth()->user()->id)->paginate(10);

        return view('tarefa.index', ['tarefas' => $tarefas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view("tarefa.create");
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $dados = $request->all('tarefa', 'data_limite_conclusao');
        $dados['user_id'] = auth()->user()->id;

        $tarefa = Tarefa::create($dados);

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * @param Tarefa $tarefa
     * @return Application|Factory|View
     */
    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    /**
     * @param Tarefa $tarefa
     * @return Application|Factory|View
     */
    public function edit(Tarefa $tarefa)
    {
        if (!$tarefa->user_id == auth()->user()->id) {
            return view('acesso-negado');
        }
        return view('tarefa.edit', ['tarefa' => $tarefa]);
    }

    /**
     * @param Request $request
     * @param Tarefa $tarefa
     * @return Application|Factory|View|RedirectResponse
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        if (!$tarefa->user_id == auth()->user()->id) {
            return view('acesso-negado');
        }
        $tarefa->update($request->all());
        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * @param Tarefa $tarefa
     * @return Application|Factory|View|RedirectResponse
     */
    public function destroy(Tarefa $tarefa)
    {
        if (!$tarefa->user_id == auth()->user()->id) {
            return view('acesso-negado');
        }
        $tarefa->delete();
        return redirect()->route('tarefa.index');
    }

    /**
     * @return BinaryFileResponse
     */
    public function exportacao(string $extensao)
    {
        return Excel::download(new TarefasExport, 'lista-tarefas.'.$extensao);
    }

    /**
     * @return Response
     */
    public function exportar()
    {
        $tarefas = auth()->user()->tarefas()->get();

        $pdf = PDF::loadView('tarefa.pdf', ['tarefas' => $tarefas]);

//        return $pdf->download('lista-tarefas.pdf');
        return $pdf->stream('lista-tarefas.pdf');
    }
}
