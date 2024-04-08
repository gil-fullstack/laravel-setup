<!DOCTYPE html>
<html lang="pt-bt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NDZ7GC6');</script>
    <!-- End Google Tag Manager -->

    <!-- Global site tag (gtag.js) - Google Ads: 661974299 --> 
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-661974299"></script> 
    <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-661974299'); </script>
    
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '3679703918817308');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=3679703918817308&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->

    <!-- Google Adsense -->
    <script data-ad-client="ca-pub-1443218375070475" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    {{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}
    {!! NoCaptcha::renderJs() !!}

    <title>CIAF - Soluções em Software</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="reply-to" content="fabio@ciaf.com.br">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Conheça nossos sistemas utilizando 5 dias de avaliação e suporte gratuito! Atendemos o comércio em geral, pequenas indústrias e prestadores de serviço.">
    <meta name="author" content="CIAF - Soluções em Software">
    <meta name="robots" content="index, follow, all">
    <meta name="googlebot" content="index, follow, all">
    <meta name="keywords" content="CIAF, Petsystem, CIAF Automotivo, Docsystem, software, cadastro de clientes, financeiro, controle de estoque, relatório, controle bancário, contas a pagar, contas a receber, levantamento diário, duplicatas, compras, cadastro de produtos, relatórios, CEP, prontuário, agenda, secretária, convênios, pet shop, clínica veterinária, animais, vacinas, vermífugos, acompanhamento de peso, receituário, fotos de animais, acompanhamento, orçamento por e-mail, emissao de orçamento, ordem de serviço, controle de km, oficina mecânica, automotivo, centro automotivo, veículos, motos, CIAF Médico, CIAF Hotelaria, Petsystem">
    <link rel="shortcut icon" href="{{asset('storage/images/favicon.ico')}}" type="image/x-icon">

    <!-- Scripts -->
    <script type="text/javascript" src="{{asset('assets/jquery.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/owl-carousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/owl-carousel/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/custom.css')}}">
    <link rel="stylesheet" href="{{asset('assets/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/animated.css')}}">
  </head>
  <body>

    @component('layouts/navbar',compact('navbar'))
    @endcomponent

    @yield('content')

    @component('layouts/chat')
    @endcomponent

    @component('layouts/footer',compact('footer'))
    @endcomponent

    @component('layouts/popup-cta')
    @endcomponent


    <script type="text/javascript" src="{{asset('assets/fontawesome.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/owl-carousel/owl.carousel.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/jquery.mask.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript" src="{{asset('assets/custom.js')}}"></script>
  </body>
</html>
