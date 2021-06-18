<div class="container-fluid">


@if(!auth()->guest())
    


<div id="slotcontainer" class="container-xl">
  <div id="card_live" class="card"  style="background: #111a1e !important; box-shadow: none !important;">
    <div id=parent>
          <iframe src="<?php echo $url; ?>" border="0"></iframe>

    </div>
  </div>
</div>


@else

    Please login

@endif
  </div>


  <style>

iframe { 
  width : 100%;
  height : 75vh;
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