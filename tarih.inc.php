<?php
function mysql_bicimine_cevir ($tarih)
{
    $gun=mb_substr($tarih,0,2);
	$ay=mb_substr($tarih,3,2);
	$yil=mb_substr($tarih,6,4);
	$mysql_tarihi=$yil."-".$ay."-".$gun;
	return $mysql_tarihi;
}
function kullanici_bicimine_cevir ($tarih)
{
	$yil=mb_substr($tarih,0,4);
	$ay=mb_substr($tarih,5,2);
	$gun=mb_substr($tarih,8,4);
	$kullanici_tarihi=$gun."-".$ay."-".$yil;
	return $kullanici_tarihi;
}
?>