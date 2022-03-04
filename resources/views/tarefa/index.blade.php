@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Tarefas
                            </div>
                            <div class="col-6">
                                <div class="float-end">
                                    <a href="{{route('tarefa.create')}}" class="mr-3">Novo</a>
                                    <a href="{{route('tarefa.exportacao', ['extensao' => 'xlsx'])}}">XLSX</a>
                                    <a href="{{route('tarefa.exportacao', ['extensao' => 'csv'])}}">CSV</a>
                                    <a href="{{route('tarefa.exportar')}}" target="_blank">PDF</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tarefa</th>
                                <th scope="col">Data Limite Conclusão</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tarefas as $tarefa)
                                <tr>
                                    <th scope="row">{{$tarefa['id']}}</th>
                                    <td>{{$tarefa['tarefa']}}</td>
                                    <td>{{date('d/m/y', strtotime($tarefa['data_limite_conclusao']))}}</td>
                                    <td><a href="{{route('tarefa.edit', $tarefa['id'])}}">Editar</a></td>
                                    <td>
                                        <form id="form_{{$tarefa['id']}}" method="post"
                                              action="{{route('tarefa.destroy', ['tarefa' => $tarefa])}}">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                        <a href="#"
                                           onclick="document.getElementById('form_{{$tarefa['id']}}').submit()">Excluir</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <nav>
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link"
                                                         href="{{$tarefas->previousPageUrl()}}">Voltar</a></li>
                                @for($index = 1; $index <= $tarefas->lastPage(); $index++)
                                    <li class="page-item {{$tarefas->currentPage() == $index ? 'active' : ''}}">
                                        <a class="page-link" href="{{$tarefas->url($index)}}">{{$index}}</a>
                                    </li>
                                @endfor
                                <li class="page-item"><a class="page-link"
                                                         href="{{$tarefas->nextPageUrl()}}">Avançar</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
