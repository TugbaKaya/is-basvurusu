<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="js/jquery.min.js" ></script>
	<script type="text/javascript" src="js/egitim.js" ></script>
</head>
<body>

<?php
$baglan = null;

function veri_baglantisi ()
{
	global $baglan;
	
	if ($baglan === null) {
		$baglan = new mysqli("localhost", "root", "", "is_talep_formu_aro");

		if ($baglan->connect_error)
		{
			die("Bağlantı sağlanamadı: " . $baglan->connect_error);
		} 
		echo "Bağlantı Sağlandı";

		//TÜRKÇE KARAKTERLERİ TANIMASI İÇİN
		$baglan->query ("Set names utf8");
		$baglan->query ("set character_set_client=utf8");
		$baglan->query ("set character_set_results=utf8");
		$baglan->query ("set character_set_connection=utf8");
	}
}

function giris_formu ()
{ 
    global $baglan;
?>
    <!--bilgi girme ekranı-->
    <form action="egitim.php" method='POST'>
    &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Tür:<input type="text" name="tur" id="tur"><br>
    Açıklama:<input type="text" name="aciklama" id="aciklama"><br>
    <input type="submit" name="ekle"  value="Ekle" onclick="return kontrol();">
	<input type="submit" name="sorgula" value="Sorgula">
    </form>

<?php 
}
function veri_ekle ()
{
	//veri tabanına bilginin eklendiği yer
	global $baglan;
	
	if(isset($_POST["ekle"]))
    {
        $tur=$_POST['tur'];
        $aciklama=$_POST['aciklama'];
	    $sql=sprintf("INSERT INTO egitim(tur,aciklama)values(%d,'%s')",$tur, mysqli_real_escape_string($baglan,$aciklama));
	    $sonuc=$baglan->query($sql);
    }
    else
    {
	    echo "veri eklenmedi";
    }
}


function sorgula ()
{
	global $baglan;	
?>
	<table border='1'>
	<tr>
	    <td>Güncelle</td>
		<td>Sil</td>
		<td>Tür</td>
		<td>Okul</td>
		
	</tr>
<?php

	$sorgu = $baglan->query("SELECT * FROM egitim"); // Eğitim tablosundaki tüm verileri çekiyoruz.
	while ($sonuc = $sorgu->fetch_array()) { 
		$tur = $sonuc['tur'];                        // Veritabanından çektiğimiz tur satırını $tur olarak tanımlıyoruz.
		$aciklama = $sonuc['aciklama'];
		

	                                                 // While döngüsü ile verileri sıralayacağız. Burada PHP tagını kapatarak tırnaklarla uğraşmadan tekrarlatabiliriz. 
?>
	<tr>
	<td><a href="egitim.php?tur=<?php echo $tur; ?>&amp;kayit_getir=1"><img src="guncelle.jpg" width="30" height="30"></a></td>
	<td><a href="egitim.php?tur=<?php echo $tur; ?>&amp;kayit_sil=1" onclick="return confirm('Silmek İstediğinize Emin Misiniz?')"><img src="sil.jpg"width="30" height="30"></a></td>
	<td><?php echo $tur; ?></td> <!--*** echo komutunu unutma-->
	<td><?php echo $aciklama; ?></td>
	</tr>

	
<?php
}?>
</table> 
<?php
// sorgula bitti ()
}

function guncelle_formu ($tur)
{
	global $baglan;
	echo $tur;
?>
	<form action="egitim.php" method='POST'>
		Tür:<input type="text" name="tur" id="tur" value="<?php echo $tur; ?>"><br>
		Açıklama:<input type="text" name="aciklama" id="aciklama"value="<?php $sorgu = $baglan->query("SELECT aciklama FROM egitim where tur='$tur'"); 
	                                                             while ($sonuc = $sorgu->fetch_array()) { 
		                                                         $aciklama = $sonuc['aciklama']; 
																 echo $aciklama;}?>"><br>
		<input type="hidden" name="eskitur"value="<?php echo $tur ?>">												  
		<input type="submit" name="Guncelle"  value="Guncelle" onclick="return kontrol();" >
		</form>
<?php	
	
}

function veri_guncelle()
{
	global $baglan;
	
	$aciklama=$_POST["aciklama"];
    $tur=$_POST["tur"];
	$eskitur=$_POST["eskitur"];
	print_r($_POST);
	
	$sql = sprintf("UPDATE egitim set tur=%d, aciklama='%s' where tur=%d", $tur, $aciklama, $eskitur);
	echo "<p>$sql</p>";
	
	$guncelle = $baglan->query($sql);
	//$guncelle = $baglan->query("UPDATE egitim SET tur='$tur', aciklama='$kayit_getir' where tur='$eskitur'");
 
    if($guncelle)
	{
		sorgula();
    }
	else
	{
		echo "Güncellenmedi";
    }
	
}

function veri_sil($tur)
{
	
	global $baglan;
	$sql = "delete from egitim where tur='$tur'";
	echo "<p>$sql</p>";
	$sonuc=$baglan->query($sql);
	
	giris_formu();
	sorgula();
}

function veri_sorgula()
{
	global $baglan;	
	$tur=$_POST['tur'];
    $aciklama=$_POST['aciklama'];


	if($aciklama==NULL && $tur==NULL){
		
		sorgula(); 
	}
	else if($tur==NULL){
		
		$sql=("SELECT * from egitim where aciklama LIKE '$aciklama'");
		print_r($sql);
		kayıt_getir($sql);
	}
	else if($aciklama==NULL){
		
		$sql=("SELECT * from egitim where tur='$tur'");
		print_r($sql);
		kayıt_getir($sql);
	}
	
	else {
		
		$sql=("SELECT * from egitim where tur='$tur' and aciklama LIKE '$aciklama'");
		print_r($sql);
		kayıt_getir($sql);
	}
}                                                

function kayıt_getir($sql)
{
	global $baglan;
	$say="0";
	$tur=$_POST['tur'];
    $aciklama=$_POST['aciklama'];
	$sorgu=$baglan->query($sql);
	while ($sonuc = $sorgu->fetch_array()) { 
		$tur = $sonuc['tur'];                  
		$aciklama = $sonuc['aciklama'];
		$say++;

		if($say == 1){
?>
			<table border='1'>
			<tr>
				<td>Güncelle</td>
				<td>Sil</td>
				<td>Tür</td>
				<td>Okul</td>
				
			</tr> 
<?php
		
		}
?>

		<tr>
			<td><a href="egitim.php?tur=<?php echo $tur; ?>&amp;kayit_getir=1"><img src="guncelle.jpg" width="30" height="30"></a></td>
			<td><a href="egitim.php?tur=<?php echo $tur; ?>&amp;kayit_sil=1" onclick="return confirm('Silmek İstediğinize Emin Misiniz?')"><img src="sil.jpg"width="30" height="30"></a></td>
			<td><?php echo $tur; ?></td> <!--*** echo komutunu unutma-->
			<td><?php echo $aciklama; ?></td>
		</tr>

	
<?php
	}
    if($say < 1){
		echo "<p>Aradığınız özelliklere uygun kayıt bulunamamaktadır!</p>";
	}
	else{
?>      </table><?php
	}

 
    
}

/*********************************MAİN PROGRAM***************************************/

veri_baglantisi();

if (isset ($_GET ["kayit_getir"])) {
	print_r ($_GET);
	$tur=$_GET["tur"];
	guncelle_formu($tur);
	
} else if (isset ($_POST ["Guncelle"])) {
	veri_guncelle();
	
} else if (isset ($_POST ["ekle"])) {
	veri_ekle();
	echo "<p>Kayıt girildi</p>";
	giris_formu();
	sorgula();
	
} else if(isset($_GET["kayit_sil"])) {
	print_r($_GET);	
	$tur=$_GET["tur"];
	veri_sil($tur);
	
} else if(isset($_POST["sorgula"])){
	veri_sorgula();
}
  else { 
	giris_formu();
}
   
?>

</body>
</html>