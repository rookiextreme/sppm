<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ExportExcel extends CWidget {

    public $type;
    public $result;

    public function run() 
    {
        if ($this->result) 
        {
            switch($this->type)
            {
                case 2 :
                        $this->lampiranJKRPKP112();
                        break;
                case 4 :
                        $this->lampiranJKRPKP114();
                        break;
            }
        }
    }

    private function lampiranJKRPKP114() 
    {
        /** Include PHPExcel */
        Yii::import('application.vendors.PHPExcel.Classes.*');
        require_once 'PHPExcel.php';

        $start_row = $row = 5; //start from row  
        //total row record + start row to fill record (excel view)
        $total_row = $start_row + count($this->result);

        // Create new PHPExcel object        
        $e = new PHPExcel();

        // Set document properties        
        $e->getProperties()->setCreator("Sistem Aduan JKR")
                ->setLastModifiedBy('Web Aduan')
                ->setTitle("Laporan Aduan ")
                ->setSubject("xx")
                ->setCategory('Category')
                ->setKeywords('Keyword')
                ->setDescription('Laporan Aduan');

        // Add some data        
        $e->setActiveSheetIndex(0)
                ->setCellValue('A1', 'LAPORAN DAFTAR MAKLUMBALAS PELANGGAN (JKR.PK(P).11-4)')
                ->setCellValue('A3', 'Bil')
                ->setCellValue('B3', 'Jabatan Pelanggan')
                ->setCellValue('C3', 'Maklumbalas Pelanggan')
                ->setCellValue('C4', 'Bilangan Aduan')
                ->setCellValue('D4', 'Dasar')
                ->setCellValue('E4', 'Rekabentuk')
                ->setCellValue('F4', 'Pembinaan')
                ->setCellValue('G4', 'Senggara')
                ->setCellValue('H4', 'Salahguna')
                ->setCellValue('I4', 'Tidak Berkaitan')
                ->setCellValue('J3', 'Tindakan Pembetulan')
                ->setCellValue('J4', 'Siap')
                ->setCellValue('K4', 'Belum Siap')
                ->setCellValue('L4', 'Peratusan Siap')
                ->setCellValue('M3', 'Catatan');

        $e->getActiveSheet()
                ->mergeCells('A3:A4')
                ->mergeCells('B3:B4')
                ->mergeCells('C3:I3')
                ->mergeCells('J3:L3')
                ->mergeCells('M3:M4');

        $e->getActiveSheet()
                ->getColumnDimension('B')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('C')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('D')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('E')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('F')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('G')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('H')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('I')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('J')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('K')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('L')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('M')
                ->setAutoSize(true);

        $styleArr = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => 'FFFFFF')
                 ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),                
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '46a2d1')
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ),
                ),
        );
        
        $e->getActiveSheet()->getStyle('A3:' .
                        $e->getActiveSheet()->getHighestColumn() . 
                        $e->getActiveSheet()->getHighestRow()
                )->applyFromArray($styleArr);

        $style_center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
        );
        $style_left = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
            ),
        );
        
        $e->getActiveSheet()->getStyle('C3:C' . $total_row)->applyFromArray($style_center);
        $e->getActiveSheet()->getStyle('D3:D' . $total_row)->applyFromArray($style_center);
        $e->getActiveSheet()->getStyle('E3:E' . $total_row)->applyFromArray($style_center);
        $e->getActiveSheet()->getStyle('F1')->applyFromArray($style_center);
        $e->getActiveSheet()->getStyle('F2:I2')->applyFromArray($style_center);
        $e->getActiveSheet()->getStyle('F3:F' . $total_row)->applyFromArray($style_center);
        $e->getActiveSheet()->getStyle('G3:G' . $total_row)->applyFromArray($style_center);
        $e->getActiveSheet()->getStyle('H3:H' . $total_row)->applyFromArray($style_center);
        $e->getActiveSheet()->getStyle('I3:I' . $total_row)->applyFromArray($style_center);
        $e->getActiveSheet()->getStyle('J3:J' . $total_row)->applyFromArray($style_center);
        $e->getActiveSheet()->getStyle('K3:K' . $total_row)->applyFromArray($style_center);
        $e->getActiveSheet()->getStyle('D3:D' . $total_row)->getNumberFormat()
                ->setFormatCode('0');

        foreach ($this->result as $item) {
            $siap = Aduan::model()->count(array(
                        'condition'=>'kod_daerah=:kod and kod_status=:kods',
                        'params'=>array(
                            ':kod'=>$item->kod_daerah,
                            ':kods'=>3,
                        ),
                    ));
            $xsiap = Aduan::model()->count(array(
                        'condition'=>'kod_daerah = :kod and kod_status <>:kods',
                        'params'=>array(
                            ':kod'=>$item->kod_daerah,
                            ':kods'=>3,
                        ),
                    ));
           
            $peratus = number_format(($siap/($siap+$xsiap)*100),2);
            $totalAduan = $siap + $xsiap;
            
            $e->getActiveSheet()
                    ->setCellValue('A' . $row, ++$counter)
                    ->setCellValue('B' . $row, $item->negeri->negeri.' / '.$item->daerah->nama_daerah)
                    ->setCellValue('C' . $row, $totalAduan);
            $arrayCell = array('D','E','F','G','H','I');  
            for($i=1;$i<7;$i++) {
                $i==6?$i+1:$i;
                $e->getActiveSheet()->setCellValue($arrayCell[$i-1] . $row, 
                                            Aduan::model()->count(array(
                                                'condition'=>'kod_daerah =:kod and kod_berkaitan =:kodd',
                                                'params'=>array(
                                                            ':kod'=>$item->kod_daerah,
                                                            ':kodd'=>$i,
                                                ),
                                            )));
            }
                        
            $e->getActiveSheet()
                    ->setCellValue('J' . $row, $siap)
                    ->setCellValue('K' . $row, $Xsiap)
                    ->setCellValue('L' . $row, $peratus)
                    ->setCellValue('M' . $row, $item->ulasan);
            $row += 1;
        }
        // Rename worksheet
        //echo date('H:i:s'), " Rename worksheet", EOL;
        $e->getActiveSheet()->setTitle('Data Penilaian');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $e->setActiveSheetIndex(0);

        // Save Excel 2007 file        
        $objWriter = PHPExcel_IOFactory::createWriter($e, 'Excel2007');

        //$objWriter->save('php://output');
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        //header('Location:'.Yii::app()->request->baseUrl.'/protected/widgets/WaranDetail.xls');
        // We'll be outputting an excel file
        //ob_flush(); //this will clean the output buffer
        header("Content-type: application/vnd.ms-excel");
        // It will be called file.xls
        header('Content-Disposition: attachment; filename="Lampiran.xls"');
        //header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    private function lampiranJKRPKP112() 
    {
        /** Include PHPExcel */
        Yii::import('application.vendors.PHPExcel.Classes.*');
        require_once 'PHPExcel.php';

        $start_row = $row = 5; //start from row  
        //total row record + start row to fill record (excel view)
        $total_row = $start_row + count($this->result);

        // Create new PHPExcel object        
        $e = new PHPExcel();

        // Set document properties        
        $e->getProperties()->setCreator("Sistem Aduan JKR")
                ->setLastModifiedBy('Web Aduan')
                ->setTitle("Laporan Aduan ")
                ->setSubject("xx")
                ->setCategory('Category')
                ->setKeywords('Keyword')
                ->setDescription('Laporan Aduan');

        // Add some data        
        $e->setActiveSheetIndex(0)
                ->setCellValue('A1', 'LAPORAN DAFTAR MAKLUMBALAS PELANGGAN (JKR.PK(P).11-2)')
                ->setCellValue('A3', 'Bil')
                ->setCellValue('B3', 'No Aduan')
                ->setCellValue('C3', 'Maklumbalas')
                ->setCellValue('C4', 'Tarikh Aduan')
                ->setCellValue('D4', 'Butiran Maklumbalas')
                ->setCellValue('E4', 'Pelapor dan Alamat')
                ->setCellValue('F3', 'Nama Penerima ')
                ->setCellValue('G3', 'Tindakan Jabatan')
                ->setCellValue('G4', 'Tarikh Arahan')
                ->setCellValue('H4', 'Pegawai Bertugas')
                ->setCellValue('I4', 'Laporan Siasatan dan Tindakan')
                ->setCellValue('J4', 'Tarikh Jawapan')
                ->setCellValue('K3', 'Catatan');

        $e->getActiveSheet()
                ->mergeCells('A1:K1')
                ->mergeCells('A3:A4')
                ->mergeCells('B3:B4')
                ->mergeCells('C3:E3')   //col maklumbalas
                ->mergeCells('F3:F4')   //col nama penerima
                ->mergeCells('G3:J3')   //col tindakan jabatan
                ->mergeCells('K3:K4');  //catatan

        $e->getActiveSheet()
                ->getColumnDimension('B')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('C')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('D')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('E')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('F')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('G')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('H')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('I')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('J')
                ->setAutoSize(true);
        $e->getActiveSheet()
                ->getColumnDimension('K')
                ->setAutoSize(true);
        
        $styleArr = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => 'FFFFFF')
                 ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),                
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '46a2d1')
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ),
                ),
        );
        
        $e->getActiveSheet()->getStyle('A3:' .
                        $e->getActiveSheet()->getHighestColumn() . 
                        $e->getActiveSheet()->getHighestRow()
                )->applyFromArray($styleArr);
        
//        $styleArray = array(
//            'font' => array(
//                'bold' => true,
////                'color' => array('rgb' => 'FFFFFF')
//            ),
//            'alignment' => array(
//                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),
//            'borders' => array(
//                'bottom' => array(
//                    'style' => PHPExcel_Style_Border::BORDER_THIN,
//                ),
//            ),
//            'fill' => array(
//                'type' => PHPExcel_Style_Fill::FILL_SOLID,
////                'color' => array('rgb' => '46a2d1')
//            ),
//        );
//        $e->getActiveSheet()->getStyle('A3:J3')
//                ->applyFromArray($styleArray);
//
//        $style_center = array(
//            'alignment' => array(
//                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
//            ),
//        );
//        $style_left = array(
//            'alignment' => array(
//                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
//            ),
//        );
//
//        $e->getActiveSheet()->getStyle('H1')->applyFromArray($style_center);
//        $e->getActiveSheet()->getStyle('F3')->applyFromArray($style_center);
//        $e->getActiveSheet()->getStyle('F4:I4')->applyFromArray($style_center);
//        $e->getActiveSheet()->getStyle('F5:F' . $total_row)->applyFromArray($style_center);
//        $e->getActiveSheet()->getStyle('G5:G' . $total_row)->applyFromArray($style_center);
//        $e->getActiveSheet()->getStyle('H5:H' . $total_row)->applyFromArray($style_left);
//        $e->getActiveSheet()->getStyle('I5:I' . $total_row)->applyFromArray($style_center);
//        $e->getActiveSheet()->getStyle('D5:D' . $total_row)->getNumberFormat()
//                ->setFormatCode('0');

        foreach ($this->result as $item) {
            $e->getActiveSheet()
                    ->setCellValue('A' . $row, ++$counter)
                    ->setCellValue('B' . $row, $item->id.$item->lsaluran->nama)
                    ->setCellValue('C' . $row, Yii::app()->dateFormatter->format("dd-MM-yyyy",strtotime($item->tkh_daftar)))
                    ->setCellValue('D' . $row, $item->perkara)
                    ->setCellValue('E' . $row, $item->nama. ',' .$adu->alamat_pengadu)
                    ->setCellValue('F' . $row, $item->pegawai->nama)
                    ->setCellValue('G' . $row, Yii::app()->dateFormatter->format("dd-MM-yyyy",strtotime($item->tkh_agih)))
                    ->setCellValue('H' . $row, $item->pegawai->nama)
                    ->setCellValue('I' . $row, $item->hasil_siasatan)
                    ->setCellValue('J' . $row, Yii::app()->dateFormatter->format("dd-MM-yyyy",strtotime($item->tkh_tindakan)))
                    ->setCellValue('K' . $row, $item->ulasan);
            $row += 1;
        }
        // Rename worksheet
        //echo date('H:i:s'), " Rename worksheet", EOL;
        $e->getActiveSheet()->setTitle('Data Penilaian');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $e->setActiveSheetIndex(0);

        // Save Excel 2007 file        
        $objWriter = PHPExcel_IOFactory::createWriter($e, 'Excel2007');

        //$objWriter->save('php://output');
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        //header('Location:'.Yii::app()->request->baseUrl.'/protected/widgets/WaranDetail.xls');
        // We'll be outputting an excel file
        //ob_flush(); //this will clean the output buffer
        header("Content-type: application/vnd.ms-excel");
        // It will be called file.xls
        header('Content-Disposition: attachment; filename="Lampiran.xls"');
        //header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
}
?>