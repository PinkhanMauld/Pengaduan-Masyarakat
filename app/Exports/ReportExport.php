<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Report::with([
            'user',
            'response',
            'response.staff',
            'response.staff.staffprovince',
            'response.response_progress',
            'user.staffprovince',
        ])->when($this->startDate && $this->endDate, function ($query) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        })->get();
    }

    public function headings(): array
    {
        return [
            "Email Pelapor",
            "Dilaporkan Pada Tanggal",
            "Deskripsi Pengaduan",
            "URL Gambar",
            "Lokasi",
            "Jumlah Voting",
            "Status Pengaduan",
            "Progres Tanggapan",
            "Staff Terkait"
        ];
    }
    public function map($item): array
    {
        $responseStatus = optional($item->response)->response_status ?? 'Tidak Diketahui';

        $historiessString = 'Tidak Ada Progres';
        if ($item->response && $item->response->response_progress) {
            $historiesArray = $item->response->response_progress;

            $historiessString = '';
            foreach ($historiesArray as $history) {
                if (isset($history->histories)) {
                    $historiesNote = $history->histories;
                    if (is_string($historiesNote)) {
                        $decodedHistories = json_decode($historiesNote, true);
                        if (is_array($decodedHistories)) {
                            $historiesNote = implode('; ', $decodedHistories);
                        }
                    }
                    $historiessString .= $historiesNote . '; ';
                }
            }

            $historiessString = rtrim($historiessString, '; ');
        }

        $locationsArray = [];

        if (is_string($item->province) && !empty($item->province)) {
            $province = json_decode($item->province, true);
            if (is_array($province) && isset($province['name'])) {
                $locationsArray[] = $province['name'];
            } else {
                $locationsArray[] = $item->province;
            }
        }

        if (is_string($item->regency) && !empty($item->regency)) {
            $regency = json_decode($item->regency, true);
            if (is_array($regency) && isset($regency['name'])) {
                $locationsArray[] = $regency['name'];
            } else {
                $locationsArray[] = $item->regency;
            }
        }
        if (is_string($item->subdistrict) && !empty($item->subdistrict)) {
            $subdistrict = json_decode($item->subdistrict, true);
            if (is_array($subdistrict) && isset($subdistrict['name'])) {
                $locationsArray[] = $subdistrict['name'];
            } else {
                $locationsArray[] = $item->subdistrict;
            }
        }

        if (is_string($item->village) && !empty($item->village)) {
            $village = json_decode($item->village, true);
            if (is_array($village) && isset($village['name'])) {
                $locationsArray[] = $village['name'];
            } else {
                $locationsArray[] = $item->village;
            }
    }

    $locationsString = !empty($locationsArray) ? implode(', '. $locationsArray) : 'Lokasi tidak tersedia';

    $votingCount = 0;
    if ($item->voting) {
        if (is_array($item->voting)) {
            $votingCount = count($item->voting);
        } elseif (is_string($item->voting)) {
            $votingArray = json_decode($item->voting, true);
            if (is_array($votingArray)) {
                $votingCount = count($votingArray);
            }
        }
    }

    $staffName = $item->response->staff->email ?? 'Tidak ada';

    return [
        optional($item->user)->email ?? 'Email Tidak Tersedia',
        $item->created_at->translatedFormat('d F Y H:i'),
        $item->description,
        url('storage/' . $item->image),
        $locationsString,
        $votingCount,
        $responseStatus,
        $historiessString,
        $staffName
    ];
}
}