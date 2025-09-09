<?php

namespace App\Http\Controllers;

use App\Models\Intent;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Survey;
use App\Mail\SurveyResultMail;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
class ImportController extends Controller
{
    public function checkExcel(Request $request)
    {
        $request->validate([
            'survey_id' => 'required|integer',
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $surveyId = $request->input('survey_id');

        // Lấy keyword & prefecture của survey
        $survey = Survey::findOrFail($surveyId);

        $keywords = !empty($survey->keyword)
            ? array_map('trim', explode(',', $survey->keyword))
            : [];

        $prefectures = !empty($survey->prefectures)
            ? array_map('trim', explode(',', $survey->prefectures))
            : [];

        // Load Excel
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $matchedEmails = [];

        foreach ($rows as $index => $row) {
            if ($index === 0) continue;

            $name = $row[0] ?? '';
            $email = $row[2] ?? '';
            $address = $row[4] ?? '';
            $nameMatch = empty($keywords) || collect($keywords)->contains(function ($kw) use ($name) {
                    return str_contains(mb_strtolower($name), mb_strtolower($kw));
                });
            $addressMatch = empty($prefectures) || collect($prefectures)->contains(function ($pf) use ($address) {
                    return str_contains(mb_strtolower($address), mb_strtolower($pf));
                });

            if ($nameMatch || $addressMatch) {
                $matchedEmails[] = [
                    'email' => $email,
                ];
            }
        }
        foreach ($matchedEmails as $item) {
            $emailAddress = $item['email'] ?? null;

            if ($emailAddress && filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
                try {
                    Mail::to($emailAddress)->send(new SurveyResultMail($survey));
                } catch (\Throwable $e) {
                    // Bỏ qua nếu lỗi
                }
            }
        }
        $sendCount = count($matchedEmails);
        $survey->sent_count = $sendCount;
        $survey->save();
        return response()->json([
            'results' => $matchedEmails,
            'total' => count($matchedEmails)
        ]);
    }
    public function previewImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        $spreadsheet = IOFactory::load($request->file('file')->getPathname());
        $rows = $spreadsheet->getActiveSheet()->toArray();

        $total = max(count($rows) - 1, 0);

        return response()->json([
            'total' => $total
        ]);
    }
    public function export()
    {
        $intents = Intent::with('answers')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('List_of_recipients');

        $headers = ['Contact_name','Company_name', 'Email', 'Phone_number', 'response_text'];
        $sheet->fromArray($headers, null, 'A1');
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9E1F2']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ];
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

        $row = 2;
        foreach ($intents as $intent) {
            foreach ($intent->answers as $answer) {
                $sheet->setCellValue('A' . $row, $intent->intent_name);
                $sheet->setCellValue('B' . $row, $answer->company_name ?? '');
                $sheet->setCellValue('C' . $row, $answer->email ?? '');
                $sheet->setCellValue('D' . $row, $answer->phone_number ?? '');
                $sheet->setCellValue('E' . $row, $answer->response_text ?? '');
                $row++;
            }
        }


        $tempPath = tempnam(sys_get_temp_dir(), 'recipients_') . '.xlsx';

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($tempPath);

        return response()->download($tempPath, 'List_of_recipients.xlsx')->deleteFileAfterSend(true);
    }

}
