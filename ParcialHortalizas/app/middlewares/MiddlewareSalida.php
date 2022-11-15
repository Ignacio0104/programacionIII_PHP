<?php
use Dotenv\Loader\Resolver;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

require_once './models/Usuario.php';


class MiddlewareSalida{
    public function __invoke(Request $request,RequestHandler $handler) : Response
    {
      $header = $request->getHeaderLine(("Authorization"));
      $token = trim(explode("Bearer",$header)[1]);
      $datos = json_decode(file_get_contents("php://input"), true);
      $idHortaliza = $datos['id'];
       try {
          $data = AutentificadorJWT::ObtenerData($token);
          $usuarioAuxiliar = Usuario::obtenerUsuario($data->usuario); 
          $response = $handler->handle($request);
          $texto = (string)$response->getBody();
          if(isset(json_decode($texto, true)["Error!"]))
          {
            $response->getBody()->write(json_encode(array('Error' => "No se va a realizar registro en la tabla logs")));
          }else{
              if($this->guardarInformacionLog($usuarioAuxiliar->id,$idHortaliza)>0){
                $response->getBody()->write(json_encode(array('Exito' => "Log actualizado!")));
              }else{
                $response->getBody()->write(json_encode(array('Error!' => "No se pudo guardar log en base de datos")));
              }
          }
      } catch (Exception $e) {
        $response->getBody()->write(json_encode(array('Error' => $e->getMessage())));
        $response = $response->withStatus(401);
      }
      return $response
        ->withHeader('Content-Type', 'application/json');
    }


    public static function guardarInformacionLog($idUsuario,$idHortaliza)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("INSERT INTO logs (id_usuario,id_hortaliza,accion,fecha_accion)
        VALUES (:id_usuario,:id_Hortaliza,:accion,:fecha_accion)");
        $fecha = date("Y-m-d");
        $consulta->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
        $consulta->bindValue(':id_Hortaliza', $idHortaliza, PDO::PARAM_INT);
        $consulta->bindValue(':accion', "Borrado de hortaliza", PDO::PARAM_STR);
        $consulta->bindValue(':fecha_accion', $fecha);
        $consulta->execute();
        return $consulta->rowCount();
    }

 
}
?>