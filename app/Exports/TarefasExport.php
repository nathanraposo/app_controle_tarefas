<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TarefasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return Collection
    */
    public function collection()
    {
        return auth()->user()->tarefas()->get();
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
       return [
           'Id da Tarefa',
           'Tarefa',
           'Data limite conclusão'
       ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->tarefa,
            date('d/m/y', strtotime($row->data_limite_conclusao))
        ];
    }
}
