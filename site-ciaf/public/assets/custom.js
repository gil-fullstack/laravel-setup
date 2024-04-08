$(function() {
  // $(document).scroll(function () {
  //   var $nav = $("#navbar");
  //   $nav.toggleClass('bg-white', $(this).scrollTop() > $nav.height());
  // });

  $(document).ready(function() {
    var SPMaskBehavior = function(val) {
        return val.replace(/\D/g, "").length === 11
          ? "(00) 00000-0000"
          : "(00) 0000-00009";
      },
      spOptions = {
        onKeyPress: function(val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
      };

    var CEPMaskBehavior = function(val) {
        return val.replace(/\D/g, "").length >= 12
          ? "00.000.000/0000-00"
          : "000.000.000-009";
      },
      cpfOptions = {
        onKeyPress: function(val, e, field, options) {
          field.mask(CEPMaskBehavior.apply({}, arguments), options);
        }
      };

    $(".phone").mask(SPMaskBehavior, spOptions);
    $(".cpf_cnpj").mask(CEPMaskBehavior, cpfOptions);
    $(".cnpj").mask("00.000.000/0000-00", { reverse: true });
    $(".cep").mask("00000-000");
  });

  var already_leave = 0;

  $(document).mousemove(function(e) {
    if (e.clientY <= 10 && localStorage.getItem("already_leave") != 1) {
      $("#popup-exit").modal();
      localStorage.setItem("already_leave", 1);
    }
  });
});

$(document).ready(function() {
  $(".owl-carousel").owlCarousel({
    loop: false,
    margin: 10,
    responsive: {
      0: {
        items: 1
      },
      800: {
        items: 3
      },
      1000: {
        items: 5
      }
    }
  });
});

$(".close-popup-exit").click(function(e) {
  e.preventDefault();

  $(".popup-exit").hide();
});

$(".btn-cta").click(function(e) {
  e.preventDefault();
  // $('.popup-cta').show();
  $("#popup-cta").modal("show");
});

$(".close-popup-cta").click(function(e) {
  e.preventDefault();

  $(".popup-cta").hide();
});

$("#tipo_plano").change(function(e) {
  let tipo = $(this).val();

  $(".price").hide();
  $(".price[data-id=" + tipo + "]").show();
});

$(".solucao-toggle").click(function() {
  if ($(this).attr("aria-expanded") == "true") {
    $(this)
      .children("i")
      .removeClass("fa-minus")
      .addClass("fa-plus");
    $(this)
      .children("span")
      .text("Ver mais");
  } else {
    $(this)
      .children("i")
      .removeClass("fa-plus")
      .addClass("fa-minus");
    $(this)
      .children("span")
      .text("Ver menos");
  }
});

$(".cpf_cnpj").blur(function() {
  if ($(this).val().length == 18) {
    var cnpj = $(this)
      .val()
      .replace(/\D/g, "");

    $(".nome_fantasia").val("...");
    $(".razao_social").val("...");
    $(".telefone").val("...");
    $(".email").val("...");

    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      }
    });

    $.ajax({
      url: "/buscar_cnpj",
      data: { cnpj: cnpj },
      method: "POST",
      success: function(result) {
        var retorno = result.dados;

        if (retorno == null) {
          $(".nome_fantasia").val("");
          $(".razao_social").val("");
          $(".telefone").val("");
          $(".email").val("");
          $("#validador").val("true");
          Swal.fire({
            title: "O CNPJ/CPF não foi encontrado.",
            text: "Por favor preencha manualmente.",
            icon: "warning"
          });
        } else if (retorno.status == "OK") {
          $(".nome_fantasia").val(retorno.fantasia);
          $(".razao_social").val(retorno.nome);
          $(".telefone").val(retorno.telefone);
          $(".email").val(retorno.email);
          $("#validador").val("true");
        } else if (retorno.status == "ERROR") {
          $(".nome_fantasia").val("");
          $(".razao_social").val("");
          $(".telefone").val("");
          $(".email").val("");
          $("#validador").val("false");
          Swal.fire({
            title: "O CNPJ/CPF não foi encontrado.",
            text: "Por favor preencha manualmente.",
            icon: "warning"
          });
        } else {
          $(".nome_fantasia").val("");
          $(".razao_social").val("");
          $(".telefone").val("");
          $(".email").val("");
          $("#validador").val("true");
          Swal.fire({
            title: "O CNPJ/CPF não foi encontrado.",
            text: "Por favor preencha manualmente.",
            icon: "warning"
          });
        }
      }
    });
  }
});

$(".cep").blur(function() {
  if ($(this).val().length == 9) {
    var cep = $(this)
      .val()
      .replace(/\D/g, "");
    $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function(
      dados
    ) {
      if (!dados.erro) {
        $(".endereco").val(dados.logradouro);
        $(".bairro").val(dados.bairro);
        $(".cidade").val(dados.localidade);
        $(".uf").val(dados.uf);
      }
    });
  }
});

$("#submit_form_checkout").click(function(e) {
  e.preventDefault();

  if ($("#validador").val() == "true") {
    $("#form_checkout")
      .find('[type="submit"]')
      .trigger("click");
  } else {
    Swal.fire({
      title: "O CNPJ/CPF não foi encontrado.",
      text: "Deseja enviar o formulário mesmo assim?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Enviar",
      cancelButtonText: "Voltar"
    }).then(result => {
      if (result.value) {
        $("#form_checkout")
          .find('[type="submit"]')
          .trigger("click");
      }
    });
  }
});
