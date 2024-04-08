<div class="modal fade" id="popup-cta" tabindex="-1" role="dialog" aria-labelledby="popup-cta" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

        <img src="{{asset('storage/images/tech-banner.jpg')}}" class="card-img-top" alt="...">
        <div class="card-body">
          <p class="card-text">Deixe seu contato e a gente te liga.</p>

          <form action="{{url('salvarcontato')}}" method="POST">
            @csrf
            <div class="form-group">
              <input type="text" name="nome" required="" placeholder="Nome" class="form-control" value={{old('nome')}}>
            </div>
            <div class="form-group">
              <input type="email" name="email" required="" placeholder="Email" class="form-control" value={{old('email')}}>
            </div>
            <div class="form-group">
              <input name="telefone" required="" placeholder="Telefone/Celular" class="form-control phone" value={{old('telefone')}}>
            </div>
            <input type="hidden" name="assunto" value="Me liga">
            <input type="hidden" name="texto" value="">
            <input type="hidden" name="onde" value="8">
            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
              {!! app('captcha')->display() !!}
              @if ($errors->has('g-recaptcha-response'))
                  <span class="help-block text-danger">
                      <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                  </span>
              @endif
          </div>
            <button type="submit" name="button" class="btn btn-primary" style="background-color:#0B2C52; border-color:#0B2C52">Enviar</button>
            <a href="#" class="btn btn-secondary close-popup-cta" data-dismiss="modal">Cancelar</a>
          </form>
        </div>

    </div>
  </div>
</div>

@if ($errors->has('g-recaptcha-response') && old('leave') != 1)
  <script>
    $('#popup-cta').modal('show');
  </script>
@endif