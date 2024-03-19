<?php
namespace App\Helpers;

use Aws\S3\S3Client;
use Illuminate\Support\Carbon;
use Exception;

class AppUtil{

    public static function Mask($mask,$str){

        $str = str_replace(" ","",$str);

        for($i=0;$i<strlen($str);$i++){
            $mask[strpos($mask,"#")] = $str[$i];
        }

        return $mask;

    }

    public static function gerarSequenciaNomeArquivo($valor){
        // $alfabeto = range('A', 'Z');
        $numero = substr($valor, 0, 5);
        $letra = substr($valor, 5, 7);
        $letra1 = substr($letra, 0, 1);
        $letra2 = substr($letra, 1, 1);
        $letra3 = substr($letra, 2, 1);

        $novoNumero = $numero;
        if($letra == "ZZZ") {
            $novoNumero = $numero + 1;
        } else {
            if($letra3 === "Z") {
                if($letra2 === "Z") {
                    $letra1 = ++$letra1;
                } else {
                    $letra2 = ++$letra2;
                }
            } else {
                $letra3 = ++$letra3;
            }
        }
        return str_pad($novoNumero , 5 , '0' , STR_PAD_LEFT).$letra1.$letra2.$letra3;
    }


    public static function formataDataExibicao($data){
        if($data){
            $date = Carbon::parse($data)->format('d/m/Y');
            return $date;
        }
        return $data;
    }

    public static function dataParaCarbon($data, $divisor = '/'){
        if($data){
            $dataFormat = explode($divisor, $data);
            $dataEnd = Carbon::parse("{$dataFormat[2]}-{$dataFormat[1]}-{$dataFormat[0]}");
            return $dataEnd;
        }
        return $data;
    }

    public static function isDate($date, $divisor = '/', $reverse = false){
        if($date){
            $dateFormat = explode($divisor, $date);
            if($reverse){
                return checkdate($dateFormat[1], $dateFormat[1], $dateFormat[0]);
            } else {
                return checkdate($dateFormat[1], $dateFormat[1], $dateFormat[0]);
            }
        }
        return false;
    }

    public static function dataHoraParaCarbon($data, $hora, $divisor = '/'){
        if($data){
            $dataFormat = explode($divisor, $data);
            $dataHora = Carbon::parse("{$dataFormat[2]}-{$dataFormat[1]}-{$dataFormat[0]} {$hora}");
            return $dataHora;
        }
        return $data;

    }

    public static function dataParaSql($data){
        if($data){
            $dataFormat = explode('/', $data);
            $dataEnd = Carbon::parse("{$dataFormat[2]}-{$dataFormat[1]}-{$dataFormat[0]}")->format('Y-m-d');
            return "'{$dataEnd}'";
        }
        return $data;

    }

    public static function converterParaData($data){
        $dataFormat = explode('/', $data);
        $dataEnd = Carbon::parse("{$dataFormat[2]}-{$dataFormat[1]}-{$dataFormat[0]}");
        return $dataEnd;
    }

    public static function getUltimaDiaByCompetencia($ano, $mes) {
        $data = Carbon::parse("{$ano}-{$mes}-" . date("t", mktime(0, 0, 0, $mes, '01', $ano)));
        return $data;
    }

    public static function limparMascara($param){
        $data = str_replace(".", "", $param);
        $data = str_replace(",", "", $data);
        $data = str_replace("/", "", $data);
        $data = str_replace("-", "", $data);
        $data = str_replace("(", "", $data);
        $data = str_replace(")", "", $data);
        $data = str_replace(" ", "", $data);
        return $data;
    }
    /**
    * Verifica se o valor informado é um valor numerico e maior que zero
    */
    public static function isNumeric($value) {
        if (is_array($value)) {
            if (!isset($value['id']))
                return false;
            else
                $value = $value['id'];
        }
        return (!empty($value) && is_numeric($value) && $value > 0);
    }

    public static function getDiasCompentencia($ano, $mes) {

        // %A || %a - Dia da Semana Texto
        // %d - Dia da Semana Número
        // %B - Nome do Mes
        // %Y - Ano Numero
        // echo $dataini->formatLocalized('%a %d %B %Y'); die;

        $mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $dataini = Carbon::parse("{$ano}-{$mes}-01", 'America/Sao_Paulo');
        $datafim = Carbon::parse("{$ano}-{$mes}-" . date("t", mktime(0, 0, 0, $mes, '01', $ano)), 'America/Sao_Paulo');
        $diashort = (int) $dataini->format('d');

        $dias = array(0 => array('dia' => $diashort, 'diaf' => $diashort . '-' . ucfirst($dataini->formatLocalized('%a'))));
        for ($i = 1; $i < $datafim->format('d'); $i++) {
            $diashort = (int) $dataini->addDay(1)->format('d');
            $dias[] = array('dia' => $diashort, 'diaf' => $diashort . '-' . ucfirst($dataini->formatLocalized('%a')));
        }
        return $dias;
    }

    public static function getClientIp() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function formataCodigo($cod){
        $cod = (int) $cod;
        return str_pad($cod , 2 , '0' , STR_PAD_LEFT);
    }

    public static function formataCodigoDigitos($cod, $digitos){
        $cod = (int) $cod;
        return str_pad($cod , $digitos , '0' , STR_PAD_LEFT);
    }

    public static function formataCnpjCpf($value){
        $cnpj_cpf = preg_replace("/\D/", '', $value);
        if (strlen($cnpj_cpf) === 11) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        }
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }

    public static function formataTelefone($value){
        $telefone = preg_replace("/\D/", '', $value);
        if (strlen($telefone) === 11) {
            return preg_replace("/(\d{2})(\d{5})(\d{4})/", "(\$1) \$2.\$3", $telefone);
        }
        return preg_replace("/(\d{2})(\d{4})(\d{4})/", "(\$1) \$2.\$3", $telefone);
    }

    public static function diaDaSemana($value){
        $semana = [
            'domingo',
            'segunda',
            'terca',
            'quarta',
            'quinta',
            'sexta',
            'sabado',
        ];
        return $semana[$value];
    }

    public static function getMesByNumero($mes){
        $retorno = '';

        switch ($mes) {
            case '01':
                $retorno = 'Janeiro';
                break;
            case '02':
                $retorno = 'Fevereiro';
                break;
            case '03':
                $retorno = 'Marco';
                break;
            case '04':
                $retorno = 'Abril';
                break;
            case '05':
                $retorno = 'Maio';
                break;
            case '06':
                $retorno = 'Junho';
                break;
            case '07':
                $retorno = 'Julho';
                break;
            case '08':
                $retorno = 'Agosto';
                break;
            case '09':
                $retorno = 'Setembro';
                break;
            case '10':
                $retorno = 'Outubro';
                break;
            case '11':
                $retorno = 'Novembro';
                break;
            case '12':
                $retorno = 'Dezembro';
                break;
            default:
                $retorno = $mes;
                break;
        }

        return $retorno;
    }

    public static function getMes($mes){
        $retorno = '';

        switch ($mes) {
            case 1:
                $retorno = 'Janeiro';
                break;
            case 2:
                $retorno = 'Fevereiro';
                break;
            case 3:
                $retorno = 'Marco';
                break;
            case 4:
                $retorno = 'Abril';
                break;
            case 5:
                $retorno = 'Maio';
                break;
            case 6:
                $retorno = 'Junho';
                break;
            case 7:
                $retorno = 'Julho';
                break;
            case 8:
                $retorno = 'Agosto';
                break;
            case 9:
                $retorno = 'Setembro';
                break;
            case 10:
                $retorno = 'Outubro';
                break;
            case 11:
                $retorno = 'Novembro';
                break;
            case 12:
                $retorno = 'Dezembro';
                break;
            default:
                $retorno = $mes;
                break;
        }

        return $retorno;
    }

    public static function getMesCurto($mes){
        $retorno = '';

        switch ($mes) {
            case 1:
                $retorno = 'JAN';
                break;
            case 2:
                $retorno = 'FEV';
                break;
            case 3:
                $retorno = 'MAR';
                break;
            case 4:
                $retorno = 'ABR';
                break;
            case 5:
                $retorno = 'MAI';
                break;
            case 6:
                $retorno = 'JUN';
                break;
            case 7:
                $retorno = 'JUL';
                break;
            case 8:
                $retorno = 'AGO';
                break;
            case 9:
                $retorno = 'SET';
                break;
            case 10:
                $retorno = 'OUT';
                break;
            case 11:
                $retorno = 'NOV';
                break;
            case 12:
                $retorno = 'DEZ';
                break;
            default:
                $retorno = $mes;
                break;
        }

        return $retorno;
    }

    public static function removeCaracteresEspeciais($string, $espaco = null) {

        if (!isset($espaco)) {
            $espaco = '_';
        }

        $aSaida = array('á', 'à', 'ã', 'â', 'é', 'ê', 'í', 'ó', 'ô', 'õ', 'ú', 'ü', 'ç', 'Á', 'À', 'Ã', 'Â', 'É', 'Ê', 'Í', 'Ó', 'Ô', 'Õ', 'Ú', 'Ü', 'Ç', ' ', '(', ')', '.');

        $entrada = "aaaaeeiooouucAAAAEEIOOOUUC" . $espaco;

        $tamEntar = strlen($entrada);

        for ($i = 0; $i < $tamEntar; $i++) {

            $charEntrar = substr($entrada, $i, 1);
            $charSair = $aSaida[$i];
            if (substr_count($string, $charSair) > 0) {
                $string = str_replace($charSair, $charEntrar, $string);
            }
        }

        $nome = strtolower($string);
        $nome = preg_replace('/[áàãâä]/ui', 'a', $nome);
        $nome = preg_replace('/[éèêë]/ui', 'e', $nome);
        $nome = preg_replace('/[íìîï]/ui', 'i', $nome);
        $nome = preg_replace('/[óòõôö]/ui', 'o', $nome);
        $nome = preg_replace('/[úùûü]/ui', 'u', $nome);
        $nome = preg_replace('/[ç]/ui', 'c', $nome);
        $nome = strtoupper($nome);
        $nome = trim($nome);

        return strtoupper($nome);
    }



    public static function removeCaracteresEspeciaisNumeric($string) {
        $string = str_replace(".", "", $string);
        $string = str_replace("(", "", $string);
        $string = str_replace(")", "", $string);
        $string = str_replace("-", "", $string);
        $string = str_replace(" ", "", $string);

        return $string;
    }

    public static function uploadArquivo(array $files, $arrayKey, $filename, $caminho, $exts = array(), $validaExt = true) {
        if ($files) {
            if ($files[$arrayKey]['error'] == 0) {

                if (empty($exts)) {
                    $arrayPermExt = array('jpg', 'pdf', 'gif', 'jpeg', 'doc', 'png', 'docx', 'xls', 'xltx', 'jpeg', 'ppsx', 'pptx', 'xlsx', 'zip', 'rar', 'txt', 'ppt', 'pps', 'tar', 'odt', 'ods', 'odp', 'ret') + $exts;
                } else {
                    $arrayPermExt = $exts;
                }

                $exp = explode('.', $files[$arrayKey]['name']);
                $ext = strtolower(end($exp));

                if (in_array($ext, $arrayPermExt) || $validaExt === false) {
                    try {

                        $dir = $caminho;

                        if (!is_dir($dir))
                            mkdir($dir, 0777, true);

                        if (strpos($filename, '.') !== false) {
                            $arquivoFinal = $filename;
                        } else {
                            $arquivoFinal = "{$filename}.{$ext}";
                        }

                        @unlink("{$dir}{$arquivoFinal}");
                        copy($files[$arrayKey]['tmp_name'], "{$dir}{$arquivoFinal}");

                        return true;
                    } catch (Exception $e) {
                        throw $e;
                    }
                } else {
                    throw new Exception('Tipo de arquivo não permitido!');
                }
            } else {
                throw new Exception('Arquivo corrompido ou vazio!');
            }
        }
    }

    public static function getWeekDay($data) {

        $dia = self::removeCaracteresEspeciais($data->formatLocalized('%a'));
        $dia = strtoupper($dia);

        switch ($dia) {
            case 'DOM':
                return 0;
                break;
            case 'SEG':
                return 1;
                break;
            case 'TER':
                return 2;
                break;
            case 'QUA':
                return 3;
                break;
            case 'QUI':
                return 4;
                break;
            case 'SEX':
                return 5;
                break;
            case 'SAB':
                return 6;
                break;
        }
    }

    public static function removerFormatacaoNumero($strNumero) {

        $strNumero = trim(str_replace("R$", null, $strNumero));

        $vetVirgula = explode(",", $strNumero);
        if (count($vetVirgula) == 1) {
            $acentos = array(".");
            $resultado = str_replace($acentos, "", $strNumero);
            return $resultado;
        } else if (count($vetVirgula) != 2) {
            return $strNumero;
        }

        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr($vetVirgula[1], 0, 2);

        $acentos = array(".");
        $resultado = str_replace($acentos, "", $strNumero);
        $resultado = $resultado . "." . $strDecimal;

        return $resultado;
    }

    public static function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function valorPorExtenso($valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false) {

        $valor = self::removerFormatacaoNumero($valor);

        $singular = null;
        $plural = null;

        if ($bolExibirMoeda) {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
        } else {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
        }

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");


        if ($bolPalavraFeminina) {
            if ($valor == 1) {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
            } else {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
            }
            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas", "quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
        }

        $z = 0;
        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);

        for ($i = 0; $i < count($inteiro); $i++) {
            for ($ii = mb_strlen($inteiro[$i]); $ii < 3; $ii++) {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000")
                $z++;
            elseif ($z > 0)
                $z--;

            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                $r .= (($z > 1) ? " de " : "") . $plural[$t];

            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        $rt = mb_substr($rt, 1);

        return ($rt ? trim($rt) : "zero");
    }

    public static function quote($value){
        return $value;
    }

    public static function setFlush() {
        set_time_limit(0);

        // Turn off output buffering
        ini_set('output_buffering', 'off');
        // Turn off PHP output compression
        ini_set('zlib.output_compression', false);
        // Implicitly flush the buffer(s)
        ini_set('implicit_flush', true);
        ob_implicit_flush(true);
        // Clear, and turn off output buffering

        while (ob_get_level() > 0) {
            // Get the curent level
            $level = ob_get_level();
            // End the buffering
            ob_end_clean();
            // If the current level has not changed, abort
            if (ob_get_level() == $level)
                break;
        }

        // Disable apache output buffering/compression
        if (function_exists('apache_setenv')) {
            apache_setenv('no-gzip', '1');
            apache_setenv('dont-vary', '1');
        }
    }

    public static function formatarZeroEsquerda($valor, $caractere) {
        $valor = str_pad($valor, $caractere, '0', STR_PAD_LEFT);
        return $valor;
    }

    public static function formatarEmReais(float $val): string {
        return number_format($val , 2, ',', '.');
    }

    public static function removerPontosEVirgulas(string $str): string {
        $str = str_replace('.', '', $str); // remove o ponto
        return str_replace(',', '.', $str);
    }

    public static function clearMask($var) {
		return preg_replace("/[_\W]/", "", $var);
    }

    public static function getDataJsonLabelValue($params, $name, $field){
        $result = [];

        if(!isset($params[$name]) || empty($params[$name])) {
            return $result;
        }

        $data = json_decode($params[$name]);
        if(is_array($field)) {
            foreach($field as $n) {
                if(isset($data->$n)) {
                    foreach($data->$n as $item) {
                        $result[$n][] = $item->value;
                    }
                }
            }
        } else {
            if($data->$field) {
                foreach($data->$field as $item) {
                    $result[] = [
                        'label' => $item->label,
                        'value' => $item->value,
                    ];
                }
            }
        }
        return $result;
    }

    public static function getDataJsonLabelValueUnique($params, $name){
        $result = [];
        if(!isset($params[$name]) || empty($params[$name])) {
            return $result;
        }
        if(count($params[$name])) {
            foreach($params[$name] as $item) {
                $data = json_decode($item);
                $result[] = $data->value;
            }
        }
        return $result;
    }

    public static function getOrgaosId($sessioorgao){

        $user_orgaos_ids = array_map(function($orgao){
            return $orgao->orgao_id;
          }, $sessioorgao);

        return !empty($user_orgaos_ids) ? implode(', ', $user_orgaos_ids) : '0';
    }

    public static function validaCPF($cpf) {

        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;

    }

    public static function cpfForPassword($cpf){
        $first = substr($cpf, 0, 3);
        $second = substr($cpf, 9, 11);
        return $first.$second;
    }

    public static function issetEmpty($params, $name) {
        if(isset($params[$name]) && !empty($params[$name])) {
            // not empty
            return false;
        }
        // empty
        return true;
    }

    public static function uploadS3($file) {
        // Verifica se o arquivo é válido
        if ($file->isValid()) {
            // Configuração do S3
            $s3 = new S3Client([
                'version' => 'latest',
                'region' => env('AWS_DEFAULT_REGION'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            // Nome do arquivo no S3 (pode ser modificado conforme necessário)
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Caminho completo no bucket do S3
            $filePath = $fileName;

            // Faz o upload do arquivo para o S3
            $result = $s3->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key' => $filePath,
                'Body' => fopen($file->getRealPath(), 'rb'),
                'ACL' => 'public-read', // Defina as permissões adequadas
            ]);

            // Verifica se o upload foi bem-sucedido
            if ($result['@metadata']['statusCode'] === 200) {
                // Retorna o URL público do arquivo no S3
                return $result['ObjectURL'];
            } else {
                // Caso ocorra algum erro durante o upload
                return null;
            }
        } else {
            // Caso o arquivo não seja válido
            return null;
        }
    }
}
