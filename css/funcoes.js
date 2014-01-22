/*if($('#escolha:selected').val('cpf') )
{
    $(document).ready(function() {

$("#escolha").change(function() {
$("#painel").html("Este é o cpf!");
});
});
}else if($('#escolha:selected').val('cnpj') )
{
    $(document).ready(function() {

$("#escolha").change(function() {
$("#painel").html("Este é o cnpj!");
});
});
}*/

function val(valor){
    
  
  if(document.getElementById('escolha').value== valor)
  {
     alert('cpf')
     escreva= document.getElementById('painel').innerHTML="<tr>"+
                                                   "<td>CPF:</td><td><input type='text' name='cpf' id='cpf' placeholder='numero cpf'/></td>"+
                                                   "</tr> ";
     return escreva;                                         
  }else if(document.getElementById('escolha').value== valor)
  {
      alert('cnpj selecionado')
      escreva= document.getElementById('painel').innerHTML=="<tr>"+
                                                   "<td>CNPJ:</td><td><input type='text' name='cnpj' id='cnpj' placeholder='numero cnpj'/></td>"+
                                                   "</tr> ";
                                                 return escreva;  
  }  
  else {
      alert('telefone selecionado')
    escreva = document.getElementById('painel').innerHTML=="<tr>"+
                                                   "<td>tel:</td><td><input type='text' name='telefone' class='tel' placeholder='numero telefone'/></td></tr><tr>"+
                                                    "<td>Cliente:</td><td><input type='text' name='cliente' placeholder='nome cliente'/></td>" +
                                                      "</tr> ";
                                                return escreva;
  }  
}