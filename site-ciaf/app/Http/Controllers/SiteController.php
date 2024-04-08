<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conteudo;
use App\Produto;
use App\CategoriaProduto;
use App\Funcionalidade;
use App\Subfuncionalidade;
use App\FuncionalidadeProduto;
use App\Cliente;
use App\Checkout;
use App\Checkout2;
use App\ProdutoModelo;
use Carbon\Carbon;
use App\Contato;
use App\Download;
use App\Configuracao;
use App\Mail\ContatoMail;
use App\Mail\CheckoutMail;
use App\Mail\CheckoutMail2;
use App\Mail\DownloadMail;
use App\Mail\DadosMail;
use App\Arvore;
use App\ProdutoArvore;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{
  public function index()
  {

    $conteudo = Conteudo::where('pagina_id', 1)->orderBy('ordem')->get();
    $produtos = CategoriaProduto::where('destaque', 1)->orderBy('ordem')->get();
    $cta = Conteudo::where('pagina_id', 2)->first();
    $noticias = Conteudo::where('pagina_id', 3)->orderBy('created_at', 'desc')->limit(4)->get();
    $intervalo_banner = Configuracao::where('tipo', 'Intervalo Banner')->first();

    $footer = MasterController::footer();
    $navbar = MasterController::navbar();

    return view('index', compact('conteudo', 'produtos', 'cta', 'noticias', 'footer', 'navbar', 'intervalo_banner'));
  }

  public function Noticias()
  {

    $noticias = Conteudo::where('pagina_id', 3)->orderBy('created_at', 'desc')->get();
    $banner_pagina = Configuracao::find(15);

    $footer = MasterController::footer();
    $navbar = MasterController::navbar();

    return view('noticias', compact('noticias', 'footer', 'navbar', 'banner_pagina'));
  }

  public function NoticiasDetalhes($id)
  {

    $banner_pagina = Configuracao::find(14);

    $noticia = Conteudo::where('id', $id)->where('pagina_id', 3)->first();

    if ($noticia) {
      $footer = MasterController::footer();
      $navbar = MasterController::navbar();

      return view('noticias_detalhes', compact('noticia', 'footer', 'navbar', 'banner_pagina'));
    } else {
      abort(404);
    }
  }

  public function buscar_arvores_produtos_json(Request $request)
  {

    $array_busca = [];
    $array_temp = [];
    $explode_string = [];

    foreach ($request->busca as $key => $busca) {
      $explode_string = explode("-", $busca);
      $arvore = Arvore::select('json', 'nome')->find($explode_string[0]);
      $arvore_produto = ProdutoArvore::select('funcionalidades_selecionadas')->where('arvore_id', $explode_string[0])->where('produto_id', $explode_string[1])->first();
      $array_temp = [
        "arvore" => $arvore,
        "funcionalidades" => $arvore_produto,
        "busca" => $busca
      ];

      array_push($array_busca, $array_temp);
    }
    return json_decode(json_encode($array_busca), true);
  }

  public function Solucoes($id)
  {

    $banner_pagina = Configuracao::find(18);
    $array_retorno_funcionalidades = [];
    $array_arvores = [];
    $array_temp = [];

    // $produtos = Produto::where('categoria_produtos_id', $id)->orderBy('ordem')->get();
    $produtos = Produto::where('categoria_produtos_id', $id)->with('arvores')->orderBy('ordem')->get();
    $categoria = CategoriaProduto::find($id);
    $sub_funcionalidades = Subfuncionalidade::all();
    $funcionalidades = Funcionalidade::all();
    // $funcionalidades = Subfuncionalidade::all();
    $cta_produto = Conteudo::where('pagina_id', 8)->first();

    if ($produtos && $categoria) {

      $footer = MasterController::footer();
      $navbar = MasterController::navbar();
      return view('produto', compact('produtos', 'footer', 'navbar', 'categoria', 'funcionalidades', 'cta_produto', 'banner_pagina', 'sub_funcionalidades'));

      // return view('produto', compact('produtos','footer','navbar','categoria','funcionalidades','cta_produto','banner_pagina'));
    } else {
      abort(404);
    }
  }
  public function Solucoes2($id)
  {
    // dd("teste   ".$id);
    $banner_pagina = Configuracao::find(18);
    $array_retorno_funcionalidades = [];
    $array_arvores = [];
    $array_temp = [];
    // $id = '14';
    // $produtos = Produto::where('categoria_produtos_id', $id)->orderBy('ordem')->get();
    $produtos = Produto::where('categoria_produtos_id', $id)->with('arvores')->orderBy('ordem')->get();
    $categoria = CategoriaProduto::find($id);
    $sub_funcionalidades = Subfuncionalidade::all();
    $funcionalidades = Funcionalidade::all();
    // $funcionalidades = Subfuncionalidade::all();
    $cta_produto = Conteudo::where('pagina_id', 8)->first();

    if ($produtos && $categoria) {

      $footer = MasterController::footer();
      $navbar = MasterController::navbar();
      return view('produto2', compact('produtos', 'footer', 'navbar', 'categoria', 'funcionalidades', 'cta_produto', 'banner_pagina', 'sub_funcionalidades'));

      // return view('produto', compact('produtos','footer','navbar','categoria','funcionalidades','cta_produto','banner_pagina'));
    } else {
      abort(404);
    }
  }

  public function SolucoesDetalhes($id)
  {

    $banner_pagina = Configuracao::find(17);

    $produto = Produto::find($id);

    $cta_produto = Conteudo::where('pagina_id', 8)->first();

    if ($produto) {
      $precos = ProdutoModelo::where('produto_id', $id)->orderBy('categoria_id')->get();
      $footer = MasterController::footer();
      $navbar = MasterController::navbar();

      return view('produto_detalhe', compact('produto', 'footer', 'navbar', 'cta_produto', 'precos', 'banner_pagina'));
    } else {
      abort(404);
    }
  }
  public function SolucoesDetalhes2($id)
  {

    $banner_pagina = Configuracao::find(17);

    $produto = Produto::find($id);

    $cta_produto = Conteudo::where('pagina_id', 8)->first();

    if ($produto) {
      $precos = ProdutoModelo::where('produto_id', $id)->orderBy('categoria_id')->get();
      $footer = MasterController::footer();
      $navbar = MasterController::navbar();

      return view('produto_detalhe2', compact('produto', 'footer', 'navbar', 'cta_produto', 'precos', 'banner_pagina'));
    } else {
      abort(404);
    }
  }

  public function Comprar()
  {

    $banner_pagina = Configuracao::find(4);

    $produtos = Produto::select('categoria_produtos_id', 'site_produtos.imagem_destaque as imagem_destaque', 'site_produtos.titulo as titulo', 'site_produtos.descricao as descricao', 'site_produtos.id as id')
      ->join('site_produto_modelos', 'site_produto_modelos.produto_id', 'site_produtos.id')
      ->orderBy('categoria_produtos_id')
      ->orderBy('ordem')
      ->groupBy('site_produtos.id')
      ->get();

    $categorias = CategoriaProduto::orderBy('ordem')->get();

    $footer = MasterController::footer();
    $navbar = MasterController::navbar();

    return view('comprar', compact('produtos', 'categorias', 'footer', 'navbar', 'banner_pagina'));
  }

  public function Downloads()
  {

    $banner_pagina = Configuracao::find(8);

    $produtos = Produto::whereNotNull('link_download')->orderBy('categoria_produtos_id')->orderBy('ordem')->get();
    $categorias = CategoriaProduto::orderBy('ordem')->get();

    $footer = MasterController::footer();
    $navbar = MasterController::navbar();

    return view('downloads', compact('produtos', 'categorias', 'footer', 'navbar', 'banner_pagina'));
  }

  public function DownloadProduto($id)
  {

    $banner_pagina = Configuracao::find(7);

    $produto = Produto::find($id);

    if ($produto) {
      $footer = MasterController::footer();
      $navbar = MasterController::navbar();

      return view('download_produto', compact('produto', 'footer', 'navbar', 'banner_pagina'));
    } else {
      abort(404);
    }
  }

  public function CheckoutDownload(Request $request)
  {

    $this->validate($request, [
      'g-recaptcha-response' => 'required|captcha',
    ]);

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }

    $produto = Produto::find($request->produto_id);

    $contador_ip = Download::where('ip', $ip)->count();

    if ($contador_ip > 9) {
      return back()->with('error', 'Você já atingiu o limite de 10 downloads nesse IP.');
    }

    $download = Download::create([
      'nome' => $request->nome,
      'empresa' => $request->empresa,
      'email' => $request->email,
      'telefone' => $request->telefone,
      'modelo' => $produto->titulo,
      'data' => Carbon::now()->format('Y-m-d H:i:s'),
      'onde' => $request->onde,
      'ip' => $ip,
      'contador_ip' => $contador_ip++,
      'obs' => ''
    ]);

    Mail::to($request->email)->send(new DownloadMail($download));


    return redirect('download_produto/' . $request->produto_id)->with('link', $produto);
  }

  public function Sobre()
  {

    $banner_pagina = Configuracao::find(19);

    $sobre = Conteudo::where('pagina_id', 9)->first();
    $valores = Conteudo::where('pagina_id', 10)->orderBy('ordem')->get();

    $footer = MasterController::footer();
    $navbar = MasterController::navbar();

    return view('sobre', compact('sobre', 'valores', 'footer', 'navbar', 'banner_pagina'));
  }

  public function Suporte()
  {

    $banner_pagina = Configuracao::find(20);

    $suporte = Conteudo::where('pagina_id', 5)->orderBy('ordem')->get();

    $footer = MasterController::footer();
    $navbar = MasterController::navbar();

    return view('suporte', compact('suporte', 'footer', 'navbar', 'banner_pagina'));
  }

  public function Funcionalidades($produto_id)
  {

    $banner_pagina = Configuracao::find(10);

    $subfuncionalidades_produto = FuncionalidadeProduto::where('produto_id', $produto_id)->get();

    $subfuncionalidades = Subfuncionalidade::whereIn('id', $subfuncionalidades_produto->pluck('subfuncionalidade_id'))->get();
    $funcionalidades_produto = Funcionalidade::whereIn('id', $subfuncionalidades->pluck('funcionalidades_id'))->get();

    if ($subfuncionalidades_produto) {
      $footer = MasterController::footer();
      $navbar = MasterController::navbar();

      return view('funcionalidades', compact('subfuncionalidades', 'funcionalidades_produto', 'footer', 'navbar', 'banner_pagina'));
    } else {
      abort(404);
    }
  }

  public function Contato()
  {

    $banner_pagina = Configuracao::find(5);

    $informacoes = Conteudo::where('pagina_id', 11)->orderBy('ordem')->get();
    $endereco = Conteudo::where('pagina_id', 12)->first();
    $horario_atendimento = Conteudo::where('pagina_id', 13)->first();
    $telefones = Conteudo::where('pagina_id', 7)->orderBy('ordem')->get();

    $footer = MasterController::footer();
    $navbar = MasterController::navbar();

    return view('contato', compact('informacoes', 'endereco', 'horario_atendimento', 'footer', 'navbar', 'telefones', 'banner_pagina'));
  }

  public function LoginAreaCliente(Request $request)
  {

    $banner_pagina = Configuracao::find(11);


    if ($request->session()->has('cliente')) {

      return redirect('area_cliente');
    } else {
      $footer = MasterController::footer();
      $navbar = MasterController::navbar();

      return view('login_area_cliente', compact('footer', 'navbar', 'banner_pagina'));
    }
  }

  public function escolherCliente($id)
  {



    $cliente = Cliente::find($id);

    session(['cliente' => compact('cliente')]);

    return redirect('area_cliente');
  }

  public function AreaCliente(Request $request)
  {

    $banner_pagina = Configuracao::find(2);

    $noticias = Conteudo::where('pagina_id', 3)->orderBy('created_at', 'desc')->limit(3)->get();

    if (!$request->cliente && $request->session()->has('cliente')) {
      $footer = MasterController::footer();
      $navbar = MasterController::navbar();

      $cliente = $request->session()->get('cliente')['cliente'];

      return view('areacliente', compact('cliente', 'footer', 'navbar', 'noticias', 'banner_pagina'));
    } elseif (!$request->cliente && !$request->cnpj) {

      return redirect('login_cliente');
    }

    $cnpj = preg_replace('/[^0-9]/', '', $request->cnpj);

    $cliente = Cliente::where('cnpj_cpf', $cnpj)
      ->whereRaw('senha = password("' . $request->senha . '")')
      ->get();

    if ($cliente->count() == 1) {
      $footer = MasterController::footer();
      $navbar = MasterController::navbar();

      $cliente = $cliente[0];

      $request->session()->put('cliente', compact('cliente'));
      return view('areacliente', compact('cliente', 'footer', 'navbar', 'noticias', 'banner_pagina')); // alterada essa linha

      // return view('areacliente', compact('cliente','footer','navbar','noticias', 'banner_pagina'));

    } elseif ($cliente->count() > 1) {
      $footer = MasterController::footer();
      $navbar = MasterController::navbar();

      // $request->session()->put('cliente', compact('cliente'));
      return view('escolhercliente', compact('cliente', 'footer', 'navbar', 'banner_pagina')); // alterada essa linha

      // return view('escolhercliente', compact('cliente','footer','navbar', 'banner_pagina'));
    } else {
      return back()->withError('Usuário ou senha incorretos.');
    }
  }

  public function logoutCliente(Request $request)
  {
    $request->session()->forget('cliente');

    return redirect('login_cliente');
  }

  public function DadosPessoais(Request $request)
  {

    $banner_pagina = Configuracao::find(6);

    if ($request->session()->has('cliente')) {

      $footer = MasterController::footer();
      $navbar = MasterController::navbar();

      $cliente = $request->session()->get('cliente')['cliente'];
      return view('dadospessoais', compact('cliente', 'footer', 'navbar', 'banner_pagina'));
    } else {
      return redirect('login_cliente');
    }
  }

  public function Manuais()
  {

    $banner_pagina = Configuracao::find(12);

    $footer = MasterController::footer();
    $navbar = MasterController::navbar();

    $manuais = Conteudo::where('pagina_id', 14)->orderBy('ordem')->get();
    return view('manuais', compact('manuais', 'footer', 'navbar', 'banner_pagina'));
  }

  public function NFE()
  {
    $banner_pagina = Configuracao::find(13);
    $footer = MasterController::footer();
    $navbar = MasterController::navbar();

    $nfe = Conteudo::where('pagina_id', 15)->orderBy('ordem')->first();
    return view('nfe', compact('nfe', 'footer', 'navbar', 'banner_pagina'));
  }

  public function Checkout($id)
  {

    $banner_pagina = Configuracao::find(3);

    $produto = Produto::find($id);

    if ($produto) {
      $footer = MasterController::footer();
      $navbar = MasterController::navbar();
      return view('checkout', compact('produto', 'footer', 'navbar', 'banner_pagina'));
    } else {
      abort(404);
    }
  }
  public function Checkout2($id)
  {

    $banner_pagina = Configuracao::find(3);

    $produto = Produto::find($id);

    if ($produto) {
      $footer = MasterController::footer();
      $navbar = MasterController::navbar();
      return view('checkout2', compact('produto', 'footer', 'navbar', 'banner_pagina'));
    } else {
      abort(404);
    }
  }

  public function SalvarCheckout(Request $request)
  {

    $this->validate($request, [
      'g-recaptcha-response' => 'required|captcha',
    ]);

    $banner_pagina = Configuracao::find(3);

    $produto = ProdutoModelo::find($request->produto);

    $checkout = Checkout::create([
      "id_modelo" => $request->produto,
      "modelo" => $produto->nome,
      "nome" => $request->nome,
      "cnpj_cpf" => $request->cnpj,
      "razao" => $request->razao,
      "fantasia" => $request->fantasia,
      "email" => $request->email,
      "telefone" => $request->telefone,
      "celular" => $request->celular ? $request->celular : '',
      "momento" => Carbon::now()->format('Y-m-d H:i:s'),
      'onde' => $request->onde,
      "licenciamento" => ''
    ]);

    Mail::to('financeiro@ciaf.com.br')->send(new CheckoutMail($checkout));

    $footer = MasterController::footer();
    $navbar = MasterController::navbar();

    $pagamento = Conteudo::where('pagina_id', 16)->get();

    return view('pagamento', compact('navbar', 'footer', 'produto', 'pagamento', 'banner_pagina'));
  }
  public function SalvarCheckout2(Request $request)
  {

    $this->validate($request, [
      'g-recaptcha-response' => 'required|captcha',
    ]);
    $banner_pagina = Configuracao::find(3);
    $produto = ProdutoModelo::find('5');


    $checkout = Checkout2::create([
      "id" => 1,
      "id_modelo" => "2",
      "modelo" => $produto->nome,
      "nome" => $request->nome,
      "cnpj_cpf" => $request->cnpj,
      "razao" => $request->razao,
      "fantasia" => $request->fantasia,
      "email" => $request->email,
      "telefone" => $request->telefone,
      "celular" => $request->celular ? $request->celular : '',
      "funcionarios"=>$request->funcionarios,
      "faturamento"=>$request->faturamento,
      "momento" => Carbon::now()->format('Y-m-d H:i:s'),
      'onde' => $request->onde,
      "licenciamento" => ''
    ]);

    Mail::to('financeiro@ciaf.com.br')->send(new CheckoutMail2($checkout));
    $footer = MasterController::footer();
    $navbar = MasterController::navbar();
    // dd($checkout);
    $pagamento = Conteudo::where('pagina_id', 16)->get();
    return view('pagamento2', compact('navbar', 'footer', 'produto', 'pagamento', 'banner_pagina'));
  }

  public function SalvarContato(Request $request)
  {

    $this->validate($request, [
      'g-recaptcha-response' => 'required|captcha',
    ]);

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }

    $contato = Contato::create([
      'nome' => $request->nome,
      'telefone' => $request->telefone,
      'email' => $request->email,
      'assunto' => $request->assunto,
      'mensagem' => $request->mensagem,
      'ip' => $ip,
      'onde' => $request->onde
    ]);

    Mail::to('suporte@ciaf.com.br')->send(new ContatoMail($contato));
    // Mail::to('guilhermemiranda.ti@gmail.com')->send(new ContatoMail($contato));

    return back()->with('success', 'Mensagem enviada com sucesso.');
  }

  public function BuscarCNPJ(Request $request)
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://receitaws.com.br/v1/cnpj/" . $request->cnpj,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "",
      CURLOPT_HTTPHEADER => array(
        "Postman-Token: 01ceeeea-90ee-405a-9c7b-04385abb5414",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return response()->json(['error' => $err]);
    } else {
      return response()->json(['dados' => json_decode($response)]);
    }
  }

  public function SalvarDados(Request $request)
  {

    $cliente = new Cliente();
    $cliente->nome = $request->nome;
    $cliente->razao = $request->razao;
    $cliente->cnpj_cpf = $request->cnpj_cpf;
    $cliente->cep = $request->cep;
    $cliente->endereco = $request->endereco;
    $cliente->numero = $request->numero;
    $cliente->bairro = $request->bairro;
    $cliente->cidade = $request->cidade;
    $cliente->uf = $request->uf;
    $cliente->fone1 = $request->fone1;
    $cliente->fone2 = $request->fone2;
    $cliente->fone3 = $request->fone3;
    $cliente->email = $request->email;

    Mail::to('suporte@ciaf.com.br')->send(new DadosMail($cliente));
    // Mail::to('guilhermemiranda.ti@gmail.com')->send(new DadosMail($cliente));

    return back();
  }
}
