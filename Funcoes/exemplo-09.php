<?php

//exemplo de funcao recursiva

	$hierarquia = array(
		array(
			'nome_cargo' => 'CEO',
			'subordinados' => array(
				//inisio diretor comercial
				array(
					'nome_cargo'=>'Diretor Comercial',
					'subordinados'=>array(
					//inicio gerente de vendas
						array(					
							'nome_cargo'=>'Gerente de vendas'												
						)
					)
					//fim gerente de vendas
				),				
				//termino do diretor comerical
				//inicio diretor financeiro
				array(
					'nome_cargo'=>'Diretor financeiro',
					'subordinados'=>array(
						//inicio: gerente contas a pagar
						array(
							'nome_cargo'=>'Gerende de Contas a Pagar',
							'subordinados'=>array(
								//inicio do supevisor de pagamentos
								array(
									'nome_cargo'=>'Supervisor de Pagamentos'
								)
								//fim supervisor de pagamentos
							)
						),
						//termino: gerente contas  a pagar
						//inicio: gerente de compras
						array(
							'nome_cargo'=>'Gerente de compras',
							'subordinados'=> array(
								//inicio: supervisor de suprimentos
								array(
									'nome_cargo'=>'Supervisor de Suprimentos'
								)		
								//fim: supervisor de suprimentos								
							)
							
						)
					)
				
				)							
			) 
		)
	);
	
	
	function exibe($cargos)
	{
		$html = '<ul>';

		foreach($cargos as $cargo)
		{
			$html .= '<li>';
				
			//echo "<br>";
			//var_dump($cargo);
			//echo "<br>";
			
			$html .= $cargo['nome_cargo'];
			$html .= '</li>';
			
			if(isset($cargo['subordinados']) && count($cargo['subordinados']))
			{
				$html .= exibe($cargo['subordinados']);
			}
			
			
		}
				
		$html .= '</ul>';
		
		return $html;
		
	}
	
	echo exibe($hierarquia);

?>