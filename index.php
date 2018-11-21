<html>
<head>

<title>Sincronizacion de Opera </title>
</head>
<body>
	<center>
	<table align-items = "Center">
		<tr>
			<td align="center" colspan="2">
			<?php
			//Fecha cabecera
			$date1 = new DateTime("now");
			$fechactual = $date1->format('l , d - m  - Y');
			echo "Dia " . $fechactual

			?>
			</td>
		</tr>
		<tr >
			<td align="center">
				Archivo procesado
			</td>
			<td>
				Estado
			</td>
		</tr>
		<tr>
			<td>
				<?php

				$comprimido = new ZipArchive();
				$date1 = new DateTime("now");
				$fechactual = $date1->format('Y_m_d');
				$archivo = 'files/daily_report_' . $fechactual . '_0725AM.zip';
				$carpetaNow = 'daily_report_' . $fechactual . '_0725AM';
				$primary = "html/" . $carpetaNow . "/" . "primary_" . $fechactual . "_0725AM.html";

				if(!file_exists($primary))
				{
					if(file_exists($archivo))
					{
						$comprimido->open($archivo);
						$extraidos = $comprimido->extractTo("html/" . $carpetaNow );
						echo "Archivo Primary OK";
					}
					else
					{
						$date1 = new DateTime("now");
						$fechactual = $date1->format('d m Y');
						echo "Archivo del dia " . $fechactual . " no encontrado ";

						//Obtener

						echo "<a href='copiar.php'> Obtener </a>";

					}
				}
				else
				{
					echo "Primary Extraccion OK";
				}

				echo "</td><td>";

				//Inicia proceso de revision de archivo
				$error = 0;
				$linea_error = -1;
				if(file_exists($primary))
				{

					$archivo_primary = fopen($primary, "r");

					$i = 0;

					$linea_primary = "";

					while(!feof($archivo_primary))
					{
						$i++;
						$linea_primary = $linea_primary . fgets($archivo_primary);
						//echo $linea_primary;
						//echo strnatcmp($linea_primary,$fail);
					}


					if (strpos($linea_primary,"ERROR")||strpos($linea_primary, "ERROR"))
					{
						//echo "Error encontrado";
						$error = 1;

					}
					else
					{
						//echo "Ok sin fallas";
					}

					//IMPRIMIR ERRORES ENCONTRADOS
					if($error > 0 )
					{
						echo "Error linea " . $linea_error . " <a href = '". $primary . " ' >Verficar </a>";
					}
					else 
					{
						echo "Primary OK";
					}


				}
				else
				{
					echo "Error no se encontro el archivo";
				}

			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			
		$date1 = new DateTime("now");
		$fechactual = $date1->format('Y_m_d');
		$standby = "html/" . $carpetaNow . "/" . "standby_" . $fechactual . "_0725AM.html";

			echo "<td>";
			if(!file_exists($standby))
			{
				echo "Archivo Standby no encontrado";
			}
			else
			{
				echo "Archivo Standby OK";
			}

			echo "</td><td>";
				//Verficacion archivo standby
			$errorStanby = 0;
			if(file_exists($standby))
			{
				$archivo_standby = fopen($standby, "r");
				$i = 0;
				$linea_standby = "";
				while(!feof($archivo_standby))
				{
					$i++;
					$linea_standby = $linea_standby . fgets($archivo_standby);

				}

				if (strpos($linea_standby, "ERROR") || strpos($linea_standby, "FAIL"))
					{
						$errorStanby = 1;
					}
				//IMPRIMIR errorStanbyES ENCONTRADOS
				if($errorStanby > 0 )
				{
					echo "ERROR  <a href = '". $standby . " ' >Verficar </a>";
				}
				else 
				{
					echo "Standby OK";
				}
			}
			else
			{
				echo "Error no se encontro el archivo Standby";
			}
			echo "</td>";

		echo "</tr><tr>";
			$sumerrores = $error+$errorStanby;
			echo "<td align= 'center' colspan = '2' >Errores: ". $sumerrores ." </td>";
		echo "</tr>";
		?>

</table>
<br>
<br>

</center>

<div class="footer-copyright">
  <div class="container">
    <div align="right">by Cesar Sanchez</div>
  </div>
</div>
</body>
</html>
