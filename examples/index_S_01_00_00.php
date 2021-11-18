 <!DOCTYPE html>
        <html lang="en">
        <head>
          <title>Resumo</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
          <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
          <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
          <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        </head>
        <body>
        <script>
          $(document).ready(function() {
              $("#example").DataTable( {
                  "scrollY":        "500px",
                  "scrollCollapse": true,
                  "paging":         false
              } );
          } );
        </script>
        <div class="container">
          <br>
          <center><h3>S_01_00_00</h3></center>
          <p> <span style=" float: right;"></span>Click nos links abaixo para criar o Schema e em seguinda executar o envio Fake do evento</p>
          <table class="table" id="example">
            <thead>
              <tr>
                <th>Arquivos Json Schema - v_S_01_00_00 </th>               
                <th>Traits - v_S_01_00_00 </th>   
                <th>Fake - v_S_01_00_00 </th>   
              </tr>
            </thead>
            <tbody>
         <?php       
            //carrega informacoes da Traits
            $path_traits = "../src/Factories/Traits/";
            $diretorio_traits = dir($path_traits);
            $array_traits = array();
            while($arquivo = $diretorio_traits -> read()){
              
              if(strlen($arquivo)>3 and trim($arquivo)<>''){
                array_push($array_traits, array('identificador_trait'=>strtolower(substr($arquivo,5,5)),'nome'=>$arquivo,'url'=>$path_traits.$arquivo));
              } 
            }   
           
         		//carrega informacoes do Fake
         		$path_fake = "Fake/v_S_01_00_00/";
    				$diretorio_fake = dir($path_fake);
    				$array_fake = array();
    				while($arquivo = $diretorio_fake -> read()){
    					
    					if(strlen($arquivo)>3 and trim($arquivo)<>''){
    						array_push($array_fake, array('identificador'=>substr($arquivo,5,5),'nome'=>$arquivo,'url'=>$path_fake.$path.$arquivo));
    					}	
    				}					
    				//lista informacoes dos schemas
    		        $path = "schemes/v_S_01_00_00/";
    				$diretorio = dir($path);
    				while($arquivo = $diretorio -> read()){
    					if(strlen($arquivo)>3 and trim($arquivo)<>''){
    						    $codigo_evento = substr($arquivo,0,5);
    						    $achou_array_fake = array_filter($array_fake, function ($var) use ($codigo_evento) {
                
               					 return (($var['identificador'] == $codigo_evento)) ? $var : null;
            				});
            				if($achou_array_fake){
            					
             					$caminho_arquivo_fake = $achou_array_fake[key($achou_array_fake)]['url'];
    							    $arquivo_fake = $achou_array_fake[key($achou_array_fake)]['nome'];
            				}

                     $achou_array_trait = array_filter($array_traits, function ($var) use ($codigo_evento) {
                
                         return (($var['identificador_trait'] == $codigo_evento)) ? $var : null;
                    });

                    if($achou_array_trait){
                      
                      $caminho_arquivo_trait = $achou_array_trait[key($achou_array_trait)]['url'];
                      $arquivo_trait = $achou_array_trait[key($achou_array_trait)]['nome'];
                    }    
                    echo '<tr><td>'.'<a href="'.$path.$arquivo.'"" target="_blank">'.$arquivo.'</a>'.'</td>
                    <td>'.'<a href="javascript:void(0)'.'"" title="'.$caminho_arquivo_trait.'">'.$arquivo_trait.'</a>'.'</td>
                    <td>'.'<a href="'.$caminho_arquivo_fake.'"" target="_blank">'.$arquivo_fake.'</a>'.'</td></tr>';
    					}					
    				}
    				$diretorio -> close();
         ?>   	
        <tr><td></td><td></td><td></td><td >&nbsp; </td><td >&nbsp; </td><td align="right" > </td> </tr>
        </tbody>
      </table>
    </div>
    </body>
    </html>