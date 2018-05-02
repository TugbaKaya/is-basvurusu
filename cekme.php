<?php 

function cekme()
{
	baglan();
$sorgu = $baglan->query("SELECT * FROM egitim"); // Eğitim tablosundaki tüm verileri çekiyoruz.

while ($sonuc = $sorgu->fetch_assoc()) { 

$tur = $sonuc['tur']; // Veritabanından çektiğimiz tur satırını $tur olarak tanımlıyoruz.
$aciklama = $sonuc['aciklama'];


// While döngüsü ile verileri sıralayacağız. Burada PHP tagını kapatarak tırnaklarla uğraşmadan tekrarlatabiliriz. 
}
}
?>