#!/usr/bin/php
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
				//file_put_contents($log, $elf[$i].$delimiter, FILE_APPEND);
				//echo "pasa: ".$elf[$i]."<br>";
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
		"\t#  de archivo que contenga la lista de links #\n".
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
