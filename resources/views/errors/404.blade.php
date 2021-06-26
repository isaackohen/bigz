@if(env('APP_DEBUG', false)) {{ url()->current() }} @endif
@include('errors.error', ['code' => 404])

<script type="text/javascript">   
    function Redirect() 
    {  
        window.location="/huh/"; 
    } 
    setTimeout('Redirect()', 8000);   
</script>