<?php

//Receber os dados da imagem
$dados_imagem = $_FILES['image'];

//Diretório que será salvo a imagem
$diretorio = 'imagens/';

//Gerar uma chave para o nome do arquivo
$chave = substr(md5(rand()), 0, 16);
$extensao = pathinfo($dados_imagem['name'], PATHINFO_EXTENSION);
$nome_arquivo = $chave . "." . $extensao;

//Upload do arquivo
//move_uploaded_file($dados_imagem['tmp_name'], $diretorio . $dados_imagem['name']);
move_uploaded_file($dados_imagem['tmp_name'], $diretorio . $nome_arquivo);

$retorno['success'] = true;
$retorno['file'] = "http://localhost/gerenciar-registro-v0.2/imagens/" . $nome_arquivo;

echo json_encode($retorno);
