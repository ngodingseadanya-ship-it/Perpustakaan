<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function hitung_denda($tgl_kembali)
{
    $ci =& get_instance();
    $ci->load->model('Pengaturan_model');

    $status = $ci->Pengaturan_model->get('denda_status');
    if($status != 'on') return 0;

    $perhari = $ci->Pengaturan_model->get('denda_per_hari');

    $hari_telat = floor(
        (strtotime(date('Y-m-d')) - strtotime($tgl_kembali)) / 86400
    );

    return $hari_telat > 0 ? $hari_telat * $perhari : 0;
}