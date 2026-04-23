<?php 



//************************************************************ 

  function getbase()

  { 

    

    include('adodb/adodb.inc.php');  // La libreria AdoDB que permite acceder a la base de datos

    $url = $_SERVER['PHP_SELF'];

    

    if (stripos($url, '/scripts/') == false)  // La ubicación de config depende de quien carge a utiles.php

      include('scripts/config.php');          

    else

      include('config.php'); // Servidor donde se encuentra la base de datos, puede ser cualquier ip o dominio enrutable

                          // login, password y base de datos para conectarse 

    $db = ADONewConnection('mysqli');   // Se crea el objeto para conectar con la base de datos, como parámetro se usa el driver (mysql)

     // $db->debug = true;              // con $db->debug = true nos permite ver información detallada sobre los procesos realizados

    

    $db->Connect($server, $user, $password, $database);   // Se conecta con el servidor, observe que puede conectarse con multiples servidores al mismo tiempo

   

    return($db);

  }

//************************************************************ 

//************************************************************ 

  function genera_combo($tabla, $campos, $seleccionado = -1, $extra='')

  {

    $db = getbase();

    $sql = "select $campos from $tabla ".$extra;

    $rs = $db->Execute($sql);

    $cad = '';

    while (!$rs->EOF)

    {

      if ($rs->fields[0] == $seleccionado)

        $cad.='<option value="'.$rs->fields[0]. '" selected>'.$rs->fields[1]."</option>\n"; 

      else  

        $cad.='<option value="'.$rs->fields[0]. '">'.$rs->fields[1]."</option>\n";

      $rs->MoveNext();

    }

    return $cad; 

  }

//************************************************************

//************************************************************

  function celda($str)

  {

    return("<td>$str</td>");

  }

//************************************************************

//************************************************************

  function get_ultimo($campo,$tabla)

  {

    $db = getbase();   

    $sql= "select max($campo) as id from $tabla" ;

    

  }

//************************************************************

//************************************************************

  function get_cantidad($tabla,$condicion='')

  {

    $db = getbase();   

    $sql= "select count(*) as cantidad from $tabla ".$condicion ;

    $rs = $db->Execute($sql);

    if ($rs)  

      return $rs->fields[0];  

    else

      die('Registro no encontrado...'); 

  }

//************************************************************

//************************************************************

//************************************************************

  function get_cantidad_pqr()

  {

    $db = getbase();   

    $sql="SELECT count(*) as total,(select count(*) FROM `corrective_preventive_actions` where current_status=0 and  publish = 1) as abiertos,(select count(*) FROM `corrective_preventive_actions` where current_status=1 and  publish = 1) as cerrados FROM `corrective_preventive_actions` where  publish = 1 ";

    $rs = $db->Execute($sql);

    if ($rs)  

      return($rs->FetchRow());  

    else

      die('Registro no encontrado...'); 

  }

//************************************************************

  

//************************************************************  

//************************PROCESOS****************************

//************************************************************

  function admin_proceso($cond='')

  {

    $tr="<tr>"; $tre='</tr>';

    $db = getbase();

    $sql = "SELECT departments.id,departments.name,departments.clauses, departments.publish from departments ".$cond." order by departments.sr_no asc" ;

    $rs = $db->Execute($sql);

    while (!$rs->EOF)    

    {

      echo $tr;

      for($i=1;$i<$rs->FieldCount();$i++)  

      {

        if ($i==3) {

          if (($rs->fields[$i])==1) {

            echo celda('<i class="fa fa-check"></i>'); 

          } else{

            echo celda('<i class="fa fa-ban"></i>'); 

          }

        } else {

          echo celda($rs->fields[$i]); 

        }              

      } 

      $id=$rs->fields[0] ; 

      echo celda("<a href=\"scripts/admin.php?action=21&id=$id\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Ver\"><img src=\"plugins/images/icons/view.png\"></a>

                  <a href=\"scripts/admin.php?action=18&id=$id\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar\"><img src=\"plugins/images/icons//edit.png\"></a>

                  <a href=\"scripts/admin.php?action=19&id=$id\"  data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Eliminar\"><img src=\"plugins/images/icons//trash.png\"></a>

                  <a href=\"scripts/admin.php?action=19&id=$id\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Publicar\"><img src=\"plugins/images/icons//list.png\"></a>");

      

      $rs->MoveNext();     

                                                    

      echo $tre;                                                          

    }

  }

//************************************************************

//************************************************************

  function new_libro($tipo,$titulo,$autor,$sigtop1,$sigtop2,$costo,$estado,$tomo,$usuario)

  {

    $sql ="INSERT INTO libro(lib_tipo, lib_titulo, lib_autor, lib_sigtop1, lib_sigtop2, lib_costo, lib_estado, lib_tomo,lib_fecha_registro)";

    $sql.="VALUES ('$tipo','$titulo','$autor','$sigtop1','$sigtop2','$costo','$estado','$tomo',now())";

    

    $db = getbase();

    $rs = $db->Execute($sql);

  }

//************************************************************

//************************************************************

  function borrar_libro($id)

  {

    $sql ="DELETE FROM libro WHERE lib_id = $id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************

//************************************************************

  function get_registro_libro($id)

  {

    $db = getbase();   

    $sql="SELECT * from libro inner join tipo on (lib_tipo = tip_id) inner join clasificacion on (tip_clasificacion = cla_id) inner join estado on (lib_estado = est_id) where lib_id = '$id'" ;

    $rs = $db->Execute($sql);

    if ($rs)  

      return($rs->FetchRow());  

    else

      die('Registro no encontrado...'); 

  }

//************************************************************

//************************************************************

  function actualizar_libro($id,$codigo, $nombre, $aprendizaje, $porcentaje, $introduccion, $curso)    

  {

    $sql ="UPDATE modulos SET ";

    $sql.="mod_codigo ='$codigo', ";

    $sql.="mod_nombre ='$nombre', ";

    $sql.="mod_aprendizaje ='$aprendizaje', ";

    $sql.="mod_porcentaje ='$porcentaje', ";

    $sql.="mod_introduccion ='$introduccion', ";

    $sql.="mod_idcurso ='$curso' ";

    $sql.="WHERE mod_id=$id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }



//************************************************************  

//*************************CARGO ****************************

//************************************************************

  function admin_cargo($cond='')

  {

    $tr="<tr>"; $tre='</tr>';

    $db = getbase();

    $sql = "SELECT designations.id,designations.name, designations.publish from designations ".$cond." order by designations.sr_no asc" ;

    $rs = $db->Execute($sql);

    while (!$rs->EOF)    

    {

      echo $tr;

      for($i=1;$i<$rs->FieldCount();$i++)  

      {

        if ($i==2) {

          if (($rs->fields[$i])==1) {

            echo celda('<i class="fa fa-check"></i>'); 

          } else{

            echo celda('<i class="fa fa-ban"></i>'); 

          }

        } else {

          echo celda($rs->fields[$i]); 

        }              

      } 

      $id=$rs->fields[0] ; 

      echo celda("<a href=\"scripts/admin.php?action=21&id=$id\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Ver\"><img src=\"plugins/images/icons/view.png\"></a>

                  <a href=\"scripts/admin.php?action=18&id=$id\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Editar\"><img src=\"plugins/images/icons//edit.png\"></a>

                  <a href=\"scripts/admin.php?action=19&id=$id\"  data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Eliminar\"><img src=\"plugins/images/icons//trash.png\"></a>

                  <a href=\"scripts/admin.php?action=19&id=$id\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"Publicar\"><img src=\"plugins/images/icons//list.png\"></a>");

      

      $rs->MoveNext();     

                                                    

      echo $tre;                                                          

    }

  }

//************************************************************

//************************************************************

  function new_estado($nombre)

  {

    $sql ="INSERT INTO estado(est_nombre)";

    $sql.="VALUES ('$nombre')";

    $db = getbase();

    $rs = $db->Execute($sql);

  }

//************************************************************

//************************************************************

  function borrar_estado($id)

  {

    $sql ="DELETE FROM estado WHERE est_id = $id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************

//************************************************************

  function get_registro_estado($id)

  {

    $db = getbase();   

    $sql="SELECT est_id, est_nombre from estado where est_id = '$id'" ;

    $rs = $db->Execute($sql);

    if ($rs)  

      return($rs->FetchRow());  

    else

      die('Registro no encontrado...'); 

  }

//************************************************************

//************************************************************

  function actualizar_estado($id, $nombre)    

  {

    $sql ="UPDATE estado SET ";

    $sql.="est_nombre ='$nombre'";

    $sql.="WHERE est_id=$id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************  

//***********************CLASIFICACION************************

//************************************************************

  function admin_clasificacion()

  {

    $tr="<tr>"; $tre='</tr>';

    $tb="<tbody>"; $tbe='</tbody>';

    $db = getbase();

    $sql = "SELECT cla_id, cla_nombre from clasificacion order by cla_id" ;

    $rs = $db->Execute($sql);

    echo $tb;

    while (!$rs->EOF)    

    {

      echo $tr;

      for($i=1;$i<$rs->FieldCount();$i++)  

      {

        echo celda($rs->fields[$i]);       

      } 

      $id=$rs->fields[0] ; 

      /*echo celda("<a href=\"scripts/admin.php?action=10&id=$id\" class=\"btn btn-success\" title=\"Editar\">Editar</a>

                  <a href=\"scripts/admin.php?action=11&id=$id\" class=\"btn btn-danger\" title=\"Eliminar\" onclick=\"return confirm('Deseas realmente eliminar?')\">Eliminar</a>");*/

      echo celda("<a href=\"scripts/admin.php?action=10&id=$id\" class=\"btn btn-success\" title=\"Editar\">Editar</a>");

      $rs->MoveNext();                                                    

      echo $tre;                                                          

    }

    echo $tbe;

  }

//************************************************************

//************************************************************

  function new_clasificacion($nombre)

  {

    $sql ="INSERT INTO clasificacion(cla_nombre)";

    $sql.="VALUES ('$nombre')";

    $db = getbase();

    $rs = $db->Execute($sql);

  }

//************************************************************

//************************************************************

  function borrar_clasificacion($id)

  {

    $sql ="DELETE FROM clasificacion WHERE cla_id = $id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************

//************************************************************

  function get_registro_clasificacion($id)

  {

    $db = getbase();   

    $sql="SELECT cla_id, cla_nombre from clasificacion where cla_id = '$id'" ;

    $rs = $db->Execute($sql);

    if ($rs)  

      return($rs->FetchRow());  

    else

      die('Registro no encontrado...'); 

  }

//************************************************************

//************************************************************

  function actualizar_clasificacion($id, $nombre)    

  {

    $sql ="UPDATE clasificacion SET ";

    $sql.="cla_nombre ='$nombre'";

    $sql.="WHERE cla_id=$id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************ 

//************************************************************

  function get_clasificacion()

  {

    $db = getbase();   

    $sql="SELECT cla_id, cla_nombre, COUNT(lib_id) from libro inner join tipo on (lib_tipo = tip_id) inner join clasificacion on (tip_clasificacion = cla_id) group by cla_id, cla_nombre ORDER BY cla_id" ;

    $rs = $db->Execute($sql);

    $j=0;

    $datos = array();

    while(!$rs->EOF){



      $datos[$j][0]=$rs->fields[0];

      $datos[$j][1]=$rs->fields[1];

      $datos[$j][2]=$rs->fields[2];

      $j=$j+1;

      $rs->MoveNext();

    }

    return $datos; 

  }

//************************************************************ 

//************************************************************

  function get_datos_clasificacion()

  {

    $db = getbase();   

    $sql="SELECT cla_nombre, COUNT(lib_id) from libro inner join tipo on (lib_tipo = tip_id) inner join clasificacion on (tip_clasificacion = cla_id) group by cla_id, cla_nombre ORDER BY cla_id" ;

    $rs = $db->Execute($sql);

    $json = array();

    $json[] = array('Libros', 'Cantidad');

    while(!$rs->EOF)

    {

      $json[] = array($rs->fields[0], intval($rs->fields[1]));

      $rs->MoveNext(); 

    }

    return($json);

  }

//************************************************************

//*******************TIPO DE IDENTIFICACION*******************

//************************************************************

 function admin_tipo_identificacion()

  {

    $tr="<tr>"; $tre='</tr>';

    $tb="<tbody>"; $tbe='</tbody>';

    $db = getbase();

    $sql = "SELECT ti_id, ti_codigo, ti_nombre from tipo_identificacion" ;

    $rs = $db->Execute($sql);

    echo $tb;

    while (!$rs->EOF)    

    {

      echo $tr;

      for($i=1;$i<$rs->FieldCount();$i++)  

      {

        echo celda($rs->fields[$i]);       

      } 

      $id=$rs->fields[0] ; 

      echo celda("<a href=\"scripts/admin.php?action=30&id=$id\" class=\"btn btn-success\" title=\"Editar\">Editar</a>

                  <a href=\"scripts/admin.php?action=31&id=$id\" class=\"btn btn-danger\" title=\"Eliminar\" onclick=\"return confirm('Deseas realmente eliminar?')\">Eliminar</a>");



      $rs->MoveNext();                                                    

      echo $tre;                                                          

    }

    echo $tbe;

  }

//************************************************************

//************************************************************

  function new_tipo_identificacion($codigo, $nombre)

  {

    $sql ="INSERT INTO tipo_identificacion(ti_codigo, ti_nombre)";

    $sql.="VALUES ('$codigo', '$nombre')";

    $db = getbase();

    $rs = $db->Execute($sql);

  }

//************************************************************

//************************************************************

  function borrar_tipo_identificacion($id)

  {

    $sql ="DELETE FROM tipo_identificacion WHERE ti_id = $id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************

//************************************************************

  function get_registro_tipo_identificacion($id)

  {

    $db = getbase();   

    $sql="SELECT ti_id, ti_codigo, ti_nombre from tipo_identificacion where ti_id = '$id'" ;

    $rs = $db->Execute($sql);

    if ($rs)  

      return($rs->FetchRow());  

    else

      die('Registro no encontrado...'); 

  }

//************************************************************

//************************************************************

  function actualizar_tipo_identificacion($id, $codigo, $nombre)    

  {

    $sql ="UPDATE tipo_identificacion SET ";

    $sql.="ti_codigo='$codigo', ti_nombre='$nombre' ";

    $sql.="WHERE ti_id=$id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************

//**********************TIPO********************************

//************************************************************

  function admin_tipo()

  {

    $tr="<tr>"; $tre='</tr>';

    $tb="<tbody>"; $tbe='</tbody>';

    $db = getbase();

    $sql = "SELECT tip_id, tip_nombre, cla_nombre from tipo " ;

    $sql.="inner join clasificacion on (tip_clasificacion = cla_id) ";

    $rs = $db->Execute($sql);

    echo $tb;

    while (!$rs->EOF)    

    {

      echo $tr;

      for($i=1;$i<$rs->FieldCount();$i++)  

      {

        echo celda($rs->fields[$i]);       

      } 

      $id=$rs->fields[0] ; 

      echo celda("<a href=\"scripts/admin.php?action=14&id=$id\" class=\"btn btn-success\" title=\"Editar\">Editar</a>

                  <a href=\"scripts/admin.php?action=15&id=$id\" class=\"btn btn-danger\" title=\"Eliminar\" onclick=\"return confirm('Deseas realmente eliminar?')\">Eliminar</a>");

      $rs->MoveNext();                                                    

      echo $tre;                                                          

    }

    echo $tbe;

  }

//************************************************************

//************************************************************

  function new_tipo($nombre, $clasificacion)

  {

    $sql ="INSERT INTO tipo(tip_nombre, tip_clasificacion)";

    $sql.="VALUES ('$nombre', '$clasificacion')";

    $db = getbase();

    $rs = $db->Execute($sql);

  }

//************************************************************

//************************************************************

  function borrar_tipo($id)

  {

    $sql ="DELETE FROM tipo WHERE tip_id = $id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************

//************************************************************

  function get_registro_tipo($id)

  {

    $db = getbase();   

    $sql="SELECT tip_id, tip_nombre, tip_clasificacion from tipo where tip_id = '$id'" ;

    $rs = $db->Execute($sql);

    if ($rs)  

      return($rs->FetchRow());  

    else

      die('Registro no encontrado...'); 

  }

//************************************************************

//************************************************************

  function actualizar_tipo($id, $nombre, $clasificacion)    

  {

    $sql ="UPDATE tipo SET ";

    $sql.="tip_nombre ='$nombre', ";

    $sql.="tip_clasificacion ='$clasificacion'";

    $sql.="WHERE tip_id=$id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************ 

//************************************************************

  function get_tipo($clasificacion)

  {

    $db = getbase();   

    $sql="SELECT tip_id, tip_nombre, COUNT(lib_id) from libro inner join tipo on (lib_tipo = tip_id) inner join clasificacion on (tip_clasificacion = cla_id) where tip_clasificacion = '$clasificacion' group by tip_id, tip_nombre ORDER BY tip_id" ;

    $rs = $db->Execute($sql);

    while(!$rs->EOF){

      $id=$rs->fields[0] ; 

      echo "<a href=\"libro.php?tipo=$id\" class=\"list-group-item\"><span class=\"badge\">".$rs->fields[2]."</span>".$rs->fields[1]."</a>";

      $rs->MoveNext();

    }

  }

//************************************************************ 

//************************************************************

  function get_registro_perfil($id)

  {

    $db = getbase();   

    $sql="SELECT usu_id, usu_ti, usu_identificacion, usu_nombre_completo, usu_correo, usu_direccion, usu_telefono, usu_tu, usu_fregistro, usu_estado, ti_codigo, tu_nombre, usu_contrasenia from usuario inner join tipo_identificacion on (ti_id = usu_ti) inner join tipo_usuario on (tu_id = usu_tu) where usu_id = '$id'" ;

    $rs = $db->Execute($sql);

    if ($rs)  

      return($rs->FetchRow());  

    else

      die('Registro no encontrado...'); 

  }

//************************************************************

//************************************************************

  function actualizar_contrasenia($id, $contrasenia)    

  {

    $sql ="UPDATE usuario SET ";

    $sql.="usu_contrasenia ='$contrasenia' ";

    $sql.="WHERE usu_id=$id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************

//************************************************************

  function get_usuario_restaurar($identificacion, $correo)

  {

    $db = getbase();   

    $sql="SELECT usu_id from usuario where usu_identificacion = '$identificacion' and usu_correo = '$correo'" ;

    $rs = $db->Execute($sql);

    if ($rs)  

      return ($rs->fields[0]);  

    else

      return 0; 

  }

//************************************************************

//***********************USUARIO******************************

//************************************************************

  function admin_usuario()

  {

    $tr="<tr>"; $tre='</tr>';

    $tb="<tbody>"; $tbe='</tbody>';

    $db = getbase();

    $sql = "SELECT usu_id, CONCAT(ti_codigo, ' ' ,usu_identificacion), usu_nombre_completo, usu_estado ";

    $sql.="from usuario inner join tipo_usuario on (usu_tu = tu_id) inner join tipo_identificacion on (usu_ti = ti_id)";

    $rs = $db->Execute($sql);

    echo $tb;

    while (!$rs->EOF)    

    {

      echo $tr;

      for($i=1;$i<$rs->FieldCount();$i++)  

      {

        if ($i<>3) {

          echo celda($rs->fields[$i]); 

        }

        else {

          if ($rs->fields[$i]=='T')

            echo celda('ACTIVO');

          else

            echo celda('INACTIVO'); 

        }

      } 

      $id=$rs->fields[0] ; 

      echo celda("<a href=\"scripts/admin.php?action=53&id=$id\" class=\"btn btn-info\" title=\"Ver\">Ver</a>

                  <a href=\"scripts/admin.php?action=50&id=$id\" class=\"btn btn-success\" title=\"Editar\">Editar</a>

                  <a href=\"scripts/admin.php?action=51&id=$id\" class=\"btn btn-danger\" title=\"Eliminar\" onclick=\"return confirm('Deseas realmente eliminar?')\">Eliminar</a>");

      $rs->MoveNext();                                                    

      echo $tre;                                                          

    }

    echo $tbe;

  }

//************************************************************

//************************************************************

  function new_usuario($tipoidentificacion,$identificacion, $nombrecompleto, $correo, $contrasenia, $direccion, $telefono, $estado, $tipousuario)

  {

    $sql ="INSERT INTO usuario(usu_ti, usu_identificacion, usu_nombre_completo, usu_correo, usu_contrasenia, ";

    $sql.="usu_direccion, usu_telefono, usu_estado, usu_tu, usu_fregistro)";

    $sql.="VALUES ('$tipoidentificacion','$identificacion', '$nombrecompleto', '$correo', '$contrasenia', '$direccion', '$telefono', '$estado', '$tipousuario', now())";

    $db = getbase();

    $rs = $db->Execute($sql);

    //echo $sql;

  }

//************************************************************

//************************************************************

  function borrar_usuario($id)

  {

    $sql ="DELETE FROM usuario WHERE usu_id = $id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************

//************************************************************

  function get_registro_usuario($id)

  {

    $db = getbase();   

    $sql="SELECT usu_id, usu_ti, usu_identificacion, usu_nombre_completo, usu_correo, usu_contrasenia, ";

    $sql.="usu_direccion, usu_telefono, usu_estado, usu_tu, usu_fregistro, ti_codigo, tu_nombre ";

    $sql.="from usuario inner join tipo_identificacion on (usu_ti = ti_id) ";

    $sql.= "inner join tipo_usuario on (usu_tu = tu_id) WHERE usu_id = $id";

    $rs = $db->Execute($sql);

    if ($rs)  

      return($rs->FetchRow());  

    else

      die('Registro no encontrado...'); 

  }

//************************************************************

//************************************************************

  function actualizar_usuario($id, $tipoidentificacion,$identificacion, $nombrecompleto, $correo, $contrasenia, $direccion, $telefono, $estado, $tipousuario)    

  {

    $sql = "UPDATE usuario SET ";

    $sql.="usu_ti='$tipoidentificacion',usu_identificacion='$identificacion',usu_nombre_completo='$nombrecompleto',usu_correo='$correo',";

    $sql.="usu_contrasenia='$contrasenia',usu_direccion='$direccion',usu_telefono='$telefono',usu_estado='$estado', usu_tu='$tipousuario' ";

    $sql.="WHERE usu_id=$id";

    $db = getbase();

    //echo $sql;

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************

//************************************************************

  function borrar_persona($id)

  {

    $sql ="DELETE FROM persona WHERE per_id = $id";

    $db = getbase();

    $rs = $db->Execute($sql);

    return($rs);

  }

//************************************************************

//************************************************************

function enviarEmailSMTP($correo,$contrasenia)

{  

   require '../mailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;



    $mail->SMTPDebug = false;                               // Enable verbose debug output



    $mail->isSMTP();                                      // Set mailer to use SMTP

    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers

    $mail->SMTPAuth = true;                               // Enable SMTP authentication

    $mail->Username = 'mauricio.realpe@unividafup.edu.co';                 // SMTP username

    $mail->Password = 'Realpe-811205';                           // SMTP password

    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted

    $mail->Port = 465;                                    // TCP port to connect to



    $mail->From = 'webcalidad@fup.edu.co';

    $mail->FromName = 'Calidad FUP';

    $mail->addAddress('maurixio5540@gmail.com', 'Usuario');     // Add a recipient

    $mail->addAddress($correo, 'Usuario');     // Add a recipient

    $mail->isHTML(true);                                  // Set email format to HTML



    $mail->Subject = 'Restauración de contraseña';

    $mail->Body    = "<html>

    <head>

        <style>

            body {

                font-family: Arial;

                font-size: 13px;

                padding: 20px 10px;

                width: 780px;

                line-height: 20px;

                background: #cdcdcd;

            }

        </style>

    </head>

    <body>

        <div style=\"background:#005CA9;margin:0px; float:left; padding:5px 20px; color:#fff; width:820px; text-shadow:0px 0px 1px #000000; line-height:19px\">

             <h2>BIBLIOTECA</h2>

        </div>

        <div style=\"background:#FFFFFF;margin:0px; float:left; padding:5px 20px; color:#333333; width:820px\">



             <div>

                <table border=0>

                    <tr>

                        <td style=\"padding:10px\">

                            Apreciado usuario,<br/><br/>

                            

                            En respuesta a su solicitud, le enviamos su nueva contraseña de acceso al sistema CEDAM. 

                            <br /><br />

                            <strong>CONTRASEÑA: </strong>".$contrasenia."

                            <br /><br />

                            

                            <br />

                            <br />

                            Le agradecemos el buen uso de la herramienta.

                        </td>

                    </tr>

                </table>

            </div>



        </div>

        <div style=\"line-height:16px;background:#005CA9;margin:0 0 20px 0; float:left; padding:5px 20px; color:#fff; width:820px\">

             <span style=\"float:right\">

                Copyright &copy; 2016 </span> 

        </div>

    </body>

    </html>";

    

    if(!$mail->send()) {

      echo 'Message could not be sent.';

      echo 'Mailer Error: ' . $mail->ErrorInfo;

    } else {

      echo 'Message has been sent';

  } 

}

//************************************************************

//************************************************************

  function security()

  {

    if (!isset($_SESSION['id']))

      return 0;

  }

//************************************************************

//************************************************************

  function valida_usuario($log, $pass)

  {

    $db = getbase(); 

    $sql="SELECT users.id, users.username,users.name, users.is_mr, users.is_view_all, users.is_approvar, users.last_activity, users.branchid, users.departmentid,users.employee_id,users.administrador FROM users where (users.username = '$log') and (users.password = md5('$pass')) and (users.publish = 1) "; 

    

    $rs = $db->Execute($sql);

    if ($rs){

      $_SESSION['id'] = $rs->fields[0];

      $_SESSION['username'] = $rs->fields[1];

      $_SESSION['nombre'] = $rs->fields[2];

      $_SESSION['coordinador'] = $rs->fields[3];

      $_SESSION['administrador'] = $rs->fields[4];

      $_SESSION['aprobador'] = $rs->fields[5];

      $_SESSION['ultima_actividad'] = $rs->fields[6];
      $_SESSION['branch'] = $rs->fields[7];
      $_SESSION['department'] = $rs->fields[8];
      $_SESSION['empleado'] = $rs->fields[9];
      $_SESSION['super'] = $rs->fields[10];
    }

  }

//************************************************************

//************************************************************

  function analiza_logout($logout)

  {

    if ($logout==1)

      unset($_SESSION['id']);

  }

//************************************************************

//************************************************************

?>