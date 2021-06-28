

@if(!auth()->guest())
    <div class="container-fluid">

          <iframe src="<?php echo $url; ?>" border="0"></iframe>
      <button onclick="redirect('/')" title="Return to Home" class="btn btn-primary-small-dark btn-rounded p-1 m-2" style="min-width: 65px; font-size: 15px;"><i class="fas fa-home"></i></button>

    </div>


@else

    Please login

@endif


  <style>

.fixed {
  min-height: 45px !important;
}

header {
  display: none !important;
}

.chat .fixed {
  height:  100% !important;
  top:  0px !important;
}

footer {
  display:  none !important;
}

.live {
  display:  none !important;
}
 
.wallet {
  display: none !important;
}

iframe { 
  width : 100%;
  height : 95vh;
}
body {
    text-shadow: 0 0 black !important;
}
.body {
    text-shadow: 0 0 black !important;
}
.main {
    text-shadow: 0 0 black !important;
}

#card_live {
    background-color: #19262b !important;
    box-shadow: none !important;
}

#parent > button {
  opacity: 0.3;
  position:relative;
  float: right;
  right:10px;
  bottom:60px;
  transition: 0.5s;
}
#parent > button {
  opacity: 1;
}  
</style>