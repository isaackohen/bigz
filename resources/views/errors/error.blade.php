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


</style>
    </head>

        <p id="showMe" style="margin-top: 10vw; color: #fff; font-size: 0.85rem; font-weight: 600;"></p>

        <div class="pageLoader">
            <img style="position: absolute; top: 0; bottom: 0; margin: auto; left: 0; right: 0; height: 100px; width: 100px;" src="/img/logo/bigz-preload-small.gif">
        </div>


    </section>                            

