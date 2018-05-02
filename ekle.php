<?php 
function ekle()
{
//veri tabanına bilginin eklendiği yer
  if(isset($_POST["ekle"]))
   {
	// escape string kullanım şekli: mysqli_real_escape_string($baglan,$string);
	$tur=$_POST['tur'];
    $aciklama=$_POST['aciklama'];
	//$sqlekle="INSERT INTO egitim(tur,aciklama)values('$tur','$aciklama')";
	
	$sql=sprintf("INSERT INTO egitim(tur,aciklama)values(%d,'%s')",$tur, mysqli_real_escape_string($baglan,$aciklama));
	echo "<p>$sql</p>";
	$sonuc=mysqli_query($baglan,$sql);
   }
 else
  {
	echo "burada";
  }
}
?>