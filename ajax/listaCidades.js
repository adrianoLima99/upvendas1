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
function listaCidades()
{
    ajax=ajaxInit();
    if(ajax)
    {
     id = document.getElementById('uf').value;
     
     ajax.open('GET','ajax/ConsultaMunicipio.class.php?id='+id,'true');  
     ajax.onreadystatechange = function(){
     if(ajax.readyState == 4){
      if(ajax.status ==200){
         document.getElementById('municipio').innerHTML=ajax.responseText; 
        
            
      }
          
 }
    }
    }
    ajax.send(null) ;
}

