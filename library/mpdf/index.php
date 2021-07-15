<?php
require_once __DIR__ . '/vendor/autoload.php';
//custom font
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
            'sarabun' => [
                'R' => 'THSarabun.ttf',
            ]
        ],
]);
$mpdf->useDictionaryLBR = false;

$doc_id = $_POST['doc_id'];	
$add_date = $_POST['add_date']; 
$topic = $_POST['topic']; 
$send_to = $_POST['send_to']; 
$value1 = $_POST['value1']; 
$value2 = $_POST['value2']; 
$value3 = $_POST['value3']; 
$name = $_POST['name']; 
$position = $_POST['position']; 
$content = '
<style>
.container{
    font-family: "sarabun";
    font-size: 16pt;
    margin-left:70px;
}
p{
    text-align: justify;
    padding:0px;
    margin:0px;
}
h1{
    text-align: center;
}
body{
    top:0;
}
</style>
<body>
<div class="container" style="width: 100%;" >
<div style="margin-left:245px;font-size:18pt;padding-top:40px;"><p>บันทึกข้อความ</p></div>
ที่ &nbsp;&nbsp;&nbsp;&nbsp;'.$doc_id.' <br>
<p>เรื่อง '.$topic.'</p>
<p>เรียน '.$send_to.'</p>
<p style="text-indent: 1in"> '.$value1.'</p>
<p style="text-indent: 1in"> '.$value2.'</p>
<p style="text-indent: 1in"> '.$value3.'</p>
<p style="text-indent: 4in">( '.$name.' ) </p>
<p style="text-indent: 4.3in">'.$position.' </p>
</div>
</body>
';
$mpdf->WriteHTML($content);
$mpdf->Output();
?>