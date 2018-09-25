$(document).ready(function(){
    //$(".iframe1").colorbox({iframe:true,width:"860", height:"500",transition:"fade", scrolling:true, opacity:0.7});
    $(".iframe2").colorbox({iframe:true,width:"600", height:"550",transition:"fade", scrolling:false, opacity:0.7});
    //$(".iframe3").colorbox({iframe:true,width:"420", height:"430",transition:"fade", scrolling:false, opacity:0.7});
    $("#click").click(function(){ 
        $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
        return false;
    });

    $("area[rel^='prettyPhoto']").prettyPhoto();

            $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
            $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});

            $("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
                custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
                changepicturecallback: function(){ initialize(); }
            });

            $("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
                custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
                changepicturecallback: function(){ _bsap.exec(); }
            });

     //Selecciona programa.
     $('#id_p').on('input', function () {
         var opt = $('option[value="' + $(this).val() + '"]');
         $("#id_programa").val(opt.attr('id'));
         buscaPrograma(opt.attr('id'));
     });

    //Selecciona numero de parte.
    //Selecciona numero de parte.
    $('#nparte').on('input',function() {
        var opt = $('option[value="'+$(this).val()+'"]');
        $("#parte").val(opt.attr('id'));
        var id = $("#parte").val();
        if (id != "") {
            buscaParte(id);
        }else{
            $("#fibra_id").html("")
        }
        
    });
});

//Muestra el modal cortes.
function myFunction() {
var popup = document.getElementById("myPopup");
popup.classList.toggle("show");
}

//Cierra colorbox.
function cerrarV(){
$.fn.colorbox.close();
}

//Abre colorbox con pantalla editar_corte_prod.
function abrir(id)
{
$.colorbox({iframe2:true,href:"editar_corte_prod.php?id="+id,width:"420", height:"430",transition:"fade", scrolling:true, opacity:0.7});	
}

//Abre colorbox con pantalla editar_pausa_prod.
function abrir2(id)
{	
$.colorbox({iframe2:true,href:"editar_pausa_prod.php?id="+id,width:"820", height:"630",transition:"fade", scrolling:true, opacity:0.7});	
}

//Pasa el lugar seleccionado en el filtro.
function seleccionaLugar()
{
document.form1.lugar_b.value=document.form2.lugar_b.value;
}

//Ocultar.
function ocultar()
{
var btn=document.getElementById('btn1').value;
if(btn=="-")
{
document.getElementById('btn1').value="+";
document.getElementById('lis').style.display="none";
}
else
{
document.getElementById('btn1').value="-";
document.getElementById('lis').style.display="block";
}
}

function textAreaAdjust(o)
{
o.style.height = "1px";
o.style.height = (25+o.scrollHeight)+"px";
}

//Borrar registro.
function borrar(id)
{
if(confirm("Esta seguro de borrar este Corte?"))
{
    document.form1.borrar.value=id;
    document.form1.submit();
}
}

//llena el campo numero de parte
function buscaPrograma(valor)
{
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 
var y=valor;
var xmlhttp;
var resultado;
if($('#id_cut_type').val() !=3)
{
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            resultado=xmlhttp.responseText;
            var m=document.getElementById('id_parte');
            m.innerHTML=resultado;
        }
    }
    var tipo=0;
    xmlhttp.open("GET","buscaPrograma.php?id="+y,true);
    xmlhttp.send();
    return false;
}
else
{
    y=999999;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            resultado=xmlhttp.responseText;
            var m=document.getElementById('id_parte');
            m.innerHTML=resultado;
        }
    }
    var tipo=0;  
    xmlhttp.open("GET","buscaPrograma.php?id="+y,true);
    xmlhttp.send();		
    buscaParte(999999);
    return false;				
}  
}

function buscaParte(valor)
{
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 
var y=valor;
var xmlhttp;
var resultado;
if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        resultado=xmlhttp.responseText; 
        var m=document.getElementById('d_fibra');
        m.innerHTML=resultado;
    }
}
var tipo=0;
xmlhttp.open("GET","buscaParte.php?id="+y,true);
xmlhttp.send();
return false;		
}

function capturar(valor)
{
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 
var fibra="";
var check=document.getElementsByName('fibra_id[]');
for(i=0; i<check.length; i++)
{
    
    if(check[i].checked==true)
    {
        fibra=check[i].value;
    }
}
if(fibra=="")
{
    alert("Seleccione fibra");
}
else
{
    if(document.form1.location_assigned_id.value==0)
    {
        alert("Seleccione fibra");
    }
    else
    {
        var y=valor;
        var xmlhttp;
        var resultado;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                resultado=xmlhttp.responseText;
                var m=document.getElementById('d_pos');
                m.innerHTML=resultado;
            }
        }
        var tipo=0;
        if(document.form1.captura.checked)  
            xmlhttp.open("GET","buscaRollo_n.php?fibra="+fibra+"&location="+document.form1.location_assigned_id.value,true);
        else
            xmlhttp.open("GET","buscaRollo_n.php?fibra=0&location=0",true);
            xmlhttp.send();
    }
}		
return false;		

}

/*
Funcion llamada en cortes cuando seleccionas tipos de corte.

*/
function buscaParche() {
    $("#captura").prop("checked", false);
    $('#id_p').val("");
    $('#nparte').val("");
    $('#fibra_id').hide();
    $('#d_fibra').html("<label>Fibra:</label>");
    var tipocorte = $('#id_cut_type').val();

    /**
     * Cuando el tipo de corte es Daily
     */
    if (tipocorte == 6) {
        var a = document.getElementById('d_fibra');
        a.style.visibility = "hidden";
        var b = document.getElementById('d_prog');
        b.style.visibility = "hidden";
        var c = document.getElementById('d_parte');
        c.style.visibility = "hidden";
        var d = document.getElementById('d_lugar');
        d.style.visibility = "hidden";
    } else {
        var a = document.getElementById('d_fibra');
        a.style.visibility = "visible";
        var b = document.getElementById('d_prog');
        b.style.visibility = "visible";
        var c = document.getElementById('d_parte');
        c.style.visibility = "visible";
        var d = document.getElementById('d_lugar');
        d.style.visibility = "visible";
    }
    /**
     * Tipo de corte es parche.
     */
    if (tipocorte == 3) {
        $("#captura").prop("checked", true);
        $('#length_measured').val(0);
        var strUserAgent = navigator.userAgent.toLowerCase();
        var isIE = strUserAgent.indexOf("msie") > -1;
        var xmlhttp;
        var resultado;
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                resultado = xmlhttp.responseText;
                var m = document.getElementById('d_lugar');
                m.innerHTML = resultado;
            }
        }
        var tipo = 0;
        xmlhttp.open("GET", "mostrarLectra.php", true);
        xmlhttp.send();
        buscaParte(999999);
    }
    return false;
}

function mostrarLectras()
{
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 
var xmlhttp;
var resultado;
if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        resultado=xmlhttp.responseText;
        var m=document.getElementById('d_lugar');
        m.innerHTML=resultado;
    }
}
var tipo=0;
xmlhttp.open("GET","mostrarLectra.php",true);
xmlhttp.send();
if(!document.form1.fallout.checked)
    buscaFibra(document.form1.fibra_id.value);
return false;		
}
function buscaFibra(valor)
{
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 
var x=valor.split("|");
var y=x[0];
document.form1.length_measured.value=x[1];
var xmlhttp;
var resultado;
if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        resultado=xmlhttp.responseText;
        var m=document.getElementById('d_lugar');
        m.innerHTML=resultado;
    }
}
var tipo=0;
xmlhttp.open("GET","buscaFibra.php?id="+y,true);
xmlhttp.send();
buscaRollo(valor);
return false;		
}
function buscaRollo(valor)
{
var strUserAgent = navigator.userAgent.toLowerCase(); 
var isIE = strUserAgent.indexOf("msie") > -1; 
var x=valor.split("|");
var y=x[0];
document.form1.length_measured.value=x[1];
var xmlhttp;
var resultado;
if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        resultado=xmlhttp.responseText;
        var m=document.getElementById('d_rollo');
        m.innerHTML=resultado;
    }
}
var tipo=0;
xmlhttp.open("GET","buscaRollo.php?id="+y,true);
xmlhttp.send();	
return false;		
}

function buscaLugar()
{
var program = $('#id_p').val();  
if (program != "")
{
    var valor = $('#location_assigned_id').val();
    var strUserAgent = navigator.userAgent.toLowerCase(); 
    var isIE = strUserAgent.indexOf("msie") > -1; 
    var y=valor;
    var z=document.form1.fibra_id.value.split("|");
    var xx=0;
    xx=1;

    var w=document.form1.id_cut_type.value;
    var xmlhttp;
    var resultado;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            resultado=xmlhttp.responseText;
            var m=document.getElementById('d_pos');
            m.innerHTML=resultado;
        }
    }

    var tipo=0;
    xmlhttp.open("GET","buscaLugar.php?id="+y+"&fiber="+z[0]+"&fall="+xx+"&parche="+w,true);
    xmlhttp.send();	
    return false;
}
else 
{
    alert('Programa no seleccionado');
    $( "#id_p" ).focus();
}
    
}

function validar() 
{
    if (document.form1.id_cut_type.value != 6) //daily
    {
        if (document.form1.id_cut_type.value != 3) //parche
        {
            if (document.form1.location_assigned_id.value == 0) 
            {
                alert("Seleccione Lugar");
                return false;
            }
        } 
        else 
        {
            document.querySelector('#id_p').required = false;
        }
    } 
    else 
    {
        var condiciones = $("#captura").is(":checked");
        if (condiciones)
        {
            $("#captura").prop("checked", false);
        }
        document.querySelector('#id_p').required = false;
        return true;
    }
}

function mostrar(posicion)
{
    var datos=document.form1.number_position.value.split("|");
    document.form1.longitud_real.value=datos[1];
    document.form1.longitud_restante.value=datos[2];
}
function mostrar2(posicion)
{
    var datos=document.form1.roll_id.value.split("|");
    document.form1.longitud_real.value=datos[1];
    document.form1.longitud_restante.value=datos[2];
    if(document.form1.longitud_restante.value*1< document.form1.length_measured.value*1)
    {
        document.form1.number_position.value=0;
        alert("No hay suficiente fibra para este corte");
    }
}

$('.datepick').each(function(){
$(this).datepicker({ dateFormat: 'yy-mm-dd' });
});
