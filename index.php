<html>
<?php
#error_reporting(E_ALL);
#ini_set('display_errors', 1);

//----------KONFIGURACJA-------------
//zmienna statusu wczytywania pliku [0 - brak akcji, 1-niepowodzenie, 2-powodzenie, 3-zakazane roszerzenie]
$status_uploaded = 0;
//lokalizacja gdzie przechowywac pliki
$fpa = "pliki";
//maksymalny rozmiar pliku
ini_set('upload_max_filesize', '800000000000');

//---------OBSLUGA WGRYWANIA PLIKU-----------
//jesli wyslano plik
if(is_uploaded_file($_FILES['f']['tmp_name'])){

	$fileinfo = pathinfo($_FILES[f][name]);
	//print_r($fileinfo);

	//sprawdzenie czy nie jest zakazane rozszerzenie pliku
	if ($fileinfo['extension']!="php"){

	       //stworzenie sciezki lokalizacji pliku
               $fpa = $fpa."/".$fileinfo['filename'].".".$fileinfo['extension'];
	       //echo "zapisuje w $fpa";

		//wgranie pliku
                if(!move_uploaded_file($_FILES['f']['tmp_name'],$fpa)){
			      //blad przy wczytywaniu
			      $status_uploaded = 1;
		}
		else {
			//powodzenie przy wczytywaniu
			$status_uploaded = 2;
		}	
	}
	//zakazane rozszerzenie pliku
	else {
		$status_uploaded = 3;
	}
}
?>



<h1>Plikownica</h1>

<?php
//jesli zakazany typ pliku
if ($status_uploaded == 3) {
	echo "<p>bledny typ pliku</p>";
}

//jesli wczytano
if ($status_uploaded == 2) {
	echo "<p>plik wczytano poprawnie</p>";
}

//jesli blad wczytywania
if ($status_uploaded == 1) {
	echo "<p>blad przy wczytywaniu pliku</p>";
}
?>


<form enctype="multipart/form-data" action="index.php"  method="post">
	<input type="file" name="f" />
	<input type="submit" value="Wyślij"/>
</form>

<?php
//TODO: zrobic wyswietlanie zawartosci folderu "pliki/"
	$katalog    = 'ftp://mkwk019.cba.pl/plikownica.cba.pl/pliki/';
$pliki = scandir($katalog);
foreach($pliki as $plik) echo '<p>'.$plik.'</p>';
?>

</html>
