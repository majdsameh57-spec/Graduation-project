<?php

namespace App\Exports;

use App\Models\Shop;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ShopsExport implements FromArray, WithStyles, WithTitle, WithColumnWidths
{ 
    public function array(): array
    {
        $data = [];
        // صف العنوان الكبير
        $data[] = ['قائمة المحلات والفروع', '', '', ''];
        // عناوين الأعمدة
        $data[] = [
            'اسم المحل',
            'رقم هاتف المحل',
            'موقع المحل',
            '(الفروع (موقع الفرع / رقم هاتف الفرع',
        ];
        $shops = \App\Models\Shop::with(['branches'])->get();
        foreach ($shops as $shop) {
            $branches = $shop->branches->map(function($branch) {
                $location = $branch->location ?? '';
                $phone = $branch->phone_number ?? '';
                // تحويل كل الأرقام العربية والهندية إلى أرقام إنجليزية بشكل مباشر
                $phone_en = strtr($phone, [
                    '٠'=>'0','١'=>'1','٢'=>'2','٣'=>'3','٤'=>'4','٥'=>'5','٦'=>'6','٧'=>'7','٨'=>'8','٩'=>'9',
                    '۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9',
                ]);
                return ($location ? $location : '') . ($phone_en ? ' / ' . $phone_en : '');
            })->implode(' | ');
            $data[] = [
                $shop->name,
                $shop->phone ?? '',
                $shop->description ?? '',
                $branches,
            ];
        }
        return $data;
    }


    // عنوان الورقة
    public function title(): string
    {
        return 'قائمة المحلات والفروع';
    }

    // تنسيق الأعمدة
    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 18,
            'C' => 35,
            'D' => 40,
        ];
    }

    // تنسيقات مخصصة
    public function styles(Worksheet $sheet)
    {
        // دمج الأعمدة للعنوان الكبير
        $sheet->mergeCells('A1:D1');
        // تنسيق العنوان الكبير
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '002147'], // لون أزرق غامق واضح
                'size' => 18,
            ],
            'fill' => [
                'fillType' => 'gradientLinear',
                'rotation' => 90,
                'startColor' => ['rgb' => '0047b3'],
                'endColor' => ['rgb' => '00a1ff'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        // تنسيق عناوين الأعمدة
        $sheet->getStyle('A2:D2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '002147'],
                'size' => 14,
            ],
            'fill' => [
                'fillType' => 'gradientLinear',
                'rotation' => 90,
                'startColor' => ['rgb' => 'e3f2fd'],
                'endColor' => ['rgb' => 'b6e0fe'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        // اتجاه الورقة من اليمين إلى اليسار
        $sheet->setRightToLeft(true);
        // حدود خفيفة لكل الخلايا
        $sheet->getStyle('A1:D' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'b3c6e0'],
                ],
            ],
        ]);
        // محاذاة النص يمين للعربي
        $sheet->getStyle('A2:D' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        return [];
    }
}
