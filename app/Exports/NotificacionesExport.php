<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NotificacionesExport implements FromCollection, WithHeadings
{
    protected $headings = [
        
    ];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->data);
    }

    /**
     * @return string
     */
    public function delimiter(): string
    {
        return ';';
    }

    /**
     * @return string
     */
    public function encoding(): string
    {
        return 'UTF-8';
    }
}
