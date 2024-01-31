<?php

namespace App\Exports;


use App\Models\Products;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Products::all([
            'product_num_ceap',
            'product_num_intern',
            'product_name',
            'product_start',
            'product_end',
            'created_at',
            'updated_at'
        ]);
    }

    public function headings(): array {
        return [
            'Numero CEAP',
            'Numero interno',
            'Nome prodotto',
            'Data di inizio validità',
            'Data di fine validità',
            'Data di creazione',
            'Data ultima modifica'
        ];
    }

    public function map($row): array {
        return [
            $row->product_num_ceap,
            $row->product_num_intern,
            $row->product_name,
            $row->product_start,
            $row->product_end,
            $row->created_at,
            $row->updated_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f00']],
        ]);
    }
}
