@extends('layouts/master')
@section('content')

    <div class="carousel slide" data-ride="carousel" style="height:250px;margin-top:70px">
      <div class="carousel-inner h-100">
        <div class="carousel-item active h-100" style="background-image:url({{asset('storage/'.$banner_pagina->valor)}}); background-size:cover; background-position:center;">
          <div class="overlay"></div>
          <div class="container h-100 position-relative d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-5 mb-0">Atualizações</h1>
            <hr style="border: 1px solid #CC1707; width:100px">
          </div>
        </div>
      </div>
    </div>

    <div class="container text-center py-4">
      <div class="mb-5">
        <p>Quando for incluído um novo recurso ou for identificado alguma inconsistência em algum de nossos sistemas essa melhoria ou correção chamamos de atualização.</p>
        <p>É aqui nesta página que disponibilizamos para você o processo que atualiza a versão do seu sistema.</p>
        <p>Aqui sempre estará disponível a última versão e a data em que nós disponibilizamos.</p>
        <p>Compare as informações e efetue o processo se necessário. Fique tranquilo! Se precisar de ajuda é só entrar em contato!</p>
      </div>

      <table class="table">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col">Sistema</th>
            <th scope="col">Última versão</th>
            <th scope="col">Lançado em</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row"><img src="images/ciafprofessional.png" class="img-fluid" width="100"></th>
            <td>CIAF Master</td>
            <td>16.0.2</td>
            <td>23/06/2019</td>
            <td><button type="button" class="btn btn-custom-2 btn-sm">Solicitar Atualização</button></td>
          </tr>
          <tr>
            <th scope="row"><img src="images/EmissorNfeeNfce.png" class="img-fluid" width="100"></th>
            <td>CIAF Emissor NF-e</td>
            <td>15.4.1</td>
            <td>05/11/2018</td>
            <td><button type="button" class="btn btn-custom-2 btn-sm">Solicitar Atualização</button></td>
          </tr>
          <tr>
            <th scope="row"><img src="images/logo_petsystem.jpg" class="img-fluid" width="100"></th>
            <td>Petsystem</td>
            <td>16.0.0</td>
            <td>30/05/2019</td>
            <td><button type="button" class="btn btn-custom-2 btn-sm">Solicitar Atualização</button></td>
          </tr>
        </tbody>
      </table>
    </div>

@endsection
