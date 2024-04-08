<!DOCTYPE html>
<html lang="pt-BR" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
  <body>

    <h1>EDITOR</h1>

    <div id="editor"></div>

    <button type="button" name="button" id="submit" class="btn btn-primary">Gerar HTML</button>

    <textarea name="name" rows="8" cols="80" id="textarea"></textarea>

    <script type="text/javascript" src="{{asset('assets/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/ckeditor4/ckeditor.js')}}"></script>
    <script>

      let editor;

      $(document).ready(function(){

        editor = CKEDITOR.replace( 'editor', {
          extraPlugins: ['colorbutton','panelbutton','button','floatpanel','panel'],
        });
      });


      $('#submit').click(function(){
        $('#textarea').text(editor.getData());
      })

    </script>

  </body>
</html>
