# Bugs encontrados 

### Zoom aplicado ao diminuir o tempo do zoom
O zoom das imagens na posição 2 e 4 não estão sendo aplicado ao diminuir o tempo do zoom. Isto ocorre com durações 
abaixo de 5 segundos.<br>
Aparentemente, o tipo de concatenação está intereferindo nisso. Pois a concatenação do tipo "[v0][v1][v2][v3][v4]concat=n=5:v=1:a=0", no arquivo londonComZoom, funciona, porém as concatenações restantes envolvendo transções este problema aparece. <br> <br>
Relatado: 13/03/2024

#### Ideias
O problema, a princípio, não são as imagens, mas sim as posições dela. <br>
Verificar se não é as posições de número par, o tempo de transação, codecs adequados, etc.