<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <title>bigz.io</title>
<?php if(!isset($_GET['token'])) {
    $length = 6;
$randomString = substr(str_shuffle(md5(time())),0,$length);
echo '<meta http-equiv="refresh" content="0;URL=?&token='.$randomString.'"/>';
header("Refresh:1");

} ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="{{ asset('/img/logo/ico.png') }}">
        <link rel="stylesheet" href="{{ mix('/css/pages/error.css') }}">

<style>
    #showMe {
  animation: cssAnimation 0s 5s forwards;
  opacity: 0; 
}

@keyframes cssAnimation {
  to   { opacity: 1; }
}

body {
  font-family: 'Trebuchet MS', sans-serif;
}
</style>
    </head>

    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background: #19262b !important;">

</nav>


    <section class="error_section">
<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" class="svg position-absolute d-none d-lg-block" style="height: 650px;width: 100%;z-index: -10;/* overflow: hidden; *//* transform: scaleY(1.5); */-webkit-transform: scaleX(-1);transform: scaleX(-1) scaleY(1.5);">
  <defs>
    <linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0">
      <stop stop-color="#162327" offset="0%"></stop>
      <stop stop-color="#162327" offset="100%"></stop>
    </linearGradient>
  </defs>
  <path fill="url(#sw-gradient-0)" d="M 0.351 264.418 C 0.351 264.418 33.396 268.165 47.112 270.128 C 265.033 301.319 477.487 325.608 614.827 237.124 C 713.575 173.504 692.613 144.116 805.776 87.876 C 942.649 19.853 1317.845 20.149 1440.003 23.965 C 1466.069 24.779 1440.135 24.024 1440.135 24.024 L 1440 0 L 1360 0 C 1280 0 1120 0 960 0 C 800 0 640 0 480 0 C 320 0 160 0 80 0 L 0 0 L 0.351 264.418 Z">
  </path>
</svg>
        <p id="showMe" style="margin-top: 10vw; color: #fff; font-size: 0.85rem; font-weight: 600;">{{ $code ?? -1 }}</p>

        <img  style="top: 0; bottom: 0; margin: auto; left: 0; right: 0; height: 100px; width: 100px;" src="https://i.imgur.com/K3e4Bml.gif">

    </section>                            

