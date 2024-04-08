@extends('cms/master')
@section('content')

<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0"></h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{url('cms/produto_form')}}" class="btn btn-neutral">Novo</a>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">

  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col-4">
              <h3 class="mb-0">Produto</h3>
            </div>

            <form class="col-8" method="GET" action="{{url('cms/produto')}}">
              @csrf
              <div class="d-flex flex-row justify-content-end align-items-center">
                <div class="mx-2 flex-fill">
                  <input type="text" class="form-control" placeholder="Digite aqui algum termo..." name="pesquisa" value="{{$pesquisa}}">
                </div>
                <div class="mx-2 flex-fill">
                  <select class="form-control" name="categoria_id">
                    <option value="0" selected>Todas as categorias</option>
                    @foreach ($categorias as $key => $item)
                      <option value="{{$item->id}}" {{$categoria_id == $item->id ? 'selected' : ''}}>{{$item->titulo}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mx-2">
                  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
                <div class="mx-2">
                  <a href="{{url('cms/produto')}}">Limpar filtros</a>
                </div>
              </div>
            </form>

          </div>
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">Título</th>
                <th scope="col" class="text-center">Categoria</th>
                <th scope="col" class="text-center">Destaque</th>
                <th scope="col" class="text-center">Ordem</th>
                <th scope="col" class="text-center">Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($produto as $key => $item)
                <tr>
                  <th scope="row">{{$item->titulo}}</th>
                  <td class="text-center">{{$item->categoria}}</td>
                  <td class="text-center">{{$item->destaque == 1 ? 'SIM' : 'NÃO'}}</td>
                  <td class="text-center">{{$item->ordem ? $item->ordem : '-'}}</td>
                  <td class="text-center">
                    <a href="#" class="btn btn-primary btn-sm btn-mover" title="Mover para cima" item="{{$item->id}}" mover="up" tipo="produto"><i class="fas fa-arrow-up"></i></a>
                    <a href="#" class="btn btn-primary btn-sm btn-mover" title="Mover para baixo" item="{{$item->id}}" mover="down" tipo="produto"><i class="fas fa-arrow-down"></i></a>
                    <a href="{{url('cms/produto_form/'.$item->id)}}" class="btn btn-info btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                    <a href="#" class="btn btn-danger btn-sm btn-deletar" title="Deletar" tipo="produto" item="{{$item->id}}"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="p-3">
          {{$produto->links()}}
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
