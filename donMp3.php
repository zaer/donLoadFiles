#!/usr/bin/php
/**********************************************************/
/* El archivo que se le pasa como parametro al script es  */
/* una lista de links que hacen referencia a los archivos */
/* a descargar, por ejemplo:                              */
/* <a href="mi_mp3.mp3">Cancion X</a>                     */
/* ¿Como obtenemos la lista?                              */
/* Con la ayuda de Google Dorks, ejemplo:                 */
/* intitle:index.of? mp3 Un millon de primaveras          */
/* obtienen la lista de los archivos, guardamos y pasamos */
/* como parametro esa lista y listo                       */
/* dudas: zaer00t@gmail.com                               */
/**********************************************************/
<?php
function extrae_ligas($archivo)
{
	if(is_file($archivo))
	{
		$direcciones = array();
		$lista = file_get_contents($archivo);
		preg_match_all("/https?\:\/\/[^\" ]+(\.mp3)+/i",$lista,$coins);
		$elf = array_unique($coins[0]);
		for($i=0;$i<count($elf);$i++)
		{
			if(!empty($elf[$i]))
			{
				$direcciones[]=$elf[$i];
			}
		}
		return $direcciones;
	}
	else
	{
		return false;
	}
}

function tranza($lista)
{
	$tamanio = sizeof($lista);
	for($i=0; $i<$tamanio; $i++)
	{
		$nom = explode("/",$lista[$i]);
		$tam = sizeof($nom);
		$nom = $nom[$tam-1];

		$fh = file_get_contents($lista[$i]);

		$nom = str_replace("%20","_",$nom);
		echo "Descargado: ".$nom."\n";
		$f1=fopen($nom,"w");
		fwrite($f1,$fh);
		fclose($f1);
	}
}
$usage ="\n\t##############################################\n" .
		"\t# El modo de uso para {$argv[0]} es:        #\n".
		"\t#  {$argv[0]} <lista>                       #\n".
		"\t#  Donde lista puede ser cualquier tipo de   #\n".
		"\t#  archivo que contenga la lista de links    #\n".
		"\t##############################################\n\n\n";
// the start the magic code
if(!isset($argv[1]))
{
	echo $usage;
	return;
}
else
{
	$links = $argv[1];
	if(is_file($links))
	{
		$archivo = extrae_ligas($links);
		tranza($archivo);
	}
	else
	{
		echo "No mamiscles";
		return;
	}
	
}

?>
