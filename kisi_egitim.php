<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="js/jquery.min.js" ></script>
	<script type="text/javascript" src="js/jquery-ui.min.js" ></script>
	<link rel="StyleSheet" href="js/jquery-ui.min.css" type="text/css">
	<link rel="StyleSheet" href="js/jquery-ui.theme.min.css" type="text/css">
	<script type="text/javascript" src="js/kisi_egitim.js" ></script>
</head>
<body>
<?php
$baglan = null;

require_once "tarih.inc.php";
require_once "veri_baglantisi.inc.php";


function egitim_listesi ($alan_adi="okul_adi", $deger="")
{
	global $baglan;
	echo $deger; 
	echo $alan_adi;
	
	$sorgu = $baglan->query("SELECT aciklama FROM egitim"); 

	echo '<select type="text" name="' . $alan_adi . '" id="' . $alan_adi . '" >';
		
	while ($sonuc = $sorgu->fetch_array()) { 
				$aciklama = $sonuc['aciklama'];
				
	            echo"<option value='$aciklama' ";
				if (mb_substr($aciklama, 0, 1) == mb_substr($deger,0,1))
					echo " selected='selected' ";
				    echo $deger;
				
				echo ">";
				    echo $aciklama; 
				echo"</option>\n";
	}
	echo "</select>";
}

function giris_formu ()
{ 
    global $baglan;
?>
    <form action="kisi_egitim.php" method='POST'>
		KİŞİ ID:<input type="text" name="kisi_id" id="id"><br>
		OKUL ADI:<?php egitim_listesi();?><br>
		ADRES:<textarea rows="1" cols="35" name="yer"> </textarea><br>
		BAŞLAMA TARİHİ:<input type="text" name="b_tarihi" id="b_tarihi" class="datepicker"><br>
		BÖLÜM:<input type="text" name="bolum" id="bolum"><br>
		EĞİTİM DURUMU: &emsp; <font>Okuyor</font><input checked="" type="checkbox" name="egitimdevam" value="okuyor"><br>
		<input type="submit" name="ekle" value="Kayıt Ekle" onclick="kontrol();" >
		<input type="submit" name="sorgula" value="Kayıt Sorgula">
    </form>

<?php 
}
function kayit_ekle()
{
	global $baglan;
	
	if(isset($_POST["ekle"]))
    {
		$kisi_id=$_POST['kisi_id'];
        $okul_adi=$_POST['okul_adi'];
		$yer=$_POST['yer'];
		$baslama_tarihi = mysql_bicimine_cevir ($_POST['b_tarihi']);
		$bolum=$_POST['bolum'];
		if(isset ($_POST['egitimdevam']))
		{
			$egitim_durumu="1";
		}
		else
		{
			$egitim_durumu=NULL;
		}
	    $sql=sprintf("INSERT INTO kisi_egitim(kisi_id,okul_adi,yer,baslama_tarihi,bolum,egitimdevam)values(%d,'%s','%s','%s','%s','%s')",$kisi_id,mysqli_real_escape_string($baglan,$okul_adi),mysqli_real_escape_string($baglan,$yer),mysqli_real_escape_string($baglan,$baslama_tarihi),mysqli_real_escape_string($baglan,$bolum),mysqli_real_escape_string($baglan,$egitim_durumu)); //mysqli_real_escape_string veri tabanına karşı yapılan saldırılar için kullanılan metod
	    $sonuc=$baglan->query($sql);
		echo $sql;
		echo "<p>Kayıt eklendi</p>";
    }
    else
    {
	    echo "Veri eklenmedi";
    }
}
function kayit_sorgula ()
{
	global $baglan;	
?>
	<table border='2'>
	<tr>
	    <td>KİŞİ ID</td>
		<td>OKUL ADI</td>
		<td>ADRES</td>
		<td>BAŞLAMA TARİHİ</td>
		<td>BÖLÜM</td>
		<td>EĞİTİM DURUMU</td>
		<td>GÜNCELLE</td>
		<td>SİL</td>
	</tr>
<?php
    
	$sorgu = $baglan->query("SELECT * FROM kisi_egitim"); 
	while ($sonuc = $sorgu->fetch_array()) { 
		$kisi_id=$sonuc['kisi_id'];
		$okul_adi=$sonuc['okul_adi'];
		$yer=$sonuc['yer'];
		$baslama_tarihi=kullanici_bicimine_cevir( $sonuc['baslama_tarihi'] );
		$bolum=$sonuc['bolum']; 
		$egitim_durumu=$sonuc['egitimdevam'];
?>
	<tr>
		<td><?php echo $kisi_id; ?></td>
		<td><?php echo $okul_adi; ?></td>
		<td><?php echo $yer; ?></td>
		<td><?php echo $baslama_tarihi; ?></td>
		<td><?php echo $bolum; ?></td> <!--&amp;=Değişkenleri ayırmak için kullanılır(VE). kayit_getirme=1=Program benim kayıt getirmek istediğimi anlaması için"-->
		<td><?php echo $egitim_durumu; ?></td>
		<td><a href="kisi_egitim.php?kisi_id=<?php echo $kisi_id; ?> &amp;kayit_getirme=1"><img src="guncelle.jpg" width="30" height="30"></a></td>
		<td><a href="kisi_egitim.php?kisi_id=<?php echo $kisi_id; ?> &amp;kayit_silme=0" onclick="return confirm('Silmek İstediğinize Emin Misiniz?')"><img src="sil.jpg" width="30" height="30"></a></td> <!--return confirm:ekranda pencere açar ver kod da yazılan soruyu sorar-->
	</tr>

		
<?php
}?>
</table> 
<?php
}
function guncelle_formu ($kisi_id)
{
	global $baglan;
	echo $kisi_id;
	
	$sorgu = $baglan->query("SELECT * FROM kisi_egitim where kisi_id=$kisi_id"); 
	if ($sonuc = $sorgu->fetch_array()) {
		$yer=$sonuc['yer'];
		$baslama_tarihi=kullanici_bicimine_cevir( $sonuc['baslama_tarihi'] );
		$bolum=$sonuc['bolum'];
		$okul_adi=$sonuc['okul_adi'];
		$egitim_durumu=$sonuc['egitimdevam'];
	}													 
?>
	<form action="kisi_egitim.php" method='POST'>
	
		KİŞİ ID:<input type="text" name="kisi_id" value="<?php echo $kisi_id ?>"id="id"><br>
		
		OKUL ADI:<?php egitim_listesi("okul_adi", $okul_adi); ?> <br>
		
		ADRES:<input type="text" name="yer" id="yer" value="<?php echo $yer; ?>" ><br>
														  
		BAŞLAMA TARİHİ:<input type="text" name="b_tarihi" class="datepicker" id="b_tarihi" value="<?php echo $baslama_tarihi; ?> " ><br>
														  
		BÖLÜM:<input type="text" name="bolum" id="bolum" value="<?php echo $bolum; ?>" ><br>
														  
		EĞİTİM DURUMU:<input type="checkbox" name="egitimdevam" value="<?php echo $egitim_durumu; ?>">
														  
        <input type="hidden" name="eskikisi" value="<?php echo $kisi_id ?>">
		
		<input type="submit" name="guncelle"  value="Güncelle">
		
    </form>
<?php	
	
}
function kayit_guncelle()
{
	global $baglan;
	
	$kisi_id=$_POST['kisi_id'];
    $okul_adi=$_POST['okul_adi'];
	$yer=$_POST['yer'];
	$baslama_tarihi= mysql_bicimine_cevir( $_POST['b_tarihi'] );
	$bolum=$_POST['bolum'];
	$eskikisi=$_POST["eskikisi"];
	if(isset ($_POST['egitimdevam']))
	{
		$egitim_durumu = "1";
    }
	else
	{
		$egitim_durumu = NULL;
	}
	
	print_r($_POST);
	
	$sql = sprintf("UPDATE kisi_egitim set kisi_id=%d, okul_adi='%s', yer='%s', baslama_tarihi='%s', bolum='%s', egitimdevam='%s' where kisi_id=%d", $kisi_id, $okul_adi, $yer, $baslama_tarihi, $bolum, $egitim_durumu, $eskikisi);
	echo "<p>$sql</p>";
	
	$guncelle = $baglan->query($sql);
 
    if($guncelle)
	{
		kayit_sorgula();
    }
	else
	{
		echo "Güncellenmedi";
    }
	
}
function kayit_sil($kisi_id)
{
	global $baglan;
	$sql = "delete from kisi_egitim where kisi_id='$kisi_id'";
	echo "<p>$sql</p>";
	$sonuc=$baglan->query($sql);
	
	kayit_sorgula();
}
//*******************************************ANA PROGRAM****************************************
veri_baglantisi();

if (isset ($_POST["ekle"])) 
{
	kayit_ekle();
	kayit_sorgula();
}
else if(isset ($_POST["sorgula"]))
{
	giris_formu();
	kayit_sorgula();
}
else if (isset ($_GET["kayit_getirme"])) 
{
	print_r ($_GET);
	$kisi_id=$_GET["kisi_id"];
	guncelle_formu($kisi_id);
}
else if(isset ($_GET["kayit_silme"]))
{
	$kisi_id=$_GET["kisi_id"];
	kayit_sil($kisi_id);
}
else if(isset ($_POST["guncelle"]))
{
	kayit_guncelle();
}
else
{
	giris_formu();
}
?>
</body>