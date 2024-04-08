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
              <h3 class="mb-0">Download</h3>
            </div>

            <form class="col-8" method="GET" action="{{url('cms/download')}}">
              @csrf
              <div class="d-flex flex-row justify-content-end align-items-center">
                <div class="mx-2 flex-fill">
                  <input type="text" class="form-control" placeholder="Digite aqui algum termo..." name="pesquisa" value="{{$pesquisa}}">
                </div>
                <div class="mx-2">
                  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
                <div class="mx-2">
                  <a href="{{url('cms/download')}}">Limpar filtros</a>
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
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Modelo</th>
                <th scope="col">Data</th>
                <th scope="col" class="text-center">Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($download as $key => $item)
                <tr>
                  <th scope="row">{{$item->nome}}</th>
                  <td>{{$item->email}}</td>
                  <td>{{$item->modelo}}</td>
                  <td>{{Carbon\Carbon::parse($item->data)->format('d/m/Y H:i:s')}}</td>
                  <td class="text-center">
                    <a href="{{url('cms/download_detalhe/'.$item->download_id)}}" class="btn btn-info btn-sm" title="Informações"><i class="fas fa-info-circle"></i></a>
                    <a href="#" class="btn btn-danger btn-sm btn-deletar" title="Deletar" tipo="download" item="{{$item->download_id}}"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="p-3">
          {{$download->links()}}
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
