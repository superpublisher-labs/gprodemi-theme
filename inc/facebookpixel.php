<?php 
$pixel = $_GET['pixel'];
if($pixel){
?>

<!-- Meta Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '<?=$pixel?>');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=<?=$pixel?>&ev=PageView&noscript=1"
/></noscript>


<script>
// Função para disparar o evento Purchase
function dispararEvento() {
    // Código para disparar o evento, como enviar dados para o Facebook Pixel
    //console.log('Usuário navegou para a segunda página.');
    // Exemplo de envio de evento para o Facebook Pixel
    fbq('track', 'Purchase');
}

// Verifica se o localStorage está disponível
if (typeof(Storage) !== "undefined") {
    // Obtém a contagem de páginas navegadas do localStorage
    let pageCount = localStorage.getItem('pageCount');
    
    // Se não houver contagem, inicialize com 0
    if (!pageCount) {
        pageCount = 0;
    }

    // Incrementa a contagem de páginas
    pageCount++;
    
    // Armazena a contagem atualizada no localStorage
    localStorage.setItem('pageCount', pageCount);
    
    // Verifica se é a segunda página navegada
    if (pageCount == 2) {
        dispararEvento();
    }
} else {
    console.log("localStorage não é suportado neste navegador.");
}
</script>

<!-- End Meta Pixel Code -->
<?php 
}
?>