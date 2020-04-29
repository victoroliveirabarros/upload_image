<?php
class UploadImagem{
public $width; // Definida no arquivo index.php, será a largura máxima da nossa imagem
public $height; // Definida no arquivo index.php, será a altura máxima da nossa imagem
protected $tipos = array("jpeg", "png", "gif", "jpg"); // Nossos tipos de imagem disponíveis para este exemplo

public $mensagem = "";

protected function tirarAcento($texto){
    // array com letras acentuadas
    $com_acento = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ',);
    // array com letras correspondentes ao array anterior, porém sem acento
    $sem_acento = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','0','U','U','U','Y',);
    // procuramos no nosso texto qualquer caractere do primeiro array e substituímos pelo seu correspondente presente no 2º array
    $final = str_replace($com_acento, $sem_acento, $texto);
    // array com pontuação e acentos
    $com_pontuacao = array('´','`','¨','^','~',' ','-');
    // array com substitutos para o array anterior
    $sem_pontuacao = array('','','','','','_','_');
    // procuramos no nosso texto qualquer caractere do primeiro array e substituímos pelo seu correspondente presente no 2º array
    $final = str_replace($com_pontuacao, $sem_pontuacao, $final);
    // retornamos a variável com nosso texto sem pontuações, acentos e letras acentuadas
    return $final;
} // -> fim function tirarAcento()
 
// Função que irá fazer o upload da imagem
public function salvar($caminho, $file){
 
// Retiramos acentos, espaços e hífens do nome da imagem
$file['name'] = $this->tirarAcento(($file['name']));
// Atribuímos caminho e nome da imagem a uma variável apenas
$uploadfile = $caminho.$file['name'];
 
// Guardamos na variável tipo o formato do arquivo enviado
$tipo = strtolower(end(explode('/', $file['type'])));
// Verifica se a imagem enviada é do tipo jpeg, png ou gif
if (array_search($tipo, $this->tipos) === false) {
$mensagem = "<font color='#F00'>Envie apenas imagens no formato jpeg, png ou gif!</font>";
return $mensagem;
}
 
// Se a imagem temporária não for movida para onde a variável com caminho e nome indica, exibiremos uma mensagem de erro
else if (!move_uploaded_file($file['tmp_name'], $uploadfile)) {
switch($file['error']){
case 1:
$mensagem = "<font color='#F00'>O tamanho do arquivo é maior que o tamanho permitido.</font>";
break;
case 2:
$mensagem = "<font color='#F00'>O tamanho do arquivo é maior que o tamanho permitido.</font>";
break;
case 3:
$mensagem = "<font color='#F00'>O upload do arquivo foi feito parcialmente.</font>";
case 4:
$mensagem = "<font color='#F00'>Não foi feito o upload de arquivo.</font>";
break;
} // -> fim switch
 
// Se a imagem temporária for movida
} /* -> fim if */ else{
 
// Pegamos sua largura e altura originais
list($width_orig, $height_orig) = getimagesize($uploadfile);

//conexão com o banco de dados
$servername = "Localhost";
$database = "rede_olt";
$username = "wbt";
$password = "abc@1234WBT";

//criando a conexão

$conn = mysqli_connect($servername, $username, $password, $database);

//checando a conexão

if (!$conn)
{
    die("Connection failed: ".mysqli_connect_error());
}

//Upload efetuado com sucesso, exibe a mensagem
$sql_insert_image = "INSERT INTO imagem_teste (referencia_imagem) VALUES ('".$uploadfile."')";

$result_insert_image = mysqli_query($conn, $sql_insert_image);

if(!$result_insert_image){
    echo "
    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://10.0.30.54/aulas/upload.php'>
    <script type=\"text/javascript\">
        alert(\"Imagem cadastrada com Sucesso.\");
    </script>
";	
}else{
    
}



mysqli_close($conn);
 
// Exibiremos uma mensagem de sucesso
$mensagem = "<a href='".$uploadfile."'><font color='#070'>Upload realizado com sucesso!</font><a>";
} // -> fim else
 
// Retornamos a mensagem com o erro ou sucesso
return $mensagem;
 
} // -> fim function salvar()



} // -> fim classe
?>