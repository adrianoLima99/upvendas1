function ajaxInit(){
    var xmlhttp;
    try{
        xmlhttp = new XMLHttpRequest();
       }catch(ee){
           try{
               xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            }catch(e){
                try{
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
               }catch(E){
                   xmlhttp = false;
               }
       }
      }
      return xmlhttp;
      }
function selecionaVendedor()
{
    ajax=ajaxInit();
    if(ajax)
    {
     ger = document.getElementById('gerente').value;
     
     ajax.open('GET','js/consultaVendedor.php?id='+ger,'true');  
     ajax.onreadystatechange = function(){
     if(ajax.readyState == 4){
      if(ajax.status ==200){
         document.getElementById('exibir').innerHTML=ajax.responseText; 
        
            
      }
          
 }
    }
    }
    ajax.send(null) ;
}
function selecionaOperador()
{
    ajaxOP=ajaxInit();
    if(ajaxOP)
    {
  
     ajaxOP.open('GET','js/operador.class.php','true');
     ajaxOP.onreadystatechange = function(){
     if(ajaxOP.readyState == 4){
      if(ajaxOP.status ==200){
         document.getElementById('operador').innerHTML=ajaxOP.responseText; 
        
       }
      }
    }
   }
    ajaxOP.send(null) ;
}

function selecionaOperador2()
{
    ajaxOP=ajaxInit();
    if(ajaxOP)
    {
      id = document.getElementById('exibiGerTel').value;
     
    
     ajaxOP.open('GET','js/operador.class.php?superior='+id,'true');
     ajaxOP.onreadystatechange = function(){
     if(ajaxOP.readyState == 4){
      if(ajaxOP.status ==200){
         document.getElementById('operador').innerHTML=ajaxOP.responseText; 
        
       }
      }
    }
   }
    ajaxOP.send(null) ;
}
function lembraAdiados()
{
    ajax=ajaxInit();
    if(ajax)
    {
     
     ajax.open('GET','lembrete/lembrar.class.php','true');  
     ajax.onreadystatechange = function(){
     if(ajax.readyState == 4){
      if(ajax.status ==200){
         document.getElementById('lembrar').innerHTML=ajax.responseText; 
          
       }
          
 }
    }
    }
    ajax.send(null) ;
}
function mensagem(){
	alert("Voce tem acompanhamento nesse horaio")
}


function selecionaCargo()
{
    ajax=ajaxInit();
    if(ajax)
    {
     cargo = document.getElementById('cargo').value;
     empresa=document.getElementById('cliEmpresa').value;
     ajax.open('GET','js/consultas.class.php?cargo='+cargo+'&empresa='+empresa,'true');  
     ajax.onreadystatechange = function(){
     if(ajax.readyState == 4){
      if(ajax.status ==200){
         document.getElementById('nomeCargo').innerHTML=ajax.responseText; 
        
            
      }
          
 }
    }
    }
    ajax.send(null) ;
}
function selecionaPerfil()
{
    ajax=ajaxInit();
    if(ajax)
    {
     perfil = document.getElementById('perfil').value;
     empresa = document.getElementById('cliEmpresa').value;
     
     ajax.open('GET','js/perfil.class.php?perfil='+perfil+'&empresa='+empresa,'true');  
     ajax.onreadystatechange = function(){
     if(ajax.readyState == 4){
      if(ajax.status ==200){
         document.getElementById('retornaPerfil').innerHTML=ajax.responseText; 
        
            
      }
          
 }
    }
    }
    ajax.send(null) ;
}

function selecionaGerente()
{
    ajax=ajaxInit();
    if(ajax)
    {
   // sup=document.getElementById("adm").value;
    // ajax.open('GET','js/gerenteVenda.class.php?id='+sup,'true');
    ajax.open('GET','js/gerenteVenda.class.php','true');
     ajax.onreadystatechange = function(){
     if(ajax.readyState == 4){
      if(ajax.status ==200){
         document.getElementById('gerente').innerHTML=ajax.responseText; 
      
        }
       }
    }
   }
    ajax.send(null) ;
}
function selecionaGerOpRel()
{
     ajax=ajaxInit();
     ajax2=ajaxInit();
     ajax3=ajaxInit();
     ajax4=ajaxInit();
     ajax5=ajaxInit();
      ajax6=ajaxInit();
       ajax7=ajaxInit();
        ajax8=ajaxInit();
   
      if(ajax3)
    {
     
     
     ajax3.open('GET','js/administrador.class.php','true');  
     ajax3.onreadystatechange = function(){
     if(ajax3.readyState == 4){
      if(ajax3.status ==200){
         document.getElementById('adm').innerHTML=ajax3.responseText; 
        
            
      }
          
 }
    }
    }
    ajax3.send(null) ;
  
    if(ajax5)
    {
     
     
     ajax5.open('GET','js/gerenteTel.class.php','true');  
     ajax5.onreadystatechange = function(){
     if(ajax5.readyState == 4){
      if(ajax5.status ==200){
         document.getElementById('exibiGerTel').innerHTML=ajax5.responseText; 
        
            
      }
          
 }
    }
    }
    ajax5.send(null) ;
    if(ajax6)
    {
     
     
     ajax6.open('GET','js/plano.class.php','true');  
     ajax6.onreadystatechange = function(){
     if(ajax6.readyState == 4){
      if(ajax6.status ==200){
         document.getElementById('plano').innerHTML=ajax6.responseText; 
        
            
      }
          
 }
    }
    }
    ajax6.send(null) ;
   if(ajax7)
    {
     
     
     ajax7.open('GET','js/produto.class.php','true');  
     ajax7.onreadystatechange = function(){
     if(ajax7.readyState == 4){
      if(ajax7.status ==200){
         document.getElementById('exibiProd').innerHTML=ajax7.responseText; 
        
            
      }
          
 }
    }
    }
    ajax7.send(null) ; 
    
   
 
}
function verificaAgendados()
{
    ajax=ajaxInit();
    if(ajax)
    {
     
     ajax.open('GET','js/Agendados.class.php','true');  
     ajax.onreadystatechange = function(){
     if(ajax.readyState == 4){
      if(ajax.status ==200){
         document.getElementById('agendados').innerHTML=ajax.responseText; 
        
            
      }
          
 }
    }
    }
    ajax.send(null) ;
}

function verificaUsuario()
{
    ajax=ajaxInit();
    if(ajax)
    {
     usuario=document.getElementById("usuario").value;
     funcionario=document.getElementById("nomeCargo").value;
     ajax.open('GET','ajax/ListaUsuario.class.php?usuario='+usuario+'&funcionario='+funcionario,'true');  
     ajax.onreadystatechange = function(){
     if(ajax.readyState == 4){
      if(ajax.status ==200){
      document.getElementById('check').innerHTML=ajax.responseText; 
        //  document.getElementById('check').value=ajax.responseText;
            
      }
          
 }
    }
    }
    ajax.send(null) ;
}




