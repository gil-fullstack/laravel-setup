<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conteudo;
use App\Produto;
use App\CategoriaProduto;
use App\Categoria;
use App\Funcionalidade;
use App\Subfuncionalidade;
use App\FuncionalidadeProduto;
use App\Cliente;
use App\Checkout;
use App\Checkout2;
use App\ProdutoModelo;
use Carbon\Carbon;
use App\Contato;
use App\Pagina;
use App\Download;
use App\Configuracao;
use App\User;
use App\Arvore;
use App\ProdutoArvore;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\NoticiasMail;
use Illuminate\Support\Facades\Mail;

class CMSController extends Controller
{
  public function __construct(){
      $this->middleware('auth');
  }

  public function Conteudo(Request $request){

    $pesquisa = '';
    $pagina_id = 0;

    $conteudo = Conteudo::select('site_paginas.titulo as pagina','site_conteudos.id as id','site_conteudos.titulo as titulo','site_conteudos.destaque as destaque','site_conteudos.ordem as ordem','site_conteudos.updated_at as updated_at')
    ->join('site_paginas','site_paginas.id','site_conteudos.pagina_id')
    ->orderBy('site_conteudos.ordem')
    ->orderBy('site_conteudos.updated_at','desc');


    if($request->pesquisa){

      $pesquisa = $request->pesquisa;

      $conteudo->where(function($query) use($pesquisa){
        $query->where('site_conteudos.titulo', 'like', '%'.$pesquisa.'%')
              ->orWhere('site_conteudos.descricao', 'like', '%'.$pesquisa.'%')
              ->orWhere('site_conteudos.texto', 'like', '%'.$pesquisa.'%')
              ->orWhere('site_paginas.titulo', 'like', '%'.$pesquisa.'%');
      });
    }

    if($request->pagina_id){
      $pagina_id = $request->pagina_id;

      $conteudo->where('pagina_id',$pagina_id);
    }

    $conteudo = $conteudo->paginate(20);


    $paginas = Pagina::all()->sortBy('titulo');

    return view('cms/conteudo', compact('conteudo','paginas','pesquisa','pagina_id'));
  }

  public function ConteudoForm($id = null){

    $paginas = Pagina::all()->sortBy('titulo');

    if($id){
      $conteudo = Conteudo::find($id);

      if($conteudo){
        return view('cms/conteudo_form', compact('paginas','conteudo'));
      }
      else{
        abort(404);
      }
    }
    else{
      return view('cms/conteudo_form', compact('paginas'));
    }



  }

  public function ConteudoSalvar(Request $request){

    if($request->imagem && $request->imagem != 'blocked'){

      $extension = explode('/', explode(';', $request->imagem)[0])[1];
      $imageName = Str::random(10).'.'.$extension;

      if (preg_match('/^data:image\/(\w+);base64,/', $request->imagem)) {
        $data = substr($request->imagem, strpos($request->imagem, ',') + 1);
        $data = base64_decode($data);
        Storage::put('images/'.$imageName, $data);
      }

      $imagem = 'images/'.$imageName;
    }
    else{
      $imagem = null;
    }

    if($request->imagem_responsiva && $request->imagem_responsiva != 'blocked'){

      $extension = explode('/', explode(';', $request->imagem_responsiva)[0])[1];
      $imageName = Str::random(10).'.'.$extension;

      if (preg_match('/^data:image\/(\w+);base64,/', $request->imagem_responsiva)) {
        $data = substr($request->imagem_responsiva, strpos($request->imagem_responsiva, ',') + 1);
        $data = base64_decode($data);
        Storage::put('images/'.$imageName, $data);
      }

      $imagem_responsiva = 'images/'.$imageName;
    }
    else{
      $imagem_responsiva = null;
    }

    if($request->arquivo && $request->arquivo != 'blocked'){
      $arquivo = 'arquivos/'.$request->file('arquivo')->hashName();

      Storage::putFileAs(
        'arquivos', $request->file('arquivo'), $request->file('arquivo')->hashName()
      );
    }
    else{
      $arquivo = null;
    }

    if($request->id){

      $conteudo = Conteudo::find($request->id);



      $conteudo->titulo = $request->titulo;
      $conteudo->descricao = $request->descricao;
      $conteudo->texto = $request->texto;
      if($request->imagem != 'blocked'){
        $conteudo->imagem = $imagem;
      }
      if($request->imagem_responsiva != 'blocked'){
        $conteudo->imagem_responsiva = $imagem_responsiva;
      }
      if($request->arquivo != 'blocked'){
        $conteudo->arquivo = $arquivo;
      }
      $conteudo->destaque = $request->destaque;
      if($request->pagina_id != $conteudo->pagina_id){
        $conteudo_count = Conteudo::where('pagina_id',$request->pagina_id)->where('id','!=',$request->id)->orderBy('ordem','desc')->first();
        Conteudo::where('pagina_id',$conteudo->pagina_id)->where('ordem','>',$conteudo->ordem)->decrement('ordem',1);
        $conteudo->ordem = $conteudo_count ? $conteudo_count->ordem+1 : 1;
      }
      $conteudo->pagina_id = $request->pagina_id;
      $conteudo->link = $request->link;

      $conteudo->save();
    }
    else{

      $conteudo_count = Conteudo::where('pagina_id',$request->pagina_id)->orderBy('ordem','desc')->first();

      $conteudo = Conteudo::create([
        'titulo' => $request->titulo,
        'descricao' => $request->descricao,
        'texto' => $request->texto,
        'imagem' => $imagem,
        'destaque' => $request->destaque,
        'pagina_id' => $request->pagina_id,
        'ordem' => $conteudo_count ? $conteudo_count->ordem+1 : 1,
        'imagem_responsiva' => $imagem_responsiva,
        'arquivo' => $arquivo,
        'link' => $request->link
      ]);

      if($request->pagina_id == 3 && $request->sendmail == 1){

        $this->enviarEmailNoticia($conteudo);

      }
    }

    return redirect('cms/conteudo');
  }

  public function enviarEmailNoticia($conteudo){
    $clientes = Cliente::selectRaw('distinct(email) as email')->where('email','!=',"")->whereNotNull('email')->limit(10)->get();

    $email_list = [];

    foreach ($clientes as $item) {
      $email_formatted = str_replace(" ","",strtolower($item->email));
      $arr_email = explode(';',$email_formatted);
      foreach ($arr_email as $email) {
        array_push($email_list, $email);
      }

    }

    $email_test_list = [];
    array_push($email_test_list,'guilhermemiranda.ti@gmail.com');

    if (PATH_SEPARATOR == ';') {
        $quebra_linha = "\r\n";
    }
    elseif (PATH_SEPARATOR == ':') {
        $quebra_linha = "\n";
    }
    elseif (PATH_SEPARATOR != ';' && PATH_SEPARATOR != ':') {
        echo ('Esse script não funcionará corretamente neste servidor, a função PATH_SEPARATOR não retornou o parâmetro esperado.');
    }

    $texto = '
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
              <meta name="format-detection" content="telephone=no" /> <!-- disable auto telephone linking in iOS -->
              <style type="text/css">
                  html { background-color:#E1E1E1; margin:0; padding:0; }
                  body, #bodyTable, #bodyCell, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica, Arial, "Lucida Grande", sans-serif;}
                  table{border-collapse:collapse;}
                  table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}
                  img, a img{border:0; outline:none; text-decoration:none;height:auto; line-height:100%;}
                  a {text-decoration:none !important;border-bottom: 1px solid;}
                  h1, h2, h3, h4, h5, h6{color:#5F5F5F; font-weight:normal; font-family:Helvetica; font-size:20px; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}
                  .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail/Outlook.com to display emails at full width. */
                  .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%;} /* Force Hotmail/Outlook.com to display line heights normally. */
                  table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remove spacing between tables in Outlook 2007 and up. */
                  #outlook a{padding:0;} /* Force Outlook 2007 and up to provide a "view in browser" message. */
                  img{-ms-interpolation-mode: bicubic;display:block;outline:none; text-decoration:none;} /* Force IE to smoothly render resized images. */
                  body, table, td, p, a, li, blockquote{-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; font-weight:normal!important;} /* Prevent Windows- and Webkit-based mobile platforms from changing declared text sizes. */
                  .ExternalClass td[class="ecxflexibleContainerBox"] h3 {padding-top: 10px !important;} /* Force hotmail to push 2-grid sub headers down */
                  h1{display:block;font-size:26px;font-style:normal;font-weight:normal;line-height:100%;}
                  h2{display:block;font-size:20px;font-style:normal;font-weight:normal;line-height:120%;}
                  h3{display:block;font-size:17px;font-style:normal;font-weight:normal;line-height:110%;}
                  h4{display:block;font-size:18px;font-style:italic;font-weight:normal;line-height:100%;}
                  .flexibleImage{height:auto;}
                  .linkRemoveBorder{border-bottom:0 !important;}
                  table[class=flexibleContainerCellDivider] {padding-bottom:0 !important;padding-top:0 !important;}
                  body, #bodyTable{background-color:#E1E1E1;}
                  #emailHeader{background-color:#E1E1E1;}
                  #emailBody{background-color:#FFFFFF;}
                  #emailFooter{background-color:#E1E1E1;}
                  .nestedContainer{background-color:#F8F8F8; border:1px solid #CCCCCC;}
                  .emailButton{background-color:#205478; border-collapse:separate;}
                  .buttonContent{color:#FFFFFF; font-family:Helvetica; font-size:18px; font-weight:bold; line-height:100%; padding:15px; text-align:center;}
                  .buttonContent a{color:#FFFFFF; display:block; text-decoration:none!important; border:0!important;}
                  .emailCalendar{background-color:#FFFFFF; border:1px solid #CCCCCC;}
                  .emailCalendarMonth{background-color:#205478; color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; padding-top:10px; padding-bottom:10px; text-align:center;}
                  .emailCalendarDay{color:#205478; font-family:Helvetica, Arial, sans-serif; font-size:60px; font-weight:bold; line-height:100%; padding-top:20px; padding-bottom:20px; text-align:center;}
                  .imageContentText {margin-top: 10px;line-height:0;}
                  .imageContentText a {line-height:0;}
                  #invisibleIntroduction {display:none !important;} /* Removing the introduction text from the view */
                  span[class=ios-color-hack] a {color:#275100!important;text-decoration:none!important;} /* Remove all link colors in IOS (below are duplicates based on the color preference) */
                  span[class=ios-color-hack2] a {color:#205478!important;text-decoration:none!important;}
                  span[class=ios-color-hack3] a {color:#8B8B8B!important;text-decoration:none!important;}
                  .a[href^="tel"], a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important;}
                  .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important;}
                  @media only screen and (max-width: 480px){
                      body{width:100% !important; min-width:100% !important;} /* Force iOS Mail to render the email at full width. */
                      /*td[class="textContent"], td[class="flexibleContainerCell"] { width: 100%; padding-left: 10px !important; padding-right: 10px !important; }*/
                      table[id="emailHeader"],
                      table[id="emailBody"],
                      table[id="emailFooter"],
                      table[class="flexibleContainer"],
                      td[class="flexibleContainerCell"] {width:100% !important;}
                      td[class="flexibleContainerBox"], td[class="flexibleContainerBox"] table {display: block;width: 100%;text-align: left;}
                      td[class="imageContent"] img {height:auto !important; width:100% !important; max-width:100% !important; }
                      img[class="flexibleImage"]{height:auto !important; width:100% !important;max-width:100% !important;}
                      img[class="flexibleImageSmall"]{height:auto !important; width:auto !important;}
                      table[class="flexibleContainerBoxNext"]{padding-top: 10px !important;}
                      table[class="emailButton"]{width:100% !important;}
                      td[class="buttonContent"]{padding:0 !important;}
                      td[class="buttonContent"] a{padding:15px !important;}
                  }
                  /*  CONDITIONS FOR ANDROID DEVICES ONLY
                  *   http://developer.android.com/guide/webapps/targeting.html
                  *   http://pugetworks.com/2011/04/css-media-queries-for-targeting-different-mobile-devices/ ;
                  =====================================================*/
                  @media only screen and (-webkit-device-pixel-ratio:.75){
                      /* Put CSS for low density (ldpi) Android layouts in here */
                  }
                  @media only screen and (-webkit-device-pixel-ratio:1){
                      /* Put CSS for medium density (mdpi) Android layouts in here */
                  }
                  @media only screen and (-webkit-device-pixel-ratio:1.5){
                      /* Put CSS for high density (hdpi) Android layouts in here */
                  }
                  /* end Android targeting */
                  /* CONDITIONS FOR IOS DEVICES ONLY
                  =====================================================*/
                  @media only screen and (min-device-width : 320px) and (max-device-width:568px) {
                  }
                  /* end IOS targeting */
              </style>
              <!--[if mso 12]>
                  <style type="text/css">
                      .flexibleContainer{display:block !important; width:100% !important;}
                  </style>
              <![endif]-->
              <!--[if mso 14]>
                  <style type="text/css">
                      .flexibleContainer{display:block !important; width:100% !important;}
                  </style>
              <![endif]-->
          </head>
          <body bgcolor="#E1E1E1" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
              <center style="background-color:#E1E1E1;">
                  <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
                      <tr>
                          <td align="center" valign="top" id="bodyCell">
                              <table bgcolor="#E1E1E1" border="0" cellpadding="0" cellspacing="0" width="500" id="emailHeader">
                                  <tr>
                                      <td align="center" valign="top">
                                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td align="center" valign="top">
                                                      <table border="0" cellpadding="10" cellspacing="0" width="500" class="flexibleContainer">
                                                          <tr>
                                                              <td valign="top" width="500" class="flexibleContainerCell">
                                                                  <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                      <tr>
                                                                          <td align="center" valign="middle" class="flexibleContainerBox">
                                                                              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:100%;">
                                                                                  <tr>
                                                                                      <td align="left" class="textContent">
                                                                                          <div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;">
                                                                                              Se voc&ecirc; n&atilde;o pode ver essa mensagem, <a href="#" target="_blank" style="text-decoration:none;border-bottom:1px solid #828282;color:#828282;"><span style="color:#828282;">visualize&nbsp;no&nbsp;seu&nbsp;navegador</span></a>.
                                                                                          </div>
                                                                                      </td>
                                                                                  </tr>
                                                                              </table>
                                                                          </td>
                                                                      </tr>
                                                                  </table>
                                                              </td>
                                                          </tr>
                                                      </table>
                                                  </td>
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                              </table>
                              <table bgcolor="#FFFFFF"  border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody">
                                  <tr>
                                      <td align="center" valign="top">
                                          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#3498db">
                                              <tr>
                                                  <td align="center" valign="top">
                                                      <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                          <tr>
                                                              <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                  <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                      <tr>
                                                                          <td align="center" valign="top" class="textContent">
                                                                              <img src="https://ciaf.com.br/site/images/logo.png" width="300" height="70" alt="CIAF">
                                                                          </td>
                                                                      </tr>
                                                                  </table>
                                                              </td>
                                                          </tr>
                                                      </table>
                                                  </td>
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                                  <tr mc:hideable>
                                      <td align="center" valign="top">
                                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td align="center" valign="top">
                                                      <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                          <tr>
                                                              <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                  <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                      <tr>
                                                                          <td align="center" valign="top">
                                                                              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                                  <tr>
                                                                                      <td valign="top" class="textContent">
                                                                                          <h3 style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">Tem uma nova not&iacute;cia no CIAF</h3>
                                                                                          <hr></hr>
                                                                                          <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">
                                                                                              '.$conteudo->descricao.'
                                                                                          </div>
                                                                                      </td>
                                                                                  </tr>
                                                                              </table>
                                                                          </td>
                                                                      </tr>
                                                                  </table>
                                                              </td>
                                                          </tr>
                                                      </table>
                                                  </td>
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td align="center" valign="top">
                                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr style="padding-top:0;">
                                                  <td align="center" valign="top">
                                                      <table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
                                                          <tr>
                                                              <td style="padding-top:0;" align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                  <table border="0" cellpadding="0" cellspacing="0" width="50%" class="emailButton" style="background-color: #3498DB;">
                                                                      <tr>
                                                                          <td align="center" valign="middle" class="buttonContent" style="padding-top:15px;padding-bottom:15px;padding-right:15px;padding-left:15px;">
                                                                              <a style="color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:135%;" href="http://site.ciaf.com.br/noticias_detalhes/91" target="_blank">Leia mais</a>
                                                                          </td>
                                                                      </tr>
                                                                  </table>
                                                              </td>
                                                          </tr>
                                                      </table>
                                                  </td>
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                              </table>
                              <table bgcolor="#E1E1E1" border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter">
                                  <tr>
                                      <td align="center" valign="top">
                                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td align="center" valign="top">
                                                      <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                          <tr>
                                                              <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                  <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                      <tr>
                                                                          <td valign="top" bgcolor="#E1E1E1">
                                                                              <div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;">
                                                                                  <div>Copyright &#169; ' . date('Y') . '. Todos&nbsp;os&nbsp;direitos&nbsp;reservados.</div>
                                                                              </div>
                                                                          </td>
                                                                      </tr>
                                                                  </table>
                                                              </td>
                                                          </tr>
                                                      </table>
                                                  </td>
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                  </table>
              </center>
          </body>
      </html>
      ';
    $de = "vendas@ciaf.com.br";

    $assunto = "Nova notícia no site do CIAF - ".$conteudo->titulo;
    $assunto = '=?UTF-8?B?'.base64_encode($assunto).'?=';

    $from = "CIAF - Soluções em Software";
    $from = '=?UTF-8?B?'.base64_encode($from).'?=';

    $headers = "MIME-Version: 1.0" . $quebra_linha . "";
    $headers .= "From: " . $from . "<" . $de . ">" . $quebra_linha . "";
    $headers .= "Return-Path: " . $de . $quebra_linha . "";
    $headers .= "Content-type: text/html; charset=iso-8859-1" . $quebra_linha . "";

    foreach ($email_list as $item) {

      mail($item, $assunto, $texto, $headers, "-r" . $de);
    }

  }

  public function AlterarOrdem(Request $request){

    if($request->tipo == 'produto'){

      $produto = Produto::find($request->id);

      if($request->mover == 'up'){

        if($produto->ordem <= 1){
          return response()->json(['success' => true]);
        }

        Produto::where('categoria_produtos_id',$produto->categoria_produtos_id)
        ->where('id','<>',$request->id)
        ->where('ordem','<',$produto->ordem)
        ->orderBy('ordem','desc')
        ->limit(1)
        ->increment('ordem');

        $produto->ordem = $produto->ordem-1;
        $produto->save();

      }
      elseif ($request->mover == 'down') {
        $produtos_count = Produto::where('categoria_produtos_id',$produto->categoria_produtos_id)->count();

        if($produto->ordem >= $produtos_count){
          return response()->json(['success' => true]);
        }

        Produto::where('categoria_produtos_id',$produto->categoria_produtos_id)
        ->where('id','<>',$request->id)
        ->where('ordem','>',$produto->ordem)
        ->orderBy('ordem','asc')
        ->limit(1)
        ->decrement('ordem');

        $produto->ordem = $produto->ordem+1;
        $produto->save();
      }
    }
    elseif($request->tipo == 'conteudo'){
      $conteudo = Conteudo::find($request->id);

      if($request->mover == 'up'){

        if($conteudo->ordem <= 1){
          return response()->json(['success' => true]);
        }

        Conteudo::where('pagina_id',$conteudo->pagina_id)
        ->where('id','<>',$request->id)
        ->where('ordem','<',$conteudo->ordem)
        ->orderBy('ordem','desc')
        ->limit(1)
        ->increment('ordem');

        $conteudo->ordem = $conteudo->ordem-1;
        $conteudo->save();
      }
      elseif ($request->mover == 'down') {

        $conteudos_count = Conteudo::where('pagina_id',$conteudo->pagina_id)->count();

        if($conteudo->ordem >= $conteudos_count){
          return response()->json(['success' => true]);
        }

        Conteudo::where('pagina_id',$conteudo->pagina_id)
        ->where('id','<>',$request->id)
        ->where('ordem','>',$conteudo->ordem)
        ->orderBy('ordem','asc')
        ->limit(1)
        ->decrement('ordem');

        $conteudo->ordem = $conteudo->ordem+1;
        $conteudo->save();
      }

      return response()->json(['success' => true]);
    }
    elseif($request->tipo == 'categoria'){
      $categoria = CategoriaProduto::find($request->id);

      if($request->mover == 'up'){

        if($categoria->ordem <= 1){
          return response()->json(['success' => true]);
        }

        CategoriaProduto::where('id','<>',$request->id)
        ->where('ordem','<',$categoria->ordem)
        ->orderBy('ordem','desc')
        ->limit(1)
        ->increment('ordem');

        $categoria->ordem = $categoria->ordem-1;
        $categoria->save();
      }
      elseif ($request->mover == 'down') {

        $conteudos_count = CategoriaProduto::count();

        if($categoria->ordem >= $conteudos_count){
          return response()->json(['success' => true]);
        }

        CategoriaProduto::where('id','<>',$request->id)
        ->where('ordem','>',$categoria->ordem)
        ->orderBy('ordem','asc')
        ->limit(1)
        ->decrement('ordem');

        $categoria->ordem = $categoria->ordem+1;
        $categoria->save();
      }

      return response()->json(['success' => true]);
    }

  }

  public function Deletar(Request $request){

    switch ($request->tipo) {
      case 'conteudo':
        $item = Conteudo::find($request->id);
        Conteudo::where('pagina_id',$item->pagina_id)->where('ordem','>',$item->ordem)->decrement('ordem',1);
        $item->delete();
      break;
      case 'categoria_produto':
        $produtos = Produto::where('categoria_produtos_id',$request->id)->count();

        if($produtos > 0){
          return response()->json(['error' => 'Exclua todos os produtos da categoria antes de excluir essa categoria.']);
        }
        else{
          $item = CategoriaProduto::find($request->id);
          CategoriaProduto::where('ordem','>',$item->ordem)->decrement('ordem',1);
          $item->delete();
        }

      break;
      case 'categoria':
        $produto_modelo = ProdutoModelo::where('categoria_id',$request->id)->count();
        if($produto_modelo > 0){
          return response()->json(['error' => 'Exclua todos os modelos da categoria antes de excluir essa categoria.']);
        }
        else{
          Categoria::find($request->id)->delete();
        }
      break;
      case 'checkout':
        Checkout::find($request->id)->delete();
      break;
      case 'contato':
        Contato::find($request->id)->delete();
      break;
      case 'download':
        Download::find($request->id)->delete();
      break;
      case 'modelo':
        ProdutoModelo::find($request->id)->delete();
      break;
      case 'produto':
        $item = Produto::find($request->id);
        Produto::where('categoria_produtos_id',$item->categoria_produtos_id)->where('ordem','>',$item->ordem)->decrement('ordem',1);
        $item->delete();
      break;
      case 'usuarios':
        User::find($request->id)->delete();
      break;
      case 'funcionalidades':
        $funcionalidades = Subfuncionalidade::where('funcionalidades_id',$request->id)->count();

        if($funcionalidades > 0){
          return response()->json(['error' => 'Exclua todas as subfuncionalidades antes de excluir essa funcionalidade.']);
        }
        else{
          Funcionalidade::find($request->id)->delete();
        }

      break;
      case 'subfuncionalidades':
        Subfuncionalidade::find($request->id)->delete();
      break;
    }

    return response()->json(['success' => true]);
  }

  public function Produto(Request $request){
    $pesquisa = '';
    $categoria_id = 0;

    $produto = Produto::select('site_produtos.titulo as titulo','site_categoria_produtos.titulo as categoria','site_produtos.id as id','site_produtos.ordem as ordem','site_produtos.destaque as destaque')
    ->join('site_categoria_produtos','site_categoria_produtos.id','site_produtos.categoria_produtos_id')
    ->orderBy('site_produtos.ordem')
    ->orderBy('site_produtos.updated_at','desc');

    if($request->pesquisa){

      $pesquisa = $request->pesquisa;

      $produto->where(function($query) use($pesquisa){
        $query->where('site_produtos.titulo', 'like', '%'.$pesquisa.'%')
              ->orWhere('site_produtos.descricao', 'like', '%'.$pesquisa.'%')
              ->orWhere('site_produtos.texto', 'like', '%'.$pesquisa.'%')
              ->orWhere('site_categoria_produtos.titulo', 'like', '%'.$pesquisa.'%');
      });
    }

    if($request->categoria_id){
      $categoria_id = $request->categoria_id;

      $produto->where('categoria_produtos_id',$categoria_id);
    }

    $produto = $produto->paginate(20);


    $categorias = CategoriaProduto::all()->sortBy('titulo');

    return view('cms/produto', compact('produto','categorias','pesquisa','categoria_id'));
  }

  public function ProdutoForm($id = null){

    $categoria_produtos = CategoriaProduto::all()->sortBy('titulo');
    $funcionalidades = Subfuncionalidade::all()->sortBy('funcionalidades_id');
    $json_arvore = Arvore::get();

    if($id){
      $produto = Produto::find($id);
      $produto_arvore = Produto::find($id)->arvores;
      if($produto){
        return view('cms/produto_form', compact('categoria_produtos','produto','funcionalidades', 'json_arvore', 'produto_arvore'));
      }
      else{
        abort(404);
      }
    }
    else{
      return view('cms/produto_form', compact('categoria_produtos','funcionalidades', 'json_arvore'));
    }


  }

  public function ProdutoSalvar(Request $request){

    if($request->link_download && $request->link_download != 'blocked'){
      Storage::putFileAs(
        'arquivos', $request->file('link_download'), $request->file('link_download')->hashName().'.'.$request->file('link_download')->getClientOriginalExtension()
      );

      $arquivo = $request->file('link_download')->hashName().'.'.$request->file('link_download')->getClientOriginalExtension();
    }
    else{
      $arquivo = null;
    }

    if($request->imagem && $request->imagem != 'blocked'){
      $extension = explode('/', explode(';', $request->imagem)[0])[1];
      $imageName = Str::random(10).'.'.$extension;

      if (preg_match('/^data:image\/(\w+);base64,/', $request->imagem)) {
        $data = substr($request->imagem, strpos($request->imagem, ',') + 1);
        $data = base64_decode($data);
        Storage::put('images/'.$imageName, $data);
      }

      $imagem = 'images/'.$imageName;

      // Storage::putFileAs(
      //   'images', $request->file('imagem'), $request->file('imagem')->hashName()
      // );
      //
      // $imagem = 'images/'.$request->file('imagem')->hashName();
    }
    else{
      $imagem = null;
    }

    if($request->imagem_destaque && $request->imagem_destaque != 'blocked'){
      $extension = explode('/', explode(';', $request->imagem_destaque)[0])[1];
      $imageName = Str::random(10).'.'.$extension;

      if (preg_match('/^data:image\/(\w+);base64,/', $request->imagem_destaque)) {
        $data = substr($request->imagem_destaque, strpos($request->imagem_destaque, ',') + 1);
        $data = base64_decode($data);
        Storage::put('images/'.$imageName, $data);
      }

      $imagem_destaque = 'images/'.$imageName;

      // Storage::putFileAs(
      //   'images', $request->file('imagem_destaque'), $request->file('imagem_destaque')->hashName()
      // );
      //
      // $imagem_destaque = 'images/'.$request->file('imagem_destaque')->hashName();
    }
    else{
      $imagem_destaque = null;
    }

    if($request->id){

      $produto = Produto::find($request->id);
      $produto->titulo = $request->titulo;
      $produto->descricao = $request->descricao;
      $produto->detalhes = $request->detalhes;
      $produto->texto = $request->texto;
      $produto->destaque = $request->destaque;
      $produto->categoria_produtos_id = $request->categoria_produtos_id;
      if($request->link_download != 'blocked'){
        $produto->link_download = $arquivo;
      }
      if($request->imagem != 'blocked'){
        $produto->imagem = $imagem;
      }
      if($request->imagem_destaque != 'blocked'){
        $produto->imagem_destaque = $imagem_destaque;
      }
      $produto->save();
      $arvore_produto = ProdutoArvore::where('produto_id', $request->id)->where('arvore_id', $request->arvores_totais)->first();

      if($arvore_produto != null){

        $arvore_produto->funcionalidades_selecionadas = $request->arvore_nodes;
        $arvore_produto->save();
      
      }else{
        
        if ($request->arvores_totais) {
          # code...
          $produto_arvore = ProdutoArvore::create([
            'produto_id' => $produto->id,
            'arvore_id' => $request->arvores_totais,
            'funcionalidades_selecionadas' => $request->arvore_nodes
          ]);
          
        }

      }
      
    }else{

      $produto_count = Produto::where('categoria_produtos_id',$request->categoria_produtos_id)->orderBy('ordem','desc')->first();

      $produto = Produto::create([
        'titulo' => $request->titulo,
        'descricao' => $request->descricao,
        'detalhes' => $request->detalhes,
        'texto' => $request->texto,
        'imagem_destaque' => $imagem_destaque,
        'imagem' => $imagem,
        'destaque' => $request->destaque,
        'categoria_produtos_id' => $request->categoria_produtos_id,
        'link_download' => $arquivo,
        'ordem' => $produto_count ? $produto_count->ordem+1 : 1,
      ]);
      $produto_arvore = ProdutoArvore::create([
        'produto_id' => $produto->id,
        'arvore_id' => $request->arvores_totais,
        'funcionalidades_selecionadas' => $request->arvore_nodes
      ]);
    }

    FuncionalidadeProduto::where('produto_id',$produto->id)->delete();

    if($request->funcionalidade){
      foreach ($request->funcionalidade as $key => $item) {

        FuncionalidadeProduto::create([
          'produto_id' => $produto->id,
          'subfuncionalidade_id' => $item
        ]);
    }


    }

    return redirect('cms/produto');
  }

  public function CategoriaProduto(Request $request){
    $pesquisa = '';

    $categorias = CategoriaProduto::select('site_categoria_produtos.titulo as titulo','site_categoria_produtos.id as id','site_categoria_produtos.ordem as ordem','site_categoria_produtos.destaque as destaque')
    ->orderBy('site_categoria_produtos.ordem')
    ->orderBy('site_categoria_produtos.updated_at','desc');

    if($request->pesquisa){

      $pesquisa = $request->pesquisa;

      $categorias = $categorias->where('site_categoria_produtos.titulo', 'like', '%'.$pesquisa.'%');
    }

    $categorias = $categorias->paginate(20);

    return view('cms/categoria_produto', compact('categorias','pesquisa'));
  }

  public function CategoriaProdutoForm($id = null){

    if($id){
      $categoria = CategoriaProduto::find($id);

      if($categoria){
        return view('cms/categoria_produto_form', compact('categoria'));
      }
      else{
        abort(404);
      }
    }
    else{
      return view('cms/categoria_produto_form');
    }


  }

  public function CategoriaProdutoSalvar(Request $request){

    if($request->imagem_destaque && $request->imagem_destaque != 'blocked'){

      $extension = explode('/', explode(';', $request->imagem_destaque)[0])[1];

      $imageName = Str::random(10).'.'.$extension;

      if (preg_match('/^data:image\/(\w+);base64,/', $request->imagem_destaque)) {
        $data = substr($request->imagem_destaque, strpos($request->imagem_destaque, ',') + 1);
        $data = base64_decode($data);
        Storage::put('images/'.$imageName, $data);
      }

      $imagem = 'images/'.$imageName;

      // Storage::putFileAs(
      //   'images', $request->file('imagem_destaque'), $request->file('imagem_destaque')->hashName()
      // );
      //
      // $imagem = 'images/'.$request->file('imagem_destaque')->hashName();
    }
    else{
      $imagem = null;
    }

    if($request->id){
      $categoria = CategoriaProduto::find($request->id);
      $categoria->titulo = $request->titulo;
      if($request->imagem_destaque != 'blocked'){
        $categoria->imagem_destaque = $imagem;
      }
      $categoria->destaque = $request->destaque;
      $categoria->save();
    }
    else{

      $categoria_count = CategoriaProduto::all()->sortByDesc('ordem')->first();
      CategoriaProduto::create([
        'titulo' => $request->titulo,
        'imagem_destaque' => $imagem,
        'destaque' => $request->destaque,
        'ordem' => $categoria_count ? $categoria_count->ordem+1 : 1,
      ]);
    }

    return redirect('cms/categoria_produto');
  }

  public function ModeloProduto(Request $request){
    $pesquisa = '';
    $categoria_id = 0;
    $produto_id = 0;
    $categorias_produto_id = 0;

    $modelos = ProdutoModelo::select('site_produto_modelos.nome as titulo','site_produto_modelos.id as id','site_produto_modelos.preco as preco','site_categorias.nome as categoria','site_produtos.titulo as produto','site_categoria_produtos.titulo as categoria_produto')
    ->join('site_produtos','site_produtos.id','site_produto_modelos.produto_id')
    ->join('site_categoria_produtos','site_categoria_produtos.id','site_produtos.categoria_produtos_id')
    ->join('site_categorias','site_categorias.id','site_produto_modelos.categoria_id')
    ->orderBy('site_categoria_produtos.updated_at','desc');

    if($request->pesquisa){

      $pesquisa = $request->pesquisa;

      $modelos->where(function($query) use($pesquisa){
        $query->where('site_produto_modelos.nome', 'like', '%'.$pesquisa.'%')
              ->orWhere('site_produtos.titulo', 'like', '%'.$pesquisa.'%')
              ->orWhere('site_categoria_produtos.titulo', 'like', '%'.$pesquisa.'%');
      });
    }

    if($request->categoria_id){

      $categoria_id = $request->categoria_id;

      $modelos = $modelos->where('categoria_id',$categoria_id);
    }

    if($request->produto_id){

      $produto_id = $request->produto_id;

      $modelos = $modelos->where('produto_id',$produto_id);
    }

    if($request->categoria_produtos_id){

      $categorias_produto_id = $request->categoria_produtos_id;

      $modelos = $modelos->where('categoria_produtos_id',$categorias_produto_id);
    }

    $modelos = $modelos->paginate(20);

    $categorias = Categoria::all()->sortBy('nome');
    $produtos = Produto::all()->sortBy('titulo');
    $categorias_produto = CategoriaProduto::all()->sortBy('titulo');

    return view('cms/modelo', compact('modelos','pesquisa','categoria_id','produto_id','categorias_produto_id','categorias','produtos','categorias_produto'));
  }

  public function ModeloProdutoForm($id = null){

    $categorias = Categoria::all()->sortBy('nome');
    $produtos = Produto::all()->sortBy('titulo');

    if($id){
      $modelo = ProdutoModelo::find($id);

      if($modelo){
        return view('cms/modelo_form', compact('categorias','produtos','modelo'));
      }
      else{
        abort(404);
      }
    }
    else{
      return view('cms/modelo_form', compact('categorias','produtos'));
    }


  }

  public function ModeloProdutoSalvar(Request $request){

    $preco = str_replace(',','.',$request->preco);

    if($request->id){
      $modelo = ProdutoModelo::find($request->id);
      $modelo->nome = $request->nome;
      $modelo->produto_id = $request->produto_id;
      $modelo->preco = $preco;
      $modelo->paypal = $request->paypal;
      $modelo->tag_2 = $request->tag_2;
      $modelo->tag_3 = $request->tag_3;
      $modelo->categoria_id = $request->categoria_id;
      $modelo->obs = $request->obs;
      $modelo->save();
    }
    else{
      ProdutoModelo::create([
        'nome' => $request->nome,
        'produto_id' => $request->produto_id,
        'preco' => $preco,
        'paypal' => $request->paypal,
        'tag_2' => $request->tag_2,
        'tag_3' => $request->tag_3,
        'obs' => $request->obs,
        'categoria_id' => $request->categoria_id
      ]);
    }

    return redirect('cms/modelo');
  }

  public function CheckoutLead(Request $request){
    $pesquisa = '';

    $checkout = Checkout::orderBy('id','desc');

    if($request->pesquisa){

      $pesquisa = $request->pesquisa;

      $checkout->where(function($query) use($pesquisa){
        $query->where('nome', 'like', '%'.$pesquisa.'%')
              ->orWhere('razao', 'like', '%'.$pesquisa.'%')
              ->orWhere('fantasia', 'like', '%'.$pesquisa.'%');
      });
    }

    $checkout = $checkout->paginate(40);
    return view('cms/checkout', compact('pesquisa','checkout'));
  }

  public function CheckoutLeadDetalhe($id){
    $lead = Checkout::find($id);

    if($lead){
      return view('cms/checkout_detalhe', compact('lead'));
    }
    else{
      abort(404);
    }

  }

  public function ContatoLead(Request $request){
    $pesquisa = '';

    $contato = Contato::orderBy('id','desc');

    if($request->pesquisa){

      $pesquisa = $request->pesquisa;

      $contato = $contato->where('nome','like','%'.$pesquisa.'%');
    }

    $contato = $contato->paginate(40);
    return view('cms/contato', compact('pesquisa','contato'));
  }

  public function ContatoLeadDetalhe($id){
    $lead = Contato::find($id);

    if($lead){
      return view('cms/contato_detalhe', compact('lead'));
    }
    else{
      abort(404);
    }

  }

  public function DownloadLead(Request $request){
    $pesquisa = '';

    $download = Download::orderBy('download_id','desc');

    if($request->pesquisa){

      $pesquisa = $request->pesquisa;

      $download->where(function($query) use($pesquisa){
        $query->where('nome', 'like', '%'.$pesquisa.'%')
              ->orWhere('empresa', 'like', '%'.$pesquisa.'%');
      });
    }

    $download = $download->paginate(40);
    return view('cms/download', compact('pesquisa','download'));
  }

  public function DownloadLeadDetalhe($id){
    $lead = Download::find($id);

    if($lead){
      return view('cms/download_detalhe', compact('lead'));
    }
    else{
      abort(404);
    }

  }

  public function Usuarios(Request $request){
    $pesquisa = '';

    $usuarios = User::whereNotNull('id');

    if($request->pesquisa){

      $pesquisa = $request->pesquisa;

      $usuarios = $usuarios->where('users.name', 'like', '%'.$pesquisa.'%');
    }

    $usuarios = $usuarios->paginate(20);
    return view('cms/usuarios',compact('usuarios','pesquisa'));
  }

  public function UsuariosForm($id = null){

    if($id){
      $usuario = User::find($id);

      if($usuario && $id == Auth::id()){
        return view('cms/usuarios_form', compact('usuario'));
      }
      else{
        abort(404);
      }
    }
    else{
      return view('cms/usuarios_form');
    }

  }

  public function UsuariosSalvar(Request $request){

    if($request->id){
      $user = User::find($request->id);
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = Hash::make($request->password);
      $user->save();
    }
    else{
      User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->password),
      ]);
    }



    return redirect('cms/usuarios');
  }

  public function Funcionalidades(Request $request){

    $pesquisa = '';

    $funcionalidades = new Funcionalidade();

    if($request->pesquisa){

      $pesquisa = $request->pesquisa;

      $funcionalidades = $funcionalidades->where('descricao', 'like', '%'.$pesquisa.'%');
    }

    $funcionalidades = $funcionalidades->paginate(20);

    return view('cms/funcionalidades', compact('funcionalidades','pesquisa'));
  }

  public function FuncionalidadesForm($id = null){

    if($id){
      $funcionalidade = Funcionalidade::find($id);

      if($funcionalidade){
        return view('cms/funcionalidades_form', compact('funcionalidade'));
      }
      else{
        abort(404);
      }
    }
    else{
      return view('cms/funcionalidades_form');
    }

  }

  public function FuncionalidadesSalvar(Request $request){
    if($request->id){
      $funcionalidade = Funcionalidade::find($request->id);
      $funcionalidade->descricao = $request->descricao;
      $funcionalidade->save();
    }
    else{
      Funcionalidade::create([
        'descricao' => $request->descricao
      ]);
    }

    return redirect('cms/funcionalidades');
  }

  public function SubFuncionalidades(Request $request){

    $pesquisa = '';

    $funcionalidades = new Subfuncionalidade();

    if($request->pesquisa){

      $pesquisa = $request->pesquisa;

      $funcionalidades = $funcionalidades->where('titulo', 'like', '%'.$pesquisa.'%');
    }

    $funcionalidades = $funcionalidades->paginate(20);

    return view('cms/subfuncionalidades', compact('funcionalidades','pesquisa'));
  }

  public function SubFuncionalidadesForm($id = null){

    $funcionalidades = Funcionalidade::all()->sortBy('descricao');

    if($id){
      $funcionalidade = Subfuncionalidade::find($id);

      if($funcionalidade){
        return view('cms/subfuncionalidades_form', compact('funcionalidade','funcionalidades'));
      }
      else{
        abort(404);
      }
    }
    else{
      return view('cms/subfuncionalidades_form', compact('funcionalidades'));
    }

  }

  public function SubFuncionalidadesSalvar(Request $request){
    if($request->id){
      $funcionalidade = Subfuncionalidade::find($request->id);
      $funcionalidade->titulo = $request->titulo;
      $funcionalidade->funcionalidades_id = $request->funcionalidades_id;
      $funcionalidade->save();
    }
    else{
      Subfuncionalidade::create([
        'titulo' => $request->titulo,
        'funcionalidades_id' => $request->funcionalidades_id
      ]);
    }

    return redirect('cms/subfuncionalidades');
  }

  public function Configuracoes(){
    $configuracoes = Configuracao::all();

    return view('cms/configuracao', compact('configuracoes'));
  }

  public function ConfiguracoesForm($id){
    $configuracao = Configuracao::find($id);

    return view('cms/configuracao_form', compact('configuracao'));
  }

  public function ConfiguracoesSalvar(Request $request){
    $configuracao = Configuracao::find($request->id);

    if(substr($request->valor, 0, 4) == 'data'){

      $extension = explode('/', explode(';', $request->valor)[0])[1];
      $imageName = Str::random(10).'.'.$extension;

      if (preg_match('/^data:image\/(\w+);base64,/', $request->valor)) {
        $data = substr($request->valor, strpos($request->valor, ',') + 1);
        $data = base64_decode($data);
        Storage::put('images/'.$imageName, $data);
      }

      $configuracao->valor = 'images/'.$imageName;
    }
    elseif ($request->valor != 'blocked') {
      $configuracao->valor = $request->valor;
    }

    $configuracao->save();

    return redirect('cms/configuracoes');
  }

  public function Categoria(){
    $categorias = Categoria::all();

    return view('cms/categoria', compact('categorias'));
  }

  public function CategoriaForm($id = null){

    if($id){
      $categoria = Categoria::find($id);
    }
    else{
      $categoria = null;
    }

    return view('cms/categoria_form', compact('categoria'));
  }

  public function CategoriaSalvar(Request $request){

    if($request->id){
      $categoria = Categoria::find($request->id);
      $categoria->nome = $request->nome;
      $categoria->descricao = $request->descricao;
      $categoria->save();
    }
    else{
      Categoria::create([
        'nome' => $request->nome,
        'descricao' => $request->descricao
      ]);
    }

    return redirect('cms/categoria');
  }

}
