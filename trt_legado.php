<?php

class Diario
{
   public $code;

   // declaração de propriedade
   public function init () {

      $url = "https://dejt.jt.jus.br/dejt/f/n/diariocon";

      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      
      $headers = array(
         "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0",
         "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
         "Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
         "Connection: keep-alive",
         "Referer: https://dejt.jt.jus.br/dejt/f/n/diariocon",
         "Upgrade-Insecure-Requests: 1",
      );
   
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
   
      //for debug only!
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__.'/cookies.txt');
   
      $content = curl_exec($curl);
   
      // pegar input validado
      libxml_use_internal_errors(true); // remove erros do DOM
      $documento = new DOMDocument();
      $documento->loadHTML($content);

      $xpath = new DOMXPath($documento);
   
      $code = $xpath->query('//input[@name="javax.faces.ViewState"]/@value')->item(0)->value;
      // $code = str_replace('!', '%21', $code);
      
      $jsessionid = $xpath->query('//form')->item(0)->getAttribute('action');
      preg_match_all('/(?<=jsessionid=).*$/m', $jsessionid, $jsessionid);
      
      $cookies_and_body = [
         'jsessionid' => $jsessionid[0][0],
         'javax_faces_viewstate' => $code
      ];

      print_r($cookies_and_body);
      
      curl_close($curl);

   }

    // declaração de método
   public function download( $cookies_and_body = null ) {

      $url = "https://dejt.jt.jus.br/dejt/f/n/diariocon";
   
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      
      $req = [
         'jsessionid' => "59F90C418B921FA44F66AC88120A2F14.dejt_vm727",
         'javax.faces.ViewState' => "!fxjddpuy3"
      ];

      $headers = array(
         // "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0",
         "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
         "Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
         "Content-Type: application/x-www-form-urlencoded",
         "Origin: https://dejt.jt.jus.br",
         "Connection: keep-alive",
         "Referer: https://dejt.jt.jus.br/dejt/f/n/diariocon;jsessionid={$req['jsessionid']}",
         "Cookie: tipoCadernoDejt=J; resolucaoPlc=1920x1080; resolucaoPlc=1920x1080; JSESSIONID={$req['jsessionid']}",
         "Upgrade-Insecure-Requests: 1",
      );
      
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      
      $data = "corpo%3Aformulario%3AdataIni=10%2F06%2F2021&corpo%3Aformulario%3AdataFim=10%2F06%2F2021&corpo%3Aformulario%3AtipoCaderno=1&corpo%3Aformulario%3Atribunal=21&corpo%3Aformulario%3AordenacaoPlc=&navDe=1&detCorrPlc=&tabCorrPlc=&detCorrPlcPaginado=&exibeEdDocPlc=&indExcDetPlc=&org.apache.myfaces.trinidad.faces.FORM=corpo%3Aformulario&_noJavaScript=false&javax.faces.ViewState={$req['javax.faces.ViewState']}&source=corpo%3Aformulario%3AplcLogicaItens%3A0%3Aj_id131";
      
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      
      //for debug only!
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      
      $resp = curl_exec($curl);
      
      $fp = fopen("diario.pdf", "w");
      fwrite($fp, $resp);
      
      curl_close($curl);
   }
   
   public function teste () {
      
      $url = "https://dejt.jt.jus.br/dejt/f/n/diariocon";
   
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      
      $req = [
         'jsessionid' => "59F90C418B921FA44F66AC88120A2F14.dejt_vm727",
         'javax.faces.ViewState' => "!fxjddpuy3"
      ];

      $headers = array(
         // "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0",
         "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
         "Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3",
         "Content-Type: application/x-www-form-urlencoded",
         "Origin: https://dejt.jt.jus.br",
         "Connection: keep-alive",
         "Referer: https://dejt.jt.jus.br/dejt/f/n/diariocon;jsessionid={$req['jsessionid']}",
         "Cookie: tipoCadernoDejt=J; resolucaoPlc=1920x1080; resolucaoPlc=1920x1080; JSESSIONID={$req['jsessionid']}",
         "Upgrade-Insecure-Requests: 1",
      );
      
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      
      $data = "corpo%3Aformulario%3AdataIni=10%2F06%2F2021&corpo%3Aformulario%3AdataFim=10%2F06%2F2021&corpo%3Aformulario%3AtipoCaderno=1&corpo%3Aformulario%3Atribunal=21&corpo%3Aformulario%3AordenacaoPlc=&navDe=1&detCorrPlc=&tabCorrPlc=&detCorrPlcPaginado=&exibeEdDocPlc=&indExcDetPlc=&org.apache.myfaces.trinidad.faces.FORM=corpo%3Aformulario&_noJavaScript=false&javax.faces.ViewState={$req['javax.faces.ViewState']}&source=corpo%3Aformulario%3AplcLogicaItens%3A0%3Aj_id131";
      
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      
      //for debug only!
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      
      $resp = curl_exec($curl);
      
      // // pegar input validado
      // libxml_use_internal_errors(true); // remove erros do DOM
      // $documento = new DOMDocument();
      // $documento->loadHTML($resp);

      // $xpath = new DOMXPath($documento);
   
      // $code = $xpath->query('//input[@name="javax.faces.ViewState"]/@value')->item(0)->value;
      // // $code = str_replace('!', '%21', $code);
      
      // $jsessionid = $xpath->query('//form')->item(0)->getAttribute('action');
      // preg_match_all('/(?<=jsessionid=).*$/m', $jsessionid, $jsessionid);
      
      // $cookies_and_body = [
      //    'jsessionid' => $jsessionid[0][0],
      //    'javax_faces_viewstate' => $code
      // ];

      // print_r($cookies_and_body);

      $fp = fopen("diario.pdf", "w");
      fwrite($fp, $resp);
      
      curl_close($curl);
   }
}

$diario = new Diario();

$diario->teste();