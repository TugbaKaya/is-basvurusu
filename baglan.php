<?php
//BAĞLANTI FONKSİYONU
function baglan()
{  
    $baglan = new mysqli("localhost", "root", "", "is_talep_formu_aro");
    if ($baglan->connect_error)
	{
      die("Bağlantı sağlanamadı: " . $baglan->connect_error);
    } 
	else
    {
	  echo "Bağlantı Sağlandı";
	}
//TÜRKÇE KARAKTERLERİ TANIMASI İÇİN
 //  mysqli_set_charset($baglan, "utf8");
   mysqli_query($baglan,"set names utf8");
   mysqli_query($baglan,"set character_set_client=utf8");
   mysqli_query($baglan,"set character_set_result=utf8");
   mysqli_query($baglan,"set character_set_connection=utf8");
} 
?>