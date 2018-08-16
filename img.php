<?php
// include composer autoload
require_once 'vendor/autoload.php';
 
// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;  
 
// สร้างตัวแปรอ้างอิง object ตัวจัดการรูปภาพ
$manager = new ImageManager();      
     
// การอ่านไฟล์จากรูภาพที่มีอยู่แล้ว โดยระ path ของรูปภาพ ที่จะใช้งาน เพื่อสร้างข้อมูลรูปภาพใหม่
//$img = $manager->make('img/bg1.jpg');     
 
// ส่ง HTTP header และข้อมูลของรูปเพื่อนำไปแสดง 
//echo $img->response();

if(isset($_GET['file']) && $_GET['file']!=""){
    $picFile = trim($_GET['file']);
    $originalFilePath = 'img/'; // แก้ไขเป็นโฟลเดอร์รูปต้นฉบับ
    $fullFilePath = $originalFilePath.$picFile;
    $fullFilePathJPG = $fullFilePath.'.jpg';
    $fullFilePathPNG = $fullFilePath.'.png';
    $fullFile = '';
    $picType = '';
    if(file_exists($fullFilePathJPG)){
        $picType = 'jpg';
        $fullFile = $fullFilePath.'.'.$picType;
    }
    if(file_exists($fullFilePathPNG)){ 
        $picType = 'png';
        $fullFile = $fullFilePath.'.'.$picType;
    }   
    if($picType==''){
        header("HTTP/1.0 404 Not Found");
        exit;
    }
    $manager = new ImageManager();  
    $img = $manager->make($fullFile); 
    if(isset($_GET['mode']) && $_GET['mode']=='f'){
        if(isset($_GET['width']) && $_GET['width']!="" && isset($_GET['height']) && $_GET['height']!=""){       
            $img->fit($_GET['width'], $_GET['height'], function ($constraint) {
                $constraint->upsize(); // ถ้าค่าที่กำหนดมากกว่าค่าเดิม ไม่ต้องปรับขนาด
            });
        }else{
            // only width
            if(isset($_GET['width']) && $_GET['width']!=""){
                $img->fit($_GET['width']);               
            }else{ // no width parameter
                 
            }
        }       
    }
    if(isset($_GET['mode']) && $_GET['mode']=='c'){
        if(isset($_GET['width']) && $_GET['width']!="" && isset($_GET['height']) && $_GET['height']!=""){   
            $img->crop($_GET['width'], $_GET['height']);         
        }else{
            // only width
            if(isset($_GET['width']) && $_GET['width']!=""){
                $img->crop($_GET['width'], $_GET['width']);              
            }else{ // no width parameter
                 
            }
        }       
    } 
    if(isset($_GET['mode']) && $_GET['mode']=='r'){
        if(isset($_GET['width']) && $_GET['width']!="" && isset($_GET['height']) && $_GET['height']!=""){   
            $img->resize($_GET['width'], $_GET['height']);           
        }else{
            // only width
            if(isset($_GET['width']) && $_GET['width']!=""){
                $img->resize($_GET['width'], null, function ($constraint) {
                    $constraint->aspectRatio();// ให้คงสัดส่วนของรูปภาพ
                }); 
            }else{ // no width parameter
                 
            }
        }       
    } 
    if(isset($_GET['mode']) && $_GET['mode']=='w'){
        // only width
        if(isset($_GET['width']) && $_GET['width']!=""){
            $img->widen($_GET['width'], function ($constraint) {
                $constraint->upsize(); // ถ้าค่าความกว้างที่กำหนดมากกว่าค่าเดิม ไม่ต้องปรับขนาด
            });
        }else{ // no width parameter
             
        }
    }   
    if(isset($_GET['mode']) && $_GET['mode']=='h'){
        if(isset($_GET['width']) && $_GET['width']!="" && isset($_GET['height']) && $_GET['height']!=""){       
            $img->heighten($_GET['height'], function ($constraint) {
                $constraint->upsize(); // ถ้าค่าความสูงที่กำหนดมากกว่าค่าเดิม ไม่ต้องปรับขนาด
            });
        }else{
            // only width
            if(isset($_GET['width']) && $_GET['width']!=""){
                $img->heighten($_GET['width'], function ($constraint) {
                    $constraint->upsize(); // ถ้าค่าความสูงที่กำหนดมากกว่าค่าเดิม ไม่ต้องปรับขนาด
                });             
            }else{ // no width parameter
                 
            }
        }
    }  
    echo $img->response();   
}
?>