<?php
echo "merhaba dunya<br/>";

$ad="Tugba";
$soyad="KAYA";
$yas=21;
$meslek="Bilgisayar Mühendisligi";
echo $ad.$soyad.$yas.$meslek."<br/>";
echo $soyad."<br/>";
echo $yas."<br/>";
echo $meslek."<br/>";
//değişkenin değerini değişken adı yapmak
$degisken="web";
$$degisken=".y";
echo $degisken.$web."<br/>";
//gettype
echo gettype($ad)."<br/>";
echo $yas."  adlı değişken  ".gettype($yas)."  dır <br/>";
echo gettype($soyad)."<br/>".gettype($meslek)."<br/>";
//settype
settype($yas,"string");
echo $yas." adlı değişken ".gettype($yas) ." dır <br/>";
//sabit değiken
define("ADIM","Tugba");
echo ADIM ."<br/>";

echo defined("ADIM")."<br/>";
define ("SOYAD",ADIM);
echo SOYAD."<br/>";
echo defined("SOYAD")."<br/>";
//tek tırnak(Escape String)
echo 'Bursa Türkiye\'nin Ulu Şehridir <br/>';
echo '$ komutu, php dilinde değişken tanımlamak için kullanılır';
echo "<br/>\$ <br/>";
echo " $soyad  <br/>"; // çift tırnak kullanımı
echo $soyad ."<br/>"; //çift tırnak ile kullanımı aynıdır.
echo '$soyad <br/>'; // tek tırnak kullanımı
//if-else
	$a=5; $b=10;
if($a==$b) 
{
	echo "$a sayısı $b sayısına eşittir";
}
else echo "$a sayısı $b sayısına eşit değildir <br/>";
echo "en küçük sayı bulma <br/>";
$sayi1=98; $sayi2=88; $sayi3=78;
$enkucuksayi=$sayi1;
if($sayi2<$enkucuksayi)  $enkucuksayi=$sayi2;
else echo "knlk";
if($sayi3<$enkucuksayi) $enkucuksayi=$sayi3;
else echo "blb";
echo "$sayi1, $sayi2, $sayi3 sayılarının arasında enküçük sayı $enkucuksayi'dır";
else if yapısına bakınca en büyük sayıyı bulma yap.
?>