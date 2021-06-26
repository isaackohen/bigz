@include('errors.error', ['code' => 403, 'desc' => 'Access denied'])

<script type="text/javascript">   
    function Redirect() 
    {  
        window.location="/huh/"; 
    } 
    setTimeout('Redirect()', 9000);   
</script>