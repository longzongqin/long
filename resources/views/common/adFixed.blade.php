<script type="text/javascript">
    var clientWidth = document.body.clientWidth;
    if(clientWidth > 768){
        /*pc-悬浮*/
        var cpro_id = "u3053317";
        var scriptNode = document.createElement("script");
        scriptNode.setAttribute("type", "text/javascript");
        scriptNode.setAttribute("src", "http://cpro.baidustatic.com/cpro/ui/c.js");
    }else{
        /*phone-悬浮*/
        var cpro_id = "u3053315";
        var scriptNode = document.createElement("script");
        scriptNode.setAttribute("type", "text/javascript");
        scriptNode.setAttribute("src", "http://cpro.baidustatic.com/cpro/ui/cm.js");
    }
    document.body.appendChild(scriptNode);
</script>