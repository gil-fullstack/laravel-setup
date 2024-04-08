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
          <a href="{{url('cms/arvore')}}" class="btn btn-neutral">Novo</a>
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
              <h3 class="mb-0">Arvores</h3>
            </div>
          </div>
        </div>
        <div class="table-responsive d-flex justify-content-center">
            
            @if ($arvores->isEmpty())
                <div class="alert alert-primary" style="width: 90%" role="alert">
                    Nenhuma arvore cadastrada
                </div>
            @else

                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($arvores as $key => $item)
                        <tr>
                        <th scope="row">{{$item->nome}}</th>
                        <td class="text-center">
                            <a href="{{url('cms/arvore/editar').'/'.$item->id}}" class="btn btn-info btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                            <a href="{{url('cms/arvore/excluir').'/'.$item->id}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            @endif
         
        </div>
        {{-- <div class="p-3">
          {{$produto->links()}}
        </div> --}}

      </div>
    </div>
  </div>
</div>
@endsection
