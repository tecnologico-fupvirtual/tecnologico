<?php 
  session_start();
  include 'utiles.php';
  $action = $_POST['action'];
  if (trim($action) == '')
      $action = $_GET['action'];
  switch($action)
  {
//**************************************LOGIN*******************************************
      case 1:
        valida_usuario($_POST['username'], $_POST['password']);
        security();
        header('Location:../escritorio');
        break;
      case 2:
        session_start();
        session_unset();
        session_destroy();
        header('Location:../');
        break;
      case 3:  
        $id = $_POST['id'];  
        actualizar_contrasenia($id, $_POST['nueva']);
        header('Location:../inicio.php');
        break;          
      case 4: 
        $var = get_usuario_restaurar($_POST['identificacion'],$_POST['correo']);
        if(isset($var)){
          $nuevopasw = substr(str_shuffle("0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKMNOPQRSTUVWXYZ"), 0, 8);
          actualizar_contrasenia($var,$nuevopasw);
          enviarEmailSMTP($_POST['correo'],$nuevopasw);
          header('Location:../index.php?adv=1');          
        }
        else {
          header('Location:../olvidoContrasenia.php?adv=1');
        }

        break;
//************************************ESTADO *****************************************************            
      case 5: 
        new_estado($_POST['nombre']);
        header("Location:../estado.php");
        break;
      case 6:
        $id = $_GET['id'];  
        header("Location:../editarEstado.php?id=$id");
        break; 
      case 7:  
        $id = $_GET['id']; 
        borrar_estado($id);            
        header('Location:../estado.php');
        break;
      case 8:
        $id = $_POST['id'];  
        actualizar_estado($id, $_POST['nombre']);     
        header("Location:../estado.php");
        break;
//****************************************CLASIFICACION*******************************************            
      case 9: 
        new_clasificacion($_POST['nombre']);
        header("Location:../clasificacion.php");
        break;
      case 10:
        $id = $_GET['id'];  
        header("Location:../editarClasificacion.php?id=$id");
        break; 
      case 11:  
        $id = $_GET['id']; 
        borrar_clasificacion($id);            
        header('Location:../clasificacion.php');
        break;
      case 12:
        $id = $_POST['id'];  
        actualizar_clasificacion($id, $_POST['nombre']);     
        header("Location:../clasificacion.php");
        break;
//************************************TIPO DE LIBRO*********************************************            
      case 13: 
        new_tipo($_POST['nombre'],$_POST['clasificacion']);
        header("Location:../tipo.php");
        break;
      case 14:
        $id = $_GET['id'];  
        header("Location:../editarTipo.php?id=$id");
        break; 
      case 15:  
        $id = $_GET['id']; 
        borrar_tipo($id);            
        header('Location:../tipo.php');
        break;
      case 16:
        $id = $_POST['id'];  
        actualizar_tipo($id, $_POST['nombre'],$_POST['clasificacion']);     
        header("Location:../tipo.php");
        break;
//****************************************LIBRO********************************************
      case 17:  
        new_libro($_POST['tipo'],$_POST['titulo'],$_POST['autor'],$_POST['sigtop1'],$_POST['sigtop2'],$_POST['costo'],$_POST['estado'],$_POST['tomo']);
        header("Location:../libro.php");
        break;
      case 18:
        $id = $_GET['id'];  
        header("Location:../editarLibro.php?id=$id");
        break; 
      case 19:  
        $id = $_GET['id']; 
        borrar_libro($id);            
        header('Location:../libro.php');
        break;
      case 20:
        $id = $_POST['id'];  
        actualizar_libro($id, $_POST['nombre'],$_POST['clasificacion']);     
        header("Location:../libro.php");
        break;
      case 21:
        $id = $_GET['id']; 
        header("Location:../verLibro.php?id=$id");
        break;

//**********************************TIPO DE IDENTIFICACION***********************************            
      case 29:  
        new_tipo_identificacion($_POST['codigo'], $_POST['nombre']);
        header("Location:../tipoIdentificacion.php");
        break;
      case 30:
        $id = $_GET['id'];  
        header("Location:../editarTipoIdentificacion.php?id=$id");
        break;      
      case 31:  
        $id = $_GET['id']; 
        borrar_tipo_identificacion($id);            
        header('Location:../tipo_identificacion.php');
        break;          
      case 32: 
        $id = $_POST['id'];  
        actualizar_tipo_identificacion($id, $_POST['codigo'], $_POST['nombre']);     
        header("Location:../tipoIdentificacion.php");
        break;  

//************************************USUARIO****************************************** 
      case 49:  
        new_usuario($_POST['tipoidentificacion'],$_POST['identificacion'], $_POST['nombrecompleto'], $_POST['correo'], $_POST['contrasenia'], $_POST['direccion'], $_POST['telefono'], $_POST['estado'], $_POST['tipousuario']);
        header("Location:../usuario.php");
        break;     
      case 50:
        $id = $_GET['id']; 
        header("Location:../editarUsuario.php?id=$id");
        break; 
      case 51:  
        $id = $_GET['id']; 
        borrar_usuario($id);            
        header('Location:../usuario.php');
        break;
      case 52:
        $id = $_POST['id'];
        actualizar_usuario($id, $_POST['tipoidentificacion'],$_POST['identificacion'], $_POST['nombrecompleto'], $_POST['correo'], $_POST['contrasenia'], $_POST['direccion'], $_POST['telefono'], $_POST['estado'], $_POST['tipousuario']);     
        header("Location:../usuario.php");
        break; 
      case 53:
        $id = $_GET['id']; 
        header("Location:../verUsuario.php?id=$id");
        break;   

    
  }
?>
