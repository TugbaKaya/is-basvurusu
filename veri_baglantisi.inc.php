<?php

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

?>