<?php
require_once 'Zend/Loader/Autoloader.php';
// register auto-loader
$loader = Zend_Loader_Autoloader::getInstance();
// Create a new PDF document
$form = new Form_Export_Index();
echo $form;
if ($this->param->isPost()) {
    try {
        $pdf = new Zend_Pdf();
        $model = new Model_Khachhang();
        $khachhang = $model->getAll();
        //     var_dump($khachhang) ;
//         Zend\Search\Lucene\Analysis\Analyzer::setDefault(
//         new Zend\Search\Lucene\Analysis\Analyzer\Common\Utf8());
    
        $page1 = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $page2 = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $page3 = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        //Page created, but not included into pages list
        $width  = $page1->getWidth();
        $height = $page1->getHeight();
        //      echo $height; 842
        //      echo "width";
        //      echo $width; 595
        // Create new Style
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        $style->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
        $style->setLineWidth(3);
        $style->setLineDashingPattern(array(3, 2, 3, 4), 1.6);
        $fontH = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER);
//         $fontH = Zend_Pdf_Font::fontWithPath('.\public\font\glyphicons-halflings-regular.ttf');
        $style->setFont($fontH, 12);
    
        //     foreach ($khachhang as $data ){
        //         print_r($data['TenKhachHang']);
        //         static $page = 20;
        //         $kh = $data['TenKhachHang'];
    
        //         $page1->setStyle($style)
        //         ->drawText($kh, 50,500 + $page, $charEncoding = 'UTF-8');
        //         $page = $page + 20;
        //     }
        $page1->setStyle($style)
        ->drawText('DAI HOC BACH KHOA TP.HO CHI MINH', 180 ,800, $charEncoding = 'UTF-8');
        // define image resource
        $image = Zend_Pdf_Image::imageWithPath('./public/image/logo1.png');
        // write image to page
        $page1->drawImage($image, 240 , 668 , 360,790 );
        $diaChi = "Dia Chi: 268 Lý Thường Kiệt, Phường 9, Quận 10, TP. Hồ Chí Minh";
        $sdt = "SDT: 08 3568256";
    
        $page1->setStyle($style)
        ->drawText($diaChi, 50 ,650, $charEncoding = 'UTF-8');
        $page1->setStyle($style)
        ->drawText($sdt, 50 ,630, $charEncoding = 'UTF-8');
        $title = "THONG TIN DON XUAT";
        // Create new Style
        $styleTitle = new Zend_Pdf_Style();
        $styleTitle->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        $styleTitle->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
        $styleTitle->setLineWidth(3);
        $styleTitle->setLineDashingPattern(array(3, 2, 3, 4), 1.6);
        $fontTitle = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER);
        $styleTitle->setFont($fontTitle, 30);
    
        $page1->setStyle($styleTitle)
        ->drawText($title, 130 ,600, $charEncoding = 'UTF-8');
        // add footer text
        $page1->drawLine(80, 25, ($page2->getWidth()-10), 25);
        $page1->drawImage($image, 20, 10, ($image->getPixelWidth()), ($image->getPixelHeight()));
        $page1->setStyle($style)
        ->drawText('Copyright @HCMUT. All rights reserved.', 200, 10);
        $page1->drawLine(40, 580, ($page2->getWidth()-10), 580);
        // 25 --> 580
        // Thông tin khach hang, Get thông tin theo mã khách hàng. Đơn xuất->Mã Đơn Hàng-> Mã Khách hàng
        $postMaKH = 1234; // Dữ liệu giả.
        $modelKhachhang = new Model_Khachhang();
        $thongtinkh = $modelKhachhang->getByMakh($postMaKH);
    
        foreach ($thongtinkh as $data) {
            $tenkh = $data['TenKhachHang'];
            $diachikh = $data['DiaChi'];
            $sdtkh = $data['SoDienThoai'];
        }
    
        $page1->drawText("Ten Khach hang: " . $tenkh, 50, 560, 'UTF-8');
        $page1->drawText("Dia Chi: " . $diachikh, 50, 540, 'UTF-8');
        $page1->drawText("SO DIen Thoai: " . $sdtkh, 50, 520, 'UTF-8');
        $page1->drawLine(40, 500, ($page2->getWidth()-10), 500);
        // Thong tin don xuat
        // get by ma don xuat = 1
        $postMadx = 1;
        $modelDonXuat = new Model_Donxuat();
        $thongtindx = $modelDonXuat->getWhere($postMadx);
        foreach ($thongtindx as $data) {
            $tendx = $data['TenDonXuat'];
            $ngayxuat = $data['NgayXuat'];
        }
    
        $sometvai ="";
        $socayvai = "";
    
        $page1->drawText("Ten Don Xuat: " . $tendx, 50, 480, 'UTF-8');
        $page1->drawText("Ngay Xuat: " . $ngayxuat, 50, 460, 'UTF-8');
        $page1->drawText("Tong So Met Vai: " . $sometvai, 50, 440, 'UTF-8');
        $page1->drawText("Tong So Cay Vai: " . $socayvai, 50, 420, 'UTF-8');
        $page1->drawText("Gia Tien Moi Met Vai: ", 50, 400, 'UTF-8');
        $page1->drawLine(40, 380, ($page2->getWidth()-10), 380);
        //Thoong tin cay vai
        $page1->drawText("THONG TIN CAY VAI", 50, 360, 'UTF-8');
    
        // TH table
        $page1->drawText("Ma Cay Vai", 50, 340, 'UTF-8');
        $page1->drawText("Mau", $page1->getWidth()/3, 340, 'UTF-8');
        $page1->drawText("So Met Vai", $page1->getWidth()/3*2, 340, 'UTF-8');
        // Thoong tin cay vai dua vao thong tin ma don xuat
        // Get information flow MaDonXuat = 1;
        $modelCtp = new Model_Caythanhpham();
        $idmadx = 1; // Du lieu gia 
        $thongtinctp = $modelCtp->getByMaDX($idmadx);
        
        foreach ($thongtinctp as $data ){
//             print_r($data);
            static $page = 20;
            $mactp = $data['MaCTP'];
            $Mau = "";
            $sometvai = $data['SoMetVai'];
            $y = 340 - $page;
            if ($y > 150) {
            $page1->setStyle($style)
            ->drawText($mactp, 50,$y, $charEncoding = 'UTF-8')
            ->drawText($Mau, $page1->getWidth()/3 ,$y, $charEncoding = 'UTF-8')
            ->drawText($sometvai, $page1->getWidth()/3*2 ,$y, $charEncoding = 'UTF-8');
            $page = $page + 20;
            }
            else {
                
               static $paged = 20;
               $sy = 840 -$paged;
                $page2->setStyle($style)
                ->drawText($mactp, 50,$sy, $charEncoding = 'UTF-8')
                ->drawText($Mau, $page2->getWidth()/3 ,$sy, $charEncoding = 'UTF-8')
                ->drawText($sometvai, $page2->getWidth()/3*2 ,$sy, $charEncoding = 'UTF-8');
                $paged = $paged + 20;
            }
              
         }
    
    
    
        // $page1->drawText('example text here',100,100);
        // $page1->drawText('Dai hoc bach khoa', 100, 100);
        // $pdf->pages[] = $page2;
    
        // $page=$pdf->pages[]; // this will get reference to the first page.
    
        // $style = new Zend_Pdf_Style();
        // $style->setLineColor(new Zend_Pdf_Color_Rgb(0,0,0));
    
        // $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
    
        // $style->setFont($font,12);
    
        // $page1->setStyle($style);
    
        // $page1->drawText('example text here',100,($page1->getHeight()-100));
    
    
        // $destination1 = Zend_Pdf_Destination_Fit::create($page2);
        // $destination2 = Zend_Pdf_Destination_Fit::create($page3);
    
        // // Returns $page2 object
        // $page = $pdf->resolveDestination($destination1);
    
        // // Returns null, page 3 is not included into document yet
        // $page = $pdf->resolveDestination($destination2);
    
        // $pdf->setNamedDestination('Page2', $destination1);
        // $pdf->setNamedDestination('Page3', $destination2);
    
        // // Returns $destination2
        // $destination = $pdf->getNamedDestination('Page3');
    
        // // Returns $destination1
        // $pdf->resolveDestination(Zend_Pdf_Destination_Named::create('Page2'));
    
        // // Returns null, page 3 is not included into document yet
        // $pdf->resolveDestination(Zend_Pdf_Destination_Named::create('Page3'));
    
        // // them noi dung cho page
    
    
        // $action1 = Zend_Pdf_Action_GoTo::create(
        //     Zend_Pdf_Destination_Fit::create($page2));
        // $action2 = Zend_Pdf_Action_GoTo::create(
        //     Zend_Pdf_Destination_Fit::create($page3));
        // $action3 = Zend_Pdf_Action_GoTo::create(
        //     Zend_Pdf_Destination_Named::create('Chapter1'));
        // $action4 = Zend_Pdf_Action_GoTo::create(
        //     Zend_Pdf_Destination_Named::create('Chapter5'));
    
        // $action2->next[] = $action3;
        // $action2->next[] = $action4;
    
        // $action1->next[] = $action2;
    
        // $actionsCount = 1; // Note! Iteration doesn't include top level action and
        // // walks through children only
        // $iterator = new RecursiveIteratorIterator(
        //     $action1,
        //     RecursiveIteratorIterator::SELF_FIRST);
        // foreach ($iterator as $chainedAction) {
        //     $actionsCount++;
        // }
    
        // // Prints 'Actions in a tree: 4'
        // printf("Actions in a tree: %d\n", $actionsCount++);
    
    
    
    
        $page2->setStyle($style);
        $page2->drawLine(80, 25, ($page2->getWidth()-10), 25);
        $page2->drawImage($image, 20, 10, ($image->getPixelWidth()), ($image->getPixelHeight()));
        $page2->drawText('Copyright @HCMUT. All rights reserved.', 200, 10);

        $pdf->pages[] = $page1;
        $pdf->pages[] = $page2;
        $pdf->properties['Title'] = 'DIMOPLA-2016';
        $donxuat = "donxuat";
        $pdf->save($donxuat . '.pdf');
        // $pdf->save('./file.pdf', true);
        echo 'SUCCESS: Document saved!';
        echo '\n File luu trong thu muc Project!';
    } catch (Zend_Pdf_Exception $e) {
        die ('PDF error: ' . $e->getMessage());
    } catch (Exception $e) {
        die ('Application error: ' . $e->getMessage());
    }
    
}

// $pdfString = $pdf->render();
