$('.btn-mover').click(function(e){
  e.preventDefault();

  var elemento = $(this);

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url:'/cms/alterar_ordem',
    method:'POST',
    data:{id:elemento.attr('item'),mover:elemento.attr('mover'),tipo:elemento.attr('tipo')},
    success:function(result){
      location.reload();
    }
  })
})

let editor;
let editor1;

$(document).ready(function(){


  if($('#editor').length){
    editor = CKEDITOR.replace( 'editor', {
      extraPlugins: ['colorbutton','panelbutton','button','floatpanel','panel'],
    });
  }

  if($('#editor1').length){
    editor = CKEDITOR.replace( 'editor1', {
      extraPlugins: ['colorbutton','panelbutton','button','floatpanel','panel'],
    });
  }

  if($('#img-croppie')){
    var basic = $('#demo-basic').croppie({
			viewport: {
				width: 150,
				height: 200
			},
			boundary: {
				width: 300,
				height: 300
			}
		});

  }



});


$('#submit').click(function(){
  $('#textarea').text(editor.getData());
})

$('.btn-deletar').click(function(e){
  e.preventDefault();

  var elemento = $(this);

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  Swal.fire({
    title: 'Você tem certeza?',
    text: "Você não conseguirá recuperar esses dados.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sim, apagar',
    cancelButtonText: 'Não',
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url:'/cms/deletar',
        method:'POST',
        data:{id:elemento.attr('item'),tipo:elemento.attr('tipo')},
        success:function(result){
          if(result.error){
            Swal.fire({
              text:result.error,
              icon:'error'
            })
          }
          else{
            location.reload();
          }

        }
      })
    }
  })
})

$('.btn_apagar_imagem_form').click(function(e){
  e.preventDefault();

  $('.imagem_form').remove();
  $('.btn_apagar_imagem_form').addClass('d-none');
  $('.container_imagem_form input').attr('type','file').val('').show();
  imagem_escolhida = false;
})

$('.btn_apagar_imagem_destaque_form').click(function(e){
  e.preventDefault();

  $('.imagem_destaque_form').remove();
  $('.btn_apagar_imagem_destaque_form').addClass('d-none');
  $('.container_imagem_destaque_form input').attr('type','file').val('').show();
})

$('.btn_apagar_imagem_responsiva_form').click(function(e){
  e.preventDefault();
  $('.imagem_destaque_form').remove();
  $('.btn_apagar_imagem_responsiva_form').addClass('d-none');
  $('.container_imagem_responsiva_form input').attr('type','file').val('').show();
  imagem_destaque_escolhida = false;
})

$('.btn_apagar_arquivo_form').click(function(e){
  e.preventDefault();

  $('.arquivo_form').remove();
  $('.btn_apagar_arquivo_form').remove();
  $('.container_arquivo_form input').val('').show();
})

var croppie;
var image_uploaded = '';
var width_image_croppie = 0;
var height_image_croppie = 0;
var imagem_escolhida = $('.imagem_form').val();
var imagem_destaque_escolhida = $('.imagem_destaque_form').val();
var input_imagem_ativo = '';
var current_extension = 'png';

$('.image_uploader_modal').on('hidden.bs.modal', function (e) {
  $('.tipo-imagem-div').show();
  $('.tipo-imagem-escolhida').hide();
  image_uploaded = '';

  width_image_croppie = 0;
  height_image_croppie = 0;
  width_image_destaque_croppie = 0;
  height_image_destaque_croppie = 0;

  if(!imagem_escolhida){
    $('.upload_imagem').val('')
  }

  if(!imagem_destaque_escolhida){
    $('.upload_imagem_destaque').val('')
    $('.upload_imagem_responsivo').val('')
  }

  croppie.croppie('destroy');
})

$('.upload_imagem').change(function(){
  $('.image_uploader_modal').modal('show');

  var file = this.files[0];
  var reader  = new FileReader();
  reader.onloadend = function () {
    image_uploaded = reader.result;
  }

  reader.readAsDataURL(file);

  input_imagem_ativo = 'upload_imagem';
  current_extension = $(this).val().split('.').pop();
})

$('.upload_imagem_responsivo').change(function(){
  $('.image_uploader_modal').modal('show');

  var file = this.files[0];
  var reader  = new FileReader();
  reader.onloadend = function () {
    image_uploaded = reader.result;
  }

  reader.readAsDataURL(file);

  input_imagem_ativo = 'upload_imagem_responsivo';
  current_extension = $(this).val().split('.').pop();
})

$('.upload_imagem_destaque').change(function(){
  $('.image_uploader_modal').modal('show');

  var file = this.files[0];
  var reader  = new FileReader();
  reader.onloadend = function () {
    image_uploaded = reader.result;
  }

  reader.readAsDataURL(file);

  input_imagem_ativo = 'upload_imagem_destaque';
  current_extension = $(this).val().split('.').pop();
})

$('.tipo-imagem').click(function(){
  $('.tipo-imagem-div').hide();
  $('.tipo-imagem-escolhida > h2').text($(this).attr('title'))
  $('.tipo-imagem-escolhida').show();

  let tipos = {
    banner:{width:1920/4, height:980/4, original_width:1920, original_height:980, quociente:4},
    cta:{width:1440/3, height:250/3, original_width:1440, original_height:250, quociente:3},
    detalhe_produto:{width:600/2, height:800/2, original_width:600, original_height:800, quociente:2},
    logo_site:{width:280, height:70, original_width:280, original_height:70, quociente:1},
    outro:{width:1280/3, height:720/3, original_width:1280, original_height:720, quociente:3},
    secundaria_banner:{width:400, height:400, original_width:400, original_height:400, quociente:1}
  }

  var width = tipos[$(this).attr('name')].width;
  var height = tipos[$(this).attr('name')].height;
  width_image_croppie = tipos[$(this).attr('name')].original_width;
  height_image_croppie = tipos[$(this).attr('name')].original_height;

  croppie = $('#image-crop').croppie({
  	viewport: {
  		width: width,
  		height: height
  	},
  	boundary: {
  		width: 600,
  		height: 400
  	},
    enforceBoundary:false
  });
   croppie.croppie('bind', {
  	url: image_uploaded,
    zoom:1/tipos[$(this).attr('name')].quociente
  });
})

$('#usar-imagem').click(function(){

  if(current_extension == 'jpg'){
    current_extension = 'jpeg';
  }

  croppie.croppie('result', {type: 'canvas', size: {width:width_image_croppie, height:height_image_croppie }, format:current_extension, quality:0.8})
  .then(function(base64) {

    if(input_imagem_ativo == 'upload_imagem'){
      var html = '<img src="'+base64+'" width="200" height="auto" class="imagem_form">';
      $('.upload_imagem').attr('type','hidden').val(base64);
      $('.container_imagem_form').prepend(html)
      $('.btn_apagar_imagem_form').removeClass('d-none');
      imagem_escolhida = base64;
    }
    else if(input_imagem_ativo == 'upload_imagem_destaque'){
      var html = '<img src="'+base64+'" width="200" height="auto" class="imagem_destaque_form">';
      $('.upload_imagem_destaque').attr('type','hidden').val(base64);
      $('.container_imagem_destaque_form').prepend(html)
      $('.btn_apagar_imagem_destaque_form').removeClass('d-none');
      imagem_destaque_escolhida = base64;
    }
    else{
      var html = '<img src="'+base64+'" width="200" height="auto" class="imagem_destaque_form">';
      $('.upload_imagem_responsivo').attr('type','hidden').val(base64);
      $('.container_imagem_responsiva_form').prepend(html)
      $('.btn_apagar_imagem_responsiva_form').removeClass('d-none');
      imagem_destaque_escolhida = base64;
    }

    $('.image_uploader_modal').modal('hide')

  });
})
