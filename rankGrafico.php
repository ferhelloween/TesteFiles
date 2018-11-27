<?php 

	#definir o char-set da página 
	setlocale(LC_ALL,"pt_BR"); 
	header('Content-type: text/html; charset=windows-1252');

	set_time_limit(120); //Define tempo limite de execução
	ERROR_REPORTING (E_ERROR);  //Somente exibe erros fatais

	 #Cria a variável de usuário 
	 $usuario = strtolower($_SERVER["REMOTE_USER"]);
     $usuario_1 = split('\\\\', $usuario);
     $usuario = $usuario_1[1];


     $data_AT = date('d/m/Y');

      //Inclui arquivo de conexão que será usado na pesquisa 
   	 include "../STRUTS/Conexao.php"; 

   	 #Varíaveis globais que serão usadas para cadastramento 
	SQL(); 
	global $sql;
	SQL2(); 
	global $sql2; 
	SQL3(); 
	global $sql3;
	SQL4(); 
	global $sql4;


	//Crias a variaveis que serão utilizdas para o filtro 
	$dataI = $_REQUEST["dataI"]; //Data Inicial 
	$dataF = $_REQUEST["dataF"]; //Data Final 
	$gitec = $_REQUEST["gitec"]; //Gitec 
	$rede = $_REQUEST["rede"]; //Rede 

	//echo $dataI; 
	//echo $dataF; 
	//echo $gitec; 
	//echo $rede;


	//Criando os filtros que serão usados na consulta 
		$comparaGitec = $gitec; //Passa a Variavel $gitec para $comparaGitec; 
			if ($comparaGitec == "Todas") {
				$cgc = "Todos"; 
			} else if ($comparaGitec == "CEPTI/SP") { 
				$cgc = "7261"; 
			} else if ($comparaGitec == "CETAD") { 
				$cgc = "7366"; 
			} else if ($comparaGitec == "CETEC") { 
				$cgc = "7562"; 
			} else if ($comparaGitec == "GITEC/BE") { 
				$cgc = "7434"; 
			} else if ($comparaGitec == "GITEC/BH") { 
				$cgc = "7435"; 
			} else if ($comparaGitec == "GITEC/BR") { 
				$cgc = "7436"; 
			} else if ($comparaGitec == "GITEC/BU") { 
				$cgc = "7433"; 
			} else if ($comparaGitec == "GITEC/CG") { 
				$cgc = "7438"; 
			} else if ($comparaGitec == "GITEC/CT") { 
				$cgc = "7445"; 
			} else if ($comparaGitec == "GITEC/FO") { 
				$cgc = "7874"; 
			} else if ($comparaGitec == "GITEC/GO") { 
				$cgc = "7875"; 
			} else if ($comparaGitec == "GITEC/PO") { 
				$cgc = "7876"; 
			} else if ($comparaGitec == "GITEC/RE") { 
				$cgc = "7466"; 
			} else if ($comparaGitec == "GITEC/RJ") { 
				$cgc = "7469"; 
			} else if ($comparaGitec == "GITEC/SA") { 
				$cgc = "7470"; 
			} else if ($comparaGitec == "GITEC/SP") { 
				$cgc = "7877"; 
			} else { 
				$cgc = ""; 
			}

			//Cria a condição para Gitec 
			if($gitec == "Todas") { 
				$whereGitec = ""; 
			} else { 
				$whereGitec = "AND REP_SIR.[GITEC] = '$gitec'";
			}	

			//Cria a Condição para a Rede 
			if($rede == "Todas") { 
				$whereRedes = ""; 
			} else { 
				$whereRedes = "AND PLA_CIR.[TIPO_CIRCUITO] = '$rede'";
			}

			//Cria a Condição para a Rede 
			if($rede == "Todas") { 
				$whereRedesNew = ""; 
			} else { 
				$whereRedesNew = "AND [TIPO_CIRCUITO] = '$rede'";
			}

			//Cria a condição para o CGC 
			if($cgc == "Todos") { 
				$whereCgc = "";
			} else { 
				$whereCgc = "AND [CGC_FILIAL] = '$cgc'";
			}


?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="windows-1252"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 	<link rel="stylesheet" href="/resources/demos/style.css">
		
	<!--CSS Bootstrap e Próprios-->
	<link rel="stylesheet" type="text/css" href="../LIB/CSS/bootstrap.min.css"/> <!--BootStrap-->
	<link rel="stylesheet" type="text/css" href="../LIB/CSS/newPages.css"/><!--CSS Adicional-->
		
	<!--Bootstrap JS--> 
	<!--<script type="text/javascript" charset="utf-8" src="LIB/JS/jquery-1.11.1.min.js"></script>--> 
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" charset="utf-8" src="../LIB/JS/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script><!--Script para mascara de telefone-->
	<script type="text/javascript" charset="utf-8" src="../LIB/JS/bootstrap.min.js"></script> 
		
	<!--<script type="text/javascript" charset="utf-8" src="../LIB/JS/calendario.js"></script>-->
	

	<!--PDF JavaScript-->
	<!-- Jquery DataTable Plugin Js -->
	<script src="../LIB/JS/datatable/jquery-datatable/jquery.dataTables.js"></script> <!-- need -->
	<script src="../LIB/JS/datatable/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script> <!-- need -->
	<script src="../LIB/JS/datatable/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script> <!-- need -->
	<script src="../LIB/JS/datatable/jquery-datatable/extensions/export/buttons.flash.min.js"></script> <!-- need -->
	<script src="../LIB/JS/datatable/jquery-datatable/extensions/export/jszip.min.js"></script> <!-- need -->
	<script src="../LIB/JS/datatable/jquery-datatable/extensions/export/pdfmake.min.js"></script> <!-- need -->
	<script src="../LIB/JS/datatable/jquery-datatable/extensions/export/vfs_fonts.js"></script> <!-- need -->
	<script src="../LIB/JS/datatable/jquery-datatable/extensions/export/buttons.html5.min.js"></script> <!-- need -->
	<script src="../LIB/JS/datatable/jquery-datatable/extensions/export/buttons.print.min.js"></script> <!-- need -->
	<script src="../LIB/JS/datatable/tables/jquery-datatable.js"></script> <!-- need -->

	  <script>
  			$(function() {   
       			$( "#dataIni" ).datepicker({ 
       					dateFormat: "yy-mm-dd",  
      					dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
       				    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      					dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      		    		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
     				   	monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
     						 onClose: function( selectedDate ) {  
   						    	 $( "#dataFim" ).datepicker( "option", "minDate", selectedDate );  
    					  }  
  				 	 });  
			  	 $( "#dataFim" ).datepicker({
    			 		dateFormat: "yy-mm-dd",
    			 		dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
       			 	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      				    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      			   	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
     			   	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    			        onClose: function( selectedDate ) {
   				           $( "#dataIni" ).datepicker( "option", "maxDate", selectedDate );
      			 	   }
    			   });  
  			}); 
  			</script>
	
			<style type="text/css">
				input[type=text] { 
					border: 2px solid #000080;
					border-radius: 4px;	
				}

				label { 
					color: #066FA8;
				}

				body { 
					background-color: #e6ffff;
				}

			</style>	
</head>
<body>	
		<br>	
		<p style="margin-left: 15px; color: #000080;">Período de Pesquisa: <b><?=$dataI;?></b> até <b><?=$dataF;?></b>&nbsp;&nbsp; GITEC: <b><?=$gitec;?></b>&nbsp;&nbsp; REDE: <b><?=$rede;?></b></p>	
		  <? 		

				$consultaGrafico = "
					SELECT  [OPERADORA],
						COUNT(REP_SIR.[ID]) as Total_Incidentes,
						AVG (CASE WHEN LEN(REP_SIR.[TEMPO INDISPONÍVEL]) = 8 THEN (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 1, 2) * 3600) 
						+ (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 4, 2) * 60) + (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 7, 2))
						 WHEN LEN(REP_SIR.[TEMPO INDISPONÍVEL]) = 9 THEN (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 1, 3) * 3600) 
						+ (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 5, 2) * 60) + (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 8, 2)) END) AS TMR,  
						SUM (CASE WHEN LEN(REP_SIR.[TEMPO INDISPONÍVEL]) = 8 THEN (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 1, 2) * 3600) 
						+ (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 4, 2) * 60) + (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 7, 2))
						 WHEN LEN(REP_SIR.[TEMPO INDISPONÍVEL]) = 9 THEN (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 1, 3) * 3600) 
						+ (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 5, 2) * 60) + (SUBSTRING(REP_SIR.[TEMPO INDISPONÍVEL], 8, 2)) END) AS Total_HS 
						 FROM [REPORT].[dbo].[report_sirea] REP_SIR INNER JOIN [REPORT].[dbo].[planta_circuitos] PLA_CIR 
						  ON REP_SIR.[CIRCUITO] = PLA_CIR.[DESIGNACAO] 
  							WHERE REP_SIR.[INICIO] BETWEEN '$dataI' AND '$dataF 23:59:59' 
  							$whereGitec $whereRedes
  							AND REP_SIR.[GRUPO] = 'OPERADORA' GROUP BY REP_SIR.[OPERADORA] ORDER BY Total_Incidentes
				"; 

				//echo $consultaGrafico;

				//Executa a consulta 
				try {
					$listaGrafico = $sql->prepare($consultaGrafico); //Prepara a consulta 
					$listaGrafico->execute();

					foreach ($listaGrafico as $listaFinal) {
						$operadora = $listaFinal['OPERADORA'];
						$total_incidentes = $listaFinal['Total_Incidentes']; 
						$tmr = $listaFinal['TMR']; 
						$total_hs = $listaFinal['Total_HS']; 

						##Executa a conversão do TMR e do Total_HS 

						##1º Passo - Conversão do TMR 
						$hs_tmr = floor($tmr/3600); //Horas 
						$mi_tmr = floor(($tmr - ($hs_tmr * 3600)) / 60); //Minutos 
						$se_tmr = floor($tmr%60); //Segundos 
						$hms_tmr = $hs_tmr.':'.substr("0".$mi_tmr, -2).':'.substr("0".$se_tmr, -2);
						$tela_hms_tmr = $hms_tmr; 

						##2ºPasso - Conversão do Total de Horas 
						$hs_total = floor($total_hs/3600); //Horas 
						$min_total = floor(($total_hs -($hs_total * 3600)) / 60); //Minutos 
						$seg_total = floor($total_hs%60); //Segundos 
						$hms_total = $hs_total.':'.substr("0".$min_total, -2).':'.substr("0".$seg_total, -2); 
						$tela_hms_total = $hms_total; 

						//Alterando o nome da Operadora para Exibição e consulta interna
							switch ($operadora) {
								case 'ALG':
									$nome_exi = 'ALGAR';
								break;
												
								case 'ALP':
									$nome_exi = 'ALPHA';
								break; 
													
								case 'ALT': 
									$nome_exi = 'ACESSOLINE';
								break;	
													
								case 'AMT': 
									$nome_exi = 'AMERICANET';
								break; 

								case 'BTB': 
									$nome_exi = 'BTB-BT';
								break;	

								case 'BT ': 
									$nome_exi = 'BT';
								break;	

                              	case 'CEM': 
									$nome_exi = 'CEMIG';
								break; 
	
								case 'CLA':		
									$nome_exi = 'CLARO';
								break; 

								case 'FOR':  
									$nome_exi = 'FORTEL';
								break; 
															
								case 'FRW': 
									$nome_exi = 'FREE WAY';
								break;

								case 'GVT': 
									$nome_exi = 'TELEFÔNICA BRASIL';
								break;	

								case 'ITL': 
									$nome_exi = 'INTELIG';
								break; 

								case 'LVL': 
									$nome_exi = 'LEVEL 3';
								break; 

								case 'MOB': 
									$nome_exi = 'MOB';
								break; 

								case 'NEB': 
									$nome_exi = 'NET EXPRESS';
								break; 

								case 'NNT': 
									$nome_exi = 'NORTE NET';
								break; 

								case 'OI ': 
									$nome_exi = 'OI MOVEL';
								break; 

								case 'PTN': 
									$nome_exi = 'PRONTONET';
								break; 

								case 'RAG': 
									$nome_exi = 'RAGTEK';
								break; 	

								case 'SOL': 
									$nome_exi = 'SOLUTION';
								break;	

								case 'TLF': 
									$nome_exi = 'TELEFÔNICA';
								break; 

								case 'TLM': 		
									$nome_exi = 'OI';
								break; 

								case 'TNL':	
									$nome_exi = 'TELEMAR NORTE LESTE';
								break; 	

								case 'VLI': 
									$nome_exi = 'VALE DO RIBEIRA';
								break; 

								case 'WCS': 
									$nome_exi = 'WCS';
								break;	

								default:
									# code...
								break;
							}		

						//Criando o Total de Circuitos por Operadora 
							$consultaCircuitos = "
									SELECT [NO_OPERADORA],COUNT([ID]) as Total_Circuitos 
										FROM [REPORT].[dbo].[planta_circuitos] WHERE
										 [NO_OPERADORA] = '$nome_exi' 
										 AND [DT_CONTRATACAO] <= '$dataFim'
										AND [NO_OPERADORA] <> 'CAIXA' $whereRedesNew $whereCgc
										GROUP BY [NO_OPERADORA] 

								";


							//echo $consultaCircuitos."<BR><BR>";
							$listQtd = $sql2->prepare($consultaCircuitos); 
							$listQtd->execute();
								foreach ($listQtd as $qtdCircuitos) {
									$quantidade = $qtdCircuitos['Total_Circuitos'];
								}

							//Cria a Consulta para verificar os circuitos antigos 
								$consultaCircuitosAntigos = "
									SELECT COUNT([ID]) as Total_Circuitos 
										FROM [REPORT].[dbo].[planta_circuitos_descontratados]  WHERE
										 [NO_OPERADORA] = '$nome_exi' 
										 AND [T015_DT_DESCONTRATACAO] BETWEEN '$dataIni' AND '$dataFim' 
										AND [NO_OPERADORA] <> 'CAIXA' $whereRedesNew $whereCgc
										
								";

								//echo $consultaCircuitosAntigos."<BR>";
								
								$listQtdAnt = $sql3->prepare($consultaCircuitosAntigos); 
								$listQtdAnt->execute(); 
									foreach ($listQtdAnt as $qtdCircuitosAnt) {
											$quantidadeAntiga = $qtdCircuitosAnt['Total_Circuitos'];
										}	

								//Cria a Soma das quantidades 
								$quantidadeFinal = $quantidade + $quantidadeAntiga;			

								
							//Cria o calculo para o resultado 
							$horasTotais = $quantidadeFinal * 30 * 24 * 60 * 60;
							$disponibilidadeTotal = $horasTotais - $total_hs; 
							$indisponibilidadeTotal = $total_hs; 	


							//Calcula a porcentagem de Disponibilidade 
							$perc_dispo = (($indisponibilidadeTotal * 100)/$horasTotais); //Cria a porcentagem 
							$perc_dispo_arre = round($perc_dispo,3); //Arredonda a porcentagem para 3 casas decimais 
							$perc_dispo_at = 100 - 	$perc_dispo_arre; 
							$perc_dispo_saida =  $perc_dispo_at."%"; //Saída 

							//Calcula a porcentagem de Indisponibilidade 
							$perc_indispo_at = 100 - $perc_dispo_at; 
							$perc_indispo_saida = round($perc_indispo_at,3)."%";	


						//Cria as saídas para o Gráfico  
						
						//Operadoras	
						$todasOperadoras = array($nome_exi); 
						$saidaOperadora = "";	
							//Cria um forEach interno para o nome 
							foreach ($todasOperadoras as $vOpe) {
								$saidaOperadora = $vOpe;  
							}

						$saidaOpeX = $saidaOpeX." , ".$saidaOperadora;	

						//Total de Incidentes
						$xIncidentes =  array($total_incidentes);
						$saidaIncidentes = "";
							//Cria um forEach para o total de incidentes 
							foreach ($xIncidentes as $vInc) {
									$saidaIncidentes = $vInc;
								}	

						$saidaIncX = $saidaIncX. " , ".$saidaIncidentes;	


						//Tempo Médio de Resposta 
						$xTmr = array($tela_hms_tmr);
						$saidaTmr = ""; 
							//Cria um foreach interno para TMR 
							foreach ($xTmr as $vTmr) {
								$saidaTmr = $vTmr;
							}
						$saidaTmrX = $saidaTmrX. " , ".$saidaTmr;	
						//echo $saidaTmrX;

						//echo "<p style='color: black'>Operadora: ".$operadora."</p><BR>"; 
						//echo "<p style='color: black'>Inicidentes: ".$total_incidentes."</p><BR>";
				}

				} catch (Exception $e) {
					print "<BR><BR>Ocorreu um erro ao acessar o banco de dados -> <B>".$e->getMessage()."</B>"; 
				}

			
			//echo $saidaIncX."<BR>";	
			$saidaOpeX = substr($saidaOpeX, 2);
			//echo $saidaOpeX."<BR><BR>";

			$saidaIncX = substr($saidaIncX, 2); 
			//echo $saidaIncX."<BR><BR>";

			$saidaTmrX = substr($saidaTmrX, 2); 


			$OpeX = explode(',', $saidaOpeX);
			//print_r($OpeX); 
			//print "<BR>"; 

			$IncX = explode(',',$saidaIncX);

			$TmrX = explode(',', $saidaTmrX);


			$totalOpe =  sizeof($OpeX);
			$totalInc =  sizeof($IncX);


			//echo $totalOpe."<BR>";
			//echo $totalInc."<BR>";

			/*for ($i=0 ; $i < $totalOpe  ; $i++ ) { 
				if($i < $totalOpe - 1) {
					echo "['".$OpeX[$i]."',".$TmrX[$i]."]<BR>"; 
				} else { 
					echo "['".$OpeX[$i]."',".$TmrX[$i]."]<BR>";
				}	
						
			}*/

				

		?> 
		<!--Highcharts Scripts-->
		<script src="../LIB/JS/Highcharts/js/highcharts.js"></script>	
		<script src="../LIB/JS/Highcharts/js/modules/data.js"></script>
		<script src="../LIB/JS/Highcharts/js/modules/drilldown.js"></script>

		<!--Exibe o Gráfico-->
		<script type="text/javascript">
			
		$(function () {
		    $('#container').highcharts({
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Quantidade de incidentes por operadora'
		        },
		        subtitle: {
		            text: 'Fonte: <a href="http://sirea.caixa">SIREA</a>'
		        },
		        xAxis: {
		            type: 'category',
		            labels: {
		                rotation: -45,
		                style: {
		                    fontSize: '8px',
		                    fontFamily: 'Verdana, sans-serif'
		                }  

		            }

		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'Incidentes(Nº)'
		            }
		        },
		        legend: {
		            enabled: false
		        },
		        tooltip: {
		            pointFormat: 'Incidentes por Operadora: <b>{point.y:.0f}</b>'
		        },
		        series: [{
		            name: 'Incidentes por Operadora',
		            'colorByPoint': true,
		            data: [
		            	<? 	
		            		for ($i=0 ; $i < $totalOpe  ; $i++ ) { 
								echo "['".$OpeX[$i]."',".$IncX[$i]."],";
							}
		            	?> 	
		            ],
		            dataLabels: {
		                enabled: true,
		                rotation: -90,
		                color: '#000080',
		                align: 'right',
		                format: '{point.y:.0f}', // one decimal
		                y: -28, // 10 pixels down from the top
		                style: {
		                    fontSize: '10px',
		                    fontFamily: 'Verdana, sans-serif'
		                }
		            }
		        }]
		    });
		});		
		</script>

		<div id='container' style='min-width: 310px; height: 400px; margin: 0 auto'></div> 	
		<br>
			<!--Exibe o Gráfico-->
		<script type="text/javascript">
			
		$(function () {
		    $('#container2').highcharts({
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Tempo Médio de Resposta por Operadora'
		        },
		        subtitle: {
		            text: 'Fonte: <a href="http://sirea.caixa">SIREA</a>'
		        },
		        xAxis: {
		            type: 'category',
		            labels: {
		                rotation: -45,
		                style: {
		                    fontSize: '8px',
		                    fontFamily: 'Verdana, sans-serif'
		                }  

		            }

		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'TMR(Hs)'
		            }
		        },
		        legend: {
		            enabled: false
		        },
		        tooltip: {
		            pointFormat: 'Incidentes por Operadora: <b>{point.y:.0f}</b>'
		        },
		        series: [{
		            name: 'Incidentes por Operadora',
		            'colorByPoint': true,
		            data: [
		            	<? 	
		            		for ($i=0 ; $i < $totalOpe  ; $i++ ) { 
								echo "['".$OpeX[$i]."','".$TmrX[$i]."'],";
							}
		            	?> 	
		            ],
		            dataLabels: {
		                enabled: true,
		                rotation: -90,
		                color: '#000080',
		                align: 'right',
		                format: '{y}', 
		                y: -28, // 10 pixels down from the top
		                style: {
		                    fontSize: '10px',
		                    fontFamily: 'Verdana, sans-serif'
		                }
		            }
		        }]
		    });
		});		
		</script>	




		<div id='container2' style='min-width: 310px; height: 400px; margin: 0 auto'></div>
	
</body>
</html>