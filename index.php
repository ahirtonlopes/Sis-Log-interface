<?php

include 'conexaoestabelecida.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- Template Design by TheWebhub.com | http://www.thewebhub.com | Released for free under a Creative Commons Attribution-Share Alike 3.0 Philippines -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Sistema de Identificação e Localização de Ônibus Urbano</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="http://maps.google.com/maps?file=api&v=1&key=ABQIAAAA4jhXVv-9ROrF-uxAyDz2iBTj_Fc9Dxzx6d3lYP6ZEt_6IkbP-BQjW0rZrzjG-sHXdrwyoVEvb6oMuA"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<!-- include Cycle plugin -->
<script type="text/javascript" src="http://cloud.github.com/downloads/malsup/cycle/jquery.cycle.all.2.72.js"></script>
<script type="text/javascript">

//$(document).ready(function() {
  //  $('.slideshow').cycle({
        //fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
    //    fx:     'scrollUp',
      //  timeout: 6000,
       // delay:  -2000
   // });
//});

$(document).ready(function() {
    $('.slideshow').cycle({
        fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
    });
});
</script>

<!--MAPA -->

</head>
<body>

<div id="wrapper">

</div>
  <div id="conteudo">
  
	<div id="header">
    <iframe src="http://www.portaldotempo.com.br/selos/mostra.php?CIDADES=MA000" scrolling='no' frameborder='0' width='140' height='150' marginheight='0' marginwidth='0' align="right"></iframe>	</div>
	<div id="menu">
		<ul>
			<li><a href="index.php?id=home">Home</a></li>
			<li><a href="index.php?id=linhas">Linhas</a></li>
			<li><a href="index.php?id=paradas">Paradas</a></li>
			<li><a href="index.php?id=mapas">Mapas</a></li>
			<li><a href="index.php?id=sobresislog">Sobre o Sis-Log</a></li>
		</ul>
	</div>

	<div id="content">
		<div id="left">

			<div class="post">

            <?php

            $id = $_GET['id'];
            if((!isset($id))||($id=="home"))
            {
                echo "<form name=\"Pesquisa\" method=\"POST\" action=\"index.php?id=home\">";
				echo "<h2>Localização de Ônibus</h2>";
				echo "<p>Informe a linha e a parada do ônibus desejado e saiba sua localização:</p>";
				echo "<ul>";


                          echo "<div class=\"entry\">";
                            echo "<div class=\"entrybgtop\">";
                                echo "<div class=\"entrybgbtm\">";

                       echo "<table width=\"613\" border=\"0\"  align=\"center\"> ";
                        echo "<tr>";
                       // echo "<li>";


                          echo "<td width=\"25\" style=\"color:#000000\">Linha:</td>";
                          echo "<td width=\"230\"><input name=\"linha\" type=\"text\" id=\"linha\" size=30/></td>";
                          echo "<td width=\"26\" style=\"color:#000000\">Parada:</td>";
                          echo "<td widht=\"209\"><input name=\"parada\" type=\"text\" id=\"parada\" size=30/></td>";
                          echo "<td widht=\"64\"><input type=\"submit\" name=\"button\" id=\"button\" value=\"localizar\"/></td>";
                       echo "</tr>";
                          echo "<tr>";
                          echo "<td>&nbsp;</td>";
                          echo "<td align=\"justify\"><a href=\"index.php?id=linhas\">Pesquisar Linhas</a></td>";
                          echo "<td>&nbsp;</td>";
                          echo "<td align=\"justify\"><a href=\"index.php?id=paradas\">Pesquisar Paradas</a></td>";
                        //echo "</li>";
                            echo "</div>";
                                echo "</div>";
                                    echo "</div>";
                echo "</table>";

				echo "</ul>";
				echo"</form>";

                echo "<br>";
                echo "<br>";
                echo "<br>";



                $parada = $_POST["parada"];
                $linha = $_POST["linha"];
                $flag = 0;

                if(((empty($parada)) && empty($linha)) || (($parada==" ")||($linha==" ")))
                {
                    echo "<div class=\"slideshow\">";

                    echo "<img src=\"images/finep.png\" width=\"350\" height=\"250\" />";
                    echo "<img src=\"images/artec.png\" width=\"350\" height=\"250\"/>";
                     echo "<img src=\"images/desenvolvimento.png\" width=\"350\" height=\"250\"/>";

                    echo "</div>";

                }
                elseif((!empty($parada)) && (empty($linha)) && !($parada==" "))
                {
                      $ql = "Select * from parada where referencia_parada LIKE '%".$parada."%'";
                      $resultParada = mysql_query($ql);
                      $teste = mysql_num_rows($resultParada);

                      if(!($teste>0))
                      {
                           $ql2 = "Select * from parada where local_parada LIKE '%".$parada."%'";
                           $resultParada = mysql_query($ql2);
                           $teste = mysql_num_rows($resultParada);
                           if(!($teste>0))
                           {
                                $ql3 = "Select * from parada where id_parada LIKE '%".$parada."%'";
                                $resultParada = mysql_query($ql3);
                                $teste = mysql_num_rows($resultParada);
                                if(!($teste>0))
                                {
                                     echo 'Nenhum registro encontrado!';
                                     $flag = 1;
                                }
                           }
                      }
                      if($flag == 0)
                      {

                        if($teste > 1){

                          echo "<br>";
                          echo '<table cellspacing=1 align="center">';
                          echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 50>Código</td>";
                          echo "<td widht = 190>Nome </td>";
                          echo "<td width = 190>Local </td>";
                          echo "<td width = 150>Referência</td>";
                          while($array = mysql_fetch_array($resultParada))
                          {
                               $idparada = $array["id_parada"];
                               if($i==0){
                                    $i=1;
                                    echo "<tr bgcolor=beige>";
                               }
                               else{
                                    $i=0;
                                    echo "<tr bgcolor=white>";
                               }
                               echo "<td><a href=\"index.php?id=pesquisaLinha&parada=$idparada&campo=$parada\">".$array["id_parada"]."</td>";
                               echo "<td><a href=\"index.php?id=pesquisaLinha&parada=$idparada&campo=$parada\">".$array["nome_parada"]."</td>";
                               echo "<td><a href=\"index.php?id=pesquisaLinha&parada=$idparada&campo=$parada\">".$array["local_parada"]."</td>";
                               echo "<td><a href=\"index.php?id=pesquisaLinha&parada=$idparada&campo=$parada\">".$array["referencia_parada"]."</td>";
                              }
                              echo "</table>";
                         }

                      else{

                        while($array = mysql_fetch_array($resultParada)){
                              $ql4 = "Select linha_rota, nome_linha, numero_linha from rota,linha where parada_rota = '".$array["id_parada"]."' AND rota.linha_rota = linha.id_linha";
                              $resultLinha = mysql_query($ql4);
                              echo "<br>";
                               echo '<table cellspacing=1 align="center">';
                               echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Parada: ".$array["local_parada"]."</td>";
                               echo "<td width = 190>Referência: ".$array["referencia_parada"]."</td>";
                               echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Número</td><td width = 190>Linha</td>";
                               $i=0;
                               while($linha = mysql_fetch_array($resultLinha)){
                               $idparada = $array["id_parada"];
                               $idlinha = $linha["linha_rota"];
                               if($i==0){
                                    $i=1;
                                    echo "<tr bgcolor=beige>";
                               }
                               else{
                                    $i=0;
                                    echo "<tr bgcolor=white>";
                               }
                               echo "<td>".$linha["numero_linha"]."</td>";
                               echo "<td><a href=\"index.php?id=pesquisa&parada=$idparada&linha=$idlinha\">".$linha["nome_linha"]."</td>";
                              }
                              echo "</table>";
                         }
                      }
                      }
                      }

                elseif((empty($parada)) && (!empty($linha)) && (!($linha==" ")))
                {
                      $ql = "Select * from linha where nome_linha LIKE '%".$linha."%'";
                      $resultLinha = mysql_query($ql);
                      $teste = mysql_num_rows($resultLinha);
                      if(!($teste>0))
                      {
                                $ql3 = "Select * from linha where numero_linha LIKE '%".$linha."%'";
                                $resultLinha = mysql_query($ql3);
                                $teste = mysql_num_rows($resultLinha);
                                if(!($teste>0))
                                {
                                     echo 'Nenhum registro encontrado!';
                                     $flag = 1;
                                }
                           }


                      if($flag == 0)
                      {

                         if($teste > 1){

                          echo "<br>";
                          echo '<table cellspacing=1 align="center">';
                          echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Número</td>";
                          echo "<td widht = 190>Nome</td>";

                          while($array = mysql_fetch_array($resultLinha))
                          {
                                $idlinha = $array["id_linha"];
                                if($i==0)
                                {
                                    $i = 1;
                                    echo "<tr bgcolor = beige>";
                                }
                                else{
                                    $i = 0;
                                    echo "<tr bgcolor = white>";
                                }

                               echo "<td><a href=\"index.php?id=pesquisaParada&linha=$idlinha&campo=$linha\">".$array["numero_linha"]."</td>";
                               echo "<td><a href=\"index.php?id=pesquisaParada&linha=$idlinha&campo=$linha\">".$array["nome_linha"]."</td>";
                          }
                          echo "</table>";
                      }
                      else{
                          while($array2 = mysql_fetch_array($resultLinha)){
                            $ql4 = "Select parada_rota, local_parada, referencia_parada from rota,parada where linha_rota = '".$array2["id_linha"]."' AND rota.parada_rota = parada.id_parada";
                            $resultParada = mysql_query($ql4);
                            echo "<br>";
                               echo '<table cellspacing=1 align="center">';
                               echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Número: ".$array["numero_linha"]."</td>";
                               echo "<td width = 190>Linha: ".$array["nome_linha"]."</td>";
                              echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Parada</td><td width = 190>Local</td>";
                              $i = 0;

                              while($linha = mysql_fetch_array($resultParada))
                              {
                                  $idlinha = $array["id_linha"];
                                  $idparada = $linha["parada_rota"];
                                  if($i==0){
                                    $i=1;
                                    echo "<tr bgcolor=beige>";
                                  }
                                  else{
                                    $i=0;
                                    echo "<tr bgcolor=white>";
                                  }
                                  echo "<td>".$linha["nome_parada"]."</td>";
                               echo "<td><a href=\"index.php?id=pesquisa&parada=$idparada&linha=$idlinha\">".$linha["local_parada"]."</td>";
                              }
                              echo "</table>";


                              }
                       }
                   }
                }
                elseif((!empty($parada)) && (!empty($linha)))
                {

                     $flag = 0;
                     $ql = "Select id_parada,local_parada,referencia_parada from parada where referencia_parada LIKE '%".$parada."%'";
                      $resultParada = mysql_query($ql);
                      $teste = mysql_num_rows($resultParada);
                      if(!($teste>0))
                      {
                           $ql2 = "Select id_parada,local_parada,referencia_parada from parada where local_parada LIKE '%".$parada."%'";
                           $resultParada = mysql_query($ql2);
                           $teste = mysql_num_rows($resultParada);
                           if(!($teste>0))
                           {
                                $ql3 = "Select id_parada,local_parada,referencia_parada from parada where id_parada = '".$parada."'";
                                $resultParada = mysql_query($ql3);
                                $teste = mysql_num_rows($resultParada);
                                if(!($teste>0))
                                {
                                     echo 'Nenhum registro encontrado!';
                                     $flag = 1;
                                }
                           }
                      }
                      if($flag == 0)
                      {
                            $ql4 = "Select * from linha where nome_linha LIKE '%".$linha."%'";
                      $resultLinha = mysql_query($ql4);
                      $teste = mysql_num_rows($resultLinha);
                      if(!($teste>0))
                      {
                                $ql5 = "Select * from linha where numero_linha = '".$linha."'";
                                $resultLinha = mysql_query($ql5);
                                $teste = mysql_num_rows($resultLinha);
                                if(!($teste>0))
                                {
                                     echo 'Nenhum registro encontrado!';
                                     $flag = 1;
                                }
                           }

                      if($flag == 0)
                      {
                            $linha = mysql_fetch_array($resultLinha);
                            $parada = mysql_fetch_array($resultParada);
                            $idlinha = $linha["id_linha"];
                            $idparada = $parada["id_parada"];
                            echo "<script>
                          	window.location=\"index.php?id=pesquisa&parada=$idparada&linha=$idlinha\";</script>";
                      }
                      }

                }
            }
            elseif($id=="paradas")
            {

                 echo '<form name="Pesquisa" method="post" action="index.php?id=paradas">';
                 echo '<h2>Pesquisa de Paradas</h2><p>Digite o cógido, o local ou a referência da parada para mais informações:</p>';
                 echo "<ul>";
					echo "<li>Parada:<input name=\"parada\" type=\"text\" id=\"parada\" size=30/>";
                     echo "<input type=\"submit\" name=\"button\" id=\"button\" value=\"pesquisar\"/></li>";
			     echo '</form>';
                 //echo "<div id=\"footer\"></div>";
                 $parada = $_POST["parada"];
                 if(!empty($parada) && $parada != " "){
                      $ql = "Select id_parada, local_parada, referencia_parada from parada where referencia_parada LIKE '%".$parada."%'";
                      $resultParada = mysql_query($ql);
                      $teste = mysql_num_rows($resultParada);
                      if($teste>0)
                      {
                           echo '<table cellspacing=1 align="center">';
                           echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Código</td><td width = 190>Referência</td><td width = 130>Local</td>";
                      }else{
                           $ql2 = "Select id_parada, local_parada, referencia_parada from parada where local_parada LIKE '%".$parada."%'";
                           $resultParada = mysql_query($ql2);
                           $teste = mysql_num_rows($resultParada);
                           if($teste>0)
                           {
                                echo '<table cellspacing=1 align="center">';
                                echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Código</td><td width = 190>Referência</td><td width = 130>Local</td>";
                           }
                           else{
                                $ql3 = "Select id_parada,local_parada,referencia_parada from parada where id_parada = '".$parada."'";
                                $resultParada = mysql_query($ql3);
                                $teste = mysql_num_rows($resultParada);
                                if($teste>0)
                                {
                                     echo '<table cellspacing=1 align="center">';
                                     echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Código</td><td width = 190>Referência</td><td width = 130>Local</td>";
                                }
                                else{
                                     echo 'Nenhum registro encontrado!';
                                }
                            }
                       }
                       $i=0;
                       while($linha = mysql_fetch_array($resultParada)){
                       if($i==0){
                             $i=1;
                             echo "<tr bgcolor=beige>";
                       }
                       else{
                             $i=0;
                             echo "<tr bgcolor=white>";
                       }
                       echo "<td>".$linha["id_parada"]."</td>";
                       echo "<td>".$linha["referencia_parada"]."</td>";
                       echo "<td>".$linha["local_parada"]."</td>";

                       }
                       echo "</table>";
                   }

                }
                elseif($id=="linhas")
            {
                 echo "<form name=\"Pesquisa\" method=\"post\" action=\"index.php?id=linhas\">";
                 echo "<h2>Pesquisa de Linhas</h2><p>Digite o número ou a linha para mais informações:</p>";
                 echo "<ul>";
					echo "<li>Linha:<input name=\"linha\" type=\"text\" id=\"linha\" size=30/>";
                     echo "<input type=\"submit\" name=\"button\" id=\"button\" value=\"pesquisar\"/></li>";
			     echo '</form>';
                 //echo "<div id=\"footer\"></div>";
                 $linhapesq = $_POST["linha"];
                 if(!empty($linhapesq) && $linhapesq != " "){
                      $ql = "Select numero_linha,nome_linha from linha where nome_linha LIKE '%".$linhapesq."%'";
                      $resultLinha = mysql_query($ql);
                      $teste = mysql_num_rows($resultLinha);
                      if($teste>0)
                      {
                            echo '<table cellspacing=1 align="center">';
                     echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Número</td><td width = 190>Linha</td>";
                 }else{
                 $ql2 = "Select numero_linha, nome_linha from linha where numero_linha = '".$linhapesq."'";
                 $resultLinha = mysql_query($ql2);
                 $teste = mysql_num_rows($resultLinha);
                 if($teste>0)
                 {
                     echo '<table cellspacing=1 align="center">';
                     echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Número</td><td width = 190>Linha</td>";
                 }
                 else{
                     echo 'Nenhum registro encontrado!';
                 }
                 }
                 $i=0;
                 while($linha = mysql_fetch_array($resultLinha)){
                if($i==0){
                    $i=1;
                    echo "<tr bgcolor=beige>";
                }
                else{
                    $i=0;
                echo "<tr bgcolor=white>";
                }
                echo "<td>".$linha["numero_linha"]."</td>";
                echo "<td>".$linha["nome_linha"]."</td>";
                }
         echo "</table>";
            }

        }
        elseif($id=="pesquisa")
        {
                          $idparada = $_GET['parada'];
                          $idlinha = $_GET['linha'];

                          echo "<h2>Localização de Ônibus</h2>";
                          echo "<p>Resultados";
                          echo "</p>";
                          /*echo "<p>Informe a linha e a parada do ônibus desejado e saiba sua localização:</p>";*/

                          $ql = "Select * from rota where parada_rota = '".$idparada."'";
                          $result = mysql_query($ql);
                          $ordem = mysql_fetch_array($result);
                          $ordemParada = $ordem["ordem_rota"];

                          $ql3 = "Select * from parada where id_parada = '".$idparada."'";
                          $resultaux = mysql_query($ql3);
                          $dadosParada = mysql_fetch_array($resultaux);

                          $ql4 = "Select * from linha where id_linha = '".$idlinha."'";
                          $resultaux2 = mysql_query($ql4);
                          $dadosLinha = mysql_fetch_array($resultaux2);


                          $ql2 = "SELECT * FROM log, onibus, rota WHERE log.onibus_log = onibus.id_onibus AND log.parada_log = rota.parada_rota AND onibus.linha_onibus = rota.linha_rota AND rota.ordem_rota <'".$ordemParada."' AND onibus.linha_onibus ='".$idlinha."' order by rota.ordem_rota DESC";
                         // $ql2 = "Select onibus, parada, onibus, linha, parada, ordem, from log,onibus,rota where log.onibus = onibus.id AND log.parada = rota.parada AND rota.ordem < '".$ordemParada."' AND onibus.linha = '".$idlinha."'";
                          $result2 = mysql_query($ql2);
                               echo "<p style=\"font-size:12px\">Localização dos Ônibus Linha: '".$dadosLinha["nome_linha"]."'</td> próximos à Parada: '".$dadosParada["referencia_parada"]."'</p>";
                                echo '<table cellspacing=1 align="center">';
                                echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Código do ônibus</td><td width = 250>Última passagem na Parada</td><td width = 200>Horário</td>";


                               $i=0;
                              while($linhaResult = mysql_fetch_array($result2)){
                                $data = $linhaResult["data_log"];
                                $hora = substr($data,11,19);
                                $ql5 = "Select * from parada where id_parada = '".$linhaResult["parada_log"]."'";
                                $resultUltimaParada = mysql_query($ql5);
                                $referenciaUltimaParada = mysql_fetch_array($resultUltimaParada);
                              if($i==0){
                                    $i=1;
                                    echo "<tr bgcolor=beige>";
                               }
                               else{
                                    $i=0;
                                    echo "<tr bgcolor=white>";
                               }
                               echo "<td>".$linhaResult["onibus_log"]."</td>";
                               echo "<td>".$referenciaUltimaParada["referencia_parada"]." - ".$referenciaUltimaParada["local_parada"]."</td>";
                               echo "<td>".$hora."</td>";

                              }
                              echo "</table>";

                              echo "<br>";
                              echo "<br>";
                              ?>
                             <div align="center">
                                <label title=" Veja a localização no mapa" style="font-size:12px"></label>
                                Veja a localização no mapa
                             </div>
                              <div align="center">
                                   <iframe src="http://localhost/sislog/mapa.html" style="width: 600px; height: 400px" frameborder="0"/>
                              </div>
                             
        <?php
        }//parei aqui
        elseif($id=="pesquisaLinha")
        {
                echo "<form name=\"Pesquisa\" method=\"POST\" action=\"index.php?id=home\">";
				echo "<h2>Localização de Ônibus</h2>";
				echo "<p>Informe a linha e a parada do ônibus desejado e saiba sua localização:</p>";
				echo "<ul>";

                 echo "<div class=\"entry\">";
                            echo "<div class=\"entrybgtop\">";
                                echo "<div class=\"entrybgbtm\">";
                       echo "<table width=\"613\" border=\"0\">";
                        echo "<tr>";
                       // echo "<li>";
                          echo "<td width=\"25\" style=\"color:#000000\">Linha:</td>";
                          echo "<td width=\"230\"><input name=\"linha\" type=\"text\" id=\"linha\" size=30/></td>";
                          echo "<td width=\"26\" style=\"color:#000000\">Parada:</td>";
                          echo "<td widht=\"209\"><input name=\"parada\" type=\"text\" id=\"parada\" size=30/></td>";
                          echo "<td widht=\"64\"><input type=\"submit\" name=\"button\" id=\"button\" value=\"localizar\"/></td>";
                       echo "</tr>";
                          echo "<tr>";
                          echo "<td>&nbsp;</td>";
                          echo "<td align=\"justify\"><a href=\"index.php?id=linhas\">Pesquisar Linhas</a></td>";
                          echo "<td>&nbsp;</td>";
                          echo "<td align=\"justify\"><a href=\"index.php?id=paradas\">Pesquisar Paradas</a></td>";
                        //echo "</li>";

                   echo "</table>";
                   echo "</div>";
                   echo "</div>";
                   echo "</div>";
				echo "</ul>";
				echo"</form>";

                $idparada = $_GET['parada'];
                $campo = $_GET['campo'];
                // echo "<td><a href=\"index.php?id=pesquisaLinha&parada=$idparada&campo=$parada\">".$array["referencia"]."</td>";

                $ql = "Select * from parada where referencia_parada LIKE '%".$campo."%'";
                      $resultParada = mysql_query($ql);
                      $teste = mysql_num_rows($resultParada);
                      if(!($teste>0))
                      {
                           $ql2 = "Select * from parada where local_parada LIKE '%".$campo."%'";
                           $resultParada = mysql_query($ql2);
                           $teste = mysql_num_rows($resultParada);
                           if(!($teste>0))
                           {
                                $ql3 = "Select * from parada where id_parada LIKE '%".$campo."%'";
                                $resultParada = mysql_query($ql3);
                                $teste = mysql_num_rows($resultParada);
                           }
                      }
                      $ql4 = "Select linha_rota, nome_linha, numero_linha from rota,linha where parada_rota = '".$idparada."' AND rota.linha_rota = linha.id_linha";
                      $resultLinha = mysql_query($ql4);
                      //$dadosLinha = mysql_fetch_array($resultLinha);

                      echo "<br>";
                          echo '<table cellspacing=1 align="center">';
                          echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 50>Código</td>";
                          echo "<td width = 190>Nome </td>";
                          echo "<td width = 190>Local </td>";
                          echo "<td width = 150>Referência</td>";
                          while($array = mysql_fetch_array($resultParada))
                          {
                               $idparadaSelected = $array["id_parada"];
                               if($i==0){
                                    $i=1;
                                    echo "<tr bgcolor=beige>";
                               }
                               else{
                                    $i=0;
                                    echo "<tr bgcolor=white>";
                               }
                               echo "<td><a href=\"index.php?id=pesquisaLinha&parada=$idparadaSelected&campo=$parada\">".$array["id_parada"]."</td>";
                               echo "<td><a href=\"index.php?id=pesquisaLinha&parada=$idparadaSelected&campo=$parada\">".$array["nome_parada"]."</td>";
                               echo "<td><a href=\"index.php?id=pesquisaLinha&parada=$idparadaSelected&campo=$parada\">".$array["local_parada"]."</td>";
                               echo "<td><a href=\"index.php?id=pesquisaLinha&parada=$idparadaSelected&campo=$parada\">".$array["referencia_parada"]."</td>";

                          }
                              echo "</table>";

                              echo "<br>";

                               echo '<table cellspacing=1 align="center">';
                               echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Número</td>";
                               echo "<td width = 190>Linha </td>";

                               while($linha = mysql_fetch_array($resultLinha)){
                                   $idparadaSelec = $_GET['parada'];
                                   $idlinha = $linha["linha_rota"];
                                    if($i==0){
                                         $i=1;
                                         echo "<tr bgcolor=beige>";
                                    }
                                    else{
                                         $i=0;
                                         echo "<tr bgcolor=white>";
                                    }
                                    echo "<td>".$linha["numero_linha"]."</td>";
                                    echo "<td><a href=\"index.php?id=pesquisa&parada=$idparadaSelec&linha=$idlinha\">".$linha["nome_linha"]."</td>";
                                }
                                echo "</table>";

        }

        elseif($id=="pesquisaParada")
        {
                echo "<form name=\"Pesquisa\" method=\"POST\" action=\"index.php?id=home\">";
				echo "<h2>Localização de Ônibus</h2>";
				echo "<p>Informe a linha e a parada do ônibus desejado e saiba sua localização:</p>";
				echo "<ul>";

                 echo "<div class=\"entry\">";
                            echo "<div class=\"entrybgtop\">";
                                echo "<div class=\"entrybgbtm\">";
                       echo "<table width=\"613\" border=\"0\" >";
                        echo "<tr>";
                       // echo "<li>";
                          echo "<td width=\"25\">Linha:</td>";
                          echo "<td width=\"230\"><input name=\"linha\" type=\"text\" id=\"linha\" size=30/></td>";
                          echo "<td width=\"26\">Parada:</td>";
                          echo "<td widht=\"209\"><input name=\"parada\" type=\"text\" id=\"parada\" size=30/></td>";
                          echo "<td widht=\"64\"><input type=\"submit\" name=\"button\" id=\"button\" value=\"localizar\"/></td>";
                       echo "</tr>";
                          echo "<tr>";
                          echo "<td>&nbsp;</td>";
                          echo "<td><a href=\"index.php?id=linhas\">Pesquisar Linhas</a></td>";
                          echo "<td>&nbsp;</td>";
                          echo "<td><a href=\"index.php?id=paradas\">Pesquisar Paradas</a></td>";
                        //echo "</li>";

                   echo "</table>";

                   echo "</div>";
                   echo "</div>";
                   echo "</div>";

				echo "</ul>";
				echo"</form>";

                $idlinha = $_GET['linha'];
                $campo = $_GET['campo'];
                // echo "<td><a href=\"index.php?id=pesquisaLinha&parada=$idparada&campo=$parada\">".$array["referencia"]."</td>";

                $ql = "Select * from linha where nome_linha LIKE '%".$campo."%'";
                      $resultLinha = mysql_query($ql);
                      $teste = mysql_num_rows($resultLinha);
                      if(!($teste>0))
                      {
                                $ql3 = "Select * from linha where numero_linha LIKE '%".$campo."%'";
                                $resultLinha = mysql_query($ql3);
                                $teste = mysql_num_rows($resultLinha);
                      }

                      $ql4 = "Select nome_parada, parada_rota, local_parada, referencia_parada from rota,parada where linha_rota = '".$idlinha."' AND rota.parada_rota = parada.id_parada";
                      $resultParada = mysql_query($ql4);
                      //$dadosLinha = mysql_fetch_array($resultLinha);

                       echo "<br>";
                               echo '<table cellspacing=1 align="center">';
                               echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Número</td>";
                               echo "<td width = 190>Linha</td>";
                               $i = 0;

                              while($linha2 = mysql_fetch_array($resultLinha))
                              {
                                  $idlinhaSelected = $linha2["id_linha"];
                                 // $idparada = $linha2["parada_rota"];
                                  if($i==0){
                                    $i=1;
                                    echo "<tr bgcolor=beige>";
                                  }
                                  else{
                                    $i=0;
                                    echo "<tr bgcolor=white>";
                                  }
                                  echo "<td><a href=\"index.php?id=pesquisaParada&linha=$idlinhaSelected&campo=$linha\">".$linha2["numero_linha"]."</td>";
                               echo "<td><a href=\"index.php?id=pesquisaParada&linha=$idlinhaSelected&campo=$linha\">".$linha2["nome_linha"]."</td>";
                              }
                              echo "</table>";

                              echo "<br>";

                               echo '<table cellspacing=1 align="center">';
                               echo "<tr bgcolor = #ccdddd style=\"color:black\"><td width = 150>Parada</td>";
                               echo "<td width = 190>Local</td>";

                               while($linha = mysql_fetch_array($resultParada)){
                                   // $idparadaSelec = $_GET['parada'];
                                   $idlinhaSelec = $_GET['linha'];
                                   $idparada = $linha["parada_rota"];
                                    if($i==0){
                                         $i=1;
                                         echo "<tr bgcolor=beige>";
                                    }
                                    else{
                                         $i=0;
                                         echo "<tr bgcolor=white>";
                                    }
                                    echo "<td>".$linha["nome_parada"]."</td>";
                                    echo "<td><a href=\"index.php?id=pesquisa&parada=$idparada&linha=$idlinhaSelec\">".$linha["local_parada"]."</td>";
                                }
                                echo "</table>";

        }

         ?>

		</div>
	</div>
	<div id="footer">
    <?php
                         echo "<br>";
                         echo "<br>";
                         
                          echo "<div class=\"meio\">";
                            echo "<div class=\"comeco\">";
                                echo "<div class=\"fim\">";


            echo "</div>";
             echo "</div>";

     echo "</div>";


    ?>
    </div>
</div>

  </div>
 

</body>
</html>

