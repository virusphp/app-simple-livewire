<?php

function labelStatus($nilai)
{
    if ($nilai == 1) {
        $statusBadge =  '<span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Aktif</span>';
    } else {
        $statusBadge =  '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">Non Aktif</span>';
    }

    return $statusBadge;
}

function labelCopy($nilai)
{
    return '<button type="button" id="copy" data-copy="' . $nilai . '"  class="btn btn-sm btn-outline-info" data-coreui-toggle="tooltip" data-coreui-placement="top" title="klik untuk copy">' . $nilai . '</button>';
}

function labelCopySuccess($nilai)
{
    return '<button id="no-shipping" class="btn btn-sm btn-outline-success" data-coreui-toggle="tooltip" data-coreui-placement="top" title="klik untuk tracking">' . $nilai . '</button>';
}

function labelDetail($nilai)
{
    return '<button id="detail" data-id="' . $nilai . '"  class="btn btn-sm btn-outline-warning" data-coreui-toggle="tooltip" data-coreui-placement="top" title="klik untuk detail">' . $nilai . '</button>';
}

function rupiah($nilai)
{
    return number_format($nilai, 0, ',', '.');
}

function statusRole($nilai)
{
    return '<span id="copy" data-copy="' . $nilai . '"  class="badge badge-info">' . $nilai . '</span>';
}

function statusActive($nilai)
{
    return $nilai == 1 ? labelCopySuccess("Active") : labelDetail("Not Active");
}

function ribuan($nilai)
{
    return number_format($nilai, "2", ",", ".");
}

function statusApproved($nilai)
{
    if ($nilai == 1) {
        return '<span id="approved" class="badge badge-success">Diterima</span>';
    } else {
        return '<span id="approved" class="badge badge-danger">Pending</span>';
    }
}

function tanggalFull($nilai)
{
    return date('d-M-Y H:i:s', strtotime($nilai));
}

function tanggalIndo($nilai)
{
    return date('d-m-Y', strtotime($nilai));
}

function tanggal($nilai)
{
    return date('Y-m-d', strtotime($nilai));
}

function tanggalIndoFull($nilai)
{
    return date('d-m-Y H:i:s', strtotime($nilai));
}

function numberOnly($nilai)
{
    return preg_replace("/[^0-9]/", "", $nilai);
}

function getTahunFormat($nilai): int
{
    $tahun = explode("-", $nilai);
    return $tahun[1];
}

function getBulanFormat($nilai): int
{
    $tahun = explode("-", $nilai);
    return $tahun[0];
}

function getBulan($nilai)
{
    return date('m', strtotime($nilai));
}

function getTahun($nilai)
{
    return date('Y', strtotime($nilai));
}
