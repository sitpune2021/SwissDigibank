<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Response;

class CsvExportHelper
{
    public static function downloadCsv(array $headers, array $data, string $filename = 'export.csv')
    {
        $callback = function () use ($headers, $data) {
            $file = fopen('php://output', 'w');
            // Add headers
            fputcsv($file, $headers);
            // Add rows
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
        ]);
    }
}
