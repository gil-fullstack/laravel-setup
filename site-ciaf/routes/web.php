<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'SiteController@index');

Route::post('/arvore_produto_json', 'SiteController@buscar_arvores_produtos_json')->name('arvore_produto_json');

Route::get('noticias', 'SiteController@Noticias');
Route::get('noticias_detalhes/{id}', 'SiteController@NoticiasDetalhes');

Route::get('solucoes/{id}', 'SiteController@Solucoes');
Route::get('solucoesweb/{id}', 'SiteController@Solucoes2');
Route::get('solucoes_detalhes/{id}', 'SiteController@SolucoesDetalhes');
Route::get('solucoes_detalhes2/{id}', 'SiteController@SolucoesDetalhes2');

Route::get('comprar', 'SiteController@Comprar');

Route::get('downloads', 'SiteController@Downloads');
Route::post('checkout_download', 'SiteController@CheckoutDownload');
Route::get('download_produto/{id}', 'SiteController@DownloadProduto');

Route::get('manuais', 'SiteController@Manuais');

Route::get('sobre', 'SiteController@Sobre');

Route::get('nfe', 'SiteController@NFE');

Route::get('checkout2/{id}', 'SiteController@Checkout2');
Route::get('checkout/{id}', 'SiteController@Checkout');
Route::post('checkout', 'SiteController@SalvarCheckout');
Route::post('checkout2', 'SiteController@SalvarCheckout2');

Route::get('suporte', 'SiteController@Suporte');

Route::get('funcionalidades/{id}', 'SiteController@Funcionalidades');

Route::get('login_cliente', 'SiteController@LoginAreaCliente');
Route::post('area_cliente', 'SiteController@AreaCliente');
Route::get('area_cliente', 'SiteController@AreaCliente');
Route::get('dadospessoais', 'SiteController@DadosPessoais');
Route::post('salvar_dados', 'SiteController@SalvarDados');
Route::get('logout_area_cliente', 'SiteController@logoutCliente');
Route::get('escolher_cliente/{id}', 'SiteController@escolherCliente');

Route::get('contato', 'SiteController@Contato');
Route::post('salvarcontato', 'SiteController@SalvarContato');

Route::post('buscar_cnpj', 'SiteController@BuscarCNPJ');

Route::get('pagamento2', function () {
  return view('pagamento2');
});


//CMS
Route::get('editor', function () {
  return view('cms/teste');
});

Route::get('home', function () {
  return redirect('cms/conteudo');
});
Route::get('cms/arvore', 'ArvoreController@index');
Route::get('cms/arvore/listar', 'ArvoreController@listar_arvores');
Route::get('cms/arvore/editar/{id}', 'ArvoreController@editar_arvore')->name('editar_arvore');
Route::post('cms/arvore/editar/salvar', 'ArvoreController@salvar_arvore_editada')->name('edit.arvore');
Route::get('cms/arvore/excluir/{id}', 'ArvoreController@excluir_arvore');
Route::post('cms/arvore/json', 'ArvoreController@get_json')->name('get_json.arvore');
Route::post('cms/arvore/json/produto/', 'ArvoreController@get_json_produto')->name('produto_json_arvore');
Route::post('cms/arvore_atribuida/remover/', 'ArvoreController@remover_arvore_atribuida')->name('remover.arvore_atribuida');
Route::post('cms/arvore/store', 'ArvoreController@store')->name('store.arvore');
Route::post('cms/alterar_ordem', 'CMSController@AlterarOrdem');
Route::post('cms/deletar', 'CMSController@Deletar');

Route::get('cms/conteudo', 'CMSController@Conteudo');
Route::get('cms/conteudo_form/{id?}', 'CMSController@ConteudoForm');
Route::post('cms/conteudo_salvar', 'CMSController@ConteudoSalvar');

Route::get('cms/produto', 'CMSController@Produto');
Route::get('cms/produto_form/{id?}', 'CMSController@ProdutoForm');
Route::post('cms/produto_salvar', 'CMSController@ProdutoSalvar');

Route::get('cms/categoria_produto', 'CMSController@CategoriaProduto');
Route::get('cms/categoria_produto_form/{id?}', 'CMSController@CategoriaProdutoForm');
Route::post('cms/categoria_produto_salvar', 'CMSController@CategoriaProdutoSalvar');

Route::get('cms/modelo', 'CMSController@ModeloProduto');
Route::get('cms/modelo_form/{id?}', 'CMSController@ModeloProdutoForm');
Route::post('cms/modelo_salvar', 'CMSController@ModeloProdutoSalvar');

Route::get('cms/categoria', 'CMSController@Categoria');
Route::get('cms/categoria_form/{id?}', 'CMSController@CategoriaForm');
Route::post('cms/categoria_salvar', 'CMSController@CategoriaSalvar');

Route::get('cms/funcionalidades', 'CMSController@Funcionalidades');
Route::get('cms/funcionalidades_form/{id?}', 'CMSController@FuncionalidadesForm');
Route::post('cms/funcionalidade_salvar', 'CMSController@FuncionalidadesSalvar');

Route::get('cms/subfuncionalidades', 'CMSController@SubFuncionalidades');
Route::get('cms/subfuncionalidades_form/{id?}', 'CMSController@SubFuncionalidadesForm');
Route::post('cms/subfuncionalidade_salvar', 'CMSController@SubFuncionalidadesSalvar');

Route::get('cms/configuracoes', 'CMSController@Configuracoes');
Route::get('cms/configuracoes_form/{id?}', 'CMSController@ConfiguracoesForm');
Route::post('cms/configuracoes_salvar', 'CMSController@ConfiguracoesSalvar');

Route::get('cms/usuarios', 'CMSController@Usuarios');
Route::get('cms/usuarios_form/{id?}', 'CMSController@UsuariosForm');
Route::post('cms/usuarios_salvar', 'CMSController@UsuariosSalvar');

Route::get('cms/checkout', 'CMSController@CheckoutLead');
Route::get('cms/checkout_detalhe/{id}', 'CMSController@CheckoutLeadDetalhe');

Route::get('cms/contato', 'CMSController@ContatoLead');
Route::get('cms/contato_detalhe/{id}', 'CMSController@ContatoLeadDetalhe');

Route::get('cms/download', 'CMSController@DownloadLead');
Route::get('cms/download_detalhe/{id}', 'CMSController@DownloadLeadDetalhe');

Route::get('cms/usuarios', 'CMSController@Usuarios');
