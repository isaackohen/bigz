@include('errors.error', ['code' => 500, 'desc' => 'An error occured.'])

<script type="text/javascript">   
    function Redirect() 
    {  
        window.location="/internalerror/"; 
    } 
    setTimeout('Redirect()', 8000);   
</script>