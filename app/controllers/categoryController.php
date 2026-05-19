<?php

	namespace app\controllers;
	use app\models\mainModel;

	class categoryController extends mainModel{

		
		public function registrarCategoriaControlador(){

			
		    $nombre=$this->limpiarCadena($_POST['categoria_nombre']);
		    $ubicacion=$this->limpiarCadena($_POST['categoria_ubicacion']);

		    
            if($nombre==""){
            	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            
		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($ubicacion!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$ubicacion)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La UBICACION no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    
		    $check_nombre=$this->consultaSegura("SELECT categoria_nombre FROM categoria WHERE categoria_nombre=:Nombre", [":Nombre"=>$nombre]);
		    if($check_nombre->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }


		    $categoria_datos_reg=[
				[
					"campo_nombre"=>"categoria_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"categoria_ubicacion",
					"campo_marcador"=>":Ubicacion",
					"campo_valor"=>$ubicacion
				]
			];

			$registrar_categoria=$this->guardarDatos("categoria",$categoria_datos_reg);

			if($registrar_categoria->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Categoría registrada",
					"texto"=>"La categoría ".$nombre." se registro con exito",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar la categoría, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}


		
		public function listarCategoriaControlador($pagina,$registros,$url,$busqueda){

			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);

			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT * FROM categoria WHERE categoria_nombre LIKE :Busqueda OR categoria_ubicacion LIKE :Busqueda ORDER BY categoria_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(categoria_id) FROM categoria WHERE categoria_nombre LIKE :Busqueda OR categoria_ubicacion LIKE :Busqueda";

				$datos = $this->consultaSegura($consulta_datos, [":Busqueda"=>"%$busqueda%"]);
				$total = $this->consultaSegura($consulta_total, [":Busqueda"=>"%$busqueda%"]);

			}else{

				$consulta_datos="SELECT * FROM categoria ORDER BY categoria_nombre ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(categoria_id) FROM categoria";

				$datos = $this->ejecutarConsulta($consulta_datos);
				$total = $this->ejecutarConsulta($consulta_total);

			}

			$datos = $datos->fetchAll();

			$total = (int) $total->fetchColumn();

			$numeroPaginas =ceil($total/$registros);

			$tabla.='
		        <div class="table-container">
		        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		            <thead>
		                <tr>
		                    <th class="has-text-centered">#</th>
		                    <th class="has-text-centered">Nombre</th>
		                    <th class="has-text-centered">Ubicacion</th>
		                    <th class="has-text-centered">Productos</th>
		                    <th class="has-text-centered">Actualizar</th>
		                    <th class="has-text-centered">Eliminar</th>
		                </tr>
		            </thead>
		            <tbody>
		    ';

		    if($total>=1 && $pagina<=$numeroPaginas){
				$contador=$inicio+1;
				$pag_inicio=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
						<tr class="has-text-centered" >
							<td>'.$contador.'</td>
							<td>'.$rows['categoria_nombre'].'</td>
							<td>'.$rows['categoria_ubicacion'].'</td>
							<td>
			                    <a href="'.APP_URL.'productCategory/'.$rows['categoria_id'].'/" class="button is-info is-rounded is-small">
			                    	<i class="ri-inbox-line"></i>
			                    </a>
			                </td>
			                <td>
			                    <a href="'.APP_URL.'categoryUpdate/'.$rows['categoria_id'].'/" class="button is-success is-rounded is-small">
			                    	<i class="ri-refresh-line"></i>
			                    </a>
			                </td>
			                <td>
			                	<form class="FormularioAjax" action="'.APP_URL.'app/ajax/categoriaAjax.php" method="POST" autocomplete="off" >

			                		<input type="hidden" name="modulo_categoria" value="eliminar">
			                		<input type="hidden" name="categoria_id" value="'.$rows['categoria_id'].'">

			                    	<button type="submit" class="button is-danger is-rounded is-small">
			                    		<i class="ri-delete-bin-line"></i>
			                    	</button>
			                    </form>
			                </td>
						</tr>
					';
					$contador++;
				}
				$pag_final=$contador-1;
			}else{
				if($total>=1){
					$tabla.='
						<tr class="has-text-centered" >
			                <td colspan="6">
			                    <a href="'.$url.'1/" class="button is-link is-rounded is-small mt-4 mb-4">
			                        Haga clic acá para recargar el listado
			                    </a>
			                </td>
			            </tr>
					';
				}else{
					$tabla.='
						<tr class="has-text-centered" >
			                <td colspan="6">
			                    No hay registros en el sistema
			                </td>
			            </tr>
					';
				}
			}

			$tabla.='</tbody></table></div>';

			
			if($total>0 && $pagina<=$numeroPaginas){
				$tabla.='<p class="has-text-right">Mostrando categorías <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';

				$tabla.=$this->paginadorTablas($pagina,$numeroPaginas,$url,7);
			}

			return $tabla;
		}


		
		public function eliminarCategoriaControlador(){

			$id=$this->limpiarCadena($_POST['categoria_id']);

			
		    $datos=$this->consultaSegura("SELECT * FROM categoria WHERE categoria_id=:ID", [":ID"=>$id]);
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la categoría en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    
		    $check_productos=$this->consultaSegura("SELECT categoria_id FROM producto WHERE categoria_id=:ID LIMIT 1", [":ID"=>$id]);
		    if($check_productos->rowCount()>0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar la categoría del sistema ya que tiene productos asociados",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $eliminarCategoria=$this->eliminarRegistro("categoria","categoria_id",$id);

		    if($eliminarCategoria->rowCount()==1){

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Categoría eliminada",
					"texto"=>"La categoría ".$datos['categoria_nombre']." ha sido eliminada del sistema correctamente",
					"icono"=>"success"
				];

		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar la categoría ".$datos['categoria_nombre']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}


		
		public function actualizarCategoriaControlador(){

			$id=$this->limpiarCadena($_POST['categoria_id']);

			
		    $datos=$this->consultaSegura("SELECT * FROM categoria WHERE categoria_id=:ID", [":ID"=>$id]);
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la categoría en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    
		    $nombre=$this->limpiarCadena($_POST['categoria_nombre']);
		    $ubicacion=$this->limpiarCadena($_POST['categoria_ubicacion']);

		    
            if($nombre==""){
            	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
            }

            
		    if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El NOMBRE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($ubicacion!=""){
		    	if($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$ubicacion)){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La UBICACION no coincide con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }

		    
		    if($datos['categoria_nombre']!=$nombre){
			    $check_nombre=$this->consultaSegura("SELECT categoria_nombre FROM categoria WHERE categoria_nombre=:Nombre", [":Nombre"=>$nombre]);
			    if($check_nombre->rowCount()>0){
			    	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El NOMBRE ingresado ya se encuentra registrado, por favor elija otro",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
		    }


		    $categoria_datos_up=[
				[
					"campo_nombre"=>"categoria_nombre",
					"campo_marcador"=>":Nombre",
					"campo_valor"=>$nombre
				],
				[
					"campo_nombre"=>"categoria_ubicacion",
					"campo_marcador"=>":Ubicacion",
					"campo_valor"=>$ubicacion
				]
			];

			$condicion=[
				"condicion_campo"=>"categoria_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("categoria",$categoria_datos_up,$condicion)){
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Categoría actualizada",
					"texto"=>"Los datos de la categoría ".$datos['categoria_nombre']." se actualizaron correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los datos de la categoría ".$datos['categoria_nombre'].", por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}

	}
