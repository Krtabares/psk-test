<?php

namespace App\Pdf;

use App\Repos\EmpresaRepo;
use Dompdf\Options;
use Dompdf\Dompdf;

class EmpresaReport{

    public static function generate(array $empresas){
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $html = '<h1>Reporte de Empresas</h1> <table border="1" cellpadding="5" cellspacing="0">';
        $html .= '<tr><th>ID</th><th>RIF</th><th>Razón Social</th><th>Dirección</th><th>Teléfono</th></tr>';
        foreach($empresas as $e){
            $html .= '<tr>';
            $html .= '<td>'.$e['id_empresa'].'</td>';
            $html .= '<td>'.$e['rif'].'</td>';
            $html .= '<td>'.$e['razon_social'].'</td>';
            $html .= '<td>'.$e['direccion'].'</td>';
            $html .= '<td>'.$e['telefono'].'</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream('empresas_report.pdf', ['Attachment' => false]);
    }

}